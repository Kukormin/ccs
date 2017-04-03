var date = new Date();
var SelectedDate;
var input;
var tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
tomorrow.setHours(0);
tomorrow.setMinutes(0);
tomorrow.setSeconds(0);
var afterTomorrow = new Date();
afterTomorrow.setDate(afterTomorrow.getDate() + 2);
var FREE_DELIVERY_SELECTED = false;


function insertNodeText(obj, text) {
	var txtNode = document.createTextNode(text);
	obj.appendChild(txtNode);
	return obj;
}

function insertButton(obj, text, flag) {
	for (var i = 0; i < 2; i++) {
		var button = document.createElement('Button');
		var caption = (i == flag) ? text + text : text;
		button = insertNodeText(button, caption);
		button.onclick = controlButton;
		obj.appendChild(button).classList.add('arr-cal');
	}
}

function getCoords(elem) {
	var box = elem.getBoundingClientRect();
	var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
	var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft;
	var clientTop = document.documentElement.clientTop || document.body.clientTop || 0;
	var clientLeft = document.documentElement.clientLeft || document.body.clientLeft || 0;
	var top = box.top + scrollTop - clientTop;
	var left = box.left + scrollLeft - clientLeft;
	return {top: Math.round(top) + elem.offsetHeight + 'px', left: Math.round(left) + 'px'}
}

function getCountDay(index) {
	var months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	if (date.getFullYear() % 4 == 0)
		months[1]++;
	return months[index];
}

function getCountWeek(date) {
	date.setDate(1);
	return Math.ceil((getCountDay(date.getMonth()) + getNumberDay(date)) / 7);
}

function getNumberDay(date) {
	var days = [6, 0, 1, 2, 3, 4, 5];
	return days[date.getDay()];
}

function getNumberFirstDay(date) {
	date.setDate(1);
	return getNumberDay(date);
}

function controlButton() {
	if (this.lastChild.nodeValue.length == 1) {
		var m = (this.lastChild.nodeValue == '<') ? date.getTime() - (24 * 60 * 60 * 1000 * date.getDate()) : date.getTime() + (24 * 60 * 60 * 1000 * (getCountDay(date.getMonth()) - date.getDate() + 1));
		date.setTime(m);
	}
	/*else {
	 var Y = (this.lastChild.nodeValue == '<<')? date.getFullYear() - 1 : date.getFullYear() + 1;
	 date.setFullYear(Y);
	 }*/
	generateCalendar();
}

function createTable() {
	var days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];

	var body = document.getElementsByTagName('body')[0];
	var div = document.createElement('div');
	body.appendChild(div);
	div.setAttribute('id', 'calendar', 0);
	div.className = 'calendar-wrapper';

	var tbl = document.createElement("table");
	div.appendChild(tbl);

	tbl.setAttribute('align', 'center', 0);
	tbl.setAttribute('cellpadding', '0', 0);
	tbl.setAttribute('cellspacing', '0', 0);

	var row = tbl.insertRow(-1);
	row.setAttribute('id', 'first-child', 0);

	// первая ячейка
	var cell = row.insertCell(-1);
	cell.setAttribute('colspan', '2', 0);
	cell.className = 'lalign';
	cell = insertButton(cell, '<', 0);

	// вторая ячейка
	cell = row.insertCell(-1);
	cell.setAttribute('colspan', '3', 0);

	// третья ячейка
	cell = row.insertCell(-1);
	cell.setAttribute('colspan', '2', 0);
	cell.className = 'ralign';
	cell = insertButton(cell, '>', 1);

	row = tbl.insertRow(-1);
	row.className = 'day';
	for (var i = 0; i < 7; i++) {
		cell = row.insertCell(-1);
		cell = insertNodeText(cell, days[i]);
	}
}

