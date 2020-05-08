<?php

/*
echo "서버 점검중입니다.";
exit;
*/

// 세션 데이터 초기화
session_start();

// 쿠키허용 설정
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"'); 

// DB
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/db.inc.php");

// 상수
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/constant.inc.php");

// 함수
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/function.inc.php");

// 사이트전용 함수
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/site.inc.php");


////////////////////////////////////////////////////////////////////////////////
// 택배사 배송조회관련 함수 포함된 파일 포함

foreach ($COMMON_DELIVERYTYPE_ARRAY as $key => $val) {
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/deliverytype/deliverytype_" . $val . ".php");
}

/* 예)

    // CJ대한통운
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/deliverytype/deliverytype_doortodoor.php");
    
    // 우체국택배
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/deliverytype/deliverytype_epost.php");
    
    // GTX택배
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/deliverytype/deliverytype_gtxlogis.php");
    
    // 한진택배
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/deliverytype/deliverytype_hanjin.php");
    
    // 합동택배
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/deliverytype/deliverytype_hdexp.php");
    
    // 로젠택배
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/deliverytype/deliverytype_ilogen.php");
    
*/

// 택배사 배송조회관련 함수 포함된 파일 포함
////////////////////////////////////////////////////////////////////////////////

// 템플릿
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/template.inc.php");

// 광고
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/ad.inc.php");


////////////////////////////////////////////////////////////////////////////////
// 쿠키설정(사용자ID)
    
if ($_COOKIE["cookie_dt_userid"] == "") {
    $cookie_dt_userid = current_datetime() . "_" . trim($_SERVER["REMOTE_ADDR"]);
    $_COOKIE["cookie_dt_userid"] = $cookie_dt_userid;
    
    $expire = 60 * 60 * 24 * 100;                           // 100일
    setcookie("cookie_dt_userid", $cookie_dt_userid, time() + $expire, "/", "");
}

// echo "<br />cookie_dt_userid : " . $_COOKIE["cookie_dt_userid"];

/*
if ($_COOKIE["cookie_test2"] == "") {
    $cookie_test2 = current_datetime() . "_" . trim($_SERVER["REMOTE_ADDR"]);    
    $_COOKIE["cookie_test2"] = $cookie_test2;

    $expire = 60 * 60 * 24 * 100;                           // 100일
    setcookie("cookie_test2", $cookie_test2, time() + $expire, "/", "");
}

echo "<br />cookie_test2 : " . $_COOKIE["cookie_test2"];
*/
// 쿠키설정(사용자ID)
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
// 세션설정(링크주소)
    
if ($_SESSION["session_dt_referer"] == "") {
    foreach (getallheaders() as $header_name => $header_value) {
        // Referer : http://aboki.wst.kr/zzz/dt_link.php

        if ($header_name == "Referer") {
            $referer_value = trim($header_value);

            $_SESSION["session_dt_referer"] = $referer_value;
            
            /*
            if (    ($referer_value != "") && 
                    (strpos($referer_value, $SITE_VAR["host"]) === false)   ) { // === 3개인것 중요함    
                // echo "<br />AAA referer : " . $referer_value;   
            }
            else {
                // echo "<br />BBB referer : " . $referer_value;   
                // 세션설정
                $_SESSION["session_dt_referer"] = $referer_value;
            }
            */
        }
    }

    // echo "<br />SITE_VAR host : " . $SITE_VAR["host"];
    // echo "<br />referer : " . $referer_value;
}

// echo "<br />session_dt_referer : " . $_SESSION["session_dt_referer"];
// 세션설정(링크주소)
////////////////////////////////////////////////////////////////////////////////


// 도메인체크 해서 메인도메인으로 이동
if ($_SERVER["HTTP_HOST"] != $SITE_VAR["domain"]) {
    // 예)
    // 이동전 : http://deliverytracking.kr/?dummy=dummy&deliverytype=kglogis&keyword=3043-4892-7584
    // 이동후 : http://www.deliverytracking.kr/?dummy=dummy&deliverytype=kglogis&keyword=3043-4892-7584
    // $_SERVER["REQUEST_URI"] : /?dummy=dummy&deliverytype=kglogis&keyword=3043-4892-7584        
    
    $location_href = "http://" . $SITE_VAR["domain"] . $_SERVER["REQUEST_URI"];
    // echo $location_href;    
    location_href($location_href);
}


// 접속 차단할 IP주소 막아놓음
if (in_array($_SERVER["REMOTE_ADDR"], $BLOCK_IP_ADDRESS_ARRAY)) {
    html_meta_charset_utf8();
    echo "<br />접속이 차단된 IP주소 입니다. : " . $_SERVER["REMOTE_ADDR"];
    echo "<br />사용하시려면 아래 이메일 주소로 요청해주시기 바랍니다.";
    echo "<br />" . $SITE_VAR["email"];
    exit;
}

// 데이터베이스 접속
db_connect();

?>
