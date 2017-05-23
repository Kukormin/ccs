<?
namespace Local\Media;
use Local\System\ExtCache;

/**
 * Class Cakes Торты на заказ
 * @package Local\Media
 */
class Cakes
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Media/Cakes/';

	/**
	 * ID инфоблока
	 */
	const IBLOCK_ID = 53;

	/**
	 * Возвращает все
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

			$iblockSection = new \CIBlockSection();
			$rsItems = $iblockSection->GetList(array('SORT' => 'ASC'), array(
				'IBLOCK_ID' => self::IBLOCK_ID,
				'ACTIVE' => 'Y',
			), false, array(
				'ID', 'NAME', 'CODE',
			));
			while ($item = $rsItems->Fetch())
			{
				$id = intval($item['ID']);
				$return[$id] = array(
					'NAME' => $item['NAME'],
					'ITEMS' => array(),
				);
			}

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(
				'SORT' => 'ASC',
			), array(
				'IBLOCK_ID' => self::IBLOCK_ID,
				'ACTIVE' => 'Y',
			), false, false, array(
				'ID', 'NAME', 'CODE', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'IBLOCK_SECTION_ID',
			));
			while ($item = $rsItems->GetNext())
			{
				$section = intval($item['IBLOCK_SECTION_ID']);
				$return[$section]['ITEMS'][] = array(
					'ID' => $item['ID'],
					'PICTURE' => $item['DETAIL_PICTURE'],
					'PICTURE1' => $item['PREVIEW_PICTURE'],
				);
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

}