function generateCalendar() {
	var wrapper = document.getElementById('calendar');
	if (!wrapper)
		return;

	var tbl = wrapper.getElementsByTagName('table')[0];

	var months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

	tbl.rows[0].cells[1].innerHTML = months[date.getMonth()] + ' ' + date.getFullYear();

	while (tbl.rows.length > 2)
		tbl.deleteRow(tbl.rows.length - 1);

	var flag = false;
	var countday = 1;
	var currdate = new Date();
	var fromDate = getNextDeliveryDate(currdate);
	var thisMonth = SelectedDate && date.getMonth() == SelectedDate.getMonth() && date.getFullYear() == SelectedDate.getFullYear();

	for (var i = 0; i < getCountWeek(date); i++) {
		var row = tbl.insertRow(-1);
		for (var j = 0; j < 7; j++) {
			var cell = row.insertCell(-1);
			if (j == getNumberFirstDay(date))
				flag = true;
			if (countday > getCountDay(date.getMonth()))
				flag = false;
			if (flag) {
				cell = insertNodeText(cell, countday);
				var clickHandler = false;

				var cmp = compare(fromDate.getFullYear(), fromDate.getMonth(), fromDate.getDate(),
					date.getFullYear(), date.getMonth(), countday);
				var s = countday + '.' + (date.getMonth() + 1) + '.' + date.getFullYear();
				var is_holiday = isHoliday2(j, s);
				if (cmp != -1) {
					if (is_holiday)
						cell.className = 'holiday';
					else {
						if (isFreeDelivery(s))
							cell.className = 'dd free';
						else
							cell.className = 'dd';
						clickHandler = true;
					}
				}
				cmp = compare(currdate.getFullYear(), currdate.getMonth(), currdate.getDate(),
					date.getFullYear(), date.getMonth(), countday);
				if (cmp == 0)
					cell.className = 'CurrDay';
				if (SelectedDate && thisMonth && SelectedDate.getDate() == countday) {
					cell.className = 'dd Select'
				}

				if (clickHandler) {
					cell.onclick = function () {
						document.getElementById('calendar').style.display = 'none';
						var d = this.lastChild.nodeValue;
						date.setDate(d);
						var dd = (d < 10) ? '0' + d : d;
						var m = date.getMonth() + 1;
						var mm = (m < 10) ? '0' + m : m;
						var y = date.getFullYear();
						input.value = dd + '.' + mm + '.' + y;
						FREE_DELIVERY_SELECTED = isFreeDelivery(d + '.' + m + '.' + y);
						correct8m(d + '.' + m + '.' + y);
						$('.js_radio_input input').change();
					};
				}

				countday++;
			}
			else {
				cell.style.border = 'none';
				cell = insertNodeText(cell, ' ');
			}
		}
	}
}

function compare(y1, m1, d1, y2, m2, d2) {
	if (y1 > y2)
		return -1;
	else if (y1 < y2)
		return 1;
	else if (m1 > m2)
		return -1;
	else if (m1 < m2)
		return 1;
	else if (d1 > d2)
		return -1;
	else if (d1 < d2)
		return 1;
	else
		return 0;
}

function isHoliday1(d) {
	if (sunday_holidays && (d.getDay() == 0))
		return true;
	var s = d.getDate() + '.' + (d.getMonth() + 1) + '.' + d.getFullYear();
	return inHolidays(s);
}

function isHoliday2(dow, s) {
	if (sunday_holidays && (dow == 6))
		return true;
	return inHolidays(s);
}

function inHolidays(s) {
	for (var i in holidays) {
		var tmp = holidays[i];
		if (tmp == s)
			return true;
	}
	return false;
}

function isFreeDelivery(s) {
	for (var i in free_delivery) {
		var tmp = free_delivery[i];
		if (tmp == s)
			return true;
	}
	return false;
}

function correct8m(s) {
	var m8 = s == '14.4.2017' || s == '15.4.2017';
	if (m8) {
		$('.js-default-int').hide();
		$('.js-8m-int').show();
	}
	else {
		$('.js-default-int').show();
		$('.js-8m-int').hide();
	}

}

function getNextDeliveryDate(d) {
	var nowHours = d.getUTCHours();
	var nowMinutes = d.getMinutes();
	var evening = (nowHours > dhour) || (nowHours == dhour && nowMinutes >= dminutes);
	var fromDate = new Date(d);
	var add = evening || isHoliday1(fromDate) ? 2 : 1; // сколько рабочих дней добавить
	while (add > 0) {
		fromDate.setDate(fromDate.getDate() + 1);
		if (!isHoliday1(fromDate))
			add--;
	}

	return fromDate;
}

function showcalendar(input_date) {
	input = input_date;
	var wrapper = document.getElementById('calendar');
	if (!wrapper)
		return;

	if (input.value != '') {
		// Разделяем переданную дату
		var ar = input.value.split('.');
		// Массив параметров (День, Месяц, Год)
		// В Конструктор Date передаем в другом порядке, а именно: Год, Месяц, День
		// ar[2] - Год
		// ar[1] - Месяц
		// ar[0] - День
		// В JavaScript месяца идут с 0 до 11, поэтому мы от номера месяца отнимаем единицу
		date = new Date(ar[2], ar[1] - 1, ar[0]);
		SelectedDate = new Date(date);
	}

	generateCalendar();

	wrapper.style.left = getCoords(input).left;
	wrapper.style.top = getCoords(input).top;
	wrapper.style.display = (wrapper.style.display == "block") ? "none" : "block";
}

if (window.addEventListener)
	window.addEventListener('load', createTable, false);
else if (window.attachEvent)
	window.attachEvent('onload', createTable);