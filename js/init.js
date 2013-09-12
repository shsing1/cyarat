// JavaScript Document
var loadingDiv = loadingDailog = {};
var title = '系統訊息';
var btnOk = "OK";
var inAjax = keepMask = false;
function showLoading(){		
	var message = 'Loading...';
	loadingDiv = $('<div>').attr({'title': title});
	loadingDiv.dialog("destroy");
	loadingDiv.text(message).dialog({
		modal: true,
		resizable: false,
		draggable: false
	});
	loadingDailog = loadingDiv.parents('.ui-dialog:first');
	loadingDailog.find('.ui-dialog-titlebar-close').remove();
}
function hideLoading(){
	loadingDiv.dialog("destroy");
	loadingDiv.remove();
}
function showMsg(message, cTitle, callback){
	hideLoading();
	title = cTitle==undefined?title:cTitle;
	var div = $('<div>').attr({'title': title});
	div.dialog("destroy");
	div.html(message).dialog({
		modal: true,
		resizable: false,
		buttons:[{
				text: btnOk,
				click: function() { if( callback ) callback(true); $(this).dialog("close"); div.remove();}
			}]
	});
	var actPanel = div.parents('.ui-dialog:first');
	actPanel.find('.ui-dialog-titlebar-close').remove();
}
function implode (glue, pieces) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Waldo Malqui Silva
    // +   improved by: Itsacon (http://www.itsacon.net/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: implode(' ', ['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: 'Kevin van Zonneveld'
    // *     example 2: implode(' ', {first:'Kevin', last: 'van Zonneveld'});
    // *     returns 2: 'Kevin van Zonneveld'
    var i = '',
        retVal = '',
        tGlue = '';
    if (arguments.length === 1) {
        pieces = glue;
        glue = '';
    }
    if (typeof(pieces) === 'object') {
        if (Object.prototype.toString.call(pieces) === '[object Array]') {
            return pieces.join(glue);
        } 
        for (i in pieces) {
            retVal += tGlue + pieces[i];
            tGlue = glue;
        }
        return retVal;
    }
    return pieces;
}
function is_array (mixed_var) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Legaev Andrey
    // +   bugfixed by: Cord
    // +   bugfixed by: Manish
    // +   improved by: Onno Marsman
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Nathan Sepulveda
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: In php.js, javascript objects are like php associative arrays, thus JavaScript objects will also
    // %        note 1: return true in this function (except for objects which inherit properties, being thus used as objects),
    // %        note 1: unless you do ini_set('phpjs.objectsAsArrays', 0), in which case only genuine JavaScript arrays
    // %        note 1: will return true
    // *     example 1: is_array(['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: true
    // *     example 2: is_array('Kevin van Zonneveld');
    // *     returns 2: false
    // *     example 3: is_array({0: 'Kevin', 1: 'van', 2: 'Zonneveld'});
    // *     returns 3: true
    // *     example 4: is_array(function tmp_a(){this.name = 'Kevin'});
    // *     returns 4: false
    var ini,
        _getFuncName = function (fn) {
            var name = (/\W*function\s+([\w\$]+)\s*\(/).exec(fn);
            if (!name) {
                return '(Anonymous)';
            }
            return name[1];
        },
        _isArray = function (mixed_var) {
            // return Object.prototype.toString.call(mixed_var) === '[object Array]';
            // The above works, but let's do the even more stringent approach: (since Object.prototype.toString could be overridden)
            // Null, Not an object, no length property so couldn't be an Array (or String)
            if (!mixed_var || typeof mixed_var !== 'object' || typeof mixed_var.length !== 'number') {
                return false;
            }
            var len = mixed_var.length;
            mixed_var[mixed_var.length] = 'bogus';
            // The only way I can think of to get around this (or where there would be trouble) would be to have an object defined 
            // with a custom "length" getter which changed behavior on each call (or a setter to mess up the following below) or a custom 
            // setter for numeric properties, but even that would need to listen for specific indexes; but there should be no false negatives 
            // and such a false positive would need to rely on later JavaScript innovations like __defineSetter__
            if (len !== mixed_var.length) { // We know it's an array since length auto-changed with the addition of a 
            // numeric property at its length end, so safely get rid of our bogus element
                mixed_var.length -= 1;
                return true;
            }
            // Get rid of the property we added onto a non-array object; only possible 
            // side-effect is if the user adds back the property later, it will iterate 
            // this property in the older order placement in IE (an order which should not 
            // be depended on anyways)
            delete mixed_var[mixed_var.length];
            return false;
        };

    if (!mixed_var || typeof mixed_var !== 'object') {
        return false;
    }

    // BEGIN REDUNDANT
    this.php_js = this.php_js || {};
    this.php_js.ini = this.php_js.ini || {};
    // END REDUNDANT
    
    ini = this.php_js.ini['phpjs.objectsAsArrays'];

    return _isArray(mixed_var) ||
        // Allow returning true unless user has called
        // ini_set('phpjs.objectsAsArrays', 0) to disallow objects as arrays
        ((!ini || ( // if it's not set to 0 and it's not 'off', check for objects as arrays
        (parseInt(ini.local_value, 10) !== 0 && (!ini.local_value.toLowerCase || ini.local_value.toLowerCase() !== 'off')))
        ) && (
        Object.prototype.toString.call(mixed_var) === '[object Object]' && _getFuncName(mixed_var.constructor) === 'Object' // Most likely a literal and intended as assoc. array
        ));
}
function doAjax(e){
	var f = $(e);
	
	var url = f.attr("action");
	url = url==''?getPageName():url;
	var data = f.serialize();
	data += '&is_ajax=1';
	
	$.ajax({
		url: url,
		data: data
	});
	
	return false;
}
function doAjaxSuccess(data, textStatus, XMLHttpRequest){
	if(data.error){
		var msg = '';
		if(data.message){
			msg = implode("<br/>",data.message);
		}
		showMsg(msg);
	}else{
		switch(data.act){
			case 'msgRedirect':
				showMsg(data.message, title, function(){location.href = data.url;});
				break;
			case 'showPanel':
				$('#'+data.panel).html(data.html);
				break;
		}
	}
}
function getPageName(){
	var $url = location.href.lastIndexOf("?") == -1 ? location.href.substring((location.href.lastIndexOf("/")) + 1) : location.href.substring((location.href.lastIndexOf("/")) + 1, location.href.lastIndexOf("?"));
	$url = $url == ''?'index.php':$url; 
	$i = $url.indexOf("#");			
	if($i != -1){
		$url = $url.substring(0,$i);
	}
	return $url;
}
/* 設定ajax預設值*/
$.ajaxSetup({
	url: getPageName(),
	type: "POST",
	dataType: "json",
	beforeSend:function(){ inAjax = true; showLoading();},
	complete:function(){ if(!keepMask){  hideLoading(); keepMask = false; } inAjax = false;  },
	success:doAjaxSuccess
});		
	
$(function(){
	showLoading();
	hideLoading();
	//showMsg();
});