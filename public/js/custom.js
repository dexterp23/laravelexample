function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}



function load_JS_object (filename) {
	
	var fileref=document.createElement('script');
	fileref.setAttribute("type","text/javascript");
	fileref.setAttribute("src", filename);
	fileref.setAttribute("name", filename);
	
	var load_chk=document.getElementsByName(filename);
	
	if (typeof fileref!="undefined" && load_chk.length==0) document.getElementsByTagName("head")[0].appendChild(fileref);
	
}



function textCounter(field, countfield, maxlimit) {
    if (field.value.length > maxlimit) // if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
        // otherwise, update 'characters left' counter
    else
        countfield.value = maxlimit - field.value.length;
}



function htmlspecialchars (unsafe) {
  return unsafe
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}



function addslashes(str) {
	str=str.replace(/\\/g,'\\\\');
	str=str.replace(/\'/g,'\\\'');
	str=str.replace(/\"/g,'\\"');
	str=str.replace(/\0/g,'\\0');
	return str;
}



function stripslashes(str) {
	str=str.replace(/\\'/g,'\'');
	str=str.replace(/\\&quot;/g,'\&quot;');
	str=str.replace(/\\"/g,'"');
	str=str.replace(/\\0/g,'\0');
	str=str.replace(/\\\\/g,'\\');
	return str;
}



function urlencode (str) {

	encodeURIComponent(str.replace(/&amp;/g, "&"));
	
	return str;
	
}



//brise polja iz forme
function clear_form_elements(ele) {

	jQuery(ele).find(':input').each(function() {
		switch(this.type) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'tel':
			case 'email':
			case 'number':
			case 'textarea':
				$(this).val('');
				break;
			case 'checkbox':
			case 'radio':
				this.checked = false;
		}
	});

}



function number_format (number, decimals, dec_point, thousands_sep) {

    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');    }
    return s.join(dec);
}



//izbacuje odredjeni value iz niza
function removeItem(array, item){
	for(var i in array){
		if(array[i]==item){
			array.splice(i,1);
			break;
			}
	}
}
	
	
	
//kopira multidimenzioni niz
function deepCopy(obj) {
	if (Object.prototype.toString.call(obj) === '[object Array]') {
		var out = [], i = 0, len = obj.length;
		for ( ; i < len; i++ ) {
			out[i] = arguments.callee(obj[i]);
		}
		return out;
	}
	if (typeof obj === 'object') {
		var out = {}, i;
		for ( i in obj ) {
			out[i] = arguments.callee(obj[i]);
		}
		return out;
	}
	return obj;
}




//daje nam broj nedelja u mesecu
function getSundaysNumber (d) {
	var day = 1;
	var c= 0;
	var d = new Date(d);
	var year = d.getFullYear();
	var month = d.getMonth();
	var date = new Date(year, month, day);
	while(date.getMonth() === month) {
		if(date.getDay() === 6) {
			c++;
		}
		day++;
		date = new Date(year, month, day);
	}
	return c;
}




function mouseLoader (e) {
	
	//App.blockUI($("#content"));
	
	if (!$('#mouseLoader').length) {
		
		$('body').prepend('<div id="mouseLoader"></div>');
		
	}
	
	$('#mouseLoader').show().css({
		top: (e.pageY + 15) + "px",
		left: (e.pageX + 15) + "px"
	});
	

	$(document).mousemove(function(e){
		$('#mouseLoader')
		.css({
            top: (e.pageY + 15) + "px",
            left: (e.pageX + 15) + "px"
        });
    });
	
}
function mouseLoaderHide () {
	
	//App.unblockUI($("#content"));
	$('#mouseLoader').hide();
	
}


function mouseLoader_2 () {
	
	if (!$('#mouseLoader_2').length) {
		
		$('body').prepend('<div id="mouseLoader_2"></div>');
		
	}
	
}
function mouseLoaderHide_2 () {

	$('#mouseLoader_2').remove();
	
}



function sys_messages_click (message, type_message, type, fade_chk) {
	
	var content = '<div class="sys_messages_hold">';
	
	switch(type_message) {
	case 'ok':
		content += '<div class="ok">' + message + '</div>';
	break;
	case 'error':
		content += '<div class="error">' + message + '</div>';
	break;
	default:
		content += '<div class="regular">' + message + '</div>';
	}
	
	content += '</div>';
	
	sys_message_onload (content, type, fade_chk);
	
}



function sys_message_onload (message, type, fade_chk, id, title, box_type, footer) {
	
	if (message) {
		
		if (type=="popup") {

			if (!title) title='&nbsp;';
			/*
			<button type="button" class="bootbox-close-button close" data-dismiss="modal" style="margin-top: -10px;">×</button>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style=" margin-top:-8px; opacity: 1;"><img src="/images/close-icon.png" style="width:36px;height:36px;" /></button>
			*/
			var html = '<div id="dModal" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">'+title+'</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body m-3">'+message+'</div>';
			if (footer) html += '<div class="modal-footer">'+footer+'</div>';
			html += '</div></div></div>';
			
			$('#sys_messages_popup').html(html);
			$('#dModal').modal({
				backdrop: true,
				keyboard: true
			});
			
			$(document).keyup(function(e) {
				if (e.keyCode == 27) modalClose ('#dModal', '#sys_messages_popup');
			});

		}
		
		if (type=="box") {
			if (!id || typeof(id) == 'undefined') id = 'sys_message_box';
			document.getElementById(id).style.display = 'block';
			$('#' + id).html(message);
			if (fade_chk == 1) setTimeout(function(){$('#' + id).fadeOut('slow');},5000);
		}
		
		if (type=="box_2") {
			
			if (!box_type) box_type='alert'; //alert, success, error, warning, information
			
			noty({
				text: message,
				type: box_type,
				layout: 'top',
				timeout: 2000
			});

		}
		
	}
	
}


function TextView (id, title) {
	
	if (typeof(title) == 'undefined') title = '';
	var text = $(id).val();
	if (!text) text = $(id).html();
	if (!text) text = '&nbsp;';
	sys_message_onload (text, 'popup', false, false, title);
	
}



function modalClose (id_modal, id_html) {
	
	$(id_modal).modal('hide');
	setTimeout(function(){ $(id_html).html(''); }, 500);
		
}



function modalIframePopup (url) {

	sys_message_onload ('<div style="height:650px;"><iframe width="100%" height="650" src="'+url+'" align="left" scrolling="yes" frameborder="0" name="results"></iframe></div>', 'popup');
	
}



function Remove (id) {

	$('.remove_'+id).html('');
	$('.remove_'+id).hide();

}



function Toggle (id) {
	
	$(id).animate({'height':'toggle'}, 'fast');
	
}


function Toggle_slide (id_hide, id_show) {

	$(id_hide).hide('slide',{ direction: 'right' }, 250, function () {
		$(id_show).show('slide',{ direction: 'left' }, 250, function () {
			$(id_hide).hide();
		});
	});
	
}


function scrollPage (id, speed, destination) {
	
	if (typeof(destination) == 'undefined' && typeof(id) !== 'undefined' && id !== false) {
		destination = $(id).offset().top;
		destination = destination - 20;
	}
	if (typeof(destination) == 'undefined') destination = 0;
	if (typeof(speed) == 'undefined') speed = 500;

	$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, speed );
	
}


