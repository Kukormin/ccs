<?

namespace Local\Catalog;

use Bitrix\Iblock\InheritedProperty\ElementValues;
use Local\Sale\Package;
use Local\Sale\Postals;
use Local\System\ExtCache;

/**
 * Class Products Товары и торговые предложения каталога
 * @package Local\Catalog
 */
class Products
{
	const IB_PRODUCTS = 44;
	const IB_OFFERS = 45;
	const IB_PRODUCT_PROP_ID = 249;
	const CACHE_TIME = 86400;

	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Catalog/Products/';

	/**
	 * Возвращает все товары со свойствами, которые нужны для построения панели фильтров.
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
			static::CACHE_TIME
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			$select = array(
				'ID',
				'NAME',
			    'PROPERTY_PRICE',
			    'PROPERTY_PRICE_WO_DISCOUNT',
			    'PROPERTY_CATEGORY',
			    'PROPERTY_HOLIDAY',
			);
			$flagsSelect = Flags::getForSelect();
			$select = array_merge($select, $flagsSelect);
			$codes = Flags::getCodes();

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(), array(
				'IBLOCK_ID' => self::IB_PRODUCTS,
				'ACTIVE' => 'Y',
			), false, false, $select);
			while ($item = $rsItems->Fetch())
			{
				if ($item['PROPERTY_HOLIDAY_VALUE'])
					$item['PROPERTY_HOLIDAY_VALUE'][] = 1;
				$product = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'CATEGORY' => intval($item['PROPERTY_CATEGORY_VALUE']),
					'HOLIDAY' => $item['PROPERTY_HOLIDAY_VALUE'],
					'PRICE' => intval($item['PROPERTY_PRICE_VALUE']),
					'PRICE_WO_DISCOUNT' => intval($item['PROPERTY_PRICE_WO_DISCOUNT_VALUE']),
				);

				foreach ($codes as $code)
				{
					if ($code == 'KIDS')
						$product[$code] = ($item['PROPERTY_BOY_VALUE'] || $item['PROPERTY_GIRL_VALUE']) ? 1 : 0;
					else
						$product[$code] = intval($item['PROPERTY_' . $code . '_VALUE']);
				}

				$return[$item['ID']] = $product;
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Возвращает товар по ID
	 * @param $id
	 */
	public static function getSimpleById($id)
	{
		$all = self::getAll();
		return $all[$id];
	}

	/**
	 * Возвращает данные по фильтру
	 * (сначала получает все товары getAll - потом фильтрует)
	 * @param $filter
	 * @param bool|false $refreshCache
	 * @return array
	 */
	public static function getDataByFilter($filter, $refreshCache = false)
	{
		$return = array(
			'COUNT' => 0,
		);

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
				$filter,
			),
			static::CACHE_PATH . __FUNCTION__ . '/',
			static::CACHE_TIME
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			$all = self::getAll($refreshCache);
			foreach ($all as $productId => $product)
			{
				$ok = true;
				foreach ($filter as $key => $value)
				{
					if ($key == 'ID')
					{
						if (!$value[$productId])
						{
							$ok = false;
							break;
						}
					}
					elseif ($key == 'PRICE')
					{
						if (isset($value['FROM']) && $product['PRICE'] < $value['FROM'] ||
							isset($value['TO']) && $product['PRICE'] > $value['TO'])
						{
							$ok = false;
							break;
						}
					}
					elseif ($key == 'CATEGORY')
					{
						if (!$value[$product['CATEGORY']])
						{
							$ok = false;
							break;
						}
					}
					elseif ($key == 'HOLIDAY')
					{
						$ex = false;
						foreach ($product['HOLIDAY'] as $h)
						{
							if ($value[$h])
							{
								$ex = true;
								break;
							}
						}
						if (!$ex)
						{
							$ok = false;
							break;
						}
					}
					else
					{
						if (!$product[$key])
						{
							$ok = false;
							break;
						}
					}

				}

				if ($ok)
				{
					$return['COUNT']++;
					$return['IDS'][] = $product['ID'];

					if (!isset($return['PRICE']['MIN']) || $return['PRICE']['MIN'] > $product['PRICE'])
						$return['PRICE']['MIN'] = $product['PRICE'];
					if (!isset($return['PRICE']['MAX']) || $return['PRICE']['MAX'] < $product['PRICE'])
						$return['PRICE']['MAX'] = $product['PRICE'];

					if (!isset($return['CATEGORY'][$product['CATEGORY']]))
						$return['CATEGORY'][$product['CATEGORY']] = 0;
					$return['CATEGORY'][$product['CATEGORY']]++;

					foreach ($product['HOLIDAY'] as $h)
					{
						if (!isset($return['HOLIDAY'][$h]))
							$return['HOLIDAY'][$h] = 0;
						$return['HOLIDAY'][$h]++;
					}

					foreach (Flags::getCodes() as $code)
					{
						if ($product[$code])
						{
							if (!isset($return[$code]))
								$return[$code] = 0;
							$return[$code]++;
						}
					}
				}
			}

