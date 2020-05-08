<?php

////////////////////////////////////////////////////////////////////////////////
// 드림택배

// 배송조회결과 구함 (드림택배)
function get_result_deliverytracking_idreamlogis($content_temp) {   
    
    global $COMMON_DELIVERYTYPE_ARRAY;                              

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("<script src=\"http://www.logii.com/interface/delvprom/delv_link.asp", $content_temp);              // 조회결과 없을 경우
    $content_array_count    =   count($content_array);          
    /*
    조회된 데이터가 없습니다.
    */
    
    if ($content_array_count <= 1) {
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
    // 1.배송 정보
                
    // 운송장번호, 송화주, 상품명, 수화주, 수량, 수화주 주소

    /*
    <article class="input_group">
		<table class="i_table_01">
			<caption>배송조회결과 정보표</caption>
			<colgroup>
				<col style="width:180px">
				<col style="width:270px">
				<col style="width:180px">
				<col style="width:270px">
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">운송장번호</th>
					<td>3043-4892-7584</td>						
					<th scope="row">송화주</th>						
					<td>주)이스마트 님</td>						
				</tr>
				<tr>
					<th scope="row">상품명</th>
					<td>[1230]엘리트와이드(A</td>
					<th scope="row">수화주</th>						
					<td>주정환 님</td>						
				</tr>
				<tr>
					<th scope="row">수량</th>
					<td colspan="3">1</td>						
				</tr>
				<tr>
					<th scope="row">수화주 주소</th>
					<td colspan="3">서울 송파구  풍납2동</td>						
				</tr>
			</tbody>
		</table>		
	</article>
    */
    
    $content_array  =   explode("<caption>배송조회결과 정보표</caption>", $content_temp);
    $content_array2 =   explode("</tbody>", $content_array[1]);
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 운송장번호
    $content_array3 =   explode("<th scope=\"row\">운송장번호</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array5[1]);              // html중 text 데이터만 구함    
    
    // (2) 송화주
    $content_array3 =   explode("<th scope=\"row\">송화주</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array5[1]);
    
    // (3) 상품명
    $content_array3 =   explode("<th scope=\"row\">상품명</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array5[1]);
    
    // (4) 수화주
    $content_array3 =   explode("<th scope=\"row\">수화주</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array5[1]);
    
    // (5) 수량
    $content_array3 =   explode("<th scope=\"row\">수량</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td colspan=\"3\">", $content_array4[0]);
    
    $text_temp[5]   =   get_html_to_text_data($content_array5[1]);
    
    /*
    // (6) 수화주 주소
    $content_array3 =   explode("<th scope=\"row\">수화주 주소</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td colspan=\"3\">", $content_array4[0]);
    
    $text_temp[6]   =   get_html_to_text_data($content_array5[1]);
    */
    
    // echo $text_temp[8]; exit;
    
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
                    <th class=\"text-center\" colspan=\"4\">배송 정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"text-center active\">운송장번호</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"text-center active\">송화주</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">상품명</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"text-center active\">수화주</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">수량</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <th class=\"text-center active\">수화주 주소</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                </tr>
            </tbody>
        </table>
    ";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.배송 상태
    
    // 배송 상태
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"10%\" />
                <col width=\"10%\" />
                <col width=\"50%\" />
                <col width=\"15%\" />  
                <col width=\"15%\" />  
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">배송 상태</th>
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜</th>
                    <th class=\"text-center\">시간</th>                    
                    <th class=\"text-center\">상태</th>                            
                    <th class=\"text-center\">배송처</th>
                    <th class=\"text-center\">연락처</th>
                </tr>
            </thead>
            <tbody>
    ";
    
    // 날짜, 시간, 상태, 배송처, 연락처
    /*
    <article class="inquiry_result">
		<table class="c_table_01">
			<caption>배송조회결과 상태 표</caption>
			<colgroup>
				<col style="width:10%">
				<col style="width:10%">
				<col style="width:50%">
				<col style="width:20%">
				<col style="width:10%">
			</colgroup>
			<thead>
				<tr>
					<th scope="col">날짜</th>
					<th scope="col">시간</th>
					<th scope="col">상태</th>
					<th scope="col">배송처</th>
					<th scope="col">연락처</th>
				</tr>
			</thead>
			<tbody>
	
				<tr>
					<td><span>2016.03.02</span></td>
					<td><span>12:41</span></td>
					<td><span>상품을 발송하기 위한 운송장을 발행하였습니다.</span></td>
					<td><span>포천</span></td>
					<td><span>031-535-0434</span></td>
				</tr>
	
				<tr>
					<td><span>2016.03.03</span></td>
					<td><span>12:38</span></td>
					<td><span>고객님의 상품을 인수하였습니다.</span></td>
					<td><span>포천</span></td>
					<td><span>010-5492-0075</span></td>
				</tr>
	
  		<tr>
	        <td colspan="5">
      			<script src="http://www.logii.com/interface/delvprom/delv_link.asp?comp_code=dongex&inv_no=304348927584"></script>
	        </td>
	      </tr>
	
			<!-- 
				<tr>
					<td>2015.05.18</td>
					<td><em class="c_orange">접수중</em></td>
					<td>드림택배</td>
					<td>010.0000.0000</td>
				</tr>
				<tr>
					<td colspan="4">조회된 데이터가 없습니다.<br>운송장이 등록되지 않았거나 업체에서 상품을 준비중이니 업체에 문의하여 주십시오.</td>
				</tr>
			 -->				 
			</tbody>
		</table>
	</article>
	*/
	
	$content_array  =   explode("<caption>배송조회결과 상태 표</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);
    $content_array4 =   explode("<script src=", $content_array3[1]);
    $content_array5 =   explode("</tr>", $content_array4[0]);
    
    $content_array5_count   =   count($content_array5);
    
    for ($i = 0; $i < $content_array5_count - 1; $i++) {
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
    
        $content_array6 =   explode("<td><span>", $content_array5[$i]);
        
        // (1) 날짜
        $content_array7 =   explode("</span></td>", $content_array6[1]);        // 1
        
        $text_temp[1]   =   get_html_to_text_data($content_array7[0]);
        
        // (2) 시간
        $content_array7 =   explode("</span></td>", $content_array6[2]);        // 2
        
        $text_temp[2]   =   get_html_to_text_data($content_array7[0]);
        
        // (3) 상태
        $content_array7 =   explode("</span></td>", $content_array6[3]);        // 3
                
        $text_temp[3]   =   get_html_to_text_data($content_array7[0]);
        
        // (4) 배송처
        $content_array7 =   explode("</span></td>", $content_array6[4]);        // 4
        
        $text_temp[4]   =   get_html_to_text_data($content_array7[0]);
        
        // (5) 연락처
        $content_array7 =   explode("</span></td>", $content_array6[5]);        // 5
        
        $text_temp[5]   =   get_html_to_text_data($content_array7[0]);
        
        
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[4]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[5]) . "</td>
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