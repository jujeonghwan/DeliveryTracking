<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");


    $deliverytype = $COMMON_DELIVERYTYPE_ARRAY["롯데택배"];
    $invoice_no = "305854318232";


    // 롯데택배
    // 택배사 배송조회 페이지를 읽음 (예 : https://www.doortodoor.co.kr/main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=690052355203)
    // $delivery_search_url = $COMMON_DELIVERYURL_PRE_ARRAY[$deliverytype];        // 선처리 페이지
    
    $delivery_search_url = "https://www.lotteglogis.com/home/personal/inquiry/track?InvNo={invoice_no}&action=processInvoiceLinkSubmit";
    $temp_url_array     =   explode("://", $delivery_search_url);
    $temp_url2_array    =   explode("/", $temp_url_array[1]);
    
    $request_protocol   =   $temp_url_array[0];                                 // http, https        
    $request_host       =   $temp_url2_array[0];                                // www.doortodoor.co.kr
    $request_uri        =   str_replace($request_host, "", $temp_url_array[1]); // /main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012

    $request_uri        =   str_replace("{invoice_no}", urlencode($invoice_no), $request_uri);

    $request_uri_array  =   explode("?", $request_uri);
    $request_uri_file   =   $request_uri_array[0];                              // /main/doortodoor.do       
    $request_uri_query  =   $request_uri_array[1];                              // fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012


    $string = $COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] . " " . $request_protocol . "://" . $request_host . $request_uri_file . " HTTP/1.0\r\n";
            
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

    $string .= "Content-length: " . strlen($data) . "\r\n";
    $string .= "Connection: Close\r\n\r\n";
    // $string .= "Connection: Keep-Alive\r\n\r\n";
    
    $string .= $data;                               // POST 데이터 뒷부분 추가

    echo "<xmp>" . $string . "</xmp>";


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


    echo "<xmp>" . $data . "</xmp>";


    exit;


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
   
    
    ////////////////////////////////////////////////////////////////////////////////
    // 택배사 배송조회 선처리 (시작)
    
        
    // 택배사 배송조회 선처리 페이지를 읽음 (예 : https://www.hlc.co.kr/home/personal/inquiry/track?InvNo=225100323652&action=processInvoiceSubmit)
    $delivery_search_url = $COMMON_DELIVERYURL_PRE_ARRAY[$deliverytype];
    
    $temp_url_array     =   explode("://", $delivery_search_url);
    $temp_url2_array    =   explode("/", $temp_url_array[1]);
    
    $request_protocol   =   $temp_url_array[0];                                 // http, https        
    $request_host       =   $temp_url2_array[0];                                // www.hlc.co.kr
    $request_uri        =   str_replace($request_host, "", $temp_url_array[1]); // /home/personal/inquiry/track?InvNo=225100323652&action=processInvoiceSubmit
    
    // 운송장번호 부분 대체 : {invoice_no} => 225100323652
    $request_uri        =   str_replace("{invoice_no}", urlencode($invoice_no), $request_uri);
    
    $request_uri_array  =   explode("?", $request_uri);
    $request_uri_file   =   $request_uri_array[0];                      // /home/personal/inquiry/track       
    $request_uri_query  =   $request_uri_array[1];                      // InvNo=225100323652&action=processInvoiceSubmit
    // echo $request_uri; exit;
    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) {
        echo $request_uri;
        exit;
    }
    */
                
    // cURL 시작
    $curlopt_url        =   $request_protocol . "://" . $request_host . $request_uri_file;                      // https://www.hlc.co.kr/home/personal/inquiry/track
    
    if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
        $curlopt_post   =   1;                      // POST
    }
    else {
        $curlopt_post   =   0;                      // GET
    }
    
    $curlopt_postfields =   $request_uri_query;                         // InvNo=225100323652&action=processInvoiceSubmit
    $curlopt_useragent  =   "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)";

    // 선처리 Referer
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["TNT(국제)"]) {
        $curlopt_referer    =   "http://www.tnt.com/express/ko_kr/site/home/applications/tracking.html?%23=undefined&cons=" . $invoice_no . "&searchType=CON";
    }
    else {
        $curlopt_referer    =   $curlopt_url;    
    }

    // $curlopt_cookiejar  =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";
    // $curlopt_cookiefile =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";            
    $curlopt_cookiejar  =   $cookie_file;
    $curlopt_cookiefile =   $cookie_file;
    
    // /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) {
        echo "<br />curlopt_url : " . $curlopt_url;
        echo "<br />curlopt_post : " . $curlopt_post;
        echo "<br />curlopt_postfields : " . $curlopt_postfields;
        echo "<br />curlopt_referer : " . $curlopt_referer;
        echo "<br />curlopt_cookiejar : " . $curlopt_cookiejar;
        echo "<br />curlopt_cookiefile : " . $curlopt_cookiefile;
        exit;
    }      
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
    $pre_result =   curl_exec($curlsession);
    
    // /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) {
        echo "pre_result: <xmp>" . $pre_result . "</xmp>";
        // echo $pre_result;
        // echo $pre_result;
        exit;
    }
    // */
            
    sleep(3);
            
    // 택배사 배송조회 선처리 (끝)
    ////////////////////////////////////////////////////////////////////////////////



?>