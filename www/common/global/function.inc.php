<?php

////////////////////////////////////////////////////////////////////////////////
// 페이지 HTML
function html_begin() {    
    global $SITE_VAR;
    
    echo "<!DOCTYPE HTML>\n";    
    echo "<html>\n";
    echo "<head>\n";
    echo "<meta charset=\"utf-8\" />\n";
    echo "<title>" . $SITE_VAR["title"] . "</title>\n";    
    echo "</head>\n";
    echo "<body>\n";
}

function html_end() {  
    echo "\n";
    echo "</body>\n";
    echo "</html>";
}

function html_meta_charset_utf8() {     
    echo "\n";
    echo "<meta charset=\"utf-8\" />\n";
}


////////////////////////////////////////////////////////////////////////////////
// 자바스크립트
function run_javascript($msg) {
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo $msg . "\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
}

function alert($msg) {
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    alert(\"" . $msg . "\");\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
}

function alert_back($msg) {
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    alert(\"" . $msg . "\");\n";
    echo "    history.back();\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
    
    exit;   
}

function focus($obj) {
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    get_object(\"" . $obj . "\").focus();\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
}

function close() {
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    self.close();\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
}

function refresh($url = "", $delay = 0) {
    global $_SERVER;
    
    if ($url == "") {
        $url = $_SERVER["PHP_SELF"];   
    }
    
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"ko\">\n";
    echo "<head>\n";
    echo "<title>" . $SITE_VAR["title"] . "</title>\n";
    echo "<meta http-equiv=\"Refresh\" content=\"" . $delay . "; url=" . $url . "\" />\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "\n";
    echo "</body>\n";
    echo "</html>";
    
    exit;
}

function location_replace($url = "") {          // history 적용안됨
    global $_SERVER;
    
    if ($url == "") {
        $url = $_SERVER["PHP_SELF"];   
    }
    
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    location.replace(\"" . $url . "\");\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
    
    exit;
}

function top_location_replace($url = "") {      // history 적용안됨
    global $_SERVER;
    
    if ($url == "") {
        $url = $_SERVER["PHP_SELF"];   
    }
    
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    top.location.replace(\"" . $url . "\");\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
    
    exit;
}

function location_href($url = "") {          
    global $_SERVER;
    
    if ($url == "") {
        $url = $_SERVER["PHP_SELF"];   
    }
    
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    location.href = \"" . $url . "\";\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
    
    exit;
}

function top_location_href($url = "") {          
    global $_SERVER;
    
    if ($url == "") {
        $url = $_SERVER["PHP_SELF"];   
    }
    
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    top.location.href = \"" . $url . "\";\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
    
    exit;
}

function opener_location_href($url = "") {          
    global $_SERVER;
    
    if ($url == "") {
        $url = $_SERVER["PHP_SELF"];   
    }
    
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    opener.location.href = \"" . $url . "\";\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
}

function opener_location_reload() { 
    html_begin();
             
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    opener.location.reload();\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
}

function mainFrame_location_href($url = "") {               // mainFrame 이동      
    global $_SERVER;
    
    if ($url == "") {
        $url = $_SERVER["PHP_SELF"];   
    }
    
    html_begin();
    
    echo "\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    top.mainFrame.location.href = \"" . $url . "\";\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    
    html_end();
    
    exit;
}

function form_post_action_submit($url, $param) {
    global $SITE_VAR;
    
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"ko\">\n";
    echo "<head>\n";
    echo "<title>" . $SITE_VAR["title"] . "</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "\n";
    
    echo "<form name=\"post_form\" method=\"post\" enctype=\"multipart/form-data\" action=\"" . $url . "\">\n";
    
    $param_array = explode("&", $param);
    
    if (count($param_array) > 0) {
        foreach ($param_array as $key => $val) {
            unset ($val_array);
            
            $val_array = explode("=", $val);
            
            echo "<input type=\"hidden\" id=\"" . $val_array[0] . "\" name=\"" . $val_array[0] . "\" value=\"" . $val_array[1] . "\" />\n";
        }
    }
    
    echo "</form>\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    document.post_form.submit();\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    echo "</body>\n";
    echo "</html>";
    
    exit;
}

function form_get_action_submit($url, $param) {
    global $SITE_VAR;
    
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"ko\">\n";
    echo "<head>\n";
    echo "<title>" . $SITE_VAR["title"] . "</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "\n";
    
    echo "<form name=\"get_form\" method=\"get\" enctype=\"multipart/form-data\" action=\"" . $url . "\">\n";
    
    $param_array = explode("&", $param);
    
    if (count($param_array) > 0) {
        foreach ($param_array as $key => $val) {
            unset ($val_array);
            
            $val_array = explode("=", $val);
            
            echo "<input type=\"hidden\" id=\"" . $val_array[0] . "\" name=\"" . $val_array[0] . "\" value=\"" . $val_array[1] . "\" />\n";
        }
    }
    
    echo "</form>\n";
    echo "<script type=\"text/javascript\">\n";
    echo "/* <![CDATA[ */\n";
    echo "    document.get_form.submit();\n";
    echo "/* ]]> */\n";
    echo "</script>\n";
    echo "</body>\n";
    echo "</html>";
    
    exit;
}



// 디버깅 관련

// 내용출력
function dp($str) {                     // debug_print
    global $DEBUG_MODE;
    
    if ($DEBUG_MODE == true) {
        echo "<br />\n";   
        echo "<xmp>\n";
        echo $str;
        echo "</xmp>\n";
        echo "<br />\n";
    }   
}

function dd($str) {                     // 무조건 화면 표시
    echo "<br />\n";   
    echo "<xmp>\n";
    echo $str;
    echo "</xmp>\n";
    echo "<br />\n";
}


// HTML 컨트롤
// <select><option>
function get_select_option($blank_text, $option_array, $selected_value) {
    $option_text = "";
    
    if ($blank_text != "") {
        $option_text .= "<option value=\"\">" . $blank_text . "</option>";     
    }
    
    if (count($option_array) > 0) {
        foreach($option_array as $value => $text) {
            $option_text .= "<option value=\"" . $value . "\"";
            if (trim($value) == trim($selected_value)) {
                $option_text .= " selected=\"selected\"";    
            }  
            $option_text .= ">" . $text . "</option>";
        }
    }
    
    return $option_text;
}

// <input type="radio"> 값 설정
function get_input_radio($name, $radio_array, $checked_value, $color_array = "") {
    $radio_text = "";
    
    if (count($radio_array) > 0) {
        foreach($radio_array as $value => $text) {
            $radio_text .= "<label class=\"radio-inline\">";
            
            $radio_text .= "<input type=\"radio\" id=\"" . $name . "_" . $value . "\" name=\"" . $name . "\" value=\"" . $value . "\"";
            if (trim($value) == trim($checked_value)) {
                $radio_text .= " checked=\"checked\"";       
            }  
            $radio_text .= " /> <span style=\"color:" . $color_array[$value] . "\">" . $text . "</span> ";
            
            $radio_text .= "</label>";
        }
    }
    
    return $radio_text;
}

// <input type="checkbox"> 값 설정
function get_input_checkbox($name, $checkbox_array, $checked_value_array, $color_array = "") {
    $checkbox_text = "";
    
    if (count($checkbox_array) > 0) {
        foreach($checkbox_array as $value => $text) {
            $checkbox_text .= "<label class=\"checkbox-inline\">";
            
            $checkbox_text .= "<input type=\"checkbox\" id=\"" . $name . "_" . $value . "\" name=\"" . $name . "[]\" value=\"" . $value . "\"";
            if ($checked_value_array[$value] != "") {
                $checkbox_text .= " checked=\"checked\"";       
            }  
            $checkbox_text .= " /> <span style=\"color:" . $color_array[$value] . "\">" . $text . "</span> ";
            
            $checkbox_text .= "</label>";
        }
    }
    
    return $checkbox_text;
}

// 날짜시간
// 현재 날짜시간 관련
function current_date() {
    return date("Ymd", time());   
}

function current_yearmonth() {
    return date("Ym", time());   
}

function current_year() {
    return date("Y", time());   
}

function current_shortyear() {
    return date("y", time());   
}

function current_monthday() {
    return date("md", time());   
}

function current_month() {
    return date("m", time());   
}

function current_day() {
    return date("d", time());   
}

function current_datetime() {
    return date("YmdHis", time());   
}

function current_time() {
    return date("His", time());   
}

function current_hour() {
    return date("H", time());   
}

function current_minute() {
    return date("i", time());   
}

function current_second() {
    return date("s", time());   
}

// 이전이후 날짜시간 관련
function date_difference_year($date, $diff) {
    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, 6, 2);

    return date("Ymd", mktime(0, 0, 0, $month, $day, $year + $diff));   
}

function date_difference_month($date, $diff) {
    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, 6, 2);

    return date("Ymd", mktime(0, 0, 0, $month + $diff, $day, $year));   
}

function date_difference_week($date, $diff) {
    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, 6, 2);

    return date("Ymd", mktime(0, 0, 0, $month, $day + ($diff * 7), $year));   
}

function date_difference_day($date, $diff) {
    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, 6, 2);

    return date("Ymd", mktime(0, 0, 0, $month, $day + $diff, $year));   
}

function yearmonth_difference_month($yearmonth, $diff) {
    $year = substr($yearmonth, 0, 4);
    $month = substr($yearmonth, 4, 2);
	$day = "01";
	
    return date("Ym", mktime(0, 0, 0, $month + $diff, $day, $year));   
}

function year_difference_year($year, $diff) {
    $year = substr($year, 0, 4);
    $month = "01";
	$day = "01";
	
    return date("Y", mktime(0, 0, 0, $month, $day, $year + $diff));   
}

function day_period_date($begin_date, $end_date) {                  // 두 날짜 사이의 차이(일)
    $date1 = strtotime(get_date_format($begin_date, "-"));
    $date2 = strtotime(get_date_format($end_date, "-"));
    
    return ($date2 - $date1) / (24 * 60 * 60);
}

function week_period_date($begin_date, $end_date) {                 // 두 날짜 사이의 차이(주)
    $date1 = strtotime(get_date_format($begin_date, "-"));
    $date2 = strtotime(get_date_format($end_date, "-"));
    
    return ($date2 - $date1) / (7 * 24 * 60 * 60);
}

function month_period_date($begin_date, $end_date) {                // 두 날짜 사이의 차이(월)
    $date1 = strtotime(get_date_format($begin_date, "-"));
    $date2 = strtotime(get_date_format($end_date, "-"));
    
    return ($date2 - $date1) / ((365 / 12) * 24 * 60 * 60);
}

function get_month_daycount($yearmonth) {       // 해당월의 날짜수
    $date1 = $yearmonth . "01";
    $date2 = yearmonth_difference_month($yearmonth, 1) . "01";
    
    return day_period_date($date1, $date2);
}


// 데이터 날짜시간 관련
function get_dayweek($date)
{
    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, 6, 2);

    return date("w", mktime(0, 0, 0, $month, $day, $year));     
}

