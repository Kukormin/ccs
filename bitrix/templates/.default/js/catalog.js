/**
 * Панель фильтров
 */
var Filters = {
	price_from: 0,
	price_to: 0,
	price_min: 0,
	price_max: 0,
	price: false,
	mfWidth: 0,
	curMfg: false,
	priceInputFl: false,
	init: function() {
		this.panel = $('#filters-panel');
		this.catalogPath = this.panel.find('input[name=catalog_path]').val();
		this.separator = this.panel.find('input[name=separator]').val();
		this.q = this.panel.find('input[name=q]').val();
		this.groups = this.panel.find('.filter-group');
		this.cb = this.panel.find('input[type=checkbox]');
		this.ajaxCont = $('.js-ajax-content-block');
		this.bcCont = $('#bc');
		this.mobileFilters = $('#mobile-filters');
		this.mfWnd = this.mobileFilters.find('.wnd');
		this.mfCont = this.mobileFilters.find('#mf-cont');
		this.mfUl = this.mfCont.children('ul');
		this.mfL2 = this.mfCont.children('.level2');

		this.priceInit();
		this.mobileFilters.find(':checkbox').iphoneStyle({
			checkedLabel: '',
			uncheckedLabel: '',
			resizeContainer: false,
			resizeHandle: false,
			onChange: Filters.mobileCbChange
		});

		this.cb.click(this.checkboxClick);
		this.panel.on('click', '.filter-group li b', this.bClick);
		this.panel.on('click', 'h3', this.h3_s);
		this.ajaxCont.on('click', '#current-filters a', this.urlClick);
		this.ajaxCont.on('click', '.js-catalog-pager a', this.urlClick);
		this.ajaxCont.on('click', '.show_all_btn', this.urlClick);
		this.bcCont.on('click', 'a', this.urlClick);
		this.mobileFilters.on('click', 'h3', this.m_h3_s);
		this.mobileFilters.on('click', 'h3 b', this.m_h3_b);
		this.mobileFilters.on('click', '#mf-cont > ul li', this.m_li_s);
		this.mobileFilters.on('click', '.mfg > span', this.clearGroup);

		$(window).on('popstate', function (e) {
			var url = e.target.location;
			Filters.loadProducts(url, false);
		});
	},
	priceInit: function() {
		this.priceDiv = $('#price_slider');
		if (!this.priceDiv.length)
			return;
		this.mPriceDiv = $('#mprice_slider');
		this.priceGroup = this.priceDiv.closest('.filter-group');
		this.inputFrom = this.priceGroup.find('#from');
		this.inputTo = this.priceGroup.find('#to');
		this.inputMFrom = $('#mfrom');
		this.inputMTo = $('#mto');

		this.price_from = this.priceDiv.data('from');
		this.price_to = this.priceDiv.data('to');
		this.price_min = this.priceDiv.data('min');
		this.price_max = this.priceDiv.data('max');

		if (this.price_min == this.price_max)
			return;

		this.price = noUiSlider.create(this.priceDiv.get(0), {
			start: [this.price_from, this.price_to],
			connect: true,
			step: 100,
			range: {
				'min': this.price_min,
				'max': this.price_max
			}
		});
		this.mprice = noUiSlider.create(this.mPriceDiv.get(0), {
			start: [this.price_from, this.price_to],
			connect: true,
			step: 100,
			range: {
				'min': this.price_min,
				'max': this.price_max
			}
		});
		this.price.on('change', Filters.priceChange);
		this.mprice.on('change', Filters.priceChange);
		this.price.on('update', function(e) {
			if (Filters.priceInputFl)
				return;

			Filters.inputFrom.val(parseInt(e[0]));
			Filters.inputTo.val(parseInt(e[1]));
		});
		this.mprice.on('update', function(e) {
			if (Filters.priceInputFl)
				return;

			Filters.inputMFrom.val(parseInt(e[0]));
			Filters.inputMTo.val(parseInt(e[1]));
		});
		this.inputFrom.on('input', function() {
			Filters.price_from = parseInt($(this).val());
			Filters.priceInputFl = true;
			Filters.price.set([Filters.price_from, Filters.price_to]);
			Filters.priceInputFl = false;
		});
		this.inputMFrom.on('input', function() {
			Filters.price_from = parseInt($(this).val());
			Filters.priceInputFl = true;
			Filters.mprice.set([Filters.price_from, Filters.price_to]);
			Filters.priceInputFl = false;
		});
		this.inputFrom.on('change', Filters.updateProducts);
		this.inputMFrom.on('change', Filters.updateProducts);
		this.inputTo.on('input', function() {
			Filters.price_to = parseInt($(this).val());
			Filters.priceInputFl = true;
			Filters.price.set([Filters.price_from, Filters.price_to]);
			Filters.priceInputFl = false;
		});
		this.inputMTo.on('input', function() {
			Filters.price_to = parseInt($(this).val());
			Filters.priceInputFl = true;
			Filters.mprice.set([Filters.price_from, Filters.price_to]);
			Filters.priceInputFl = false;
		});
		this.inputTo.on('change', Filters.updateProducts);
		this.inputMTo.on('change', Filters.updateProducts);
	},
	priceChange: function(e) {
		Filters.price_from = parseInt(e[0]);
		Filters.price_to = parseInt(e[1]);
		Filters.updateProducts();
	},
	priceCorrect: function(data) {
		Filters.price_from = data.FROM;
		Filters.price_to = data.TO;
		Filters.price.set([Filters.price_from, Filters.price_to]);
		Filters.mprice.set([Filters.price_from, Filters.price_to]);
	},
	h3_s: function() {
		var gr = $(this).parent();
		var div = gr.children('div');
		if (gr.hasClass('closed')) {
			gr.removeClass('closed');
			div.stop().slideDown();
		}
		else {
			gr.addClass('closed')
			div.stop().slideUp();
		}
		var val = '';
		Filters.groups.each(function() {
			var s = $(this).hasClass('closed') ? 1 : 0;
			val += s + ',';
		});
		var d = new Date();
		d.setTime(d.getTime() + 8640000000);
		document.cookie = "filter_groups=" + val + "; path=/; expires=" + d.toUTCString();
	},
	checkboxClick: function() {
		var input = $(this);
		Filters.updateCb(input);
	},
	bClick: function() {
		var input = $(this).siblings('label').children('input');
		var checked = input.prop('checked');
		input.prop('checked', !checked);
		Filters.updateCb(input);
	},
	updateCb: function(input) {
		var li = input.closest('li');
		var checked = input.prop('checked');
		if (checked)
			li.addClass('checked');
		else
			li.removeClass('checked');
		Filters.updateProducts();
	},
	updateProducts: function() {
		var url = Filters.catalogPath;
		Filters.groups.each(function() {
			var cb = $(this).find('input[type=checkbox]:checked');
			var part = '';
			cb.each(function() {
				if (part)
					part += Filters.separator;
				part += $(this).attr('name');
			});
			if (part)
				url += part + '/';
		});
		var params = '';
		if (Filters.q) {
			params += params ? '&' : '?';
			params += 'q=' + Filters.q;
		}
		if (Filters.price_from <= Filters.price_to) {
			if (Filters.price_from > Filters.price_min) {
				params += params ? '&' : '?';
				params += 'p-from=' + Filters.price_from;
			}
			if (Filters.price_to < Filters.price_max) {
				params += params ? '&' : '?';
				params += 'p-to=' + Filters.price_to;
			}
		}
		url += params;
		Filters.loadProducts(url, true);
	},
	loadProducts: function(url, setHistory) {
		//window.location = url;
		$.post(url, {
			'mode': 'ajax'
		}, function (resp) {
			Filters.ajaxCont.html(resp.HTML);
			Filters.bcCont.html(resp.BC);
			for (var i in resp.FILTERS) {
				if (i == 'PRICE') {
					Filters.priceCorrect(resp.FILTERS[i]);
				}
				else {
					var cnt = resp.FILTERS[i][0];
					var checked = resp.FILTERS[i][1];
					var cb = Filters.panel.find('input[name=' + i + ']');
					var li = cb.closest('li');
					cb.prop('checked', checked);
					if (checked)
						li.addClass('checked');
					else
						li.removeClass('checked');
					if (cnt) {
						cb.prop('disabled', false);
						li.removeClass('disabled');
						//li.stop().slideDown();
					}
					else {
						cb.prop('disabled', true);
						li.addClass('disabled');
						//li.stop().slideUp();
					}
					cb.siblings('i').text(cnt);

					// мобилка
					cb = Filters.mobileFilters.find('input[data-code=' + i + ']');
					li = cb.closest('li');
					var old = cb.prop('checked');
					if (checked && !old || !checked && old) {
						cb.prop('checked', checked);
						cb.iphoneStyle("didChange");
						if (checked)
							li.addClass('checked');
						else
							li.removeClass('checked');
					}
					if (cnt) {
						cb.prop('disabled', false);
						li.removeClass('disabled');
						//li.stop().slideDown();
					}
					else {
						cb.prop('disabled', true);
						li.addClass('disabled');
						//li.stop().slideUp();
					}
					li.find('i').text(cnt);
				}
			}

			/*Filters.panel.find('.filter-group:not(.filter-group-price)').each(function() {
				var l = $(this).find('li:not(.disabled)').length;

				if (l) {
					$(this).stop().slideDown();
				}
				else {
					$(this).stop().slideUp();
				}
			});*/

			var all = 0;
			Filters.mfUl.children('li').each(function() {
				var id = $(this).data('id');
				var mfg = Filters.mobileFilters.find('#mfg' + id);
				var ps = mfg.find('.price-group');
				var l = 0;
				if (ps.length) {
					if (Filters.price_from <= Filters.price_to) {
						if (Filters.price_from > Filters.price_min)
							l++;
						if (Filters.price_to < Filters.price_max)
							l++;
					}
				}
				else
					l = mfg.find('li.checked').length;
				var cnt = l ? '(' + l + ')' : '';
				$(this).find('i').text(cnt);
				all += l;
				/*var l = mfg.find('li:not(.disabled)').length;

				if (l) {
					$(this).stop().slideDown();
				}
				else {
					$(this).stop().slideUp();
				}*/
			});

			var allCnt = all ? '(' + all + ')' : '';
			Filters.mobileFilters.find('h3 i').text(allCnt);

			document.title = resp.TITLE;
			if (setHistory)
				history.pushState('', resp.TITLE, url);

			Filters.q = resp.SEARCH;

			return false;
		});
	},
	urlClick: function() {
		var url = $(this).attr('href');
		if (url == '/')
			return true;

		Filters.loadProducts(url, true);
		return false;
	},
	mobileCbChange: function(cb, value) {
		var code = cb.data('code');
		var li = cb.closest('li');
		if (value)
			li.addClass('checked');
		else
			li.removeClass('checked');
		var dt = Filters.panel.find('input[name=' + code + ']');
		dt.prop('checked', value);
		Filters.updateProducts();
	},
	resize: function() {
		Filters.mfWidth = Filters.mobileFilters.width();
		Filters.mfCont.width(Filters.mfWidth * 2 + 1);
		Filters.mfUl.width(Filters.mfWidth);
		Filters.mfL2.width(Filters.mfWidth);
	},
	m_h3_s: function() {
		Filters.resize();
		Filters.mobileFilters.toggleClass('closed');
		Filters.mobileFilters.removeClass('l2');
		Filters.mfCont.animate({left: 0});
		if (Filters.mobileFilters.hasClass('closed'))
			Filters.mfWnd.stop().slideUp();
		else
			Filters.mfWnd.stop().slideDown();
		if (Filters.curMfg)
			Filters.curMfg.hide();
	},
	m_h3_b: function(e) {
		e.stopPropagation();
		Filters.mfCont.animate({left: 0});
		Filters.mobileFilters.removeClass('l2');
		Filters.curMfg.hide();
	},
	m_li_s: function() {
		Filters.resize();
		var id = $(this).data('id');
		Filters.curMfg = Filters.mobileFilters.find('#mfg' + id);
		Filters.curMfg.show();
		Filters.mfCont.animate({left: '-' + Filters.mfWidth + 'px'});
		Filters.mobileFilters.addClass('l2');
	},
	clearGroup: function() {
		var mfg = $(this).parent();
		var ps = mfg.find('.price-group');
		var i = 0;
		if (ps.length) {
			if (Filters.price_from != Filters.price_min || Filters.price_to != Filters.price_max) {
				Filters.price_from = Filters.price_min;
				Filters.price_to = Filters.price_max;
				Filters.mprice.set([Filters.price_from, Filters.price_to]);
				i = 2;
			}
		}
		else {
			mfg.find('input:checked').each(function() {
				var cb = $(this);
				var li = cb.closest('li');
				cb.prop('checked', false);
				cb.iphoneStyle("didChange");
				li.removeClass('checked');
				var code = cb.data('code');
				var dt = Filters.panel.find('input[name=' + code + ']');
				dt.prop('checked', false);
				i++;
			});
		}
		if (i)
			Filters.updateProducts();
	}
};

