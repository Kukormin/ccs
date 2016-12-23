<?
namespace Local\Catalog;

/**
 * Class Suspended Приостановленные для продажи товары
 * @package Local\Catalog
 */
class Suspended
{

	public static function getAll()
	{
		$return = array(
			3508, 3793, 3388, 3783, 3752, 3737, 3747, 3667, 3677, 3712, 3722, 3657, 3717,
			3488, 3773, 3382, 3768, 3438, 3763, 3443, 3687, 3448, 3692, 3453, 3652, 3473, 3647, 3458, 3647,
			3377, 3697, 3352, 3662, 3287, 3282, 3277, 3195, 3069, 3064, 3074, 3115, 3105, 3175, 3044,
		);

		return $return;
	}

	public static function check($id)
	{
		$id = intval($id);
		$all = self::getAll();
		return !in_array($id, $all);
	}

}