function get_date_format($date, $mark = "-") {
	if ($date == "") {
		return "";
	}
	else {
		return substr($date, 0, 4) . $mark . substr($date, 4, 2) . $mark . substr($date, 6, 2);
	}
}

function get_korea_date_format($date) {
	if ($date == "") {
		return "";
	}
	else {
		return substr($date, 0, 4) . "년 " . substr($date, 4, 2) . "월 " . substr($date, 6, 2) . "일";
	}
}

function get_list_date_format($date, $mark = "-") {
	if ($date == "") {
		return "";
	}
	else {
		return substr($date, 0, 4) . $mark . "<br />" . substr($date, 4, 2) . $mark . substr($date, 6, 2);
	}
}

function get_yearmonth_format($date, $mark = "-") {
	if ($date == "") {
		return "";
	}
	else {
		return substr($date, 0, 4) . $mark . substr($date, 4, 2);
	}
}

function get_monthday_format($date, $mark = "-") {
	if ($date == "") {
		return "";
	}
	else {
		return substr($date, 4, 2) . $mark . substr($date, 6, 2);
	}
}

function get_year_format($date) {
    return substr($date, 0, 4);
}

function get_month_format($date) {
    return substr($date, 4, 2);
}

function get_day_format($date) {
    return substr($date, 6, 2);
}

