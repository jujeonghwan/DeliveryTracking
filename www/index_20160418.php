<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();

////////////////////////////////////////////////////////////////////////////////
// 쿠키설정(사용자ID)

// 배송조회 DB 저장할 값 미리 설정 (쿠키 관련 값)
$dt_ipaddress   =   trim($_SERVER["REMOTE_ADDR"]);
$dt_regtime     =   current_datetime();
    
if ($_COOKIE["cookie_dt_userid"] != "") {
    $dt_userid  =   trim($_COOKIE["cookie_dt_userid"]);
}
else {
    $dt_userid  =   $dt_regtime . "_" . $dt_ipaddress;                          // 예) 20151210100325_112.221.253.82
}
    
if ($dt_userid != "") {    
    $cookie_dt_userid = $dt_userid;
    
    $expire = 60 * 60 * 24 * 100;                                               // 100일
    setcookie("cookie_dt_userid", $cookie_dt_userid, time() + $expire, "/", "");
}

// 쿠키설정(사용자ID)
////////////////////////////////////////////////////////////////////////////////


require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/nav.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/main.html");


// 택배사
$deliverytype = trim($_REQUEST["deliverytype"]);
if ($deliverytype == "") {
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
        $deliverytype = $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운"];
    }
}
$radio_array = array_flip($COMMON_DELIVERYTYPE_ARRAY);
$radio = get_input_radio("deliverytype", $radio_array, $deliverytype, "");
tp_set("radio_deliverytype", $radio);

// 검색어
$keyword = trim($_REQUEST["keyword"]);
tp_set("keyword", $keyword);
    
    
    
////////////////////////////////////////////////////////////////////////////////
// 택배사별 배송조회

