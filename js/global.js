function encrypt(string) {
	var salt = 'ujhuskedh!Â£)8J)o3uIoO4jjd3!';
	return $.rc4EncryptStr(string, salt);
}
function decrypt(string) {
	return $.rc4DecryptStr(string, 'ujhuskedh!Â£)8J)o3uIoO4jjd3!');
}

function hasWhiteSpace(s) {
	return /\s+/.test(s);
}

function strip_px(px) {
	return parseInt(px.substr(0, px.length - 2), 10);
}

function strcmp(str1, str2) {
	var str1 = str1.toLowerCase();
	var str2 = str2.toLowerCase();
	return (str1 == str2) ? 0 : ((str1 > str2) ? 1 : -1);
}

function input_enter_key(elem, callback) {
	$(elem).keypress(function(e) {
		switch(e.keyCode) {
			case 13:
				callback(elem);
			break;
		}
	});
}

function post(url, data, callback) {
	data.csrf_cyoa = $('[name="csrf_cyoa"]').val();
	$.post(url, data, function(return_data) {
		if (callback) {
			callback(return_data);
		}
	});
}

function template_loader() {
	var data = {
		self: this
		, partials : {}
	};

	this.load_templates = function(url, callback) {
		$.ajax({
			url: url //'js/templates/sprites.htm'
			, data: {}
			, success: function(templates) {
				data.templates = $(templates);
				$.each(data.templates, function(idx, template) {
					if (template.id) {
						data.partials[template.id] = $(template).html();
					}
				});
				callback();
			}
			, dataType: 'html'
			, error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus + ':' + errorThrown);
			}
		});
	};

	this.mustache_template = function(template_id) {
		return data.partials[template_id];
	};

	// elem is the jquery array of elements to apply template to
	// template_id is the loaded mustache template to render the data in to
	// template_data is the data to put in to the template
	// method is the jquery method to use on elem to put the rendered template in to the DOM (append, html)
	this.render = function(elem, template_id, template_data, method) {
		elem[method](this.renderHtml(template_id, template_data));
	};

	this.renderHtml = function(template_id, template_data) {
		return $.trim(Mustache.render(data.self.mustache_template(template_id), template_data, data.partials));
	};

}

function number_format (number, decimals, dec_point, thousands_sep) {
  // http://kevin.vanzonneveld.net
  // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +     bugfix by: Michael White (http://getsprink.com)
  // +     bugfix by: Benjamin Lupton
  // +     bugfix by: Allan Jensen (http://www.winternet.no)
  // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // +     bugfix by: Howard Yeend
  // +    revised by: Luke Smith (http://lucassmith.name)
  // +     bugfix by: Diogo Resende
  // +     bugfix by: Rival
  // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
  // +   improved by: davook
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Jay Klehr
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Amir Habibi (http://www.residence-mixte.com/)
  // +     bugfix by: Brett Zamir (http://brett-zamir.me)
  // +   improved by: Theriault
  // +      input by: Amirouche
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // *     example 1: number_format(1234.56);
  // *     returns 1: '1,235'
  // *     example 2: number_format(1234.56, 2, ',', ' ');
  // *     returns 2: '1 234,56'
  // *     example 3: number_format(1234.5678, 2, '.', '');
  // *     returns 3: '1234.57'
  // *     example 4: number_format(67, 2, ',', '.');
  // *     returns 4: '67,00'
  // *     example 5: number_format(1000);
  // *     returns 5: '1,000'
  // *     example 6: number_format(67.311, 2);
  // *     returns 6: '67.31'
  // *     example 7: number_format(1000.55, 1);
  // *     returns 7: '1,000.6'
  // *     example 8: number_format(67000, 5, ',', '.');
  // *     returns 8: '67.000,00000'
  // *     example 9: number_format(0.9, 0);
  // *     returns 9: '1'
  // *    example 10: number_format('1.20', 2);
  // *    returns 10: '1.20'
  // *    example 11: number_format('1.20', 4);
  // *    returns 11: '1.2000'
  // *    example 12: number_format('1.2000', 3);
  // *    returns 12: '1.200'
  // *    example 13: number_format('1 000,50', 2, '.', ' ');
  // *    returns 13: '100 050.00'
  // Strip all characters but numerical ones.
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function number_format_integer(integer) {
	return number_format(integer, 0, '.', ',');
}

function number_format_double(d) {
	return number_format(d, 2, '.', ',');
}

// protect your a!
function handle_event(run_function) {
	return function(e) {
		e.preventDefault();
		e.stopPropagation();
		// call sets "this" of the called function
		// the called function behaves as if jquery had called it by giving it the triggering element
		run_function.call(e.target, e);
	};
}
