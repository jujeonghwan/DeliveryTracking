  
////////////////////////////////////////////////////////////////////////////////////////////////////
// MM_ JavaScript Function
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


////////////////////////////////////////////////////////////////////////////////////////////////////
// Common JavaScript Function

// 브라우저에 관계없는 객체접근 함수 
function get_object(objectId) {
    if( document.getElementById && document.getElementById(objectId) ) {
        return document.getElementById(objectId);                               // check W3C DOM
    }
    else if ( document.all && document.all(objectID) ) {
        return document.all(objectID);                                          // IE4
    }
    else if ( document.layers && document.layers[objectID] ) {
        return document.layer[objectID];                                        // NN4
    }
    else {
        return false;
    }
}

function get_object_opener(objectId) {
    if( opener.document.getElementById && opener.document.getElementById(objectId) ) {
        return opener.document.getElementById(objectId);                        // check W3C DOM
    }
    else if ( opener.document.all && opener.document.all(objectID) ) {
        return opener.document.all(objectID);                                   // IE4
    }
    else if ( opener.document.layers && opener.document.layers[objectID] ) {
        return opener.document.layer[objectID];                                 // NN4
    }
    else {
        return false;
    }
}

function get_select_value(objectId) {                                           // <select> 선택된 값
    return get_object(objectId).options[get_object(objectId).selectedIndex].value;
}

function get_select_text(objectId) {                                            // <select> 선택된 텍스트
    return get_object(objectId).options[get_object(objectId).selectedIndex].text;
}

function get_select_length(objectId) {                                          // <select> 항목 갯수
    return get_object(objectId).options.length;
}

function set_select_selectedIndex_default(objectId) {                           // <select> 기본으로 첫번째항목 선택
    if (get_object(objectId).selectedIndex == -1) {
        get_object(objectId).selectedIndex = 0;    
    }
}

// 윈도우나 프레임의 내부 크기
function get_inner_width() {
    var x;
    
    if (self.innerWidth) {                                                      // IE 외 모든 브라우저
        x = self.innerWidth;
    }
    else if (document.documentElement && document.documentElement.clientWidth) {                    // IE6 Strict 모드
        x = document.documentElement.clientWidth;
    }
    else if (document.body) {                                                   // 다른 IE 브라우저
        x = document.body.clientWidth;   
    }
    
    return x;
}

function get_inner_height() {
    var y;
    
    if (self.innerHeight) {                                                     // IE 외 모든 브라우저
        y = self.innerHeight;
    }
    else if (document.documentElement && document.documentElement.clientHeight) {                   // IE6 Strict 모드
        y = document.documentElement.clientHeight;
    }
    else if (document.body) {                                                   // 다른 IE 브라우저
        y = document.body.clientWidth;   
    }
    
    return y;
}

// 페이지 스크롤 크기
function get_scroll_left() {
    var x;
    
    if (self.pageXOffset) {                                                     // IE 외 모든 브라우저
        x = self.pageXOffset;
    }
    else if (document.documentElement && document.documentElement.scrollLeft) { // IE6 Strict 모드
        x = document.documentElement.scrollLeft;
    }
    else if (document.body) {                                                   // 다른 IE 브라우저
        x = document.body.scrollLeft;   
    }
    
    return x;
}

function get_scroll_top() {
    var y;
    
    if (self.pageYOffset) {                                                     // IE 외 모든 브라우저
        y = self.pageYOffset;
    }
    else if (document.documentElement && document.documentElement.scrollTop) {  // IE6 Strict 모드
        y = document.documentElement.scrollTop;
    }
    else if (document.body) {                                                   // 다른 IE 브라우저
        y = document.body.scrollTop;   
    }
    
    return y;
}
  
function window_open(url_text, name, width, height, scrollbars) {
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;

    var features = "location=no, status=no, left=" + left + ", top=" + top + ", width=" + width + ", height=" + height + ", scrollbars=" + scrollbars;        
    window.open(url_text, name, features);    
}

function window_close() {
	self.close();
}

function top_location(url) {
    top.location.href = url;
}  


////////////////////////////////////////////////////////////////////////////////////////////////////
// 즐겨찾기 추가

