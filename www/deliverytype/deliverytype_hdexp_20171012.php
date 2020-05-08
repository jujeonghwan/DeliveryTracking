<?php

////////////////////////////////////////////////////////////////////////////////
// 합동택배


// 배송조회결과 구함 (합동택배)
function get_result_deliverytracking_hdexp($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("조회된 데이터가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    조회된 데이터가 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "조회된 데이터가 없습니다.";
        
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
    
    // 조회결과
    $result_deliverytracking        =   "";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.보낸분 받는분 정보
                
    // 발송영업소 발송영업소tel 보낸분 보낸분tel 보낸분주소
    // 도착영업소 도착영업소tel 받는분 받는분tel 받는분주소

    /*
    {
    "result":
        {
            "carno1":"성남분당백현7603",
            "carno2":"군포번영82나4381",
            "carno3":"인천남동2626953",
            "scan_dcargubun":null,
            "t2_tel":null,
            "searchmonth":null,
            "t1_tel":"080-877-8202",
            "scan_ucargubun":null,
            "sender_name":"아성테크",
            "goodsname":"발포지",
            "delivery_time":"2016-03-31 03:31:00",
            "packing":"비닐",
            "deliverystatdesc":"배송완료",
            "receiver_tel":"010-5187-0412",
            "scan_umulpumtime":null,
            "scan_umulpumgubun":null,
            "endbranch_tel":"032-822-9923",
            "scan_ucartime":null,
            "scan_ubranchgubun":null,
            "t1_gubun":"군포",
            "scan_dcartime":null,
            "startbranch_name":"군포건영",
            "receiver_name":"김기도",
            "endbranch_name":"인천남동263",
            "barcode":"209016103305",
            "receivetime":"2016-03-30 06:30:00",
            "sender_tel":"031-764-2050",
            "t1_time":"2016-03-30 11:30:31",
            "gatherdate":"20160330",
            "volume":"1",
            "sign_value":"본인",
            "t2_gubun":"고촌",
            "scan_dbranchgubun":null,
            "t2_time":"2016-03-30 02:30:43",
            "scan_ubranchtime":null,
            "paydivdesc":"택현",
            "receiver_addr":"인천 연수구 송도동 9-3 인천가톨릭대학교 조형예대809",
            "startbranch_tel":"031-460-7800",
            "scan_dbranchtime":null        
        }
    }
    */
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 발송영업소
    $content_array  =   explode("\"startbranch_name\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    
    // (2) 도착영업소
    $content_array  =   explode("\"endbranch_name\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array2[0]);
    
    // (3) 발송영업소tel
    $content_array  =   explode("\"startbranch_tel\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array2[0]);
    
    // (4) 도착영업소tel  
    $content_array  =   explode("\"endbranch_tel\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array2[0]);
    
    // (5) 보낸분
    $content_array  =   explode("\"sender_name\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[5]   =   get_html_to_text_data($content_array2[0]);
    
    // (6) 받는분
    $content_array  =   explode("\"receiver_name\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[6]   =   get_html_to_text_data($content_array2[0]);
    
    // (7) 보낸분tel
    $content_array  =   explode("\"sender_tel\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[7]   =   get_html_to_text_data($content_array2[0]);
    
    // (8) 받는분tel
    $content_array  =   explode("\"receiver_tel\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[8]   =   get_html_to_text_data($content_array2[0]);
    
    // (9) 받는분주소
    $content_array  =   explode("\"receiver_addr\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[9]   =   get_html_to_text_data($content_array2[0]);
    
    // print_r($text_temp); exit;
    
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
                    <th class=\"text-center\" colspan=\"4\">보낸분 받는분 정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"text-center active\">발송영업소</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"text-center active\">도착영업소</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">발송영업소tel</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"text-center active\">도착영업소tel</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">보낸분</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <th class=\"text-center active\">받는분</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                </tr>      
                <!--                          
                <tr>
                    <th class=\"text-center active\">보낸분tel</th>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>
                    <th class=\"text-center active\">받는분tel</th>
                    <td class=\"text-center\">" . $text_temp[8] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">받는분주소</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[9] . "</td>
                </tr>
                -->
            </tbody>
        </table>
    ";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.기본정보
                
    // 발송일 운송장번호 운송구분 물품명 포장 수량
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 발송일
    $content_array  =   explode("\"gatherdate\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    
    // (2) 운송장번호
    $content_array  =   explode("\"barcode\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array2[0]);
    
    // (3) 운송구분
    $content_array  =   explode("\"paydivdesc\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array2[0]);
    
    // (4) 물품명
    $content_array  =   explode("\"goodsname\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array2[0]);
    
    // (5) 포장
    $content_array  =   explode("\"packing\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[5]   =   get_html_to_text_data($content_array2[0]);
    
    // (6) 수량
    $content_array  =   explode("\"volume\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[6]   =   get_html_to_text_data($content_array2[0]);
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                
                <col width=\"20%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"6\">기본정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">발송일</th>
                    <th class=\"text-center\">운송장번호</th>
                    <th class=\"text-center\">운송구분</th>
                    
                    <th class=\"text-center\">물품명</th>
                    <th class=\"text-center\">포장</th>                            
                    <th class=\"text-center\">수량</th>                            
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>                                
                </tr>
            </tbody>
        </table>
    "; 
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 3.처리현황
    
    // 처리현황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"25%\" />
                <col width=\"25%\" />
                <col width=\"25%\" />
                <col width=\"25%\" />  
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">처리현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜</th>
                    <th class=\"text-center\">처리점소</th>                    
                    <th class=\"text-center\">연락처</th>                            
                    <th class=\"text-center\">처리현황</th>                          
                </tr>
            </thead>
            <tbody>
    ";
    
    // 날짜, 처리점소, 연락처, 처리현황
    
    // [배송추적 시작] startbranch
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 날짜
    $content_array  =   explode("\"receivetime\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    
    // (2) 처리점소
    $content_array  =   explode("\"startbranch_name\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array2[0]);
    
    // (3) 연락처
    $content_array  =   explode("\"startbranch_tel\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array2[0]);
    
    // (4) 처리현황
    $text_temp[4]   =   "접수완료";
    
    if ( ($text_temp[1] != "") && ($text_temp[2] != "") ) {
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[4]) . "</td>
            </tr>
        ";    
    }
    
    
    
    // [배송추적 터미널]
    for ($i = 1; $i <= 5; $i++) {
        $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
        // (1) 날짜
        $content_array  =   explode("\"t" . $i . "_time\":\"", $content_temp);
        $content_array2 =   explode("\"", $content_array[1]);
        
        $text_temp[1]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
        
        // (2) 처리점소
        $content_array  =   explode("\"t" . $i . "_gubun\":\"", $content_temp);
        $content_array2 =   explode("\"", $content_array[1]);
        
        $text_temp[2]   =   get_html_to_text_data($content_array2[0]);
        
        // (3) 연락처
        $content_array  =   explode("\"t" . $i . "_tel\":\"", $content_temp);
        $content_array2 =   explode("\"", $content_array[1]);
        
        $text_temp[3]   =   get_html_to_text_data($content_array2[0]);
        
        // (4) 처리현황
        $text_temp[4]   =   "터미널입고";
        
        if ( ($text_temp[1] != "") && ($text_temp[2] != "") ) {
            $result_deliverytracking .= "
                <tr>
                    <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[4]) . "</td>
                </tr>
            ";    
        }   
    }    
    
    
    
    // [배송추적 끝] endbranch
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 날짜
    $content_array  =   explode("\"delivery_time\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    
    // (2) 처리점소
    $content_array  =   explode("\"endbranch_name\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array2[0]);
    
    // (3) 연락처
    $content_array  =   explode("\"endbranch_tel\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array2[0]);
    
    // (4) 처리현황
    $content_array  =   explode("\"deliverystatdesc\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array2[0]);
    
    if ( ($text_temp[1] != "") && ($text_temp[2] != "") ) {
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[4]) . "</td>
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