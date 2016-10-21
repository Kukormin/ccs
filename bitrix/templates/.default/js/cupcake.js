$(document).ready(function () {

	$("#new_address").suggestions({
		serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
		token: "af304791ab1e5b8bfeca2736f2dbbe04d4f3a885",
		addon: 'spinner',
		type: "ADDRESS",
		count: 10,
		geoLocation: {kladr_id: '77000000'},
		scrollOnFocus: $('label[for="delivery_new"]'),
		onSelect: function() {
			$(this).focus();
		}
	});

	//mobile top menu
	$(".mobile-button-nav").click(function () {
		$('.b-header__bottom').toggleClass('open');
	});
	$('.b-bottom-nav a').click(function () {
		$('.b-header__bottom').removeClass('open');
	});

	//mobile zoom out
	$('input, select, textarea').on('focus blur', function (event) {
		$('meta[name=viewport]').attr('content', 'width=device-width,initial-scale=1,maximum-scale=1'); // + (event.type == 'blur' ? 10 : 1)
	});

	//mobile  menu 	 account

	$(".account__navigation--mobile").click(function () {
		$('.b-block-account__navigation').toggleClass('open');
	});
	$('.b-account-navigation__mobile-wrap a').click(function () {
		$('.b-block-account__navigation').removeClass('open');
	});


	$(".cupcake__navigation--mobile, .mobile_catalog_open").click(function () {
		$('.b-mobile-breadcrumbs').toggleClass('open');
	});
	$('.b-cupcake__navigation--mobile-first-line__list a').click(function () {
		$('.b-mobile-breadcrumbs').removeClass('open');
	});

	$('.carousel-main .carousel-main-row').each(function () {
		var src = $(this).find('img').attr('src');
		$(this).find('img').hide();
		$(this).css('background-image', 'url(' + src + ')');
	})
	//slider
	$('.carousel-main').slick({
		slide: '.carousel-main-row',
		dots: false,
		infinite: true,
		speed: 1000,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 10000
	});

	$('.b-slider-wrap').slick({
		dots: true,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				}
			}

		]
	});

	$('.b-topscreen-slider').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		slidesToScroll: 1
	});


	$('#related_products_main').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			},
			{
				breakpoint: 961,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			},
			{
				breakpoint: 701,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			}


		]
	});

	$('#related-products').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			},
			{
				breakpoint: 650,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			}


		]
	});

	$('.b-slider-wrap-postcard__list').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 4,
		slidesToScroll: 4,
		responsive: [
			{
				breakpoint: 1010,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true,
					dots: false
				}
			},
			{
				breakpoint: 859,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			},
			{
				breakpoint: 700,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			}/*,
			 {
			 breakpoint: 650,
			 settings: {
			 slidesToShow: 3,
			 slidesToScroll: 3,
			 infinite: true,
			 dots: false
			 }
			 }*/

		]
	});

	var $elems = $('.b-slider-stock__list').children(),
		$parents = $elems.parent(),
		selector = 'a';

	$parents.each(function () {
		$(this).children(selector).sort(function () {
			return Math.round(Math.random()) - 0.5;
		}).detach().appendTo(this);
	});

	$('.b-slider-stock__list, .b-slider-wrap--stories').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			}

		]
	});

	$('.b-slider-wrap--stories').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
		var item = slick.$slides.eq(nextSlide);
		var background_url = item.data('url');
		$('.b-content-wrap--stories').css('background-image', 'url("' + background_url + '")');
	});


	$('.b-slider-wrap--stories').find('.b-slider__item').each(function () {
		var img = $(this).data('url');
		var load = new Image();
		load.src = img;
	});

	$('.b-slider-wrap-basket__list').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 3,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: false,
					dots: false
				}
			},
			{
				breakpoint: 941,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					infinite: false,
					dots: false
				}
			},
			{
				breakpoint: 821,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: false,
					dots: false
				}
			},


			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: false
				}
			}

		]
	});


	//gallery
	if ($(".slider-for").length && $(".slider-for img").length) {
		$(".slider-for img").load(function () {
			$(".slider-for").css({'height': $(".slider-for img").height() + 'px', 'position': 'relative'});
		});
		$(".slider-for").css({'height': $(".slider-for img").height() + 'px', 'position': 'relative'});
	}
	(function () {
		$(".slider-nav-gal a").click(function () {
			var path = $(this).attr("href");
			var alt = $(this).attr("alt");
			$(".slider-nav-gal a").removeClass('active');
			$(this).addClass('active');
			$(".slider-for img").css({'position': 'absolute', 'z-index': 2}).animate({opacity: 0}, 1000, function () {
				$(this).remove();
			});
			$(".slider-for").append("<img src='" + path + "' />").find("img").css({
				'position': 'absolute',
				'z-index': 1,
				'opacity': 0
			}).bind("load", function () {
				$(this).animate({opacity: 1}, 1000);
				$(".slider-for").css({'height': $(this).height() + 'px'});
			});
			return false;
		});
	})();


	$('.slider-nav-gal').slick({
		slidesToShow: 9,
		slidesToScroll: 1,
		arrows: true,
		fade: false,
		responsive: [

			{
				breakpoint: 769,
				settings: {
					slidesToShow: 6,
					slidesToScroll: 6,
					arrows: true,
					infinite: false,
					dots: false
				}
			},
			{
				breakpoint: 650,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4,
					arrows: true,
					infinite: false,
					dots: false
				}
			},
			{
				breakpoint: 470,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4,
					arrows: true,
					infinite: false,
					dots: false
				}
			}
		]

	});


	(function () {
		var el = $('#questions-answers .questions-answers_title'),
			subEl = $('#questions-answers div.questions-answers-sub_nav'),
			prevElement = el.next(subEl).prev();

		prevElement.append('<span></span>');
		el.click(function () {
			var checkedElement = $(this).next(subEl);
			visibleElement = subEl.filter(':visible');

			visibleElement.stop().animate({'height': 'toggle'}, 300).prev().toggleClass('active');
			if ((checkedElement.is(subEl)) && (!checkedElement.is(':visible'))) {
				checkedElement.stop().animate({'height': 'toggle'}, 300).prev().toggleClass('active');
			}
			return false;
		});
	})();

	$('body').on('click', '.js-ajax-pager a', function (e) {
		e.preventDefault();
		var param = $(this).data('page');
		var search = document.location.search.substr(1);
		search = search.replace(/&?PAGEN_(\d+)=(\d+)/, '');
		var url = document.location.pathname + (search || param ? '?' : '') + search + (param && search ? '&' : '') + param;
		history.pushState('', '', url);
		$.get(url, function (resp) {
			$('.js-ajax-content-block').html($(resp).find('.js-ajax-content-block').html());
			$('.js-ajax-pager').html($(resp).find('.js-ajax-pager').html());
		});
	});

	$('body').on('click', '.js-catalog-filter', function () {
		var search = document.location.search.substr(1);
		if (search) {
			var active = $('.js-catalog-filter.active').data('param');
			var regExp = new RegExp('^' + active + '&?');
			search = search.replace(regExp, '');
		}
		var filter = $(this).data('param');
		if (!filter && !search) {
			document.location.search = '';
			return;
		}

		var url = document.location.pathname + '?' + filter + (filter && search ? '&' : '') + search;
		history.pushState('', '', url);
		$.get(url, function (resp) {
			$('.js-ajax-content-block').html($(resp).find('.js-ajax-content-block').html());
			$('.js-ajax-pager').html($(resp).find('.js-ajax-pager').html());
		});
	});


	(function () {
		var el = $('#order-history .b-order-history_title'),
			subEl = $('#order-history div.b-order-history-sub_nav'),
			prevElement = el.next(subEl).prev();

		prevElement.append('<span></span>');
		el.click(function () {
			var checkedElement = $(this).next(subEl);
			visibleElement = subEl.filter(':visible');

			visibleElement.stop().animate({'height': 'toggle'}, 300).prev().toggleClass('active');
			if ((checkedElement.is(subEl)) && (!checkedElement.is(':visible'))) {
				checkedElement.stop().animate({'height': 'toggle'}, 300).prev().toggleClass('active');
			}
			return false;
		});
	})();

	$('.js-copy-order').on('click', function (e) {
		e.preventDefault();
		if ($(this).hasClass('block')) return false;

		$(this).addClass('block');
		var order = $(this).closest('.js-copy-order-order');
		var data = [];
		$('.js-copy-order-item', order).each(function () {
			data.push({
				'id': $(this).data('id'),
				'q': $(this).data('quantity'),
				'props': $(this).data('props')
			});
		});
		$.post('/include/copy_order.php', {'data': data}, function (resp) {
			if (resp == 1) {
				document.location.pathname = '/personal/order/make/';
			}
		});
	});


	//select stylization
	$('select').each(function () {
		$(this).prev('p').text($(this).children('option:selected').text());
	});
	$('body').on('change', 'select', function () {
		$(this).prev('p').text($(this).children('option:selected').text());
	});


	/*scroll*/

	$(window).scroll(function () {
		if ($(document).scrollTop() > 178) {
			$('.b-header__bottom').addClass('menu-fixed');
		} else {
			$('.b-header__bottom').removeClass('menu-fixed');
		}
	});


	/*menuleft*/


	var el = $('#nav_list_asaide li a');
	$('#nav_list_asaide li:has("ul")').append('<span></span>');
	el.click(function (e) {
		e.preventDefault();
		var checkElement = $(this).next();
		if (!$(this).closest('ul').hasClass('open')) {
			$("#nav_list_asaide ul.open").not(checkElement).not(checkElement.parents()).slideUp().removeClass('open');
		}
		$('#nav_list_asaide li.active').not($(this).parent()).removeClass('active');

		var link = $(this).attr('href');
		if (checkElement.length) {
			checkElement.stop().toggleClass('open').animate(
				{'height': 'toggle'}, 500, function () {
					history.pushState('', '', link);
				}
			).parent().toggleClass('active');
		} else {
			history.pushState('', '', link);
			$(this).parent().toggleClass('active');
		}
		$.get(link, function (resp) {
			$('.js-ajax-content-block').html($(resp).find('.js-ajax-content-block').html());
			$('.js-ajax-pager').html($(resp).find('.js-ajax-pager').html());
		});
		if (checkElement.is('ul')) {
			return false;
		}
	});


	$(window).stellar({
		responsive: true
	});


	/*popup	*/
	$('.b-modal-personal_account').hide();
	$('.overlay').hide();
	$('.js_login, .js_cart_login').click(function () {
		$('.overlay').show();
		$('.js_login_modal').show().css('top', $(window).scrollTop() + 25 + "px");
		;
	})
	$('.js_register').click(function () {
		$('.overlay').show();
		$('.js_modal_registration').show().css('top', $(window).scrollTop() + 25 + "px");
	});

	$('.b-footer-mail').click(function (e) {
		e.preventDefault();
		$('.overlay').show();
		$('.js_feedback_modal').show().css('top', $(window).scrollTop() + 25 + "px");
	});

	$('.bnt-mailing, .b-mailing__item-img').click(function (e) {
		e.preventDefault();
		$('.overlay').show();
		$('.js_subscribe_modal').show().css('top', $(window).scrollTop() + 25 + "px");
		;
	});


	$('.b-forget_password').click(function (e) {
		e.preventDefault();
		$('.overlay').show();
		$('.js_forgot_pass').show().css('top', $(window).scrollTop() + 25 + "px");
		;
		$('.js_login_modal').hide();
		$('.js_modal_registration').hide();
	});

	$('.js-already-register').click(function (e) {
		e.preventDefault();
		$('.js_modal_registration').hide();
		$('.js_login_modal').show().css('top', $(window).scrollTop() + 25 + "px");
		;
	});

	$('body').on('click', '.b-close-modal', function (e) {
		e.preventDefault();
		$(this).parent('.b-modal-personal_account, .b-modal--cupcake, .b-modal-fastorder').hide();
		$(".overlay").hide();
		$(".js-go-to").removeClass('js-go-to').text('в корзину');
	});
	$('body').on('click', '.b-modal-add-products', function (e) {
		e.preventDefault();
		$(this).parent('.b-modal-personal_account, .b-modal--cupcake').hide();
		$(".overlay").hide();
		$(".js-go-to").removeClass('js-go-to').text('в корзину');
	});

	//personal page
	$('.profile_form').submit(function () {
		$('.new_password_confirm').val($('.b-account-form--input-pass').val());
	});

	$('.registration_form').submit(function () {
		$('.registration_login').val($('.registration_phone').val());
	});

	$('.js-personal-editable').on('click', function () {
		$('#' + $(this).data('for')).prop('readonly', false).attr('placeholder', '').focus().parent().addClass('active');
		$(this).hide();
	});


	$('body').on('click', '.basket-button', function (e) {
		e.preventDefault();
		var gid = $(this).data('btn_id');
		$(".overlay").show();
		if (!$("#modal_" + gid).length) {
			$.get('/include/item_modal.php?ID=' + gid + '&IBLOCK=' + $(this).data('block_id'), function (resp) {
				$('body').append(resp);
				$("#modal_" + gid).show().css('top', $(window).scrollTop() + 25 + "px");
			});
		} else {
			$("#modal_" + gid).show().css('top', $(window).scrollTop() + 25 + "px");
		}
	});

	$('.overlay').click(function () {
		$(".b-modal > *").hide();
		$(".b-modal--cupcake").hide();
		$(".js-go-to").removeClass('js-go-to').text('в корзину');
	});

	//////////////////////CATALOG ELEMENT PRICES/////////////////////////////
	$('.js_cupcake_number').change(function () {
		var prices = offer_prices[$(this).val()];
		var count = 1; //старое значение $('.js-modal-counter', modal).data("count") пришлось поставить просто 1, а то цена не выводилась, когда клиент попросил блок закоментить.
		if (prices[1] == null) {
			$('.js-priceblock').removeClass().addClass('b-history-total--price js-priceblock')
				.html(
				(prices[0] * count) + ' <span class="rub">i</span>'
			);
			$('.js-priceblock').data('price', prices[0]);
			$('.js-priceblock').data('oldprice', 0);
		} else {
			$('.js-priceblock').removeClass().addClass('b-old--total-price js-priceblock')
				.html(
				'<div class="b-old-price"> ' + (prices[0] * count) + ' <span class="rub">i</span></div>' +
				'<div class="b-new-price"> ' + (prices[1] * count) + ' <span class="rub">i</span></div>'
			);
			$('.js-priceblock').data('price', prices[1]);
			$('.js-priceblock').data('oldprice', prices[0]);
		}
	});
	$('.js_cupcake_number').change();

	$('body').on('change', '.js-option-selector', function () {
		var modal = $(this).closest('.js-modal-window')
		var id = modal.data('id');
		var count = 1; //старое значение $('.js-modal-counter', modal).data("count") пришлось поставить просто 1, а то цена не выводилась, когда клиент попросил блок закоментить.
		var prices = modal_offer_prices[id][$(this).val()];
		if (prices[1] == null) {
			$('.js-modal-priceblock', modal).removeClass().addClass('b-history-total--price b-modal-cupcake-total--price js-modal-priceblock js-priceblock')
				.html(
				(prices[0] * count) + ' <span class="rub">i</span>'
			);
			$('.js-priceblock', modal).data('price', prices[0]);
			$('.js-priceblock', modal).data('oldprice', 0);
		} else {
			$('.js-modal-priceblock', modal).removeClass().addClass('b-old--total-price b-history-total--price b-modal-cupcake-total--price js-priceblock js-modal-priceblock')
				.html(
				'<div class="b-old-price"> ' + (prices[0] * count) + ' <span class="rub">i</span></div>' +
				'<div class="b-new-price"> ' + (prices[1] * count) + ' <span class="rub">i</span></div>'
			);
			$('.js-priceblock', modal).data('price', prices[1]);
			$('.js-priceblock', modal).data('oldprice', prices[0]);
		}

		//$('.b-new-price', modal).html(offer_prices[$('.js_cupcake_number').val()][1] + ' ' + '<span class="rub">i</span>');
		//$('.b-old-price', modal).html(offer_prices[$('.js_cupcake_number').val()][0] + ' ' + '<span class="rub">i</span>');
	});

	$('.js-address-change').click(function (e) {
		e.preventDefault();
		var parent = $(this).closest('.js-address-block');
		parent.find('.js-address-edit').show();
		parent.find('.js-address-value').hide();
		parent.find('.b-block-account-address__group').hide();
	});

	$('body').on('click', '.js-modal-upcount', function () {
		var modal = $(this).closest('.js-modal-window');
		var current = parseInt($(".js-modal-counter", modal).text());
		current++;
		$(".js-modal-counter", modal).data('count', current);
		if (current > 1) $('.js-modal-downcount', modal).show();
		$(".js-modal-counter", modal).text(current + ' ' + declension(current, ['упаковка', 'упаковки', 'упаковок']));
		var prices = [$('.js-priceblock').data('price'), $('.js-priceblock').data('oldprice')];
		if ($('.js-priceblock').hasClass('js-modal-priceblock')) {
			if (prices[1] == 0) {
				$('.js-modal-priceblock', modal).removeClass().addClass('b-history-total--price b-modal-cupcake-total--price js-priceblock js-modal-priceblock')
					.html(
					(format_number(prices[0] * current)) + ' <span class="rub">i</span>'
				);
			} else {
				$('.js-modal-priceblock', modal).removeClass().addClass('b-old--total-price b-history-total--price b-modal-cupcake-total--price js-priceblock js-modal-priceblock')
					.html(
					'<div class="b-old-price"> ' + (format_number(prices[0] * current)) + ' <span class="rub">i</span></div>' +
					'<div class="b-new-price"> ' + (format_number(prices[1] * current)) + ' <span class="rub">i</span></div>'
				);
			}
		} else {//detail
			if (prices[1] == 0) {
				$('.js-priceblock').removeClass().addClass('b-history-total--price js-priceblock')
					.html(
					(format_number(prices[0] * count)) + ' <span class="rub">i</span>'
				);
			} else {
				$('.js-priceblock').removeClass().addClass('b-old--total-price js-priceblock')
					.html(
					'<div class="b-old-price"> ' + (format_number(prices[0] * count)) + ' <span class="rub">i</span></div>' +
					'<div class="b-new-price"> ' + (format_number(prices[1] * count)) + ' <span class="rub">i</span></div>'
				);
			}
		}
	});

	$('body').on('click', '.js-modal-downcount', function () {
		var modal = $(this).closest('.js-modal-window');
		var current = parseInt($(".js-modal-counter", modal).text());
		if (current > 1) current--;
		$(".js-modal-counter", modal).data('count', current);
		if (current == 1) $('.js-modal-downcount', modal).hide();
		var prices = [$('.js-priceblock').data('price'), $('.js-priceblock').data('oldprice')];
		$(".js-modal-counter", modal).text(current + ' ' + declension(current, ['упаковка', 'упаковки', 'упаковок']));
		if ($('.js-priceblock').hasClass('js-modal-priceblock')) {
			if (prices[1] == 0) {
				$('.js-modal-priceblock', modal).removeClass().addClass('b-history-total--price b-modal-cupcake-total--price js-priceblock js-modal-priceblock')
					.html(
					(format_number(prices[0] * current)) + ' <span class="rub">i</span>'
				);
			} else {
				$('.js-modal-priceblock', modal).removeClass().addClass('b-old--total-price b-history-total--price b-modal-cupcake-total--price js-priceblock js-modal-priceblock')
					.html(
					'<div class="b-old-price"> ' + (format_number(prices[0] * current)) + ' <span class="rub">i</span></div>' +
					'<div class="b-new-price"> ' + (format_number(prices[1] * current)) + ' <span class="rub">i</span></div>'
				);
			}
		} else {//detail
			if (prices[1] == 0) {
				$('.js-priceblock').removeClass().addClass('b-history-total--price js-priceblock')
					.html(
					(format_number(prices[0] * count)) + ' <span class="rub">i</span>'
				);
			} else {
				$('.js-priceblock').removeClass().addClass('b-old--total-price js-priceblock')
					.html(
					'<div class="b-old-price"> ' + (format_number(prices[0] * count)) + ' <span class="rub">i</span></div>' +
					'<div class="b-new-price"> ' + (format_number(prices[1] * count)) + ' <span class="rub">i</span></div>'
				);
			}
		}
	});

	$('body').on('click', '.js-modal-tobasket', function (e) {
		e.preventDefault();
		if ($(this).hasClass('js-go-to')) {
			document.location.pathname = $(this).data('href');
			return false;
		}
		var modal = $(this).closest('.js-modal-window');
		var that = $(this);
		var params = {};
		$('.js-basket-property, .js-option-selector, .js_cupcake_number', modal).each(function () {
			params[$(this).data('code')] = {
				'NAME': $(this).data('name'),
				'VALUE': $(this).children('option:selected').text()
			};
		});
		var selectorId = $('.js-option-selector', modal);
		var addid = 0;
		if (that.data('addid')) {
			addid = that.data('addid');
		}
		else if (selectorId.length) {
			addid = selectorId.val();
		}
		else if ($('.js_cupcake_number').length) {
			addid = $('.js_cupcake_number').val();
		}
		else {
			addid = modal.data('id');
		}

		$.post('/include/ajax_basket.php', {
			'ajaxaction': 'add',
			'ajaxaddid': addid,
			'quantity': parseInt($(".js-modal-counter", modal).text()),
			'params': params
		}, function (resp) {
			if (resp != 0) {
				that.addClass('js-go-to').text('к корзине');
				updateBasketPrice();
			}
		});
	});

	$('body').on('click', '.js-buy-fastorder', function (e) {
		var modal = $(this).closest('.js-modal-window');
		var that = $(this);
		var params = {};
		$('.js-basket-property, .js-option-selector, .js_cupcake_number', modal).each(function () {
			params[$(this).data('code')] = {
				'NAME': $(this).data('name'),
				'VALUE': $(this).children('option:selected').text()
			};
		});
		if ($('.js-option-selector', modal).length)
			var addid = $('.js-option-selector', modal).val();
		else if ($('.js_cupcake_number', modal).length)
			var addid = $('.js_cupcake_number', modal).val();
		else
			var addid = modal.data('id');

		$.post('/include/ajax_basket.php', {
			'ajaxaction': 'add',
			'ajaxaddid': addid,
			'quantity': parseInt($(".js-modal-counter", modal).text()),
			'params': params
		}, function (resp) {
			if (modal.hasClass('b-modal--cupcake')) modal.hide();
			$('.js_modal_fastorder').show().css('top', $(window).scrollTop() + 25 + "px");
			$('.js-ajax-fastorder').html('<div class="preloader"></div>');
			$.get('/include/fast_order.php', function (resp) {
				$('.js-ajax-fastorder').html(resp);
				$('#js-fastorder-mask').mask('+7(999)999-99-99');
			});
		});


	});

	$('.js-basket-fastbuy').on('click', function () {
		$('.js_modal_fastorder').show().css('top', $(window).scrollTop() + 25 + "px");
		$('.overlay').show();
		$('.js-ajax-fastorder').html('<div class="preloader"></div>');
		$.get('/include/fast_order.php', function (resp) {
			$('.js-ajax-fastorder').html(resp);
		});
	});

	/*$('body').on('submit','.js-fastorder-form', function () {

	 });*/

	$('.js-address-delete').click(function (e) {
		e.preventDefault();
		$(this).closest('.js-address-block').remove();
	});
	/////////////////////SHIPPING ADDRESS INPUT///////////////////////////////
	$('.profile_form').submit(function () {
		/* $('.js-address-edit input').each(function () {
		 $(this).val($(this).val()+'|'+$(this).data('id'));
		 });*/
		var parent = $(this);
		$('.b-form-item__input input', parent).each(function () {
			if ($(this).val()) {
				var parent = $(this).closest('.b-application-event__form--line');
				$(this).val($(this).val() + '|' + $('.shipping_region', parent).val());
			}
		});
	});


	//basket scripts
	$('.js-basket-remove').on('click', function () {
		var line = $(this).closest('.js-basket-item-cont');
		var id = line.data('oiid');
		var productName = $(this).closest('.b-basket__item').find('.b-mod__item-title--basket').html();
		var price = line.data('base-price');
		productName = productName.trim();
		$.post('/include/ajax_basket.php', {'ajaxaction': 'delete', 'ajaxdeleteid': id}, function () {
			updateBasketPrice();
		});

		line.slideUp(function () {
			line.parent().remove();
			if (!$('.b-basket__item').length) document.location.reload();
		});
		dataLayer.push({
			'event': 'removeFromCart',
			'ecommerce': {
				'remove': {
					'products': [{
						'name': productName,
						'id': id,
						'price': price,
						'quantity': 1
					}]
				}
			}
		});
	});

	$('.js-checkout-btn').on('click', function () {
		var products = [];
		$('.b-basket__item').each(function () {
			var productName = $(this).find('.b-mod__item-title--basket').html().trim();
			var id = $(this).find('.js-duplicate-item').data('id');
			$('.js-basket-item-cont').each(function () {
				products.push({'name': productName, 'id': id, 'price': $(this).data('base-price'), 'quantity': 1});
			});
		});
		dataLayer.push({
			'event': 'checkout',
			'ecommerce': {
				'checkout': {
					'actionField': {'step': 1},
					'products': products
				}
			}
		});
	});

	$('.js-basket-prop').on('change', function () {
		var line = $(this).closest('.js-basket-item-cont');
		var that = $(this);
		var params = {};
		//$('.js-basket-prop').each(function () {
		params[$(this).data('code')] = {
			'NAME': $(this).data('name'),
			'VALUE': $(this).children('option:selected').text()
		};
		//});
		/*$('.js-basket-option').each(function () {
		 params[$(this).data('code')] = {'NAME': $(this).data('name'), 'VALUE': $(this).children('option:selected').text()};
		 });*/
		var bid = line.data('oiid');
		$.post('/include/update_item.php', {'id': bid, 'params': params}, function (resp) {

			/*if (resp != 0) {
			 line.data('oiid',resp);
			 $.get('/include/update_price.php?ID='+resp, function (resp) {line.find('.js-item-total').text(resp)});
			 updateBasketPrice();
			 }*/
		});
	});

	$('.js-basket-item-cont').each(function () {
		var line = $(this);
		var that = line.find('.js-basket-option');
		if (!that.length) return true;
		if (that.data('code') == 'NUMBER')
			if (parseInt(that.find("option:selected").text().trim()) == 9) {
				line.find('.js-package-cont').find('.js-package-item').not('.js-free-box, .js-vip-box').addClass('js-hidden').hide();
				line.find('.js-package-cont').find('.js-free-box, .js-vip-box').removeClass('js-hidden').show();
				if ($(".js-package-selector:checked").closest('.js-hidden').length) {
					var target = line.find('.js-package-cont .js-vip-box, .js-package-cont .js-free-box').eq(0).find('.js-package-selector');
					line.find('.js-package-cont .js-package-item .js-package-selector').prop('checked', false);
					target.prop('checked', true);
					updatePackagePrice(target);
				}
			} else {
				line.find('.js-package-cont').find('.js-package-item').not('.js-vip-box').removeClass('js-hidden').show();
				line.find('.js-package-cont').find('.js-vip-box').addClass('js-hidden').hide();
				if ($(".js-package-selector:checked").closest('.js-hidden').length) {
					var target = line.find('.js-package-cont .js-package-item').not('.js-vip-box').eq(0).find('.js-package-selector');
					line.find('.js-package-cont .js-package-item .js-package-selector').prop('checked', false);
					target.prop('checked', true);
					updatePackagePrice(target);
				}
			}
	});

	$('.js-basket-option').on('change', function () {
		var line = $(this).closest('.js-basket-item-cont');
		var that = $(this);
		var offers_props = [];
		var props = {};
		if (that.data('code') == 'NUMBER')
			if (parseInt(that.find("option:selected").text().trim()) == 9) {
				line.find('.js-package-cont').find('.js-package-item').not('.js-free-box, .js-vip-box').addClass('js-hidden').hide();
				line.find('.js-package-cont').find('.js-free-box, .js-vip-box').removeClass('js-hidden').show();
				if ($(".js-package-selector:checked").closest('.js-hidden').length) {
					var target = line.find('.js-package-cont .js-vip-box, .js-package-cont .js-free-box').eq(0).find('.js-package-selector');
					line.find('.js-package-cont .js-package-item .js-package-selector').prop('checked', false);
					target.prop('checked', true);
					updatePackagePrice(target);

				}
			} else {
				line.find('.js-package-cont').find('.js-package-item').not('.js-vip-box').removeClass('js-hidden').show();
				line.find('.js-package-cont').find('.js-vip-box').addClass('js-hidden').hide();
				if ($(".js-package-selector:checked").closest('.js-hidden').length) {
					var target = line.find('.js-package-cont .js-package-item').not('.js-vip-box').eq(0).find('.js-package-selector');
					line.find('.js-package-cont .js-package-item .js-package-selector').prop('checked', false);
					target.prop('checked', true);
					updatePackagePrice(target);
				}
			}
		/*$('.js-basket-prop').each(function () {
		 params[$(this).data('code')] = {'NAME': $(this).data('name'), 'VALUE': $(this).children('option:selected').text()};
		 });*/
		$('.js-basket-option', line).each(function () {
			offers_props.push($(this).data('code'));
			props[$(this).data('code')] = $(this).children('option:selected').data('value-id');
		});
		var bid = line.data('oiid');
		var opts = {
			'action_var': basket_settings.action_var,
			'basketItemId': bid,
			'sessid': basket_settings.sid,
			'offers_props': offers_props.join(','),
			'props': props
		};
		opts[basket_settings.action_var] = 'select_item';
		$.ajax({
			type: 'POST',
			url: '/bitrix/components/bitrix/sale.basket.basket/ajax.php',
			data: opts,
			dataType: 'json',
			complete: function (resp) {
				resp = resp.responseText.replace(/'/g, '"');
				resp = JSON.parse(resp);
				line.data('base-price', resp.BASKET_DATA.GRID.ROWS[bid].PRICE);
				var total = line.find('.js-item-total');
				var pack_sum = parseInt(total.next().val());
				var price = parseFloat(resp.BASKET_DATA.GRID.ROWS[bid].PRICE);
				var cnt = parseInt(resp.BASKET_DATA.GRID.ROWS[bid].QUANTITY);
				var sum = Math.round(price*cnt + pack_sum);
				total.text(sum);
				updateBasketPrice();
				updateCouponsBlock(resp.BASKET_DATA.COUPON_LIST, resp.BASKET_DATA.allSum, resp.BASKET_DATA.DISCOUNT_PRICE_ALL);
			}
		});
	});

	$('.basket_cnt_minus').on('click', function () {
		var line = $(this).closest('.js-basket-item-cont');
		var that = $(this);
		var input = that.parent().find('input');
		var val = input.val();
		if (val <= 1)
			return false;

		val--;
		input.val(val);
		sendCntAjax(line, val);
	});

	$('.basket_cnt_plus').on('click', function () {
		var line = $(this).closest('.js-basket-item-cont');
		var that = $(this);
		var input = that.parent().find('input');
		var val = input.val();
		if (val >= 99)
			return false;

		val++;
		input.val(val);
		sendCntAjax(line, val);
	});

	function sendCntAjax(line, val) {
		var bid = line.data('oiid');
		var opts = {
			'action_var': basket_settings.action_var,
			'basketItemId': bid,
			'sessid': basket_settings.sid,
			'select_props': 'QUANTITY'
		};
		opts['QUANTITY_' + bid] = val;
		opts[basket_settings.action_var] = 'recalculate';
		$.ajax({
			type: 'POST',
			url: '/bitrix/components/bitrix/sale.basket.basket/ajax.php',
			data: opts,
			dataType: 'json',
			complete: function (resp) {
				resp = resp.responseText.replace(/'/g, '"');
				resp = JSON.parse(resp);
				line.data('base-price', resp.BASKET_DATA.GRID.ROWS[bid].PRICE);
				var total = line.find('.js-item-total');
				var pack_sum = parseInt(total.next().val());
				var price = parseFloat(resp.BASKET_DATA.GRID.ROWS[bid].PRICE);
				var cnt = parseInt(resp.BASKET_DATA.GRID.ROWS[bid].QUANTITY);
				var sum = Math.round(price*cnt + pack_sum);
				total.text(sum);
				updateBasketPrice();
				updateCouponsBlock(resp.BASKET_DATA.COUPON_LIST, resp.BASKET_DATA.allSum, resp.BASKET_DATA.DISCOUNT_PRICE_ALL);
			}
		});
	}

	if ($('.js-package-popup').length) {
		//$('.js-package-popup').featherlight();
	}


	$("body").on('click', ".em-radio", function (e) {
		var state = this.checked;
		if (!state) {
			e.preventDefault();
			return false;
		}
		else {
			var name = $(this).attr('name');
			$('.em-radio[name="' + name + '"]:checked').not(this).prop('checked', false);
		}
	});

	$("body").on('change', '.js-package-selector', function () {
		updatePackagePrice(this);
	});

	function updatePackagePrice(that) {
		var that = $(that);
		var line = that.closest('.js-basket-item-cont');
		var package_cont = that.closest('.js-package-cont');
		var bid = package_cont.data('package-bid');
		var gbid = line.data('oiid');
		var pack_item = that.closest('.js-package-item');
		var id = pack_item.data('package-id');
		var name = pack_item.data('package-name');

		$.post('/include/update_package.php', {'bid': bid, 'newid': id, 'gbid': gbid, 'name': name}, function (resp) {
			var total = line.find('.js-item-total');
			var price = parseFloat(line.data('base-price'));
			var pack_price = parseInt(pack_item.data('package-price'));
			var cnt = parseInt(line.find('#QUANTITY_INPUT_' + gbid).val());
			var sum = Math.round((price + pack_price)*cnt);
			total.text(sum);
			total.next().val(Math.round(pack_price*cnt));
			package_cont.data('package-bid', resp);
			updateBasketPrice();
			updateDiscountBlock();
			/*if (resp != 0) {
			 line.data('oiid',resp);
			 $.get('/include/update_price.php?ID='+resp, function (resp) {line.find('.js-item-total').text(resp)});
			 updateBasketPrice();
			 }*/
		});
	}

	$(".js-duplicate-item").on('click', function (e) {
		e.preventDefault();
		var id = $(this).data('id');
		var line = $(this).closest('ol').children('li').last();
		var params = {};
		$('.js-basket-option, .js-basket-prop', line).each(function () {
			params[$(this).data('code')] = {
				'VALUE': $(this).children('option:selected').text(),
				'NAME': $(this).data('name'),
			};
		});
		$.post('/include/ajax_basket.php', {
			'ajaxaction': 'add',
			'ajaxaddid': id,
			'params': params
		}, function (resp) {
			document.location.hash = '#an_' + id;
			document.location.reload();
		});
	});

	if (document.location.hash.indexOf('#an_') !== -1) {
		$('html,body').animate({scrollTop: $('#anchit_' + document.location.hash.substr(4).replace(/\D/g, '')).offset().top - 300}, 10);
	}

	updateBasketPrice();
	updateDiscountBlock();
	///////////////////////Маски////////////////////
	$('.js-phone-mask').mask('+7(999)999-99-99');
	$.mask.definitions['H'] = '[012]';
	$.mask.definitions['M'] = '[012345]';
	$('.js-mask-timefrom').mask('H9:M9', {
			placeholder: "_",
			completed: function () {
				var val = $(this).val().split(':');
				if (val[0] * 1 > 23) val[0] = '23';
				if (val[1] * 1 > 59) val[1] = '59';
				$(this).val(val.join(':'));
				$(this).next(':input').focus();
			}
		}
	);
	$('.js-mask-timeto').mask('H9:M9', {
			placeholder: "_",
			completed: function () {
				var val = $(this).val().split(':');
				if (val[0] * 1 > 23) val[0] = '23';
				if (val[1] * 1 > 59) val[1] = '59';
				$(this).val(val.join(':'));
				//$(this).next(':input').focus();
			}
		}
	);
	/////////////////////////////Валидация форм. К сожалению, плагин реагирует на name, а они везде разные, поэтому получилось много валидаций///////////////////////
	$('.js-form-validation').validate({
		rules: {
			'FIELDS[REVIEW_TITLE_FID1]': {
				required: true,
				minlength: 3
			},
			'FIELDS[EMAIL_FID1]': {
				required: true
			},
			'FIELDS[FB_TEXT_FID1]': {
				required: true
			},
			captcha_word: {
				required: true
			}
		},
		messages: {
			'FIELDS[REVIEW_TITLE_FID1]': {
				required: 'Обязательное поле',
				minlength: 'Не менее 3 символов'
			},
			'FIELDS[EMAIL_FID1]': {
				required: 'Обязательное поле',
				email: 'Введите валидную почту'
			},
			'FIELDS[FB_TEXT_FID1]': 'Обязательное поле',
			captcha_word: 'Обязательное поле'
		}
	});

	$('.js-form-validation').submit(function (e) {
		if ($('.error').length) {
			$('html,body').animate({scrollTop: $('.error').eq(0).offset().top - 300}, 1000);
			e.preventDefault();
		}
	});

	$('.js-validation-feedback').validate({
		rules: {
			user_name: {
				required: true,
				minlength: 3
			},
			user_email: {
				required: true
			},
			MESSAGE: {
				required: true
			},
			captcha_word: {
				required: true
			}
		},
		messages: {
			user_name: {
				required: 'Обязательное поле',
				minlength: 'Не менее 3 символов'
			},
			user_email: {
				required: 'Обязательное поле',
				email: 'Введите валидную почту'
			},
			MESSAGE: 'Обязательное поле',
			captcha_word: 'Обязательное поле'
		}
	});

	$('.js-validation-feedback').submit(function (e) {
		if ($('.error').length) {
			$('html,body').animate({scrollTop: $('.error').eq(0).offset().top - 300}, 1000);
			e.preventDefault();
		}
	});

	$('.js-validation-sweet-table').validate({
		rules: {
			user_name: {
				required: true,
				minlength: 3
			},
			phone: {
				required: true
			},
			MESSAGE: {
				required: true
			},
			captcha_word: {
				required: true
			}
		},
		messages: {
			user_name: {
				required: 'Обязательное поле',
				minlength: 'Не менее 3 символов'
			},
			phone: 'Обязательное поле',
			MESSAGE: 'Обязательное поле',
			captcha_word: 'Обязательное поле'
		}
	});

	$('.js-validation-sweet-table').submit(function (e) {
		if ($('.error').length) {
			$('html,body').animate({scrollTop: $('.error').eq(0).offset().top - 300}, 1000);
			e.preventDefault();
		}
	});

	$('.registration_form').validate({
		rules: {
			'REGISTER[NAME]': {
				required: true,
				minlength: 3
			},
			'REGISTER[EMAIL]': {
				required: true
			},
			'REGISTER[PERSONAL_PHONE]': {
				required: true
			},
			'REGISTER[PASSWORD]': {
				required: true,
				minlength: 6
			},
			'REGISTER[CONFIRM_PASSWORD]': {
				required: true,
				minlength: 6,
				equalTo: ".b-account-form--input-pass"
			}
		},
		messages: {
			'REGISTER[NAME]': {
				required: 'Обязательное поле',
				minlength: 'Не менее 3 символов'
			},
			'REGISTER[EMAIL]': {
				required: 'Обязательное поле',
				email: 'Введите валидную почту'
			},
			'REGISTER[PERSONAL_PHONE]': 'Обязательное поле',
			'REGISTER[PASSWORD]': {
				required: 'Обязательное поле',
				minlength: 'Не менее 6 символов'
			},
			'REGISTER[CONFIRM_PASSWORD]': {
				required: 'Обязательное поле',
				minlength: 'Не менее 6 символов',
				equalTo: 'Повтор пароля'
			}
		}
	});

	$('.registration_form').submit(function (e) {
		if ($('.error').length) {
			$('html,body').animate({scrollTop: $('.error').eq(0).offset().top - 300}, 1000);
			e.preventDefault();
		}
	});
	///////////////////////////////////////////////Конец валидации////////////////////////

	////////////////Модальное спасибо////////////////
	$('.js-validation-feedback').ajaxForm(function () {
		$('.js_feedback_modal').hide();
		$('.js_thankyou_modal').show().css('top', $(window).scrollTop() + 25 + "px");
		$('.overlay').show();

	});
	$('#f_feedback_FID1').ajaxForm(function () {
		$('.js_thankyou_modal').show().css('top', $(window).scrollTop() + 25 + "px");
		$('.overlay').show();
	});
	$('.js-validation-sweet-table').ajaxForm(function () {
		$('.js_thankyou_modal').show().css('top', $(window).scrollTop() + 25 + "px");
		$('.overlay').show();
	});


	if (document.location.pathname == '/celebrity-stories/') {
		$('.b-content-wrap').addClass('b-content-wrap--stories');
		$('.b-footer-wrap').addClass('b-footer-wrap-stories');
		$('.b-footer').removeClass('b-footer-about');
		$('.b-footer').addClass('b-footer-stories');
		$('.b-footer-info').addClass('gl-block-footer-info');
		$('.b-footer-info').removeClass('b-footer-info-about');
		var bg_url = $('.b-slider__item').eq(1).data('url');
		$('.b-content-wrap--stories').css('background-image', 'url("' + bg_url + '")');
		$('.b-footer-copy, .b-footer-nav__item a, .b-footer-phones').addClass('b-footer-text-color');
	}

	$('#js_show_delivery_popup').click(function () {
		$('.overlay').show();
		$('.js_delivery_modal').show().css('top', $(window).scrollTop() + 25 + "px");
		if ($('.js_cupcake_number').length > 0) {
			$('.popup_el_id').val($('.js_cupcake_number').selected().val());
		} else {
			$('.popup_el_id').val($('.js-modal-window').data('id'));
		}
		if ($(window).width() < 500) {
			$('body').css('overflow', 'hidden');
			$('.b-modal').addClass('js-active');
		}
		$('.popup_quantity').val(parseInt($('.js-modal-counter').html()));
	});

	/*$(".carousel-main .details h3").dotdotdot({
	 ellipsis	: '... ',
	 height		: 30,
	 });

	 $(window).resize(function(){
	 $(".carousel-main .details h3").trigger("update");
	 })*/

});

