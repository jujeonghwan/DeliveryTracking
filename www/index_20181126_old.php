<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();

// CJ대한통운NPlust 외부 링크일 경우 상단에 iFrame 처리
// 조회한 1개 항목만 보여주는 외부 링크일 경우
if (trim($_REQUEST["dummy"]) == "one") {
    if (trim($_REQUEST["deliverytype"]) == $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운NPlus"]) {
        if (trim($_REQUEST["keyword"]) != "") {
            // iframe 으로 보여주는 방식
            $slipno = eng_number_only($_REQUEST["keyword"]);
            
            echo "
                <center>
                    <iframe src=\"http://nplus.doortodoor.co.kr/web/detail.jsp?slipno=" . $slipno . "\" width=\"600\" height=\"1200\" frameborder=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" ></iframe>
                </center>
            ";

            /*
            // 직접 페이지 상단에 보여줌
            $deliverytype   =   trim($_REQUEST["deliverytype"]);
            $invoice_no     =   eng_number_only($_REQUEST["keyword"]);

            // 택배사별 배송조회 결과를 구함
            $result_deliverytracking = get_deliverytracking_result($deliverytype, $invoice_no);

            echo "
                <center>
                    " . $result_deliverytracking . "
                </center>

                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            ";
            */
        }
    }
}

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/nav.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/main.html");


// 배송조회 DB 저장할 값 미리 설정 (쿠키 관련 값)
$dt_userid      =   trim($_COOKIE["cookie_dt_userid"]);
$dt_ipaddress   =   trim($_SERVER["REMOTE_ADDR"]);
$dt_regtime     =   current_datetime();
$dt_referer     =   trim($_SESSION["session_dt_referer"]);

// 택배사
$deliverytype = trim($_REQUEST["deliverytype"]);

if ($deliverytype == "bundle") {        // 전체택배사(일괄조회)

}
else if ($deliverytype == "") {
    // 가장최근 조회한 항목
    $query = "select ";
    $query .= "dt_deliverytype ";
    $query .= "from deliverytracking_tb ";
    $query .= "where dt_userid = '" . $dt_userid . "' ";
    $query .= "order by dt_id desc ";
    $query .= "limit 1 ";
    
    $result = db_query($query);
        
    if ($row = db_fetch_array($result)) {
        $deliverytype = $row["dt_deliverytype"];
    }
    else {
        // $deliverytype = $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운"];
    }
}

// 전체택배사(일괄조회) 추가 항목
$COMMON_DELIVERYTYPE_BUNDLE_ARRAY = array (
    "--전체택배사(일괄조회)--"   =>  "bundle"
);
$option_bundle_array = array_flip($COMMON_DELIVERYTYPE_BUNDLE_ARRAY);
$option_array = array_flip($COMMON_DELIVERYTYPE_ARRAY);

$option_array = array_merge($option_bundle_array, $option_array);               // 배열을 합침 

$option = get_select_option("--택배사선택--", $option_array, $deliverytype);
// $option = get_select_option("--전체택배사(일괄조회)--", $option_array, $deliverytype);
tp_set("option_deliverytype", $option);
/* radio(옵션) 박스
$radio_array = array_flip($COMMON_DELIVERYTYPE_ARRAY);
$radio = get_input_radio("deliverytype", $radio_array, $deliverytype, "");
tp_set("radio_deliverytype", $radio);
*/

// 검색어
$keyword = trim($_REQUEST["keyword"]);
tp_set("keyword", $keyword);

// 현재접속날짜시간
// tp_set("current_datetime", get_datetime_format(current_datetime()));

// 현재접속IP주소
tp_set("ip_address", $_SERVER["REMOTE_ADDR"]);

    
// 운송장번호 (영어,숫자만 남김 (공백도 제거))
$invoice_no = eng_number_only($keyword); 
    
////////////////////////////////////////////////////////////////////////////////
// 택배사별 배송조회

