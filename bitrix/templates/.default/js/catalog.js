var Filters = {
	price_from: 0,
	price_to: 0,
	price_min: 0,
	price_max: 0,
	init: function() {
		this.panel = $('#filters-panel');
		this.catalogPath = this.panel.find('input[name=catalog_path]').val();
		this.separator = this.panel.find('input[name=separator]').val();
		this.groups = this.panel.find('.filter-group');
		this.cb = this.panel.find('input[type=checkbox]');

		this.priceInit();

		this.cb.click(this.checkboxClick);
	},
	priceInit: function() {
		this.priceDiv = $('#price_slider');
		if (!this.priceDiv.length)
			return;

		this.price_from = this.priceDiv.data('from');
		this.price_to = this.priceDiv.data('to');
		this.price_min = this.priceDiv.data('min');
		this.price_max = this.priceDiv.data('max');
		this.price = noUiSlider.create(this.priceDiv.get(0), {
			start: [this.price_from, this.price_to],
			connect: true,
			step: 100,
			range: {
				'min': this.price_min,
				'max': this.price_max
			}
		});
		this.price.on('change', function(e) {
			Filters.price_from = parseInt(e[0]);
			Filters.price_to = parseInt(e[1]);
			Filters.updateProducts();
		});
	},
	checkboxClick: function() {
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
		if (Filters.price_from > Filters.price_min) {
			params += params ? '&' : '?';
			params += 'p-from=' + Filters.price_from;
		}
		if (Filters.price_to < Filters.price_max) {
			params += params ? '&' : '?';
			params += 'p-to=' + Filters.price_to;
		}
		url += params;
		window.location = url;
	}

};

$(document).ready(function() {
	Filters.init();
});