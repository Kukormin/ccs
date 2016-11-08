<?

namespace Local\Catalog;

/**
 * Карточка товара
 */
class TimCatalogElement extends \CBitrixComponent
{
	/**
	 * @var array товар
	 */
	public $product = array();

	/**
	 * @inherit
	 */
	public function executeComponent()
	{
		//$this->arResult['AJAX'] = $_GET['request_mode'] == 'ajax';

		$url = urldecode($_SERVER['REQUEST_URI']);
		$urlDirs = explode('/', $url);
		$code = $urlDirs[2];

		if (is_numeric($code))
			$this->product = Products::getById($code);
		else
			$this->product = Products::getByCode($code);


		/*$this->arResult['IN_BASKET'] = false;

		if (
			!empty($this->arResult['PRODUCT']['OFFERS'])
			&& Loader::includeModule('sb.main')
		)
		{
			$this->arResult['IN_BASKET'] = (BasketTable::getList(array(
				'filter' => array(
					'FUSER_ID' => CSaleBasket::GetBasketUserID(),
					'=ORDER_ID' => false,
					'=PRODUCT_ID' => array_keys($this->arResult['PRODUCT']['OFFERS'])
				),
				'limit' => 1
			))->getSelectedRowsCount() > 0);
		}*/

		if ($this->product)
		{
			/*$this->arResult['BC'] = Filter::getBreadCrumbsByProduct($this->arResult['PRODUCT']['ID']);
            //Добавление в breadCrumb серии
            $iterator = \CIBlockElement::GetList(array(),array('ID' => $this->arResult['PRODUCT']['ID'], false, false, array('IBLOCK_ID')))->Fetch();
            $prop = \CIBlockElement::GetProperty($iterator['IBLOCK_ID'],$this->arResult['PRODUCT']['ID'], false, false, array('CODE' => 'SERIES'))->Fetch();
            if ($prop['VALUE'] > 0)
            {
                $propVal = \CIBlockElement::GetByID($prop['VALUE'])->Fetch();
                if ($propVal['CODE'])
                {
                    $pos = count($this->arResult['BC']) - 1;
                    $this->arResult['BC'][] = array(
                        'NAME' =>   $propVal['NAME'],
                        'HREF' => $this->arResult['BC'][$pos]['HREF'].$propVal['CODE'].'/'
                    );
                }
            }

			$this->arResult['BC'][] = array('NAME' => $this->arResult['PRODUCT']['NAME'] . ' ' . $this->arResult['PRODUCT']['BRAND'] );
			$this->arResult['RECOMMENDATIONS'] = Products::getRecommendations($this->arResult['PRODUCT']);
			// Счетчик просмотренных
			Products::viewedCounters($this->arResult['PRODUCT']['ID']);*/
		}

		$this->includeComponentTemplate();
	}

}