if (($deliverytype != "bundle") && ($keyword != "")) {      // 전체택배사(일괄조회)가 아니고 운송장번호 있을 경우
    
    /*
    // 운송장번호 (영어,숫자만 남김 (공백도 제거))
    $invoice_no = eng_number_only($keyword);
    */    
    
    // 택배사별 배송조회 결과를 구함
    $result_deliverytracking = get_deliverytracking_result($deliverytype, $invoice_no);

    // 배송조회결과에서 조회결과문자 부분만 구함
    $resulttext_deliverytracking = get_deliverytracking_resulttext($result_deliverytracking);
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 배송조회이력 저장
    $dt_deliverytype        =   $deliverytype;
    $dt_keyword             =   $keyword;
    $dt_invoice             =   $invoice_no;
    $dt_deliveryprogress    =   get_deliverytracking_deliveryprogress($resulttext_deliverytracking);
    $dt_result              =   $result_deliverytracking;    
    $dt_resulttext          =   $resulttext_deliverytracking;
    $dt_userid              =   $dt_userid;                 // 제일 윗쪽에서 미리 설정 (1)
    $dt_ipaddress           =   $dt_ipaddress;              // 제일 윗쪽에서 미리 설정 (2)
    $dt_regtime             =   $dt_regtime;                // 제일 윗쪽에서 미리 설정 (3)
    $dt_referer             =   $dt_referer;                // 제일 윗쪽에서 미리 설정 (4)

    // 중복 체크
    $query = "select ";
    $query .= "count(*) as data_count ";
    $query .= "from deliverytracking_tb ";
    $query .= "where dt_deliverytype = '" . $dt_deliverytype . "' ";
    $query .= "and dt_keyword = '" . $dt_keyword . "' ";
    $query .= "and dt_ipaddress = '" . $dt_ipaddress . "' ";
    // $query .= "and dt_regtime = '" . $dt_regtime . "' ";
    $query .= "and dt_regtime like '" . substr($dt_regtime, 0, 13) . "%' ";     // 10초단위로 중복체크함. 예) '20160706230314'(14자리) -> '2016070623031'(13자리)
    // echo "<br />query : " . $query; exit;
    $result_sub = db_query($query);
    
    if ($row_sub = db_fetch_array($result_sub)) {
        $data_count = $row_sub["data_count"];
    }
    else {
        $data_count = 0;
    }
    
    
    // 등록
    if ($data_count <= 0) {
        $query = "insert into deliverytracking_tb ( ";
        $query .= "dt_deliverytype, ";
        $query .= "dt_keyword, ";
        $query .= "dt_invoice, ";
        $query .= "dt_deliveryprogress, ";
        $query .= "dt_result, ";
        $query .= "dt_resulttext, ";
        $query .= "dt_userid, ";
        $query .= "dt_ipaddress, ";
        $query .= "dt_regtime, ";
        $query .= "dt_referer ";
        $query .= ") values ( ";
        $query .= "'" . $dt_deliverytype . "', ";
        $query .= "'" . $dt_keyword . "', ";
        $query .= "'" . $dt_invoice . "', ";
        $query .= "'" . $dt_deliveryprogress . "', ";
        // $query .= "'" . htmlspecialchars($dt_result) . "', ";
        $query .= "'" . addslashes(htmlspecialchars($dt_result)) . "', ";
        $query .= "'" . addslashes(htmlspecialchars($dt_resulttext)) . "', ";
        $query .= "'" . $dt_userid . "', ";
        $query .= "'" . $dt_ipaddress . "', ";
        $query .= "'" . $dt_regtime . "', ";
        $query .= "'" . $dt_referer . "' ";
        $query .= ")";  

        /*
        if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["쿠팡로켓배송"]) {
            echo "<br />query : <xmp>" . $query . "</xmp>"; exit;    
        }
        */
        
        db_query($query);  

        sleep(1);
    }  
    
    // 시간 기다림
    // sleep(1);
}

// 택배사별 배송조회
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// 배송조회이력 목록 표시

$template = "row";
tp_dynamic($template);

$no = 0;            // NO 초기화

$where_query_sub_array = array(
    "1" =>  "and dt_invoice = '" . $invoice_no . "' ",      // 운송장번호 일치 (먼저 보여줌)
    "2" =>  "and dt_invoice != '" . $invoice_no . "' "      // 운송장번호 불일치 (나중에 보여줌)
);

