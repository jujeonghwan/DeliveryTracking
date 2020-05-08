<?php

////////////////////////////////////////////////////////////////////////////////
// CJ대한통운NPlus

// 배송조회결과 구함 (CJ대한통운NPlus)
function get_result_deliverytracking_doortodoornplus($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    // 조회결과
    $result_deliverytracking  =   "";

    // result_error
    $content_array          =   explode("(미등록운송장)", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    미등록운송장
    */
    
    if ($content_array_count > 1) {
        $text_temp = "해당 번호에 대한 배송정보가 없습니다. (미등록운송장)";
        
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


    // result_error
    $content_array          =   explode("(콘솔IN)", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    콘솔IN
    */
    
    if ($content_array_count > 1) {
        $text_temp = "해당 번호에 대한 배송정보가 없습니다. (콘솔IN)";
        
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
    // 1.조회결과
    
    // 운송장번호
    $content_array  =   explode("<b>운송장 번호 : ", $content_temp);
    $content_array2 =   explode("(", $content_array[1]);            
    $slipno         =   trim($content_array2[0]);
    // echo "<br />slipno : " . $slipno; exit;


    // 보내는 사람, 받는사람, 수량, 인수자
    /*
    <tr height=22 align=center bgcolor=#F6F6F6>
        <td> &nbsp;아*키&nbsp; </td>
        <td> &nbsp;조*선&nbsp; </td>
        <td> &nbsp;1&nbsp; </td>
        <td> &nbsp;경비실&nbsp; </td>
    </tr>
    */
    $content_array  =   explode("<td>인수자</td>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    for ($i = 1; $i < $content_array3_count; $i++) {                    // 1~4
        // echo "<br />" . $content_array3[$i];
         
        $content_array4 =   explode("</td>", $content_array3[$i]);
                       
        // html중 text 데이터만 구함                            
        $text_temp[$i] = get_html_to_text_data($content_array4[0]);                
    }
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">조회결과</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">운송장번호</th>
                    <th class=\"text-center\">보내는 사람</th>
                    <th class=\"text-center\">받는 사람</th>
                    <th class=\"text-center\">수량</th>
                    <th class=\"text-center\">인수자</th>                            
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=\"text-center\">" . $slipno . "</td>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                </tr>
            </tbody>
        </table>
    ";  
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.대리점 정보 & SM 정보
    
    // 구분, 대리점명, 대리점 전화번호, SM, SM 이동전화
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">대리점 정보 & SM 정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">구분</th>
                    <th class=\"text-center\">대리점명</th>
                    <th class=\"text-center\">대리점 전화번호</th>
                    <th class=\"text-center\">SM</th>                            
                    <th class=\"text-center\">SM 이동전화</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    /*
    <tr height=22 align=center bgcolor=#F6F6F6>
        <td>집하</td>
        <td>&nbsp;서울종암&nbsp;</td>
        <td>&nbsp;02-921-5917&nbsp;</td>
        <td>&nbsp;서현&nbsp;</td>
        <td>&nbsp;010-4458-3080&nbsp;</td>
    </tr>
    <tr height=22 align=center bgcolor=#F6F6F6>
        <td>배송</td>
        <td>&nbsp;충북음성북&nbsp;</td>
        <td>&nbsp;043-872-1255&nbsp;</td>
        <td>&nbsp;최미란&nbsp;</td>
        <td>&nbsp;010-7189-1637&nbsp;</td>
    </tr>
    */
    $content_array  =   explode("<td>SM 이동전화</td>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tr", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {        // 1~
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();   // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array4 =   explode("</tr>", $content_array3[$i]);   
                     
        
        ////////////////////////////////////////////////////////////////////////////////
        // (1) 구분
        $content_array5 =   explode("<td>", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[1]);               // 1
        
        // html중 text 데이터만 구함                            
        $text_temp[1] = trim(get_html_to_text_data($content_array6[0]));

        ////////////////////////////////////////////////////////////////////////////////
        // (2) 대리점명
        $content_array5 =   explode("<td>", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[2]);               // 2
        
        // html중 text 데이터만 구함                            
        $text_temp[2] = trim(get_html_to_text_data($content_array6[0]));

        ////////////////////////////////////////////////////////////////////////////////
        // (3) 대리점 전화번호
        $content_array5 =   explode("<td>", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[3]);               // 3
        
        // html중 text 데이터만 구함                            
        $text_temp[3] = trim(get_html_to_text_data($content_array6[0]));

        ////////////////////////////////////////////////////////////////////////////////
        // (4) SM
        $content_array5 =   explode("<td>", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[4]);               // 4
        
        // html중 text 데이터만 구함                            
        $text_temp[4] = trim(get_html_to_text_data($content_array6[0]));

        ////////////////////////////////////////////////////////////////////////////////
        // (5) SM 이동전화
        $content_array5 =   explode("<td>", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[5]);               // 5
        
        // html중 text 데이터만 구함                            
        $text_temp[5] = trim(get_html_to_text_data($content_array6[0]));
                
        
        $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                                
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                </tr>
        ";
        
    }
    
    $result_deliverytracking  .=  "
            </tbody>
        </table>
    ";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 3.상품추적 상태
                    
    // 일자, 시각, 대리점, 대리점 전화, 구분
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">대리점 정보 & SM 정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">일자</th>
                    <th class=\"text-center\">시각</th>
                    <th class=\"text-center\">대리점</th>
                    <th class=\"text-center\">대리점 전화</th>                            
                    <th class=\"text-center\">구분</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    /*
    <tr height=22 bgcolor=#F6F6F6>
        <td align=center>&nbsp;2016-11-16&nbsp;</td>
        <td align=center>&nbsp;13:43:46&nbsp;</td>
        <td align=center>
            <table>
                <tr>
                    <td width=140>&nbsp;충북음성북&nbsp;</td>
                    <td width=130>&nbsp;Tel : 충북음성북(043-872-1255)&nbsp;</td>
                </tr>
            </table>
        </td>
        <td align=center>&nbsp;배달완료&nbsp;</td>
    </tr>
    <tr height=22 bgcolor=#F6F6F6>
        <td align=center>&nbsp;2016-11-16&nbsp;</td>
        <td align=center>&nbsp;11:41:43&nbsp;</td>
        <td align=center>
            <table>
                <tr>
                    <td width=140>&nbsp;충북음성북&nbsp;</td>
                    <td width=130>&nbsp;Tel : 충북음성북(043-872-1255)&nbsp;</td>
                </tr>
            </table>
        </td>
        <td align=center>&nbsp;배달출발&nbsp;</td>
    </tr>
    */
    $content_array  =   explode("<td width=70>구 분</td>", $content_temp);
    $content_array2 =   explode("http://www.doortodoor.co.kr/", $content_array[1]);    
    $content_array3 =   explode("<tr height=22 bgcolor=#F6F6F6>", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    // for ($i = 1; $i < $content_array3_count; $i++) {        // 1~
    for ($i = ($content_array3_count - 1); $i >= 1; $i--) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();   // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array4 =   explode("<td", $content_array3[$i]);   
        
        ////////////////////////////////////////////////////////////////////////////////
        // (1) 일자
        $content_array5 =   explode("</td>", $content_array4[1]);               // 1
        $content_array6 =   explode("align=center>", $content_array5[0]);               
        
        // html중 text 데이터만 구함                            
        $text_temp[1] = trim(get_html_to_text_data($content_array6[1]));

        ////////////////////////////////////////////////////////////////////////////////
        // (2) 시각
        $content_array5 =   explode("</td>", $content_array4[2]);               // 2
        $content_array6 =   explode("align=center>", $content_array5[0]);               
        
        // html중 text 데이터만 구함                            
        $text_temp[2] = trim(get_html_to_text_data($content_array6[1]));

        ////////////////////////////////////////////////////////////////////////////////
        // (3) 대리점
        $content_array5 =   explode("</td>", $content_array4[4]);               // 4
        $content_array6 =   explode("width=140>", $content_array5[0]);               
        
        // html중 text 데이터만 구함                            
        $text_temp[3] = trim(get_html_to_text_data($content_array6[1]));

        ////////////////////////////////////////////////////////////////////////////////
        // (4) 대리점 전화
        $content_array5 =   explode("</td>", $content_array4[5]);               // 5
        $content_array6 =   explode("width=130>", $content_array5[0]);               
        
        // html중 text 데이터만 구함                            
        $text_temp[4] = trim(get_html_to_text_data($content_array6[1]));

        ////////////////////////////////////////////////////////////////////////////////
        // (5) 구분
        $content_array5 =   explode("</td>", $content_array4[6]);               // 6
        $content_array6 =   explode("align=center>", $content_array5[0]);
        
        // html중 text 데이터만 구함                            
        $text_temp[5] = trim(get_html_to_text_data($content_array6[1]));
                
        
        $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                                
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                </tr>
        ";
        
    }
    
    $result_deliverytracking  .=  "
            </tbody>
        </table>
    ";

    return $result_deliverytracking;
}

?>