/**
 * Карточка товара и быстрый просмотр
 */
var Detail = {
	init: function() {
		this.cont = $('.js-ajax-content-block');
		this.modals = $('.b-modal');
		this.overlay = $('.overlay');
		this.countSelect = $('.js_detail_count');
		this.addBtn = $('.js-add-to-basket');
		this.pickupBtn = $('#js_show_delivery_popup');
		this.pickupModal = $('.js_delivery_modal');
		this.headCart = $('.js-basket-total-count');

		this.cont.on('click', '.quick-detail', this.loadModal);
		this.countSelect.on('change', this.countChange);
		this.addBtn.click(this.addToCart);
		this.modals.on('change', '.js_detail_count', this.countChange);
		this.modals.on('click', '.js-add-to-basket', this.addToCart);
		this.pickupBtn.click(this.showPickupPopup);

		$('.quick-add-cart').on('click', this.quickAddToCart);
	},
	loadModal: function() {
		var id = $(this).data('id');
		var modal = $('#modal_' + id);
		Detail.overlay.show();
		if (!modal.length) {
			var url = '/ajax/product_modal.php?id=' + id;
			$.get(url, function (data) {
				modal = $(data);
				Detail.modals.append(modal);
				Detail.showModal(modal);
			});
		}
		else
			Detail.showModal(modal);
	},
	showModal: function(modal) {
		var top = $(window).scrollTop() + 25;
		modal.show().css({'top': top});
	},
	countChange: function () {
		var id = $(this).val();
		var price = $('#p-' + id).val();
		var dPrice = $('#dp-' + id).val();
		var product = $(this).closest('.js-product');
		var priceBlock = product.find('.js-priceblock');
		var addBtn = product.find('.js-add-to-basket');
		priceBlock.find('.b-old-price .v').text(Detail.priceFormat(dPrice));
		priceBlock.find('.b-new-price .v').text(Detail.priceFormat(price));
		addBtn.data('offer', id);
		if (dPrice > price)
			priceBlock.removeClass('hide-old-price');
		else
			priceBlock.addClass('hide-old-price');
	},
	addToCart: function(e) {
		e.preventDefault();

		var btn = $(this);

		if (btn.hasClass('js-go-to')) {
			location.href = btn.data('href');
			return false;
		}

		var id = btn.data('id');
		var offer = btn.data('offer');
		var product = btn.closest('.js-product');
		var price = product.find('.js-priceblock');
		if (price.length) {
			var moved = price.clone();
			var pos = price.offset();
			var toPos = Detail.headCart.offset();
			moved.css({
				position: 'absolute',
				left: pos.left,
				top: pos.top,
				'zIndex': 999
			});
			$('body').append(moved);
			moved.animate({
				left: toPos.left - 40,
				top: toPos.top - 60,
				opacity: 0
			}, function() {
				moved.remove();
			});
		}

		$.post('/ajax/cart_action.php', {
			'action': 'add',
			'id': id,
			'offer': offer,
			'quantity': 1
		}, function (resp) {
			if (resp != 0) {
				btn.addClass('js-go-to').text('к корзине');
				Detail.headCart.text(resp);

				try { rrApi.addToBasket(id) } catch(e) {}
			}
		});
	},
	quickAddToCart: function(e) {
		e.preventDefault();

		var btn = $(this);

		if (btn.hasClass('js-go-to')) {
			location.href = btn.data('href');
			return false;
		}

		var id = btn.data('id');
		/*var product = btn.closest('.js-product');
		var price = product.find('.js-priceblock');
		if (price.length) {
			var moved = price.clone();
			var pos = price.offset();
			var toPos = Detail.headCart.offset();
			moved.css({
				position: 'absolute',
				left: pos.left,
				top: pos.top,
				'zIndex': 999
			});
			$('body').append(moved);
			moved.animate({
				left: toPos.left - 40,
				top: toPos.top - 60,
				opacity: 0
			}, function() {
				moved.remove();
			});
		}*/

		$.post('/ajax/cart_action.php', {
			'action': 'add',
			'id': id,
			'quantity': 1
		}, function (resp) {
			if (resp != 0) {
				btn.addClass('js-go-to');
				Detail.headCart.text(resp);

				try { rrApi.addToBasket(id) } catch(e) {}
			}
		});
	},
	priceFormat: function(v) {
		var l = v.length;
		if (l > 3 && l < 7) {
			var x = l - 3;
			v = v.substr(0, x) + ' ' + v.substr(x);
		}
		return v;
	},
	showPickupPopup: function() {
		Detail.pickupModal.find('#offer_id').val(Detail.addBtn.data('offer'));
		Detail.overlay.show();
		Detail.showModal(Detail.pickupModal);
	}
};

$(document).ready(function() {
	Filters.init();
	Detail.init();
});