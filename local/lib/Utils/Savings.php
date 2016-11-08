<?

namespace Local\Utils;

/**
 * Class Savings Накопительные скидки
 * @package Local\Utils
 */
class Savings
{
	/**
	 * @var array Айдишники групп, соответствующие уровням скидки
	 */
	private static $levelByGroupId = array(
		9 => 1,
		10 => 2,
		11 => 3,
	);

	/**
	 * Функция-агент битрикса
	 * @return string
	 */
	public static function updateUserGroupsAgent()
	{
		self::updateUsers();
		return '\Local\Utils\Savings::updateUserGroupsAgent();';
	}

	/**
	 * Обновляет принадлежность пользователей к скидочным группам
	 */
	public static function updateUsers()
	{
		global $DB;
		\CModule::IncludeModule('sale');

		// Получаем настройки
		$options = self::getOptions();

		// Для всех скидочных групп получаем пользователей
		$users = array();
		foreach (self::$levelByGroupId as $groupId => $level)
		{
			foreach (\CGroup::GetGroupUser($groupId) as $userId)
			{
				$userId = intval($userId);
				$users[$userId]['LEVEL'] = $level;
			}
		}

		// Считаем дату "от"
		$from = AddToTimeStamp(array("MM" => -$options['months']), time());
		$fromFormatted = date($DB->DateFormatToPHP(\CSite::GetDateFormat("SHORT")), $from);

		// Получаем заказы и считаем суммы по пользователям
		$saleOrder = new \CSaleOrder();
		$rsOrders = $saleOrder->GetList(array(), array(
			'>=DATE_INSERT' => $fromFormatted,
			//'STATUS_ID' => 'F',
		));
		$byStatus = array();
		while ($order = $rsOrders->Fetch())
		{
			$byStatus[$order['STATUS_ID']]++;
			$userId = intval($order['USER_ID']);
			if (!isset($users[$userId]['SUM']))
				$users[$userId]['SUM'] = 0;
			$users[$userId]['SUM'] += $order['PRICE'];
		}

		// Для каждого пользователя проверяем уровень
		foreach ($users as $userId => $item)
		{
			$newLevel = 0;
			if ($item['SUM'] >= $options['level3'])
				$newLevel = 3;
			elseif ($item['SUM'] >= $options['level2'])
				$newLevel = 2;
			elseif ($item['SUM'] >= $options['level1'])
				$newLevel = 1;

			// Пользователя нужно переместить в другую группу
			if ($newLevel != $item['LEVEL'])
			{
				// Получаем текущие группы пользователя
				$groups = \CUser::GetUserGroup($userId);
				$newGroups = array();

				// Удаляем все накопительные группы
				foreach ($groups as $groupId)
					if (!self::$levelByGroupId[$groupId])
						$newGroups[] = $groupId;
				// Добавляем нужную
				foreach (self::$levelByGroupId as $groupId => $level)
					if ($level == $newLevel)
						$newGroups[] = $groupId;

				// Устанавливаем принадлежность к группам
				\CUser::SetUserGroup($userId, $newGroups);
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
			'months' => \COption::GetOptionInt("grain.customsettings", "SAVINGS_MONTHS", '6'),
			'level1' => \COption::GetOptionInt("grain.customsettings", "SAVINGS_1", '30000'),
			'level2' => \COption::GetOptionInt("grain.customsettings", "SAVINGS_2", '200000'),
			'level3' => \COption::GetOptionInt("grain.customsettings", "SAVINGS_3", '500000'),
		);
	}

	/**
	 * Получает параметры накопительной программы для текущего пользователя
	 * @return array
	 */
	public static function getCurrentUserData()
	{
		$return = array(
			'LEVEL' => 0,
		);
		$group = 0;
		global $USER;
		$groups = $USER->GetUserGroupArray();
		foreach ($groups as $groupId)
		{
			if (self::$levelByGroupId[$groupId])
			{
				$group = $groupId;
				$return['LEVEL'] = self::$levelByGroupId[$groupId];
				break;
			}
		}

		$return['GROUP'] = $group;
		if ($group)
		{
			\CModule::IncludeModule('sale');
			$saleDiscount = new \CSaleDiscount();
			$rsList = $saleDiscount->GetList(array(),array(
				'USER_GROUPS' => $group,
			));
			if ($disc = $rsList->Fetch())
				$return['NAME'] = $disc['NAME'];
		}

		return $return;
	}

}