function bookmarksite(title_text, url_text) {    
    if (document.all) {                                     // Internet Explorer
        window.external.AddFavorite(url_text, title_text); 
    }
    else if (window.chrome) {                               // Google Chrome
        alert("Ctrl+D키를 누르시면 즐겨찾기에 추가하실 수 있습니다.");
    }
    else if (window.sidebar) {                              // Firefox
        window.sidebar.addPanel(title_text, url_text, "");
    }
    else if (window.opera && window.print) {                // Opera
        var elem = document.createElement('a'); 
        elem.setAttribute('href',url_text); 
        elem.setAttribute('title',title_text); 
        elem.setAttribute('rel','sidebar'); 
        elem.click(); 
    }
} 


////////////////////////////////////////////////////////////////////////////////////////////////////
// 달력 선택창

function calendar(obj_id) {
    var old_date = get_object(obj_id).value;
    
    // alert(old_date);
    var url_text = "/calendar/calendar.php?opener_id=" + obj_id + "&old_date=" + old_date;
    window_open(url_text, "calendar", 200, 310, "no");
    // window_dialog(url_text, "calendar", 200, 270);
}

function calendar2(obj_id, idx) {
    var obj_id_array = document.getElementsByName(obj_id);
    
    var old_date = obj_id_array[idx].value;
    
    // alert(old_date);
    var url_text = "/calendar/calendar2.php?opener_id=" + obj_id + "&idx=" + idx + "&old_date=" + old_date;
    window_open(url_text, "calendar2", 200, 310, "no");
    // window_dialog(url_text, "calendar2", 200, 270);
}

function calendar_yearmonth(obj_id) {
    var old_yearmonth = get_object(obj_id).value;
    
    // alert(old_date);
    var url_text = "/calendar/calendar_yearmonth.php?opener_id=" + obj_id + "&old_yearmonth=" + old_yearmonth;
    window_open(url_text, "calendar_yearmonth", 200, 310, "no");
    // window_dialog(url_text, "calendar_yearmonth", 200, 270);
}


////////////////////////////////////////////////////////////////////////////////////////////////////
// Etc. JavaScript Function

function check_string_byte(obj, max) {                      // 텍스트 Byte 체크
    var str = obj.value;                                    // 값
    var str_len = str.length;                               // 전체길이
    
    var bytes = 0;
    var len = 0;
    var one_char = "";
    var str2 = "";
    
    for (var i = 0; i < str_len; i++) {
        // 한글자를 구한다.
        one_char = str.charAt(i);
        
        // 한글일경우 2를 더함
        if (escape(one_char).length > 4) {
            bytes += 2;    
        }
        else {
            bytes++;  
        } 
        
        // 전체크기
        if (bytes <= max) {
            len = i + 1;    
        }
    }
    
    // 전체길이를 초과하면
    if(bytes > max) {
        alert( max + " 글자를 초과 입력할수 없습니다. \n 초과된 내용은 자동으로 삭제 됩니다. ");
        str2 = str.substr(0, len);
        // alert(str);
        obj.value = str2;    
    }
    
    obj.focus();
}

function check_string_length(str, min, max) { 	            // 텍스트 길이 체크
	if (str.length < min || str.length > max) {        
        return false;   
    }
    return true;
}

function check_uppercase(str) { 			                // 영문대문자 체크
	var pattern = /[A-Z]/;
	for (i = 0; i < str.length; i++) {
		if (pattern.test(str.charAt(i)) != true) {
			return false;	
		}
	}
    return true;
}

function check_lowercase_number(str) { 			            // 영문소문자/숫자 체크
	var pattern = /[a-z0-9]/;
	for (i = 0; i < str.length; i++) {
		if (pattern.test(str.charAt(i)) != true) {
			return false;	
		}
	}
    return true;
}

function check_integer_number(str) {                        // 정수숫자 체크 (-1,0,1,+1 등)
    var pattern = /[\+]|[-]|[0-9]/;
    for (i = 0; i < str.length; i++) {
        if (pattern.test(str.charAt(i)) != true) {
            return false;   
        }
    }
    return true;
}

function check_number(str) { 					            // 숫자 체크
	var pattern = /[0-9]/;
	for (i = 0; i < str.length; i++) {
		if (pattern.test(str.charAt(i)) != true) {
			return false;	
		}
	}
    return true;
}

function check_float_number(str) { 		                    // 소숫점포함 숫자 체크
	var pattern = /[.0-9]/;
	for (i = 0; i < str.length; i++) {
		if (pattern.test(str.charAt(i)) != true) {
			return false;	
		}
	}
    return true;
}

