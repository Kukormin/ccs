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
	private $searchQuery = '';

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
	public $products = array();

	/**
	 * @inherit
	 */
	public function executeComponent()
	{
		//$this->arResult['AJAX'] = $_GET['request_mode'] == 'ajax';

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
			$this->filter = Filter::getData($this->searchIds);
			$this->products = Products::get($this->sort['QUERY'], $this->filter['PRODUCTS_IDS'], $this->navParams);
		}

		$this->SetPageProperties();

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
		if ($sortKey == 'shows')
			$sortQuery['SORT'] = $this->sort['ORDER'] == 'asc' ? 'desc' : 'asc';
		$sortQuery[$this->sortParams[$this->sort['KEY']]['FIELD']] = $this->sort['ORDER'];
		$this->sort['QUERY'] = $sortQuery;
		$this->sortParams[$this->sort['KEY']]['ORDER'] = $this->sort['ORDER'];

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
				'QUERY' => $this->arResult['QUERY'],
				'SITE_ID' => 's1',
				'MODULE_ID' => 'iblock',
				'PARAM1' => 'catalog',
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
		/*$seo = array();
		if ($this->arResult['QUERY'])
		{
			$seo['H1'] = 'Результаты поиска по запросу "' . $this->arResult['QUERY'] . '"';
			$seo['TITLE'] = $seo['H1'];
		}
		elseif ($this->arResult['FILTER'])
		{
			$seo = Seo::getByUrl($this->arResult['FILTER']['SEF_URL']);
			if (!$seo['H1'])
			{
				$seo['H1'] = $this->arResult['FILTER']['SEO']['H1'];
			}
			if (!$seo['TITLE'])
			{
				$seo['TITLE'] = $this->arResult['FILTER']['SEO']['TITLE'];
			}
			if (!$seo['KEYWORDS'])
			{
				$seo['KEYWORDS'] = $this->arResult['FILTER']['SEO']['KEYWORDS'];
			}
			if (!$seo['DESCRIPTION'])
			{
				$seo['DESCRIPTION'] = $this->arResult['FILTER']['SEO']['DESCRIPTION'];
			}

			if ($detailPicture = Seo::getDetailPictureByUrl($this->arResult['FILTER']['SEF_URL']))
			{
				$seo['DETAIL_PICTURE'] = $detailPicture;
			}
		}

		if ($this->arResult['PAGE']['PAGE'] > 1)
		{
			$seo['TEXT'] = '';
		}

		$this->arResult['SEO'] = $seo;*/
	}
}
