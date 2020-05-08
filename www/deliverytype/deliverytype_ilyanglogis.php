<?php

////////////////////////////////////////////////////////////////////////////////
// 일양로지스

// 배송조회결과 구함 (일양로지스)
function get_result_deliverytracking_ilyanglogis($content_temp) {    

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("검색내역이  없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "검색내역이 없습니다.";
        
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

    /*
		<h2><strong></strong> 고객님의 상품이 <font color="#f14637">배송완료</font> 입니다.</h2>
		<!-- 배송내용 -->
		<dl>
			<dt  style="color:#585858" ><strong>&middot&nbsp;운송장 번호</strong></dt>
			<dd  style="color:#000000;font-weight:bold" >1901431641</dd>
			<dt style="color:#585858" ><strong>&middot&nbsp;보내는 분</strong></dt>
			 
				<dd>
쇼** / 주식회사*****	
				
				
				</dd>                
			 
			<dt  style="color:#585858" ><strong>&middot&nbsp;받는 분</strong></dt>
			  
			   <dd>
			   이**			   
			   
			   
			   </dd>
			  
			<!--<dt><img src="/images/pop_th_delivery04.gif" alt="상품명"></dt>
			<dd>타블렛</dd>-->
			<dt  style="color:#585858" ><strong>&middot&nbsp;고객주문번호</strong></dt>
			<dd>5000463615</dd>
			<dt  style="color:#585858" ><strong>&middot&nbsp;발송 결과</strong></dt>
	
			<dd><strong>배송완료</strong>&nbsp;<span style="color:#000000;">
			(실수령인 : 
이**
		<!-- 배송내용 -->
			
		<!-- 배송내용 -->
			
		<!-- 배송내용 -->
			
		<!-- 배송내용 -->
			
		<!-- 배송내용 -->
			



)</span></dd>
		
</dl>
	*/
    
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.배송정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수 초기화

    // (1) 운송장 번호
    $content_array  =   explode("<strong>&middot&nbsp;운송장 번호</strong>", $content_temp);    
    $content_array2 =   explode("</dd>", $content_array[1]);
    $content_array3 =   explode("<dd", $content_array2[0]);
    $content_array4 =   explode(">", $content_array3[1]);
    $text_temp[1]   =   trim($content_array4[1]);
    // echo "<br />운송장 번호 : " . $text_temp[1]; exit;

    // (2) 고객주문번호 
    $content_array  =   explode("<strong>&middot&nbsp;고객주문번호</strong>", $content_temp);    
    $content_array2 =   explode("</dd>", $content_array[1]);
    $content_array3 =   explode("<dd", $content_array2[0]);
    $content_array4 =   explode(">", $content_array3[1]);
    $text_temp[2]   =   trim($content_array4[1]);
    // echo "<br />고객주문번호 : " . $text_temp[2]; exit;
    
    // (3) 보내는 분 
    $content_array  =   explode("<strong>&middot&nbsp;보내는 분</strong>", $content_temp);    
    $content_array2 =   explode("</dd>", $content_array[1]);
    $content_array3 =   explode("<dd", $content_array2[0]);
    $content_array4 =   explode(">", $content_array3[1]);
    $text_temp[3]   =   get_html_to_text_data($content_array4[1]);
    // echo "<br />보내는 분 : " . $text_temp[3]; exit;
    
    // (4) 받는 분
    $content_array  =   explode("<strong>&middot&nbsp;받는 분</strong>", $content_temp);    
    $content_array2 =   explode("</dd>", $content_array[1]);
    $content_array3 =   explode("<dd", $content_array2[0]);
    $content_array4 =   explode(">", $content_array3[1]);
    $text_temp[4]   =   get_html_to_text_data($content_array4[1]);
    // echo "<br />받는 분 : " . $text_temp[4]; exit;
    
    // (5) 발송 결과
    $content_array  =   explode("<strong>&middot&nbsp;발송 결과</strong>", $content_temp);    
    // $content_array2 =   explode("<!-- 배송내용 -->", $content_array[1]);
    $content_array2 =   explode("<!-- /배송내용 -->", $content_array[1]);
    $content_array3 =   explode("<dd>", $content_array2[0]);
    $text_temp[5]   =   get_html_to_text_data($content_array3[1]);
    // echo "<br />발송 결과 : " . $text_temp[5]; exit;
    
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
                    <th class=\"text-center\" colspan=\"4\">배송정보</th>          
                </tr>                
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">운송장 번호</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">고객주문번호</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">보내는 분</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">받는 분</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">발송 결과</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[5] . "</td>                         
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 2.배송 상세 현황
    
    // 배송 상세 현황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>      
                <col width=\"15%\" />  
                <col width=\"10%\" />
                
                <col width=\"20%\" />
                <col width=\"15%\" />
                <col width=\"20%\" />
                
                <col width=\"10%\" />
                <col width=\"10%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"7\">배송 상세 현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜</th>
                    <th class=\"text-center\">시간</th>
                    
                    <th class=\"text-center\">운송상태</th>
                    <th class=\"text-center\">지점</th>
                    <th class=\"text-center\">연락처</th>
                    
                    <th class=\"text-center\">담당자</th>
                    <th class=\"text-center\">비고</th>
                </tr>
            </thead>
            <tbody>
    ";
        
    // 날짜, 시간, 운송상태, 지점, 연락처, 담당자, 비고
    $content_array  =   explode("<h2><strong>배송 상세 현황</h2>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);
    
    $content_array4 =   explode("<tr>", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    for ($i = 1; $i < $content_array4_count; $i++) {
        // echo "<br />" . $content_array4[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        
        $content_array5 =   explode("<td>", $content_array4[$i]);
        
        // (1) 날짜
        $content_array6 =   explode("</td>", $content_array5[1]);               // 1
        $text_temp[1]   =   trim($content_array6[0]);
        // echo "<br />날짜 : " . $text_temp[1]; exit;
        
        // (2) 시간
        $content_array6 =   explode("</td>", $content_array5[2]);               // 2
        $text_temp[2]   =   trim($content_array6[0]);
        // echo "<br />시간 : " . $text_temp[2]; exit;
        
        // (3) 운송상태
        $content_array6 =   explode("</td>", $content_array5[3]);               // 3
        $text_temp[3]   =   trim($content_array6[0]);
        // echo "<br />운송상태 : " . $text_temp[3]; exit;
        
        // (4) 지점
        $content_array6 =   explode("</td>", $content_array5[4]);               // 4
        $text_temp[4]   =   trim($content_array6[0]);
        // echo "<br />지점 : " . $text_temp[4]; exit;
        
        // (5) 연락처
        $content_array6 =   explode("</td>", $content_array5[5]);               // 5
        $text_temp[5]   =   trim($content_array6[0]);
        // echo "<br />연락처 : " . $text_temp[5]; exit;
        
        // (6) 담당자
        $content_array6 =   explode("</td>", $content_array5[6]);               // 6
        $text_temp[6]   =   trim($content_array6[0]);
        // echo "<br />담당자 : " . $text_temp[6]; exit;
        
        // (7) 비고
        $content_array6 =   explode("</td>", $content_array5[7]);               // 7
        $text_temp[7]   =   trim($content_array6[0]);
        // echo "<br />비고 : " . $text_temp[7]; exit;

        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . $text_temp[1] . "</td>
                <td class=\"text-center\">" . $text_temp[2] . "</td>
                <td class=\"text-center\">" . $text_temp[3] . "</td>
                <td class=\"text-center\">" . $text_temp[4] . "</td>
                <td class=\"text-center\">" . $text_temp[5] . "</td>
                <td class=\"text-center\">" . $text_temp[6] . "</td>
                <td class=\"text-center\">" . $text_temp[7] . "</td>                
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