function get_smallmonthday_format($date, $mark = "/") {
    if (substr($date, 4, 1) == "0") {
        $smallmonth = substr($date, 5, 1);
    }
    else {
        $smallmonth = substr($date, 4, 2);    
    }
    
    if (substr($date, 6, 1) == "0") {
        $smallday = substr($date, 7, 1);
    }
    else {
        $smallday = substr($date, 6, 2);    
    }
    
    $smallmonthday = $smallmonth . $mark . $smallday;
    
    return $smallmonthday;
}

function get_smallday_format($date) {
    if (substr($date, 6, 1) == "0") {
        $smallday = substr($date, 7, 1);
    }
    else {
        $smallday = substr($date, 6, 2);    
    }
    
    return $smallday;
}

function get_hour_format_by_datetime($time) {
	if ($time == "") {
		return "";
	}
	else {
		return substr($time, 8, 2);
	}
}

function get_time_format($time, $mark = ":") {
	if ($time == "") {
		return "";
	}
	else {
		return substr($time, 0, 2) . $mark . substr($time, 2, 2) . $mark . substr($time, 4, 2);
	}
}

function get_hourminute_format_by_time($date, $mark = ":") {
	if ($date == "") {
		return "";
	}
	else {
		return substr($date, 0, 2) . $mark . substr($date, 2, 2);
	}
}

