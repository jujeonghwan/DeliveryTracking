<?php

////////////////////////////////////////////////////////////////////////////////
// 매일택배(캐나다->한국)

// 배송조회결과 구함 (매일택배(캐나다->한국))
function get_result_deliverytracking_mailexglobal($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("검색된 운송장이 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "검색된 운송장이 없습니다.";
        
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
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.기본정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수

    $content_array  =   explode("<td class=\"subject\">운송장 번호</td>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);            

    // (1) 운송장 번호
    $content_array3 =   explode("<td class=\"pl30\"><a href=\"javascript:fnPostTrackingDetailView();\" class=\"link_text\">", $content_array2[0]);
    $content_array4 =   explode("</a></td>", $content_array3[1]);

    $text_temp[1]   =   get_html_to_text_data($content_array4[0]);       
    // echo "<br />운송장 번호: " . $text_temp[1]; exit;

    // (2) Loading No.
    $content_array3 =   explode("<td class=\"subject\">Loading No.</td>", $content_array2[0]);
    $content_array4 =   explode("<td class=\"pl30\">", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);

    $text_temp[2]   =   get_html_to_text_data($content_array5[0]);       
    // echo "<br />Loading No.: " . $text_temp[2]; exit;

    // (3) 발송인
    $content_array3 =   explode("<td class=\"subject\">발송인</td>", $content_array2[0]);
    $content_array4 =   explode("<td class=\"pl30\">", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);

    $text_temp[3]   =   get_html_to_text_data($content_array5[0]);       
    // echo "<br />발송인: " . $text_temp[3]; exit;

    // (4) 전화번호
    $content_array3 =   explode("<td class=\"subject\">전화번호</td>", $content_array2[0]);
    $content_array4 =   explode("<td class=\"pl30\">", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);

    $text_temp[4]   =   get_html_to_text_data($content_array5[0]);       
    // echo "<br />전화번호: " . $text_temp[4]; exit;

    // (5) 주소
    $content_array3 =   explode("<td class=\"subject\">주소</td>", $content_array2[0]);
    $content_array4 =   explode("<td class=\"pl30\" colspan=\"5\">", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);

    $text_temp[5]   =   get_html_to_text_data($content_array5[0]);       
    // echo "<br />주소: " . $text_temp[5]; exit;

    // (6) 수취인
    $content_array3 =   explode("<td class=\"subject\">수취인</td>", $content_array2[0]);
    $content_array4 =   explode("<td class=\"pl30\">", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);

    $text_temp[6]   =   get_html_to_text_data($content_array5[0]);       
    // echo "<br />수취인: " . $text_temp[6]; exit;

    // (7) 전화번호
    $content_array3 =   explode("<td class=\"subject\">전화번호</td>", $content_array2[0]);
    $content_array4 =   explode("<td class=\"pl30\">", $content_array3[2]);     // *** $content_array3[2] => 2번째 나오는 전화번호
    $content_array5 =   explode("</td>", $content_array4[1]);

    $text_temp[7]   =   get_html_to_text_data($content_array5[0]);       
    // echo "<br />전화번호: " . $text_temp[7]; exit;

    // (8) 주소
    $content_array3 =   explode("<td class=\"subject\">주소</td>", $content_array2[0]);
    $content_array4 =   explode("<td class=\"pl30\" colspan=\"5\">", $content_array3[2]);   // *** $content_array3[2] => 2번째 나오는 주소
    $content_array5 =   explode("</td>", $content_array4[1]);

    $text_temp[8]   =   get_html_to_text_data($content_array5[0]);       
    // echo "<br />주소: " . $text_temp[8]; exit;
    
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
                    <th class=\"active text-center\">운송장 번호</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">Loading No.</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">발송인</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">전화번호</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">주소</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[5] . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">수취인</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                    <th class=\"active text-center\">전화번호</th>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">주소</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[8] . "</td>
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 2.품목정보

    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"30%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">품목정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">번호</th>
                    <th class=\"text-center\">품목</th>
                    <th class=\"text-center\">수량</th>
                    <th class=\"text-center\">비고</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수

    $content_array  =   explode("<td class=\"boxtitle\">비고</td>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);            
    $content_array3 =   explode("<tr bgcolor=\"#FFFFFF\" height=\"25\">", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    // echo "<br />" . $content_array3_count; exit;

    for ($i = 1; $i < $content_array3_count; $i++) {                    // 1~
        // echo "<br />" . $content_array3[$i]; exit;
        
        $text_temp = array();   // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array4 =   explode("</tr>", $content_array3[$i]);   
                     
        
        ////////////////////////////////////////////////////////////////////////////////
        // (1) 번호
        $content_array5 =   explode("<td class=\"linel2 ac\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[1]);
        
        // html중 text 데이터만 구함                            
        $text_temp[1] = get_html_to_text_data($content_array6[0]);
        // echo "<br />번호: " . $text_temp[1]; exit;
        

        ////////////////////////////////////////////////////////////////////////////////
        // (2) 품목
        $content_array5 =   explode("<td class=\"pl20\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[1]);
        
        // html중 text 데이터만 구함                            
        $text_temp[2] = get_html_to_text_data($content_array6[0]);
        // echo "<br />품목: " . $text_temp[2]; exit;


        ////////////////////////////////////////////////////////////////////////////////
        // (3) 수량
        $content_array5 =   explode("<td class=\"ac\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[1]);
        
        // html중 text 데이터만 구함                            
        $text_temp[3] = get_html_to_text_data($content_array6[0]);
        // echo "<br />수량: " . $text_temp[3]; exit;


        ////////////////////////////////////////////////////////////////////////////////
        // (4) 비고
        $content_array5 =   explode("<td class=\"ac\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[2]);   // *** $content_array5[2] => 2번째 나오는 비고 데이터
        
        // html중 text 데이터만 구함                            
        $text_temp[4] = get_html_to_text_data($content_array6[0]);
        // echo "<br />비고: " . $text_temp[4]; exit;
        
        $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td>" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>                    
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                                
                </tr>
        ";
        
    }
    
    ////////////////////////////////////////////////////////////////////////////////
    // 3. 처리 현황
    
    // 처리 현황
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
                    <th class=\"text-center\" colspan=\"4\">처리 현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">처리일시</th>
                    <th class=\"text-center\">현재위치</th>                    
                    <th class=\"text-center\">처리현황</th>                            
                    <th class=\"text-center\">상세설명</th>                          
                </tr>
            </thead>
            <tbody>
    ";
    
    $content_array  =   explode("<td class=\"boxtitle\">처리현황</td>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<td class=\"boxtitle\">상세설명</td>", $content_array2[0]);
    $content_array4 =   explode("<tr height=\"30\" bgcolor=\"#ffffff\">", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    for ($i = 1; $i < $content_array4_count; $i++) {
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
    
        $content_array5 =   explode("<td", $content_array4[$i]);
        
        // (1) 처리일시
        $content_array6 =   explode("</td>", $content_array5[1]);               // 1
        $content_array7 =   explode(">", $content_array6[0]);
        
        $text_temp[1]   =   get_html_to_text_data($content_array7[1]);
        // echo "<br />처리일시: " . $text_temp[1]; exit;

        // (2) 현재위치
        $content_array6 =   explode("</td>", $content_array5[3]);               // 3
        $content_array7 =   explode(">", $content_array6[0]);
        
        $text_temp[2]   =   get_html_to_text_data($content_array7[1]);
        // echo "<br />현재위치: " . $text_temp[2]; exit;
        
        // (3) 처리현황
        $content_array6 =   explode("</td>", $content_array5[5]);               // 5
        $content_array7 =   explode(">", $content_array6[0]);
        
        $text_temp[3]   =   get_html_to_text_data($content_array7[1]);
        // echo "<br />처리현황: " . $text_temp[3]; exit;
        
        // (4) 상세설명
        $content_array6 =   explode("</td>", $content_array5[7]);               // 7
        $content_array7 =   explode("10\">", $content_array6[0]);
        
        $text_temp[4]   =   get_html_to_text_data($content_array7[1]);
        // echo "<br />상세설명: " . $text_temp[4]; exit;
        
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                <td class=\"text-left\">" . $text_temp[4] . "</td>
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