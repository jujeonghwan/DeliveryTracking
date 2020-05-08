<?php

////////////////////////////////////////////////////////////////////////////////
// 우체국택배

// 배송조회결과 구함 (우체국택배)
function get_result_deliverytracking_epost($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // 등기번호, 보내는분/발송날짜, 받는분/수신날짜, 취급구분, 배달완료
    $content_array  =   explode("<caption>배송조회 기본정보 테이블</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);            
    /*
    <tr>
	    <td colspan="5">
		    <li>현재 고객님이 신청하신 번호에 대하여 배달정보를 찾지 못했습니다.</li>
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
    <ul class="rescan">
        <li>검색결과: (총 0건 )</li>
        <li>
            <select name="searchKey" id="searchKey" title="검색방법선택">
                <option value="srchRNo" selected="selected">등기번호</option>
                <option value="srchRcvNm" >받는분</option>
            </select>
            <input type="text" name="searchWords" id="searchWords" value="" title="결과내검색어" /><input type="image" src="/iwww/images/comm/shipping/btn_rescan.gif" alt="결과내검색" />
        </li>
    </ul>
    */

    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("검색결과: (총 0건 )", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "현재 고객님이 신청하신 번호에 대하여 배달정보를 찾지 못했습니다.<br />정보가 아직 입력되지 않았거나 처리 중입니다.";
        
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
    // 1.기본정보
                
    // 등기번호, 보내는분/발송날짜, 받는분/수신날짜, 취급구분, 배달완료
    $content_array  =   explode("<caption>배송조회 기본정보 테이블</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("배달결과</th>", $content_array2[0]);
    /*
    <td>6899082239087</td>
	<td>브*스토리<br />2015.12.17</td>
	<td>최*실<br />2015.12.18</td>
	<td>&nbsp;</td>
	<td>배달완료</td>
    */

    $text_temp = array();       // 텍스트 데이터 저장할 배열 변수

    // (1) 등기번호
    $content_array4 =   explode("<th scope=\"row\">", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array5[0]);              // html중 text 데이터만 구함 


    // (2) 보내는분, (3) 발송날짜, (4) 받는분, (5) 수신날짜, (6) 취급구분, (7) 배달결과
    $content_array4 =   explode("<td>", $content_array3[1]);            
    
    $content_array4_count   =   count($content_array4);
    
    for ($i = 1; $i < $content_array4_count; $i++) {                    // 1~4
        // echo "<br />" . $content_array4[$i];

        $content_array5 =   explode("</td>", $content_array4[$i]);
         
        if ($i == 1) {                  // 보내는분/발송날짜
            $content_array6 =   explode("<br />", $content_array5[0]);
            
            $text_temp[2]   =   get_html_to_text_data($content_array6[0]);      // (2) 보내는분
            $text_temp[3]   =   get_html_to_text_data($content_array6[1]);      // (3) 발송날짜
        }
        else if ($i == 2) {             // 받는분/수신날짜
            $content_array6 =   explode("<br />", $content_array5[0]);
            
            $text_temp[4]   =   get_html_to_text_data($content_array6[0]);      // (4) 받는분
            $text_temp[5]   =   get_html_to_text_data($content_array6[1]);      // (5) 수신날짜
        }
        else if ($i == 3) {             // (6) 취급구분
            $text_temp[6]   =   get_html_to_text_data($content_array5[0]);      // html중 text 데이터만 구함
        }
        else if ($i == 4) {             // (7) 배달결과
            $text_temp[7]   =   get_html_to_text_data($content_array5[0]);      // html중 text 데이터만 구함
        }                
    }

    /*
    echo "<br /><br /><xmp>text_temp_1 : " . $text_temp[1] . "</xmp>";
    echo "<br /><br /><xmp>text_temp_2 : " . $text_temp[2] . "</xmp>";
    echo "<br /><br /><xmp>text_temp_3 : " . $text_temp[3] . "</xmp>";
    echo "<br /><br /><xmp>text_temp_4 : " . $text_temp[4] . "</xmp>";
    echo "<br /><br /><xmp>text_temp_5 : " . $text_temp[5] . "</xmp>";
    echo "<br /><br /><xmp>text_temp_6 : " . $text_temp[6] . "</xmp>";
    echo "<br /><br /><xmp>text_temp_7 : " . $text_temp[7] . "</xmp>";

    exit;
    */
    
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
                    <th class=\"text-center\">등기번호</th>
                    <th class=\"text-center\">보내는분</th>
                    <th class=\"text-center\">발송날짜</th>
                    <th class=\"text-center\">받는분</th>
                    <th class=\"text-center\">수신날짜</th>
                    <th class=\"text-center\">취급구분</th>
                    <th class=\"text-center\">배달결과</th>                        
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
    // 2.배송 진행상황
    
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
                    <th class=\"text-center\" colspan=\"4\">배송 진행상황</th>          
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
    $content_array  =   explode("<caption>배송진행현황 상세 표</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("처리현황</th>", $content_array2[0]);
    /*
    <tr>
        <td>2015.12.17</td>
        <td>17:51</td>
        <td><a href="#" onclick="return goPostDetail(70333, '접수', event)" onkeypress="return goPostDetail(70333, '접수', event)">영천</a></td>
        <td>접수<span class="tracered">&nbsp;</span></td>
    </tr>
    <tr>
        <td>2015.12.18</td>
        <td>15:01</td> 
        <td><a href="#" onclick="return goPostDetail(10122, '배달완료', event)" onkeypress="return goPostDetail(10122, '배달완료', event)">서울송파</a></td>
        <td>
		    배달완료
		    &nbsp;(<span class="tracered">&nbsp;배달&nbsp;</span>)
		    (수령인:최*실님 - 본인)
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
        // (1) 날짜
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[1]);       // 1
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[1]   =   trim($content_array7[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (2) 시간
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[2]);       // 2
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[2]   =   trim($content_array7[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (3) 현재위치
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[3]);       // 3
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[3]   =   trim($content_array7[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (4) 처리현황
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[4]);       // 4
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[4]   =   trim($content_array7[0]);
        
        
        $result_deliverytracking  .=  "
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
    
    return $result_deliverytracking;
}

?>