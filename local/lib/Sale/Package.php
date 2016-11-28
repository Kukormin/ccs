<?

namespace Local\Utils;
use Local\System\ExtCache;

/**
 * Class Package Упаковки товара
 * @package Local\Utils
 */
class Package
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Package/';

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

			//
			$return['MAP'] = array();
			$packIblocks = array();
			$rsProperties = \CIBlockProperty::GetList(array(), array('CODE' => 'PACKAGE'));
			while ($prop = $rsProperties->Fetch())
			{
				if ($prop['PROPERTY_TYPE'] == 'E')
				{
					$return['MAP'][$prop['IBLOCK_ID']] = $prop['LINK_IBLOCK_ID'];
					$packIblocks[$prop['LINK_IBLOCK_ID']] = $prop['LINK_IBLOCK_ID'];
				}
			}

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(), array(
				'IBLOCK_ID' => $packIblocks,
				'ACTIVE' => 'Y')
			);
			while ($item = $rsItems->Fetch()) {
				$price = 0;
				$rsPrice = \CPrice::GetList(array(), array('PRODUCT_ID' => $item['ID']));
				if ($arPrice = $rsPrice->Fetch())
					$price = intval($arPrice['PRICE']);
				$item['PREVIEW_PICTURE'] = \CFile::GetPath($item['PREVIEW_PICTURE']);
				$item['DETAIL_PICTURE'] = \CFile::GetPath($item['DETAIL_PICTURE']);
				$return['ITEMS'][$item['ID']] = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'IBLOCK_ID' => $item['IBLOCK_ID'],
					'PRICE' => $price,
					'PREVIEW_PICTURE' => \CFile::GetPath($item['PREVIEW_PICTURE']),
					'DETAIL_PICTURE' => \CFile::GetPath($item['DETAIL_PICTURE']),
				);
				$return['BY_IBLOCK_ID'][$item['IBLOCK_ID']][] = $item['ID'];
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
	 * Возвращает упаковку по названию и ID инфоблока
	 * @param $name
	 * @param $iblockId
	 * @return array
	 */
	public static function getByName($name, $iblockId)
	{
		$all = self::getAll();
		$packIblockId = $all['MAP'][$iblockId];
		foreach ($all['BY_IBLOCK_ID'][$packIblockId] as $id)
		{
			$item = $all['ITEMS'][$id];
			if ($item['NAME'] == $name)
				return $item;
		}
		return array();
	}

}