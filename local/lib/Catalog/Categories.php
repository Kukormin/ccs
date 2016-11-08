<?
namespace Local\Catalog;

use Local\System\ExtCache;

/**
 * Class Categories Категории каталога
 * @package Local\Catalog
 */
class Categories
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Catalog/Categories/';

	/**
	 * Возвращает все категории каталога
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

			$iblockSection = new \CIBlockSection();
			$rsItems = $iblockSection->GetList(array(
				'SORT' => 'ASC',
				'NAME' => 'ASC',
			), Array(
				'IBLOCK_ID' => Products::IB_PRODUCTS,
			));
			while ($item = $rsItems->Fetch()) {

				$return['ITEMS'][$item['ID']] = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'SORT' => $item['SORT'],
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
	 * Возвращает категорию по ID
	 * @param $id
	 */
	public static function getById($id)
	{
		$all = self::getAll();
		return $all['ITEMS'][$id];
	}

	/**
	 * Возвращает ID категории по коду
	 * @param $code
	 */
	public static function getIdByCode($code)
	{
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
				'CODE' => 'CATEGORY',
				'NAME' => $item['NAME'],
			);

		return $return;
	}

	/**
	 * Возвращает категории каталога для товаров по фильтру
	 * @param array $filter
	 * @param bool|false $refreshCache
	 * @return array
	 */
	public static function getByFilter($filter = array(), $refreshCache = false)
	{
		$return = array();

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
				$filter,
			),
			static::CACHE_PATH . __FUNCTION__ . '/',
			Products::CACHE_TIME
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			/*$products = Products::getSimpleByFilter($filter, $refreshCache);
			foreach ($products as $product)
			{
				$value = $product['SECTION'];

				if (!isset($return[$value]))
				{
					$return[$value] = array(
						'VALUE' => $value,
						'CNT' => 1,
					);
				}
				else
				{
					$return[$value]['CNT']++;
				}
			}*/

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Очищает кеш, связанный с товарами каталога
	 */
	public static function clearProductsCache()
	{
		$phpCache = new \CPHPCache();
		$phpCache->CleanDir(static::CACHE_PATH . 'getByFilter');
	}

	/**
	 * Очищает кеш всего каталога
	 */
	public static function clearCatalogCache()
	{
		$phpCache = new \CPHPCache();
		$phpCache->CleanDir(static::CACHE_PATH . 'getAll');
		$phpCache->CleanDir(static::CACHE_PATH . 'getByFilter');
	}
}