<?
namespace Local\Catalog;
use Local\System\ExtCache;

/**
 * Class Holidays Праздники
 * @package Local\Catalog
 */
class Holidays
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Catalog/Holidays/';

	/**
	 * ID инфоблока
	 */
	const IB_HOLIDAYS = 49;

	/**
	 * Возвращает все праздники
	 * @param bool|false $refreshCache
	 * @return array
	 */
	public static function getAll($refreshCache = false)
	{
		$return = array();

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
			),
			static::CACHE_PATH . __FUNCTION__ . '/',
			86400000
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(), array(
				'IBLOCK_ID' => self::IB_HOLIDAYS,
				'ACTIVE' => 'Y',
			), false, false, array(
				'ID', 'NAME', 'CODE',
			));
			while ($item = $rsItems->Fetch())
			{
				$return['ITEMS'][$item['ID']] = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'CODE' => $item['CODE'],
				);
				if ($item['CODE']) {
					$return['BY_CODE'][$item['CODE']] = $item['ID'];
				}
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Возвращает праздник по ID элемента
	 * @param $id
	 * @return mixed
	 */
	public static function getById($id) {
		$all = self::getAll();
		return $all['ITEMS'][$id];
	}

	/**
	 * Возвращает ID праздника по коду
	 * @param $code
	 * @return mixed
	 */
	public static function getIdByCode($code) {
		$all = self::getAll();
		return $all['BY_CODE'][$code];
	}

	/**
	 * Возвращает группу для панели фильтров
	 * @return array
	 */
	public static function getGroup()
	{
		$return = array();

		$all = self::getAll();
		foreach ($all['ITEMS'] as $item)
			$return[$item['CODE']] = array(
				'ID' => $item['ID'],
				'CODE' => 'HOLIDAY',
				'NAME' => $item['NAME'],
			);

		return $return;
	}

	/**
	 * Очищает кеш
	 */
	public static function clearCache()
	{
		$phpCache = new \CPHPCache();
		$phpCache->CleanDir(static::CACHE_PATH . 'getAll');
	}
}