			if ($filter['ID'])
			{
				$ids = array();
				foreach ($return['IDS'] as $id)
					$ids[$id] = true;
				$res = array();
				foreach ($filter['ID'] as $id)
				{
					if ($ids[$id])
						$res[] = $id;
				}
				$return['IDS'] = $res;
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Есть ли хоть один товар по фильтру?
	 * @param $filter
	 * @return bool
	 */
	public static function exByFilter($filter)
	{
		$all = self::getAll();
		foreach ($all as $productId => $product)
		{
			$ok = true;
			foreach ($filter as $key => $value)
			{
				if ($key == 'CATEGORY')
				{
					if (!$value[$product['CATEGORY']])
					{
						$ok = false;
						break;
					}
				}
				elseif ($key == 'HOLIDAY')
				{
					$ex = false;
					foreach ($product['HOLIDAY'] as $h)
					{
						if ($value[$h])
						{
							$ex = true;
							break;
						}
					}
					if (!$ex)
					{
						$ok = false;
						break;
					}
				}
				else
				{
					if (!$product[$key])
					{
						$ok = false;
						break;
					}
				}
			}

			if ($ok)
				return true;
		}

		return false;
	}

	/**
	 * Есть ли 3 товара по фильтру?
	 * @param $filter
	 * @return bool
	 */
	public static function ex3ByFilter($filter)
	{
		$all = self::getAll();
		$cnt = 0;
		foreach ($all as $productId => $product)
		{
			$ok = true;
			foreach ($filter as $key => $value)
			{
				if ($key == 'CATEGORY')
				{
					if (!$value[$product['CATEGORY']])
					{
						$ok = false;
						break;
					}
				}
				elseif ($key == 'HOLIDAY')
				{
					$ex = false;
					foreach ($product['HOLIDAY'] as $h)
					{
						if ($value[$h])
						{
							$ex = true;
							break;
						}
					}
					if (!$ex)
					{
						$ok = false;
						break;
					}
				}
				else
				{
					if (!$product[$key])
					{
						$ok = false;
						break;
					}
				}
			}

			if ($ok)
			{
				$cnt++;
				if ($cnt >= 3)
					return true;
			}
		}

		return false;
	}

	/**
	 * Возвращает товары по фильтру. Сначала получаем айдишники товаров методом getSimpleByFilter
	 * Результат уже должен быть закеширован (панелью фильтров)
	 * @param $sort
	 * @param $productIds
	 * @param $nav
	 * @param bool|false $refreshCache
	 * @return array
	 */
	public static function get($sort, $productIds, $nav, $refreshCache = false)
	{
		$return = array();

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
				$sort,
				$productIds,
				$nav,
			),
			static::CACHE_PATH . __FUNCTION__ . '/',
			static::CACHE_TIME
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			if ($productIds)
			{
				$return['NAV'] = array(
					'COUNT' => count($productIds),
					'PAGE' => $nav ? $nav['iNumPage'] : 'all',
				);

				// В случае поиска - ручная пагинация
				if ($sort['SEARCH'] == 'asc' && $nav)
				{
					$l = $nav['nPageSize'];
					$offset = ($nav['iNumPage'] - 1) * $l;
					$productIds = array_slice($productIds, $offset, $l);
					$nav = false;
				}

				if (!isset($sort['ID']))
					$sort['ID'] = 'DESC';

				// Товары
				$iblockElement = new \CIBlockElement();
				$rsItems = $iblockElement->GetList($sort, array(
					'=ID' => $productIds,
				), false, $nav, array(
					'ID', 'NAME', 'CODE',
					'PREVIEW_PICTURE',
					'PROPERTY_PRICE_COUNT',
					'PROPERTY_CATEGORY',
					'PROPERTY_DISABLED',
				));
				while ($item = $rsItems->GetNext())
				{
					$product = self::getSimpleById($item['ID']);

					$ipropValues = new ElementValues(self::IB_PRODUCTS, $item['ID']);
					$iprop = $ipropValues->getValues();

					$category = Categories::getById($item['PROPERTY_CATEGORY_VALUE']);
					$detail =  self::getDetailUrl($item, $category['CODE']);

					$product['NAME'] = $item['NAME'];
					$product['PIC_ALT'] = $iprop['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] ?
						$iprop['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] : $item['NAME'];
					$product['PIC_TITLE'] = $iprop['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] ?
						$iprop['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] : $item['NAME'];
					$product['DETAIL_PAGE_URL'] = $detail;
					$product['PREVIEW_PICTURE'] = \CFile::GetPath($item['PREVIEW_PICTURE']);
					$product['PRICE_COUNT'] = $item['PROPERTY_PRICE_COUNT_VALUE'];
					$product['DISABLED'] = $item['PROPERTY_DISABLED_VALUE'];

					$return['ITEMS'][$item['ID']] = $product;
				}

				// Восстановление сортировки для поиска
				if ($sort['SEARCH'] == 'asc')
				{
					$items = array();
					foreach ($productIds as $id)
					{
						if ($return['ITEMS'][$id])
							$items[$id] = $return['ITEMS'][$id];
					}
					$return['ITEMS'] = $items;
				}
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Возвращает ID товара по коду
	 * @param $code
	 * @param bool|false $refreshCache
	 * @return int|mixed
	 */
	public static function getIdByCode($code, $refreshCache = false)
	{
		$return = 0;

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
				$code,
			),
			static::CACHE_PATH . __FUNCTION__ . '/',
			static::CACHE_TIME
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(), array(
				'IBLOCK_ID' => self::IB_PRODUCTS,
				'=CODE' => $code,
			), false, false, array('ID'));
			if ($item = $rsItems->Fetch())
			{
				$return = $item['ID'];
				$extCache->endDataCache($return);
			}
			else
				$extCache->abortDataCache();
		}

		return $return;
	}

	/**
	 * Возвращает карточку товара по коду
	 * @param $code
	 * @param bool|false $refreshCache
	 * @return array|mixed
	 */
	public static function getByCode($code, $refreshCache = false)
	{
		$id = self::getIdByCode($code, $refreshCache);
		if ($id)
			return self::getById($id, $refreshCache);
		else
			return array();
	}

	/**
	 * Возвращает url карточки товара
	 * @param $item
	 * @param $cat
	 * @return string
	 */
	public static function getDetailUrl($item, $cat)
	{
		//return Filter::$CATALOG_PATH . $cat . '/' .($item['CODE'] ? $item['CODE'] : $item['ID']) . '/';
		return Filter::$CATALOG_PATH . $cat . '/' . $item['ID'] . '/';
	}

	/**
	 * Возвращает карточку товара по ID
	 * @param int $id
	 * @param bool|false $refreshCache
	 * @return array|mixed
	 */
	public static function getById($id, $refreshCache = false)
	{
		$return = array();

		$id = intval($id);
		if (!$id)
			return $return;

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
				$id,
			),
			static::CACHE_PATH . __FUNCTION__ . '/',
			static::CACHE_TIME
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			$iblockElement = new \CIBlockElement();
			$filter = array(
				'IBLOCK_ID' => self::IB_PRODUCTS,
				'ID' => $id,
			);
			$select = array(
				'ID', 'NAME', 'CODE', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'DETAIL_TEXT',
				'PROPERTY_PICTURES',
				'PROPERTY_DISABLED',
				'PROPERTY_CATEGORY',
				'PROPERTY_HIT',
				'PROPERTY_ACTION',
				'PROPERTY_ACTION_TEXT',
				'PROPERTY_NEW',
			    'CATALOG_GROUP_1',
			);
			$rsItems = $iblockElement->GetList(array(), $filter, false, false, $select);
			if ($item = $rsItems->GetNext())
			{
				$category = Categories::getById($item['PROPERTY_CATEGORY_VALUE']);
				$detail =  self::getDetailUrl($item, $category['CODE']);
				$ipropValues = new ElementValues(self::IB_PRODUCTS, $item['ID']);
				$iprop = $ipropValues->getValues();
				$title = $iprop['ELEMENT_META_TITLE'] ? $iprop['ELEMENT_META_TITLE'] :
					$item['NAME'] . ' - от Cupcake Story';
				$desc = $iprop['ELEMENT_META_DESCRIPTION'] ? $iprop['ELEMENT_META_DESCRIPTION'] :
					 'Купить «' . $item['NAME'] . '». Самые вкусные сладости только в Cupcake Story. Доставка по Москве.';
				$pictures = array();
				$file = new \CFile();
				foreach ($item['PROPERTY_PICTURES_VALUE'] as $picId)
					$pictures[] = $file->GetPath($picId);
				$offers = self::getOffersByProduct($item['ID']);
				$return = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'TITLE' => $title,
					'DESCRIPTION' => $desc,
					'CODE' => $item['CODE'],
					'DISABLED' => $item['PROPERTY_DISABLED_VALUE'],
					'DETAIL_PAGE_URL' => $detail,
					'PREVIEW_PICTURE' => $file->GetPath($item['PREVIEW_PICTURE']),
					'PREVIEW_TEXT' => $item['~PREVIEW_TEXT'],
					'DETAIL_TEXT' => $item['~DETAIL_TEXT'],
					'CATEGORY' => $category,
					'PICTURES' => $pictures,
					'HIT' => $item['PROPERTY_HIT_VALUE'],
					'ACTION' => $item['PROPERTY_ACTION_VALUE'],
					'ACTION_TEXT' => $item['PROPERTY_ACTION_TEXT_VALUE'],
					'NEW' => $item['PROPERTY_NEW_VALUE'],
					'OFFERS' => $offers,
				);
				if (!$offers)
				{
					$price = intval($item['CATALOG_PRICE_1']);
					$discounts = self::getDiscounts($item['ID'], self::IB_PRODUCTS, $price);
					$return['PRICE'] = $discounts['PRICE'];
					$return['PRICE_ID'] = $item['CATALOG_PRICE_1_ID'];
					$return['PRICE_WO_DISCOUNT'] = $price;
					$return['ACTION_TEXT'] = $discounts['TEXT'];
				}

				$extCache->endDataCache($return);
			}
			else
				$extCache->abortDataCache();

		}

		return $return;
	}