function get_datetime_format($time, $mark = "-", $mark2 = ":") {
	if ($time == "") {
		return "";
	}
	else {
		return substr($time, 0, 4) . $mark . substr($time, 4, 2) . $mark . substr($time, 6, 2) . " " . substr($time, 8, 2) . $mark2 . substr($time, 10, 2) . $mark2 . substr($time, 12, 2);
	}
}

function get_list_datetime_format($time, $mark = "-", $mark2 = ":") {
    if ($time == "") {
        return "";
    }
    else {
        return substr($time, 0, 4) . $mark . substr($time, 4, 2) . $mark . substr($time, 6, 2) . "<br />" . substr($time, 8, 2) . $mark2 . substr($time, 10, 2) . $mark2 . substr($time, 12, 2);
    }
}

function get_time_format_by_datetime($time, $mark = ":") {
    if ($time == "") {
        return "";
    }
    else {
        return substr($time, 8, 2) . $mark . substr($time, 10, 2) . $mark . substr($time, 12, 2);
    }
}

function get_datetime_format_with_gmarket($time, $mark = "-", $mark2 = ":") {   // 예) 2013-05-31 오후 2:04:17
    $hour_temp_array = array (
        "00"    =>  "오전 12",
        "01"    =>  "오전 1",
        "02"    =>  "오전 2",
        "03"    =>  "오전 3",
        "04"    =>  "오전 4",
        "05"    =>  "오전 5",
        "06"    =>  "오전 6",
        "07"    =>  "오전 7",
        "08"    =>  "오전 8",
        "09"    =>  "오전 9",
        "10"    =>  "오전 10",
        "11"    =>  "오전 11",
        "12"    =>  "오후 12",
        "13"    =>  "오후 1",
        "14"    =>  "오후 2",
        "15"    =>  "오후 3",
        "16"    =>  "오후 4",
        "17"    =>  "오후 5",
        "18"    =>  "오후 6",
        "19"    =>  "오후 7",
        "20"    =>  "오후 8",
        "21"    =>  "오후 9",
        "22"    =>  "오후 10",
        "23"    =>  "오후 11"
    );
    
	if ($time == "") {
		return "";
	}
	else {
	    $hour = $hour_temp_array[substr($time, 8, 2)];
	    
		return substr($time, 0, 4) . $mark . substr($time, 4, 2) . $mark . substr($time, 6, 2) . " " . $hour . $mark2 . substr($time, 10, 2) . $mark2 . substr($time, 12, 2);
	}
}

function get_simple_datetime_format($time, $mark = "-", $mark2 = ":") {         // 예) 05-31 14:15
    if ($time == "") {
        return "";
    }
    else {
        return substr($time, 4, 2) . $mark . substr($time, 6, 2) . " " . substr($time, 8, 2) . $mark2 . substr($time, 10, 2);
    }
}

// 한국 상세 날짜시간 구하기
function get_korea_detail_current_datetime() {
    global $WDATE_ARRAY;

    $today_date = date("Ymd", time());  // 오늘날짜 예) 20161222

    $korea_detail_current_datetime = date("Y년 m월 d일 H시 i분 s초 ", time());
    $korea_detail_current_datetime .= "(" . array_search(get_dayweek($today_date), $WDATE_ARRAY) . "요일)";
    
    return $korea_detail_current_datetime;
}


// 사업자등록번호 (123-45-67890)
function get_businessno_format($businessno, $mark = "-") {
	if ($businessno == "") {
		return "";
	}
	else {
		return substr($businessno, 0, 3) . $mark . substr($businessno, 3, 2) . $mark . substr($businessno, 5, 5);
	}
}


// 구.우편번호 (123-456)
function get_zipcode_format($zipcode, $mark = "-") {
	if ($zipcode == "") {
		return "";
	}
	else {
		return substr($zipcode, 0, 3) . $mark . substr($zipcode, 3, 3);
	}
}


