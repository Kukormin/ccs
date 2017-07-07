<?
namespace Local\Catalog;
use Local\System\ExtCache;

/**
 * Class Goodies Жуковские вкусности
 * @package Local\Catalog
 */
class Goodies
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Catalog/Goodies/';

	/**
	 * ID раздела
	 */
	const CATEGORY_ID = 125;

	/**
	 * Возвращает все ЖУ
	 * @param bool|false $refreshCache
	 * @return array
	 */
	public static function get($refreshCache = false)
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
				'IBLOCK_ID' => Products::IB_PRODUCTS,
				'ACTIVE' => 'Y',
				'=PROPERTY_CATEGORY' => self::CATEGORY_ID,
			), false, false, array(
				'ID', 'NAME', 'CODE', 'IBLOCK_ID',
				'PREVIEW_PICTURE',
				'CATALOG_GROUP_1',
				'PROPERTY_CATEGORY',
			));
			while ($item = $rsItems->Fetch())
			{
				$return[] = $item;
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

}