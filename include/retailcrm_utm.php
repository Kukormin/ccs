<?
// umt info from intaro
if (!isset($_SESSION['retailcrm']))
{
	parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $urlData);

	$params = array();

	foreach ($urlData as $k => $v)
	{
		if ($k == 'utm_term' || $k == 'utm_content' || $k == 'utm_source' || $k == 'utm_medium' || $k == 'utm_campaign')
		{
			$params[$k] = $v;
		}
	}

	if (count($params) > 0)
	{
		$_SESSION['retailcrm'] = $params;
	}
}