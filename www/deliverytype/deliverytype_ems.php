<?php

////////////////////////////////////////////////////////////////////////////////
// EMS국제우편(국제)

// 배송조회결과 구함 (EMS국제우편)
function get_result_deliverytracking_ems($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("정보가 아직 입력되지 않았거나 처리 중입니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    정보가 아직 입력되지 않았거나 처리 중입니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "정보가 아직 입력되지 않았거나 처리 중입니다.";
        
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
    
    // 등기번호, 보내는분/발송날짜, 받는분/수신날짜, 취급구분, 배달완료
    $content_array  =   explode("<caption>배송조회 기본정보 테이블</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);            
    /*
    <tr>
	    <td colspan="5">
		    <li>현재 고객님이 신청하신 접수번호에 대하여 배달정보를 찾지 못했습니다.</li>
            <li>정보가 아직 입력되지 않았거나 처리 중입니다. 아래의 전화로 문의하여 주시면 감사 하겠습니다.</li>
	    </td>
    </tr>
    */
    $content_array3 =   explode("정보가 아직 입력되지 않았거나 처리 중입니다.", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    if ($content_array3_count > 1) {
        $content_array3 =   explode("<td colspan=\"5\">", $content_array2[0]);
        $content_array4 =   explode("</td>", $content_array3[1]);
        
         // html중 text 데이터만 구함                            
        $text_temp = get_html_to_text_data($content_array4[0]);    
        
        
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


    /*
    <caption>배송조회 기본정보 테이블</caption>
    */

    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("<caption>배송조회 기본정보 테이블</caption>", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count <= 1) {                        // 해당 텍스트가 없을 경우
        $text_temp = "우편물번호를 다시 확인하세요.";
        
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
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.배달요약정보
                
    // EMS(등기)번호, 발송인/발송날짜, 수신인/수신날짜, 배달단계, 서비스종류
    $content_array  =   explode("<caption>배송조회 기본정보 테이블</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode(">서비스 종류</th>", $content_array2[0]);
    /*
	<tr>
		<td>RI851019379CN</td>
		<td><br />2016-02-25</td>
		<td><br />2016-03-03</td>
<!--
		<td>배달완료2016.03.03</td>
-->
		<td>배달완료</td>
		<td>국제등기</td>
	</tr>
    */
        
    $text_temp = array();       // 텍스트 데이터 저장할 배열 변수
        
    
    // (1) EMS(등기)번호
    $content_array4 =   explode("</th>", $content_array3[1]);
    $content_array5 =   explode("<th scope=\"row\">", $content_array4[0]);
    $text_temp[1]   =   trim($content_array5[1]);
    // echo "<br />EMS(등기)번호 : " . $text_temp[1]; exit;
        
    
    $content_array4 =   explode("<td>", $content_array3[1]);            
    
    $content_array4_count   =   count($content_array4);
    
    for ($i = 1; $i < $content_array4_count; $i++) {                    // 1~6
        // echo "<br />" . $content_array4[$i];
         
        $content_array5 =   explode("</td>", $content_array4[$i]);
        
        if ($i == 1) {     // 발송인/발송날짜
            $content_array6 =   explode("<br />", $content_array5[0]);
            
            $text_temp[2]   =   get_html_to_text_data($content_array6[0]);                  // (2) 발송인
            $text_temp[3]   =   get_html_to_text_data($content_array6[1]);                  // (3) 발송날짜
        }
        else if ($i == 2) {     // 수신인/수신날짜
            $content_array6 =   explode("<br />", $content_array5[0]);
            
            $text_temp[4]   =   get_html_to_text_data($content_array6[0]);                  // (4) 수신인
            $text_temp[5]   =   get_html_to_text_data($content_array6[1]);                  // (5) 수신날짜
        }
        else if ($i == 3) {     // (6) 배달단계
            $text_temp[6]   =   get_html_to_text_data($content_array5[0]);                  // html중 text 데이터만 구함
        }
        else if ($i == 4) {     // (7) 서비스종류
            $text_temp[7]   =   get_html_to_text_data($content_array5[0]);                  // html중 text 데이터만 구함
        }                
    }
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"10%\" />
                <col width=\"15%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"7\">조회결과</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">EMS(등기)번호</th>
                    <th class=\"text-center\">발송인</th>
                    <th class=\"text-center\">발송날짜</th>
                    <th class=\"text-center\">수신인</th>
                    <th class=\"text-center\">수신날짜</th>
                    <th class=\"text-center\">배달단계</th>
                    <th class=\"text-center\">서비스종류</th>                        
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
                    <td class=\"text-center\">" . $text_temp[7] . "</td>
                </tr>
            </tbody>
        </table>
    ";  
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.배송진행현황
    
    // 
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"30%\" />
                <col width=\"40%\" />
                
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">배송진행현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">처리일시</th>
                    <th class=\"text-center\">처리현황</th>
                    <th class=\"text-center\">우체국(PostOffice)</th>
                    <th class=\"text-center\">상세설명</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    // 날짜, 시간, 현재위치, 처리현황
    $content_array  =   explode("<caption>배송진행현황 상세 표</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<th scope=\"col\">처리현황</th>", $content_array2[0]);
    /*
    <tr>
        <td>2016.02.25 10:14</td>              
        <td>&nbsp;접수</td>              
        <td>52311206</td>        
        <td class="txtL">&nbsp;접수우체국우편번호 :  
        52311206
        
        <br />&nbsp;접수우체국전화번호 : 
        <br />&nbsp;중계국 또는 도착국가 : 대한민국(KR)
        
        </td>
    </tr>
    
    <tr>
        <td>2016.02.25 15:35</td>              
        <td>&nbsp;발송준비</td>              
        <td>CNCANA</td>
        
        <td class="txtL">
          &nbsp;발송국 : CNCANA<br />
        
                     &nbsp;도착예정 교환국 : KRSELB(서울국제)<br />    
        
        
        &nbsp;발송횟수 : 314
        </td>
    </tr>

    <tr>
        <td>2016.02.29 15:23</td>              
        <td>&nbsp;교환국 도착</td>              
        <td>국제우편물류센터</td>
        
        <td class="txtL">&nbsp;</td>    
    </tr>

    <tr>
        <td>2016.02.29 22:27</td>              
        <td>&nbsp;발송</td>              
        <td>국제우편물류센터</td>
        
        <td class="txtL">&nbsp;</td>        
    </tr>

    <tr>
        <td>2016.02.29 23:40</td>              
        <td>&nbsp;도착</td>              
        <td>동서울우편집중국</td>
        
        <td class="txtL">&nbsp;</td>    
    </tr>

    <tr>
        <td>2016.03.01 06:05</td>              
        <td>&nbsp;발송</td>              
        <td>동서울우편집중국</td>
        
        <td class="txtL">&nbsp;</td>    
    </tr>

    <tr>
        <td>2016.03.01 06:44</td>              
        <td>&nbsp;도착</td>              
        <td>서울중앙</td>
        
        <td class="txtL">&nbsp;</td>    
    </tr>

    <tr>
        <td>2016.03.02 11:21</td>              
        <td>&nbsp;배달준비</td>              
        <td>서울중앙</td>
        
        <td class="txtL">&nbsp;</td>        
    </tr>

    <tr>
        <td>2016.03.03 10:36</td>              
        <td>&nbsp;배달완료</td>              
        <td>서울중앙</td>
        
        <td class="txtL">
        &nbsp;배달우체국전화번호 : 02-6450-1114<br /> &nbsp;수령인 : 김*영(회사동료)<br /> &nbsp;배달결과 : 배달완료<br />
        <!--
        &nbsp;배달우체국전화번호 : 02-6450-1114<br />
        &nbsp;수취인 우편번호 : <br />
        &nbsp;수령인 : 김*영(회사동료)<br />
        &nbsp;배달결과 : 배달완료
        -->
        
        </td>    
    </tr>
	*/
    $content_array4 =   explode("<tr>", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    for ($i = 1; $i < $content_array4_count; $i++) {                    // 1~
        // echo "<br />" . $content_array4[$i];
        
        $text_temp = array();   // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array5 =   explode("</tr>", $content_array4[$i]);   
                     
        
        ////////////////////////////////////////////////////////////////////////////////
        // (1) 처리일시
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[1]);               // 1
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[1]   =   trim($content_array7[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (2) 처리현황
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[2]);               // 2
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[2]   =   trim($content_array7[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (3) 우체국(PostOffice)
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[3]);               // 3
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[3]   =   trim($content_array7[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (4) 상세설명
        $content_array6 =   explode("<td class=\"txtL\">", $content_array5[0]);         
        $content_array7 =   explode("</td>", $content_array6[1]);
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[4]   =   trim($content_array7[0]);
        
        
        $result_deliverytracking  .=  "
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
    
    return $result_deliverytracking;
}

?>