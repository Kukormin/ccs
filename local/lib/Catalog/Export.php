<?
namespace Local\Catalog;

/**
 * Class Export Экспорт каталога
 * @package Local\Catalog
 */
class Export
{

	protected $error;
	protected $filename;
	protected $fp;
	protected $url;

	public function start()
	{
		$this->url = 'http://cupcakestory.ru';
		$this->filename = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/catalog_export/intarocrm1.xml';

		$this->fp = $this->prepareFile($this->filename. '.tmp');
		if (!$this->fp)
		{
			$this->error = 'Ошибка создания файла';
			return false;
		}

		$this->preWriteCatalog();

		$data = Products::export();
		$this->writeCategories($data['CAT']);
		$this->writeOffers($data['OFFERS']);

		$this->postWriteCatalog();
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

	protected function prepareValue($text)
	{
		$newText = strip_tags($text);
		$newText = str_replace("&", "&#x26;", $newText);
		return $newText;
	}

	protected function preWriteCatalog()
	{
		@fwrite($this->fp, "<yml_catalog date=\"" . $this->prepareValue(Date("Y-m-d H:i:s")) . "\">\n");
		@fwrite($this->fp, "<shop>\n");
		@fwrite($this->fp, "\t<name>Cupcakestory</name>\n");
		@fwrite($this->fp, "\t<company>Cupcakestory</company>\n");
	}

	protected function writeCategories($categories)
	{
		@fwrite($this->fp, "\t<categories>\n");
		foreach ($categories as $category) {
			@fwrite($this->fp, "\t\t<category id=\"" . $category['ID'] . "\">"
				. $this->prepareValue($category['NAME']) . "</category>\n");
		}
		@fwrite($this->fp, "\t</categories>\n");
	}

	protected function writeOffers($offers)
	{
		@fwrite($this->fp, "\t<offers>\n");
		foreach ($offers as $offer)
			@fwrite($this->fp, $this->getOfferString($offer));
		@fwrite($this->fp, "\t</offers>\n");
	}

	protected function getOfferString($offer)
	{
		$res = "\t\t";
		$res .= '<offer id="' . $offer['ID'] . '" productId="' . $offer['PRODUCT_ID'] . '" quantity="0">' . "\n";

		if ($offer['PRODUCT_ACTIVE'] == 'N')
			$res .= "\t\t\t<productActivity>N</productActivity>\n";

		$res .= "\t\t\t<picture>" . $this->url . $this->PrepareValue($offer['PICTURE']) . "</picture>\n";
		$res .= "\t\t\t<url>" . $this->url . $this->PrepareValue($offer['DETAIL_PAGE_URL']) . "</url>\n";
		$res .= "\t\t\t<price>" . $offer['PRICE'] . "</price>\n";
		$res .= "\t\t\t<categoryId>" . $offer['CATEGORY_ID'] . "</categoryId>\n";
		$res .= "\t\t\t<categoryName>" . $this->PrepareValue($offer['CATEGORY_NAME']) . "</categoryName>\n";
		$res .= "\t\t\t<name>" . $this->PrepareValue($offer['NAME']) . "</name>\n";
		$res .= "\t\t\t<productName>" . $this->PrepareValue($offer['PRODUCT_NAME']) . "</productName>\n";

		if ($offer['ARTICLE'])
		{
			$res .= "\t\t\t<param name=\"article\">" . $this->PrepareValue($offer['ARTICLE']) . "</param>\n";
			$res .= "\t\t\t<xmlId>" . $this->PrepareValue($offer['ARTICLE']) . "</xmlId>\n";
		}

		$res .= "\t\t</offer>\n";

		return $res;
	}

	protected function postWriteCatalog()
	{
		@fwrite($this->fp, "</shop>\n</yml_catalog>\n");
	}

	protected function closeFile()
	{
		@fclose($this->fp);
	}

	public function getError()
	{
		return $this->error;
	}

}