if ($keyword != "") {
    // 운송장번호 (영어,숫자만 남김 (공백도 제거))
    $invoice_no = eng_number_only($keyword);
    
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
        case $COMMON_DELIVERYTYPE_ARRAY["대운글로벌(국제)"]:
        case $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운"]:
        case $COMMON_DELIVERYTYPE_ARRAY["대신택배"]:
        case $COMMON_DELIVERYTYPE_ARRAY["EMS국제우편(국제)"]:   
        case $COMMON_DELIVERYTYPE_ARRAY["우체국택배"]:
        case $COMMON_DELIVERYTYPE_ARRAY["GTX로지스"]:
        case $COMMON_DELIVERYTYPE_ARRAY["한진택배"]:
        case $COMMON_DELIVERYTYPE_ARRAY["합동택배"]:
            break; 
            
        case $COMMON_DELIVERYTYPE_ARRAY["현대택배"]: 
        
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
            $curlopt_referer    =   $curlopt_url;            
            // $curlopt_cookiejar  =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";
            // $curlopt_cookiefile =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";            
            $curlopt_cookiejar  =   $cookie_file;
            $curlopt_cookiefile =   $cookie_file;
            
            /*
            echo "<br />curlopt_url : " . $curlopt_url;
            echo "<br />curlopt_post : " . $curlopt_post;
            echo "<br />curlopt_postfields : " . $curlopt_postfields;
            echo "<br />curlopt_referer : " . $curlopt_referer;
            echo "<br />curlopt_cookiejar : " . $curlopt_cookiejar;
            echo "<br />curlopt_cookiefile : " . $curlopt_cookiefile;
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
            $result =   curl_exec($curlsession);
            
            // echo "<xmp>" . $result . "</xmp>";
            // exit;
            
            // 현대택배 몇초간 기다려야 조회됨
            sleep(3);
        
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["로젠택배"]:
        case $COMMON_DELIVERYTYPE_ARRAY["KGB택배"]:        
        case $COMMON_DELIVERYTYPE_ARRAY["KG로지스"]: 
        default:
            break;
    }
    
    // 택배사 배송조회 선처리 (끝)
    ////////////////////////////////////////////////////////////////////////////////
    
    
    
    // 택배사 배송조회 페이지를 읽음 (예 : https://www.doortodoor.co.kr/main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=690052355203)
    $delivery_search_url = $COMMON_DELIVERYURL_ARRAY[$deliverytype];
    
    $temp_url_array     =   explode("://", $delivery_search_url);
    $temp_url2_array    =   explode("/", $temp_url_array[1]);
    
    $request_protocol   =   $temp_url_array[0];                                 // http, https        
    $request_host       =   $temp_url2_array[0];                                // www.doortodoor.co.kr
    $request_uri        =   str_replace($request_host, "", $temp_url_array[1]); // /main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    
    // 운송장번호 부분 대체 : {invoice_no} => 123456789012
    $request_uri        =   str_replace("{invoice_no}", urlencode($invoice_no), $request_uri);
    
    // [합동택배] 년월 부분 대체 : {search_month} => 201604
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["합동택배"]) {
        $request_uri    =   str_replace("{search_month}", current_yearmonth(), $request_uri);    
    }    
    
    $request_uri_array  =   explode("?", $request_uri);
    $request_uri_file   =   $request_uri_array[0];                              // /main/doortodoor.do       
    $request_uri_query  =   $request_uri_array[1];                              // fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    // echo $request_uri; exit;
    
    
    $curlopt_url        =   $request_protocol . "://" . $request_host . $request_uri_file;          // https://www.hlc.co.kr/home/personal/inquiry/track
    
    if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
        $curlopt_post   =   1;          // POST
    }
    else {
        $curlopt_post   =   0;          // GET
    }
    
    $curlopt_postfields =   $request_uri_query;                                                     // InvNo=225100323652&action=processInvoiceSubmit
    $curlopt_useragent  =   "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)";
    $curlopt_referer    =   $curlopt_url;    
    // $curlopt_cookiejar  =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";
    // $curlopt_cookiefile =   $PATH_VAR["cookie_path"] . "/cookie_" . $deliverytype . ".txt";            
    $curlopt_cookiejar  =   $cookie_file;
    $curlopt_cookiefile =   $cookie_file;            
    
    /*
    echo "<br />curlopt_url : " . $curlopt_url;
    echo "<br />curlopt_post : " . $curlopt_post;
    echo "<br />curlopt_postfields : " . $curlopt_postfields;
    echo "<br />curlopt_referer : " . $curlopt_referer;
    echo "<br />curlopt_cookiejar : " . $curlopt_cookiejar;
    echo "<br />curlopt_cookiefile : " . $curlopt_cookiefile;
    */
    
    curl_setopt($curlsession, CURLOPT_URL, $curlopt_url);
    curl_setopt($curlsession, CURLOPT_HEADER, 1);
    curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlsession, CURLOPT_FOLLOWLOCATION, true);                        // 리다이렉트를 자동으로 잡아줘서 302가 아니라 200이 리턴됨
    curl_setopt($curlsession, CURLOPT_MAXREDIRS, 10);                               // 최대 리다이렉트 횟수
    curl_setopt($curlsession, CURLOPT_POST, $curlopt_post);
    curl_setopt($curlsession, CURLOPT_POSTFIELDS, $curlopt_postfields);
    curl_setopt($curlsession, CURLOPT_USERAGENT, $curlopt_useragent);
    curl_setopt($curlsession, CURLOPT_REFERER, $curlopt_referer);
    curl_setopt($curlsession, CURLOPT_COOKIEJAR, $curlopt_cookiejar);
    curl_setopt($curlsession, CURLOPT_COOKIEFILE, $curlopt_cookiefile);
    curl_setopt($curlsession, CURLOPT_TIMEOUT, 10);                                 // 타임아웃 시간
    
    $result =   curl_exec($curlsession);
    
    // sleep(1);
    
    // Close a cURL session
    curl_close($curlsession);
    
    $data = $result;
    
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // cURL 동작이 안되는 택배사 fsockopen 으로 처리
    
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["합동택배"]) {
       
        if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
            $string = $COMMON_DELIVERYMETHOD_ARRAY["$deliverytype"] . " " . $request_uri . " HTTP/1.0\r\n";                 // 예) POST /trace.RetrieveDomRigiTraceList.comm?sid1=6025015340963&displayHeader=N HTTP/1.0    
            
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
            $string .= "Connection: Keep-Alive\r\n\r\n";
            
            $string .= $data;                               // POST 데이터 뒷부분 추가
        }
        else {                                              // GET
            $string = $COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] . " " . $request_uri . " HTTP/1.0\r\n";                   // 예) GET /trace.RetrieveDomRigiTraceList.comm?sid1=6025015340963&displayHeader=N HTTP/1.0    
            $string .= "Host: " . $request_host . "\r\n";    
            $string .= "Connection: Close\r\n\r\n";
        }
        ////////////////////////////////////////////////////////////////////////////////
        
        // echo "<xmp>" . $string . "</xmp>"; exit;
        
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
    
    
    
    
    // echo $data; exit;
    // echo "<xmp>" . $data . "</xmp>"; exit;
    /*
    if ($deliverytype == $COMMON_DELIVERYTYPE_ARRAY["합동택배"]) {
        echo "<xmp>" . $data . "</xmp>"; exit;
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
        
        case $COMMON_DELIVERYTYPE_ARRAY["대운글로벌(국제)"]:            
            $result_deliverytracking = get_result_deliverytracking_daewoonsys($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운"]:            
            $result_deliverytracking = get_result_deliverytracking_doortodoor($content_temp);            
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
            
        case $COMMON_DELIVERYTYPE_ARRAY["로젠택배"]:            
            $result_deliverytracking = get_result_deliverytracking_ilogen($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["KGB택배"]:            
            $result_deliverytracking = get_result_deliverytracking_kgbls($content_temp);            
            break;
            
        case $COMMON_DELIVERYTYPE_ARRAY["KG로지스"]:            
            $result_deliverytracking = get_result_deliverytracking_kglogis($content_temp);            
            break;
              
        default:
            // 조회결과 부분
            $result_deliverytracking  =   $content_temp;
            break;
            
    }    
    
    // echo "<xmp>" . $result_deliverytracking . "</xmp>"; exit;
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 배송조회이력 저장
    $dt_deliverytype        =   $deliverytype;
    $dt_keyword             =   $keyword;
    $dt_invoice             =   $invoice_no;
    $dt_deliveryprogress    =   get_deliverytracking_deliveryprogress($result_deliverytracking);
    $dt_result              =   $result_deliverytracking;    
    $dt_userid              =   $dt_userid;                 // 제일 윗쪽에서 미리 설정 (1)
    $dt_ipaddress           =   $dt_ipaddress;              // 제일 윗쪽에서 미리 설정 (2)
    $dt_regtime             =   $dt_regtime;                // 제일 윗쪽에서 미리 설정 (3)
    
    // 중복 체크
    $query = "select ";
    $query .= "count(*) as data_count ";
    $query .= "from deliverytracking_tb ";
    $query .= "where dt_deliverytype = '" . $dt_deliverytype . "' ";
    $query .= "and dt_keyword = '" . $dt_keyword . "' ";
    $query .= "and dt_ipaddress = '" . $dt_ipaddress . "' ";
    $query .= "and dt_regtime = '" . $dt_regtime . "' ";
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
        $query .= "dt_userid, ";
        $query .= "dt_ipaddress, ";
        $query .= "dt_regtime ";
        $query .= ") values ( ";
        $query .= "'" . $dt_deliverytype . "', ";
        $query .= "'" . $dt_keyword . "', ";
        $query .= "'" . $dt_invoice . "', ";
        $query .= "'" . $dt_deliveryprogress . "', ";
        $query .= "'" . htmlspecialchars($dt_result) . "', ";
        $query .= "'" . $dt_userid . "', ";
        $query .= "'" . $dt_ipaddress . "', ";
        $query .= "'" . $dt_regtime . "' ";
        $query .= ")";   
        // echo "<br />query : <xmp>" . $query . "</xmp>"; exit;
        
        db_query($query);  
    }  
    
    // 시간 기다림
    // sleep(1);    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 조회결과 표시
    
    // 택배사명
    tp_set("result_deliverytype", array_search($deliverytype, $COMMON_DELIVERYTYPE_ARRAY));
    
    // 조회결과
    tp_set("result_deliverytracking", $result_deliverytracking);
    
}

// 택배사별 배송조회
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// 배송조회이력 목록 표시

$template = "row";
tp_dynamic($template);

$query = "select ";
$query .= "dt_id, ";
$query .= "dt_deliverytype, ";
$query .= "dt_keyword, ";
$query .= "dt_invoice, ";
$query .= "dt_deliveryprogress, ";
$query .= "dt_result, ";
$query .= "dt_userid, ";
$query .= "dt_ipaddress, ";
$query .= "dt_regtime ";
$query .= "from deliverytracking_tb ";
$query .= "where dt_userid = '" . $dt_userid . "' ";
$query .= "order by dt_id desc ";
// $query .= "limit 100 ";

$result = db_query($query);
$result_rows = db_num_rows($result);
    
while ($row = db_fetch_array($result)) {
    $no++;
    
    // 상세조회결과 초기에 보여줄지 여부        
    if ( ($no == 1) && ($keyword == $row["dt_keyword"]) ) {
        $deliverytracking_display = "";    
    }
    else {
        $deliverytracking_display = "none";    
    }
    
    // 배송진행상태
    if ($row["dt_deliveryprogress"] == "") {            
        $row["dt_deliveryprogress"] = get_deliverytracking_deliveryprogress($row["dt_result"]);
    }
    
    tp_set($template, array(
        "dt_id"                     =>  $row["dt_id"],
        "no"                        =>  $no,
        "dt_regtime"                =>  get_datetime_format($row["dt_regtime"]),
        "dt_deliverytype_text"      =>  array_search($row["dt_deliverytype"], $COMMON_DELIVERYTYPE_ARRAY),
        
        "dt_keyword"                =>  $row["dt_keyword"],
        "dt_invoice"                =>  $row["dt_invoice"],        
        "color_dt_deliveryprogress" =>  $color_dt_deliveryprogress_array[$row["dt_deliveryprogress"]],  
        "dt_deliveryprogress"       =>  $row["dt_deliveryprogress"],        
        
        "dt_deliverytype"           =>  $row["dt_deliverytype"],
        
        "deliverytracking_display"  =>  $deliverytracking_display,  
        "dt_result"                 =>  htmlspecialchars_decode($row["dt_result"])
    ));
    tp_parse($template);
}

// 배송조회이력 목록 표시
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// 샘플 배송조회이력 목록 표시 (각 택배사별 1항목씩 데이터 표시)

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
        $query .= "dt_userid, ";
        $query .= "dt_ipaddress, ";
        $query .= "dt_regtime ";
        $query .= "from deliverytracking_tb ";
        $query .= "where dt_deliverytype = '" . $val . "' ";
        $query .= "order by dt_id desc ";
        $query .= "limit 1 ";
        
        $result = db_query($query);
        $result_rows = db_num_rows($result);
            
            
        while ($row = db_fetch_array($result)) {
            $no++;
            
            // 상세조회결과 초기에 보여줄지 여부        
            if ( ($no == 1) && ($keyword == $row["dt_keyword"]) ) {
                $deliverytracking_display = "";    
            }
            else {
                $deliverytracking_display = "none";    
            }
            
            // 배송진행상태
            if ($row["dt_deliveryprogress"] == "") {            
                $row["dt_deliveryprogress"] = get_deliverytracking_deliveryprogress($row["dt_result"]);
            }
            
            tp_set($template, array(
                "dt_id"                     =>  $row["dt_id"],
                "no"                        =>  $no,
                "dt_regtime"                =>  get_datetime_format($row["dt_regtime"]),
                "dt_deliverytype_text"      =>  array_search($row["dt_deliverytype"], $COMMON_DELIVERYTYPE_ARRAY),
                
                "dt_keyword"                =>  $row["dt_keyword"],
                "dt_invoice"                =>  $row["dt_invoice"],        
                "color_dt_deliveryprogress" =>  $color_dt_deliveryprogress_array[$row["dt_deliveryprogress"]],  
                "dt_deliveryprogress"       =>  $row["dt_deliveryprogress"],        
                
                "dt_deliverytype"           =>  $row["dt_deliverytype"],
                
                "deliverytracking_display"  =>  $deliverytracking_display,  
                "dt_result"                 =>  htmlspecialchars_decode($row["dt_result"])
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

?>