function check_date(y, m, d) {                              // 날짜 유효성 체크
    if (m < 1 || m > 12) {
        return false;   
    }
    
    if (d < 1 || d > 31) {
        return false;   
    }
    
    switch (m) {
        case 2:                                             // 2월
            if (d > 29) {
                return false;   
            }      
            else if (d == 29) {
                // 2월 29일일때 윤년여부 확인
                if ( ((y % 4 != 0) || (y % 100 == 0)) && (y % 400 != 0) ) {
                    return false;   
                }
            }
            break;
            
        case 4, 6, 9, 11:
            if (d == 31) {
                return false;   
            }
    }
    
    return true;
}

function check_registno(registno1, registno2) {             // 주민번호 유효성 체크
    var yy = registno1.substr(0, 2);                        // 년
    var mm = registno1.substr(2, 2);                        // 월
    var dd = registno1.substr(4, 2);                        // 일
    var gender = registno2.substr(0, 1);                    // 성별
    
    // 앞자리 체크
    if (registno1 == "") {        
        return false;   
    }
    if (registno1.length != 6) {        
        return false;   
    }
    for (i = 0; i < registno1.length; i++) {
		if (registno1.charAt(i) < "0" || registno1.charAt(i) > "9") {
			return false;
		}
	}
	
	// 뒷자리 체크	
	if (registno2 == "") {        
        return false;   
    }
    if (registno2.length != 7) {        
        return false;   
    }
    for (i = 0; i < registno2.length; i++) {
		if (registno2.charAt(i) < "0" || registno2.charAt(i) > "9") {
			return false;
		}
	}
	
	// 앞자리 년월일 형식
	if (yy < "00" || yy > "99" || mm < "01" || mm > "12" || dd < "01" || dd > "31") {
	    return false;   
	}
	
	// 성별체크
	if (gender < "1" || gender > "4") {
	    return false;   
	}
	
	// 세기(century)별 날짜 유효성 체크
	if (gender == "1" || gender == "2") {
	    cc = "19";   
	}
    else {
        cc = "20";
    }
    
    // if (check_date(parseInt(cc+yy), parseInt(mm), parseInt(dd)) == false) {
    //     return false;
    // }
	
    // check digit
    n = 2;
    sum = 0;
    
    for (i = 0; i < registno1.length; i++) {
        sum += parseInt(registno1.substr(i, 1)) * n++;   
    }
    for (i = 0; i < registno2.length - 1; i++) {
        sum += parseInt(registno2.substr(i, 1)) * n++;              
        if (n == 10) {
            n = 2;   
        }
    }
    
    c = 11 - (sum % 11);
    if (c == 11) {
        c = 1;   
    }
    if (c == 10) {
        c = 0;   
    }
    
    if (c != parseInt(registno2.substr(6, 1))) {
        return false;   
    }
    else {
        return true;   
    }
}

function check_businessno(businessno) {				        // 사업자등록번호 유효성 체크
    var a = new Array;
    var b = new Array(1,3,7,1,3,7,1,3,5);
    var sum = 0;
    
    if (businessno == "") {        
        return false;   
    }
    if (businessno.length != 10) {        
        return false;   
    }
    for (i = 0; i < businessno.length; i++) {
		if (businessno.charAt(i) < "0" || businessno.charAt(i) > "9") {
			return false;
		}
	}
	
	for (i = 0; i < 10; i++) {
		a[i] = businessno.substr(i, 1);
	}
	for (i = 0; i < 9; i++) {
		sum += (a[i] * b[i]);
	}
	
	sum += ((a[8] * 5) / 10);
	y = (sum - (sum % 1)) % 10;

    if (y == 0) {
    	z = 0;	
    }
    else {
        z = 10 - y;
    }

    if (z != a[9]) {
        return false;
    }
    else {
    	return true;
    }
}

// 천단위 콤마(,) 구분기호 넣기
function number_format(no) {
    no = no + "";                                           // 숫자를 문자열로 변환
                                                            
    var no_length = no.length;                              // 입력된 숫자의 길이
    var no_return = "";                                     // 천단위 구분자를 넣어서 리턴해줄 변수
    var no_temp = "";                                       // 임시
                                                            
    var no_count = 0;                                       
    var posPoint = no.indexOf('.');                         // 소숫점 있는 자리위치
                                                            
    if (posPoint != "-1") {                                 // 소숫점이 있는 경우
        no_length = posPoint;                               
        no_return = no.substring(posPoint);                 // 소숫점 이하는 그대로 붙인다.
    }                                                       
                                                            
    for (var i = no_length - 1; i >= 0; i--) {              
        no_temp = no.charAt(i);                             // 한글자씩 읽는다.
        if (no_temp != ",") {
            if (((no_count % 3) == 0) && (no_count != 0)) {
                no_return = no_temp + "," + no_return;                
            }
            else {
                no_return = no_temp + no_return;
            }
            no_count++;
        }   
    }
    return no_return;
}

