<?

namespace Local\Catalog;
use Bitrix\Main\Loader;

/**
 * Каталог
 */
class TimCatalog extends \CBitrixComponent
{
	/**
	 * Количество товаров на странице
	 */
	const PAGE_SIZE = 12;

	/**
	 * @var array параметры сортировки
	 */
	private $sortParams = array(
		'sort' => array(
			'ORDER_DEFAULT' => 'desc',
			'FIELD' => 'SORT',
			'DEFAULT' => true,
		    'NAME' => 'По-умолчанию',
		),
		'price' => array(
			'ORDER_DEFAULT' => 'asc',
			'FIELD' => 'PROPERTY_PRICE',
			'NAME' => 'По цене',
		),
		'shows' => array(
			'ORDER_DEFAULT' => 'desc',
			'FIELD' => 'shows',
			'NAME' => 'По популярности',
		),
		'date' => array(
			'ORDER_DEFAULT' => 'desc',
			'FIELD' => 'created',
			'NAME' => 'По новизне',
		),
	);

	/**
	 * @var array текущая сортировка
	 */
	private $sort;

	/**
	 * @var array параметры постранички
	 */
	public $navParams;

	/**
	 * @var string поисковый запрос
	 */
	public $searchQuery = '';

	/**
	 * @var array айдишники найденных товаров
	 */
	private $searchIds = array();

	/**
	 * @var array панель фильтров
	 */
	public $filter = array();

	/**
	 * @var array товары
	 */
	public $product = array();

	/**
	 * @var array товары
	 */
	public $products = array();

	/**
	 * @var array свойства SEO
	 */
	public $seo = array();

	/**
	 * @inherit
	 */
	public function executeComponent()
	{
		$url = urldecode($_SERVER['REQUEST_URI']);
		$urlDirs = explode('/', $url);
		$code = $urlDirs[3];
		if ($code && count($urlDirs) > 4)
			if (is_numeric($code))
				$this->product = Products::getById($code);
			else
				$this->product = Products::getByCode($code);

		if ($this->product)
		{
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
			}

			// Счетчик просмотренных
			Products::viewedCounters($this->arResult['PRODUCT']['ID']);*/
		}
		else
		{
			// Обработка входных данных (сортировка, постраничка...)
			$this->prepareParameters();

			// Поиск
			$empty = false;
			if ($this->searchQuery)
			{
				$this->searchIds = $this->search();
				if (!$this->searchIds)
					$empty = true;

				$this->arResult['NOT_FOUND'] = $empty;
			}

			if (!$empty)
			{
				$this->filter = Filter::getData($this->searchIds, $this->searchQuery);
				$this->products = Products::get($this->sort['QUERY'], $this->filter['PRODUCTS_IDS'], $this->navParams);
			}

			$this->SetPageProperties();
		}

		$this->includeComponentTemplate();
	}

	/**
	 * Подготовка и обработка параметров
	 */
	private function prepareParameters()
	{
		//
		// Поиск
		//
		$query = $_REQUEST['q'];
		$this->arResult['~QUERY'] = $query;
		$this->searchQuery = htmlspecialchars($query);

		//
		// Сортировка
		//
		$defaultSortKey = '';
		foreach ($this->sortParams as $key => $params)
		{
			if ($params['DEFAULT'])
				$defaultSortKey = $key;
			if (!$defaultSortKey)
				$defaultSortKey = $key;
		}

		$sortKey = $_REQUEST['sort'];
		$sortOrder = $_REQUEST['order'];
		$sortOrder = $sortOrder == 'asc' ? 'asc' : 'desc';
		// Если задано непосредственно
		if ($this->sortParams[$sortKey])
		{
			$this->sort = array(
				'KEY' => $sortKey,
				'ORDER' => $sortOrder,
			);
			$_SESSION['CATALOG']['SORT']['KEY'] = $sortKey;
			$_SESSION['CATALOG']['SORT']['ORDER'] = $sortOrder;
		}
		// Есть ли поиск?
		elseif ($this->searchQuery)
		{
			$this->sort = array(
				'KEY' => 'search',
				'ORDER' => 'asc',
			);
		}
		// Смотрим в сессии
		elseif ($_SESSION['CATALOG']['SORT']['KEY'])
		{
			$this->sort = array(
				'KEY' => $_SESSION['CATALOG']['SORT']['KEY'],
				'ORDER' => $_SESSION['CATALOG']['SORT']['ORDER'],
			);
		}
		// По-умолчанию
		else
		{
			$sortKey = $defaultSortKey;
			$this->sort = array(
				'KEY' => $sortKey,
				'ORDER' => $this->sortParams[$sortKey]['ORDER_DEFAULT'],
			);
		}
		$sortQuery = array();
		if ($this->sort['KEY'] == 'search')
		{
			$sortQuery['SEARCH'] = 'asc';
		}
		else
		{
			if ($sortKey == 'shows')
				$sortQuery['SORT'] = $this->sort['ORDER'] == 'asc' ? 'desc' : 'asc';
			$sortQuery[$this->sortParams[$this->sort['KEY']]['FIELD']] = $this->sort['ORDER'];
			$this->sortParams[$this->sort['KEY']]['ORDER'] = $this->sort['ORDER'];
		}
		$this->sort['QUERY'] = $sortQuery;

		//
		// Постраничная навигация
		//
		$page = $_REQUEST['page'];
		if (intval($page) <= 0)
			$page = 1;
		$this->navParams = array(
			'iNumPage' => $page,
			'nPageSize' => self::PAGE_SIZE,
		);
	}

	/**
	 * Обработка поискового запроса
	 * @throws \Bitrix\Main\LoaderException
	 */
	private function search()
	{
		$return = array();

		if (Loader::includeModule('search'))
		{
			$search = new \CSearch();
			$params = array(
				'QUERY' => $this->searchQuery,
				'SITE_ID' => 's1',
				'MODULE_ID' => 'iblock',
				'PARAM1' => 'new_catalog',
				'PARAM2' => array(
					Products::IB_PRODUCTS,
				),
			);
			$sort = array(
				'TITLE_RANK' => 'DESC',
				'CUSTOM_RANK' => 'DESC',
				'RANK' => 'DESC',
				'DATE_CHANGE' => 'DESC',
			);

			// Поиск с морфологией
			$search->Search($params, $sort);
			if ($search->errorno == 0)
			{

				while ($item = $search->GetNext())
					$return[$item['ITEM_ID']] = $item['ITEM_ID'];
			}
		}

		return $return;
	}

	/**
	 * Установка параметров страницы (заголовк, ключевые слова...)
	 */
	private function setPageProperties()
	{
		$this->seo = array();
		if ($this->searchQuery)
		{
			$this->seo = $this->filter['SEO'];
		}
		elseif ($this->filter)
		{
			$this->seo = Seo::getByUrl($this->filter['SEO']['URL']);
			$parts = $this->filter['SEO']['PARTS'];
			while (!$this->seo)
			{
				array_pop($parts);
				if (!$parts)
					break;

				$url = Filter::$CATALOG_PATH . implode('/', $parts) . '/';
				$seo = Seo::getByUrl($url);
				if ($seo['CHILDREN'])
					$this->seo = $seo;
			}

			if (!$this->seo['H1'])
				$this->seo['H1'] = $this->filter['SEO']['H1'];
			if (!$this->seo['TITLE'])
				$this->seo['TITLE'] = $this->filter['SEO']['TITLE'];
			if (!$this->seo['DESCRIPTION'])
				$this->seo['DESCRIPTION'] = $this->filter['SEO']['DESCRIPTION'];
		}
	}
}
