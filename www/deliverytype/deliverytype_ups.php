<?php

////////////////////////////////////////////////////////////////////////////////
// UPS(국제)

// 택배사별 배송조회 결과를 구함
function get_deliverytracking_result_ups($deliverytype = "ups", $invoice_no) {
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
    
    
    
    // 택배사 배송조회 페이지를 읽음 (예 : https://www.doortodoor.co.kr/main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=690052355203)
    $delivery_search_url = $COMMON_DELIVERYURL_ARRAY[$deliverytype];
    
    $temp_url_array     =   explode("://", $delivery_search_url);
    $temp_url2_array    =   explode("/", $temp_url_array[1]);
    
    $request_protocol   =   $temp_url_array[0];                                 // http, https        
    $request_host       =   $temp_url2_array[0];                                // www.doortodoor.co.kr
    $request_uri        =   str_replace($request_host, "", $temp_url_array[1]); // /main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    
    
    $request_uri        =   str_replace("{invoice_no}", urlencode($invoice_no), $request_uri);
    
    $request_uri_array  =   explode("?", $request_uri);
    $request_uri_file   =   $request_uri_array[0];                              // /main/doortodoor.do       
    $request_uri_query  =   $request_uri_array[1];                              // fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    
    
    $curlopt_url        =   $request_protocol . "://" . $request_host . $request_uri_file;          // https://www.hlc.co.kr/home/personal/inquiry/track
    
    if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
        $curlopt_post   =   1;          // POST
    }
    else {
        $curlopt_post   =   0;          // GET
    }
    

    ////////////////////////////////////////////////////////////////////////////////
    // Post Data

    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        // Json data
        // {"Locale":"ko_KR","TrackingNumber":["1Z31X7610476007308"]}
        $request_uri_query = '{"Locale":"ko_KR","TrackingNumber":["' . $invoice_no . '"]}';

        $curlopt_postfields =   $request_uri_query;
    }
    else {          // Default
        $curlopt_postfields =   $request_uri_query;         // InvNo=225100323652&action=processInvoiceSubmit    
    }
    



    // Post Data
    ////////////////////////////////////////////////////////////////////////////////


    $curlopt_useragent  =   "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)";
    $curlopt_referer    =   "https://www.ups.com/track?loc=ko_KR&requester=WT/";
    

    // $curlopt_cookiejar  =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";
    // $curlopt_cookiefile =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";            
    $curlopt_cookiejar  =   $cookie_file;
    $curlopt_cookiefile =   $cookie_file;            
    
    
    curl_setopt($curlsession, CURLOPT_URL, $curlopt_url);
    curl_setopt($curlsession, CURLOPT_HEADER, 1);
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlsession, CURLOPT_FOLLOWLOCATION, true);                    // 리다이렉트를 자동으로 잡아줘서 302가 아니라 200이 리턴됨
    curl_setopt($curlsession, CURLOPT_MAXREDIRS, 10);                           // 최대 리다이렉트 횟수
    curl_setopt($curlsession, CURLOPT_POST, $curlopt_post);
    curl_setopt($curlsession, CURLOPT_POSTFIELDS, $curlopt_postfields);


    
    //set the content type to application/json
    curl_setopt($curlsession, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    

    curl_setopt($curlsession, CURLOPT_USERAGENT, $curlopt_useragent);
    curl_setopt($curlsession, CURLOPT_REFERER, $curlopt_referer);
    curl_setopt($curlsession, CURLOPT_COOKIEJAR, $curlopt_cookiejar);
    curl_setopt($curlsession, CURLOPT_COOKIEFILE, $curlopt_cookiefile);
    curl_setopt($curlsession, CURLOPT_TIMEOUT, 10);                             // 타임아웃 시간

    // UPS(국제) 관련해서 설정해 봄
    // curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false);                            
    // curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, false);                   //to overcome SSL 
    curl_setopt($curlsession, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlsession, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curlsession, CURLOPT_FOLLOWLOCATION, true);  

    $result =   curl_exec($curlsession);
    
    // sleep(1);
    
    // Close a cURL session
    curl_close($curlsession);



    $data = `{"Locale":"ko_KR","TrackingNumber":["1Z31X7610476007308"]}`;

    $string = "POST https://www.ups.com/track/api/Track/GetStatus?loc=ko_KR HTTP/1.0\r\n";
    $string .= "Host: www.ups.com\r\n";
    // $string .= "Connection: keep-alive\r\n";
    // $string .= "Content-Length: 58\r\n";
    $string .= "Accept: application/json, text/plain, */*\r\n";
    $string .= "Origin: https://www.ups.com\r\n";
    $string .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36\r\n";
    $string .= "Content-Type: application/json\r\n";
    $string .= "Referer: https://www.ups.com/track?loc=ko_KR&requester=WT/\r\n";
    $string .= "Accept-Encoding: gzip, deflate, br\r\n";
    $string .= "Accept-Language: en-US,en;q=0.9,ko;q=0.8,la;q=0.7\r\n";
    $string .= `Cookie: _gcl_au=1.1.2010095634.1559909491; aam_uuid=54840022476290980321075222919191310631; aam_cms=segments%3D15025641; check=true; AMCVS_036784BD57A8BB277F000101%40AdobeOrg=1; AMCV_036784BD57A8BB277F000101%40AdobeOrg=-715282455%7CMCIDTS%7C18057%7CMCMID%7C55292992586232232841030452470980057315%7CMCAAMLH-1560716417%7C7%7CMCAAMB-1560716417%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCOPTOUT-1560118817s%7CNONE%7CMCCIDH%7C2042952370%7CvVersion%7C4.2.0; utag_main=v_id:016b31d9d8fa00121cdb1bb94a8103073003006b00bd0$_sn:2$_se:1$_ss:1$_st:1560113417892$vapi_domain:ups.com$ses_id:1560111617892%3Bexp-session$_pn:1%3Bexp-session; mbox=PC#cc2071a6ba1c4aa09bd8efd7698cb148.17_202#1623356418|session#fae7be20b2dc490586063bee145848e8#1560113477; mboxEdgeCluster=17; st_cur_page=st_track; s_tp=1351; s_ppv=ups%253Akr%253Ako%253Atrack%2C56%2C56%2C757; s_vnum=1561953600308%26vn%3D2; s_invisit=true; dayssincevisit_s=Less%20than%207%20days; s_cc=true; RT="sl=1&ss=1560111614796&tt=10304&obo=0&sh=1560111625177%3D1%3A0%3A10304&dm=ups.com&si=62728f21-b4af-46c4-afb9-ca2fb09d64bb&bcn=%2F%2F173c5b04.akstat.io%2F&ld=1560111625178"; s_nr=1560111894402-Repeat; dayssincevisit=1560111894405` . "\r\n";

    // $string .= `{"Locale":"ko_KR","TrackingNumber":["1Z31X7610476007308"]}`;


    $string .= "Content-length: " . strlen($data) . "\r\n";
    $string .= "Connection: Close\r\n\r\n";
    // $string .= "Connection: Keep-Alive\r\n\r\n";
    
    $string .= $data;                               // POST 데이터 뒷부분 추가



    /*
    $string = $COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] . " " . $request_protocol . "://" . $request_host . $request_uri_file . " HTTP/1.1\r\n";
    
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






    
    $data = $result;

    
    
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


    // /*
    // if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["UPS(국제)"]) {
        // echo "<xmp>" . $result . "</xmp>"; exit;
    // }
    // */
        
    
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

        case $COMMON_DELIVERYTYPE_ARRAY["매일택배(캐나다->한국)"]:
            $result_deliverytracking = get_result_deliverytracking_mailexglobal($content_temp);
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




// 배송조회결과 구함 (UPS(국제))
function get_result_deliverytracking_ups($content_temp) {    


    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과


	// &gt;&gt;&gt; 입력하신 번호는 유효한 조회 번호가 아닙니다 (예: 일반 조회 번호는 다음과 같은 형식입니다. 1Z9999999999999999). 정확한 조회 번호인지 검토하시거나 발송자에게 번호를 확인하십시오.

    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("입력하신 번호는 유효한 조회 번호가 아닙니다", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "입력하신 번호는 유효한 조회 번호가 아닙니다";
        
        $result_deliverytracking  .=  "
            <table class=\"table table-bordered table-condensed table-hover\">
                <colgroup>
                    <col width=\"\" />
                </colgroup>                        
                <thead>
                    <tr class=\"active\">
                        <th class=\"text-center\">조회결과</th>          
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-center\">" . $text_temp . "</td>
                    </tr>
                </tbody>
            </table>
        ";                    
        
        return $result_deliverytracking;
    }



    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("요청된 발송물 세부사항을 찾을 수 없습니다. 정보를 확인하고 나중에 다시 시도하십시오.", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "요청된 발송물 세부사항을 찾을 수 없습니다. 정보를 확인하고 나중에 다시 시도하십시오.";
        
        $result_deliverytracking  .=  "
            <table class=\"table table-bordered table-condensed table-hover\">
                <colgroup>
                    <col width=\"\" />
                </colgroup>                        
                <thead>
                    <tr class=\"active\">
                        <th class=\"text-center\">조회결과</th>          
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class=\"text-center\">" . $text_temp . "</td>
                    </tr>
                </tbody>
            </table>
        ";                    
        
        return $result_deliverytracking;
    }



    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 정상조회 결과
    
    // echo "<xmp>" . $content_temp . "</xmp>"; exit;

    /*
    <input type="hidden" name="trackNums" value="1Z1041AV0325295726">


    
    */
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.배송정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수 초기화

    // (1) 운송장 번호 (Tracking Number) 
    $content_array  =   explode("<input type=\"hidden\" name=\"trackNums\" value=\"", $content_temp);    
    $content_array2 =   explode("\">", $content_array[1]);
    $text_temp[1]   =   trim($content_array2[0]);
    // echo "<br />trackNums : " . $text_temp[1]; exit;

    // (2) 배달 날짜 (Delivered On) 
    $content_array  =   explode("<strong>배달 날짜:</strong></p>", $content_temp);    
    $content_array2 =   explode("</p>", $content_array[1]);
    $content_array3 =   explode("<p class=\"\">", $content_array2[0]);
    $text_temp[2]   =   trim($content_array3[1]);
    // echo "<br />배달 날짜 : " . $text_temp[2]; exit;

    // (3) 수신인 (Received By) 
    $content_array  =   explode("<strong>수신인:</strong></p>", $content_temp);    
    $content_array2 =   explode("</p>", $content_array[1]);
    $content_array3 =   explode("<p class=\"\">", $content_array2[0]);
    $text_temp[3]   =   trim($content_array3[1]);
    // echo "<br />수신인 (Received By) : " . $text_temp[3]; exit;

    // (4) 발송물 종류 (Shipment Category) 
    $content_array  =   explode("<strong>발송물 종류:</strong>", $content_temp);    
    $content_array2 =   explode("<div class=\"col-xs-7\">", $content_array[1]);
    $content_array3 =   explode("</div>", $content_array2[1]);
    $text_temp[4]   =   trim($content_array3[0]);
    // echo "<br />발송물 종류 (Shipment Category) : " . $text_temp[4]; exit;

    // (5) 받는 사람 (To) 
    $content_array  =   explode("<strong>받는 사람:</strong></p>", $content_temp);    
    $content_array2 =   explode("</p>", $content_array[1]);
    $content_array3 =   explode("<p>", $content_array2[0]);
    $text_temp[5]   =   trim($content_array3[1]);
    // echo "<br />받는 사람 (To) : " . $text_temp[5]; exit;

    // (6) 배송 상태 (Status) 
    $content_array  =   explode("<div id=\"ttc_tt_spStatus\" >", $content_temp);    
    $content_array2 =   explode("</div>", $content_array[1]);
    $content_array3 =   explode("<h3>", $content_array2[0]);

    // html중 text 데이터만 구함                            
    $text_temp[6]   =   get_html_to_text_data($content_array3[1]);
    // echo "<br />배송 상태 (Status) : " . $text_temp[6]; exit;


    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"30%\" />
                <col width=\"20%\" />
                <col width=\"30%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">배송정보</th>          
                </tr>                
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">운송장 번호 (Tracking Number)</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">배달 날짜 (Delivered On)</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">수신인 (Received By)</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">발송물 종류 (Shipment Category)</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">받는 사람 (To)</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <th class=\"active text-center\">배송 상태 (Status)</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>                         
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 2.발송물 처리 과정
    
    // 발송물 처리 과정
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"20%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"50%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">발송물 처리 과정</th>          
                </tr>
                <tr class=\"active\">                    
                    <th class=\"text-center\">위치 (LOCATION)</th>
                    <th class=\"text-center\">날짜 (DATE)</th>
                    <th class=\"text-center\">현지 시간 (LOCAL TIME)</th>
                    <th class=\"text-center\">진행 상황 (ACTIVITY)</th>
                </tr>
            </thead>
            <tbody>
    ";
        
    // 위치, 날짜, 현지 시간, 진행 상황
    $content_array  =   explode("class=\"full\">진행 상황</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    
    $content_array3 =   explode("<tr", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    // for ($i = 1; $i < $content_array3_count; $i++) {
    for ($i = ($content_array3_count - 1); $i >= 1; $i--) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        // (1) 위치
        $content_array4 =   explode("<td", $content_array3[$i]);
        $content_array5 =   explode("</td>", $content_array4[1]);               // 1
        $content_array6 =   explode(">", $content_array5[0]);
        $text_temp[1]   =   trim($content_array6[1]);
        // echo "<br />위치 : " . $text_temp[1]; exit;

        // (2) 날짜
        $content_array4 =   explode("<td", $content_array3[$i]);
        $content_array5 =   explode("</td>", $content_array4[2]);               // 2
        $content_array6 =   explode(">", $content_array5[0]);
        $text_temp[2]   =   trim($content_array6[1]);
        // echo "<br />날짜 : " . $text_temp[2]; exit;

        // (3) 현지 시간
        $content_array4 =   explode("<td", $content_array3[$i]);
        $content_array5 =   explode("</td>", $content_array4[3]);               // 3
        $content_array6 =   explode(">", $content_array5[0]);
        $text_temp[3]   =   trim($content_array6[1]);
        // echo "<br />현지 시간 : " . $text_temp[3]; exit;

        // (4) 진행 상황
        $content_array4 =   explode("<td", $content_array3[$i]);
        $content_array5 =   explode("</td>", $content_array4[4]);               // 4
        $content_array6 =   explode(">", $content_array5[0]);
        $text_temp[4]   =   trim($content_array6[1]);
        // echo "<br />진행 상황 : " . $text_temp[4]; exit;
        
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . $text_temp[1] . "</td>
                <td class=\"text-center\">" . $text_temp[2] . "</td>
                <td class=\"text-center\">" . $text_temp[3] . "</td>
                <td class=\"text-center\">" . $text_temp[4] . "</td>
            </tr>
        ";            
    }
    
    $result_deliverytracking  .=  "
            </tbody>
        </table>
    ";
    
    /*
    echo "<xmp>";
    echo $result_deliverytracking;
    echo "</xmp>";
    */
    
    return $result_deliverytracking;
}

?>