// 천단위 콤마(,) 제거
function remove_number_format(no) {
    var no_return = "";
    
    no_return = no.replace(/\,/g, "");
    
    return no_return;
}

// 천단위 콤마(,) 자동입력 (keyup 이벤트)
function set_number_format(obj) {
    // alert(obj.value);
    obj.value = number_format(obj.value);    
    // alert(obj.value);
}

// 텍스트박스 내용선택하기 (focus 이벤트)
function set_text_select(obj) {
    obj.select();
}

// 상품정보 수정 정보제공 텍스트박스 채우기
function fill_notice_item_value(wrap_obj, text) {
	var inputs = wrap_obj.getElementsByTagName('input');
	for(var i = 0 ; i < inputs.length ; i++) {
		if(inputs[i].type != 'text') {
			continue;
		}
		inputs[i].value = text;
	}
}


////////////////// php style func
function trim(string)
{
	string = ltrim(string);
	string = rtrim(string);
	return string;
}

function ltrim(string)
{
	var flag = false;
	var result = '';
	for(var i = 0 ; i < string.length ; i++)
	{
		if(string.charAt(i) != ' ')
			flag = true;
		if(flag)
			result += string.charAt(i);
	}
	return result;
}

function rtrim(string)
{
	var flag = false;
	var result = '';
	for(var i = string.length-1 ; i >= 0 ; i--)
	{
		if(string.charAt(i) != ' ')
			flag = true;
		if(flag)
			result = string.charAt(i)+result;
	}
	return result;
}

function in_array(key ,arr)
{
	for(var i = 0 ; i < arr.length ; i++)
	{
		if(arr[i] == key)
			return true;
	}
	return false;
}

function explode(cut, str, arrlen)
{
	var temp = str.split(cut);

	var result = [];

	for(var i = 0 ; i < temp.length ; i++)
	{
		if(arrlen && arrlen < i)
		{
			result[result.length-1] += cut + temp[i];
		}
		else
		{
			result[result.length] = temp[i];
		}
	}
	return result;
}

function implode(connstr, arr)
{
	var result = '';
	for (var i = 0; i < arr.length ; i++ )
	{
		if(result)
			result += connstr;
		result += arr[i];
	}
	return result;
}

function str_replace(oldstr, newstr, allstr, arrlen)
{
	var temp = explode(oldstr, allstr, arrlen);
	return implode(newstr, temp);
}

function nl2br(str)
{
	str = str_replace("\r", '', str);
	str = str_replace("\n", "<br>\n", str);
	return str;
}

function get_between(left, right, str)
{
	var temp = str.split(left);
	var result = [];

	for(var i = 1 ; i < temp.length ; i++)
	{
		result[result.length] = temp[i].split(right)[0];
	}
	return result;
}

function urlencode(str) {
    return encodeURIComponent(str); 
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// AJAX Function
var READY_STATE_UNINITIALIZED = 0;
var READY_STATE_LOADING = 1;
var READY_STATE_LOADED = 2;
var READY_STATE_INTERACTIVE = 3;
var READY_STATE_COMPLATE = 4;
var req = null;

function initXMLHTTPRequest() {
    var xRequest = null;
    
    if (window.XMLHttpRequest) {
        xRequest = new XMLHttpRequest();
    }   
    else if (typeof ActiveXObject != "undefined") {
        try {
            xRequest = new ActiveXObject("Msxml2.XMLHTTP");       
        }
        catch (err) {
            try {
                xRequest = new ActiveXObject("Microsoft.XMLHTTP");        
            }
            catch (err) {
            }
        }
    }
    
    return xRequest;
}

function sendRequest(URL, params, HttpMethod) {
    if (!HttpMethod) {
        HttpMethod = "POST";   
    }   
    
    req = initXMLHTTPRequest();
    
    if (req) {
        req.open(HttpMethod, URL, false);                   // (true:비동기 false:동기)
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.send(params);
        
        if (req.readyState == READY_STATE_COMPLATE) {
            if (req.status == 200) {
                return req.responseText;   
            }    
        }
    }
}
