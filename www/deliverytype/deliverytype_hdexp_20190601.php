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
    $content_array          =   explode("\"result\":\"fail\"", $content_temp);
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
    // 1.기본정보
       
    // 운송장번호         
    // 발송영업소 도착영업소 보낸분 받는분 품명 수량

    /*
    "info":{  
        "branch_end":"광주북구운암1447",
        "prod":"내벽재",
        "send_name":"주***",
        "cnt":1,
        "re_name":"권***",
        "rec_dt":"2017-10-10 14:17:43",
        "barcode":"3301024100229",
        "branch_start":"강릉내곡443",
        "relation":"본인"
    }
    */
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 운송장번호
    $content_array  =   explode("\"barcode\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    // echo "<br />운송장번호 : " . $text_temp[1]; exit;

    // (2) 발송영업소
    $content_array  =   explode("\"branch_start\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    // echo "<br />발송영업소 : " . $text_temp[2]; exit;

    // (3) 도착영업소
    $content_array  =   explode("\"branch_end\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    // echo "<br />도착영업소 : " . $text_temp[3]; exit;

    // (4) 보낸분
    $content_array  =   explode("\"send_name\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    // echo "<br />보낸분 : " . $text_temp[4]; exit;

    // (5) 받는분
    $content_array  =   explode("\"re_name\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[5]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    // echo "<br />받는분 : " . $text_temp[5]; exit;

    // (6) 품명
    $content_array  =   explode("\"prod\":\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    
    $text_temp[6]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    // echo "<br />품명 : " . $text_temp[6]; exit;

    // (7) 수량
    $content_array  =   explode("\"cnt\":", $content_temp);
    $content_array2 =   explode(",", $content_array[1]);
    
    $text_temp[7]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    // echo "<br />수량 : " . $text_temp[7]; exit;
    
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
                    <th class=\"text-center\" colspan=\"4\">기본정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"text-center active\">운송장번호</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[1] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">발송영업소</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <th class=\"text-center active\">도착영업소</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">보낸분</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                    <th class=\"text-center active\">받는분</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">품명</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                    <th class=\"text-center active\">수량</th>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>
                </tr>
            </tbody>
        </table>
    ";
    
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.배송추적 정보
    
    // 배송추적 정보
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
                    <th class=\"text-center\" colspan=\"4\">배송추적 정보</th>          
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
    $content_array  =   explode("\"items\":[", $content_temp);
    $content_array2 =   explode("],", $content_array[1]);    
    $content_array3 =   explode("{", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {
        // echo "<br /><xmp>" . $content_array3[$i] . "</xmp>"; exit;
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        // (1) 날짜
        $content_array4 =   explode("\"reg_date\":\"", $content_array3[$i]);
        $content_array5 =   explode("\",", $content_array4[1]);

        // html중 text 데이터만 구함                            
        $text_temp[1] = get_html_to_text_data($content_array5[0]);
        // echo "<br />날짜 : " . $text_temp[1]; exit;


        // (2) 처리점소
        $content_array4 =   explode("\"location\":\"", $content_array3[$i]);
        $content_array5 =   explode("\",", $content_array4[1]);

        // html중 text 데이터만 구함                            
        $text_temp[2] = get_html_to_text_data($content_array5[0]);
        // echo "<br />처리점소 : " . $text_temp[2]; exit;


        // (3) 연락처
        $content_array4 =   explode("\"tel\":\"", $content_array3[$i]);
        $content_array5 =   explode("\"", $content_array4[1]);

        // html중 text 데이터만 구함                            
        $text_temp[3] = get_html_to_text_data($content_array5[0]);
        // echo "<br />연락처 : " . $text_temp[3]; exit;


        // (4) 처리현황
        $content_array4 =   explode("\"stat\":\"", $content_array3[$i]);
        $content_array5 =   explode("\",", $content_array4[1]);

        // html중 text 데이터만 구함                            
        $text_temp[4] = get_html_to_text_data($content_array5[0]);
        // echo "<br />처리현황 : " . $text_temp[4]; exit;


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