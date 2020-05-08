<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/nav.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/main.html");

// 공통 대기시간 [초]
$SLEEP_TIME = 5;

$ms_userid = trim($_COOKIE["cookie_dt_userid"]); 

// 쿼리
$where_query = "where ms_userid = '" . $ms_userid . "' ";
$where_query .= "and ms_processstate = '" . $db_ms_processstate_array["미처리"] . "' ";

// 남은항목 갯수
$query = "select ";
$query .= "count(*) as multisearch_count ";
$query .= "from multisearch_tb ";
$query .= $where_query;

$result_count = db_query($query);
if ($row_count = db_fetch_array($result_count)) {
    $multisearch_count = $row_count["multisearch_count"];    
}
else {
    $multisearch_count = 0;
}


// 처리할 항목 1개를 읽어온다.
$query = "select ";
$query .= "ms_id, ";
$query .= "ms_deliverytype, ";
$query .= "ms_keyword, ";
$query .= "ms_remark, ";
$query .= "ms_userid, ";
$query .= "ms_processstate, ";
$query .= "ms_regtime ";
$query .= "from multisearch_tb ";
$query .= $where_query;
$query .= "order by ms_id ";
$query .= "limit 1 ";

$result_multisearch = db_query($query);
if (!$row_multisearch = db_fetch_array($result_multisearch)) {
    // 데이터가 없음
    // alert("[완료] 처리할 데이터 항목이 없습니다.");
    
    // 페이지 이동
    $location_href = "/";
    location_href($location_href);
    exit;
}

$ms_id              =   trim($row_multisearch["ms_id"]);
$ms_deliverytype    =   trim($row_multisearch["ms_deliverytype"]);
$ms_keyword         =   trim($row_multisearch["ms_keyword"]);
$ms_remark          =   trim($row_multisearch["ms_remark"]);
$ms_userid          =   trim($row_multisearch["ms_userid"]);
$ms_processstate    =   trim($row_multisearch["ms_processstate"]);
$ms_regtime         =   trim($row_multisearch["ms_regtime"]);

// 처리상태 (처리완료)
$query = "update multisearch_tb set ";
$query .= "ms_processstate = '" . $db_ms_processstate_array["처리완료"] . "' ";
$query .= "where ms_id = '" . $ms_id . "' ";
$query .= "limit 1 ";
    
if ($result_update = db_query($query)) {
    // alert("수정되었습니다.");
    // echo "<br />================================================================================";
    // echo "<br />수정되었습니다.";
}
else {
    alert("조회하는데 실패했습니다."); 

    // 페이지 이동
    $location_href = "/";
    location_href($location_href);
    exit;
}

/*
echo "<br />================================================================================";
echo "<br />다중검색 진행중... (남은 항목 갯수 : " . number_format($multisearch_count) . ")";

echo "<br /><br />택배사 : " . array_search($ms_deliverytype, $COMMON_DELIVERYTYPE_ARRAY);
echo "<br />운송장번호 : " . trim($ms_keyword);
echo "<br /><br />";
*/
$process_message = "
    <div class=\"row form-group\">   
        <div class=\"col-md-12 text-center\">
            <br />================================================================================
            <br />다중검색 진행중... (남은 항목 갯수 : " . number_format($multisearch_count) . ")

            <br /><br />택배사 : " . array_search($ms_deliverytype, $COMMON_DELIVERYTYPE_ARRAY) . "
            <br />운송장번호 : " . trim($ms_keyword) . "
            <br />비고 : " . trim($ms_remark) . "
            <br />================================================================================
        </div>    
    </div> 
";

tp_set("process_message", $process_message);


////////////////////////////////////////////////////////////////////////////////
// 택배사별 배송조회

$deliverytype   =   $ms_deliverytype;
$keyword        =   $ms_keyword;
$remark         =   $ms_remark;

if (($deliverytype != "") && ($keyword != "")) { 
    
    // 운송장번호 (영어,숫자만 남김 (공백도 제거))
    $invoice_no = eng_number_only($keyword);   
    
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
    $dt_remark              =   $remark;                    // 비고

    $dt_userid              =   trim($_COOKIE["cookie_dt_userid"]);
    $dt_ipaddress           =   trim($_SERVER["REMOTE_ADDR"]);
    $dt_regtime             =   current_datetime();
    $dt_referer             =   trim($_SESSION["session_dt_referer"]);

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
        $query .= "dt_remark, ";
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
        $query .= "'" . $dt_remark . "', ";
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
    }  
    
    // 시간 기다림
    // sleep(1);
}

// 택배사별 배송조회
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
// 화면 표시 내용 부분

// 현재접속IP주소
tp_set("ip_address", $_SERVER["REMOTE_ADDR"]);


////////////////////////////////////////////////////////////////////////////////
// 배송조회이력 목록 표시 (현재 조회항목 1개만)

$template = "row";
tp_dynamic($template);

$no = 0;            // NO 초기화


$query = "select ";
$query .= "dt_id, ";
$query .= "dt_deliverytype, ";
$query .= "dt_keyword, ";
$query .= "dt_invoice, ";
$query .= "dt_deliveryprogress, ";
$query .= "dt_result, ";
$query .= "dt_resulttext, ";
$query .= "dt_remark, ";
$query .= "dt_userid, ";
$query .= "dt_ipaddress, ";
$query .= "dt_regtime, ";
$query .= "dt_referer ";
$query .= "from deliverytracking_tb ";
$query .= "where dt_userid = '" . $dt_userid . "' ";
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

    // 배송진행상태
    if ($row["dt_deliveryprogress"] == "") {            
        $row["dt_deliveryprogress"] = get_deliverytracking_deliveryprogress($row["dt_resulttext"]);
    }

    // 상세조회결과 초기에 보여줄지 여부        
    /*
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
    */
    // 상세조회결과 무조건 보여줌
    $deliverytracking_display = "";  

    // 배송조회 URL
    $deliverytracking_url = $SITE_VAR["url"] . "?dummy=one";
    $deliverytracking_url .= "&deliverytype=" . $row["dt_deliverytype"];
    $deliverytracking_url .= "&keyword=" . $row["dt_keyword"];
    // $deliverytracking_url .= "#link";

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
        "dt_remark"                 =>  $row["dt_remark"],

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

// 배송조회이력 목록 표시 (현재 조회항목 1개만)
////////////////////////////////////////////////////////////////////////////////



tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer.php");


////////////////////////////////////////////////////////////////////////////////
// 페이지 이동

sleep($SLEEP_TIME);

$location_href = "/deliverytracking_multisearch_process.php";
// $location_href .= "&deliverytype=" . $_REQUEST["deliverytype"];
// $location_href .= "&keyword=" . urlencode($_REQUEST["keyword"]);
location_href($location_href);

?>