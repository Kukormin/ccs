<?

namespace Local\Utils;
use Bitrix\Sale\Internals\BasketTable;

/**
 * Class Abandoned Брошенные корзины
 * @package Local\Utils
 */
class Abandoned
{

	/**
	 * Функция-агент битрикса
	 * @return string
	 */
	public static function checkCartsAgent()
	{
		self::checkCarts();
		return '\Local\Utils\Abandoned::checkCartsAgent();';
	}

	/**
	 * Получает брошенные корзины пользователей
	 */
	public static function checkCarts()
	{
		\CModule::IncludeModule('sale');
		\CModule::IncludeModule('catalog');

		// Получаем связь пользователя с FUSER
		global $DB;
		$sql = 'SELECT ID, USER_ID FROM b_sale_fuser WHERE USER_ID <> 0';
		$rsFUsers = $DB->Query($sql);
		$userIdByFuser = array();
		while ($fuser = $rsFUsers->Fetch())
			$userIdByFuser[$fuser['ID']] = $fuser['USER_ID'];

		// Получаем для пользователей email и дату отправления прошлого письма
		$users = array();
		$rsUsers = \CUser::GetList($by, $desc, array(), array(
			'FIELDS' => array(
				'ID', 'EMAIL', 'NAME', 'LAST_NAME'
			),
			'SELECT' => array(
				'UF_ABANDONED_EMAIL',
			)
		));
		while ($user = $rsUsers->fetch())
		{
			$user['LAST'] = MakeTimeStamp($user['UF_ABANDONED_EMAIL']);
			$user['MAX'] = 0;
			$user['MIN'] = false;
			$user['ITEMS'] = array();
			$users[$user['ID']] = $user;
		}

		// Получаем все позиции корзины
		$basketIterator = BasketTable::getList(array(
			'filter' => array(
				'=ORDER_ID' => null,
			)
		));
		// Группируем по пользователю
		while ($item = $basketIterator->fetch()) {
			$userId = $userIdByFuser[$item['FUSER_ID']];
			if ($userId)
			{
				$user = $users[$userId];
				if ($user['EMAIL'])
				{
					/** @var $date \DateTime */
					$date = $item['DATE_UPDATE'];
					$ts = $date->getTimestamp();
					if ($ts > $user['MAX'])
						$users[$userId]['MAX'] = $ts;
					if ($user['MIN'] === false || $ts < $user['MIN'])
						$users[$userId]['MIN'] = $ts;
					$users[$userId]['ITEMS'][$item['ID']] = array(
						'NAME' => $item['NAME'],
						'PRICE' => $item['PRICE'],
						'QUANTITY' => $item['QUANTITY'],
						'URL' => $item['DETAIL_PAGE_URL'],
						'PRODUCT_ID' => $item['PRODUCT_ID'],
					);
				}
			}
		}

		// Получаем время, начиная с которого корзины считаются брошенными
		$options = self::getOptions();
		$tsX = time() - $options['hours'] * 3600;

		// Итоговые проверки
		foreach ($users as $user)
		{
			// Есть ли товары в корзине?
			if ($user['MAX'])
			{
				// Пора ли отправлять письмо?
				if ($user['MAX'] < $tsX)
				{
					// Еще не отправляли письмо по этой корзине?
					if ($user['MIN'] > $user['LAST'])
					{
						self::sendEmail($user);
					}
				}
			}
		}
	}

	/**
	 * Получает настройки
	 * @return array
	 */
	private static function getOptions()
	{
		return array(
			'hours' => \COption::GetOptionInt("grain.customsettings", "ABANDONED_HOURS", '24'),
		);
	}

	/**
	 * Генерирует хеш для авторизации из письма
	 * @return string
	 */
	private static function getHash()
	{
		return md5(md5(time()).uniqid());
	}

	/**
	 * Отправляет письмо пользователю
	 * @param $user
	 */
	private static function sendEmail($user)
	{
		$td = '<TD style="border-width: 1px; border-style: solid; border-color: #cccccc; border-left: none; border-right: none;">';
		$mes = '';
		$i = 0;
		$sum = 0;
		foreach ($user['ITEMS'] as $item)
		{
			$pic = '';
			$productInfo = \CCatalogSku::GetProductInfo($item['PRODUCT_ID']);
			if ($productInfo)
			{
				$rsProduct = \CIBlockElement::GetByID($productInfo['ID']);
				if ($product = $rsProduct->Fetch())
				{
					$pic = '<img style="max-width:135px;" alt="' . $item['NAME'] . '" src="http://cupcakestory.ru' .
						\CFile::GetPath($product['PREVIEW_PICTURE']) . '" />';
				}
			}
			$total = $item['PRICE'] * $item['QUANTITY'];
			$i++;
			$mes .= '<tr>';
			$mes .= $td . $i . '</TD>';
			$mes .= $td . $pic . '</TD>';
			$mes .= $td . $item['NAME'] . '</TD>';
			$mes .= $td . number_format($item['PRICE'], 0, ',', ' ') . ' Р</TD>';
			$mes .= $td . intval($item['QUANTITY']) . ' шт.</TD>';
			$mes .= $td . number_format($total, 0, ',', ' ') . ' Р</TD>';
			$mes .= '</tr>';
			$sum += $total;
		}
		$mes .= '<tr style="font-weight:bold;">';
		$mes .= '<td colspan="5" style = "border-width: 1px; border-style: solid; border-color: #cccccc; border-left: none; border-right: none;">Итого:</td>';
		$mes .= '<td style = "border-width: 1px; border-style: solid; border-color: #cccccc; border-left: none; border-right: none;">' . number_format($sum, 0, ',', ' ') . ' Р</td>';
		$mes .= '</tr>';

		// Генерируем и сохраняем хеш для авторизации пользователя из письма
		$hash = self::getHash();
		if ($user['ID'])
		{
			global $DB;
			$sql = 'UPDATE b_user SET STORED_HASH="' . $hash . '" WHERE ID=' . $user['ID'];
			$DB->Query($sql);
		}

		// Создаем почтовое событие
		$eventFields = array(
			'USER_ID' => $user['ID'],
			'EMAIL' => $user['EMAIL'],
			'FIO' => trim($user['NAME'] . ' ' . $user['LAST_NAME']),
			'TITLE' => 'Сupcake Story. Вы забыли у нас свои сладости',
			'HASH' => $hash,
			'MESSAGE' => $mes,
		);
		// Письмо пользователю
		$res = \CEvent::Send('ABANDONED_CART', 's1', $eventFields);
		if ($res)
		{
			$u = new \CUser;
			$u->Update($user['ID'], array('UF_ABANDONED_EMAIL' => ConvertTimeStamp(time(), 'FULL')));
		}
	}

	/**
	 * Авторизуем пользователя, если он пришел из письма
	 */
	public static function authorizeEmailUser()
	{
		if (strlen($_REQUEST['autohash']) > 0)
		{
			$u = new \CUser();
			if (!$u->IsAuthorized())
			{
				$hash = ($_REQUEST['autohash']);
				$uid = intval($_REQUEST['uid']);
				if ($uid)
				{
					$rsUser = $u->GetByID($uid);
					if ($user = $rsUser->Fetch())
					{
						if ($user['STORED_HASH'] == $hash)
						{
							global $DB;
							$sql = 'UPDATE b_user SET STORED_HASH="" WHERE ID=' . $user['ID'];
							$DB->Query($sql);
							$u->Authorize($user['ID']);
						}
					}
				}
			}
		}
	}

}