////////////////////////////////////////////////////////////////////////////////
// 택배사 운송장번호 포맷
function get_deliverytype_invoice_no_format($invoice_no, $dt_deliverytype = "") {
    global $COMMON_DELIVERYTYPE_ARRAY;

    // 초기화
    $deliverytype_invoice_no_format = "";   

    if ($invoice_no == "") {
        return $deliverytype_invoice_no_format;
    }

    // 구분기호
    $mark = "-";

    switch ($dt_deliverytype) {
        case $COMMON_DELIVERYTYPE_ARRAY["CU편의점PICK-UP"]:    // 예) 798-103-2942
            $deliverytype_invoice_no_format = substr($invoice_no, 0, 3) . $mark . substr($invoice_no, 3, 3) . $mark . substr($invoice_no, 6, 4);
            break;
        
        default:
            $deliverytype_invoice_no_format = trim($invoice_no);
            break;
    }

    return $deliverytype_invoice_no_format;
}


////////////////////////////////////////////////////////////////////////////////
// 페이지
// 페이지 초기화
function page_init() {
    global $_REQUEST;
    
    if (!isset($_REQUEST["page"]) || $_REQUEST["page"] == "") {
        $_REQUEST["page"] = 1;   
    } 
    
    return $_REQUEST["page"];
}

function calc_total_page($total_rows, $rows_per_page) {
    if ($total_rows < 1) {
        $total_rows = 1;  
    } 
    
    return ceil($total_rows / $rows_per_page);
}

function calc_begin_row($page, $rows_per_page) {
    return (($page - 1) * $rows_per_page);
}

function calc_begin_no($total_rows, $begin_row) {
    return ($total_rows - $begin_row + 1);
}

// 페이징 링크 목록
function pagination_link_list($total_page, $page = 1, $page_count = 20, $list_count = 20) {    
    $list_page = (int) ( ($page - 1) / $page_count + 1 );
	$begin_page = ( ($list_page - 1) * $page_count ) + 1;
	$end_page = $list_page * $page_count;

	if ($end_page > $total_page) {
		$end_page = $total_page;
	}
    
    $page_str   =   "";
    $page_str   .=  "<ul class=\"pagination\">";
    
    // 페이지 앞부분
	if ($begin_page > 1) {
		$prev_page = $begin_page - 1;
		
		$page_str .= " <li><a href=\"#\" onclick=\"go_list(1);\">&lt;&lt;</a></li> ";
		$page_str .= " <li><a href=\"#\" onclick=\"go_list(" . $prev_page . ");\">&lt;</a></li> ";
	}
	
	// 페이지 번호
	for ($n = $begin_page; $n <= $end_page; $n++) {
		if ($n == $page) {
			$page_str .= " <li class=\"active\"><a href=\"#\" onclick=\"go_list(" . $n . ");\">" . $n . "</a></li> ";
		}
		else {
			$page_str .= " <li><a href=\"#\" onclick=\"go_list(" . $n . ");\">" . $n . "</a></li> ";
		}
	}
		
	// 페이지 뒷부분
	if ($end_page < $total_page) {
		$next_page = ($list_page * $page_count) + 1;
		
		$page_str .= " <li><a href=\"#\" onclick=\"go_list(" . $next_page . ");\">&gt;</a></li> ";
		$page_str .= " <li><a href=\"#\" onclick=\"go_list(" . $total_page . ");\">&gt;&gt;</a></li> ";
	}
	
	$page_str   .=  "</ul>";
	
	return $page_str;
}


////////////////////////////////////////////////////////////////////////////////
// 디렉터리 관련
function check_directory($pathname, $mode = 0777) {         // 디렉터리 없을 경우 생성
	if (!is_dir($pathname)) {
		if (mkdir($pathname, $mode)) {
		    chmod($pathname, $mode);
		    
			return true;
		}
		else {
			return false;
		}
	}
}