foreach ($where_query_sub_array as $where_key => $where_query_sub) {

    $query = "select ";
    $query .= "dt_id, ";
    $query .= "dt_deliverytype, ";
    $query .= "dt_keyword, ";
    $query .= "dt_invoice, ";
    $query .= "dt_deliveryprogress, ";
    $query .= "dt_result, ";
    $query .= "dt_resulttext, ";
    $query .= "dt_userid, ";
    $query .= "dt_ipaddress, ";
    $query .= "dt_regtime, ";
    $query .= "dt_referer ";
    $query .= "from deliverytracking_tb ";
    $query .= "where dt_userid = '" . $dt_userid . "' ";
    $query .= $where_query_sub;
    $query .= "order by dt_id desc ";
    // 조회한 1개 항목만 보여주는 외부 링크일 경우
    if ($_REQUEST["dummy"] == "one") {
        if ($where_key == "1") {        // 운송장번호 일치
            $query .= "limit 1 ";
        }
        else if ($where_key == "2") {   // 운송장번호 불일치
            $query .= "limit 0 ";   
        }
    }

    $result = db_query($query);
    $result_rows = db_num_rows($result);
        
    while ($row = db_fetch_array($result)) {
        $no++;
        
        // tr class (교대로 생상 다르게 표시)
        if (($no % 2) == 0) {
            $tr_class = "success";
        }
        else {
            $tr_class = "warning";
        }

        // 배송진행상태
        if ($row["dt_deliveryprogress"] == "") {            
            $row["dt_deliveryprogress"] = get_deliverytracking_deliveryprogress($row["dt_resulttext"]);
        }

        // 상세조회결과 초기에 보여줄지 여부        
        $deliverytracking_display = "none";                 // 초기화

        // if ( ($no == 1) && ($keyword == $row["dt_keyword"]) ) {
        if ($invoice_no == $row["dt_invoice"]) {
            if ($no == 1) {
                $deliverytracking_display = "";
            }
            else {
                if ( ($row["dt_deliveryprogress"] == "조회불가") || ($row["dt_deliveryprogress"] == "-") ) {
                    $deliverytracking_display = "none";
                }
                else {
                    $deliverytracking_display = "";       
                }
            }            
        }

        // 배송조회 URL
        $deliverytracking_url = $SITE_VAR["url"] . "?dummy=one";
        $deliverytracking_url .= "&deliverytype=" . $row["dt_deliverytype"];
        $deliverytracking_url .= "&keyword=" . $row["dt_keyword"];
        $deliverytracking_url .= "#link";

        // 구글 광고
        if ($deliverytracking_display == "none") {
            $google_adsense_html = "";
        }
        else {
            $google_adsense_html = $GOOGLE_ADSENSE_HTML;
        }

        // 구글 광고 무조건 안보여줌
        $google_adsense_html = "";
        
        tp_set($template, array(
            "tr_class"                  =>  $tr_class,
            "dt_id"                     =>  $row["dt_id"],
            "no"                        =>  $no,

            "dt_deliverytype_text"      =>  array_search($row["dt_deliverytype"], $COMMON_DELIVERYTYPE_ARRAY),
            "dt_invoice"                =>  $row["dt_invoice"],        
            "dt_keyword"                =>  $row["dt_keyword"],
            "dt_regtime"                =>  get_simple_datetime_format($row["dt_regtime"]),    

            "color_dt_deliveryprogress" =>  $color_dt_deliveryprogress_array[$row["dt_deliveryprogress"]],  
            "dt_deliveryprogress"       =>  $row["dt_deliveryprogress"],    
            "dt_deliverytype"           =>  $row["dt_deliverytype"],
            
            "deliverytracking_display"  =>  $deliverytracking_display,  
            "dt_result"                 =>  htmlspecialchars_decode($row["dt_result"]),
            "dt_referer"                =>  $row["dt_referer"],
            "google_adsense_html"       =>  $google_adsense_html,
            "deliverytracking_url"      =>  $deliverytracking_url
        ));
        tp_parse($template);
    }

}

// 배송조회이력 목록 표시
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// 샘플 배송조회이력 목록 표시 (각 택배사별 1항목씩 데이터 표시)