function accordionCustom (id) {
	
	if ($('.accordionCustom_hold').is(':visible')) {
		if ($(id).is(':visible')) {
			$(id).slideUp("slow");
		} else {
			$('.accordionCustom_hold').hide(function () {
				setTimeout(function(){ $(id).slideDown("slow"); }, 100);
			});
		}
	} else {
		$(id).slideDown("slow");
	}
	
}



function uniformStartup () {
	
	$(".uniform-styles").uniform();
	//$(".uniform-styles, .uniform-styles-wrapper input, .uniform-styles-wrapper select, .uniform-styles-wrapper textarea").uniform();
	
}



//podesavamo neke css vrednostni dinamicki
function css_setup () {

	var browser_width = $(window).width();
	var html_width = $(document).width();
	var browser_height = $(window).height();
	var html_height = $(document).height();

}



function daysInMonth(month,year) {
	return new Date(year, month, 0).getDate();
}
	
	
	
//broji niz
function Arraycounter (array){
    if(array.length)
        return array.length;
    else
    {
        var length = 0;
        for ( var p in array ){if(array.hasOwnProperty(p)) length++;};
        return length;
    }
}

//pravi preview za slike kod upload
function readURL(input, id) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$(id).attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}



//zatvara levi slide manu kada mobilni meni ne postoji
function SlideMenuListener () {
    if ($('.navbar li.nav-toggle').length == 0) {
		window.setInterval( function() {  
			var bodyClass = $('body').attr("class");
			if (typeof(bodyClass) !== 'undefined') {
				if (bodyClass.toLowerCase().indexOf("nav-open") >= 0) {
					$('body').toggleClass('nav-open');
				}
			}
		},10);	
	}
}



function changeTimezone(date, ianatz) {
	
	// suppose the date is 12:00 UTC
	var invdate = new Date(date.toLocaleString('en-US', {
	timeZone: ianatz
	}));
	
	// then invdate will be 07:00 in Toronto
	// and the diff is 5 hours
	var diff = date.getTime() - invdate.getTime();
	
	// so 12:00 in Toronto is 17:00 UTC
	return new Date(date.getTime() - diff); // needs to substract

}