// 디렉터리 삭제 (하위 파일 포함)
function remove_derctory($pathname) {
    if (!is_dir($pathname)) {
        return false;
    }

    // echo "<br />pathname : " . $pathname;

    // 핸들 획득
    $dir_handle  = opendir($pathname);

    // 디렉터리에 포함된 파일을 저장한다.
    while (false !== ($filename = readdir($dir_handle))) {
        // echo "<br />pathname filename : " . $pathname . "/" . $filename;

        if ($filename == "." || $filename == ".."){
            continue;
        }
     
        // 파일인 경우만 목록에 추가한다.
        if (is_file($pathname . "/" . $filename)){
            $files[] = $filename;
        }
    }

    // 핸들 해제 
    closedir($dir_handle);

    // 파일명을 출력한다.
    foreach ($files as $temp_file_name) {
        // echo $temp_file_name;
        // echo "<br />";

        // 파일 삭제
        unlink($pathname . "/" . $temp_file_name);
    }

    // 디렉터리 삭제
    $rmdir_result = rmdir($pathname);

    if ($rmdir_result) {
        return true;
    }
    else {
        return false;
    }
}


////////////////////////////////////////////////////////////////////////////////
// 문자 관련
function get_random_string() {
    $string = md5(uniqid(mt_rand(), true));
    
    return $string;   
}

function iconv_utf8_euckr($str) {
    $string =  iconv ("UTF-8", "EUC-KR", $str);
    
    return $string;   
}

function iconv_euckr_utf8($str) {
    $string =  iconv ("EUC-KR", "UTF-8", $str);
    
    return $string;   
}

// JS String Encoding
function json_string_encode($str) {
    $string =  substr(json_encode($str), 1, -1);

    return $string;   
}

// JS String Decoding
function json_string_decode($str) {
    $string =  json_decode(sprintf('"%s"', $str));
    
    return $string;   
}

function str_cut($str, $len, $tail = "...") {
    $str_result = mb_substr($str, 0, $len, "UTF-8");
    
    if ($str_result != $str) {
        $str_result .= $tail;  
    }
    
    return $str_result;
    
    /*
	if (strlen ($str) > $len) {
		if (ord($str[$len - 1]) <= 127) {
			$pos = $len;
        }
        else {
        	for ($pos = $len - 1; $pos >= 0; $pos--) {
        		if (ord($str[$pos]) > 127) {
        			$h++;
        		}
        		else {
        			break;
        		}
        	}

        	if ($h % 2 == 0) {
        		$pos += $h + 1;
        	}
        	else {
        		$pos += $h;
        	}
        }

        $str = substr($str, 0, $pos);
        // $str = mb_substr ($str, 0, $pos);
        $str .= "..";
        // $str .= "...";
     }
     return $str;
     */
}

function strip_only($str, $tags) {                          // 해당태그만 제거
    if(!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if(end($tags) == '') array_pop($tags);
    }
    foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
    return $str;
}

function number_only($str) {                                // 숫자만 남김
    $str = ereg_replace("[^0-9]", "", $str);
    return $str;
}

function tel_number_only($str) {                            // 전화번호만 남김 (숫자 -)
    $str = ereg_replace("[^0-9-]", "", $str);
    return $str;
}

function eng_number_only($str) {                            // 영어,숫자만 남김 (공백도 제거)
    $str = ereg_replace("[^a-zA-Z0-9]", "", $str);
    return $str;
}

function kor_eng_number_only($str) {                        // 한글,영어,숫자만 남김 (공백도 제거)
    $str = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $str);
    return $str;
}

