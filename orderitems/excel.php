<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/orderitems/lib/RetailCrm/ApiClient.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/orderitems/lib/RetailCrm/Http/Client.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/orderitems/lib/RetailCrm/Response/ApiResponse.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/orderitems/lib/RetailCrm/Exception/CurlException.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/orderitems/lib/RetailCrm/Exception/InvalidJsonException.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/orderitems/ex/phpex/Classes/PHPExcel.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/orderitems/ex/phpex/Classes/PHPExcel/Writer/Excel5.php');
if ($USER->IsAuthorized() && $USER->IsAdmin()) {

    $dateFrom = trim(htmlspecialchars($_REQUEST['date_from']));
    $dateTo = trim(htmlspecialchars($_REQUEST['date_to']));
    $status = trim(htmlspecialchars($_REQUEST['status']));

    $apiKey = "GUdWqj3mIyFmUuXkL6H9br4VoPQrBzIS";
    $apiUrl = "https://cupcakestory.retailcrm.ru";

    $statuses = array(
        'new' => 'Новый',
        'v-proizvodstve' => 'В производстве',
        'ozidanie-dostavki' => 'Ожидание доставки',
        'send-to-delivery' => 'В доставке',
        'no-call' => 'Недозвон',
        'dostavlen' => 'Доставлен',
        'assembling-complete' => 'Укомплектован',
        'obrabotan' => 'Обработан',
        'cancel-other' => 'Отменен',
        'zayavka' => 'Заявка на производство',
        'fail-delivery-date' => 'Ошибка в день доставки',
        'presale' => 'Пресейл',
        'prop-zv' => 'Пропущенный звонок',
        'client-confirmed' => 'Согласование',
        'complete' => 'Выполнен'
    );

    $client = new \RetailCrm\ApiClient($apiUrl, $apiKey);
    $filter = array();

    if (isset($status)) {
        $filter['extendedStatus'] = array($status);
    }
    if (isset($dateTo)) {
        $filter['createdAtTo'] = $dateTo;
    }
    if (isset($dateFrom)) {
        $filter['createdAtFrom'] = $dateFrom;
    }
    try {
        $response = $client->ordersList($filter, 1, 100);
    } catch (\RetailCrm\Exception\CurlException $e) {
//        echo "Connection error: " . $e->getMessage();
    }

    if ($response->isSuccessful() && $pages = $response->pagination) {
        if (isset($pages['totalPageCount'])) {
            for ($page = 1; $page <= $pages['totalPageCount']; $page++) {
                try {
                    $response = $client->ordersList($filter, $page, 100);
                } catch (\RetailCrm\Exception\CurlException $e) {
//                    echo "Connection error: " . $e->getMessage();
                }
                $orders[] = $response->orders;
                time_nanosleep(0, 200000000);
            }
        }
    } else {
        if ($response->isSuccessful()) {
            $orders[] = $response->orders;
        } else {
//            echo sprintf(
//                "Error: [HTTP-code %s] %s",
//                $response->getStatusCode(),
//                $response->getErrorMsg()
//            );

        }
    }

    if (empty($orders)) {
        die("нет заказов");
    }
    $xls = new PHPExcel();
    $xls->setActiveSheetIndex(0);
    $sheet = $xls->getActiveSheet();
    $sheet->setTitle('Таблица умножения');

    $sheet->setCellValue("A1", 'Дата');
    $sheet->setCellValue("B1", 'номер заказа');
    $sheet->setCellValue("C1", 'статус');
    $sheet->setCellValue("E1", 'название товара');
    $sheet->setCellValue("D1", 'артикул');
    $sheet->setCellValue("F1", 'количество');
    $sheet->getColumnDimension('A')->setWidth(20);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(40);
    $sheet->getColumnDimension('F')->setWidth(10);

    $i = 2;
    foreach ($orders as $arorder) {
        foreach ($arorder as $order) {
            foreach ($order['items'] as $item) {
                $sheet->setCellValueByColumnAndRow(0, $i, $order['createdAt']);
                $sheet->setCellValueByColumnAndRow(1, $i, $order['number']);
                $sheet->setCellValueByColumnAndRow(2, $i, $statuses[$order['status']]);
                if (isset($item['offer']['xmlId'])) {
                    $sheet->setCellValueByColumnAndRow(3, $i, $item['offer']['xmlId']);
                } else {
                    $sheet->setCellValueByColumnAndRow(3, $i, 'отсутствует');
                }
                $sheet->setCellValueByColumnAndRow(4, $i, $item['offer']['name']);
                $sheet->setCellValueByColumnAndRow(5, $i, $item['quantity']);
                $sheet->getStyleByColumnAndRow(0, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(1, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(2, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(3, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(4, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyleByColumnAndRow(5, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $i++;
            }
        }
    }

    header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=CupcackeItems.xlsx");

// Выводим содержимое файла
    $objWriter = new PHPExcel_Writer_Excel2007($xls);
    $objWriter->save('php://output');
}