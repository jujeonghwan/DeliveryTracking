<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();
html_meta_charset_utf8();


// 배송조회 DB 저장할 값 미리 설정 (쿠키 관련 값)
$dt_userid      =   trim($_COOKIE["cookie_dt_userid"]);
$dt_ipaddress   =   trim($_SERVER["REMOTE_ADDR"]);
$dt_regtime     =   current_datetime();
$dt_referer     =   trim($_SESSION["session_dt_referer"]);


// 검색어
$keyword = trim($_REQUEST["keyword"]);

////////////////////////////////////////////////////////////////////////////////
// 택배사별 배송조회

if ($keyword != "") {

    // 배열 역순으로 실행
    $REVERSE_COMMON_DELIVERYTYPE_ARRAY = array_reverse($COMMON_DELIVERYTYPE_ARRAY); 

    foreach ($REVERSE_COMMON_DELIVERYTYPE_ARRAY as $key => $val) {              // 역순
        $deliverytype = $val;

        echo "<br />================================================================================";
        echo "<br />택배사 일괄조회 진행중...";

        echo "<br /><br />택배사 : " . array_search($deliverytype, $COMMON_DELIVERYTYPE_ARRAY);
        echo "<br /><br />검색어 : " . $keyword;
        echo "<br /><br />";


        // 운송장번호 (영어,숫자만 남김 (공백도 제거))
        $invoice_no = eng_number_only($keyword);
        
        
        // 택배사별 배송조회 결과를 구함
        $result_deliverytracking = get_deliverytracking_result($deliverytype, $invoice_no);
        // echo "<xmp>" . $result_deliverytracking . "</xmp>"; exit;

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
        $dt_userid              =   $dt_userid;             // 제일 윗쪽에서 미리 설정 (1)
        $dt_ipaddress           =   $dt_ipaddress;          // 제일 윗쪽에서 미리 설정 (2)
        $dt_regtime             =   $dt_regtime;            // 제일 윗쪽에서 미리 설정 (3)
        $dt_referer             =   $dt_referer;            // 제일 윗쪽에서 미리 설정 (4)
        
        // 중복 체크
        $query = "select ";
        $query .= "count(*) as data_count ";
        $query .= "from deliverytracking_tb ";
        $query .= "where dt_deliverytype = '" . $dt_deliverytype . "' ";
        $query .= "and dt_keyword = '" . $dt_keyword . "' ";
        $query .= "and dt_ipaddress = '" . $dt_ipaddress . "' ";
        // $query .= "and dt_regtime = '" . $dt_regtime . "' ";
        $query .= "and dt_regtime like '" . substr($dt_regtime, 0, 13) . "%' "; // 10초단위로 중복체크함. 예) '20160706230314'(14자리) -> '2016070623031'(13자리)
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
            $query .= "'" . addslashes(htmlspecialchars($dt_result)) . "', ";
            $query .= "'" . addslashes(htmlspecialchars($dt_resulttext)) . "', ";
            $query .= "'" . $dt_userid . "', ";
            $query .= "'" . $dt_ipaddress . "', ";
            $query .= "'" . $dt_regtime . "', ";
            $query .= "'" . $dt_referer . "' ";
            $query .= ")";
            // echo "<br />query : <xmp>" . $query . "</xmp>"; exit;
            
            db_query($query);  
        }  
        
        // 시간 기다림
        // sleep(1);
    }   
}

// exit;
// alert("해당운송장번호로 전체택배사를 일괄 조회했습니다.");

// 시간 기다림
sleep(1);

// 페이지 이동
$location_href = "/?dummy=dummy";
$location_href .= "&deliverytype=bundle";                   // 일괄조회
$location_href .= "&keyword=" . urlencode($_REQUEST["keyword"]);
location_href($location_href);

?>