<?php

$json = '{"Locale":"ko_KR","TrackingNumber":["1Z31X7610476007308"]}';
$obj = json_decode($json);

print_r($obj);




require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// 택배사구분 (알파벳순)
$COMMON_DELIVERYTYPE_ARRAY = array (
    "쿠팡로켓배송" => "coupang",
    "대운글로벌(국제)" => "daewoonsys",
    "CJ대한통운" => "doortodoor",
    "대신택배" => "ds3211",
    "EMS국제우편(국제)" => "ems",
    "우체국택배" => "epost",
    "FedEx(국제)" => "fedex",
    "GTX로지스" => "gtxlogis",
    "한진택배" => "hanjin",
    "합동택배" => "hdexp",
    "현대택배" => "hlc",
    "로젠택배" => "ilogen",
    "KGB택배" => "kgbls",
    "KG로지스" => "kglogis",
    "TNT(국제)" => "tnt",
    "UPS(국제)" => "ups", 
    "YANWEN(국제)" => "yw56"
);
// user_login_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/nav.php");

// tp_read($_SERVER["DOCUMENT_ROOT"] . "/main.html");


// 배송조회 DB 저장할 값 미리 설정 (쿠키 관련 값)
$dt_userid      =   trim($_COOKIE["cookie_dt_userid"]);
$dt_ipaddress   =   trim($_SERVER["REMOTE_ADDR"]);
$dt_regtime     =   current_datetime();
$dt_referer     =   trim($_SESSION["session_dt_referer"]);

// 택배사
$_REQUEST["deliverytype"] = "ups";
$deliverytype = trim($_REQUEST["deliverytype"]);

// 검색어
$_REQUEST["keyword"] = "1Z31X7610476007308";
$keyword = trim($_REQUEST["keyword"]);
tp_set("keyword", $keyword);
    
// 운송장번호 (영어,숫자만 남김 (공백도 제거))
$invoice_no = eng_number_only($keyword); 

