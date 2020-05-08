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
    $content_array          =   explode("운송장번호가 일치하지 않습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    운송장번호가 일치하지 않습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "운송장번호가 일치하지 않습니다.";
        
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
    <table class="order_tb_result" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>발송영업소</font></th>
                <td width="265" bgcolor='#ffffff'>김포월곶고양115</td>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>도착영업소</font></th>
                <td width="265" bgcolor='#ffffff'>서울송파마천11</td>
            </tr>
			<tr>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>발송영업소tel</font></th>
                <td width="265" bgcolor='#ffffff'>031-997-8288</td>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>도착영업소tel </font></th>
                <td width="265"bgcolor='#ffffff'>02-406-8790</td>
            </tr>
			<tr>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>보낸분</font></th>
                <td width="265" bgcolor='#ffffff' >민***</td>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>받는분</font></th>
                <td width="265" bgcolor='#ffffff' >최***</td>
            </tr>
			<tr>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>보낸분tel</font></th>
                <td width="265" bgcolor='#ffffff'>&nbsp;</td>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>받는분tel</font></th>
                <td width="265" bgcolor='#ffffff'>0504-***</td>
            </tr>
            <tr>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>보낸분주소</font></th>
                <td width="265" bgcolor='#ffffff'> ***</td>
                <td width="100" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
				color='#000000'>받는분주소</font></th>
                <td width="265" bgcolor='#ffffff'>***</td>
            </tr>
    </table>
    */
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 발송영업소
    $content_array  =   explode("color='#000000'>발송영업소</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff'>", $content_array2[0]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array3[1]);              // html중 text 데이터만 구함
    
    // (2) 도착영업소
    $content_array  =   explode("color='#000000'>도착영업소</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff'>", $content_array2[0]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array3[1]);
    
    // (3) 발송영업소tel
    $content_array  =   explode("color='#000000'>발송영업소tel</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff'>", $content_array2[0]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array3[1]);
    
    // (4) 도착영업소tel
    $content_array  =   explode("color='#000000'>도착영업소tel </font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\"bgcolor='#ffffff'>", $content_array2[0]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array3[1]);
    
    // (5) 보낸분
    $content_array  =   explode("color='#000000'>보낸분</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff' >", $content_array2[0]);
    
    $text_temp[5]   =   get_html_to_text_data($content_array3[1]);
    
    // (6) 받는분
    $content_array  =   explode("color='#000000'>받는분</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff' >", $content_array2[0]);
    
    $text_temp[6]   =   get_html_to_text_data($content_array3[1]);
    
    // (7) 보낸분tel
    $content_array  =   explode("color='#000000'>보낸분tel</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff'>", $content_array2[0]);
    
    $text_temp[7]   =   get_html_to_text_data($content_array3[1]);
    
    // (8) 받는분tel
    $content_array  =   explode("color='#000000'>받는분tel</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff'>", $content_array2[0]);
    
    $text_temp[8]   =   get_html_to_text_data($content_array3[1]);
    
    // (9) 보낸분주소
    $content_array  =   explode("color='#000000'>보낸분주소</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff'>", $content_array2[0]);
    
    $text_temp[9]   =   get_html_to_text_data($content_array3[1]);
    
    // (10) 받는분주소
    $content_array  =   explode("color='#000000'>받는분주소</font></th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"265\" bgcolor='#ffffff'>", $content_array2[0]);
    
    $text_temp[10]   =   get_html_to_text_data($content_array3[1]);
    
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
                <tr>
                    <th class=\"text-center active\">보낸분tel</th>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>
                    <th class=\"text-center active\">받는분tel</th>
                    <td class=\"text-center\">" . $text_temp[8] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">보낸분주소</th>
                    <td class=\"text-center\">" . $text_temp[9] . "</td>
                    <th class=\"text-center active\">받는분주소</th>
                    <td class=\"text-center\">" . $text_temp[10] . "</td>
                </tr>
            </tbody>
        </table>
    ";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.기본정보
                
    // 발송일 운송장번호 운송구분 물품명 포장 수량

    /*
    <table class="order_tb_result" width="100%" border="0" cellpadding="0" cellspacing="0">
                                    
            <tr>
    		    <td width="182" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
    			color='#000000'>발송일</font></th>
                <td width="182"bgcolor='#FFD700'>&nbsp;&nbsp;<font 
    			color='#000000'>운송장번호</font></th>
                <td width="182" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
    			color='#000000'>운송구분</font></th>
    			<td width="182" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
    			color='#000000'>물품명</font></th>
                <td width="182" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
    			color='#000000'>포장</font></th>
                <td width="184" bgcolor='#FFD700'>&nbsp;&nbsp;<font 
    			color='#000000'>수량</font></th>
            </tr>
            <tr>
                <td class="center" bgcolor='#ffffff'>2016-01-05</td>
                <td class="center" bgcolor='#ffffff'>20924162010510</td>
    			<td class="center" bgcolor='#ffffff'>택현</td>
    			<td class="center" bgcolor='#ffffff'>[델키포트]</td>
                <td class="center" bgcolor='#ffffff'>박스</td>
                <td class="center" bgcolor='#ffffff'>1</td>
            </tr>
        </tbody>
    </table>
    */
    
    $content_array  =   explode("color='#000000'>수량</font></th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<td class=\"center\" bgcolor='#ffffff'>", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    for ($i = 1; $i < $content_array3_count; $i++) {        // 1~6
        // echo "<br />" . $content_array3[$i];
         
        $content_array4 =   explode("</td>", $content_array3[$i]);
                       
        // html중 text 데이터만 구함                            
        $text_temp[$i] = get_html_to_text_data($content_array4[0]);                
    }
    
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
    $content_array  =   explode("color='#000000'>처리현황</font></th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    /*
    <table class="order_tb_result" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td width="120" bgcolor='#FFD700'><font 
				color='#000000'>날짜</font></th>
                <td width="200" bgcolor='#FFD700'><font 
				color='#000000'>처리점소</font></th>
                <td width="120" bgcolor='#FFD700'><font 
				color='#000000'>연락처</font></th>
                <td width="290" bgcolor='#FFD700'><font 
				color='#000000'>처리현황</font></th>
            </tr>
			
            <tr>
                <td class="center">2016-01-05 14:53</td>
                <td class="center">김포월곶고양115</td>
    		    <td class="center">031-997-8288</td>
                <td class="center">접수완료</td>
            </tr>
			
            <tr>
                <td class="center">2016-01-06 10:32</td>
                <td class="center">서울송파마천11</td>
                <td class="center">02-406-8790</td>
                <td class="center">배달완료</td>
            </tr>
        </tbody>
    </table>
	*/
    $content_array3 =   explode("<tr>", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        /*                     
        echo "<br /><br /><br />";
        echo "<xmp>";        
        echo $content_array4[0];
        echo "</xmp>";
        */
                
        $content_array4 =   explode("<td class=\"center\">", $content_array3[$i]);   
        
        // (1) 날짜
        $content_array5 =   explode("</td>", $content_array4[1]);               // 1
        
        $text_temp[1]   =   get_html_to_text_data($content_array5[0]);
        
        // (2) 처리점소
        $content_array5 =   explode("</td>", $content_array4[2]);               // 2
        
        $text_temp[2]   =   get_html_to_text_data($content_array5[0]);
        
        // (3) 연락처
        $content_array5 =   explode("</td>", $content_array4[3]);               // 3
        
        $text_temp[3]   =   get_html_to_text_data($content_array5[0]);
        
        // (4) 처리현황
        $content_array5 =   explode("</td>", $content_array4[4]);               // 4
        
        $text_temp[4]   =   get_html_to_text_data($content_array5[0]);
                
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