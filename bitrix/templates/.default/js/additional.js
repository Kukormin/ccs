$(function () {
	$('.b-slider-add-postcard__list').on('init', function (e, slick) {
		slick.$slider.siblings('.add-postcard--title').find('.sum-add-postcard').text(slick.slideCount);
		var root = slick.$slider.closest('.add-postcard-wrap');
		if (slick.slideCount) {
			var item = slick.$slides.eq(0);
			$('.js-postcard-counter',root).val(item.data('quantity')).prev('.select_title').html(item.data('quantity'));
			$('.js-postcard-total-price',root).text(item.data('quantity')*item.data('price'));
		}
	});

	$('.b-slider-add-postcard__list').slick({
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
	
	$('.b-slider-add-postcard__list').on('reInit', function (e, slick) {
		slick.$slider.siblings('.add-postcard--title').find('.sum-add-postcard').text(slick.slideCount);
		if (slick.slideCount) {
			slick.$slider.prev().show();
			slick.$slider.next().show();
		}else{
			slick.$slider.prev().hide();
			slick.$slider.next().hide();
		}
	});
	
	
	
	$('.b-slider-add-postcard__list').on('afterChange', function (e, slick, currentSlide) {
		var item = slick.$slides.eq(currentSlide);
		var root = slick.$slider.closest('.add-postcard-wrap');
		$('.js-postcard-counter', root).val(item.data('quantity')).prev('.select_title').html(item.data('quantity'));
		$('.js-postcard-total-price', root).text(item.data('quantity')*item.data('price'));
	});
	
	$('.js-postcard-counter').change(function () {
		var root = $(this).closest('.add-postcard-wrap');
		var slider = root.find('.b-slider-add-postcard__list');
		var slick = slider.slick('getSlick');
		var index = slider.slick('slickCurrentSlide');
		var slide = slick.$slides.eq(index);
		slide.data('quantity', $(this).val());
		$('.js-postcard-total-price', root).text($(this).val()*slide.data('price'));
		$.post('/include/ajax_basket.php', {'ajaxaction': 'update', 'ajaxbasketcountid': slide.data('bid'), 'ajaxbasketcount': $(this).val()},
			function () {updateBasketPrice();}
		);
	});
	
	$(".js-postcard-block").each(function () {
		var root = $(this);
		var slider = root.find('.b-slider-add-postcard__list');
		$(".js-addable-postcard",root).change(function () {
			var src = $(this).closest('.js-postcard-item');
			if ($(this).is(':checked')) {
				
				
				var item = '<div class="b-slider__item"> \
					<div class="b-mod__item"> \
						<div class="b-mod__item-img"> \
							<div class="b-mod__item-img--effect-transform"> \
								<img src="'+src.find('.js-postcard-img').attr('src')+'" alt=""> \
							</div> \
						</div> \
					</div> \
					<div class="b-mod__item-title"> \
						<span class="postcard--name">'+src.find('.js-postcard-name').text()+'</span> \
						<span>'+src.find('.js-postcard-text').text()+'</span> \
					</div> \
				</div>';
				item = $(item);//.find('.b-slider__item');
				item.data('src',$(this));
				item.data('oid',src.data('oid'));
				item.data('price',src.find('.js-postcard-price').data('price'));
				item.data('quantity',1);
				slider.slick('slickAdd', item);
				
				var addId = slider.slick('getSlick').slideCount - 1;
				$(this).data('sliderid', addId);
                $('.js-postcard-total-price',root).text(item.data('quantity')*item.data('price'));
				$.post('/include/ajax_basket.php', {'ajaxaction': 'add', 'ajaxaddid': src.data('oid')},function (resp) {
					slider.slick('getSlick').$slides.eq(addId).data('bid',resp);
					src.data('bid',resp);
					updateBasketPrice();
				});
			}else{
				if (typeof $(this).data('sliderid') != 'undefined') {//remove from collection
					slider.slick('slickRemove',$(this).data('sliderid'));
					$.post('/include/ajax_basket.php', {'ajaxaction': 'delete', 'ajaxdeleteid': src.data('bid')},
					function () {updateBasketPrice();});
					
				}
			}
		});
	});
	
	$('.b-postcard-delete').click(function () {
		var slick = $(this).next('.b-slider-add-postcard__list');
		var index = slick.slick('slickCurrentSlide');
		var slide = slick.slick('getSlick').$slides.eq(index);
		if (slide.data('src')) 
			slide.data('src').find('.js-addable-postcard').prop('checked',false);
		if (typeof slide.data('oid') != 'undefined')
			$(this).closest('.js-postcard-block').find('.b-slider-wrap-postcard__list').slick('getSlick').$slides.find('[data-oid="'+slide.data('oid')+'"]').find('.js-addable-postcard').prop('checked',false);
		$.post('/include/ajax_basket.php', {'ajaxaction': 'delete', 'ajaxdeleteid': slide.data('bid')},function () {updateBasketPrice();});
		slick.slick('removeSlide', index);
	});
	
	$('.js-postcard-toggle').click(function (e) {
		$(".js-postcards-wrap").slideToggle(function () {$(window).resize()});
    });

    if ($('.b-postcard__item').length == 0) {
        $('.addition-order--title').hide();
        $('.js-postcards-wrap').hide();
    }

});