var pack_sum = 0;
function updateBasketPrice() {
	var sum = 0;
	pack_sum = 0;
	$('.js-item-total').each(function() {
		sum += parseInt($(this).text());
		pack_sum += parseInt($(this).next().val());
	});
	$('.js-order-total').html(sum > 10000 ? format_number(sum) : sum);
}

function updateCouponsBlock(list, sum, discount) {
	if (list)
		for (var i in list)
		{
			var item = list[i];
			var div = $('.bx_ordercart_coupon#c_' + item.ID);
			if (div.length) {
				var cl = 'disabled';
				if (item.JS_STATUS === 'BAD')
					cl = 'bad';
				else if (item.JS_STATUS === 'APPLYED')
					cl = 'good';
				div.children('input').attr('class', cl);
				div.children('span').attr('class', cl);
				div.children('.bx_ordercart_coupon_notes').text(item.JS_CHECK_CODE);
			}
		}

	discount_price_all = Math.round(discount);
	allSum = Math.round(sum);

	updateDiscountBlock();
}

function updateDiscountBlock() {
	var total = $('.discount-total');
	if (total.length) {
		var sum = allSum + pack_sum;
		if (discount_price_all > 0) {
			total.find('#dtotal1').text(sum + discount_price_all);
			total.find('#dtotal2').text(discount_price_all);
			total.find('#dtotal3').text(sum);
			total.removeClass('hidden');
		}
		else {
			total.addClass('hidden');
		}
	}

}

