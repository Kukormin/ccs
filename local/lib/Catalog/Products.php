<?

namespace Local\Catalog;
use Bitrix\Iblock\InheritedProperty\ElementValues;
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
				$product = array(
					'ID' => $item['ID'],
					'CATEGORY' => intval($item['PROPERTY_CATEGORY_VALUE']),
					'HOLIDAY' => $item['PROPERTY_HOLIDAY_VALUE'],
					'PRICE' => intval($item['PROPERTY_PRICE_VALUE']),
					'PRICE_D' => intval($item['PROPERTY_PRICE_WO_DISCOUNT_VALUE']),
				);

				foreach ($codes as $code)
					$product[$code] = intval($item['PROPERTY_' . $code . '_VALUE']);

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

			$extCache->endDataCache($return);
		}

		return $return;
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
				// Товары
				$iblockElement = new \CIBlockElement();
				$rsItems = $iblockElement->GetList($sort, array(
					'=ID' => $productIds,
				), false, $nav, array(
					'ID', 'NAME', 'CODE',
					'PREVIEW_PICTURE',
					'PREVIEW_TEXT',
					'PROPERTY_ARTICLE',
					'PROPERTY_PRICE_COUNT',

				));
				while ($item = $rsItems->GetNext())
				{
					$product = self::getSimpleById($item['ID']);

					$ipropValues = new ElementValues(self::IB_PRODUCTS, $item['ID']);
					$iprop = $ipropValues->getValues();

					$product['NAME'] = $item['NAME'];
					$product['TITLE'] = $iprop['ELEMENT_PAGE_TITLE'] ? $iprop['ELEMENT_PAGE_TITLE'] : $item['NAME'];
					$product['PIC_ALT'] = $iprop['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] ?
						$iprop['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] : $item['NAME'];
					$product['PIC_TITLE'] = $iprop['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] ?
						$iprop['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] : $item['NAME'];
					$product['DETAIL_PAGE_URL'] = '/d/' . ($item['CODE'] ? $item['CODE'] : $item['ID']) . '/';
					$product['PREVIEW_TEXT'] = $item['~PREVIEW_TEXT'];
					$product['PREVIEW_PICTURE'] = \CFile::GetPath($item['PREVIEW_PICTURE']);
					$product['ARTICLE'] = $item['PROPERTY_ARTICLE_VALUE'];
					$product['PRICE_COUNT'] = $item['PROPERTY_PRICE_COUNT_VALUE'];

					$return['ITEMS'][$item['ID']] = $product;
				}

				$return['NAV'] = array(
					'COUNT' => $rsItems->NavRecordCount,
					'PAGE' => $rsItems->NavPageNomer,
				);
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
	 * Возвращает карточку товара по ID
	 * @param int $id
	 * @param bool|false $refreshCache
	 * @return array|mixed
	 */
	public static function getById($id, $refreshCache = false)
	{
		$return = array();

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
				'ID', 'NAME', 'CODE', 'PREVIEW_TEXT', 'DETAIL_TEXT',
				'PROPERTY_PICTURES',
				'PROPERTY_ARTICLE',
				'PROPERTY_CATEGORY',
				'PROPERTY_HIT',
				'PROPERTY_ACTION',
				'PROPERTY_NEW',
			    'CATALOG_GROUP_1',
			);
			$rsItems = $iblockElement->GetList(array(), $filter, false, false, $select);
			if ($item = $rsItems->GetNext())
			{
				$detail = '/d/' . ($item['CODE'] ? $item['CODE'] : $item['ID']) . '/';
				$pictures = array();
				$file = new \CFile();
				foreach ($item['PROPERTY_PICTURES_VALUE'] as $picId)
					$pictures[] = $file->GetPath($picId);
				$offers = self::getOffersByProduct($item['ID']);
				$return = array(
					'ID' => $item['ID'],
					'NAME' => $item['NAME'],
					'CODE' => $item['CODE'],
					'ARTICLE' => $item['PROPERTY_ARTICLE_VALUE'],
					'DETAIL_PAGE_URL' => $detail,
					'PREVIEW_TEXT' => $item['~PREVIEW_TEXT'],
					'DETAIL_TEXT' => $item['~DETAIL_TEXT'],
					'CATEGORY' => Categories::getById($item['PROPERTY_CATEGORY_VALUE']),
					'PICTURES' => $pictures,
					'HIT' => $item['PROPERTY_HIT_VALUE'],
					'ACTION' => $item['PROPERTY_ACTION_VALUE'],
					'NEW' => $item['PROPERTY_NEW_VALUE'],
					'OFFERS' => $offers,
				);
				if ($item['CATALOG_PRICE_ID_1'])
					$return['PRICE'] = intval($item['CATALOG_PRICE_1']);

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
	 * @param bool|false $refreshCache
	 * @return array|mixed
	 */
	public static function getOffersByProduct($productId, $refreshCache = false)
	{
		$return = array();

		$extCache = new ExtCache(
			array(
				__FUNCTION__,
				$productId,
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
				$return[$item['ID']] = array(
					'ID' => $item['ID'],
					'COUNT' => $item['PROPERTY_COUNT_VALUE'],
					'ARTICLE' => $item['PROPERTY_OFFER_ARTICLE_VALUE'],
					'PRICE' => intval($item['CATALOG_PRICE_1']),
				);
			}

			uasort($arReturn, '\Local\Catalog\Products::countCmp');

			$extCache->endDataCache($return);
		}

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

		if (isset($_SESSION['usee']))
		{
			if (!in_array($productId, $_SESSION['usee'])) {
				$_SESSION['usee'][] = $productId;
			}
		}
	}

	public static function beforeSearchIndex($arFields)
	{
		$productId = intval($arFields['ITEM_ID']);
		if ($productId && array_key_exists('BODY', $arFields))
		{
			$product = self::getById($productId);
			foreach ($product['OFFERS'] as $offer)
				$arFields['BODY'] .= ' ' . $offer['ARTICLE'];
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
			$discounts = \CCatalogDiscount::GetDiscount(
				$productId,
				self::IB_PRODUCTS,
				array(1),
				array(2),
				'N',
				's1',
				array()
			);
			$discountPrice = \CCatalogProduct::CountPriceWithDiscount(
				intval($min),
				'RUB',
				$discounts
			);
			$iblockElement->SetPropertyValuesEx($productId, self::IB_PRODUCTS, array(
				'PRICE' => intval($discountPrice),
				'PRICE_WO_DISCOUNT' => intval($min),
				'PRICE_COUNT' => intval($count),
				'ACTION' => $discountPrice < $min ? 1 : 0,
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
			$discounts = \CCatalogDiscount::GetDiscount(
				$productId,
				self::IB_PRODUCTS,
				array(1),
				array(2),
				'N',
				's1',
				array()
			);
			$discountPrice = \CCatalogProduct::CountPriceWithDiscount(
				$item['PRICE_D'],
				'RUB',
				$discounts
			);
			if ($discountPrice != $item['PRICE'])
			{
				$iblockElement->SetPropertyValuesEx($productId, self::IB_PRODUCTS, array(
					'PRICE' => intval($discountPrice),
					'ACTION' => $discountPrice < $item['PRICE_D'] ? 1 : 0,
				));
				$clearCache = true;
			}
		}

		if ($clearCache)
			self::getAll(true);
	}

	/**
	 * Очищает кеш каталога
	 */
	public static function clearCatalogCache()
	{
		$phpCache = new \CPHPCache();
		$phpCache->CleanDir(static::CACHE_PATH . 'getAll');
		$phpCache->CleanDir(static::CACHE_PATH . 'getSimpleById');
		$phpCache->CleanDir(static::CACHE_PATH . 'get');
		$phpCache->CleanDir(static::CACHE_PATH . 'getById');
		$phpCache->CleanDir(static::CACHE_PATH . 'getOffersByProduct');
	}

}