	/**
	 * Возвращает предложения для заданного товара
	 * @param $productId
	 * @return array
	 */
	public static function getOffersByProduct($productId)
	{
		$return = array();

		$iblockElement = new \CIBlockElement();
		$rsItems = $iblockElement->GetList(array(), array(
			'IBLOCK_ID' => self::IB_OFFERS,
			'PROPERTY_CML2_LINK' => $productId,
			'ACTIVE' => 'Y',
		), false, false, array(
			'ID',
			'IBLOCK_ID',
			'PROPERTY_COUNT',
			'PROPERTY_OFFER_ARTICLE',
			'CATALOG_GROUP_1',
		));
		while ($item = $rsItems->Fetch())
		{
			$price = intval($item['CATALOG_PRICE_1']);
			$discounts = self::getDiscounts($item['ID'], self::IB_OFFERS, $price);
			$return[$item['ID']] = array(
				'ID' => $item['ID'],
				'COUNT' => $item['PROPERTY_COUNT_VALUE'],
				'ARTICLE' => $item['PROPERTY_OFFER_ARTICLE_VALUE'],
				'PRICE' => $discounts['PRICE'],
				'PRICE_ID' => $item['CATALOG_PRICE_1_ID'],
				'PRICE_WO_DISCOUNT' => $price,
				'ACTION_TEXT' => $discounts['TEXT'],
			);
		}

		uasort($arReturn, '\Local\Catalog\Products::countCmp');

		return $return;
	}

