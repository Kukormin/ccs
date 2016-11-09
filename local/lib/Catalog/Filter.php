<?

namespace Local\Catalog;

use Local\System\ExtCache;

/**
 * Class Filter Панель фильтров, формирование свойств страницы, в зависимости от выбранных фильтров
 * @package Local\Catalog
 */
class Filter
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Catalog/Filter/';

	/**
	 * Разделитель вариантов в URL
	 */
	const SEPARATOR = ';';

	/**
	 * @var array Полная структура панели фильтров
	 */
	private static $GROUPS = array();

	/**
	 * @var array Фильтры для выборки товаров
	 */
	private static $FILTER_BY_KEY = array();

	/**
	 * @var array Информация по товарам, выбранным по фильтрам
	 */
	private static $DATA_BY_KEY = array();

	/**
	 * @var string Ключ фильтра для товаров
	 */
	private static $PRODUCTS_KEY = array();

	/**
	 * @var string Раздел каталога
	 */
	public static $CATALOG_PATH = '/cat/';

	/**
	 * @var string url, сформированный панелью фильтров
	 */
	private static $SEF_URL = '';

	/**
	 * @var array данные для Seo
	 */
	private static $SEO_VALUES = array();


	protected static $redirectsEnabled = true;

	public static function setRedirectsEnabled($flag)
	{
		static::$redirectsEnabled = (bool)$flag;
	}

	/**
	 * Возвращает данные для построения панели фильтров, хлебные крошки и ID отфильтрованных товаров
	 * @param array $searchIds товары, отфильтрованные поисковым запросом
	 * @return array
	 */
	public static function getData($searchIds = array())
	{
		// Получаем все свойства для фильтров
		// (Состояние, когда мы в корне каталога и ни один фильтр не выбран пользователем)
		self::$GROUPS = self::getGroups();

		// ------ Далее работа в случае, если выбран какой-нибудь фильтр -------
		// Помечаем выбранные пользователем варианты
		self::setChecked();
		// Формируем фильтры для каждого свойства, чтобы отсеять варианты с учетом пользовательских фильтров
		self::getUserFilter($searchIds);
		// Получаем товары для всех фильтров
		self::getProductsByFilters();
		// Проверяем на пустой результат и редиректим
		self::checkEmptyResult();
		// Скрываем варианты, которые не попали в пользовательский фильтр
		// (напр. в куртках не представлен бренд Asics)
		self::hideVars();
		// Формируем данные для Seo
		self::setSeoValues();

		$data = self::$DATA_BY_KEY[self::$PRODUCTS_KEY];

		// Возвращаем данные в компонент
		return array(
			// Данные для построения панели
			'GROUPS' => self::$GROUPS,
			// Базовый путь к каталогу
			'CATALOG_PATH' => self::$CATALOG_PATH,
			// Разделитель
			'SEPARATOR' => self::SEPARATOR,
			// Айдишники товаров
			'PRODUCTS_IDS' => $data['IDS'],
			// Красивый урл (по нему подгружаются SEO свойства)
			'SEF_URL' => self::$SEF_URL,
			// Хлебные крошки
			'BC' => self::getBreadCrumb(),
			// Хлебные крошки
			'CUR_FILTERS' => self::getCurrentFilters(),
			// Seo
			'SEO' => self::$SEO_VALUES,
		);
	}

	/**
	 * Возвращает все свойства, которые участвуют в фильтрации каталога
	 * @return array
	 */
	public static function getGroups()
	{
		$return = array();

		$return[] = array(
			'NAME' => 'Тип товара',
			'BC' => true,
		    'ITEMS' => Categories::getGroup(),
		);
		$flags = Flags::getAll();
		foreach ($flags as $name => $items)
			$return[] = array(
				'NAME' => $name,
				'ITEMS' => $items,
			);
		$return[] = array(
			'NAME' => 'Праздник',
			'BC' => true,
			'ITEMS' => Holidays::getGroup(),
		);
		$return[] = array(
			'NAME' => 'Цена',
			'TYPE' => 'price',
		);

		return $return;
	}

	/**
	 * По текущему URL определяет какие из вариантов фильтров нажаты
	 */
	private static function setChecked()
	{
		$url = urldecode($_SERVER['REQUEST_URI']);
		$urlDirs = explode('/', $url);
		self::$CATALOG_PATH = '/' . $urlDirs[1] . '/';

		$urlCodes = array();
		for ($i = 2; $i < count($urlDirs) - 1; $i++)
		{
			$parts = explode(self::SEPARATOR, $urlDirs[$i]);
			foreach ($parts as $part)
				$urlCodes[$part] = true;
		}

		foreach (self::$GROUPS as &$group)
		{
			if ($group['TYPE'] == 'price')
			{
				if (isset($_REQUEST['p-from']))
					$group['FROM'] = intval($_REQUEST['p-from']);
				if (isset($_REQUEST['p-to']))
					$group['TO'] = intval($_REQUEST['p-to']);
			}
			else
			{
				foreach ($group['ITEMS'] as $code => &$item)
				{
					if ($urlCodes[$code])
						$item['CHECKED'] = true;
				}
				unset($item);
			}
		}
		unset($group);
	}

	/**
	 * Формирует фильтры для каждого свойства, чтобы отсеять варианты с учетом пользовательских фильтров
	 * К примеру, пользователь выбрал капкейки на свадьбу.
	 * В итоге для разделов у нас должен сформироваться фильтр только по празднику "свадьба", для праздников -
	 * только по капкейками, а для всех остальных свойств - фильтр и по капкейкам и по "свадьбе"
	 * @param array $searchIds
	 */
	public static function getUserFilter($searchIds = array())
	{
		// Коды свойств, участвующие в фильтрации
		// По ключу _ALL будет фильтр по всем свойствам, т.е. итоговый фильтр для товаров
		$codes = array(
			'_ALL' => '_ALL',
		    'PRICE' => 'PRICE',
		);
		foreach (self::$GROUPS as $group)
		{
			foreach ($group['ITEMS'] as $item)
				$codes[$item['CODE']] = $item['CODE'];
		}

		// Формируем фильтры для каждого свойства, некоторые могут оказаться одинаковыми
		$filters = array();
		foreach ($codes as $code)
		{
			$filters[$code] = array(
				'KEY' => '',
				'DATA' => array(),
			);
			foreach (self::$GROUPS as $group)
			{
				if ($group['TYPE'] == 'price')
				{
					if ('PRICE' == $code)
						continue;

					if (isset($group['FROM']))
					{
						$filters[$code]['DATA']['PRICE']['FROM'] = $group['FROM'];
						$filters[$code]['KEY'] .= '|f#' . $group['FROM'];
					}
					if (isset($group['TO']))
					{
						$filters[$code]['DATA']['PRICE']['TO'] = $group['TO'];
						$filters[$code]['KEY'] .= '|t#' . $group['TO'];
					}
				}
				else
				{
					foreach ($group['ITEMS'] as $item)
					{
						if ($item['CODE'] == $code)
							continue;

						if ($item['CHECKED'])
						{
							if ($item['CODE'] == 'CATEGORY' || $item['CODE'] == 'HOLIDAY')
							{
								$filters[$code]['DATA'][$item['CODE']][$item['ID']] = $item['ID'];
								$filters[$code]['KEY'] .= '|' . $item['ID'];
							}
							else
							{
								$filters[$code]['DATA'][$item['CODE']] = true;
								$filters[$code]['KEY'] .= '|' . $item['CODE'];
							}
						}
					}
				}
			}
		}

		self::$FILTER_BY_KEY = array();
		foreach ($codes as $code)
		{
			$key = $filters[$code]['KEY'];
			self::$FILTER_BY_KEY[$key] = $filters[$code]['DATA'];
			if ($searchIds)
				self::$FILTER_BY_KEY[$key]['ID'] = $searchIds;
		}

		// Теперь полученные фильтры добавим обратно в свойства
		foreach (self::$GROUPS as &$group)
		{
			if ($group['TYPE'] == 'price')
				$group['KEY'] = $filters['PRICE']['KEY'];
			else
			{
				foreach ($group['ITEMS'] as &$item)
					$item['KEY'] = $filters[$item['CODE']]['KEY'];
				unset($item);
			}
		}
		unset($group);

		// Общий фильтр
		self::$PRODUCTS_KEY = $filters['_ALL']['KEY'];
	}

	/**
	 * Получаем ID товаров для всех фильтров
	 */
	public static function getProductsByFilters()
	{
		self::$DATA_BY_KEY = array();
		foreach (self::$FILTER_BY_KEY as $key => $filter)
			self::$DATA_BY_KEY[$key] = Products::getDataByFilter($filter);
	}

	/**
	 * Проверка на пустой результат и редирект если нужно
	 */
	public static function checkEmptyResult()
	{
		/*$filter = self::$FILTER_BY_KEY[self::$PRODUCTS_KEY];
		$tmpProducts = Products::getByFilter($filter);
		debugmessage($tmpProducts);
		if (!$tmpProducts)
		{
			$url = self::getResultUrl(true);

			if (static::$redirectsEnabled)
			{
				define('ERROR_404', 'Y');
				\CHTTP::SetStatus('404 Not Found');
			}
		}*/
	}

	/**
	 * Помечаем скрытыми варианты свойств, которых нет среди товаров, отфильтрованных пользователем
	 * (выставляем количество товаров FCNT, если оно = 0, то вариант считается скрытым)
	 */
	public static function hideVars()
	{
		foreach (self::$GROUPS as &$group)
		{
			$cntGroup = 0;

			if ($group['TYPE'] == 'price')
			{
				$data = self::$DATA_BY_KEY[$group['KEY']];
				$group['MIN'] = $data['PRICE']['MIN'];
				$group['MAX'] = $data['PRICE']['MAX'];
				$cntGroup = $group['MIN'] == $group['MAX'] ? 0 : 1;
			}
			else
			{
				foreach ($group['ITEMS'] as &$item)
				{
					$data = self::$DATA_BY_KEY[$item['KEY']];

					if ($item['CODE'] == 'CATEGORY' || $item['CODE'] == 'HOLIDAY')
						$item['CNT'] = intval($data[$item['CODE']][$item['ID']]);
					else
						$item['CNT'] = intval($data[$item['CODE']]);

					$cntGroup += $item['CNT'];
				}
				unset($item);
			}

			$group['CNT'] = $cntGroup;
		}
		unset($group);
	}

	/**
	 * Формирует массив для добавления в хлебные крошки
	 */
	private static function getBreadCrumb()
	{
		$href = self::$CATALOG_PATH;
		$return = array(
			array(
				'NAME' => 'Главная',
				'HREF' => '/',
			),
			array(
				'NAME' => 'Весь каталог',
				'HREF' => $href,
			),
		);

		foreach (self::$GROUPS as $group)
		{
			if (!$group['CNT'])
				continue;

			if (!$group['BC'])
				continue;

			$cnt = 0;
			$singleCode = '';

			foreach ($group['ITEMS'] as $code => $item)
			{
				if ($item['CHECKED'])
				{
					$singleCode = $code;
					$cnt++;
				}
			}

			if ($cnt == 1)
			{
				$item = $group['ITEMS'][$singleCode];
				$href .= $singleCode . '/';
				$return[] = array(
					'NAME' => $item['NAME'],
					'HREF' => $href,
				);
			}
		}

		return $return;
	}

	/**
	 * Формирует массив для добавления в хлебные крошки
	 */
	private static function getCurrentFilters()
	{
		$return = array();

		foreach (self::$GROUPS as $g1 => $group1)
		{
			if (!$group1['CNT'])
				continue;

			$href = self::$CATALOG_PATH;
			$name = '';
			foreach ($group1['ITEMS'] as $item)
			{
				if ($item['CHECKED'])
				{
					if ($name)
						$name .= ', ';
					$name .= $item['NAME'];
				}
			}
			if ($name)
			{
				foreach (self::$GROUPS as $g2 => $group2)
				{
					if ($g1 == $g2)
						continue;

					$part = '';
					foreach ($group2['ITEMS'] as $code => $item)
					{
						if ($item['CHECKED'])
						{
							if ($part)
								$part .= self::SEPARATOR;
							$part .= $code;
						}
					}
					if ($part)
						$href .= $part . '/';
				}

				$return[] = array(
					'NAME' => '<b>' . $group1['NAME'] . '</b>: ' . $name,
					'HREF' => $href,
				);
			}
		}

		return $return;
	}

	/**
	 * Формирует данные для Seo
	 */
	private static function setSeoValues()
	{
		$cats = '';
		$brand = '';
		$brandRus = '';
		$brandOnlyRus = '';
		$m = false;
		$w = false;
		$size = '';
		$sizeSuffix = ' размера';
		$color = '';
		$material = '';
		$season = '';
		$shoesType = '';
		$series = '';
		$seriesOnlyRus = '';
		$gender = '';
		foreach (self::$GROUPS as $group)
		{
			foreach ($group['PROPS'] as $prop)
			{
				if ($prop['CODE'] == 'PRICE')
					continue;

				foreach ($prop['VARS'] as $variant)
				{
					if ($variant['CHECKED'])
					{
						if ($prop['CODE'] == 'SECTION')
						{
							if ($cats)
								$cats .= ', ';
							$cats .= mb_strtolower($variant['NAME']);
						}
						if ($prop['CODE'] == 'FOR_M')
							$m = true;
						if ($prop['CODE'] == 'FOR_W')
							$w = true;
						if ($prop['CODE'] == 'BRAND')
						{
							if ($brand)
							{
								$brand .= ', ';
								$brandRus .= ', ';
							}
							$brand .= $variant['NAME'];
							$brandRus .= $variant['NAME'];
							if ($variant['ADD']['NAME_RUS'])
							{
								$brandRus .= ' (' . $variant['ADD']['NAME_RUS'] . ')';
								if ($brandOnlyRus)
									$brandOnlyRus .= ', ';
								$brandOnlyRus .= $variant['ADD']['NAME_RUS'];
							}
						}
						if ($prop['CODE'] == 'SIZE')
						{
							if ($size)
							{
								$size .= ', ';
								$sizeSuffix = ' размеров';
							}
							$size .= $variant['NAME'];
						}
						if ($prop['CODE'] == 'MAIN_COLOR')
						{
							if ($color)
								$color .= ', ';
							$color .= ($variant['ADD']['NAME_MULTI'] ? $variant['ADD']['NAME_MULTI'] : $variant['NAME']);
						}
						if ($prop['CODE'] == 'MATERIAL_UPPER')
						{
							if ($variant['ADD']['ID'] > 0)
							{
								$iblock = \CIBlockElement::GetList(array(), array('ID' => $variant['ADD']['ID']), false, false, array('IBLOCK_ID'))->Fetch();
								$iterator = \CIBlockElement::GetProperty($iblock['IBLOCK_ID'], $variant['ADD']['ID'], array(), array('CODE' => 'NAME_MULTI'))->Fetch();
								if (!empty($iterator['VALUE']))
								{
									$variant['ADD']['NAME_MULTI'] = $iterator['VALUE'];
								}
							}
							if ($material)
								$material .= ', ';
							$material .= ($variant['ADD']['NAME_MULTI'] ? $variant['ADD']['NAME_MULTI'] : $variant['NAME']);
						}
						if ($prop['CODE'] == 'SEASON')
						{
							$seasonVal = 'season';
							switch ($variant['NAME'])
							{
								case 'зима' :
									$seasonVal = 'зимние';
									break;
								case 'лето' :
									$seasonVal = 'летние';
									break;
								case 'весна/осень' :
									$seasonVal = 'демисезонные';
									break;
							}
							if ($season)
								$season .= ', ';
							$season .= $seasonVal;
						}
						if ($prop['CODE'] == 'VID_OBUVI')
						{
							if ($shoesType)
								$shoesType .= ', ';
							$shoesType .= $variant['NAME'];
						}
						if ($prop['CODE'] == 'SERIES')
						{
							foreach ($prop['VARS'] as $variant)
							{
								if ($variant['CHECKED'] > 0)
								{
									if (in_array($variant['NAME'], $seriesList))
										continue;
									$seriesList[] = $variant['NAME'];
									if ($series)
										$series .= ', ';
									$series .= $variant['NAME'];
									if ($seriesOnlyRus)
										$seriesOnlyRus .= ', ';
									$seriesOnlyRus .= $variant['ADD']['NAME_RUS'];
								}
							}
						}
						if ($prop['CODE'] == 'SALE')
						{
							$sale = true;
						}
						if ($prop['CODE'] == 'NEW')
						{
							$new = true;
						}
					}
				}
			}
		}
		$keywords = '';
		$description = '';
		$productsName = 'товары';
		$h1 = $cats;
		if ($m && !$w)
		{
			if ($h1)
				$h1 = 'мужские ' . $h1;
			else
				$h1 = 'мужские ' . $productsName;
			$gender = 'мужские';
		}
		if ($w && !$m)
		{
			if ($h1)
				$h1 = 'женские ' . $h1;
			else
				$h1 = 'женские ' . $productsName;
			$gender = 'женские';

		}
		$description = $h1 . ' ' . $brand . $description;
		if ($color)
		{
			$keywords .= $color . ' ';
		}
		if ($material)
		{
			$keywords .= $material . ' ';
		}
		if ($season)
		{
			$keywords .= $season . ' ';
		}
		if ($shoesType)
		{
			if ($h1)
				$h1 = $shoesType . ' ' . $h1;
			else
				$h1 = $shoesType . ' ' . $productsName;
			$keywords .= $shoesType . ' ';
			$description = $shoesType . ' ' . $description;
		}
		if ($season)
		{
			if ($h1)
				$h1 = $season . ' ' . $h1;
			else
				$h1 = $season . ' ' . $productsName;
			$description = $season . ' ' . $description;
		}
		if ($material)
		{
			if ($h1)
				$h1 = $material . ' ' . $h1;
			else
				$h1 = $material . ' ' . $productsName;
			$description = $material . ' ' . $description;
		}
		if ($color)
		{
			if ($h1)
				$h1 = $color . ' ' . $h1;
			else
				$h1 = $color . ' ' . $productsName;
			$description = $color . ' ' . $description;
		}
		$title = $h1;
		if ($brand)
			if ($h1)
			{
				$h1 .= ' ' . $brand;
				$title .= ' ' . $brand;
			}
			else
			{
				$h1 = $productsName . ' ' . $brand;
				$title = $productsName . ' ' . $brandRus;
			}
		if ($series)
			if ($h1)
			{
				$h1 .= ' ' . $series;
				$title .= ' ' . $series;
				$description .= ' ' . $series;
			}
			else
			{
				$h1 = $productsName . ' ' . $series;
				$title = $productsName . ' ' . $series;
				$description = $productsName . ' ' . $series;
			}
		if ($size)
			if ($h1)
			{
				$h1 .= ' ' . $size . $sizeSuffix;
				$title .= ' ' . $size . $sizeSuffix;
				$description .= ' ' . $size . $sizeSuffix;
			}
			else
			{
				$h1 = $productsName . ' ' . $size . $sizeSuffix;
				$title = $productsName . ' ' . $size . $sizeSuffix;
				$description = $productsName . ' ' . $size . $sizeSuffix;
			}

		if ($h1)
		{
			$title = 'Купить ' . $title . ($sale ? ' - распродажа в' : ($new ? ' - актуальные новинки в' : ' -')) . ' Street Beat';
			$description = ($sale ? 'Скидки на ' : '') . $description . ($new ? ' из новой коллекции ' : '');
			$description .= ' в Сети фирменных магазинов Street Beat';
			$h1 = ($sale ? 'Скидки на ' : '') . $h1 . ($new ? ' из новой коллекции ' : '');
		}
		else
		{
			$h1 = 'Каталог';
			$title = 'Каталог товаров';
			$description = 'Каталог товаров StreetBeat';
		}

		if ($gender)
		{
			$keywords .= $gender . ' ';
		}
		if ($productsName)
		{
			$keywords .= $cats . ' ';
		}
		if ($brand)
		{
			$keywords .= $brand . ' ';
		}
		if ($brandOnlyRus)
		{
			$keywords .= $brandOnlyRus . ' ';
		}
		if ($series)
		{
			$keywords .= $series . ' ';
		}
		if ($seriesOnlyRus)
		{
			$keywords .= $seriesOnlyRus . ' ';
		}
		if ($size)
		{
			$keywords .= $size . $sizeSuffix . ' ';
		}
		$keywords .= 'купить продажа цена интернет магазин';
		if ($sale)
			$keywords .= ' распродажа акции скидки';
		if ($new)
			$keywords .= ' новые новинки коллекции';

		$keywords = str_replace(',', '', $keywords);

		$keywords = mb_strtoupper(substr($keywords, 0, 1)) . substr($keywords, 1);
		$h1 = mb_strtoupper(substr($h1, 0, 1)) . substr($h1, 1);

		$description = mb_strtoupper(substr($description, 0, 1)) . substr($description, 1);

		self::$SEO_VALUES = array(
			'H1' => $h1,
			'TITLE' => $title,
			'KEYWORDS' => $keywords,
			'DESCRIPTION' => $description,
		);
	}

	/**
	 * Для всех свойств выставляем фильтр по ID заданного товара
	 * @param $productId
	 */
	public static function getUserFilterForProduct($productId)
	{
		foreach (self::$GROUPS as &$group)
		{
			foreach ($group['PROPS'] as &$prop)
			{
				$prop['FILTER'] = array(
					'ID' => array($productId => $productId),
				);
			}
			unset($prop);
		}
		unset($group);
	}

	public static function getBreadCrumbsByProduct($productId)
	{
		// Получаем все свойства для фильтров
		// (Состояние, когда мы в корне каталога и ни один фильтр не выбран пользователем)
		self::getGroupsWithVars();

		// Формируем фильтры для каждого свойства, по заданному ID товара
		self::getUserFilterForProduct($productId);
		// Скрываем варианты, которые не попали в пользовательский фильтр
		self::hideVars();

		$sefUrl = self::$CATALOG_PATH;
		$return = array(
			array(
				'NAME' => 'Каталог',
				'HREF' => $sefUrl,
			),
		);
		$params = array();
		$man = false;
		foreach (self::$GROUPS as $group)
		{
			if (!$group['FCNT'])
				continue;

			foreach ($group['PROPS'] as $prop)
			{
				if (!$prop['FCNT'])
					continue;
				if ($prop['CODE'] == 'FOR_W' && $man)
					continue;

				if ($prop['ADD']['BREAD'])
				{
					foreach ($prop['VARS'] as $variant)
					{
						if ($prop['USER_TYPE'] == 'SASDCheckboxNum' && $variant['VALUE'] == 0)
							continue;

						if ($variant['FCNT'])
						{
							if ($prop['CODE'] == 'FOR_M')
								$man = true;

							if ($prop['ADD']['IN_URL'] && $variant['CODE'])
								$sefUrl .= $variant['CODE'] . '/';
							else
							{
								$sign = $prop['MULTI'] ? '[]=' : '=';
								$params[] = $prop['ADD']['URL_PARAM'] . $sign . $variant['ID'];
							}

							$href = $sefUrl;
							if ($params)
								$href .= '?' . implode('&', $params);
							$return[] = array(
								'NAME' => $variant['NAME'],
								'HREF' => $href,
							);
						}
					}
				}
			}
		}

		return $return;
	}

	/**
	 * Очищает кеш, связанный с товарами каталога
	 */
	public static function clearCatalogCache()
	{
		$phpCache = new \CPHPCache();
		$phpCache->CleanDir(static::CACHE_PATH . 'getGroupsWithVars');
	}

}