function smoothSort(items,prop,reverse) {  
    var length = items.length;
    for (var i = (length - 1); i >= 0; i--) {
        //Number of passes
        for (var j = (length - i); j > 0; j--) {
            //Compare the adjacent positions
            if(reverse && typeof(items[j]) !== 'undefined' && typeof(items[j - 1]) !== 'undefined'){
              if (items[j][prop] > items[j - 1][prop]) {
                //Swap the numbers
                var tmp = items[j];
                items[j] = items[j - 1];
                items[j - 1] = tmp;
            }
            }

            if(!reverse && typeof(items[j]) !== 'undefined' && typeof(items[j - 1]) !== 'undefined'){
              if (items[j][prop] < items[j - 1][prop]) {
                  //Swap the numbers
                  var tmp = items[j];
                  items[j] = items[j - 1];
                  items[j - 1] = tmp;
              }
            }
        }
    }

    return items;
}






function ksort(inputArr, sort_flags) {
  //  discuss at: http://phpjs.org/functions/ksort/
  // original by: GeekFG (http://geekfg.blogspot.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Brett Zamir (http://brett-zamir.me)
  //        note: The examples are correct, this is a new way
  //        note: This function deviates from PHP in returning a copy of the array instead
  //        note: of acting by reference and returning true; this was necessary because
  //        note: IE does not allow deleting and re-adding of properties without caching
  //        note: of property position; you can set the ini of "phpjs.strictForIn" to true to
  //        note: get the PHP behavior, but use this only if you are in an environment
  //        note: such as Firefox extensions where for-in iteration order is fixed and true
  //        note: property deletion is supported. Note that we intend to implement the PHP
  //        note: behavior by default if IE ever does allow it; only gives shallow copy since
  //        note: is by reference in PHP anyways
  //        note: Since JS objects' keys are always strings, and (the
  //        note: default) SORT_REGULAR flag distinguishes by key type,
  //        note: if the content is a numeric string, we treat the
  //        note: "original type" as numeric.
  //  depends on: i18n_loc_get_default
  //  depends on: strnatcmp
  //   example 1: data = {d: 'lemon', a: 'orange', b: 'banana', c: 'apple'};
  //   example 1: data = ksort(data);
  //   example 1: $result = data
  //   returns 1: {a: 'orange', b: 'banana', c: 'apple', d: 'lemon'}
  //   example 2: ini_set('phpjs.strictForIn', true);
  //   example 2: data = {2: 'van', 3: 'Zonneveld', 1: 'Kevin'};
  //   example 2: ksort(data);
  //   example 2: $result = data
  //   returns 2: {1: 'Kevin', 2: 'van', 3: 'Zonneveld'}

  var tmp_arr = {},
    keys = [],
    sorter, i, k, that = this,
    strictForIn = false,
    populateArr = {};

  switch (sort_flags) {
    case 'SORT_STRING':
      // compare items as strings
      sorter = function(a, b) {
        return that.strnatcmp(a, b);
      };
      break;
    case 'SORT_LOCALE_STRING':
      // compare items as strings, original by the current locale (set with  i18n_loc_set_default() as of PHP6)
      var loc = this.i18n_loc_get_default();
      sorter = this.php_js.i18nLocales[loc].sorting;
      break;
    case 'SORT_NUMERIC':
      // compare items numerically
      sorter = function(a, b) {
        return ((a + 0) - (b + 0));
      };
      break;
      // case 'SORT_REGULAR': // compare items normally (don't change types)
    default:
      sorter = function(a, b) {
        var aFloat = parseFloat(a),
          bFloat = parseFloat(b),
          aNumeric = aFloat + '' === a,
          bNumeric = bFloat + '' === b;
        if (aNumeric && bNumeric) {
          return aFloat > bFloat ? 1 : aFloat < bFloat ? -1 : 0;
        } else if (aNumeric && !bNumeric) {
          return 1;
        } else if (!aNumeric && bNumeric) {
          return -1;
        }
        return a > b ? 1 : a < b ? -1 : 0;
      };
      break;
  }

  // Make a list of key names
  for (k in inputArr) {
    if (inputArr.hasOwnProperty(k)) {
      keys.push(k);
    }
  }
  keys.sort(sorter);

  // BEGIN REDUNDANT
  this.php_js = this.php_js || {};
  this.php_js.ini = this.php_js.ini || {};
  // END REDUNDANT
  strictForIn = this.php_js.ini['phpjs.strictForIn'] && this.php_js.ini['phpjs.strictForIn'].local_value && this.php_js
    .ini['phpjs.strictForIn'].local_value !== 'off';
  populateArr = strictForIn ? inputArr : populateArr;

  // Rebuild array with sorted key names
  for (i = 0; i < keys.length; i++) {
    k = keys[i];
    tmp_arr[k] = inputArr[k];
    if (strictForIn) {
      delete inputArr[k];
    }
  }
  for (i in tmp_arr) {
    if (tmp_arr.hasOwnProperty(i)) {
      populateArr[i] = tmp_arr[i];
    }
  }

  return strictForIn || populateArr;
}


