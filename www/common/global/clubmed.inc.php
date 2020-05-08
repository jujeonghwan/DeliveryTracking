<?php

////////////////////////////////////////////////////////////////////////////////
// Constant (Club Med)

// 클럽메드 리조트
$CLUBMED_RESORT_ARRAY = array (
    "Bali"      => "발리",
    "Bintan"    => "빈탄 아일랜드"
);

// 클럽메드 가격조회 URL
$CLUBMED_PRICE_URL_ARRAY = array (
    "Bali"      => "https://www.clubmed.co.kr/r/%EB%B0%9C%EB%A6%AC/y",
    "Bintan"    => "https://www.clubmed.co.kr/r/%EB%B9%88%ED%83%84-%EC%95%84%EC%9D%BC%EB%9E%9C%EB%93%9C/y"
);

// 클럽메드 가격조회 URL
$CLUBMED_PRICE_URL_ARRAY = array (
    "Bali"      => "https://www.clubmed.co.kr/r/%EB%B0%9C%EB%A6%AC/y",
    "Bintan"    => "https://www.clubmed.co.kr/r/%EB%B9%88%ED%83%84-%EC%95%84%EC%9D%BC%EB%9E%9C%EB%93%9C/y"
);

// 클럽메드 가격조회 METHOD
$CLUBMED_PRICE_METHOD_ARRAY = array (
    "Bali"      => "GET",
    "Bintan"    => "GET"
);



////////////////////////////////////////////////////////////////////////////////
// Function (Club Med)

// 리조트별 가격을 구함
function get_clubmed_price_result($cp_resort) {



    global $CLUBMED_RESORT_ARRAY;
    global $CLUBMED_PRICE_URL_ARRAY;
    global $CLUBMED_PRICE_METHOD_ARRAY;



    ////////////////////////////////////////////////////////////////////////////////
    // 요청후 결과 기억

    // Initialize a cURL session
    $curlsession = curl_init();


    // 쿠키 파일 디렉터리 확인
    check_directory ($PATH_VAR["cookie_path"]);
    check_directory ($PATH_VAR["cookie_path"] . "/" . current_date());
    $cookie_file_save_path = $PATH_VAR["cookie_path"] . "/" . current_date();
        
    $cookie_file_name = current_datetime() . "_clubmed_cookie_" . urlencode($invoice_no) . ".txt";
    $cookie_file = $cookie_file_save_path . "/" . $cookie_file_name;


    // 클럽메드 가격조회 URL
    // 예) https://www.clubmed.co.kr/r/%EB%B0%9C%EB%A6%AC/y

    $clubmed_price_url  =   $CLUBMED_PRICE_URL_ARRAY[$cp_resort];

    $temp_url_array     =   explode("://", $clubmed_price_url);
    $temp_url2_array    =   explode("/", $temp_url_array[1]);

    $request_protocol   =   $temp_url_array[0];                                 // http, https        
    $request_host       =   $temp_url2_array[0];                                // www.clubmed.co.kr
    $request_uri        =   str_replace($request_host, "", $temp_url_array[1]); // /r/%EB%B0%9C%EB%A6%AC/y
    
    $request_uri_array  =   explode("?", $request_uri);
    $request_uri_file   =   $request_uri_array[0];                              // /r/%EB%B0%9C%EB%A6%AC/y      
    $request_uri_query  =   $request_uri_array[1];                              // ? 기호가 없을 경우 값없음
    
    echo "<br />request_protocol : " . $request_protocol;
    echo "<br />request_host : " . $request_host;
    echo "<br />request_uri : " . $request_uri;

    echo "<br />request_uri_file : " . $request_uri_file;
    echo "<br />request_uri_query : " . $request_uri_query;
    // exit;


    // cURL 시작
    $curlopt_url        =   $request_protocol . "://" . $request_host . $request_uri_file;                      // https://www.hlc.co.kr/home/personal/inquiry/track
    
    if ($CLUBMED_PRICE_METHOD_ARRAY[$cp_resort] == "POST") {
        $curlopt_post   =   1;          // POST
    }
    else {
        $curlopt_post   =   0;          // GET
    }
    
    $curlopt_postfields =   $request_uri_query;                         // InvNo=225100323652&action=processInvoiceSubmit
    $curlopt_useragent  =   "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)";
    $curlopt_referer    =   $curlopt_url;            
    // $curlopt_cookiejar  =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";
    // $curlopt_cookiefile =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";            
    $curlopt_cookiejar  =   $cookie_file;
    $curlopt_cookiefile =   $cookie_file;
    
    // /*
    echo "<br />curlopt_url : " . $curlopt_url;
    echo "<br />curlopt_post : " . $curlopt_post;
    echo "<br />curlopt_postfields : " . $curlopt_postfields;
    echo "<br />curlopt_referer : " . $curlopt_referer;
    echo "<br />curlopt_cookiejar : " . $curlopt_cookiejar;
    echo "<br />curlopt_cookiefile : " . $curlopt_cookiefile;
    // */            
    
    curl_setopt($curlsession, CURLOPT_URL, $curlopt_url);
    curl_setopt($curlsession, CURLOPT_HEADER, 1);
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlsession, CURLOPT_FOLLOWLOCATION, true);                        // 리다이렉트를 자동으로 잡아줘서 302가 아니라 200이 리턴됨
    curl_setopt($curlsession, CURLOPT_MAXREDIRS, 10);                               // 최대 리다이렉트 횟수
    curl_setopt($curlsession, CURLOPT_POST, 1);
    curl_setopt($curlsession, CURLOPT_POSTFIELDS, $curlopt_postfields);
    curl_setopt($curlsession, CURLOPT_USERAGENT, $curlopt_useragent);
    curl_setopt($curlsession, CURLOPT_REFERER, $curlopt_referer);
    curl_setopt($curlsession, CURLOPT_COOKIEJAR, $curlopt_cookiejar);
    curl_setopt($curlsession, CURLOPT_COOKIEFILE, $curlopt_cookiefile);
    curl_setopt($curlsession, CURLOPT_TIMEOUT, 10);                                 // 타임아웃 시간
                

    // $buffer =   curl_exec($curlsession);
    // $cinfo  =   curl_getinfo($curlsession);
    $result =   curl_exec($curlsession);
    
    // Close a cURL session
    curl_close($curlsession);
    
    $data = $result;

    echo "<xmp>" . $data . "</xmp>";

    ////////////////////////////// 여기여기여기
    // 클럽메드 


}

?>