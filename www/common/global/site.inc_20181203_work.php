<?php

////////////////////////////////////////////////////////////////////////////////
// 배송조회

// 택배사별 배송조회 결과를 구함
function get_deliverytracking_result($deliverytype, $invoice_no) {
    global $PATH_VAR;
    global $COMMON_DELIVERYTYPE_ARRAY;
    global $COMMON_DELIVERYURL_ARRAY;
    global $COMMON_DELIVERYURL_PRE_ARRAY;
    global $COMMON_DELIVERYMETHOD_ARRAY;
    global $ENCODING_TYPE_ARRAY;
    
    
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
   
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 택배사 배송조회 선처리 (시작)
    
    switch ($deliverytype) {
        // (알파벳순)
            
        case $COMMON_DELIVERYTYPE_ARRAY["쿠팡로켓배송"]:
        case $COMMON_DELIVERYTYPE_ARRAY["CU편의점택배"]:
        case $COMMON_DELIVERYTYPE_ARRAY["CU편의점PICK-UP"]:

        case $COMMON_DELIVERYTYPE_ARRAY["현대택배"]: 
        case $COMMON_DELIVERYTYPE_ARRAY["현대로지스틱스국제특송(국제)"]: 
        case $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]: 
        case $COMMON_DELIVERYTYPE_ARRAY["PHLPOST필리핀국제우편(국제)"]: 

        case $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점택배(GS25)"]: 
        case $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점PICK-UP(GS25)"]: 
        case $COMMON_DELIVERYTYPE_ARRAY["TNT(국제)"]: 
        
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
                // /home/personal/inquiry/track?InvNo=305854318232&action=processInvoiceSubmit
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
            
            /*
            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) {
                echo "<br />curlopt_url : " . $curlopt_url;
                echo "<br />curlopt_post : " . $curlopt_post;
                echo "<br />curlopt_postfields : " . $curlopt_postfields;
                echo "<br />curlopt_referer : " . $curlopt_referer;
                echo "<br />curlopt_cookiejar : " . $curlopt_cookiejar;
                echo "<br />curlopt_cookiefile : " . $curlopt_cookiefile;
                exit;
            }      
            */

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
            
            /*
            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) {
                echo "pre_result: <xmp>" . $pre_result . "</xmp>";
                // echo $pre_result;
                exit;
            }
            */
            

            ////////////////////////////////////////////////////////////////////////////////
            // 선처리시 몇초간 기다려야 조회됨

            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["CU편의점택배"]) {
                sleep(1);
            } 

            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["CU편의점PICK-UP"]) {
                sleep(1);
            } 

            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["현대택배"]) {
                sleep(3);
            } 

            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) {
                sleep(3);
            }   

            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점택배(GS25)"]) {
                sleep(1);
            }   

            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점PICK-UP(GS25)"]) {
                sleep(1);
            }   

            // 선처리시 몇초간 기다려야 조회됨
            ////////////////////////////////////////////////////////////////////////////////
            
        
            break;
        
        default:
            break;
    }



    ////////////////////////////////////////////////////////////
    // [[선처리]] cURL 동작이 안되는 택배사 fsockopen 으로 처리

    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) {

//        if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
//            $string = $COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] . " " . $request_protocol . "://" . $request_host . $request_uri_file . " HTTP/1.0\r\n";
//
//            $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);    // 예) fbe9c26702    
//            $string .= "Content-type: multipart/form-data, boundary=" . $boundary . "\r\n";
//
//            // 본문 생성
//            $post_data_array    =   explode("?", $request_uri);                     // 예) /Delivery_html/inquiry/result_waybill.jsp?wbl_num=406535669400
//            $post_data2_array   =   explode("&", $post_data_array[1]);              // 예) wbl_num=406535669400
//            
//            $post_data2_count   =   count($post_data2_array);
//            
//            $data = "";
//            for ($i = 0; $i < $post_data2_count; $i++) {             
//                $post_data3_array   =   explode("=", $post_data2_array[$i]);   
//                
//                $data .= "--" . $boundary . "\r\n";
//                $data .= "Content-Disposition: form-data; name=\"" . $post_data3_array[0] . "\"\r\n";   // wbl_num
//                $data .= "\r\n" . $post_data3_array[1] . "\r\n";                                        // 406535669400
//                $data .="--" . $boundary . "\r\n";
//            }
//
//            $string .= "Content-length: " . strlen($data) . "\r\n";
//
//            $string .= "Cache-Control: max-age=0\r\n";
//            $string .= "Origin: https://www.lotteglogis.com\r\n";
//            $string .= "Upgrade-Insecure-Requests: 1\r\n";
//            $string .= "Content-Type: application/x-www-form-urlencoded\r\n";
//            $string .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36\r\n";
//            $string .= "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8\r\n";
//            $string .= "Referer: https://www.lotteglogis.com/home/personal/inquiry/track\r\n";
//            $string .= "Accept-Encoding: gzip, deflate, br\r\n";
//            $string .= "Accept-Language: en-US,en;q=0.9,ko;q=0.8,la;q=0.7\r\n";
//            $string .= "Cookie: JSESSIONID=872BEE865A2F3C3A85AEDE9306C6E89E\r\n";
//
//            // $string .= "Connection: Close\r\n\r\n";
//            $string .= "Connection: Keep-Alive\r\n\r\n";
//            
//            $string .= $data;                               // POST 데이터 뒷부분 추가
//
//            // echo "<xmp>string: " . $string . "</xmp>";
//
//        }
//        else {                                              // GET
            // $string = $COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] . " " . $request_uri . " HTTP/1.1\r\n";                   // 예) GET /trace.RetrieveDomRigiTraceList.comm?sid1=6025015340963&displayHeader=N HTTP/1.0    
            $string = "GET" . " " . $request_uri . " HTTP/1.0\r\n";
            $string .= "Host: " . $request_host . "\r\n"; 

            // $string = "";
            // $string .= "POST https://www.lotteglogis.com/home/personal/inquiry/track HTTP/1.1\r\n";
            // $string .= "Host: www.lotteglogis.com\r\n";
            // $string .= "Connection: keep-alive\r\n";
            // $string .= "Content-Length: 46\r\n";

            $string .= "Content-Length: 46\r\n";
            $string .= "Cache-Control: max-age=0\r\n";
            $string .= "Origin: https://www.lotteglogis.com\r\n";
            $string .= "Upgrade-Insecure-Requests: 1\r\n";
            $string .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $string .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36\r\n";
            $string .= "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8\r\n";
            $string .= "Referer: https://www.lotteglogis.com/home/personal/inquiry/track\r\n";
            $string .= "Accept-Encoding: gzip, deflate, br\r\n";
            $string .= "Accept-Language: en-US,en;q=0.9,ko;q=0.8,la;q=0.7\r\n";
            $string .= "Cookie: JSESSIONID=872BEE865A2F3C3A85AEDE9306C6E89E\r\n";
            // $string .= "";
            $string .= "InvNo=305854318232&action=processInvoiceSubmit\r\n";

            $string .= "Connection: Close\r\n\r\n";

            // echo "<xmp>string: " . $string . "</xmp>";
//        }

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

        $pre_result = $data;
    }

    /*
    echo "fsockopen_hostname: " . $fsockopen_hostname . "<br />";
    echo "fsockopen_port: " . $fsockopen_port . "<br />";
    echo "fsockopen_hostname: " . $fsockopen_hostname . "<br />";
    */

    echo "<xmp>" . $pre_result . "</xmp>"; exit;
    // sleep(3);


    // [[선처리]] cURL 동작이 안되는 택배사 fsockopen 으로 처리
    ////////////////////////////////////////////////////////////


    
    // 택배사 배송조회 선처리 (끝)
    ////////////////////////////////////////////////////////////////////////////////
    
    
    
    // 택배사 배송조회 페이지를 읽음 (예 : https://www.doortodoor.co.kr/main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=690052355203)
    $delivery_search_url = $COMMON_DELIVERYURL_ARRAY[$deliverytype];
    
    $temp_url_array     =   explode("://", $delivery_search_url);
    $temp_url2_array    =   explode("/", $temp_url_array[1]);
    
    $request_protocol   =   $temp_url_array[0];                                 // http, https        
    $request_host       =   $temp_url2_array[0];                                // www.doortodoor.co.kr
    $request_uri        =   str_replace($request_host, "", $temp_url_array[1]); // /main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    
    

    ////////////////////////////////////////////////////////////////////////////////
    // 운송장번호 부분 포맷 변경
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["CU편의점PICK-UP"]) {          // 예) 798-103-2942
        $invoice_no = get_deliverytype_invoice_no_format($invoice_no, $deliverytype);
        // echo "<br />invoice_no : " . $invoice_no; exit;
    }
    // 운송장번호 부분 포맷 변경
    ////////////////////////////////////////////////////////////////////////////////



    $request_uri        =   str_replace("{invoice_no}", urlencode($invoice_no), $request_uri);
    
    // [쿠팡로켓배송] 배송조회 선처리 부분 대체 : {query_string} => item_unique_code=&member_code=coupang&member_name=%25ec%25bf%25a0%25ed%258c%25a1&is_mobile=N&root_path=http%253a%252f%252fb2c.goodsflow.com%253a80%252fsmall%252fCoupang&top_bar_visible=Y&data_type=xml&tracking_data=goodsFLOWWh...
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["쿠팡로켓배송"]) {
        // echo "<br />request_uri : " . $request_uri; exit;
        /*
        <form id="PostForm" name="PostForm" action="TrackingList/Old2.aspx" method="POST">
        <input type="hidden" name="item_unique_code" value="">
        <input type="hidden" name="member_code" value="coupang">
        <input type="hidden" name="member_name" value="%ec%bf%a0%ed%8c%a1">
        <input type="hidden" name="is_mobile" value="N">
        <input type="hidden" name="root_path" value="http%3a%2f%2fb2c.goodsflow.com%3a80%2fsmall%2fCoupang">
        <input type="hidden" name="top_bar_visible" value="Y">
        <input type="hidden" name="data_type" value="xml">
        <input type="hidden" name="tracking_data" value="goodsFLOWWherisEnc%24%24buwgndDa9VSMMTPksRm%2bPBITEecFx4HXkRQmAJmBnpINzdCGQGMw1uEDYhxxNDDOyF1WaFDBmHbHNJP3LY2hrlJClrQZRMTMkpvMr84SJtRbBzpfrGccGU3S8tzcrpCkAapWIe7fi43rvUx8eSMAB1ABs43DejozyXGed19%2fwGZMdc0TrsAxKycyjTX%2bDZUcOIy62BTr%2b9qHHl03oMb%2bShukPNjjVi2IpzUH46jsKjuQH3CrIMgZTDUsyM48vQfgjt%2bbMy40BA3Q8sMoY1Y6qULiT6Z1Cwvpnp1fhMmnpIxpzP6RwS8bUecuLzWXLus5b4xaERnLcWr9ZA6RX0OHnuMlV7NY3ZEt6JLbI0lmYnOoqkY4ZSz3VX3V5%2bs5IWcZA1HAshcr9fw3MPOw1PQizHsUBc%2fdsjAU%2b6V9ux1hgGb%2bvdjtO4OqD6I9E8CBzzbPDbLnTsNYS5Rb5HAeU90B4CRPLOanXFW93z93AFKPKSj7an%2fdtvk7Hv6uMBvNWoBdZtwfFrPgYu0QJoNMGfvQGMvPe1NNg3gQKgZYp751V2CTLPacGkLN2Zyc1XdkxbllKm8M%2fv6y1149sOmnImYSCUvALgy%2bZvrc9%2f28P%2foS%2fgRCRwPdHKY%2fT88pcj6vY8I%2b14dpGclEeLIrnUeksWuz%2fzu4oX9OyeQjtjakmlhU0JDf3%2fMOwdqSJIASa5u1LaNCn3Vqsn7X3zXJcHZynKrBJ5p64aYImz4byuAEgYm3Ut6QY4x1pKdSLJLRF57T0d6A5YRXudlTdKmnX5r9s9leQuI5PbBd44gVpN8Egexz15r4lxOW7ov7fNcK%2fGTUdTZ3EFb8zf6EQC96EIyMr9QAS0qsA6AohfwYWNjxMEbRt%2bsM87JaQO7Lf72J2b55K0Vn%2f0lwhF0x7Wjx1jyC4l%2bzlNoWxs1LHcyI6j6vwElQiU4PCSJ6KcAWa2akRGDoOXkFE5mC1HF4RtKYNCR8AGJi82UwL9cly6fCqpJgDfee3xeGny2bIGZFwfo8lWUBQyHSSlKNYXRZoqSJqzp7N4SkEG98jTn24iRfm7rEIdafd7KOK3RGV2zPuGsHPX7MI4Ug0lsr1nwiF31PG40tP6CAfsx%2bs11Lzug6Hejuyk6YS3SgGd0KBGiXbLSKsC5QnosivNw9fhcJIV8cy2c%2b%2bUv8nE%2blYrx%2f7bTLetDAjG8xrPujw3SSGU2Jxy%2b41dxTM3uKpsxsvHoyWhZX2MAra4kNT5cWsLWwBiPWc9mT2fuvAKwM1UXLK6BklWuYu876Z83%2b85gc3JODz7hQXhNoQhfa4gfPGYKwYh%2f5z8gciAk%2fJLNMjnd5Ntm0pNwlvxJMoP7pMwp%2fViTRSc2ygasqlReVQ%2bTIFfDBMj2GGyE0a8nOBeqeTkuSEmcfgKG%2fSNZuwPoWJf560h8kFEMbiKP15WlAmvjHG5cuRzZgPmZbD5gVexXmr8sw8VXTcVVLa1dwl7D02Vkywe3ig4eQzub8%2bMxH4gJlIP19dSm388MHCMFDx2kjwD6Mq%2bHGkwgPd1e0PSvQK7sX8IQmTmsraJig9lJS3ihXzU8IBEfz36AhSdOtNeFjHAXJlDo0R2uq8Ki6wxl%2bANxDf3fOYwF6FL2QZGRVRuEJr9UB%2fVMhcQRSIs22KvNXlDFJGv5e3bER%2flQ7pnTnzvPWEedZ%2ba0zWghO7C8y07mUd%2fn%2bCAK9AF2BPou04F7ozmlWrVTXUBXXb8nbNp%2fJ68hGNY9WD2wcHVCoRefqdeQBcFQ3rsvpX4%2bTM%2bBu%2bpppLwjppo1%2f5xh3rNKWDBWkxurgvs5QY0DNXvLhlhopFxHa0ubhBEl3DyY87cGA0ZrqRnOfE9lhHXeDDwQ2bststb7GGPsn70YwmfImGv6CPgHp2htn52rZikjiCGDLjXNFoMZMLAZZ%2fkFQ7KzeDZTmJPh3xAxLasTr01VzrSoKinfv%2bNenrIIZwR%2fe9iWhq89tmnsg0r2cYqEbKKfCLFomd1vB5%2f9N1tqiMnXpU0kjN4Tzh6Ugrt%2f20qHGseV5mUCI4YuiWITUkdCYd0Ga24rSe7%2bHdaCXatlCSXb9mmWio7DctENYRVk1cXIh966J69ytxnXzN%2b5UgC7BTuWoi9Nmt1p4yV1v1WvQdb0zi39aDgYB8zHeTtYJCoDmaYSjbc%2bdcidJ%2bwiTcwnGIWMgxJzxf9RqqqHqOuoW2IHmekKbLaWRjKS28rghnLt4uto0w%2b3KP4Uh%2byKBIK6iiL3QNMs3n9s2Hp3GPAuTXwW9E%2bCohnJpx%2fK8oCnA3mA3UMf3wZ3%2fzOpAemnSmEZrxmcsAWzY9dQ9ucss19HlZ5%2b9hs%2bs6nVe01Xmz2pq6F7p98iYa0GNf1hBypsFIzB%2fDdQfKJ6DX6SeUoy3fkIBzqpf06prJ8GYbhou2Lo2NAin%2bLvID0PEuPqLv909RWiRmVopnRK26x6T9okE%2fpxsXfCwNj4a7BDT48uBSn8kd%2bmuAm288gGQ1kDIqIzWI9D27QPGGl9%2fwuvVJjnvdh6nC%2f1%2bcb1ysravZHAw4nqjJ7%2f5%2fmejmy%2fDEPu2w8PtP2QyvF4X%2fsP%2bLpZPNIbSecw27uYpEgCKhtG%2brImc1hoSEn9lxD03zUlhdb9ujj7viSqcfuRXEn7SzifMbCuDUHdzE071%2fpg0%2b1MfPMYHgNLPR1X519GElc3hjDgzYoqYjOS5ECfOCBTqQ%2bfvg6Edeh2tSh64sc8X7%2bwuAiQUe%2f2nX9rEIdLTV5i8ILhrqPuB2ooyOWx4mANUoYx9sc%2bBjH8VC5zk%2fkC2VHyPq0vJGVJsjrhAGN41ouchP7vJN45KWRVYCFgzOXNSjpGOhSKc%2bUaptm9J5xRAHoIyS7m8MoQDZuCX4krMdLVhtOUM6a8H91G%2b17xAZ23l72aGtORWQRaSwtUj%2bkJTt1aDE67yUA0PKRos1kZC2Haw9%2fkqj1m%2fQ62Pu%2fdC0s%2fuFd1uvmDuRdcwOOm4sqwtHRArt8aSSq8qq3sp87Hk6n6xnGixotyCgoOrqVhd9MKpKcub5i4F4%2fTas01GHzg9NKnwngd%2bLjk631ntm1Dl8Pe8HrnDul%2bUNSfo9gegJJx9qImuVNPTnnqqi7v19XuP4S9ehvEqDTi2Zyb1K%2bemPZFt1Vwqfdwfb5yd3SJsJUt%2bAF4p2bEU%2bcQfKZ1qk02cTgeSDt%2bAIXj4X%2fLm0A%2bbq0SdsTpBTIjpidPb3wruUAsS9i4LYm7iJfwpPSz%2bVIKN%2fIBpbKATbV%2bQKQ%2fDGTSDmkGYU3kZxBlQpMeDR18m08lkXV7CmtHinzUUdUFhYH9p%2fubXbucn39RtnJS9amSmUQKS8wSL9I8K7Gt5fIQaKVKnE4jty2xcFbIq%2f5st2JmS27KeEqQCFS1vSYkM4vj92Z1%2b%2bu7tC6Nwul%2fbRH2trST6Yp72i0THSYqSMyKa4IJYeburmwz2mpYVuGK1HqI5xjG8072ZyPwfAdOp117QHoB%2fgBQE81jFmJZQsYfSzO9KYlStcCg12CAZH8S1jIIbVL9fGjQZYz7n34e0yS%2fCqpi6fIha7KjnHyTef2739qjulLLzTRuPKh2Y1RJKOyexGluPH%2buWN%2fuSnANLml%2fZ%2fzzhvrYRZf0ZmTu7biPZPYE9yqyg68zgggKXpKq8OMJj14kkKij19fhr0eaHsgVNlJKB0ckDyIYDgV7%2fI0o21zcUHtonFl3zebbfPndTzDcn8LKuYWfbm8Rx5pItnZ9c02J3IEmXNbTsxqrExMQ6di%2fAsRl8uKbhDvtXkRv4ZPw5AZrTRV6bJWiZTRSyaCw1Dm99%2fhbSKGsF9Ya0ufBbFugOIFyK32xxA6UJs5YDqhHLEXQXHvc7mFnEdPYt2OK8Xkw%2fM8M2pwL5Pg2%2beKmmv0bT8gZ4KB%2fTrEbuhfcAMiWp1dsdVQdri6u0ylC6Nt3hrWmgjObES700i4OsShtoHzuZ7CkMdCY%2f7A8ChUxkN1AZe%2fdxxBjjPkKTn%2fiD119hXDIKwcjuFETLRqY1%2b4qaIYrrNhW16yJhNu%2bc2iWNrJYl01WiFNZ7QCbbabU2pMX4lpTqpVgXFGtnZ7xaSQKfWLK8wx1vHDflJEqyCY3Kyd6QASV12i23Cy%2fZp0pg8IjxpeDTjPG0Y%2bBbPE%2bCAgfTa%2bibuVn5Qm52E%2b27wtuchqxsJGeLxsiFtWu7hbZ1xEryf8f9YUYcusG0zh9E%2f6URaD%2bQxxHFbB%2fDPhBJALfj2uk39jMg3viIBxI7s6fYeP%2bAfWDQOsTrbpnBXeMs%2fdQD5w2wCJTaNorss8SSvqPQP9062it5zOxD%2fSDK9%2bYvRNEHZHFVi3NI8c8EUet9kJNIRNwCd%2f2t0a7noFVn6SpSA6JQ5oZ7SA0mYBoFYbAuq%2fDAKp7gPa%2f%2fU10Y5SJQylK2EHxkHWiW73HpeeSdEUDditfp3j7LvFYuqBQuUN9cKkH%2fm470JpjmJDwPl0reV8H%2fdCkZQlh7oFTs2HHZn5wTbXn0SaTTv1h762wGFel%2bjE6BMFYzwzN3O0Y5DDgTmpUrkiFPwZHj%2bMzEz6YrKG2QfizFYxZQdGl%2bHufO02Fii7WyR3qIpUyNJ3P0i1cx3o4G0v987d6aWPKZxJl07WPDevSV2ggbwAcceVrm9C%2btHAAAAoHnWwJhCSChaP4twNsnIA8yKp9%2femfNF7t6%2bkzGmcBw1kDkEBpNoWVXVyF15fjS06PkkYxew8Fpux6P1R9Hfy1vsp9Xo8w2AFwZmQePKwO9OgWxvMxUYbbhzVqZ%2fkg1OQjjJ%2bAZ%2b%2fL4cTQQhf25Vl%2fQ5HNN3Rh5BsyvVFwloGrJmPTPVIMqivKnk1n4oBJ9pPa0gdfZgodnnEN%2f5hZ9CVWDa7BJGajHKl9c%2bM4G6J6GjvOpVbTSGhVo2A6uR5uRBEITTWgGnCNE%2bWqljKS4FJ2WEJjAkVlFgf45fOFptYMhif9viMG98aGke55ck6dIrOQGkPn%2bZ4yCWCjgPLd1WfBOUYRUomMVlIoue2dkYov4VH5srEGj7jp9fXTNjJaAxJocJ%2bWrStGMKqOaa2o4PCaT8pU1DMqLawA8bHfoXcvYgPj7uKHHlF6hS3cjx7C91Rr4tkZeR6pnONPO7fN%2bm0OJftUE7ypg2CNMGm8vQNqaC6ca9k4wkTlpN7yRqyjTK0Afl6zaDQK28OgXCyQOSa1UK5fWeSJU%2fh2W3lOcRjb1EeydhYXlf0KPegSEu9Xl7uzk7WXUV0AUCDJoeP09d9XZE%2bK6vsV5opJ6R5mqDKIiiWmoFGqw4gPFCGHFwUVSclqrnwrCsZjWrkQ1P6OUaTJMpu%2f6mUlGk%2bYRrVlD4K0ziQR3yXbVrWaSrkBYXotVsukqJ3odwHO1bqI1o8VWd1TgOyFsqvHOwvErD%2f2VtO2fNhi8RJLqWrfoi1eEVa8OKveGEpfLFgQumu9HxB%2bphJAFFUVyLf%2bQehgTIKyMfjAk7ZJuytLTKai3GNRQ6yld2jrbxyNV%2fJldpdWTIxPSvIW%2b0ueycc56UU%2fUlfbkKgsFCuYhTHQUGoE7iCNjp4DzBKfUkbRDTOP%2bBner87bw%2bxsgtyHf4i%2f0RmoXxt%2bEPeUP5PhR6PuBkHkykI6upF3gRwGGFL3YNSHRdZzpSfqQjoqCEShd47UiAyKaQmNgeSIUhi8PKB3u4OwWkLOzPHW8WMBSNevA%2fdLhQQeYQKcf8QQ6K7YyNCMI26gBYswnEDjjYShbWSRC4AQ0iH5ubpUceCz1vQVy6FQ8JEoe7d%2fj%2bDl3l8CR55bOz94mxblHPTWWhZYqhhX1BMTlLN0NIgwzN6ingnINeITAFbE5I0xP6S8Tgxu3J9a7vAfJDBjeJnuMLQScmtc%2fkvFPGggG0PhwGlrIFNnMzWT1XBaSjs1JPF5Os6IGoid9lkMkZ0s%2fh%2b3bWoWmxXpJQiDfeltg9wqFhZfWkSX6Yi6vrvRNFYmMwAMvjudV%2f3ko41rYo%2bdGAVr4gGJVql1byY6PGJPhAViddFuKAisXotlCgdeq%2fJVybIoROH8h5QTL8zIBGnRUSprHnYTBGxMnoh8vAeUSONpSbHiIIkC7Gt5%2bMhk3ArEJGZRB42oKvVtDT6pVBmrtpyuUm1tdpjgexpjHGviqVbCRicem5juuvd3dOio8e%2fcR2GDYx2hdx6e8DArtTf1bDBEzRw5n57cFyS4fRmpQ4NoAVvlojjZKKmCf3jSPB9AIsQgK5M1qpynT%2fAJBpjfeyNw9kbxd%2behSGu4NRA6wsU%2fGLfJvAO322OXYBjTqiGxf7iUrwF4i2gPx7Tt1p5khPS08%2bsSmafS9xyQrDVRcWOApoIIiTQ1FJvRBu1B4BOW0f7DzU5DIgNSRPU8bZuotYLbw9mOAqSu3k38HrPELn5qji5H3NWDv5TGLAL14g2AacMCbZKnwktMqiZkKGmtaB7yzFjB6KgaU1vif8XD8EKn4YB%2fGjtvXibE9IG0%2fEIOMc%2b%2fUDjgq4nuKIo4gQDEutoPrW85ctUqMc9VHHQykeRDl7zb7SSIrnYwBQsZ8AddJc2WVFC5NzKJKSWhQZcJfu8WBQcg00DmTk2%2b2e9IvueMVIKynb8W7IJGE92QKsE9eS1hUruTMm41jBzWNvctIPnybwTAT6BUCXybZNQ399pic3xv7xNBXXjoNB2n9QL5VrhduJhSb%2bI4JGyKNQ8iav27y0JEy%2fTXXyfpJR0YJ0hNw4ccsQNhzb4UHo%2fugR3IpSegpAF5cEtcF3QoLDhs7KFS6bjADnNrzAKDEj1e9TJZu%2fM0bBo5W6N4NmSAYr7X3gxW48YtwjUorZ38SpoteTOL9WWWs1DDhx91yCAnSXC5kcxuAeMSg8YU%2bOczM2%2fmqRGSUBT5JIgjFuHhj74hz8zsN5H4uT9i2urAe63%2bWWwJXjw0QmE%2bLjS1MPMlMy%2fDLp%2fYhvW5MwopXTHW4Ewg8Czjk1VWqc%2bPfgbH7xu2caD95sXXnl0ZUIo14%2fVwk3Dmng4hIr7amLaGQ7NjwOgBTFPOVNZjiJs3x5oi7ThcyAWsvEfwjeGogjHklZpAxT0qwpVBexCS3ij6TEOd2XH0SLyh9B7fA9nb5rjPz7ADsOnYFXc6B3PQkrpXn2mlAmifqKUaugGEF0tepvGye66R0Ot15Kv070HxSw%2bSq93ezfHBoyeNy%2fElr%2bjpQHWkAmRt3kaecw%2bGrNBDqS%2fwUPsX803MhWUrJLmYlKfnRlNFnCxmCJf4Q9xeqICQj%2fZ1KuS4AHwKHDJlglJ8sRIAsc9c99h3ffjRPmek1sH9dtxSF6EEYC97UgZY%2bGp%2fYLqR4voxpMmkucgZlOrcO6SRsv7i%2brYrjAzhJeCZwWh0iiil6f7XojllPG8XygkUYKEy831gkX6%2b01cd7V%2fEJsXsQJUc0p8KQHNRT9sFw03pmFRlxclleQznsK%2b1CovKYz2wCq9A7HBF42qKec%2fgQnswSf1gOr0Up2xxV0TD0Xr53uXUHF2g4LI7Ni16P1m03NpdvSN4Mpc80KOGGnqqFu%2fhSCWaDsISqL%2bwpzOyfR4nbD2GOnNiKPwFmbGKmxuCRyAB5r6IYr3tsFbDVaD7n%2bpLckoNOPARvN%2fccxtn%2b7o34J71xAUw3OQ%2fKNzHLcFGPf3V6sp8uOZ8XHu62mM4NsKl63O2rTdZGa%2fk7QwCo684ZA3%2fqKyQpSEK5gf6XhTYBtG3%2bIa%2bIr0bu44YSe5pWnO5By674Ulg8hEmtz0gTp5zFKXJTvSHO6xGKN5QCGG7tL6agV%2bzIVjHPJhdyjYZ4iUcN3mZmJLtu2uABr0hpJoXafPflVwzCgpCsz%2bFO82Bv%2bgb9kP%2fyO1am6kkCoSlLVsEmNie8cjq9hGUOrqb05v1MZRCV2YfGblsjFzELBGb3H0b5o2w9AduwIZFSB1cjjL6at6gfTFqB%2bwGBwgO%2bO%2fjAhom%2fJPZyy7XUv8yQJViKkZbFeQkA8js1Q96xY%2frO8K5y1GMng8SVbsltLfeczwuKIGx%2fcEVrvGGb7PRopaRbknJrxFoSiUtOrMazniKvFymPwT3pwQmPrpkMsvbPOqOKjfnsHzwP%2bdebEOc80%2fBkObPWYXeb7C1eBYkPYmyGMX%2bfPWNrEDXvMFINKAhxeK9xl1CvpcFp5uWgpwsNs%2fhmx2W7LumYehxTeEP42PlwZLDRkvQlKbAbMG0C6OtZkvYdlcqUORau7vWECEUMmvJ7pi2g2CkFh2DKpTkD1K%2bNuRdId64k2sLMdzNWlKpdpKVrbcOqE8YM2vDilQFsGLBpVSBwDHbH2sDPbY12UvP2LXWBSZg7xCbd9fvoObUHWA1fn07Fc64eFEl0xHMOwKUHVxnekLIc9G12yF1dijSuMfWlXnI99ewq7DyzmGjXbFdpXoJZiBrFTMEBDXBhe0IbsmJm%2fKx53sTsvSz39fK5fsdNCPq0ZlkuSHoRPqF2UmJVBwXpvmByN9bN19Jl%2f3cmPK%2fdA5BhMj6D0DRbN1VR0TEkC7fPJNR6Noy14Vx02yeQr20g3iuh90HARNv1iBnlkBjXmuI5qk5c%2bhNenGFi77O9y6hgS3SjpvgqqC6uzJVRUriW9C2%2bbidnpn7068d1ivVHMWDUBAJxnzL3krlIfiK5c0hal4P4q7rNicjgUzx8TI%2bjXDYTyC4zOGMZJxAiRC%2fX%2bIWBaE677fF%2bBUA88Bx8aCcE8yN697S2tSoM%2fYtiikl01g90x5w6A%2b3bMVO56L3F3pwCNE51HiTch7jnwbe7v1cjIDSoEJ%2b2Xg3f%2f%2bR4NVeYARo6%2fNeOVal12vvxvaxcE%2fjOtexJaOEtlZbhVXjRk8j6l9na3bFbYREyrS817huZMJCAJW18jpT70wVr25tY62BMNdzDMKblHjnaQkypicY5vahTIkgBFTe8gX%2fkaMZCXJKNzv0Bvt3CPERoZd2qtOKnEibpdXnZmwkrrgB1cXmwNwmW5tCrnyT2xYSoJRc43cfofRr5c0B76vhimLFEaTO5UXkPYPG9qKzv0lYat%2b23Q4D1x19rGCjDsG8TwLAD%2bfgSmIcYHXdPpoXgYEzI0Z0jUiXqAssqp8%2bICXtiNJC7Vc2GQ6TYc9fi%2bjCHwZp6TtBH3ZXp1ye4UAOC3vF2v37QcfrGUIlRKuCEpoXdBNb89T%2bCkmna4x0Ck%2b6NAnn97ewoIy5ui8ceO2oEPxKG5o2wYsi0KoK8KLU1NOSuNLAbY6LrWc1XE%2fDxhPsWk5J2e07WWZ4RfsUCu52b2fBTfDiTlxKy5KBhzuPn3UoomQtSKNcDhQfIAKfDWKCzMX7A7wwMNDfHRS1uP%2fM6VWWDf7QDnm3iaye%2f1tE0sZBpJbBL2%2fT8jTlU%2bdOHYw4h0A%2fACgKJ%2by2SuFns%2fa2oxI44LzP2qa0bHMsE0WNV9di9nbfpWqBfeMTmowWmgyLSuwioZK0e6e53FqD4r%2fitQojzWrJI%2b6jxQ0vONT1v86bmobWh%2fpYEZm583khhKkidAf6QD0tFLZ%2fPSUEdnpMxY6d30Pq3eLcMBKXqS1lb9PEINP%2f9qIBiWSbuT3J4z8p0CdY16YHhZrIoBmRuas%2fF2PfdUs8EO3%2fn1LCBQqt7UzdT37KpONjgs%2b%2fMEO%2fnSMajgqMDUV0OckBTi%2fdK%2bO6zZQ%2bMKqeAfI1OcK4jjgHyRXSuA87xmsLUIH%2b3%2b3NWuvCb4ulx2HyPOr8Ii7jJt175MfJLWcSK9mKUKwSO0%2bAzlNpjak9fee23SQ4LC8aydfF86jYM5G1KLE0ZuH8Bv9behia%2f5SOrZVgflzn%2bboxaL3%2f%2blS9Lqw1kloQSMo%2fcJHANQGvcvFpDmD3dejz4X9a61oTGzaCIGlcIHATsnVRofiwOYG%2bVALBRBRwep4doeyhsQQilS1wPt5wZTJsSC6KAMWll8xp4ffT0jzOM58K2LxlsfM9SZAJTUWeiC9SQl3Bkv%2bQ%2fsJM5FB9Okc4uLD6lP2%2fx8EFTd2Z2zwrzGr53q9KP%2f1G%2f0bfrSMHIw6uTWL1jMUOULr6s1pjtGk4aPPf4geBv8HA%2fleUTe8JDYbBeOxPKlKugdVaYsgASN9InsMHCU1XDfPgwURd4OHBWjNsuA0A67DZrostb3a7AOSkVe0lLTmuwJc2jXrSRpX5m4NjG0W5NudVzTToz8T1PRE2tXOpBzyoobV1%2b8yfyXxdqJgDVgYkmsJmCbLUHbOIM7NNsqjk%2fx%2f%2fkU1%2bRS3V1gYQuj%2bGuxW7nMyUjXKJTAN3TMzVbjR%2f%2fjdx4I4vhBdhw1dmRKv3CGGj%2bdVzdCPtegIq4m0nm7fcKNQY8rC7UIA3s3H5RmvqJ22Md%2b1NS6F4lJSxhOz8UrWDuroUrcltOMc7gByV3wWk9XkXahJVXGG1lgMLIMdH5KXdzWhby6AbACyRwVr%2f85hhNZNY%2f3cEgVgwSf62izjB3HDV4XnVw2gAw1C1IV8f9E0TgG5gIA2hY0J3sLX20wtc2okjkkw44slfIzlksuVMVMgNQyoLhRuzf49xsrMt%2bCGTDj0YxwlAcA7j48qqh9F0q5oZuxM6TPMH%2fWYyvdnPUpzIeDGV4VPgUfYDT2vWCpWetVAXRs0JpoZKADug9AQK8GqEGDSpkRnp8u4uGuXk%2fZQgdHikt1kU2vy3Jp8zAn8dqXuQ1tApaIdygNcuSMNg2AzuJebY9aaX%2bbZncN%2fAQz9V0p2wFns38REzhky%2fRD7gOKcZDM%2fEsziHM6fiA3tES%2fIGmxOIzQw0X7WB0dni4qQqnOHwo0iFldPBUs6jaiRVbkyLpKqba2kJZzg6S9x1iwUaqSoGGPR3NpiIXN52CUgoAuzeg%2fGJIG1ULEAtModqvaYBQ0Iw2Cm83LHC%2ftoFL%2fcIkOUHyhrRUHuN9mQosW8w2BA%3d%3d">
        </form>
        <script language="javascript">
        document.PostForm.submit();
        </script>
        */
        
        $POST_NAME_ARRAY = array (
            "item_unique_code",
            "member_code",
            "member_name",
            "is_mobile",
            "root_path",
            "top_bar_visible",
            "data_type",
            "tracking_data"
        );

        $content_temp   =   $pre_result;
        // echo "<xmp>" . $content_temp . "</xmp>"; exit;

        $query_string = "";             // 초기화

        $i = 0;
        foreach ($POST_NAME_ARRAY as $key => $val) {
            $i++;
            $POST_NAME = $val;

            $content_array  =   explode("<input type=\"hidden\" name=\"" . $POST_NAME . "\" value=\"", $content_temp);
            $content_array2 =   explode("\"", $content_array[1]);
            $POST_VALUE     =   trim($content_array2[0]);

            if ($i > 1) {
                $query_string .= "&";    
            }

            $query_string .= $POST_NAME . "=" . $POST_VALUE;
        }

        $request_uri    =   str_replace("{query_string}", $query_string, $request_uri);   
        // echo "<xmp>" . $request_uri . "</xmp>"; exit; 
    }

    // [합동택배] 년월 부분 대체 : {search_month} => 201604
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["합동택배"]) {
        $request_uri    =   str_replace("{search_month}", current_yearmonth(), $request_uri);    
    }    

    
    $request_uri_array  =   explode("?", $request_uri);
    $request_uri_file   =   $request_uri_array[0];                              // /main/doortodoor.do       
    $request_uri_query  =   $request_uri_array[1];                              // fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    
    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["DHL(국제)"]) {
        echo "<br />request_uri_file : " . $request_uri_file; // exit;
        echo "<br />request_uri_query : " . $request_uri_query; // exit;
    }
    */
    
    
    $curlopt_url        =   $request_protocol . "://" . $request_host . $request_uri_file;          // https://www.hlc.co.kr/home/personal/inquiry/track
    
    if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
        $curlopt_post   =   1;          // POST
    }
    else {
        $curlopt_post   =   0;          // GET
    }
    
    $curlopt_postfields =   $request_uri_query;                                                     // InvNo=225100323652&action=processInvoiceSubmit\r\n";
    $curlopt_useragent  =   "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)";
       
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["CU편의점택배"]) {
        $curlopt_referer    =   "https://www.cupost.co.kr/postbox/delivery/localResult.cupost";
    } 
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["CU편의점PICK-UP"]) {
        $curlopt_referer    =   "https://www.cupost.co.kr/postbox/delivery/pickupResultNew.cupost";
    } 
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["DHL(국제)"]) {
        $curlopt_referer    =   "http://www.dhl.co.kr/ko/express/tracking.html?brand=DHL&AWB=2416844566" . $invoice_no . "%0D%0A";
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["우체국택배"]) {
        // $curlopt_referer =   "https://service.epost.go.kr/iservice/usr/trace/usrtrc001k01.jsp";
        $curlopt_referer    =   "https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?sid1=" . $invoice_no . "&displayHeader=";
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["FedEx(국제)"]) {
        $curlopt_referer    =   "https://www.fedex.com/apps/fedextrack/?action=track&tracknumbers=" . $invoice_no . "&locale=ko_KR&cntry_code=kr";
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) {
        $curlopt_referer    =   "https://www.lotteglogis.com/home/personal/inquiry/track?InvNo=" . $invoice_no . "&action=processInvoiceSubmit";
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점택배(GS25)"]) {
        $curlopt_referer    =   "http://www.cvsnet.co.kr/postbox/m_delivery/local/local.jsp";
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점PICK-UP(GS25)"]) {
        $curlopt_referer    =   "http://www.cvsnet.co.kr/postbox/m_delivery/pickup/pickup.jsp";
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["TNT(국제)"]) {
        $curlopt_referer    =   "http://www.tnt.com/express/ko_kr/site/home/applications/tracking.html?cons=" . $invoice_no . "&searchType=CON";
    }
    /*
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        $curlopt_referer    =   "https://wwwapps.ups.com/WebTracking/track?loc=ko_KR";
    }
    */
    else {
        $curlopt_referer    =   $curlopt_url;    
    }

    // $curlopt_cookiejar  =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";
    // $curlopt_cookiefile =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";            
    $curlopt_cookiejar  =   $cookie_file;
    $curlopt_cookiefile =   $cookie_file;            
    
    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["현대택배"]) {
        echo "<br />curlopt_postfields : <xmp>" . $curlopt_postfields . "</xmp>";

        echo "<br /><br /><br />";
        echo "<br />curlopt_url : " . $curlopt_url;
        echo "<br />curlopt_post : " . $curlopt_post;
        echo "<br />curlopt_postfields : " . $curlopt_postfields;
        echo "<br />curlopt_referer : " . $curlopt_referer;
        echo "<br />curlopt_cookiejar : " . $curlopt_cookiejar;
        echo "<br />curlopt_cookiefile : " . $curlopt_cookiefile;
        exit;
    }
    */

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
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlsession, CURLOPT_FOLLOWLOCATION, true);                    // 리다이렉트를 자동으로 잡아줘서 302가 아니라 200이 리턴됨
    curl_setopt($curlsession, CURLOPT_MAXREDIRS, 10);                           // 최대 리다이렉트 횟수
    curl_setopt($curlsession, CURLOPT_POST, $curlopt_post);
    curl_setopt($curlsession, CURLOPT_POSTFIELDS, $curlopt_postfields);
    curl_setopt($curlsession, CURLOPT_USERAGENT, $curlopt_useragent);
    curl_setopt($curlsession, CURLOPT_REFERER, $curlopt_referer);
    curl_setopt($curlsession, CURLOPT_COOKIEJAR, $curlopt_cookiejar);
    curl_setopt($curlsession, CURLOPT_COOKIEFILE, $curlopt_cookiefile);
    curl_setopt($curlsession, CURLOPT_TIMEOUT, 10);                             // 타임아웃 시간

    // UPS(국제) 관련해서 설정해 봄
    // curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false);                            
    // curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false);                //to overcome SSL verification

    $result =   curl_exec($curlsession);
    
    // sleep(1);
    
    // Close a cURL session
    curl_close($curlsession);
    

    $data = "";

    // 선처리 데이터를 추가로 앞에 붙여주는 택배사 처리
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["CU편의점택배"]) {
        $data .= $pre_result;
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["CU편의점PICK-UP"]) {
        $data .= $pre_result;
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점택배(GS25)"]) {
        $data .= $pre_result;
    }
    else if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점PICK-UP(GS25)"]) {
        $data .= $pre_result;
    }

    $data .= $result;
    
    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["CU편의점PICK-UP"]) {
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
            ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["DHL(국제)"]) ||
            ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["합동택배"]) ||
            // ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]) ||
            ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["TNT(국제)"]) ||
            ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["ZZZ"]) ) {            // 소스편리하게 처리하기 위해서 의미 없는 항목 넣어놓음
    
        if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
            
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


            if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["쿠팡로켓배송"]) {
                $string .= "Referer: http://b2c.goodsflow.com/small/Coupang/Whereis.aspx\r\n";
                $string .= "Host: b2c.goodsflow.com\r\n";
                $string .= "Cookie: ASPSESSIONIDAARTRSSB=FFLEHKPDMGJLOLDLLDEPPMNI; ASP.NET_SessionId=wvsv53gtxsnt1x1ssmxygehm; ASPSESSIONIDCCQTQQSA=PCDAFCIAHCHFOFICBEPGFBIN; ASPSESSIONIDACRSRQSA=HIBOFODABDHBMILAHNDCONGB\r\n";
            }


            //  if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
            //  
            //      // $string .= "Accept: text/html, application/xhtml+xml, image/jxr, */*\r\n";
            //      // $string .= "Accept-Encoding: gzip, deflate\r\n";
            //      // $string .= "Accept-Language: ko\r\n";
            //      // $string .= "Cache-Control: no-cache\r\n";
            //      // $string .= "Connection: Keep-Alive\r\n";
            //      // $string .= "Content-Length: 2780\r\n";
            //      // $string .= "Content-Type: application/x-www-form-urlencoded\r\n";
            //      $string .= "Cookie: WT_FPC=id=175.208.158.237-521020288.30523347:lv=1465153791965:ss=1465153765881; UPS_SHARED_SESSION=" . $UPS_SHARED_SESSION . "; WT_MIG=ss=1465204182678\r\n";
            //      $string .= "Host: wwwapps.ups.com\r\n";
            //      $string .= "Referer: https://wwwapps.ups.com/WebTracking/track?loc=ko_KR\r\n";
            //      // $string .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko\r\n";
            //  
            //  
            //      // $string .= "Accept: text/html, application/xhtml+xml, image/jxr, */*\r\n";
            //      // $string .= "Referer: https://wwwapps.ups.com/WebTracking/track\r\n";
            //      // $string .= "Accept-Language: ko\r\n";
            //      // $string .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko\r\n";
            //      // $string .= "Content-Type: application/x-www-form-urlencoded\r\n";
            //      // $string .= "Accept-Encoding: gzip, deflate\r\n";
            //      // $string .= "Host: wwwapps.ups.com\r\n";
            //      // // $string .= "Content-Length: 2796\r\n";
            //      // $string .= "DNT: 1\r\n";                
            //      // // $string .= "Connection: Keep-Alive\r\n";
            //      // $string .= "Cache-Control: no-cache\r\n";
            //      // $string .= "Cookie: WT_FPC=id=112.221.253.82-868809984.30522696:lv=1464887137904:ss=1464887001117; defaultHome=kr_ko_home|1464924625248; UPS_SHARED_SESSION=" . $UPS_SHARED_SESSION . "; WT_MIG=ss=1464924677947\r\n";
            //  
            //  }

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
    
    
    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["TNT(국제)"]) {
        echo "<xmp>" . $data . "</xmp>"; exit;
        // echo $data; exit;
    }
    */
    
    
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
    // echo "<xmp>" . $content_temp . "</xmp>"; exit;

    switch ($deliverytype) {
        
        // (알파벳순)
        
        case $COMMON_DELIVERYTYPE_ARRAY["쿠팡로켓배송"]:            
            $result_deliverytracking = get_result_deliverytracking_coupang($content_temp);   
            // echo "<xmp>" . $content_temp . "</xmp>"; exit;         
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["CU편의점택배"]:            
            $result_deliverytracking = get_result_deliverytracking_cupost($content_temp);   
            // echo "<xmp>" . $content_temp . "</xmp>"; exit;         
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["CU편의점PICK-UP"]:            
            $result_deliverytracking = get_result_deliverytracking_cupostpickup($content_temp);   
            // echo "<xmp>" . $content_temp . "</xmp>"; exit;         
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["대운글로벌(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_daewoonsys($content_temp);            
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["DHL(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_dhl($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운"]:            
            $result_deliverytracking = get_result_deliverytracking_doortodoor($content_temp);            
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운NPlus"]:            
            $result_deliverytracking = get_result_deliverytracking_doortodoornplus($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["대신택배"]:            
            $result_deliverytracking = get_result_deliverytracking_ds3211($content_temp); 
            // echo "<xmp>" . $result_deliverytracking . "</xmp>"; exit; 
            break;
        
        case $COMMON_DELIVERYTYPE_ARRAY["EMS국제우편(국제)"]:
            $result_deliverytracking = get_result_deliverytracking_ems($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["우체국택배"]:            
            $result_deliverytracking = get_result_deliverytracking_epost($content_temp);            
            break;            
        
        case $COMMON_DELIVERYTYPE_ARRAY["FedEx(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_fedex($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["GTX로지스"]:            
            $result_deliverytracking = get_result_deliverytracking_gtxlogis($content_temp);            
            break;            
        
        case $COMMON_DELIVERYTYPE_ARRAY["한진택배"]:            
            $result_deliverytracking = get_result_deliverytracking_hanjin($content_temp);            
            break; 
            
        case $COMMON_DELIVERYTYPE_ARRAY["합동택배"]:            
            $result_deliverytracking = get_result_deliverytracking_hdexp($content_temp);            
            break; 
            
        case $COMMON_DELIVERYTYPE_ARRAY["현대택배"]:            
            $result_deliverytracking = get_result_deliverytracking_hlc($content_temp);            
            break;   

        case $COMMON_DELIVERYTYPE_ARRAY["현대로지스틱스국제특송(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_hyundaiexp($content_temp);            
            break;       
            
        case $COMMON_DELIVERYTYPE_ARRAY["드림택배"]:
            $result_deliverytracking = get_result_deliverytracking_idreamlogis($content_temp);            
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["로젠택배"]:            
            $result_deliverytracking = get_result_deliverytracking_ilogen($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["일양로지스"]:            
            $result_deliverytracking = get_result_deliverytracking_ilyanglogis($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["KGB택배"]:            
            $result_deliverytracking = get_result_deliverytracking_kgbps($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["KG로지스"]:
            $result_deliverytracking = get_result_deliverytracking_kglogis($content_temp);            
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["대한통운국제특송(해외->한국)"]:
            $result_deliverytracking = get_result_deliverytracking_korexinbound($content_temp);
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["롯데택배"]:
            $result_deliverytracking = get_result_deliverytracking_lotteglogis($content_temp);
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["PHLPOST필리핀국제우편(국제)"]:
            $result_deliverytracking = get_result_deliverytracking_phlpost($content_temp);
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점택배(GS25)"]:
            $result_deliverytracking = get_result_deliverytracking_postbox($content_temp);
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["포스트박스편의점PICK-UP(GS25)"]:
            $result_deliverytracking = get_result_deliverytracking_postboxpickup($content_temp);
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["TNT(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_tnt($content_temp);            
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_ups($content_temp);            
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["USPS(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_usps($content_temp);            
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["YES24총알배송(당일/하루배송)"]:            
            $result_deliverytracking = get_result_deliverytracking_yes24($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["YANWEN(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_yw56($content_temp);            
            break;

        default:
            // 조회결과 부분
            $result_deliverytracking = $content_temp;
            break;
            
    }    
    
    // echo "<xmp>" . $result_deliverytracking . "</xmp>"; exit;
    
    return $result_deliverytracking;
}


// 배송조회결과에서 조회결과문자 부분만 구함
function get_deliverytracking_resulttext($result_deliverytracking) {

    $resulttext_deliverytracking = trim($result_deliverytracking);

    // <th ... </th> 부분을 없앰
    $resulttext_deliverytracking = preg_replace('/<th(.*)<\/th>/', "", $resulttext_deliverytracking);

    // alt= ... src= 부분을 src= 로 변경
    $resulttext_deliverytracking = preg_replace('/alt=(.*)src=/', "src=", $resulttext_deliverytracking);

    // <img>태그를 제외한 부분을 제거
    $resulttext_deliverytracking = strip_tags($resulttext_deliverytracking, '<img>');

    // html중 text 데이터만 구함
    $resulttext_deliverytracking = get_html_to_text_data($resulttext_deliverytracking);             
    
    /*
    echo "<xmp>" . $result_deliverytracking . "</xmp>"; 
    echo "<br /><br /><br /><br /><br />";
    echo "<xmp>" . $resulttext_deliverytracking . "</xmp>"; 
    exit;
    */   
    
    return $resulttext_deliverytracking;
}


// 배송조회결과에서 배송진행상태를 구함
function get_deliverytracking_deliveryprogress($dt_resulttext) {
    global $db_dt_deliveryprogress_array;
    
    $deliverytracking_deliveryprogress = "-";               // 배송진행상태 초기화
    
    foreach ($db_dt_deliveryprogress_array as $key => $val) {
        $dt_resulttext_array        =   explode($key, $dt_resulttext);
        $dt_resulttext_array_count  =   count($dt_resulttext_array);
           
        if ($dt_resulttext_array_count > 1) {
            $deliverytracking_deliveryprogress  =   $val;
            break;       
        }
    }
    
    return $deliverytracking_deliveryprogress;
}



////////////////////////////////////////////////////////////////////////////////
// 사용자 방문기록

// 사용자ID별 최종방문일시 업데이트
function set_deliverytracking_lastvisittime() {
    global $_COOKIE;

    $dt_userid          =   trim($_COOKIE["cookie_dt_userid"]);
    $dt_lastvisittime   =   current_datetime();

    // 최종방문일시 업데이트
    $query = "update deliverytracking_tb set ";
    $query .= "dt_lastvisittime = '" . $dt_lastvisittime . "' ";
    $query .= "where dt_userid = '" . $dt_userid . "' ";
    // echo "<br />query : " . $query; exit;

    if ($result = db_query($query)) {
        return true;
    }
    else {
        return false;
    }
}



////////////////////////////////////////////////////////////////////////////////
// DB 데이터 정리

// 배송조회 DB파일 정리 (항목수 기준)
function set_deliverytracking_db_auto_delete() {
    global $SITE_VAR;

    // 배송조회(deliverytracking_tb) 항목수를 구한다.
    $query = "select ";
    $query .= "count(*) as deliverytracking_count ";
    $query .= "from deliverytracking_tb ";
    // echo "<br /><br />" . $query; exit;

    $result_count = db_query($query);
    $row_count = db_fetch_array($result_count);

    if ($row_count["deliverytracking_count"] <= $SITE_VAR["deliverytracking_db_save_count"]) {
        return true;
    }

    // 삭제항 항목수 = 배송조회(deliverytracking_tb) 항목수 - 택배사배송조회 DB 저장할 항목수
    $limit_delete_count = $row_count["deliverytracking_count"] - $SITE_VAR["deliverytracking_db_save_count"];
    /*
    echo "<br />deliverytracking_count : " . $row_count["deliverytracking_count"];
    echo "<br />deliverytracking_db_save_count : " . $SITE_VAR["deliverytracking_db_save_count"];
    echo "<br />limit_delete_count : " . $limit_delete_count;
    */

    // 삭제
    $query = "delete from deliverytracking_tb ";
    // $query .= "order by dt_lastvisittime, dt_id ";
    $query .= "order by dt_id ";
    $query .= "limit " . $limit_delete_count;
    // echo "<br />query : " . $query; // exit;

    if ($result = db_query($query)) {

        ////////////////////////////////////////////////////////////////////////////////
        // dt_id 갑을 1부터 다시 설정

        $query = "select ";
        $query .= "dt_id ";
        $query .= "from deliverytracking_tb ";
        $query .= "order by dt_id ";

        $result_reset = db_query($query);

        $dt_id_new = 0;
        while ($row_reset = db_fetch_array($result_reset)) {
            $dt_id_new++;

            $dt_id_old = $row_reset["dt_id"];

            $query_reset = "update deliverytracking_tb set ";
            $query_reset .= "dt_id = '" . $dt_id_new . "' ";
            $query_reset .= "where dt_id = '" . $dt_id_old . "' ";
            $query_reset .= "limit 1 ";

            // echo "<br />query_reset : " . $query_reset; exit;
            db_query($query_reset); 
        }

        // 자동 증가값 초기화
        $query_reset = "alter table deliverytracking_tb ";
        $query_reset .= "auto_increment = " . ($dt_id_new + 1) . " ";

        db_query($query_reset);

        // dt_id 갑을 1부터 다시 설정
        ////////////////////////////////////////////////////////////////////////////////

        return true;
    }
    else {
        return false;
    }
}


// 다중검색 DB파일 정리 (항목수 기준)
function set_multisearch_db_auto_delete() {
    global $SITE_VAR;

    // 다중검색(multisearch_tb) 항목수를 구한다.
    $query = "select ";
    $query .= "count(*) as multisearch_count ";
    $query .= "from multisearch_tb ";
    // echo "<br /><br />" . $query; exit;

    $result_count = db_query($query);
    $row_count = db_fetch_array($result_count);

    if ($row_count["multisearch_count"] <= $SITE_VAR["multisearch_db_save_count"]) {
        return true;
    }

    // 삭제항 항목수 = 다중검색(multisearch_tb) 항목수 - 다중검색 DB 저장할 항목수
    $limit_delete_count = $row_count["multisearch_count"] - $SITE_VAR["multisearch_db_save_count"];
    /*
    echo "<br />multisearch_count : " . $row_count["multisearch_count"];
    echo "<br />multisearch_db_save_count : " . $SITE_VAR["multisearch_db_save_count"];
    echo "<br />limit_delete_count : " . $limit_delete_count;
    */

    // 삭제
    $query = "delete from multisearch_tb ";
    $query .= "order by ms_id ";
    $query .= "limit " . $limit_delete_count;
    // echo "<br />query : " . $query; // exit;

    if ($result = db_query($query)) {

        ////////////////////////////////////////////////////////////////////////////////
        // ms_id 갑을 1부터 다시 설정

        $query = "select ";
        $query .= "ms_id ";
        $query .= "from multisearch_tb ";
        $query .= "order by ms_id ";

        $result_reset = db_query($query);

        $ms_id_new = 0;
        while ($row_reset = db_fetch_array($result_reset)) {
            $ms_id_new++;

            $ms_id_old = $row_reset["ms_id"];

            $query_reset = "update multisearch_tb set ";
            $query_reset .= "ms_id = '" . $ms_id_new . "' ";
            $query_reset .= "where ms_id = '" . $ms_id_old . "' ";
            $query_reset .= "limit 1 ";

            // echo "<br />query_reset : " . $query_reset; exit;
            db_query($query_reset); 
        }

        // 자동 증가값 초기화
        $query_reset = "alter table multisearch_tb ";
        $query_reset .= "auto_increment = " . ($ms_id_new + 1) . " ";

        db_query($query_reset);

        // ms_id 갑을 1부터 다시 설정
        ////////////////////////////////////////////////////////////////////////////////

        return true;
    }
    else {
        return false;
    }
}


////////////////////////////////////////////////////////////////////////////////
// 파일 데이터 정리

// 쿠키파일 정리
function set_cookie_file_auto_delete() {
    global $SITE_VAR;
    global $PATH_VAR;

    // 삭제할 디렉터리 초기화
    $pathname = "";


    // 첫번째 존재하는 데렉터리를 구한다.
    $temp_date  =   date_difference_day(current_date(), -$SITE_VAR["common_file_init_date"]);
    $end_date   =   date_difference_day(current_date(), -$SITE_VAR["cookie_file_save_date"]);

    while ($temp_date <= $end_date) {
        // echo "<br />temp_date : " . $temp_date;

        $temp_path = $PATH_VAR["cookie_path"] . "/" . $temp_date;

        if (is_dir($temp_path)) {       // 디렉터리가 존재한다면
            $pathname = $temp_path;
            break;                      // while ($temp_date <= $end_date) 빠져나감     
        }

        $temp_date = date_difference_day($temp_date, 1);    // 1일 뒤 날짜
    }


    // 디렉터리 존재한다면
    if ($pathname != "") {
        // echo "<br />디렉터리 삭제 pathname : " . $pathname;
        remove_derctory($pathname);     // 디렉터리 삭제 (하위 파일 포함)
    }
}


// 택배사배송조회 수집파일 정리
function set_deliverytracking_file_auto_delete() {
    global $SITE_VAR;
    global $PATH_VAR;

    // 삭제할 디렉터리 초기화
    $pathname = "";


    // 첫번째 존재하는 데렉터리를 구한다.
    $temp_date  =   date_difference_day(current_date(), -$SITE_VAR["common_file_init_date"]);
    $end_date   =   date_difference_day(current_date(), -$SITE_VAR["deliverytracking_file_save_date"]);

    while ($temp_date <= $end_date) {
        // echo "<br />temp_date : " . $temp_date;

        $temp_path = $PATH_VAR["deliverytracking_path"] . "/" . $temp_date;

        if (is_dir($temp_path)) {       // 디렉터리가 존재한다면
            $pathname = $temp_path;
            break;                      // while ($temp_date <= $end_date) 빠져나감     
        }

        $temp_date = date_difference_day($temp_date, 1);    // 1일 뒤 날짜
    }


    // 디렉터리 존재한다면
    if ($pathname != "") {
        // echo "<br />디렉터리 삭제 pathname : " . $pathname;
        remove_derctory($pathname);     // 디렉터리 삭제 (하위 파일 포함)
    }
}

?>