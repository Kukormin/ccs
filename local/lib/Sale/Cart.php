<?
namespace Local\Sale;

use Bitrix\Sale\Compatible\BasketCompatibility;
use Local\Catalog\Products;

/**
 * Class Cart Корзина
 * @package Local\Sale
 */
class Cart
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Sale/Cart/';

	/**
	 * Добавление товара (или предложения) в корзину
	 * @param $id
	 * @param $offer
	 * @param $quantity
	 * @return bool|int
	 */
	public static function add($id, $offer, $quantity)
	{
		$productId = intval($id);
		if ($productId <= 0)
			return false;

		$quantity = intval($quantity);
		if ($quantity <= 0)
			$quantity = 1;

		$product = Products::getById($productId);
		if (!$product)
			return false;

		$price = $product['PRICE'];
		$priceId = $product['PRICE_ID'];
		$xmlId = $productId;
		$props = array();

		$offerId = intval($offer);
		if ($offerId)
		{
			$offer = $product['OFFERS'][$offerId];
			if (!$offer)
				return false;

			$productId = $offerId;
			$price = $offer['PRICE'];
			$priceId = $offer['PRICE_ID'];
			$xmlId .= '#' . $offerId;

			$props[] = array(
				'NAME' => 'Количество',
				'CODE' => 'COUNT',
				'VALUE' => $offer['COUNT'],
			);
		}

		$packages = Package::getByCategory($product['CATEGORY']['ID']);
		if ($packages[0]['ID'])
			$props[] = array(
				'NAME' => 'Упаковка',
				'CODE' => 'PACKAGE',
				'VALUE' => $packages[0]['NAME'],
				'SORT' => $packages[0]['ID'],
			);

		$fields = array(
			"PRODUCT_ID" => $productId,
			"PRODUCT_PRICE_ID" => $priceId,
			"PRICE" => $price,
			"CURRENCY" => 'RUB',
			"QUANTITY" => $quantity,
			"LID" => SITE_ID,
			"DELAY" => "N",
			"CAN_BUY" => "Y",
			"NAME" => $product['NAME'],
			"MODULE" => "catalog",
			"DETAIL_PAGE_URL" => $product['DETAIL_PAGE_URL'],
			"CATALOG_XML_ID" => $product['ID'],
			"PRODUCT_XML_ID" => $xmlId,
			"VAT_INCLUDED" => 'Y',
		    "VAT_RATE" => '18',
		    "PROPS" => $props,
		);

		$basket = new \CSaleBasket();
		$basket->Init();
		if (!$basket->CheckFields('ADD', $fields))
			return false;

		$basketItem = BasketCompatibility::add($fields);
		if (!$basketItem)
			return false;

		$ID = $basketItem->getId();

		return $ID;
	}

	/**
	 * Добавляет упакову в корзину
	 * @param $pack
	 * @param $quantity
	 * @return bool|int
	 */
	public static function addPackage($pack, $quantity)
	{
		$quantity = intval($quantity);
		if ($quantity <= 0)
			$quantity = 1;

		$fields = array(
			"PRODUCT_ID" => $pack['ID'],
			"PRODUCT_PRICE_ID" => $pack['PRICE_ID'],
			"PRICE" => $pack['PRICE'],
			"CURRENCY" => 'RUB',
			"QUANTITY" => $quantity,
			"LID" => SITE_ID,
			"DELAY" => "N",
			"CAN_BUY" => "Y",
			"NAME" => $pack['NAME'],
			"MODULE" => "catalog",
			"DETAIL_PAGE_URL" => '',
			"CATALOG_XML_ID" => $pack['ID'],
			"PRODUCT_XML_ID" => $pack['ID'],
			"VAT_INCLUDED" => 'Y',
			"VAT_RATE" => '18',
		);

		$basket = new \CSaleBasket();
		$basket->Init();
		if (!$basket->CheckFields('ADD', $fields))
			return false;

		$basketItem = BasketCompatibility::add($fields);
		if (!$basketItem)
			return false;

		$ID = $basketItem->getId();

		return $ID;
	}

	/**
	 * Меняем упаковку для товара в корзине
	 * @param $bid
	 * @param $pid
	 * @return int
	 */
	public static function pack($bid, $pid)
	{
		$pack = Package::getById($pid);
		if (!$pack)
			return 0;

		$saleBasket = new \CSaleBasket();
		$rsProps = $saleBasket->GetPropsList(array(), array("BASKET_ID" => $bid));
		$props = array();
		while ($prop = $rsProps->Fetch())
		{
			$prop = array(
				'CODE' => $prop['CODE'],
				'NAME' => $prop['NAME'],
				'VALUE' => $prop['VALUE'],
				'SORT' => $prop['SORT'],
			);
			if ($prop['CODE'] == 'PACKAGE')
			{
				$prop['VALUE'] = $pack['NAME'];
				$prop['SORT'] = $pack['ID'];
			}
			$props[] = $prop;
		}

		if ($props)
		{
			$data = array(
				'PROPS' => $props,
			);
			$saleBasket->Update($bid, $data);

			return intval($pid);
		}

		return 0;
	}

	/**
	 * Замена предложения для товара
	 * @param $bid
	 * @param $oid
	 * @return int
	 */
	public static function offer($bid, $oid)
	{
		$saleBasket = new \CSaleBasket();
		$item = $saleBasket->GetByID($bid);

		$productId = $item['CATALOG_XML_ID'];
		$offerId = $item['PRODUCT_ID'];
		if (!$offerId)
			return 0;

		$product = Products::getById($productId);
		$offer = $product['OFFERS'][$oid];
		if (!$offer)
			return 0;

		$rsProps = $saleBasket->GetPropsList(array(), array("BASKET_ID" => $bid));
		$props = array();
		while ($prop = $rsProps->Fetch())
		{
			$prop = array(
				'CODE' => $prop['CODE'],
				'NAME' => $prop['NAME'],
				'VALUE' => $prop['VALUE'],
				'SORT' => $prop['SORT'],
			);
			if ($prop['CODE'] == 'COUNT')
			{
				$prop['VALUE'] = $offer['COUNT'];
			}
			$props[] = $prop;
		}

		if ($props)
		{
			$price = $offer['PRICE'];
			$priceId = $offer['PRICE_ID'];
			$data = array(
				'PRODUCT_ID' => $oid,
				'PRODUCT_XML_ID' => $productId . '#' . $oid,
				"PRODUCT_PRICE_ID" => $priceId,
				"PRICE" => $price,
				'PROPS' => $props,
			);
			$saleBasket->Update($bid, $data);

			return intval($oid);
		}

		return 0;
	}
}