$(function () {
	if (document.location.href.indexOf('contact') !== -1) {
		google.maps.event.addDomListener(window, 'load', gmaps_init);
	}


	function gmaps_init() {
		var coords = map_info[0].coords.split(',')
		var markerLatLng = new google.maps.LatLng(coords[0], coords[1]);

		var settings = {
			zoom: 13,
			center: markerLatLng,
			disableDefaultUI: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl: false,
			scrollwheel: false,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL,
				position: google.maps.ControlPosition.LEFT_CENTER
			}
		};

		var map = new google.maps.Map(document.getElementById("gmap"), settings);
		var latlngbounds = new google.maps.LatLngBounds();
		for (var info in map_info) {
			var coordinates = map_info[info].coords.split(',');
			var markerLatLng = new google.maps.LatLng(coordinates[0], coordinates[1]);
			var marker = new RichMarker({
				position: markerLatLng,
				map: map,
				draggable: false,
				shadow: 'none',
				anchor: RichMarkerPosition.BOTTOM,
				content: '<div class="b-map-icon"></div>',
				window: '<div class="b-maps__item"><div class="b-maps__item-title">' + map_info[info].name + '</div><div class="b-maps__item-address">' + map_info[info].adr + ',&nbsp;' + map_info[info].schedule + '.</div></div>',
				mark: '<div class="b-map-icon"></div>',
				status: false
			});
			latlngbounds.extend(markerLatLng);

			google.maps.event.addListener(marker, 'click', function () {
				if (this.status) {
					this.setContent(this.mark);
					this.status = false;
				} else {
					this.setContent(this.window);
					this.status = true;
				}
			});
		}
		map.fitBounds(latlngbounds);
		var listener = google.maps.event.addListener(map, "idle", function () {
			if (map_info.length == 1) {
				map.setZoom(17);
			} else {
				map.setZoom(map.getZoom() - 1);
			}
			google.maps.event.removeListener(listener);
		});
	}
});