function krsort(inputArr, sort_flags) {
  //  discuss at: http://phpjs.org/functions/krsort/
  // original by: GeekFG (http://geekfg.blogspot.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Brett Zamir (http://brett-zamir.me)
  //        note: The examples are correct, this is a new way
  //        note: This function deviates from PHP in returning a copy of the array instead
  //        note: of acting by reference and returning true; this was necessary because
  //        note: IE does not allow deleting and re-adding of properties without caching
  //        note: of property position; you can set the ini of "phpjs.strictForIn" to true to
  //        note: get the PHP behavior, but use this only if you are in an environment
  //        note: such as Firefox extensions where for-in iteration order is fixed and true
  //        note: property deletion is supported. Note that we intend to implement the PHP
  //        note: behavior by default if IE ever does allow it; only gives shallow copy since
  //        note: is by reference in PHP anyways
  //        note: Since JS objects' keys are always strings, and (the
  //        note: default) SORT_REGULAR flag distinguishes by key type,
  //        note: if the content is a numeric string, we treat the
  //        note: "original type" as numeric.
  //  depends on: i18n_loc_get_default
  //   example 1: data = {d: 'lemon', a: 'orange', b: 'banana', c: 'apple'};
  //   example 1: data = krsort(data);
  //   example 1: $result = data
  //   returns 1: {d: 'lemon', c: 'apple', b: 'banana', a: 'orange'}
  //   example 2: ini_set('phpjs.strictForIn', true);
  //   example 2: data = {2: 'van', 3: 'Zonneveld', 1: 'Kevin'};
  //   example 2: krsort(data);
  //   example 2: $result = data
  //   returns 2: {3: 'Kevin', 2: 'van', 1: 'Zonneveld'}

  var tmp_arr = {},
    keys = [],
    sorter, i, k, that = this,
    strictForIn = false,
    populateArr = {};

  switch (sort_flags) {
  case 'SORT_STRING':
    // compare items as strings
    sorter = function (a, b) {
      return that.strnatcmp(b, a);
    };
    break;
  case 'SORT_LOCALE_STRING':
    // compare items as strings, original by the current locale (set with  i18n_loc_set_default() as of PHP6)
    var loc = this.i18n_loc_get_default();
    sorter = this.php_js.i18nLocales[loc].sorting;
    break;
  case 'SORT_NUMERIC':
    // compare items numerically
    sorter = function (a, b) {
      return (b - a);
    };
    break;
  case 'SORT_REGULAR':
    // compare items normally (don't change types)
  default:
    sorter = function (b, a) {
      var aFloat = parseFloat(a),
        bFloat = parseFloat(b),
        aNumeric = aFloat + '' === a,
        bNumeric = bFloat + '' === b;
      if (aNumeric && bNumeric) {
        return aFloat > bFloat ? 1 : aFloat < bFloat ? -1 : 0;
      } else if (aNumeric && !bNumeric) {
        return 1;
      } else if (!aNumeric && bNumeric) {
        return -1;
      }
      return a > b ? 1 : a < b ? -1 : 0;
    };
    break;
  }

  // Make a list of key names
  for (k in inputArr) {
    if (inputArr.hasOwnProperty(k)) {
      keys.push(k);
    }
  }
  keys.sort(sorter);

  // BEGIN REDUNDANT
  this.php_js = this.php_js || {};
  this.php_js.ini = this.php_js.ini || {};
  // END REDUNDANT
  strictForIn = this.php_js.ini['phpjs.strictForIn'] && this.php_js.ini['phpjs.strictForIn'].local_value && this.php_js
    .ini['phpjs.strictForIn'].local_value !== 'off';
  populateArr = strictForIn ? inputArr : populateArr;

  // Rebuild array with sorted key names
  for (i = 0; i < keys.length; i++) {
    k = keys[i];
    tmp_arr[k] = inputArr[k];
    if (strictForIn) {
      delete inputArr[k];
    }
  }
  for (i in tmp_arr) {
    if (tmp_arr.hasOwnProperty(i)) {
      populateArr[i] = tmp_arr[i];
    }
  }

  return strictForIn || populateArr;
}







