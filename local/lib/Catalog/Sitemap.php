<?
namespace Local\Catalog;

/**
 * Class Sitemap Генерация карты сайта
 * @package Local\Catalog
 */
class Sitemap
{
	protected $error;
	protected $filename;
	protected $fp;
	protected $url;

	/**
	 * Обновляет файл sitemap.xml
	 * @return bool
	 */
	public function start()
	{
		$this->url = 'http://cupcakestory.ru';
		$this->filename = $_SERVER["DOCUMENT_ROOT"] . '/sitemap.xml';

		$this->fp = $this->prepareFile($this->filename. '.tmp');
		if (!$this->fp)
		{
			$this->error = 'Ошибка создания файла';
			return false;
		}

		$this->preWrite();

		$data = $this->getStatic();
		$this->writeStatic($data);
		$data = Filter::getSiteMap();
		$this->write($data);

		$this->postWrite();
		$this->closeFile();

		unlink($this->filename);
		rename($this->filename. '.tmp', $this->filename);

		return true;
	}

	protected function prepareFile($filename)
	{
		CheckDirPath($filename);

		if ($fp = @fopen($filename, "w"))
			return $fp;
		else
			return false;
	}

	protected function preWrite()
	{
		@fwrite($this->fp, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
		@fwrite($this->fp, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"');
		@fwrite($this->fp, ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"');
		@fwrite($this->fp, ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"');
		@fwrite($this->fp, ">\n");
	}

	protected function writeStatic($data)
	{
		foreach ($data as $url => $p) {
			@fwrite($this->fp, "<url>\n");
			@fwrite($this->fp, "\t<loc>" . $this->url . $url . "</loc>\n");
			@fwrite($this->fp, "\t<priority>$p</priority>\n");
			@fwrite($this->fp, "</url>\n");
		}
	}

	protected function write($data)
	{
		foreach ($data as $url) {
			@fwrite($this->fp, "<url>\n");
			@fwrite($this->fp, "\t<loc>" . $this->url . $url . "</loc>\n");
			@fwrite($this->fp, "\t<priority>0.50</priority>\n");
			@fwrite($this->fp, "</url>\n");
		}
	}

	protected function postWrite()
	{
		@fwrite($this->fp, "</urlset>\n");
	}

	protected function closeFile()
	{
		@fclose($this->fp);
	}

	public function getError()
	{
		return $this->error;
	}

	private function getStatic()
	{
		return array(
			'/' => '1.00',
			'/contacts/' => '0.80',
			'/about/' => '0.80',
			'/celebrity-stories/' => '0.80',
			'/payment-and-shipment/' => '0.80',
			'/reviews/' => '0.80',
			'/sweet-table/' => '0.80',
			'/stati/' => '0.80',
			'/news/' => '0.80',
			'/news/alla_mikheeva/' => '0.64',
			'/news/so-vremenem-nastoyashchaya-lyubov-stanovitsya-silnee/' => '0.64',
			'/news/sladkaya-istoriya/' => '0.64',
			'/news/konkurs-ot-cupcake-story/' => '0.64',
			'/news/prazdnichnye-kapkeyki/' => '0.64',
			'/news/novyy-period-vlyublennosti-v-zhenu/' => '0.64',
			'/news/oksana-fedorova/' => '0.64',
		);
	}

}