	/**
	 * Для сортировки по количеству
	 * @param $a
	 * @param $b
	 * @return int
	 */
	static function countCmp($a, $b)
	{
		if ($a['COUNT'] == $b['COUNT'])
			return 0;
		return ($a['COUNT'] < $b['COUNT']) ? -1 : 1;
	}

	/**
	 * Увеличивает счетчики просмотров товара
	 * @param $productId
	 */
	public static function viewedCounters($productId)
	{
		\CIBlockElement::CounterInc($productId);
	}

	/**
	 * Формирует поисковый контент для товара
	 * (добавляет категорию в заголовок и праздник в текст)
	 * @param $arFields
	 * @return mixed
	 */
	public static function beforeSearchIndex($arFields)
	{
		$productId = intval($arFields['ITEM_ID']);
		if ($productId && array_key_exists('BODY', $arFields))
		{
			$product = self::getSimpleById($productId);
			if ($product)
			{
				// Название категории в заголовок
				$category = Categories::getById($product['CATEGORY']);
				$arFields['TITLE'] .= ' ' . $category['NAME'];

				// Праздники в тело
				foreach ($product['HOLIDAY'] as $hid)
				{
					$h = Holidays::getById($hid);
					$arFields['BODY'] .= ' ' . $h['NAME'];
				}
				// Флаги в тело
				$flags = Flags::getAll();
				foreach ($flags as $group)
					foreach ($group as $item)
						if ($product[$item['CODE']])
							$arFields['BODY'] .= ' ' . $item['NAME'];
			}
		}

		return $arFields;
	}