echo "<br />deliverytype : " . $deliverytype;
echo "<br />keyword : " . $keyword;
echo "<br />invoice_no : " . $invoice_no;









    // 운송장번호 (영어,숫자만 남김 (공백도 제거))
    // $invoice_no = eng_number_only($keyword);
    
    ////////////////////////////////////////////////////////////////////////////////
    // 요청후 결과 기억
    
    // Initialize a cURL session
    $curlsession = curl_init();
    
    
    
    // 쿠키 파일 디렉터리 확인
    check_directory ($PATH_VAR["cookie_path"]);
    check_directory ($PATH_VAR["cookie_path"] . "/" . current_date());
    $cookie_file_save_path = $PATH_VAR["cookie_path"] . "/" . current_date();
        
    $cookie_file_name = current_datetime() . "_" . $deliverytype . "_cookie_" . urlencode($invoice_no) . ".txt";
    $cookie_file = $cookie_file_save_path . "/" . $cookie_file_name;
   
    
    
    
    
    
    
    // 택배사 배송조회 페이지를 읽음 (예 : https://www.doortodoor.co.kr/main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=690052355203)
    $delivery_search_url = $COMMON_DELIVERYURL_ARRAY[$deliverytype];
    
    $temp_url_array     =   explode("://", $delivery_search_url);
    $temp_url2_array    =   explode("/", $temp_url_array[1]);
    
    $request_protocol   =   $temp_url_array[0];                                 // http, https        
    $request_host       =   $temp_url2_array[0];                                // www.doortodoor.co.kr
    $request_uri        =   str_replace($request_host, "", $temp_url_array[1]); // /main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    
    // 운송장번호 부분 대체 : {invoice_no} => 123456789012
    $request_uri        =   str_replace("{invoice_no}", urlencode($invoice_no), $request_uri);
    
    // [UPS(국제)] 배송조회 선처리 부분 대체 : {query_string} => item_unique_code=&member_code=coupang&member_name=%25ec%25bf%25a0%25ed%258c%25a1&is_mobile=N&root_path=http%253a%252f%252fb2c.goodsflow.com%253a80%252fsmall%252fCoupang&top_bar_visible=Y&data_type=xml&tracking_data=goodsFLOWWh...
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        // echo "<br />request_uri : " . $request_uri; exit;
        /*

        Set-Cookie: UPS_SHARED_SESSION=rzi7vnXK1q9lEk+Iw34+6VyZLq6QfhGu+jPYTrHKUy2jxcDrflsjRNHzfTXLia6MjNxVd8A8uUJLYRIXcWMtZhZnGFi5euY2X5batRJb0aGb04EstQXiYQnsZYix3NfPRpx+NdZXYg8qnPcLtAqdzzyC9QlzzVlOpaSnHcFrLvfK1+A2yYRnNdp0NVnANYevMa397fsb0aO9muAdWVr3S95e8aZtZsRY+fjv2/WVnnhB8uPnO2BNfMyMzURzyj8zPE2FAkMc4Ff6BV2CVOlzHVT889uLu2IZMsqgF1/PwEdhOOusvyq9HLd44qrIprcQPRpg9b/kLUca92w5wHLok1yz23kLc8mXrwmanq8EgSW2itUjCuR0Lj4AssBN1Dnm8nhm2grWG0Sm/VgLTADW8VGHilURMiWOZHzwSegd3rUL6FcH+EvZAVqhb3JxwzvJm6mZ2oJNe/sePfAQNPTrGhYSepPYh6zLrEGxFWjy8ozKMK2IExIjjyNnNg/159EBsoNYu4dWH+L14jTG1kVFWVQ3mO7ujKdrmWb1lueUOuShtvZ+m6lUD4HKjhvrX++z50BihHxTEVVZpvSM3fN0LF8zulsCmypBZLjQUbOuBn13vnNxZ5MZ9H4wj+R3Q++u+u73/HMM+fCxQz6Wt/vjtlbKI2vG8k4QDIyihzHdQkLuIk9mF/KIO+RCH9l5O8XMkkkGU9kiq+y2391MethN2cPdYxMMFmqighqx8TywjMDs2S35IesR5S+MFXF5PGHgPRtUI++so73LPwX4goCLiw+ZgeTQLKcIcqFeGAsyN+k=A147d8115d; Domain=.ups.com; Path=/; Secure; HttpOnly

        <form name="detailForm" id="detailFormid" action="https://wwwapps.ups.com/WebTracking/detail" method="post">
            <input type="hidden" name="loc" value="ko_KR" >
            <input type="hidden" name="USER_HISTORY_LIST" value="">
            <input type="hidden" name="progressIsLoaded" value="N">
            <input type="hidden" name="refresh_sii" value="" id="refresh_sii_id">
            <input type="hidden" name="showSpPkgProg1" value="" id="showSpPkgProg_id">
            <input type="hidden" name="datakey" value="line1" >
            <INPUT name="HIDDEN_FIELD_SESSION" type="HIDDEN" value="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A1f0d84424">
            
            <div class="secLvl secLvlPlain detail clearfix">
                <fieldset>
                    <div><p class="error">                      
                        <label id="descErr1Z1041AV0325295726" >                                                                     
                        </label></p>
                    </div>
                    <div class="secHead clearfix">          
                        <input type="hidden" name="descValue1Z1041AV0325295726" value="" >
                      
                        <h3 id="trkNum"><img alt="" border="0" height="1" src="/img/1.gif" width="1">                       
                            
                            <label id="descText1Z1041AV0325295726" >                                                                                                                                
                            </label>                                                    
                            
                            <input type="hidden" name="trackNums" value="1Z1041AV0325295726">
                            1Z1041AV0325295726
                        </h3>                           
                         
                        <ul class="clearfix">                               
                            <li>업데이트됨:&nbsp;2016/06/03 3:05&nbsp;동부 시간                                  
                            </li>       
                        </ul>
                    </div>
                </fieldset>
            </div>  
        </form>
        */

        $content_temp   =   $pre_result;
        // echo "<xmp>" . $content_temp . "</xmp>"; exit;


        // UPS(국제) Cookie의 일부값을 구함
        $content_array  =   explode("Set-Cookie:", $content_temp);
        $content_array2 =   explode("UPS_SHARED_SESSION=", $content_array[1]);
        $content_array3 =   explode(";", $content_array2[1]);
        $UPS_SHARED_SESSION =   trim($content_array3[0]);
        // echo "UPS_SHARED_SESSION : <br /><xmp>" . $UPS_SHARED_SESSION . "</xmp>"; exit;

        
        $POST_NAME_ARRAY = array (
            "loc",
            "USER_HISTORY_LIST",
            "progressIsLoaded",
            "refresh_sii",
            "showSpPkgProg1",
            "datakey",
            "HIDDEN_FIELD_SESSION",
            "descValue" . $invoice_no,
            "trackNums"
        );

        

        $query_string = "";             // 초기화

        $i = 0;
        foreach ($POST_NAME_ARRAY as $key => $val) {
            $i++;
            $POST_NAME = $val;

            if ($POST_NAME == "HIDDEN_FIELD_SESSION") {
                $content_array  =   explode("<INPUT name=\"" . $POST_NAME . "\" type=\"HIDDEN\" value=\"", $content_temp);
                $content_array2 =   explode("\"", $content_array[1]);
                $POST_VALUE     =   trim($content_array2[0]);
            }
            else if ($POST_NAME == "progressIsLoaded") {
                // progressIsLoaded=Y 값 고정
                $POST_VALUE     =   "Y";
            }
            else if ($POST_NAME == "showSpPkgProg1") {
                // showSpPkgProg1=true 값 고정
                $POST_VALUE     =   "true";
            }
            else {
                $content_array  =   explode("<input type=\"hidden\" name=\"" . $POST_NAME . "\" value=\"", $content_temp);
                $content_array2 =   explode("\"", $content_array[1]);
                $POST_VALUE     =   trim($content_array2[0]);
            }   

            if ($i > 1) {
                $query_string .= "&";    
            }

            $query_string .= $POST_NAME . "=" . $POST_VALUE;
        }

        $request_uri    =   str_replace("{query_string}", $query_string, $request_uri);   
        echo "<xmp>" . $request_uri . "</xmp>"; // exit; 
    }

    
    $request_uri_array  =   explode("?", $request_uri);
    $request_uri_file   =   $request_uri_array[0];                              // /main/doortodoor.do       
    $request_uri_query  =   $request_uri_array[1];                              // fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        echo "<br />request_uri_file : " . $request_uri_file; // exit;
        echo "<br />request_uri_query : " . $request_uri_query; exit;
    }
    */
    
    
    $curlopt_url        =   $request_protocol . "://" . $request_host . $request_uri_file;          // https://www.hlc.co.kr/home/personal/inquiry/track
    
    if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
        $curlopt_post   =   1;          // POST
    }
    else {
        $curlopt_post   =   0;          // GET
    }
    
    $curlopt_postfields =   $request_uri_query;                                                     // InvNo=225100323652&action=processInvoiceSubmit
    $curlopt_useragent  =   "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)";
        
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["FedEx(국제)"]) {
        $curlopt_referer    =   "https://www.fedex.com/apps/fedextrack/?action=track&tracknumbers=" . $invoice_no . "&locale=ko_KR&cntry_code=kr";
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        $curlopt_referer    =   "https://wwwapps.ups.com/WebTracking/track?loc=ko_KR";
    }
    else {
        $curlopt_referer    =   $curlopt_url;    
    }

    // $curlopt_cookiejar  =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";
    // $curlopt_cookiefile =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";            
    $curlopt_cookiejar  =   $cookie_file;
    $curlopt_cookiefile =   $cookie_file;            
    
    // /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        echo "<br />curlopt_postfields : <xmp>" . $curlopt_postfields . "</xmp>";

        echo "<br /><br /><br />";
        echo "<br />curlopt_url : " . $curlopt_url;
        echo "<br />curlopt_post : " . $curlopt_post;
        echo "<br />curlopt_postfields : " . $curlopt_postfields;
        echo "<br />curlopt_referer : " . $curlopt_referer;
        echo "<br />curlopt_cookiejar : " . $curlopt_cookiejar;
        echo "<br />curlopt_cookiefile : " . $curlopt_cookiefile;
        // exit;
    }
    // */

    /* Smaple
    $ch = curl_init();//initialize the curl
    curl_setopt($ch, CURLOPT_URL, 'https://thepilotslife.com/chat');//this page sets cookie
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//to overcome SSL verification
    curl_exec($ch);//execute the curl to get and set cookies
    curl_setopt($ch, CURLOPT_URL, 'https://thepilotslife.com/assets/chat-output.php');//now set the url to page which we needed the output from
    echo curl_exec($ch);//echo the result
    */
    
    curl_setopt($curlsession, CURLOPT_URL, $curlopt_url);
    curl_setopt($curlsession, CURLOPT_HEADER, 1);
    
    // curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curlsession, CURLOPT_FOLLOWLOCATION, true);                    // 리다이렉트를 자동으로 잡아줘서 302가 아니라 200이 리턴됨
    curl_setopt($curlsession, CURLOPT_MAXREDIRS, 10);                           // 최대 리다이렉트 횟수
    curl_setopt($curlsession, CURLOPT_POST, $curlopt_post);
    curl_setopt($curlsession, CURLOPT_POSTFIELDS, $curlopt_postfields);
    curl_setopt($curlsession, CURLOPT_USERAGENT, $curlopt_useragent);
    curl_setopt($curlsession, CURLOPT_REFERER, $curlopt_referer);
    curl_setopt($curlsession, CURLOPT_COOKIEJAR, $curlopt_cookiejar);
    curl_setopt($curlsession, CURLOPT_COOKIEFILE, $curlopt_cookiefile);
    curl_setopt($curlsession, CURLOPT_TIMEOUT, 10);                             // 타임아웃 시간

    // curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false);                //to overcome SSL verification

    $result =   curl_exec($curlsession);
    
    // sleep(1);
    
    // Close a cURL session
    curl_close($curlsession);
    
    $data = $result;
    
    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["TNT(국제)"]) {
        echo "<xmp>" . $data . "</xmp>";

        echo "<br />request_uri : <br /><xmp>" . $request_uri . "</xmp>";        
        exit;
    }
    */  
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // cURL 동작이 안되는 택배사 fsockopen 으로 처리
    
    // (알파벳순)

    /*            
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["합동택배"]) {
    */
    
    if (    ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["쿠팡로켓배송"]) ||
            ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["합동택배"]) ||
            // ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) ||
            ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["ZZZ"]) ) {            // 소스편리하게 처리하기 위해서 의미 없는 항목 넣어놓음
    
        if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
            
            $string = $COMMON_DELIVERYMETHOD_ARRAY["$deliverytype"] . " " . $request_protocol . "://" . $request_host . $request_uri_file . " HTTP/1.0\r\n";
            
            $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);    // 예) fbe9c26702    
            $string .= "Content-type: multipart/form-data, boundary=" . $boundary . "\r\n";
        
            // 본문 생성
            $post_data_array    =   explode("?", $request_uri);                     // 예) /Delivery_html/inquiry/result_waybill.jsp?wbl_num=406535669400
            $post_data2_array   =   explode("&", $post_data_array[1]);              // 예) wbl_num=406535669400
            
            $post_data2_count   =   count($post_data2_array);
            
            $data = "";
            for ($i = 0; $i < $post_data2_count; $i++) {             
                $post_data3_array   =   explode("=", $post_data2_array[$i]);   
                
                $data .= "--" . $boundary . "\r\n";
                $data .= "Content-Disposition: form-data; name=\"" . $post_data3_array[0] . "\"\r\n";   // wbl_num
                $data .= "\r\n" . $post_data3_array[1] . "\r\n";                                        // 406535669400
                $data .="--" . $boundary . "\r\n";
            }


            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["쿠팡로켓배송"]) {
                $string .= "Referer: http://b2c.goodsflow.com/small/Coupang/Whereis.aspx\r\n";
                $string .= "Host: b2c.goodsflow.com\r\n";
                $string .= "Cookie: ASPSESSIONIDAARTRSSB=FFLEHKPDMGJLOLDLLDEPPMNI; ASP.NET_SessionId=wvsv53gtxsnt1x1ssmxygehm; ASPSESSIONIDCCQTQQSA=PCDAFCIAHCHFOFICBEPGFBIN; ASPSESSIONIDACRSRQSA=HIBOFODABDHBMILAHNDCONGB\r\n";
            }

            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {

                // $string .= "Accept: text/html, application/xhtml+xml, image/jxr, */*\r\n";
                // $string .= "Accept-Encoding: gzip, deflate\r\n";
                // $string .= "Accept-Language: ko\r\n";
                // $string .= "Cache-Control: no-cache\r\n";
                // $string .= "Connection: Keep-Alive\r\n";
                // $string .= "Content-Length: 2780\r\n";
                // $string .= "Content-Type: application/x-www-form-urlencoded\r\n";
                $string .= "Cookie: WT_FPC=id=175.208.158.237-521020288.30523347:lv=1465153791965:ss=1465153765881; UPS_SHARED_SESSION=" . $UPS_SHARED_SESSION . "; WT_MIG=ss=1465204182678\r\n";
                $string .= "Host: wwwapps.ups.com\r\n";
                $string .= "Referer: https://wwwapps.ups.com/WebTracking/track?loc=ko_KR\r\n";
                // $string .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko\r\n";


                // $string .= "Accept: text/html, application/xhtml+xml, image/jxr, */*\r\n";
                // $string .= "Referer: https://wwwapps.ups.com/WebTracking/track\r\n";
                // $string .= "Accept-Language: ko\r\n";
                // $string .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko\r\n";
                // $string .= "Content-Type: application/x-www-form-urlencoded\r\n";
                // $string .= "Accept-Encoding: gzip, deflate\r\n";
                // $string .= "Host: wwwapps.ups.com\r\n";
                // // $string .= "Content-Length: 2796\r\n";
                // $string .= "DNT: 1\r\n";                
                // // $string .= "Connection: Keep-Alive\r\n";
                // $string .= "Cache-Control: no-cache\r\n";
                // $string .= "Cookie: WT_FPC=id=112.221.253.82-868809984.30522696:lv=1464887137904:ss=1464887001117; defaultHome=kr_ko_home|1464924625248; UPS_SHARED_SESSION=" . $UPS_SHARED_SESSION . "; WT_MIG=ss=1464924677947\r\n";

            }

            $string .= "Content-length: " . strlen($data) . "\r\n";
            $string .= "Connection: Close\r\n\r\n";
            // $string .= "Connection: Keep-Alive\r\n\r\n";
            
            $string .= $data;                               // POST 데이터 뒷부분 추가
        }
        else {                                              // GET
            $string = $COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] . " " . $request_uri . " HTTP/1.0\r\n";                   // 예) GET /trace.RetrieveDomRigiTraceList.comm?sid1=6025015340963&displayHeader=N HTTP/1.0    
            $string .= "Host: " . $request_host . "\r\n";    
            $string .= "Connection: Close\r\n\r\n";
        }
        ////////////////////////////////////////////////////////////////////////////////
        
        /*
        if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
            echo "<xmp>" . $string . "</xmp>"; // exit;
        }
        */
        
        if ($request_protocol == "https") {
            $fsockopen_hostname =   "ssl://" . $request_host;
            $fsockopen_port     =   443;    
        }
        else {
            $fsockopen_hostname =   $request_host;
            $fsockopen_port     =   80;
        }
        
        $fp = fsockopen($fsockopen_hostname, $fsockopen_port);
        fputs($fp, $string);
        
        $data = "";
        while (!feof($fp)) {
            $data .= fgets($fp, 1024);   
        }
        fclose($fp); 
        
    }
    
    // cURL 동작이 안되는 택배사 fsockopen 으로 처리
    ////////////////////////////////////////////////////////////////////////////////
    
    
    // /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        echo "<xmp>" . $data . "</xmp>"; exit;
        // echo $data; exit;
    }
    // */
    
    
    // 인코딩 확인
    $encoding_type = mb_detect_encoding($data, $ENCODING_TYPE_ARRAY);
    
    if ($encoding_type == "ASCII") {
        $data = iconv_euckr_utf8($data);                    // 인코딩 변경 ("EUC-KR" -> "UTF-8")
    }
    else if ($encoding_type == "EUC-KR") {
        $data = iconv_euckr_utf8($data);                    // 인코딩 변경 ("EUC-KR" -> "UTF-8")
    }
    else if ($encoding_type == "UTF-8") {
        // utf-8 그대로 사용

        // $data = iconv_utf8_euckr($data);   
    }
    else {
        echo "인코딩 확인 : " . $encoding_type;
        exit;
    }


    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        echo "<xmp>" . $data . "</xmp>"; exit;
    }
    */
        
    
    // 택배사배송조회 수집파일 디렉터리 확인
    check_directory ($PATH_VAR["deliverytracking_path"]);
    check_directory ($PATH_VAR["deliverytracking_path"] . "/" . current_date());
    $file_save_path = $PATH_VAR["deliverytracking_path"] . "/" . current_date();
        
    
    // 결과 파일로 저장
    $temp_file_name = current_datetime() . "_" . $deliverytype . "_" . urlencode($invoice_no);
    $file = $file_save_path . "/" . $temp_file_name;
    
    $fp2 = fopen($file, "w");
    fputs($fp2, $data);
    fclose($fp2);

    // 파일 읽어서 파싱 DB입력
    if (!file_exists($file)) {
        echo "파일이 없습니다.";   
    }
    
    $fp3    =   fopen($file, "r");
    $text   =   fread($fp3, filesize($file));
    fclose($fp3);


    // 데이터 파싱해서 입력
    $content_temp   =   $text;
    echo "<xmp>" . $content_temp . "</xmp>"; exit;











require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer.php");

?>