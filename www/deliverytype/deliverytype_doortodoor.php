<?php

////////////////////////////////////////////////////////////////////////////////
// CJ대한통운

// 배송조회결과 구함 (CJ대한통운)
function get_result_deliverytracking_doortodoor($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // 보내는 분, 받는 분, 상품정보, 수량
    $content_array  =   explode("<caption class=\"hidden\">배송조회 조회 결과 표</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("조회된 데이터가 없습니다.", $content_array2[0]);
    
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
    
    
    

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 정상조회 결과
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.조회결과
    
    // 운송장번호
    $content_array  =   explode("<input type=\"hidden\" id=\"inv_no\" name=\"inv_no\" value=\"", $content_temp);
    $content_array2 =   explode("\"/>", $content_array[1]);            
    $inv_no         =   trim($content_array2[0]);
                
    // 보내는 분, 받는 분, 상품정보, 수량
    $content_array  =   explode("<caption class=\"hidden\">배송조회 조회 결과 표</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<th scope=\"col\" class=\"last\">수량</th>", $content_array2[0]);
    /*
    <td class="last_b">690052355203</td>
    <td class="last_b">로디*</td>
    <td class="last_b">주정*</td>
    <td class="last_b">데몬 글라스 1+1 아이폰6/6S플러스+투명/1개☞1개</td>
    <td class="last last_b">1</td>
    */
    $content_array4 =   explode("<td class=\"last", $content_array3[1]);            
    
    $content_array4_count   =   count($content_array4);
    
    $text_temp = array();       // 텍스트 데이터 저장할 배열 변수
    
    for ($i = 2; $i < $content_array4_count; $i++) {                    // 2~5
        // echo "<br />" . $content_array4[$i];
         
        $content_array5 =   explode("</td>", $content_array4[$i]);
        $content_array6 =   explode("\">", $content_array5[0]);
                       
        // html중 text 데이터만 구함                            
        $text_temp[$i] = get_html_to_text_data($content_array6[1]);                
    }
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"45%\" />
                <col width=\"10%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">조회결과</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">운송장번호</th>
                    <th class=\"text-center\">보내는 분</th>
                    <th class=\"text-center\">받는 분</th>
                    <th class=\"text-center\">상품정보</th>
                    <th class=\"text-center\">수량</th>                            
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=\"text-center\">" . $inv_no . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td>" . $text_temp[4] . "</td>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>                                
                </tr>
            </tbody>
        </table>
    ";  
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.상품상태 확인
    
    // 
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"55%\" />
                <col width=\"15%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">상품상태 확인</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">단계</th>
                    <th class=\"text-center\">처리</th>
                    <th class=\"text-center\">상품상태</th>
                    <th class=\"text-center\">담당 점소</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    // 단계, 처리, 상품상태, 담당 점소
    $content_array  =   explode("<table cellpadding=\"0\" cellspacing=\"0\" summary=\"상품상태 확인 표\" width=\"822px\" class=\"ptb10 mb15\">", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<th scope=\"col\" class=\"last\">담당 점소</th>", $content_array2[0]);
    /*
    <!-- 1) 상품상태 확인 데이터가 없을 경우 -->
	<tr>
        <td colspan="4" class="last_b">조회된 데이터가 없습니다.</td>
	</tr>
	
    <!-- 2) 상품상태 확인 데이터가 있을 경우 -->
	<tr>
		<td class="">상품인수</td>
		<td class="">2015-11-16 16:50</td>
		<td class="">보내시는 고객님으로부터 상품을 인수받았습니다</td>
		<td class="last ">
			<a href="javascript:checkDetail('5254');" title="영업소 정보 팝업">연수직영(이석호)</a>
		</td>
	</tr>
	<tr>
		<td class="">상품이동중</td>
		<td class="">2015-11-17 05:36</td>
		<td class="">배달지역으로 상품이 이동중입니다.</td>
		<td class="last ">
			<a href="javascript:checkDetail('V072');" title="영업소 정보 팝업">도척2CP</a>
		</td>
	</tr>
	*/
	
	
	// 1) 상품상태 확인 데이터가 없을 경우
	$content_array4 =   explode("조회된 데이터가 없습니다.", $content_array3[1]);
	
	$content_array4_count   =   count($content_array4);
	
	$text_temp = "조회된 상품상태 데이터가 없습니다.";                     // 1.조회결과는 있고 2.상품상태 확인데이터는 없는 경우
	
	if ($content_array4_count > 1) {
	    $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\" colspan=\"4\">" . $text_temp . "</td>
                </tr>
        ";
        
        $result_deliverytracking  .=  "
                </tbody>
            </table>
        ";
        
        return $result_deliverytracking;                                        // 빠져나감 : 1) 상품상태 확인 데이터가 없을 경우
    }
    
	
	
	// 2) 상품상태 확인 데이터가 있을 경우
    $content_array4 =   explode("<tr>", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    for ($i = 1; $i < $content_array4_count; $i++) {                    // 1~
        // echo "<br />" . $content_array4[$i];
        
        $text_temp = array();   // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array5 =   explode("</tr>", $content_array4[$i]);   
                     
        
        ////////////////////////////////////////////////////////////////////////////////
        // (1) 단계
        $content_array6 =   explode("<td class=\"", $content_array5[0]);
        $content_array7 =   explode("\">", $content_array6[1]);         // 1
        $content_array8 =   explode("</td>", $content_array7[1]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);
                        
        $text_temp[1]   =   trim($content_array8[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (2) 처리
        $content_array6 =   explode("<td class=\"", $content_array5[0]);
        $content_array7 =   explode("\">", $content_array6[2]);         // 2
        $content_array8 =   explode("</td>", $content_array7[1]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);
                        
        $text_temp[2]   =   trim($content_array8[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (3) 상품상태
        $content_array6 =   explode("<td class=\"", $content_array5[0]);
        $content_array7 =   explode("\">", $content_array6[3]);         // 3
        $content_array8 =   explode("</td>", $content_array7[1]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);
                        
        $text_temp[3]   =   trim($content_array8[0]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (4) 담당 점소
        $content_array6 =   explode("<td class=\"", $content_array5[0]);
        $content_array7 =   explode("title=\"집배점 정보 팝업\">", $content_array6[4]);            // 4
        $content_array8 =   explode("</a>", $content_array7[1]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);
                        
        $text_temp[4]   =   trim($content_array8[0]);
        
        
        $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td>" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                                
                </tr>
        ";
        
    }
    
    $result_deliverytracking  .=  "
            </tbody>
        </table>
    ";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 3.택배기사 정보
    
                
    // 보내는 분, 받는 분, 상품정보, 수량
    $content_array  =   explode("<caption class=\"hidden\">배달조회 조회 결과 표</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    /*
    <tr class="top">
        <th scope="col">택배기사</th>
        <td>박광표</td>
    </tr>
    <tr>
        <th scope="col">연락처</th>
        <td>010-4539-1726</td>
    </tr>
    <tr>
        <th scope="col">소속</th>
        <td>송파ASub</td>
    </tr>
    <tr>
        <th scope="col">Sub터미널</th>
        <td>송파A</td>
    </tr>
    <tr class="last_b">
        <th scope="col">지점</th>
        <td>송파지점</td>
    </tr>
    */
    $text_temp = array();       // 텍스트 데이터 저장할 배열 변수
    
    // (1) 택배기사
    $content_array3 =   explode("<th scope=\"col\">택배기사</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    // html중 text 데이터만 구함                            
    $text_temp[1] = get_html_to_text_data($content_array5[1]);
    
    
    // (2) 연락처
    $content_array3 =   explode("<th scope=\"col\">연락처</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    // html중 text 데이터만 구함                            
    $text_temp[2] = get_html_to_text_data($content_array5[1]);
    
    
    // (3) 소속
    $content_array3 =   explode("<th scope=\"col\">소속</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    // html중 text 데이터만 구함                            
    $text_temp[3] = get_html_to_text_data($content_array5[1]);
    
    
    // (4) Sub터미널
    $content_array3 =   explode("<th scope=\"col\">Sub터미널</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    // html중 text 데이터만 구함                            
    $text_temp[4] = get_html_to_text_data($content_array5[1]);
    
    
    // (5) 지점
    $content_array3 =   explode("<th scope=\"col\">지점</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    // html중 text 데이터만 구함                            
    $text_temp[5] = get_html_to_text_data($content_array5[1]);
                            
    
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
                    <th class=\"text-center\" colspan=\"5\">택배기사 정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">택배기사</th>
                    <th class=\"text-center\">연락처</th>
                    <th class=\"text-center\">소속</th>
                    <th class=\"text-center\">Sub터미널</th>
                    <th class=\"text-center\">지점</th>                            
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>                                
                </tr>
            </tbody>
        </table>
    ";

    return $result_deliverytracking;
}

?>