<?
namespace Local\Catalog;

/**
 * Class Flags Простые свойства товаров
 */
class Flags
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Catalog/Flags/';

	private static $all = array(
		'Маркетинговые' => array(
			'new' => array(
				'CODE' => 'NEW',
				'NAME' => 'Новинка',
			    'MAP' => true,
			),
			'action' => array(
				'CODE' => 'ACTION',
				'NAME' => 'Акция',
				'MAP' => true,
			),
			'hit' => array(
				'CODE' => 'HIT',
				'NAME' => 'Хит',
				'MAP' => true,
			),
		),
		'Для кого' => array(
			'kids' => array(
				'CODE' => 'KIDS',
				'NAME' => 'Для детей',
			),
			'girl' => array(
				'CODE' => 'GIRL',
				'NAME' => 'Для девочек',
			),
			'boy' => array(
				'CODE' => 'BOY',
				'NAME' => 'Для мальчиков',
			),
			'woman' => array(
				'CODE' => 'WOMAN',
				'NAME' => 'Для неё',
			),
			'man' => array(
				'CODE' => 'MAN',
				'NAME' => 'Для него',
			),
			'love' => array(
				'CODE' => 'LOVE',
				'NAME' => 'Для влюблённых',
			),
		),
		'Размер' => array(
			'big' => array(
				'CODE' => 'BIG',
				'NAME' => 'Большой',
			),
			'small' => array(
				'CODE' => 'SMALL',
				'NAME' => 'Маленький',
			),
		),
		'Разное' => array(
			'fitness' => array(
				'CODE' => 'FITNESS',
				'NAME' => 'Фитнес',
			),
			'happy' => array(
				'CODE' => 'HAPPY',
				'NAME' => 'Happy Box',
				'MAP' => true,
			),
			'logo' => array(
				'CODE' => 'LOGO',
				'NAME' => 'С логотипом',
				'MAP' => true,
			),
			'classic' => array(
				'CODE' => 'CLASSIC',
				'NAME' => 'Классика',
			),
			'choice' => array(
				'CODE' => 'CHOICE',
				'NAME' => 'Наш выбор',
				'MAP' => true,
			),
		),
	);

	/**
	 * Возвращает все свойства
	 * @return array
	 */
	public static function getAll()
	{
		return self::$all;
	}

	/**
	 * Возвращает свойства в формате для селекта
	 * @return array
	 */
	public static function getForSelect()
	{
		$return = array();
		foreach (self::$all as $props)
		{
			foreach ($props as $prop)
				$return[] = 'PROPERTY_' . $prop['CODE'];
		}
		return $return;
	}

	/**
	 * Возвращает коды свойств
	 * @return array
	 */
	public static function getCodes()
	{
		$return = array();
		foreach (self::$all as $props)
		{
			foreach ($props as $prop)
				$return[] = $prop['CODE'];
		}
		return $return;
	}
}
