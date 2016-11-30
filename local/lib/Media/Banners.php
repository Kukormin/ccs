<?
namespace Local\Media;
use Local\System\ExtCache;

/**
 * Class Banners Праздники
 * @package Local\Media
 */
class Banners
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Media/Banners/';

	/**
	 * ID инфоблока
	 */
	const IB_BANNERS = 51;

	/**
	 * Возвращает все баннеры с группировкой по разделам
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
			68400
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			$codeById = array();

			$iblockSection = new \CIBlockSection();
			$rsItems = $iblockSection->GetList(array(), array(
				'IBLOCK_ID' => self::IB_BANNERS,
				'ACTIVE' => 'Y',
			), false, array(
				'ID', 'NAME', 'CODE',
			));
			while ($item = $rsItems->Fetch())
			{
				$code = trim($item['CODE']);
				if (!$code)
					continue;

				$id = intval($item['ID']);
				$codeById[$id] = $code;
				$return[$code] = array();
			}

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(
				'SORT' => 'ASC',
			), array(
				'IBLOCK_ID' => self::IB_BANNERS,
				'ACTIVE' => 'Y',
			), false, false, array(
				'ID', 'NAME', 'CODE', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'PREVIEW_PICTURE',
			    'PROPERTY_LINK',
			));
			while ($item = $rsItems->GetNext())
			{
				$section = intval($item['IBLOCK_SECTION_ID']);
				$code = $codeById[$section];
				if ($code)
				{
					$return[$code][] = array(
						'ID' => $item['ID'],
						'NAME' => $item['NAME'],
						'PICTURE' => $item['PREVIEW_PICTURE'],
						'TEXT' => $item['~PREVIEW_TEXT'],
						'LINK' => $item['PROPERTY_LINK_VALUE'],
					);
				}
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Возвращает баннеры по коду раздела
	 * @param $code
	 * @param int $count максимальное количество баннеров
	 * @return mixed
	 */
	public static function getBySectionCode($code, $count = 0) {
		$all = self::getAll();
		$banners = $all[$code];
		if ($count)
			$banners = array_slice($banners, 0, $count);
		return $banners;
	}

}