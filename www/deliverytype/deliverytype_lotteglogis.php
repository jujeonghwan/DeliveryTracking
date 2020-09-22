<?php

////////////////////////////////////////////////////////////////////////////////
// 롯데택배

// 배송조회결과 구함 (롯데택배)
function get_result_deliverytracking_lotteglogis($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    
    // result_error
    $content_array          =   explode("해당 번호에 대한 배송정보가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    해당 번호에 대한 배송정보가 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "해당 번호에 대한 배송정보가 없습니다.";
        
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
    $content_array          =   explode("조회결과가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    조회결과가 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "조회결과가 없습니다.";
        
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
    $content_array          =   explode("화물추적 내역이 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    화물추적 내역이 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "화물추적 내역이 없습니다.";
        
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
                
    // 운송장번호 발송지 도착지 배달결과

    // 국내택배
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    
    // (1) 운송장번호
    $content_array  =   explode("<table class=\"tblH mt60\">", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);                       
    $content_array5 =   explode("<td>", $content_array4[0]);                    // 0
    $text_temp[1]   =   trim($content_array5[1]);
    // echo "<br />운송장번호 : " . $text_temp[1]; exit;
    
    // (2) 발송지    
    $content_array5 =   explode("<td>", $content_array4[1]);                    // 1
    $text_temp[2]   =   trim($content_array5[1]);
    // echo "<br />발송지 : " . $text_temp[2]; exit;
    
    // (3) 도착지
    $content_array5 =   explode("<td>", $content_array4[2]);                    // 2
    $text_temp[3]   =   trim($content_array5[1]);
    // echo "<br />도착지 : " . $text_temp[3]; exit;
    
    // (4) 배달결과
    $content_array5 =   explode("<td>", $content_array4[3]);                    // 3
    $text_temp[4]   =   trim($content_array5[1]);
    // echo "<br />배달결과 : " . $text_temp[4]; exit;
        
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
                    <th class=\"text-center\" colspan=\"4\">기본정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">운송장번호</th>
                    <th class=\"active text-center\">발송지</th>
                    <th class=\"active text-center\">도착지</th>
                    <th class=\"active text-center\">배달결과</th>
                </tr>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>                    
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
            </tbody>
        </table>
    "; 

    ////////////////////////////////////////////////////////////////////////////////
    // 2.처리현황
    
    // 처리현황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"20%\" />
                <col width=\"50%\" />  
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">처리현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">단계</th>
                    <th class=\"text-center\">시간</th>                    
                    <th class=\"text-center\">현재위치</th>                            
                    <th class=\"text-center\">처리현황</th>                          
                </tr>
            </thead>
            <tbody>
    ";
    
    // 단계, 시간, 현재위치, 처리현황
    $content_array  =   explode("<th scope=\"col\">처리현황</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    
    $content_array3 =   explode("<tr>", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        /*                     
        echo "<br /><br /><br />";
        echo "<xmp>";        
        echo $content_array3[0];
        echo "</xmp>";
        */
                
        $content_array4 =   explode("<td", $content_array3[$i]);   
        
        // (1) 단계
        $content_array5 =   explode("</td>", $content_array4[1]);               // 1
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[1]   =   get_html_to_text_data($content_array6[1]);
        
        // (2) 시간
        $content_array5 =   explode("</td>", $content_array4[2]);               // 2        
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[2]   =   get_html_to_text_data($content_array6[1]);
        
        // (3) 현재위치
        $content_array5 =   explode("</td>", $content_array4[3]);               // 3
        $content_array5[0]  =   strip_tags($content_array5[0]);                 // 태그를 제거 (<a href="#" onClick="javascript:PickDlvTelInfo('송파석촌대리점','02-2251-2100','53072269')"> </a>)
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[3]   =   get_html_to_text_data($content_array6[1]);
        
        // (4) 처리현황
        $content_array5 =   explode("</td>", $content_array4[4]);               // 4
        $content_array6 =   explode("class=\"tl\">", $content_array5[0]);
        
        $text_temp[4]   =   get_html_to_text_data($content_array6[1]);
                
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

////////////////////////////////////////////////////////////////////////////////
// 롯데택배의 경우에는 임시로 <iframe>으로 처리 (2018.12.04)

// 배송조회결과 구함 (롯데택배) 
function get_result_deliverytracking_lotteglogis_20200921($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    
    // result_error
    $content_array          =   explode("해당 번호에 대한 배송정보가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    해당 번호에 대한 배송정보가 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "해당 번호에 대한 배송정보가 없습니다.";
        
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
                
    // 운송장번호 발송지 도착지 배달결과

    /*
    <iframe src="https://www.lotteglogis.com/open/tracking?invno=305854318232" width="500px" height="500px" seamless="seamless"></iframe>
    */
    
    
    // 국내택배
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    
    // (1) 운송장번호
    $content_array  =   explode("https://www.lotteglogis.com/open/tracking?invno=", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[1]   =   trim($content_array2[0]);
    // echo "<br />운송장번호 : " . $text_temp[1]; exit;
    
    // (2) 배달결과
    $text_temp[2]   =   "상세내역 참고";
    // echo "<br />배달결과 : " . $text_temp[2]; exit;
    
    
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
                    <th class=\"text-center\" colspan=\"4\">기본정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">운송장번호</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td> 
                    <th class=\"active text-center\">배달결과</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>  
                </tr>
            </tbody>
        </table>
    "; 

    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.처리현황
    
    // 처리현황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"100%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\">처리현황</th>          
                </tr>
            </thead>
            <tbody>
    ";

    $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . $content_temp . "</td>
            </tr>
    ";    
    
    $result_deliverytracking  .=  "
            </tbody>
        </table>
    ";
    
    /*
    echo "<xmp>";
    echo $result_deliverytracking;
    echo "</xmp>";
    exit;
    */
    
    return $result_deliverytracking;
}


// 배송조회결과 구함 (롯데택배)
function get_result_deliverytracking_lotteglogis_20181204($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    
    // result_error
    $content_array          =   explode("해당 번호에 대한 배송정보가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    해당 번호에 대한 배송정보가 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "해당 번호에 대한 배송정보가 없습니다.";
        
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
    $content_array          =   explode("조회결과가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    조회결과가 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "조회결과가 없습니다.";
        
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
                
    // 운송장번호 발송지 도착지 배달결과

    /*
    <table class="table_02">
        <colgroup>
            <col width="25%" />
            <col width="25%" />
            <col width="25%" />
            <col width="" />
        </colgroup>
        <tr>
            <th>운송장번호</th>
            <th>발송지</th>
            <th>도착지</th>
            <th class="bg_no">배달결과</th>
        </tr>
        <tr class="bot">            
            <td class="left">225100323652</td>
            <td>신원주(대)</td>
            <td>송파석촌(대)</td>
            <td>일반배달</td>                
        </tr>
    </table>
    
    <!-- 국제택배 화물추적 -->
    <div class="mat_30">
        <table class="table_02">
            <colgroup>
                <col width="33%" />
                <col width="33%" />
                <col width="33%" />
            </colgroup>
            <tr>
                <th>오더번호</th>
                <th>운송장번호</th>
                <th class="bg_no">배달결과</th>
            </tr>
            <tr class="bot">
                <td class="left">301248277551</td>
                <td>301248277551</td>
                <td>배달전</td>
            </tr>
        </table>
    </div>
    */
    
    
    // 국내택배
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    
    // (1) 운송장번호
    $content_array  =   explode("<th class=\"bg_no\">배달결과</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tr class=\"bot\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);                   
    $content_array5 =   explode("<td class=\"left\">", $content_array4[0]);     // 0
    $text_temp[1]   =   trim($content_array5[1]);
    // echo "<br />운송장번호 : " . $text_temp[1]; exit;
    
    // (2) 발송지
    $content_array  =   explode("<th class=\"bg_no\">배달결과</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tr class=\"bot\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[1]);                    // 1
    $text_temp[2]   =   trim($content_array5[1]);
    // echo "<br />발송지 : " . $text_temp[2]; exit;
    
    // (3) 도착지
    $content_array  =   explode("<th class=\"bg_no\">배달결과</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tr class=\"bot\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[2]);                    // 2
    $text_temp[3]   =   trim($content_array5[1]);
    // echo "<br />도착지 : " . $text_temp[3]; exit;
    
    // (4) 배달결과
    $content_array  =   explode("<th class=\"bg_no\">배달결과</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tr class=\"bot\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[2]);                    // 3
    $text_temp[4]   =   trim($content_array5[1]);
    // echo "<br />배달결과 : " . $text_temp[4]; exit;
    
    
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
                    <th class=\"text-center\" colspan=\"4\">기본정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">운송장번호</th>
                    <th class=\"active text-center\">발송지</th>
                    <th class=\"active text-center\">도착지</th>
                    <th class=\"active text-center\">배달결과</th>
                </tr>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>                    
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
            </tbody>
        </table>
    "; 


    /* 국제택배 일 경우 
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    
    // (1) 운송장번호
    $content_array  =   explode("<th class=\"bg_no\">배달결과</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tr class=\"bot\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[1]);
    $text_temp[1]   =   trim($content_array5[1]);
    // echo "<br />운송장번호 : " . $text_temp[1]; exit;
    
    // (2) 오더번호
    $content_array  =   explode("<th class=\"bg_no\">배달결과</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tr class=\"bot\">", $content_array2[0]);
    $content_array4 =   explode("<td class=\"left\">", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);
    $text_temp[2]   =   trim($content_array5[0]);
    // echo "<br />오더번호 : " . $text_temp[2]; exit;
    
    // (3) 보내시는 분 이름
    $content_array  =   explode("<th><span>보내시는 분</span></th>", $content_temp);
    $content_array2 =   explode("<strong>이름</strong>", $content_array[1]);
    $content_array3 =   explode("</span>", $content_array2[1]);
    $content_array4 =   explode("<span class=\"mid_span\">", $content_array3[0]);
    $text_temp[3]   =   trim($content_array4[1]);
    // echo "<br />보내시는 분 이름 : " . $text_temp[3]; exit;
    
    // (4) 보내시는 분 주소
    $content_array  =   explode("<th><span>보내시는 분</span></th>", $content_temp);
    $content_array2 =   explode("<strong>주소</strong>", $content_array[1]);
    $content_array3 =   explode("</span>", $content_array2[1]);
    $content_array4 =   explode("<span>", $content_array3[0]);
    $text_temp[4]   =   trim($content_array4[1]);
    // echo "<br />보내시는 분 주소 : " . $text_temp[4]; exit;
    
    // (5) 받으시는 분 이름
    $content_array  =   explode("<th><span>받으시는 분</span></th>", $content_temp);
    $content_array2 =   explode("<strong>이름</strong>", $content_array[1]);
    $content_array3 =   explode("</span>", $content_array2[1]);
    $content_array4 =   explode("<span class=\"mid_span\">", $content_array3[0]);
    $text_temp[5]   =   trim($content_array4[1]);
    // echo "<br />받으시는 분 이름 : " . $text_temp[5]; exit;
    
    // (6) 받으시는 분 주소
    $content_array  =   explode("<th><span>받으시는 분</span></th>", $content_temp);
    $content_array2 =   explode("<strong>주소</strong>", $content_array[1]);
    $content_array3 =   explode("</span>", $content_array2[1]);
    $content_array4 =   explode("<span>", $content_array3[0]);
    $text_temp[6]   =   trim($content_array4[1]);
    // echo "<br />받으시는 분 주소 : " . $text_temp[6]; exit;
    
    // (7) 배달결과
    $content_array  =   explode("<th class=\"bg_no\">배달결과</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tr class=\"bot\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[2]);
    $text_temp[7]   =   trim($content_array5[1]);
    // echo "<br />배달결과 : " . $text_temp[7]; exit;
    
    
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
                    <th class=\"text-center\" colspan=\"4\">기본정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">운송장번호</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">오더번호</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">보내시는 분</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">주소</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">받으시는 분</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <th class=\"active text-center\">주소</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">배달결과</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[7] . "</td>                         
                </tr>
            </tbody>
        </table>
    "; 
    */

    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.처리현황
    
    // 처리현황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"20%\" />
                <col width=\"50%\" />  
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">처리현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜</th>
                    <th class=\"text-center\">시간</th>                    
                    <th class=\"text-center\">현재위치</th>                            
                    <th class=\"text-center\">처리현황</th>                          
                </tr>
            </thead>
            <tbody>
    ";
    
    // 날짜, 시간, 현재위치, 처리현황
    $content_array  =   explode("<th class=\"bg_no\">처리현황</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    /*
    <table class="table_02">
        <colgroup>
            <col width="136px" />
            <col width="126px" />
            <col width="160px" />
            <col width="" />
        </colgroup>
        <tr>
            <th>날짜</th>
            <th>시간</th>
            <th>현재위치</th>
            <th class="bg_no">처리현황</th>
        </tr>
        
        <tr>
            <td class="left">2016.02.11</td>
            <td>--:--</td>
            <td>
                        <a href="#" onClick="javascript:BrnshpInfo('신원주대리점','033-763-9598')">신원주대리점</a>
                    </td>
            <td class="left_a">
                <p></p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.11</td>
            <td>17:36</td>
            <td>
                        <a href="#" onClick="javascript:PickDlvTelInfo('신원주대리점','033-763-9598','59006202')">신원주대리점</a>
                    </td>
            <td class="left_a">
                <p>물품을 보내셨습니다.</p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.11</td>
            <td>19:04</td>
            <td>
                        <a href="#" onClick="javascript:BrnshpInfo('원주지점','033-766-3355')">원주지점</a>
                    </td>
            <td class="left_a">
                <p>대전터미널(으)로 출발하였습니다.</p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.11</td>
            <td>22:44</td>
            <td>
                        <a href="#" onClick="javascript:BrnshpInfo('대전터미널','042-634-2607')">대전터미널</a>
                    </td>
            <td class="left_a">
                <p>원주지점에서 도착하였습니다.</p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.11</td>
            <td>22:50</td>
            <td>
                        <a href="#" onClick="javascript:BrnshpInfo('대전터미널','042-634-2607')">대전터미널</a>
                    </td>
            <td class="left_a">
                <p>동남권터미널(으)로 출발하였습니다.</p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.12</td>
            <td>05:11</td>
            <td>
                        <a href="#" onClick="javascript:BrnshpInfo('동남권터미널','02-2251-0021')">동남권터미널</a>
                    </td>
            <td class="left_a">
                <p>대전터미널에서 도착하였습니다.</p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.12</td>
            <td>06:05</td>
            <td>
                        <a href="#" onClick="javascript:BrnshpInfo('동남권터미널','02-2251-0021')">동남권터미널</a>
                    </td>
            <td class="left_a">
                <p>송파석촌대리점(으)로 출발하였습니다.</p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.12</td>
            <td>12:09</td>
            <td>
                        <a href="#" onClick="javascript:PickDlvTelInfo('송파석촌대리점','02-2251-2100','53072269')">송파석촌대리점</a>
                    </td>
            <td class="left_a">
                <p>고객님께 배달 준비중 입니다.<br>(배송담당: 엄기원 010-2584-5072)</p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.12</td>
            <td>19:00</td>
            <td>
                        <a href="#" onClick="javascript:PickDlvTelInfo('송파석촌대리점','02-2251-2100','53072269')">송파석촌대리점</a>
                    </td>
            <td class="left_a">
                <p>배달 완료하였습니다.<br>(배송담당: 엄기원 010-2584-5072)</p>
            </td>
        </tr>
    
        <tr>
            <td class="left">2016.02.12</td>
            <td>--:--</td>
            <td>고객</td>
            <td class="left_a">
                <p>물품을 받으셨습니다.</p>
            </td>
        </tr>
        
    </table>
    */
    $content_array3 =   explode("<tr", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        /*                     
        echo "<br /><br /><br />";
        echo "<xmp>";        
        echo $content_array3[0];
        echo "</xmp>";
        */
                
        $content_array4 =   explode("<td", $content_array3[$i]);   
        
        // (1) 날짜
        $content_array5 =   explode("</td>", $content_array4[1]);               // 1
        $content_array6 =   explode("class=\"left\">", $content_array5[0]);
        
        $text_temp[1]   =   get_html_to_text_data($content_array6[1]);
        
        // (2) 시간
        $content_array5 =   explode("</td>", $content_array4[2]);               // 2        
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[2]   =   get_html_to_text_data($content_array6[1]);
        
        // (3) 현재위치
        $content_array5 =   explode("</td>", $content_array4[3]);               // 3
        $content_array5[0]  =   strip_tags($content_array5[0]);                 // 태그를 제거 (<a href="#" onClick="javascript:PickDlvTelInfo('송파석촌대리점','02-2251-2100','53072269')"> </a>)
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[3]   =   get_html_to_text_data($content_array6[1]);
        
        // (4) 처리현황
        $content_array5 =   explode("</td>", $content_array4[4]);               // 4
        $content_array6 =   explode("class=\"left_a\">", $content_array5[0]);
        
        $text_temp[4]   =   get_html_to_text_data($content_array6[1]);
                
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