	/**
	 * Обрабочик изменения цены для заданного элемента (товара или предложения)
	 * @param $elementId
	 */
	public static function priceChange($elementId) {
		$rs = \CIBlockElement::GetByID($elementId);
		if ($element = $rs->Fetch())
		{
			if ($element['IBLOCK_ID'] == self::IB_PRODUCTS)
				Products::setSortPrice($elementId);
			elseif ($element['IBLOCK_ID'] == self::IB_OFFERS)
			{
				$rsProduct = \CIBlockElement::GetProperty(self::IB_OFFERS, $elementId, array(), Array(
					'ID' => self::IB_PRODUCT_PROP_ID,
				));
				if ($product = $rsProduct->Fetch())
					Products::setSortPrice($product['VALUE']);
			}
		}
	}

	/**
	 * обработчик удаление элемента - нужно обновить цену товара, если удалили ТП
	 * @param $ID
	 */
	public static function offerDelete($ID) {
		$rsProduct = \CIBlockElement::GetProperty(self::IB_OFFERS, $ID, array(),
			Array('ID' => self::IB_PRODUCT_PROP_ID)
		);
		if ($product = $rsProduct->Fetch())
			Products::setSortPrice($product['VALUE'], $ID);
	}

	/**
	 * обработчик изменения товара - нужно обновить его цену (вдруг ее вручную кто-то поменял)
	 * @param $productId
	 */
	public static function afterProductUpdate($productId) {
		Products::setSortPrice($productId);
	}

	/**
	 * Возвращает цену с учетом скидки и описание скидки для заданного товара
	 * @param $productId
	 * @param $iblockId
	 * @param $price
	 * @return array
	 */
	public static function getDiscounts($productId, $iblockId, $price) {
		$discounts = \CCatalogDiscount::GetDiscount(
			$productId,
			$iblockId,
			array(1),
			array(2),
			'N',
			's1',
			array()
		);
		$discountPrice = \CCatalogProduct::CountPriceWithDiscount(
			intval($price),
			'RUB',
			$discounts
		);
		$discountText = '';
		foreach ($discounts as $tmp)
		{
			$discountText = $tmp['NAME'];
			break;
		}

		return array(
			'PRICE' => intval($discountPrice),
			'TEXT' => $discountText,
		);
	}

