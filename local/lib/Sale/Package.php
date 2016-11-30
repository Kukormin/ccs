<?

namespace Local\Sale;

use Local\Catalog\Categories;
use Local\System\ExtCache;

/**
 * Class Package Упаковки товара
 * @package Local\Sale
 */
class Package
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Sale/Package/';

	/**
	 * Инфоблок
	 */
	const IBLOCK_ID = 47;

	/**
	 * Возвращает все упаковки
	 * (учитывает теговый кеш)
	 * @param bool $refreshCache для принудительного сброса кеша
	 * @return array|mixed
	 */
	public static function getAll($refreshCache = false)
	{
		$return = array();

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
			),
			static::CACHE_PATH . __FUNCTION__ . '/',
			86400 * 20
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			$iblockSection = new \CIBlockSection();
			$categories = array();
			$rsItems = $iblockSection->GetList(array(), array(
				'IBLOCK_ID' => self::IBLOCK_ID,
			));
			while ($item = $rsItems->Fetch()) {
				$id = Categories::getIdByCode($item['CODE']);
				$categories[$item['ID']] = $id;
			}

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(), array(
				'IBLOCK_ID' => self::IBLOCK_ID,
				'ACTIVE' => 'Y',
			), false, false, array(
				'ID', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE',
				'CATALOG_GROUP_1',
			));
			while ($item = $rsItems->Fetch()) {
				$categoryId = $categories[$item['IBLOCK_SECTION_ID']];
				$return['ITEMS'][$item['ID']] = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'CATEGORY' => $categoryId,
					'PRICE' => intval($item['CATALOG_PRICE_1']),
					'PRICE_ID' => $item['CATALOG_PRICE_1_ID'],
					'PREVIEW_PICTURE' => \CFile::GetPath($item['PREVIEW_PICTURE']),
					'DETAIL_PICTURE' => \CFile::GetPath($item['DETAIL_PICTURE']),
				);
			}

			uasort($return['ITEMS'], function ($a, $b) {
				if ($a['PRICE'] == $b['PRICE'])
					return 0;
				return $a['PRICE'] > $b['PRICE'] ? 1 : -1;
			});

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Возвращает упаковку по ID
	 * @param $id
	 * @return mixed
	 */
	public static function getById($id)
	{
		$all = self::getAll();
		return $all['ITEMS'][$id];
	}

	/**
	 * Возвращает упаковки для типа товара
	 * @param $categoryId
	 * @return mixed
	 */
	public static function getByCategory($categoryId)
	{
		$return = array();

		$all = self::getAll();
		foreach ($all['ITEMS'] as $item)
			if ($item['CATEGORY'] == $categoryId)
				$return[] = $item;

		return $return;
	}

}