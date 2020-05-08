<?php

////////////////////////////////////////////////////////////////////////////////
// 대신택배

// 배송조회결과 구함 (대신택배)
function get_result_deliverytracking_ds3211($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        

    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("검색하신 운송장번호로 운송된 내역이 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    검색하신 운송장번호로 운송된 내역이 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "검색하신 운송장번호로 운송된 내역이 없습니다.";
        
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
    
    // 운송장번호 보내신분 전화번호 받으실분 전화번호 품명 수량
    
    /*
    <p class="box04">운송장 번호  : 2523601008141</p>
						
	<p><img src="../../common/images/sub01/con_sub_title04.gif"alt="기본정보" /></p>	

	<table class="depth01 tmar_15 bmar_50">
		<tr>
			<th>보내신분</th>
			<td>이*********</td>
			<th>전화번호</th>
			<td>0106*******</td>
		</tr>
		<tr>
			<th>받으실분</th>
			<td>전****</td>
			<th>전화번호</th>
			<td>0704*******</td>
		</tr>
		<tr>
			<th>품 명</th>
			<td>이불</td>
			<th>수 량</th>
			<td>1 EA</td>
		</tr>                  
	</table>
	
	
	<!-- 배송결과 -->	
	<div class="effect tmar_30 ">                    	
		<ul>                    
			<li>
			(택배)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			[<span style='color:red;'> 미정</span> ] 님께04 월 14 일 12 시 05 분에 인도 되었습니다.</li> 
		</ul>
	</div>	
    */
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 운송장번호
    $content_array  =   explode("<p class=\"box04\">운송장 번호  : ", $content_temp);
    $content_array2 =   explode("</p>", $content_array[1]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    
    // (2) 보내신분
    $content_array  =   explode("<th>보내신분</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array3[1]);
    
    // (3) 전화번호 (보내신분)
    $content_array  =   explode("<th>보내신분</th>", $content_temp);
    $content_array2 =   explode("<th>전화번호</th>", $content_array[1]);
    $content_array3 =   explode("</td>", $content_array2[1]);
    $content_array4 =   explode("<td>", $content_array3[0]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array4[1]);
    
    // (4) 받으실분
    $content_array  =   explode("<th>받으실분</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array3[1]);
    
    // (5) 전화번호 (받으실분)
    $content_array  =   explode("<th>받으실분</th>", $content_temp);
    $content_array2 =   explode("<th>전화번호</th>", $content_array[1]);
    $content_array3 =   explode("</td>", $content_array2[1]);
    $content_array4 =   explode("<td>", $content_array3[0]);
    
    $text_temp[5]   =   get_html_to_text_data($content_array4[1]);
    
    // (6) 품명
    $content_array  =   explode("<th>품 명</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    
    $text_temp[6]   =   get_html_to_text_data($content_array3[1]);
    
    // (7) 수량
    $content_array  =   explode("<th>수 량</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    
    $text_temp[7]   =   get_html_to_text_data($content_array3[1]);
    
    
    // (8) 배송결과
    $content_array  =   explode("<div class=\"effect tmar_30 \">", $content_temp);
    $content_array2 =   explode("</div>", $content_array[1]);
    $content_array3 =   explode("<li>", $content_array2[0]);
    $content_array4 =   explode("</li>", $content_array3[1]);
    
    $text_temp[8]   =   get_html_to_text_data(strip_tags($content_array4[0]));
        
        
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
                    <th class=\"text-center active\">보내신분</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <th class=\"text-center active\">전화번호</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">받으실분</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                    <th class=\"text-center active\">전화번호</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">품명</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                    <th class=\"text-center active\">수량</th>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>
                </tr> 
                <tr>
                    <th class=\"text-center active\">배송결과</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[8] . "</td>
                </tr>   
            </tbody>
    ";
    
    
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.상품추적상태
    
    /*
    <p><img src="../../common/images/sub01/con_sub_title05.gif"alt="상품추적 상품" /></p>

	<table class="depth01 tmar_15">
		<tr>
			<th>구 분</th>
			<th>취급점명</th>
			<th>전화번호</th>
			<th>도착(접수)일시</th>
			<th>출발(배달)일시</th>
			<th>현재위치</th>
		</tr>
		<tr>                        
			<td>발송취급점</td>
			<td>포천소흘</td>
			<td>031-541-3211</td>
			<td>2016-04-12 18:27</td>
			<td>2016-04-12 18:38</td>
			<td></td>
		</tr>                 
		       
		<tr>                        
			<td>경유취급점1</td>
			<td>부곡터</td>
			<td>031-462-0130</td>
			
				<td>2016-04-12 18:51</td>
				<td>2016-04-12 18:51</td>
				
			<td></td>
		</tr> 
		 
		<tr bgcolor="#fef8e7">                         
			<td>도착취급점</td>
			<td>망우리</td>
			<td>02-433-9966</td>
			
			<td>2016-04-13 07:32</td>
			<td>2016-04-14 12:05</td>
			
			<td>배송완료</td>
		</tr>                  
	</table>
    */			

    // 상품추적상태
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"17%\" />
                <col width=\"17%\" />
                <col width=\"16%\" />
                <col width=\"17%\" />
                <col width=\"17%\" />
                <col width=\"16%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"6\">상품추적상태</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">구분</th>
                    <th class=\"text-center\">취급점명</th>                    
                    <th class=\"text-center\">전화번호</th>                            
                    <th class=\"text-center\">도착(접수)일시</th>                          
                    <th class=\"text-center\">출발(배달)일시</th>                          
                    <th class=\"text-center\">현재위치</th>                          
                </tr>
            </thead>
            <tbody>
    ";
    						
    // 구분, 취급점명, 전화번호, 도착(접수)일시, 출발(배달)일시 현재위치
    $content_array  =   explode("<p><img src=\"../../common/images/sub01/con_sub_title05.gif\"alt=\"상품추적 상품\" /></p>", $content_temp);
    $content_array2 =   explode("<table class=\"depth01 tmar_15\">", $content_array[1]);
    $content_array3 =   explode("<th>현재위치</th>", $content_array2[1]);    
    $content_array4 =   explode("</table>", $content_array3[1]);
    
    $content_array5 =   explode("<tr", $content_array4[0]); 
    
    $content_array5_count   =   count($content_array5);
    
    // echo "<br />content_array5_count : " . $content_array5_count; exit;
    
    for ($i = 1; $i < $content_array5_count; $i++) {                            // 1~
        // echo "<br />" . $content_array5[$i];
        
        $text_temp = array();   // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array6 =   explode("</tr>", $content_array5[$i]);   
                     
        
        ////////////////////////////////////////////////////////////////////////////////
        
        // (1) 구분
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[1]);               // 1
        
        $text_temp[1]   = get_html_to_text_data($content_array8[0]);
        
        // (2) 취급점명
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[2]);               // 2
        
        $text_temp[2]   = get_html_to_text_data($content_array8[0]);
        
        // (3) 전화번호
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[3]);               // 3
        
        $text_temp[3]   = get_html_to_text_data($content_array8[0]);
        
        // (4) 도착(접수)일시
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[4]);               // 4
        
        $text_temp[4]   = get_html_to_text_data($content_array8[0]);
        
        // (5) 출발(배달)일시
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[5]);               // 5
        
        $text_temp[5]   = get_html_to_text_data($content_array8[0]);
        
        // (6) 현재위치
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[6]);               // 6
        
        $text_temp[6]   = get_html_to_text_data($content_array8[0]);
        
        
        $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
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