	/**
	 * Устанавливает цену товара = цене самого дешевого из ТП (с учетом скидок битрикса)
	 * считается что пользователь принадлежит только группе 2 (все пользователи)
	 * @param $productId
	 * @param int $excludeOfferId
	 */
	public static function setSortPrice($productId, $excludeOfferId = 0)
	{
		$iblockElement = new \CIBlockElement();
		$rsItems = $iblockElement->GetList(array(), array(
			'IBLOCK_ID' => self::IB_OFFERS,
			'ACTIVE' => 'Y',
			'=PROPERTY_CML2_LINK' => $productId,
			'!ID' => $excludeOfferId,
		), false, false, array(
			'ID',
			'CATALOG_GROUP_1',
			'PROPERTY_COUNT',
		));
		$min = false;
		$count = 0;
		while ($item = $rsItems->Fetch())
		{
			if ($min === false || $min > $item['CATALOG_PRICE_1'])
			{
				$min = $item['CATALOG_PRICE_1'];
				$count = $item['PROPERTY_COUNT_VALUE'];
			}
		}
		// Если у товара нет торговых предложений
		if ($min === false)
		{
			$price = \CPrice::GetBasePrice($productId);
			if ($price)
				$min = $price['PRICE'];
		}

		if ($min !== false)
		{
			$discounts = self::getDiscounts($productId, self::IB_PRODUCTS, $min);
			$iblockElement->SetPropertyValuesEx($productId, self::IB_PRODUCTS, array(
				'PRICE' => $discounts['PRICE'],
				'PRICE_WO_DISCOUNT' => intval($min),
				'PRICE_COUNT' => intval($count),
				'ACTION' => $discounts['PRICE'] < $min ? 1 : 0,
				'ACTION_TEXT' => $discounts['TEXT'],
			));
		}
	}

	/**
	 * Корректирует цены товаров после изменения скидок в системе
	 * считается что пользователь принадлежит только группе 2 (все пользователи)
	 */
	public static function setSortPriceAllProducts()
	{
		$iblockElement = new \CIBlockElement();
		$clearCache = false;
		$products = self::getAll();
		foreach ($products as $item)
		{
			$productId = $item['ID'];
			$discounts = self::getDiscounts($productId, self::IB_PRODUCTS, $item['PRICE_WO_DISCOUNT']);
			if ($discounts['PRICE'] != $item['PRICE'])
			{
				$iblockElement->SetPropertyValuesEx($productId, self::IB_PRODUCTS, array(
					'PRICE' => $discounts['PRICE'],
					'ACTION' => $discounts['PRICE'] < $item['PRICE_WO_DISCOUNT'] ? 1 : 0,
				    'ACTION_TEXT' => $discounts['TEXT'],
				));
				$clearCache = true;
			}
		}

		if ($clearCache)
		{
			self::clearCatalogCache();
			self::getAll(true);
		}
	}

