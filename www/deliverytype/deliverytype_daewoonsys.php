<?php

////////////////////////////////////////////////////////////////////////////////
// 대운글로벌

// 배송조회결과 구함 (대운글로벌)
function get_result_deliverytracking_daewoonsys($content_temp) {   
    
    global $COMMON_DELIVERYTYPE_ARRAY;                              

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("검색된 운송장이 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    검색된 운송장이 없습니다.
    */
    
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
    
    // echo "<xmp>" . $content_temp . "</xmp>"; exit;
    
    // 조회결과
    $result_deliverytracking        =   "";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.운송장 정보 (tracking_info)
                
    // 운송장 번호 Loading No.
    // 발송인 전화번호
    // 주소
    // 수취인 전화번호
    // 주소

    /*
    <table id="tracking_info">
		<colgroup>
			<col width="20%"/>
			<col width="30%"/>
			<col width="20%"/>
			<col width="30%"/>
		</colgroup>
		<tr>
			<th class="linet2 linel2">운송장 번호</th>
			<td class="linet2"><a href="javascript:fnPostTrackingDetailView();">6074985060697</a></td>
			<th class="linet2">Loading No.</th>
			<td class="linet2">PBNJ1601290061</td>
		</tr>
		<tr>
			<th class="linel2">발송인</th>
			<td>www.ninewest.com (POST BAY USA, INC.)</td>
			<th>전화번호</th>
			<td>201-378-****</td>
		</tr>
		<tr>
			<th class="linel2">주소</th>
			<td colspan="3">86 ORCHARD ST. UNIT 5, HACKENSACK, NJ</td>
		</tr>
		<tr>
			<th class="linel2">수취인</th>
			<td>고**</td>
			<th>전화번호</th>
			<td>010********</td>
		</tr>
		<tr>
			<th class="linel2">주소</th>
			<td colspan="3">서울 **** *****</td>
		</tr>
	</table>
    */
    
    $content_array  =   explode("<table id=\"tracking_info\">", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 운송장 번호
    $content_array3 =   explode("<th class=\"linet2 linel2\">운송장 번호</th>", $content_array2[0]);
    $content_array4 =   explode("</a></td>", $content_array3[1]);
    $content_array5 =   explode("<a href=\"javascript:fnPostTrackingDetailView();\">", $content_array4[0]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array5[1]);              // html중 text 데이터만 구함    
        
    // 운송장번호 임시 기억 (우체국택배 링크)    
    $INVOICE_NO_TEMP = $text_temp[1];    
    
    // (2) Loading No.
    $content_array3 =   explode("<th class=\"linet2\">Loading No.</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td class=\"linet2\">", $content_array4[0]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array5[1]);
    
    // (3) 발송인
    $content_array3 =   explode("<th class=\"linel2\">발송인</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array5[1]);
    
    // (4) 전화번호 (발송인)
    $content_array3 =   explode("<th class=\"linel2\">발송인</th>", $content_array2[0]);
    $content_array4 =   explode("<th>전화번호</th>", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);
    $content_array6 =   explode("<td>", $content_array5[0]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array6[1]);
    
    // (5) 주소 (발송인)
    $content_array3 =   explode("<th class=\"linel2\">발송인</th>", $content_array2[0]);
    $content_array4 =   explode("<th class=\"linel2\">주소</th>", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);
    $content_array6 =   explode("<td colspan=\"3\">", $content_array5[0]);
    
    $text_temp[5]   =   get_html_to_text_data($content_array6[1]);
        
    // (6) 수취인
    $content_array3 =   explode("<th class=\"linel2\">수취인</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);
    
    $text_temp[6]   =   get_html_to_text_data($content_array5[1]);
    
    // (7) 전화번호 (수취인)
    $content_array3 =   explode("<th class=\"linel2\">수취인</th>", $content_array2[0]);
    $content_array4 =   explode("<th>전화번호</th>", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);
    $content_array6 =   explode("<td>", $content_array5[0]);
    
    $text_temp[7]   =   get_html_to_text_data($content_array6[1]);
    
    // (8) 주소 (발송인)
    $content_array3 =   explode("<th class=\"linel2\">수취인</th>", $content_array2[0]);
    $content_array4 =   explode("<th class=\"linel2\">주소</th>", $content_array3[1]);
    $content_array5 =   explode("</td>", $content_array4[1]);
    $content_array6 =   explode("<td colspan=\"3\">", $content_array5[0]);
    
    $text_temp[8]   =   get_html_to_text_data($content_array6[1]);
    
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
                    <th class=\"text-center\" colspan=\"4\">운송장 정보 (tracking_info)</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"text-center active\">운송장 번호</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"text-center active\">Loading No.</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">발송인</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"text-center active\">전화번호</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">주소</th>
                    <td class=\"text-left\" colspan=\"3\">" . $text_temp[5] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">수취인</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                    <th class=\"text-center active\">전화번호</th>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>
                </tr>
                <tr>
                    <th class=\"text-center active\">주소</th>
                    <td class=\"text-left\" colspan=\"3\">" . $text_temp[8] . "</td>
                </tr>
            </tbody>
        </table>
    ";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.상품 정보 (tracking_goods)
    
    // 상품 정보
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"5%\" />
                <col width=\"45%\" />
                <col width=\"10%\" />
                <col width=\"20%\" />  
                <col width=\"20%\" />  
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">상품 정보 (tracking_goods)</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">번호</th>
                    <th class=\"text-center\">품목</th>                    
                    <th class=\"text-center\">수량</th>                            
                    <th class=\"text-center\">브랜드</th>
                    <th class=\"text-center\">비고</th>
                </tr>
            </thead>
            <tbody>
    ";
    
    // 번호 품목 수량 브랜드 비고
    /*
    <table id="tracking_goods">
		<colgroup>
			<col width="10%"/>
			<col width="%"/>
			<col width="10%"/>
			<col width="15%"/>
			<col width="15%"/>
		</colgroup>

		<tr>
			<th class="linet2 linel2">번호</th>
			<th class="linet2">품목</th>
			<th class="linet2">수량</th>
			<th class="linet2">브랜드</th>
			<th class="linet2">비고</th>
		</tr>

		<tr>
        	<td class="linel2 ac">1</td>
        	<td>Nine  **********</td>
        	<td class="ac">1</td>
        	<td>Ni *****</td>
        	<td></td>
        </tr>
        
        <tr>
        	<td class="linel2 ac">2</td>
        	<td>Nine  **********</td>
        	<td class="ac">2</td>
        	<td>Ni *****</td>
        	<td></td>
        </tr>

	</table>
    */
    
    $content_array  =   explode("<table id=\"tracking_goods\">", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<th class=\"linet2\">비고</th>", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
    
        $content_array4 =   explode("<td", $content_array3[$i]);
        
        // (1) 번호
        $content_array5 =   explode("</td>", $content_array4[1]);               // 1
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[1]   =   get_html_to_text_data($content_array6[1]);
        
        // (2) 품목
        $content_array5 =   explode("</td>", $content_array4[2]);               // 2
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[2]   =   get_html_to_text_data($content_array6[1]);
        
        // (3) 수량
        $content_array5 =   explode("</td>", $content_array4[3]);               // 3
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[3]   =   get_html_to_text_data($content_array6[1]);
        
        // (4) 브랜드
        $content_array5 =   explode("</td>", $content_array4[4]);               // 4
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[4]   =   get_html_to_text_data($content_array6[1]);
        
        // (5) 비고
        $content_array5 =   explode("</td>", $content_array4[5]);               // 5
        $content_array6 =   explode(">", $content_array5[0]);
        
        $text_temp[5]   =   get_html_to_text_data($content_array6[1]);
        
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
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 3. 처리 현황 (tracking_shipping)
    
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
                    <th class=\"text-center\" colspan=\"4\">처리 현황 (tracking_shipping)</th>          
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
    
    // 처리일시, 현재위치, 처리현황, 상세설명
    /*
    <table id="tracking_shipping">
		<colgroup>
			<col width="22%"/>
			<col width="18%"/>
			<col width="15%"/>
			<col width="%"/>
		</colgroup>

		<tr>
			<th class="linet2 linel2">처리일시</th>
			<th class="linet2">현재위치</th>
			<th class="linet2">처리현황</th>
			<th class="linet2">상세설명</th>
		</tr>

		<tr>
        	<td class="linel2 ac">2016-01-29 16:20 (현지)</td>
        	<td class="ac">판매자</td>
        	<td class="ac">발송</td>
        	<td>해외 운송점 발송</td>
        </tr>
        <tr>
        	<td class="linel2 ac">2016-01-29 16:36 (현지)</td>
        	<td class="ac">해외운송점</td>
        	<td class="ac">도착</td>
        	<td>해외 운송점 도착</td>
        </tr>
        <tr>
        	<td class="linel2 ac">2016-01-29 17:34 (현지)</td>
        	<td class="ac">해외운송점</td>
        	<td class="ac">발송</td>
        	<td>공항 이동</td>
        </tr>
        <tr>
        	<td class="linel2 ac">2016-01-31 07:35 (현지)</td>
        	<td class="ac">항공사</td>
        	<td class="ac">출발</td>
        	<td class="lh150">
        			출발&nbsp;시간 : 2016-01-31 07:35<br>
        			출발&nbsp;공항 : JFK<br>
        			도착&nbsp;시간 : 2016-02-01 14:35<br>
        			도착&nbsp;공항 : ICN<br>
        			항&nbsp;&nbsp;공&nbsp;&nbsp;사 : OZ<br>
        			편&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;명 : OZ267
        	</td>
        </tr>
        <tr>
        	<td class="linel2 ac">2016-02-01 14:35 (한국)</td>
        	<td class="ac">항공사</td>
        	<td class="ac">도착</td>
        	<td>인천 도착 - 반입 대기</td>
        </tr>
        <tr>
        	<td class="linel2 ac">2016-02-01 17:35 (한국)</td>
        	<td class="ac">세관</td>
        	<td class="ac">통관중</td>
        	<td>목록 통관</td>
        </tr>
	</table>
	*/
	
	$content_array  =   explode("<table id=\"tracking_shipping\">", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<th class=\"linet2\">상세설명</th>", $content_array2[0]);
    $content_array4 =   explode("<tr>", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    for ($i = 1; $i < $content_array4_count; $i++) {
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
    
        $content_array5 =   explode("<td", $content_array4[$i]);
        
        // (1) 처리일시
        $content_array6 =   explode("</td>", $content_array5[1]);               // 1
        $content_array7 =   explode(">", $content_array6[0]);
        
        $text_temp[1]   =   get_html_to_text_data($content_array7[1]);
        
        // (2) 현재위치
        $content_array6 =   explode("</td>", $content_array5[2]);               // 2
        $content_array7 =   explode(">", $content_array6[0]);
        
        $text_temp[2]   =   get_html_to_text_data($content_array7[1]);
        
        // (3) 처리현황
        $content_array6 =   explode("</td>", $content_array5[3]);               // 3
        $content_array7 =   explode(">", $content_array6[0]);
        
        $text_temp[3]   =   get_html_to_text_data($content_array7[1]);
        
        
        // (4) 상세설명
        $content_array6 =   explode("</td>", $content_array5[4]);               // 4
        
        // 2가지로 구분 
        // 1) class="lh150">    
        // 2) >        
        $content_array7 =   explode(" class=\"lh150\">", $content_array6[0]);
        $content_array7_count   =   count($content_array7);
        
        if ($content_array7_count > 1) {
            $content_array7 =   explode(" class=\"lh150\">", $content_array6[0]);
            $text_temp[4]   =   get_html_to_text_data($content_array7[1]);
        }
        else {
            $content_array7 =   explode(">", $content_array6[0]);
            $text_temp[4]   =   get_html_to_text_data($content_array7[1]);    
        }
        
        
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                <td class=\"text-left\">" . $text_temp[4] . "</td>
            </tr>
        ";
    }
    
    
    // 우체국택배 조회링크
    $result_deliverytracking .= "
            <tr class=\"active\">
                <th class=\"text-center\" colspan=\"4\"><a href=\"" . $SITE_VAR["url"] . "?dummy=dummy&deliverytype=" . $COMMON_DELIVERYTYPE_ARRAY["우체국택배"] . "&keyword=" . $INVOICE_NO_TEMP . "\">우체국택배(국내) 배송조회하기 [클릭]</a></th>
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
    */
    
    return $result_deliverytracking;
}

?>