<?

namespace Local\System;
use Local\Catalog\Holidays;
use Local\Catalog\Products;
use Local\Sale\Package;
use Local\Sale\Postals;
use Local\Utils\Abandoned;

/**
 * Class Handlers Обработчики событий
 * @package Local\Utils
 */
class Handlers
{
	/**
	 * Добавление обработчиков
	 */
	public static function addEventHandlers() {
		static $added = false;
		if (!$added) {
			$added = true;
			/*AddEventHandler('iblock', 'OnBeforeIBlockElementDelete',
				array(__NAMESPACE__ . '\Handlers', 'beforeIBlockElementDelete'));*/
			AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate',
				array(__NAMESPACE__ . '\Handlers', 'beforeIBlockElementUpdate'));
			AddEventHandler('iblock', 'OnIBlockPropertyBuildList',
				array(__NAMESPACE__ . '\Handlers', 'iBlockPropertyBuildList'));
			AddEventHandler('iblock', 'OnBeforeIBlockElementAdd',
				array(__NAMESPACE__ . '\Handlers', 'beforeElementAdd'));
			AddEventHandler('catalog', 'OnDiscountAdd',
				array(__NAMESPACE__ . '\Handlers', 'discountAdd'));
			AddEventHandler('catalog', 'OnDiscountUpdate',
				array(__NAMESPACE__ . '\Handlers', 'discountUpdate'));
			AddEventHandler('catalog', 'OnDiscountDelete',
				array(__NAMESPACE__ . '\Handlers', 'discountDelete'));
			AddEventHandler('catalog', 'OnPriceAdd',
				array(__NAMESPACE__ . '\Handlers', 'priceAdd'));
			AddEventHandler('catalog', 'OnPriceUpdate',
				array(__NAMESPACE__ . '\Handlers', 'priceUpdate'));
			AddEventHandler('iblock', 'OnIBlockElementDelete',
				array(__NAMESPACE__ . '\Handlers', 'elementDelete'));
			AddEventHandler('iblock', 'OnAfterIBlockElementUpdate',
				array(__NAMESPACE__ . '\Handlers', 'afterElementUpdate'));
			AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate',
				array(__NAMESPACE__ . '\Handlers', 'beforeElementUpdate'));
			AddEventHandler('main', 'OnAfterUserAdd',
				array(__NAMESPACE__ . '\Handlers', 'afterUserAdd'));
			AddEventHandler('main', 'OnBeforeProlog',
				array(__NAMESPACE__ . '\Handlers', 'beforeProlog'));
			AddEventHandler('search', 'BeforeIndex',
				array(__NAMESPACE__ . '\Handlers', 'beforeSearchIndex'));
		}
	}

	/**
	 * Добавление пользовательских свойств
	 * @return array
	 */
	public static function iBlockPropertyBuildList() {
		return UserTypeNYesNo::GetUserTypeDescription();
	}

	/**
	 * Уменьшение картинок товара при добавлении элемента
	 * Установка свойства ID раздела
	 * @param $arFields
	 */
	public static function beforeElementAdd(&$arFields) {
		if ($arFields['IBLOCK_ID'] == Products::IB_PRODUCTS)
		{
			foreach ($arFields['PROPERTY_VALUES'][223] as &$file)
			{
				\CFile::ResizeImage($file['VALUE'], array(
					"width" => "918",
					"height" => "918",
				), BX_RESIZE_IMAGE_PROPORTIONAL);
			}
			if (is_array($arFields['IBLOCK_SECTION']))
				$section = intval($arFields['IBLOCK_SECTION'][0]);
			else
				$section = intval($arFields['IBLOCK_SECTION']);
			if ($section)
				$arFields['PROPERTY_VALUES'][243] = $section;
		}
	}

	/**
	 * Уменьшение картинок товара при изменении элемента
	 * Установка свойства ID раздела
	 * @param $arFields
	 */
	public static function beforeElementUpdate(&$arFields) {
		if ($arFields['IBLOCK_ID'] == Products::IB_PRODUCTS)
		{
			foreach ($arFields['PROPERTY_VALUES'][223] as &$file)
			{
				if ($file['VALUE']['tmp_name'])
					\CFile::ResizeImage($file['VALUE'], array(
						"width" => "918",
						"height" => "918",
					), BX_RESIZE_IMAGE_PROPORTIONAL);
			}
			if (is_array($arFields['IBLOCK_SECTION']))
				$section = intval($arFields['IBLOCK_SECTION'][0]);
			else
				$section = intval($arFields['IBLOCK_SECTION']);
			if ($section)
				$arFields['PROPERTY_VALUES'][243] = $section;
		}
	}

	/**
	 * Корректировка цен товаров после добавления, редактирования или удаления скидок
	 */
	public static function discountAdd() {
		Products::setSortPriceAllProducts();
	}
	public static function discountUpdate() {
		Products::setSortPriceAllProducts();
	}
	public static function discountDelete() {
		Products::setSortPriceAllProducts();
	}

	/**
	 * Обработчик удаления цены
	 * @param $ID
	 * @param $fields
	 */
	public static function priceAdd(/** @noinspection PhpUnusedParameterInspection */$ID, $fields) {
		if ($fields['PRODUCT_ID'])
			Products::priceChange($fields['PRODUCT_ID']);
	}

	/**
	 * Обрабочик изменения цены
	 * @param $ID
	 * @param $fields
	 */
	public static function priceUpdate(/** @noinspection PhpUnusedParameterInspection */$ID, $fields) {
		if ($fields['PRODUCT_ID'])
			Products::priceChange($fields['PRODUCT_ID']);
	}

	/**
	 * обработчик удаления элемента
	 * @param $ID
	 */
	public static function elementDelete($ID) {
		$iblockId = self::getIblockByElementId($ID);
		// нужно обновить цену товара, если удалили ТП
		if ($iblockId == Products::IB_OFFERS)
			Products::offerDelete($ID);
	}

	/**
	 * обработчик изменения элемента
	 * @param $arFields
	 */
	public static function afterElementUpdate($arFields) {
		// нужно обновить цену товара (вдруг ее вручную кто-то поменял)
		if ($arFields['IBLOCK_ID'] == Products::IB_PRODUCTS)
			Products::afterProductUpdate($arFields['ID']);
	}

	/**
	 * Обработчик события перед удалением элемента, с возможностью отмены удаления
	 * @param $id
	 * @return bool
	 */
	public static function beforeIBlockElementDelete($id)
	{
		global $APPLICATION;
		$iblockId = self::getIblockByElementId($id);
		if ($iblockId == Products::IB_PRODUCTS)
		{
			$APPLICATION->throwException("\nНельзя просто так взять и удалить товар");
			return false;
		}
		elseif ($iblockId == Products::IB_OFFERS)
		{
			$APPLICATION->throwException("\nНельзя просто так взять и удалить торговое предложение");
			return false;
		}
		elseif ($iblockId == Holidays::IB_HOLIDAYS)
		{
			$APPLICATION->throwException("\nНельзя просто так взять и удалить праздник");
			return false;
		}
		elseif ($iblockId == Package::IBLOCK_ID)
		{
			$APPLICATION->throwException("\nНельзя просто так взять и удалить упаковку");
			return false;
		}
		elseif ($iblockId == Postals::IBLOCK_ID)
		{
			$APPLICATION->throwException("\nНельзя просто так взять и удалить открытку");
			return false;
		}

		return true;
	}

	/**
	 * Обработчик события перед изменением элемента с возможностью отмены изменений
	 * @param $arFields
	 * @return bool
	 */
	public static function beforeIBlockElementUpdate(&$arFields)
	{

		return true;
	}

	/**
	 * После добавления пользователя проверяем если задана только фамилия, считаем, что это имя
	 * @param $arFields
	 */
	public static function afterUserAdd(&$arFields)
	{
		$ID = intval($arFields['ID']);
		if ($ID > 0)
		{
			if (!$arFields['NAME'] && $arFields['LAST_NAME'])
			{
				$user = new \CUser();
				$user->Update($ID, array(
					'NAME' => $arFields['LAST_NAME'],
					'LAST_NAME' => '',
				));
			}
		}
	}

	/**
	 * вызывается в выполняемой части пролога сайта (после события OnPageStart)
	 */
	public static function beforeProlog()
	{
		// Авторизуем пользователя, если он пришел из письма
		Abandoned::authorizeEmailUser();
	}

	/**
	 * Формируем поисковый контент для товара
	 * @param $arFields
	 * @return mixed
	 */
	public static function beforeSearchIndex($arFields)
	{
		if ($arFields['MODULE_ID'] == 'iblock' && $arFields['PARAM2'] == Products::IB_PRODUCTS)
			$arFields = Products::beforeSearchIndex($arFields);

		return $arFields;
	}

	/**
	 * Находит ID инфоблока по ID элемента
	 * @param $id
	 * @return string
	 */
	private static function getIblockByElementId($id)
	{
		$iblock = 0;
		$iblockElement = new \CIBlockElement();
		$rsItems = $iblockElement->GetList(array(), array(
			'ID' => $id,
		), false, false, array(
			'IBLOCK_ID',
		));
		if ($item = $rsItems->Fetch())
			$iblock = $item['IBLOCK_ID'];

		return $iblock;
	}

}