function kor_eng_number_blank_only($str) {                  // 한글,영어,숫자,공백만 남김 (공백은 제거안함)
    $str = preg_replace ("/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $str);
    return $str;
}

function blank_one_only($str) {                             // 공백을 한개만 남김
    $str = preg_replace("/(\s){2,}/", "$1", $str);
    return $str;
}

function blank_remove($str) {                               // 공백을 제거함
    $str = str_replace(" ", "", $str);
    return $str;
}

function get_html_to_text_data($str) {                      // html중 text 데이터만 구함
    
    // 줄바꿈을 " "로 변경
    $str = str_replace("\r\n", " ", $str);
    $str = str_replace("\r", " ", $str);
    $str = str_replace("\n", " ", $str);
    
    // 공백을 한개만 남김    
    $str = blank_one_only($str);

    // 태그를 제거
    // $str = strip_tags($str);
    
    $str = trim($str);
                
    return $str;
}

function echo_flush() {
	echo str_repeat(' ',1024*64);
	flush();
}


// http 헤더관련

// 엑셀저장
function excel_header($filename, $charset = "utf-8") {
    if ($filename == "") {
        $filename = current_date() . ".xls";
    }
    else {
           
    }
    
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=" . $filename);
    echo("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=" . $charset . "\">");      
}

// referer
function get_referer_url() {
	global $_SERVER;
	
	foreach (getallheaders() as $name => $value) {
		if ($name == "Referer") {
			$referer_url = $value;	
		}
	}
	
	return $referer_url;
}


// 이미지 관련

// 이미지 처리/경로 관련
function make_thumnail($file, $save_filename, $save_path, $max_width, $max_height) {    // 썸네일 이미지 생성
    // 전송받은 이미지 정보를 받는다 
    $img_info = getImageSize($file); 
    
    // 이미지 크기를 단계별로 설정 (너비)
    if ($max_width <= 50) {
        $max_width = 50;
    }
    else if ($max_width <= 100) {
        $max_width = 100;
    }
    else if ($max_width <= 150) {
        $max_width = 150;
    }
    else if ($max_width <= 200) {
        $max_width = 200;
    }
    else if ($max_width <= 250) {
        $max_width = 250;
    }
    else if ($max_width <= 300) {
        $max_width = 300;
    }
    else if ($max_width <= 350) {
        $max_width = 350;
    }
    else if ($max_width <= 400) {
        $max_width = 400;
    }
    else if ($max_width <= 450) {
        $max_width = 450;
    }
    else if ($max_width <= 500) {
        $max_width = 500;
    }
    else {
        // $max_width = 500;
    }
    
    // 전송받은 이미지의 포맷값 얻기 (gif, jpg, png) 
    if ($img_info[2] == 1) { 
        $src_img = ImageCreateFromGif($file); 
    } 
    else if ($img_info[2] == 2) { 
        $src_img = ImageCreateFromJPEG($file); 
    } 
    else if ($img_info[2] == 3) { 
        $src_img = ImageCreateFromPNG($file); 
    } 
    else { 
        return 0; 
    } 
    
    // 전송받은 이미지의 실제 사이즈 값얻기 
    $img_width = $img_info[0]; 
    $img_height = $img_info[1]; 
    
    if ($img_width <= $max_width) { 
        $max_width = $img_width; 
        $max_height = $img_height; 
    } 
    
    if ($img_width > $max_width){ 
        $max_height = ceil(($max_width / $img_width) * $img_height); 
    } 
    
    // 새로운 트루타입 이미지를 생성 
    $dst_img = imagecreatetruecolor($max_width, $max_height); 
    
    // R255, G255, B255 값의 색상 인덱스를 만든다 
    ImageColorAllocate($dst_img, 255, 255, 255); 
    
    // 이미지를 비율별로 만든후 새로운 이미지 생성 
    ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, ImageSX($src_img),ImageSY($src_img)); 
    
    // 알맞는 포맷으로 저장 
    if ($img_info[2] == 1) { 
        ImageInterlace($dst_img); 
        ImageGif($dst_img, $save_path.$save_filename); 
    } 
    else if ($img_info[2] == 2) { 
        ImageInterlace($dst_img); 
        ImageJPEG($dst_img, $save_path.$save_filename); 
    } 
    else if ($img_info[2] == 3) { 
        ImagePNG($dst_img, $save_path.$save_filename); 
    } 
    
    // 임시 이미지 삭제 
    ImageDestroy($dst_img); 
    ImageDestroy($src_img); 
} 

function image_thumnail($path, $name, $width = 100, $height = 100) {                    // 이미지 경로파일명 구함
    global $_SERVER;
    global $SITE_VAR;
    
    $thumnail_path = $path;
    $thumnail_name = $width . "x" . $height . "_" . $name;
    $thumnail = $thumnail_path . "/" . $thumnail_name;
    
    if (!is_file($_SERVER["DOCUMENT_ROOT"] . $thumnail)) {
        make_thumnail($_SERVER["DOCUMENT_ROOT"] . $path . "/" . $name, $thumnail_name, $_SERVER["DOCUMENT_ROOT"] . $thumnail_path . "/", $width, $height);
    }
    
    $thumnail = "http://" . $SITE_VAR["image_domain"] . $thumnail;  
    
    return $thumnail;
}   

function unlink_with_thumnail($file_path, $file_name) {             // 썸네일 포함 삭제
    // 썸네일 삭제
    foreach ( glob($file_path . "/" . "*_" . $file_name) as $filename ) {
        unlink($filename);
    }
    
    // 원본 삭제
    foreach ( glob($file_path . "/" . $file_name) as $filename ) {
        unlink($filename);
    }
}

?>