// if ($_REQUEST["dummy"] == "all") {  
// if (($no <= 0) && ($_REQUEST["dummy"] == "all")) {    
if ($no <= 0) {

    $template = "row";
    tp_dynamic($template);
    
    foreach ($COMMON_DELIVERYTYPE_ARRAY as $key => $val) {
        $query = "select ";
        $query .= "dt_id, ";
        $query .= "dt_deliverytype, ";
        $query .= "dt_keyword, ";
        $query .= "dt_invoice, ";
        $query .= "dt_deliveryprogress, ";
        $query .= "dt_result, ";
        $query .= "dt_resulttext, ";
        $query .= "dt_userid, ";
        $query .= "dt_ipaddress, ";
        $query .= "dt_regtime, ";
        $query .= "dt_referer ";
        $query .= "from deliverytracking_tb ";
        $query .= "where dt_deliverytype = '" . $val . "' ";
        // $query .= "and dt_deliverytype != '" . $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점택배(CU,GS25)"] . "' ";
        // $query .= "and dt_deliveryprogress not in ('조회불가', '-') ";
        $query .= "and dt_deliveryprogress not in ('조회불가') ";
        $query .= "order by dt_id desc ";
        $query .= "limit 1 ";
        
        $result = db_query($query);
        $result_rows = db_num_rows($result);
            
            
        while ($row = db_fetch_array($result)) {
            $no++;

            // tr class (교대로 생상 다르게 표시)
            if (($no % 2) == 0) {
                $tr_class = "success";
            }
            else {
                $tr_class = "warning";
            }
                        

            // 상세조회결과 초기에 보여줄지 여부        
            if ( ($no == 1) && ($keyword == $row["dt_invoice"]) ) {
                $deliverytracking_display = "";    
            }
            else {
                $deliverytracking_display = "none";    
            }
            /*
            // 상세조회결과 초기에 페이지 로딩시에 보여줌
            $deliverytracking_display = "";
            */
            
            
            // 배송진행상태
            if ($row["dt_deliveryprogress"] == "") {            
                $row["dt_deliveryprogress"] = get_deliverytracking_deliveryprogress($row["dt_resulttext"]);
            }

            // 배송조회 URL
            $deliverytracking_url = $SITE_VAR["url"] . "?dummy=one";
            $deliverytracking_url .= "&deliverytype=" . $row["dt_deliverytype"];
            $deliverytracking_url .= "&keyword=" . $row["dt_keyword"];
            $deliverytracking_url .= "#link";

            // 구글 광고
            if ($deliverytracking_display == "none") {
                $google_adsense_html = "";
            }
            else {
                $google_adsense_html = $GOOGLE_ADSENSE_HTML;
            }

            // 구글 광고 무조건 안보여줌
            $google_adsense_html = "";
            
            tp_set($template, array(
                "tr_class"                  =>  $tr_class,
                "dt_id"                     =>  $row["dt_id"],
                "no"                        =>  $no,

                "dt_deliverytype_text"      =>  array_search($row["dt_deliverytype"], $COMMON_DELIVERYTYPE_ARRAY),
                "dt_invoice"                =>  $row["dt_invoice"],        
                "dt_keyword"                =>  $row["dt_keyword"],
                "dt_regtime"                =>  get_simple_datetime_format($row["dt_regtime"]),    

                "color_dt_deliveryprogress" =>  $color_dt_deliveryprogress_array[$row["dt_deliveryprogress"]],  
                "dt_deliveryprogress"       =>  $row["dt_deliveryprogress"],    
                "dt_deliverytype"           =>  $row["dt_deliverytype"],
                
                "deliverytracking_display"  =>  $deliverytracking_display,  
                "dt_result"                 =>  htmlspecialchars_decode($row["dt_result"]),
                "dt_referer"                =>  $row["dt_referer"],
                "google_adsense_html"       =>  $google_adsense_html,
                "deliverytracking_url"      =>  $deliverytracking_url
            ));
            tp_parse($template);
        }
    }
}
// 샘플 배송조회이력 목록 표시 (각 택배사별 1항목씩 데이터 표시)
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// 도메인 URL

// SITE_URL 예) http://www.deliverytracking.kr/
tp_set("site_url", $SITE_VAR["url"]);

// 도메인 URL 
////////////////////////////////////////////////////////////////////////////////

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer.php");



////////////////////////////////////////////////////////////////////////////////
// 자동 실행 처리할 항목

$rand_value = rand(1, 100);
// echo "<br />rand_value " . $rand_value;

switch ($rand_value) {
    case 1:
        // 쿠키파일 정리
        set_cookie_file_auto_delete();

        break;

    case 2:
        // 택배사배송조회 수집파일 정리
        set_deliverytracking_file_auto_delete();
        
        break;

    case 3:
        // 배송조회 DB파일 정리 (항목수 기준)
        set_deliverytracking_db_auto_delete();
        
        break;

    default:
        // 사용자ID별 최종방문일시 업데이트
        // set_deliverytracking_lastvisittime();

        break;
}

// 사용자ID별 최종방문일시 업데이트
set_deliverytracking_lastvisittime();

// 자동 실행 처리할 항목
////////////////////////////////////////////////////////////////////////////////

?>