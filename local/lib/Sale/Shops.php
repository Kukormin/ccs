<?
namespace Local\Sale;
use Local\System\ExtCache;

/**
 * Class Shops Магазины - пункты самовывоза
 * @package Local\Sale
 */
class Shops
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Sale/Shops/';

	/**
	 * ID инфоблока
	 */
	const IBLOCK_ID = 27;

	/**
	 * Возвращает все магазины
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
				'IBLOCK_ID' => self::IBLOCK_ID,
				'ACTIVE' => 'Y',
			), false, false, array(
				'ID', 'NAME',
				'PROPERTY_PICKUP_ADR',
				'PROPERTY_SCHEDULE'
			));
			while ($item = $rsItems->Fetch())
			{
				$return[$item['ID']] = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'ADR' => $item['PROPERTY_PICKUP_ADR_VALUE'],
					'SCHEDULE' => $item['PROPERTY_SCHEDULE_VALUE'],
				);
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

}