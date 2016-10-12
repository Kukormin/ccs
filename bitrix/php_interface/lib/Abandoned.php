<?

namespace Local;
use Bitrix\Sale\Internals\BasketTable;

/**
 * Class Abandoned Брошенные корзины
 * @package Local\Package
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
		return '\Local\Abandoned::checkCartsAgent();';
	}

	/**
	 * Получает брошенные корзины пользователей
	 */
	public static function checkCarts()
	{
		\CModule::IncludeModule('sale');

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
					$users[$userId]['ITEMS'][$item['ID']] = $item['NAME'];
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
	 * Отправляет письмо пользователю
	 * @param $user
	 */
	private static function sendEmail($user)
	{
		if ($user['ID'] != 3938)
			return;

		$mes = '<ul>';
		foreach ($user['ITEMS'] as $item)
		{
			$mes .= '<li>' . $item . '</li>';
		}
		$mes .= '</ul>';

		// Создаем почтовое событие
		$eventFields = array(
			'USER_ID' => $user['ID'],
			'EMAIL' => $user['EMAIL'],
			'FIO' => trim($user['NAME'] . ' ' . $user['LAST_NAME']),
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

}