$(document).ready(function() {
	
	//mobile top menu
	$(".mobile-button-nav").click(function() {
		$('.b-header__bottom').toggleClass('open');
	});
	$('.b-bottom-nav a').click(function() {
		$('.b-header__bottom').removeClass('open');
	});
	
	
	
	//mobile  menu 	 account
	
	$(".account__navigation--mobile").click(function() {
		$('.b-block-account__navigation').toggleClass('open');
	});
	$('.b-account-navigation__mobile-wrap a').click(function() {
		$('.b-block-account__navigation').removeClass('open');
	});
	
	
	$(".cupcake__navigation--mobile").click(function() {
		$('.b-mobile-breadcrumbs').toggleClass('open');
	});
	$('.b-cupcake__navigation--mobile-first-line__list a').click(function() {
		$('.b-mobile-breadcrumbs').removeClass('open');
	});		
	
	//slider
	
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
	
	
	$('.b-slider-wrap-about-novelty').slick({
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
			infinite: true,
			dots: false
		  }
		},
		{
		  breakpoint: 650,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 2,			
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
		  breakpoint: 1100,
		  settings: {
			slidesToShow: 3,
			slidesToScroll: 3,
			infinite: true,
			dots: false
		  }
		},
		{
		  breakpoint: 650,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 2,			
			infinite: true,
			dots: false
		  }
		}/*,
		{
		  breakpoint: 480,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 2,			
			infinite: true,
			dots: false
		  }
		}*/

	  ]
	});		
	
	
	$('.b-slider-add-postcard__list, .b-slider-stock__list, .b-slider-wrap--stories').slick({
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
		  breakpoint: 650,
		  settings: {
			slidesToShow: 3,
			slidesToScroll: 3,			
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
	
	
	
	
	
	//galery		
	(function () {
		$(".slider-nav a").click(function(){
			var path = $(this).attr("href");
			var alt = $(this).attr("alt");
			$(".slider-for").animate({opacity: 0}, 1000, function(){
				$(this).html("<img src='" +path + "' />").find("img").bind("load",function(){
					$(this).parent().animate({opacity: 1},100);
				});
			});
			return false;		
		});
	})();
	


	
	(function () {
		var el = $('#questions-answers .questions-answers_title'),
			subEl = $('#questions-answers div.questions-answers-sub_nav'),	
			prevElement = el.next(subEl).prev();		

		prevElement.append('<span></span>');  
		el.click(function() {
			var checkedElement = $(this).next(subEl);
				visibleElement = subEl.filter(':visible');
				
			visibleElement.stop().animate({'height':'toggle'}, 300).prev().toggleClass('active');		
			if((checkedElement.is(subEl)) && (!checkedElement.is(':visible'))) {
				checkedElement.stop().animate({'height':'toggle'}, 300).prev().toggleClass('active');
			}
			return false;
		});
	})();
	


	
	(function () {
		var el = $('#order-history .b-order-history_title'),
			subEl = $('#order-history div.b-order-history-sub_nav'),	
			prevElement = el.next(subEl).prev();		

		prevElement.append('<span></span>');  
		el.click(function() {
			var checkedElement = $(this).next(subEl);
				visibleElement = subEl.filter(':visible');
				
			visibleElement.stop().animate({'height':'toggle'}, 300).prev().toggleClass('active');		
			if((checkedElement.is(subEl)) && (!checkedElement.is(':visible'))) {
				checkedElement.stop().animate({'height':'toggle'}, 300).prev().toggleClass('active');
			}
			return false;
		});
	})();
	




//select stylization
	$('select').each(function(){
		$(this).siblings('p').text( $(this).children('option:selected').text() );
	});
	$('select').change(function(){
		$(this).siblings('p').text( $(this).children('option:selected').text() );
	});
	





/*scroll*/

	$(window).scroll(function() {
		if ($(document).scrollTop() > 178)  {
				$('.b-header__bottom').addClass('menu-fixed');
		} else {
			$('.b-header__bottom').removeClass('menu-fixed');
		}
	});

	

/*menuleft*/


		var el = $('#nav_list_asaide li a');
		$('#nav_list_asaide li:has("ul")').append('<span></span>');		
		el.click(function() {
			var checkElement = $(this).next();	
			
			checkElement.stop().animate({'height':'toggle'}, 500).parent().toggleClass('active');
			if(checkElement.is('ul')) {
				return false;
			}		
		});

		
		
 
		
		
	$(window).stellar({
		 responsive: true
	});	
	



/*popup	*/


		
	$('.b-close-modal').click(function(){
		$(this).parent('.b-modal-personal_account, .b-modal--cupcake').hide();
		$(".overlay").hide();
	});


});	


$(function () {
	if (document.location.href.indexOf('contact') !== -1) {
		google.maps.event.addDomListener(window, 'load', gmaps_init);
	}


	function gmaps_init() {			
		var markerLatLng = new google.maps.LatLng(55.856755, 37.609479);
		
		var settings = {
			zoom: 13,
			center: markerLatLng,
			disableDefaultUI: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl:false,
			scrollwheel: false,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL,
				position: google.maps.ControlPosition.LEFT_CENTER
			}
		};

		var map = new google.maps.Map(document.getElementById("gmap"), settings);	
		
		var marker = new RichMarker({
			position: markerLatLng, 
			map: map,
			draggable: false,
			shadow: 'none',
			anchor: RichMarkerPosition.BOTTOM,
			content: '<div class="b-map-icon"></div>',
			window: '<div class="b-maps__item"><div class="b-maps__item-title">Название пункта 1</div><div class="b-maps__item-address">123456, Москва, Улица Отрадная, 45,&nbsp;кв. 48, с 10:00 до 17:00.</div></div>',
			mark: '<div class="b-map-icon"></div>',
			status: false
		});
		
		
		google.maps.event.addListener(marker, 'click', function() {
			if (this.status) {
				this.setContent(this.mark);
				this.status = false;
			}else{
				this.setContent(this.window);
				this.status = true;
			}
		});

	}
});
