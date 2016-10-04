<?

namespace Local;

/**
 * Class Remarketing Динамический ремаркетинг Rating@Mail.ru
 * @package Local\Package
 */
class Remarketing
{
	/**
	 * @var string Тип страницы
	 */
	private static $pageType = 'other';

	/**
	 * @var array возможные типы страниц
	 */
	private static $types = array(
		'product',
		'home',
		'searchresults',
		'category',
		'cart',
		'purchase',
		'other',
	);

	/**
	 * @var array айдишники товаров
	 */
	private static $products = array();

	/**
	 * Общая стоимость товаров
	 * @var int
	 */
	private static $total = 0;

	/**
	 * Устанавливает тип страницы
	 * @param $type
	 */
	public static function setPageType($type)
	{
		if (in_array($type, self::$types))
			self::$pageType = $type;
	}

	/**
	 * Добавляет ID товара
	 * @param $id
	 */
	public static function addProductId($id)
	{
		$id = intval($id);
		self::$products[$id] = $id;
	}

	/**
	 * Устанавливает общую стоимость
	 * @param $value
	 */
	public static function setTotal($value)
	{
		self::$total = floatval($value);
	}

	public static function printHtml()
	{
		$products = '';
		$arr = false;
		foreach (self::$products as $id)
		{
			if ($products)
			{
				$products .= ',';
				$arr = true;
			}
			$products .= "'" . $id . "'";
		}
		if (!$products)
			$products = "''";
        elseif ($arr)
	        $products = "[" . $products . "]";

		$total = '';
		if (self::$total > 0)
			$total = number_format(self::$total, 2, '.', '');

		?>
<script type="text/javascript">var _tmr = _tmr || [];
_tmr.push({
type: 'itemView',
productid: <?= $products ?>,
pagetype: '<?= self::$pageType ?>',
list: '1',
totalvalue: '<?= $total ?>'
});
</script><?
	}

}