	/**
	 * Возвращает ID товара по старому ID
	 * @param $id
	 * @param bool|false $refreshCache
	 * @return int|mixed
	 */
	public static function getIdByOldId($id, $refreshCache = false)
	{
		$return = 0;

		$id = intval($id);

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
				$id,
			),
			static::CACHE_PATH . __FUNCTION__ . '/',
			static::CACHE_TIME
		);
		if(!$refreshCache && $extCache->initCache()) {
			$return = $extCache->getVars();
		} else {
			$extCache->startDataCache();

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList(array(), array(
				'IBLOCK_ID' => self::IB_PRODUCTS,
				'=XML_ID' => $id,
			), false, false, array('ID'));
			if ($item = $rsItems->Fetch())
			{
				$return = $item['ID'];
				$extCache->endDataCache($return);
			}
			else
				$extCache->abortDataCache();
		}

		return $return;
	}

	/**
	 * Возвращает категории, товары, предложения для экспорта
	 * @return array
	 */
	public static function export()
	{
		$return = array();

		$iblockSection = new \CIBlockSection();
		$iblockElement = new \CIBlockElement();
		$file = new \CFile();

		//
		// Разделы
		//
		$rsItems = $iblockSection->GetList(array(
			'SORT' => 'ASC',
			'NAME' => 'ASC',
		), Array(
			'IBLOCK_ID' => self::IB_PRODUCTS,
		));
		while ($item = $rsItems->Fetch()) {

			$return['CAT'][$item['ID']] = array(
				'ID' => $item['ID'],
				'NAME' => $item['NAME'],
				'CODE' => $item['CODE'],
			);
		}

		// Для упаковок добавляем отдельную категорию
		$return['CAT'][1] = array(
			'ID' => 1,
			'NAME' => 'Упаковка',
		);

		// Для открыток тоже
		$return['CAT'][2] = array(
			'ID' => 2,
			'NAME' => 'Открытки',
		);

		// Для открыток тоже
		$return['CAT'][3] = array(
			'ID' => 3,
			'NAME' => 'Аксессуары',
		);

		//
		// Товары
		//
		$products = array();
		$rsItems = $iblockElement->GetList(array(), array(
			'IBLOCK_ID' => self::IB_PRODUCTS,
		), false, false, array(
			'ID', 'NAME', 'ACTIVE', 'CODE',
			'PREVIEW_PICTURE',
			'PROPERTY_CATEGORY',
			'PROPERTY_ARTICLE',
			'CATALOG_GROUP_1',
		));
		while ($item = $rsItems->GetNext())
		{
			$catId = $item['PROPERTY_CATEGORY_VALUE'];
			$cat = $return['CAT'][$catId];
			$price = floatval($item['CATALOG_PRICE_1']);

			$tmp = array(
				'ID' => $item['ID'],
				'CODE' => $item['CODE'],
			);
			$products[$item['ID']] = array(
				'ID' => $item['ID'],
				'ACTIVE' => $item['ACTIVE'],
				'NAME' => $item['NAME'],
				'ARTICLE' => $item['PROPERTY_ARTICLE_VALUE'],
			    'PICTURE' => $file->GetPath($item['PREVIEW_PICTURE']),
			    'DETAIL_PAGE_URL' => self::getDetailUrl($tmp, $cat['CODE']),
			    'CATEGORY_ID' => $catId,
			    'CATEGORY_NAME' => $cat['NAME'],
			    'PRICE' => $price,
			    'OFFERS' => 0,
			);
		}

		$rsItems = $iblockElement->GetList(array(), array(
			'IBLOCK_ID' => self::IB_OFFERS,
		), false, false, array(
			'ID',
			'NAME',
			'PROPERTY_OFFER_ARTICLE',
			'PROPERTY_CML2_LINK',
			'CATALOG_GROUP_1',
		));
		while ($item = $rsItems->Fetch())
		{
			$productId = $item['PROPERTY_CML2_LINK_VALUE'];
			$product = $products[$productId];
			$price = floatval($item['CATALOG_PRICE_1']);

			$return['OFFERS'][] = array(
				'ID' => $item['ID'],
				'NAME' => $item['NAME'],
				'PRODUCT_ID' => $productId,
				'PRODUCT_ACTIVE' => $product['ACTIVE'],
				'PRODUCT_NAME' => $product['NAME'],
				'PICTURE' => $product['PICTURE'],
				'DETAIL_PAGE_URL' => $product['DETAIL_PAGE_URL'],
				'ARTICLE' => $item['PROPERTY_OFFER_ARTICLE_VALUE'],
				'PRICE' => $price,
				'CATEGORY_ID' => $product['CATEGORY_ID'],
				'CATEGORY_NAME' => $product['CATEGORY_NAME'],
			);

			$products[$productId]['OFFERS']++;
		}

		foreach ($products as $product)
		{
			if ($product['OFFERS'])
				continue;

			$return['OFFERS'][] = array(
				'ID' => $product['ID'],
				'NAME' => $product['NAME'],
				'PRODUCT_ID' => $product['ID'],
				'PRODUCT_ACTIVE' => $product['ACTIVE'],
				'PRODUCT_NAME' => $product['NAME'],
				'PICTURE' => $product['PICTURE'],
				'DETAIL_PAGE_URL' => $product['DETAIL_PAGE_URL'],
				'ARTICLE' => $product['ARTICLE'],
				'PRICE' => $product['PRICE'],
				'CATEGORY_ID' => $product['CATEGORY_ID'],
				'CATEGORY_NAME' => $product['CATEGORY_NAME'],
			);
		}

		// Упаковки
		$rsItems = $iblockElement->GetList(array(), array(
			'IBLOCK_ID' => Package::IBLOCK_ID,
		), false, false, array(
			'ID',
			'NAME',
			'ACTIVE',
			'DETAIL_PICTURE',
			'PROPERTY_ARTICLE',
			'CATALOG_GROUP_1',
		));
		while ($item = $rsItems->Fetch())
		{
			$cat = $return['CAT'][1];
			$price = floatval($item['CATALOG_PRICE_1']);
			$return['OFFERS'][] = array(
				'ID' => $item['ID'],
				'NAME' => $item['NAME'],
				'PRODUCT_ID' => $item['ID'],
				'PRODUCT_ACTIVE' => $item['ACTIVE'],
				'PRODUCT_NAME' => $item['NAME'],
				'PICTURE' => $file->GetPath($item['DETAIL_PICTURE']),
				'DETAIL_PAGE_URL' => '',
				'ARTICLE' => $item['PROPERTY_ARTICLE_VALUE'],
				'PRICE' => $price,
				'CATEGORY_ID' => 1,
				'CATEGORY_NAME' => $cat['NAME'],
			);
		}

		// Открытки
		$rsItems = $iblockElement->GetList(array(), array(
			'IBLOCK_ID' => Postals::IBLOCK_ID,
		), false, false, array(
			'ID',
			'NAME',
			'ACTIVE',
			'DETAIL_PICTURE',
			'PROPERTY_ARTICLE',
			'CATALOG_GROUP_1',
		));
		while ($item = $rsItems->Fetch())
		{
			$cat = $return['CAT'][2];
			$price = floatval($item['CATALOG_PRICE_1']);
			$return['OFFERS'][] = array(
				'ID' => $item['ID'],
				'NAME' => $item['NAME'],
				'PRODUCT_ID' => $item['ID'],
				'PRODUCT_ACTIVE' => $item['ACTIVE'],
				'PRODUCT_NAME' => $item['NAME'],
				'PICTURE' => $file->GetPath($item['DETAIL_PICTURE']),
				'DETAIL_PAGE_URL' => '',
				'ARTICLE' => $item['PROPERTY_ARTICLE_VALUE'],
				'PRICE' => $price,
				'CATEGORY_ID' => 2,
				'CATEGORY_NAME' => $cat['NAME'],
			);
		}

		// Аксессуары
		$rsItems = $iblockElement->GetList(array(), array(
			'IBLOCK_ID' => Accessories::IBLOCK_ID,
		), false, false, array(
			'ID',
			'NAME',
			'ACTIVE',
			'DETAIL_PICTURE',
			'PROPERTY_ARTICLE',
			'CATALOG_GROUP_1',
		));
		while ($item = $rsItems->Fetch())
		{
			$cat = $return['CAT'][3];
			$price = floatval($item['CATALOG_PRICE_1']);
			$return['OFFERS'][] = array(
				'ID' => $item['ID'],
				'NAME' => $item['NAME'],
				'PRODUCT_ID' => $item['ID'],
				'PRODUCT_ACTIVE' => $item['ACTIVE'],
				'PRODUCT_NAME' => $item['NAME'],
				'PICTURE' => $file->GetPath($item['DETAIL_PICTURE']),
				'DETAIL_PAGE_URL' => '',
				'ARTICLE' => $item['PROPERTY_ARTICLE_VALUE'],
				'PRICE' => $price,
				'CATEGORY_ID' => 3,
				'CATEGORY_NAME' => $cat['NAME'],
			);
		}

		return $return;
	}

	/**
	 * Очищает кеш каталога
	 */
	public static function clearCatalogCache()
	{
		$phpCache = new \CPHPCache();
		$phpCache->CleanDir(static::CACHE_PATH . 'getAll');
		$phpCache->CleanDir(static::CACHE_PATH . 'getDataByFilter');
		$phpCache->CleanDir(static::CACHE_PATH . 'get');
		$phpCache->CleanDir(static::CACHE_PATH . 'getById');
	}

}

