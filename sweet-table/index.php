<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Заказать сладкий стол для детей | сладкий стол на праздник");
$APPLICATION->SetPageProperty("description", "В нашем интернет-магазине Вы можете заказать сладкий стол для детей после которого они не останутся равнодушными. Так же возможно заказать сладкий стол на праздник и день рождения.");
$APPLICATION->SetTitle("Заказать сладкий стол для детей");
?>
    <style>
        .new_descr ul {
            list-style: initial;
            margin: 10px;
            margin-left: 30px;
        }

        h2 {
            font-family: 'PTSansRegular', sans-serif;
            font-size: 21px !important;
            font-weight: bold;
            text-align: left;
            margin: 10px 0 !important;
        }

        h3 {
            font-family: 'PTSansRegular', sans-serif;
            font-size: 19px;
        }

        h4 {
            font-family: 'PTSansRegular', sans-serif;
            font-size: 17px;
        }

        h1 {
            font-size: 30px;
            line-height: 30px;
            font-family: 'Lasco Bold', sans-serif;
            text-transform: uppercase;
            color: #22303d;
        }

        .new_descr p {
            text-align: justify;
            color: #22303d;
            font-size: 14px;
            line-height: 25px;
            font-family: 'PTSansRegular', sans-serif;
        }

        .new_descr {
            margin-top: 50px;
            text-align: justify;
            color: #22303d;
            font-size: 14px;
            line-height: 25px;
            font-family: 'PTSansRegular', sans-serif;
        }

        .hide_table.hidden {
            margin: auto;
            margin-bottom: 0px;
            height: 210px !important;
            padding-bottom: 0px;
        }

        .hide_table {
            transition: 1s all;
            position: relative;
            overflow: hidden;
            padding-bottom: 76px;
        }

        .moar {
            display: block;
            height: 130px;
            width: 100%;
            bottom: 0px;
            position: absolute;
            color: #000000;
            font-size: 20px;
            text-align: center;
            padding-top: 100px;
            box-sizing: border-box;
            background: linear-gradient(to top, #f2f1ec, rgba(65, 82, 95, 0));
            cursor: pointer;
            text-shadow: #f2f1ec 0px 0px 11px;
            font-family: 'PTSansRegular', sans-serif;
        }

        .warning {
            font-family: 'PTSansRegular';
            font-size: 18px;
            color: #22303d;
            text-align: center;
            margin-top: 22px;
        }
    </style>
    <section class="b-topblock b-topblock--pay-ship">
    </section>


    <div class="b-sweet-table-text">
        <div class="b-sweet-table-top-text__title">
			<? $APPLICATION->IncludeFile('/include/sweet_table_title_inc.php', [],
				[
					'MODE' => 'html',
					'TEMPLATE' => 'page_inc.php',
				]
			); ?>
        </div>

		<? $APPLICATION->IncludeComponent(
			"bitrix:photogallery",
			"cupcake_gallery_sweet",
			[
				"ADDITIONAL_SIGHTS" => "",
				"ALBUM_PHOTO_SIZE" => "120",
				"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "A",
				"COMPONENT_TEMPLATE" => "cupcake_gallery_sweet",
				"DATE_TIME_FORMAT_DETAIL" => "d.m.Y",
				"DATE_TIME_FORMAT_SECTION" => "d.m.Y",
				"DRAG_SORT" => "N",
				"ELEMENTS_PAGE_ELEMENTS" => "50",
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_ORDER" => "desc",
				"IBLOCK_ID" => "20",
				"IBLOCK_TYPE" => "gallery",
				"JPEG_QUALITY" => "100",
				"JPEG_QUALITY1" => "100",
				"ORIGINAL_SIZE" => "1280",
				"PAGE_NAVIGATION_TEMPLATE" => "",
				"PATH_TO_FONT" => "default.ttf",
				"PATH_TO_USER" => "",
				"PHOTO_LIST_MODE" => "Y",
				"SECTION_PAGE_ELEMENTS" => "15",
				"SECTION_SORT_BY" => "UF_DATE",
				"SECTION_SORT_ORD" => "DESC",
				"SEF_MODE" => "N",
				"SET_TITLE" => "N",
				"SHOWN_ITEMS_COUNT" => "50",
				"SHOW_LINK_ON_MAIN_PAGE" => [0 => "comments",],
				"SHOW_NAVIGATION" => "N",
				"SHOW_TAGS" => "N",
				"THUMBNAIL_SIZE" => "100",
				"UPLOAD_MAX_FILE_SIZE" => "4",
				"USE_COMMENTS" => "N",
				"USE_LIGHT_VIEW" => "Y",
				"USE_RATING" => "N",
				"USE_WATERMARK" => "Y",
				"VARIABLE_ALIASES" => ["SECTION_ID" => "SECTION_ID", "ELEMENT_ID" => "ELEMENT_ID", "PAGE_NAME" => "PAGE_NAME", "ACTION" => "ACTION",],
				"WATERMARK_MIN_PICTURE_SIZE" => "800",
				"WATERMARK_RULES" => "USER",
			]
		); ?>

        <div class="b-sweet-table-top-text__sub">
             <span class="b-sweet-table-top-text__sub-item">
                    <? $APPLICATION->IncludeFile('/include/sweet_table_text_inc.php', [],
                        [
                            'MODE' => 'html',
                            'TEMPLATE' => 'page_inc.php',
                        ]
                    ); ?>
             </span>
        </div>
    </div>

<? $APPLICATION->IncludeComponent(
	"custom:main.feedback",
	"cupcake_sweet_table",
	[
		"COMPONENT_TEMPLATE" => "cupcake_sweet_table",
		"EMAIL_TO" => "zakaz@cupcakestory.ru",
		"EVENT_MESSAGE_ID" => [0 => "39",],
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => "",
		"USE_CAPTCHA" => "Y",
	]
); ?>

    <div class="new_descr"
         style="width:1100px; text-align: justify; color: #22303d; font-size: 14px; line-height: 25px; font-family: 'PTSansRegular', sans-serif; margin: auto;">
        <h2>Сладкий стол — чудесный подарок от Cupcake Story</h2>
        <p>
            Если вы хотите накрыть сладкий стол на 10 – 30 человек и устроить незабываемый детский праздник, заказывайте
            торжество под ключ в Cupcake Story. В услугу «все включено» входят сладости ручной работы, декорированные в
            лучших традициях кондитерской семьи Жуковых, и оформление в выбранной цветовой гамме. Стол, посуда и
            скатерть предоставляются на условиях аренды.
        </p>
        <p>
            В стоимость также входят бонусные предложения: монтаж и демонтаж экспозиции с участием дизайнера и
            декоратора и доставка кондитерских изделий и расходных материалов по Москве.
        </p>
        <h2>Что будет на сладком столе?</h2>
        <p>
            Боитесь, что сладкий стол для детей покажется не слишком интересным? Эта возможность исключена. Мы подобрали
            самые любимые лакомства, которые порадуют и девчонок, и мальчишек. В комплект входят:
        </p>
        <p>
            · эклеры с различными вкусами;
        </p>
        <p>
            · капкейки, декорированные под формат мероприятия;
        </p>
        <p>
            · безе и карамель на палочке;
        </p>
        <p>
            · медово-имбирные пряники с сахарной глазурью.
        </p>
        <p>
            Сладкий стол на праздник будет состоять исключительно из полезных пирожных. Мы знаем, насколько меняется
            вкус кондитерских изделий, когда вместо усилителей вкуса и маргарина в составе натуральные ингредиенты:
            сливочное масло, мед, орехи, молоко, свежие ягоды и фрукты. Плюс к этому — яркий, запоминающийся декор из
            сахарной мастики и шоколада.
        </p>
        <h2>Когда накрывать сладкий стол?</h2>
        <p>
            Сладкий стол можно заказать не только на день рождения. Поводов для веселья, если подумать, масса:
        </p>
        <p>
            · утренники и школьные праздники;
        </p>
        <p>
            · Новый год и Хеллоуин;
        </p>
        <p>
            · окончание года/четверти на «отлично».
        </p>
        <p>
            Главное, что вы получаете — радость общения и безупречное торжество, которое останется в памяти надолго. Не
            забудьте камеру. Единственный способ наблюдать пирожные и эклеры дольше, чем 5 минут, — сфотографировать
            сладкий стол для детей до мероприятия.
        </p>
        <p>
            Хотим предупредить. Сделать заказ на оформление торжества необходимо за 7 дней. В противном случае вы можете
            остаться без сладостей. Решили накрыть сладкий стол на день рождения — заказывайте его в три шага:
        </p>
        <p>
            1) оформите покупку на сайте через корзину или по телефону;
        </p>
        <p>
            2) согласуйте объем заказа и декор с менеджером;
        </p>
        <p>
            3) ждите оформителя в день торжества.
        </p>
        <p>
            Вы доверяете нам, а мы делаем праздничные мероприятия ярче.
        </p>
    </div>
    <script>
        var hideTables = $(".new_descr");
        hideTables = $.map(hideTables, function (value, index) {
            return [value]
        });
        hideTables.forEach(function (element, index, array) {
            console.log(element);
            $(element).wrap('<div class="hide_table hidden"></div>');
            $(element).parent().css("height", $(element).css("height"));
            $(element).parent().append('<div class="moar">Показать полностью...</div>');
        })

        $('.moar').click(function () {
            if ($(this).parent().hasClass("hidden")) {
                $(this).parent().removeClass("hidden");
                $(this).text("Скрыть");
            }
            else {
                $(this).parent().addClass("hidden");
                $(this).text("Показать полностью");
            }
        })
    </script><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>