function declension(num, expressions) {
	var result;
	count = num % 100;
	if (count >= 5 && count <= 20) {
		result = expressions['2'];
	} else {
		count = count % 10;
		if (count == 1) {
			result = expressions['0'];
		} else if (count >= 2 && count <= 4) {
			result = expressions['1'];
		} else {
			result = expressions['2'];
		}
	}
	return result;
}

function format_number(number) {
	var result1 = 0;
	var i1 = 0;
	var i2 = 0;
	var result1str = '';
	var result1fin = '';
	var i = 0;
	var str = '';
	result1 = Math.round(number);
	result1str = result1 + '';
	i1 = result1str.length % 3;
	i2 = result1str.length - i1;
	if (i1 > 0)    result1fin = result1str.substring(0, i1);
	i = i1;
	while (i < result1str.length) {
		result1fin = result1fin + ' ' + result1str.substring(i, i + 3);
		i = i + 3;
	}
	if (result1fin.substring(0, 1) == ' ') result1fin = result1fin.substring(1, result1fin.length);
	str = result1fin;
	return str;
}


// share 
Share2 = {
	vk: function (purl) {
		url = 'http://vkontakte.ru/share.php?';
		url += 'url=' + encodeURIComponent(purl);
		Share.popup(url);
	},
	od: function (purl, text) {
		url = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
		url += '&st._surl=' + encodeURIComponent(purl);
		Share.popup(url);
	},
	fb: function (purl) {
		url = 'http://www.facebook.com/sharer.php?s=100';
		url += '&u=' + encodeURIComponent(purl);
		Share.popup(url);
	},
	tw: function (purl, ptitle) {
		url = 'http://twitter.com/share?';
		url += 'text=' + encodeURIComponent(ptitle);
		url += '&url=' + encodeURIComponent(purl);
		url += '&counturl=' + encodeURIComponent(purl);
		Share.popup(url);
	},
	gp: function (purl) {
		url = 'https://plus.google.com/share?url='
		+ encodeURIComponent(purl);
		Share.popup(url);
	},
	lj: function (purl) {
		url = 'http://livejournal.com/update.bml?'
		+ 'event=' + encodeURIComponent('<a href="' + purl + '">' + purl + '</a>')
		+ '&transform=1';
		Share.popup(url);
	},

	popup: function (url) {
		window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
	}
};
$(function () {
	$(".js-social-share a").click(function (e) {
		e.preventDefault();
		var type = $(this).data('share');
		Share2[type](document.location, 'CupCakeStory');
	});
});