<?

namespace Local\Sale;

use Local\System\ExtCache;

/**
 * Class Postals Открытки
 * @package Local\Sale
 */
class Postals
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Sale/Postals/';

	/**
	 * Инфоблок
	 */
	const IBLOCK_ID = 52;

	/**
	 * Возвращает все открытки
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

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(), array(
				'IBLOCK_ID' => self::IBLOCK_ID,
				'ACTIVE' => 'Y',
			), false, false, array(
				'ID', 'NAME', 'CODE', 'PREVIEW_PICTURE', 'DETAIL_PICTURE',
				'CATALOG_GROUP_1',
			));
			while ($item = $rsItems->Fetch()) {
				$key = $item['ID'];
				if ($item['CODE'] == 'default')
					$key = 0;
				$return[$key] = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'PRICE' => intval($item['CATALOG_PRICE_1']),
					'PRICE_ID' => $item['CATALOG_PRICE_1_ID'],
					'PREVIEW_PICTURE' => \CFile::GetPath($item['PREVIEW_PICTURE']),
					'DETAIL_PICTURE' => \CFile::GetPath($item['DETAIL_PICTURE']),
				);
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Возвращает открытку по ID
	 * @param $id
	 * @return mixed
	 */
	public static function getById($id)
	{
		$all = self::getAll();
		return $all[$id];
	}

	/**
	 * Возвращает открытку по-умолчанию
	 * @return mixed
	 */
	public static function getDefault()
	{
		$all = self::getAll();
		return $all[0];
	}

}