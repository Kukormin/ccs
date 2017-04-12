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

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(
				'SORT' => 'ASC',
			), array(
				'IBLOCK_ID' => self::IBLOCK_ID,
				'ACTIVE' => 'Y',
			), false, false, array(
				'ID', 'NAME', 'CODE', 'DETAIL_PICTURE',
			));
			while ($item = $rsItems->GetNext())
			{
				$return[] = array(
					'ID' => $item['ID'],
					'PICTURE' => $item['DETAIL_PICTURE'],
				);
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

}