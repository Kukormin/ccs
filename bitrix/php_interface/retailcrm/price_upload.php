<?php
define('NO_AGENT_CHECK', true);
define('NO_KEEP_STATISTIC', true);
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../../..';
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require(__DIR__ . '/vendor/autoload.php');

CModule::IncludeModule('catalog');
CModule::IncludeModule('iblock');

use \RetailCrm\ApiClient;
use \RetailCrm\Http\Client;

/**
 * Добавил методы работы с типами цен
 */
Class ApiClientExt extends ApiClient {

    /**
     * Upload prices
     *
     * @param array  $data offers data
     * @param string $site   (default: null)
     *
     * @throws \InvalidArgumentException
     * @throws \RetailCrm\Exception\CurlException
     * @throws \RetailCrm\Exception\InvalidJsonException
     *
     * @return ApiResponse
     */
    public function pricesUpload(array $data, $site = null)
    {
        if (!count($data)) {
            throw new \InvalidArgumentException(
                'Parameter `data` must contains array of the prices'
            );
        }

        return $this->client->makeRequest(
            '/store/prices/upload',
            Client::METHOD_POST,
            $this->fillSite($site, array('prices' => json_encode($data)))
        );
    }

    /**
     * Returns prices list
     *
     * @throws \InvalidArgumentException
     * @throws \RetailCrm\Exception\CurlException
     * @throws \RetailCrm\Exception\InvalidJsonException
     *
     * @return ApiResponse
     */
    public function pricesList()
    {
        return $this->client->makeRequest(
            '/reference/price-types',
            Client::METHOD_GET
        );
    }


    /**
     * Edit store
     *
     * @param array $data site data
     *
     * @throws \InvalidArgumentException
     * @throws \RetailCrm\Exception\CurlException
     * @throws \RetailCrm\Exception\InvalidJsonException
     *
     * @return ApiResponse
     */
    public function pricesEdit(array $data)
    {
        if (!array_key_exists('code', $data)) {
            throw new \InvalidArgumentException(
                'Data must contain "code" parameter.'
            );
        }

        if (!array_key_exists('name', $data)) {
            throw new \InvalidArgumentException(
                'Data must contain "name" parameter.'
            );
        }

        return $this->client->makeRequest(
            sprintf('/reference/price-types/%s/edit', $data['code']),
            Client::METHOD_POST,
            array('priceType' => json_encode($data))
        );
    }
}

$api_host     = COption::GetOptionString('intaro.intarocrm', 'api_host', 0);
$api_key      = COption::GetOptionString('intaro.intarocrm', 'api_key', 0);
$basePriceId  = COption::GetOptionString('intaro.intarocrm', 'catalog_base_price', 1);
$currencyCode = CCurrency::GetBaseCurrency();

$api = new ApiClientExt($api_host, $api_key);

// выгрузка типов цен
$dbDiscounts = CCatalogDiscount::GetList();

$allDiscounts = [];
$time = time();

while ($arDiscount = $dbDiscounts->Fetch()) {
    if (isset($allDiscounts[$arDiscount['ID']])) {
        continue;
    }

    $allDiscounts[$arDiscount['ID']] = $arDiscount;

    $activeTo = strtotime($arDiscount['ACTIVE_TO']);
    $activeFrom = strtotime($arDiscount['ACTIVE_FROM']);

    $data = [
        'code' => $arDiscount['ID'],
        'name' => $arDiscount['NAME'],
        'active' => ($arDiscount['ACTIVE'] == 'Y' && (! $activeFrom || $activeFrom <= $time) && (! $activeTo || $activeTo > $time)),
        'ordering' => $arDiscount['SORT']
    ];

    try{
        $res = $api->pricesEdit($data);
    } catch (\RetailCrm\CurlException $e) {
        ICrmOrderActions::eventLog(
            'retailcrm_price_upload',
            'RetailCrm\ApiClient::pricesEdit::CurlException',
            $e->getCode() . ': ' . $e->getMessage()
        );
    }
}

// выгрузка цен
$dbProducts = CIBlockElement::GetList(
    [],
    ['IBLOCK_TYPE' => 'catalog'],
    false,
    false,
    ['ID', 'CATALOG_GROUP_' . $basePriceId]
);

while ($arProduct = $dbProducts->Fetch()) {
    $arDiscounts = CCatalogDiscount::GetDiscountByProduct(
        $arProduct['ID'],
        [],
        "N",
        [],
        "s1"
    );

    if (empty($arDiscounts)) continue;

    $dbOffers = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => [34,39,41,31,23,15], 'IBLOCK_TYPE' => 'offers', 'PROPERTY_CML2_LINK' => $arProduct['ID']],
        false,
        false,
        ['ID', 'PARENT_ID', 'CATALOG_GROUP_' . $basePriceId]
    );

    while ($arOffer = $dbOffers->Fetch()) {
        $arOffer['PARENT_ID'] = $arProduct['ID'];
        $priceId = $arOffer['CATALOG_PRICE_ID_' . $basePriceId];
        $price = $arOffer['CATALOG_PRICE_' . $basePriceId];
        $prices = [];
        foreach ($arDiscounts as $arDiscount) {
            $prices[$arDiscount['ID']] = CCatalogProduct::CountPriceWithDiscount($price, $currencyCode, [$arDiscount]);
        }

        $allProducts[$arOffer['ID']] = $prices;
    }

    if ($arProduct['CATALOG_PRICE_' . $basePriceId]) {
        $prices = [];
        foreach ($arDiscounts as $arDiscount) {
            $prices[$arDiscount['ID']] = CCatalogProduct::CountPriceWithDiscount($price, $currencyCode, [$arDiscount]);
        }

        $allProducts[$arProduct['ID']] = $prices;
    }
}
echo "<pre>";print_r($allProducts);echo "</pre>";
$allProducts = array_chunk($allProducts, 250, true);

foreach ($allProducts as $chunk) {
    $data = [];
    foreach ($chunk as $productId => $prices) {
        $d = ['externalId' => $productId, 'site' => '7718300028'];

        foreach ($prices as $discountId => $price) {
            $d['prices'][] = ['code' => $discountId, 'price' => $price];
        }
        $data[] = $d;
    }

    try{
        $res = $api->pricesUpload($data);
    } catch (\RetailCrm\CurlException $e) {
        ICrmOrderActions::eventLog(
            'retailcrm_price_upload',
            'RetailCrm\ApiClient::pricesUpload::CurlException',
            $e->getCode() . ': ' . $e->getMessage()
        );
    }

    unset($data);
}

