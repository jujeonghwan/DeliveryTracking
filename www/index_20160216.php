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

// 경로
tp_set("menu_navigator", get_menu_navigator());


// 택배사
$deliverytype = trim($_REQUEST["deliverytype"]);
$radio_array = array_flip($COMMON_DELIVERYTYPE_ARRAY);
$radio = get_input_radio("deliverytype", $radio_array, $deliverytype, "");
tp_set("radio_deliverytype", $radio);

// 검색어
$keyword = trim($_REQUEST["keyword"]);
tp_set("keyword", $keyword);
    
    
    
////////////////////////////////////////////////////////////////////////////////
// 택배사별 배송조회

if ($keyword != "") {
    // 운송장번호 (숫자만 남김)
    $invoice_no = number_only($keyword);
        
    
    // 택배사 배송조회 페이지를 읽음 (예 : https://www.doortodoor.co.kr/main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=690052355203)
    $delivery_search_url = $COMMON_DELIVERYURL_ARRAY[$deliverytype];

    
    $temp_url_array     =   explode("://", $delivery_search_url);
    $temp_url2_array    =   explode("/", $temp_url_array[1]);
    
    $request_protocol   =   $temp_url_array[0];                                 // http, https        
    $request_host       =   $temp_url2_array[0];                                // www.doortodoor.co.kr
    $request_uri        =   str_replace($request_host, "", $temp_url_array[1]); // /main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=123456789012
    
    // 운송장번호 부분 대체 : {invoice_no} => 123456789012
    $request_uri        =   str_replace("{invoice_no}", urlencode($invoice_no), $request_uri);
    // echo $request_uri; exit;
    
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 요청후 결과 기억
    if ($COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] == "POST") {
        $string = $COMMON_DELIVERYMETHOD_ARRAY["$deliverytype"] . " " . $request_uri . " HTTP/1.0\r\n";                 // 예) POST /trace.RetrieveDomRigiTraceList.comm?sid1=6025015340963&displayHeader=N HTTP/1.0    
        
        
        if ($request_host == "www.hlc.co.kr") {
            // $string .= "Cookie: WMONID=PdDATOAkvID; GuestId=NUTJC82043WOUKA20160122212127; entalkvar=; ValueFromClick=; LPINFO=; assc_comp_id=27281; MemberID=; assc_comp_gb=001; wcs_bt=s_1f2fe72481:1453470821; AKMALL_SESSIONID=LRQfWv0TwpsgglLwjPG65S0YyjGppkv1tvMrkg3LSLzdG1Fv0RTD!1344046434; pckey=145130164731482384650; _ga=GA1.2.1572040308.1451301647; _gat=1; Ncisy=; akmall=2e6a1dd4d58b1f181220203c352350cf3c3bdcd3ea03cc8bddee3f8f832e5b10bb4c2f27f0c4c6efabd84967847cea852ace00e214923f0d504bb7b61571cfbdc8345ee0d2cf7b30; shoppingmallID=0; app_mall_type=\n";
            
            
            $string = "POST http://www.hlc.co.kr/open/tracking HTTP/1.1\r\n";
            $string .= "Accept: text/html, application/xhtml+xml, image/jxr, */*\r\n";
            $string .= "Referer: http://www.hlc.co.kr/open/tracking?invno=" . urlencode($invoice_no) . "\r\n";
            $string .= "Accept-Language: ko\r\n";
            $string .= "User-Agent: Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)\r\n";
            $string .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $string .= "Accept-Encoding: gzip, deflate\r\n";
            // $string .= "Content-Length: 20\r\n";
            $string .= "Host: www.hlc.co.kr\r\n";
            // $string .= "Connection: Keep-Alive\r\n";
            $string .= "Pragma: no-cache\r\n";
            $string .= "Cookie: PP16012500=X; PP14081100=X; JSESSIONID_hlchome=J1jbW1VVrT7BXJKR7cFvQbzhWQYVhRpH9M4hWzGpdMGRy4BLVmPp!-1339268748!-369719718\r\n";
            
            // $string .= "action=processSubmit
            
            
            
        }

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
        
        $string .= $data;               // POST 데이터 뒷부분 추가
    }
    else {                              // GET
        $string = $COMMON_DELIVERYMETHOD_ARRAY[$deliverytype] . " " . $request_uri . " HTTP/1.0\r\n";                   // 예) GET /trace.RetrieveDomRigiTraceList.comm?sid1=6025015340963&displayHeader=N HTTP/1.0    
        $string .= "Host: " . $request_host . "\r\n";    
        $string .= "Connection: Close\r\n\r\n";
    }
    ////////////////////////////////////////////////////////////////////////////////
    
    if ($request_host == "www.hlc.co.kr") {              // 현대택배
        // echo "<xmp>" . $string . "</xmp>"; exit;
    }
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
    
    // echo $data; exit;
    // echo "<xmp>" . $data . "</xmp>"; exit;
    /*
    if ($request_host == "www.hlc.co.kr") {              // 현대택배
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
        
    
    // 디렉터리 확인
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
        
        case $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운"]:            
            $result_deliverytracking = get_result_deliverytracking_doortodoor($content_temp);            
            break;

        case $COMMON_DELIVERYTYPE_ARRAY["우체국택배"]:            
            $result_deliverytracking = get_result_deliverytracking_epost($content_temp);            
            break;            
        
        case $COMMON_DELIVERYTYPE_ARRAY["GTX택배"]:            
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
              
        default:
            // 조회결과 부분
            $result_deliverytracking  =   $content_temp;
            break;
            
    }    
    
    // echo "<xmp>" . $result_deliverytracking . "</xmp>"; exit;
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 배송조회이력 저장
    $dt_deliverytype    =   $deliverytype;
    $dt_keyword         =   $keyword;
    $dt_invoice         =   $invoice_no;
    $dt_result          =   $result_deliverytracking;    
    $dt_userid          =   $dt_userid;                     // 제일 윗쪽에서 미리 설정 (1)
    $dt_ipaddress       =   $dt_ipaddress;                  // 제일 윗쪽에서 미리 설정 (2)
    $dt_regtime         =   $dt_regtime;                    // 제일 윗쪽에서 미리 설정 (3)
    
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
        $query .= "dt_result, ";
        $query .= "dt_userid, ";
        $query .= "dt_ipaddress, ";
        $query .= "dt_regtime ";
        $query .= ") values ( ";
        $query .= "'" . $dt_deliverytype . "', ";
        $query .= "'" . $dt_keyword . "', ";
        $query .= "'" . $dt_invoice . "', ";
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
$query .= "dt_result, ";
$query .= "dt_userid, ";
$query .= "dt_ipaddress, ";
$query .= "dt_regtime ";
$query .= "from deliverytracking_tb ";
$query .= "where dt_userid = '" . $dt_userid . "' ";
$query .= "order by dt_id desc ";

$result = db_query($query);
$result_rows = db_num_rows($result);

if ($result_rows > 0) {
    $no = 0;
    
    while ($row = db_fetch_array($result)) {
        $no++;
        
        // 상세조회결과 초기에 보여줄지 여부
        $deliverytracking_display = "none";        
        if ( ($no == 1) && ($keyword == $row["dt_keyword"]) ) {
            $deliverytracking_display = "";    
        }
        
        tp_set($template, array(
            "no"                        =>  $no,
            "dt_regtime"                =>  get_datetime_format($row["dt_regtime"]),
            "dt_deliverytype_text"      =>  array_search($row["dt_deliverytype"], $COMMON_DELIVERYTYPE_ARRAY),
            "dt_keyword"                =>  $row["dt_keyword"],
            "dt_invoice"                =>  $row["dt_invoice"],
            "dt_id"                     =>  $row["dt_id"],
            "dt_deliverytype"           =>  $row["dt_deliverytype"],
            
            "deliverytracking_display"  =>  $deliverytracking_display,  
            "dt_result"                 =>  htmlspecialchars_decode($row["dt_result"])
        ));
        tp_parse($template);
    }
}
else {
    tp_set($template, array(
        "no"                        =>  "&nbsp;",
        "dt_regtime"                =>  "&nbsp;",
        "dt_deliverytype_text"      =>  "&nbsp;",
        "dt_keyword"                =>  "&nbsp;",
        "dt_invoice"                =>  "&nbsp;",        
        "dt_id"                     =>  "",
        "dt_deliverytype"           =>  "",
        
        "deliverytracking_display"  =>  "",
        "dt_result"                 =>  "검색 결과가 없습니다."
    ));
    tp_parse($template);
}   

// 배송조회이력 목록 표시
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