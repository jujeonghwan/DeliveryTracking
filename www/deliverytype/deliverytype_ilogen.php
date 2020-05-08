<?php

////////////////////////////////////////////////////////////////////////////////
// 로젠택배

// 배송조회결과 구함 (로젠택배)
function get_result_deliverytracking_ilogen($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // 등기번호, 보내는분/발송날짜, 받는분/수신날짜, 취급구분, 배달완료
    $content_array          =   explode("<title>Object moved</title>", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    <html><head><title>Object moved</title></head><body>
    <h2>Object moved to <a href="%2fiLOGEN.Web.New%2fTRACE%2fTraceNoView.aspx">here</a>.</h2>
    </body></html>
    */
    
    if ($content_array_count > 1) {
        $text_temp = "배송자료를 조회할 수 없습니다!";
        
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
    
    // result_error
    $content_array          =   explode("배송자료를 조회할 수 없습니다!", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "배송자료를 조회할 수 없습니다!";
        
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
    // 1.물품정보
                
    // 송장번호 집하일자 상품명 집하지점 배송지점 보내시는 분 수량 받으시는 분 주소 

    $content_array  =   explode("발송점 및 도착점명을 클릭하시면 연락처를 보실수 있습니다.", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);            
    /*
    <tr>
        <td height="24" class="td_02">송장번호</td>
        <td colspan="3"><input name="tbSlipNo" type="text" value="230-3415-7484" id="tbSlipNo" title="송장번호" border="0" />
            </td>
    </tr>
    <tr>
        <td height="24" class="td_02">
            집하일자</td>
        <td><input name="tbTakeDt" type="text" value="2015-12-15" id="tbTakeDt" title="집하일자" border="0" /></td>
        <td class="td_02">상품명</td>
        <td><input name="tbGoodsNm" type="text" id="tbGoodsNm" title="상품명" border="0" /></td>
    </tr>
    <tr>
        <td height="24" class="td_02">집하지점</td>
        <td><a id="btnPickBran" href="javascript:__doPostBack('btnPickBran','')">서마포</a>
            <input name="tmpPickBran" type="hidden" id="tmpPickBran" title="집하지점" style="width: 10px; height: 13px" value="222" /></td>
        <td class="td_02">배송지점</td>
        <td><a id="btnSndBran" href="javascript:__doPostBack('btnSndBran','')">북송파</a>
            <input name="tmpSndBran" type="hidden" id="tmpSndBran" title="배송지점" style="width: 10px; height: 13px" value="211" /></td>
    </tr>
    <tr>
        <td class="td_02" style="height: 24px">보내시는 분 </td>
        <td style="height: 24px"><input name="tbSndCustNm" type="text" value="북**" id="tbSndCustNm" title="보내시는 분" border="0" /></td>
        <td class="td_02" style="height: 24px">수량</td>
        <td style="height: 24px"><input name="tbQty" type="text" value="1" id="tbQty" title="수량" border="0" /></td>
    </tr>
    <tr>
        <td height="24" class="td_02">받으시는 분 </td>
        <td style="height: 22px"><input name="tbRcvCustNm" type="text" id="tbRcvCustNm" title="받으시는 분" border="0" /></td>
        <td class="td_02">주소</td>
        <td style="height: 22px"><input name="tbRcvCustAddr" type="text" value="  " id="tbRcvCustAddr" title="주소" border="0" /></td>
    </tr>
    */
    
    $text_temp = array();       // 텍스트 데이터 저장할 배열 변수
    
    // (1) 송장번호
    $content_array3 =   explode("<input name=\"tbSlipNo\" type=\"text\" value=\"", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbSlipNo\"", $content_array3[1]);            
    $text_temp[1]   =   get_html_to_text_data($content_array4[0]);                          // html중 text 데이터만 구함
    // echo "<br />송장번호 : <xmp>" . $text_temp[1] . "</xmp>"; exit;
    
    // (2) 집하일자
    $content_array3 =   explode("<input name=\"tbTakeDt\" type=\"text\" value=\"", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbTakeDt\"", $content_array3[1]);            
    $text_temp[2]   =   get_html_to_text_data($content_array4[0]);
    // echo "<br />집하일자 : <xmp>" . $text_temp[2] . "</xmp>"; exit;
    
    // (3) 상품명
    $content_array3 =   explode("<input name=\"tbGoodsNm\" type=\"text\" value=\"", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbGoodsNm\"", $content_array3[1]);            
    $text_temp[3]   =   get_html_to_text_data($content_array4[0]);
    // echo "<br />상품명 : <xmp>" . $text_temp[3] . "</xmp>"; exit;
    
    // (4) 집하지점
    $content_array3 =   explode("class=\"td_02\">집하지점</td>", $content_array2[0]);            
    $content_array4 =   explode("<input name=\"tmpPickBran\"", $content_array3[1]); 
    $content_array5 =   explode("<a id=\"btnPickBran\" href=\"javascript:__doPostBack('btnPickBran','')\">", $content_array4[0]); 
    $content_array6 =   explode("</a>", $content_array5[1]); 
    $text_temp[4]   =   get_html_to_text_data($content_array6[0]);            
    // echo "<br />집하지점 : <xmp>" . $text_temp[4] . "</xmp>"; exit;
    
    // (5) 배송지점
    $content_array3 =   explode("class=\"td_02\">배송지점</td>", $content_array2[0]);            
    $content_array4 =   explode("<input name=\"tmpSndBran\"", $content_array3[1]);            
    $content_array5 =   explode("<a id=\"btnSndBran\" href=\"javascript:__doPostBack('btnSndBran','')\">", $content_array4[0]); 
    $content_array6 =   explode("</a>", $content_array5[1]); 
    $text_temp[5]   =   get_html_to_text_data($content_array6[0]); 
    // echo "<br />배송지점 : <xmp>" . $text_temp[5] . "</xmp>"; exit;
    
    // (6) 보내시는 분
    $content_array3 =   explode("<td class=\"td_02\" style=\"height: 24px\">보내시는 분 </td>", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbSndCustNm\"", $content_array3[1]);            
    $content_array5 =   explode("<input name=\"tbSndCustNm\" type=\"text\" value=\"", $content_array4[0]);            
    $text_temp[6]   =   get_html_to_text_data($content_array5[1]);
    // echo "<br />보내시는 분 : <xmp>" . $text_temp[6] . "</xmp>"; exit;
    
    // (7) 수량
    $content_array3 =   explode("<td class=\"td_02\" style=\"height: 24px\">수량</td>", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbQty\"", $content_array3[1]);            
    $content_array5 =   explode("<input name=\"tbQty\" type=\"text\" value=\"", $content_array4[0]);            
    $text_temp[7]   =   get_html_to_text_data($content_array5[1]);
    // echo "<br />수량 : <xmp>" . $text_temp[7] . "</xmp>"; exit;
    
    // (8) 받으시는 분
    $content_array3 =   explode("<td height=\"24\" class=\"td_02\">받으시는 분 </td>", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbRcvCustNm\"", $content_array3[1]);            
    $content_array5 =   explode("<input name=\"tbRcvCustNm\" type=\"text\" value=\"", $content_array4[0]);            
    $text_temp[8]   =   get_html_to_text_data($content_array5[1]);
    // echo "<br />받으시는 분 : <xmp>" . $text_temp[8] . "</xmp>"; exit;
    
    // (9) 주소
    $content_array3 =   explode("<td class=\"td_02\">주소</td>", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbRcvCustAddr\"", $content_array3[1]);            
    $content_array5 =   explode("<input name=\"tbRcvCustAddr\" type=\"text\" value=\"", $content_array4[0]);            
    $text_temp[9]   =   get_html_to_text_data($content_array5[1]);
    // echo "<br />주소 : <xmp>" . $text_temp[9] . "</xmp>"; exit;
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"10%\" />
                <col width=\"10%\" />
                <col width=\"15%\" />
                
                <col width=\"10%\" />
                <col width=\"10%\" />
                
                <col width=\"10%\" />
                <col width=\"10%\" />
                <col width=\"10%\" />
                <col width=\"15%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"9\">물품정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">송장번호</th>
                    <th class=\"text-center\">집하일자</th>
                    <th class=\"text-center\">상품명</th>
                    
                    <th class=\"text-center\">집하지점</th>
                    <th class=\"text-center\">배송지점</th>
                    
                    <th class=\"text-center\">보내시는 분</th>
                    <th class=\"text-center\">수량</th>
                    <th class=\"text-center\">받으시는 분</th>
                    <th class=\"text-center\">주소</th>                        
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
                    <td class=\"text-center\">" . $text_temp[8] . "</td>
                    <td class=\"text-center\">" . $text_temp[9] . "</td>
                </tr>
            </tbody>
        </table>
    ";  
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.배송자료
    
    // 배송진행현황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"13%\" />
                <col width=\"12%\" />
                <col width=\"13%\" />
                
                <col width=\"12%\" />
                <col width=\"13%\" />
                
                <col width=\"12%\" />
                <col width=\"13%\" />
                <col width=\"12%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"8\">배송자료</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜</th>
                    <th class=\"text-center\">사업장</th>
                    <th class=\"text-center\">상태</th>
                    
                    <th class=\"text-center\">발송점</th>                            
                    <th class=\"text-center\">도착점</th>
                    
                    <th class=\"text-center\">담당직원</th>
                    <th class=\"text-center\">인수자</th>
                    <th class=\"text-center\">영업소</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    // 날짜, 시간, 현재위치, 처리현황
    $content_array  =   explode("<img src=\"../img/delivery/1d_1_list.gif\" alt=\"제목줄(날짜, 사업장, 상태, 발송점, 도착점, 담당직원, 인수자, 영업소)\">", $content_temp);    
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<table cellspacing=\"0\" cellpadding=\"0\" rules=\"rows\" border=\"1\" id=\"gridTrace\" style=\"border-color:White;border-width:1px;border-style:solid;width:705px;border-collapse:collapse;\">", $content_array2[0]);
    /*
    <tr>
		<td align="center" width="145">2015-12-15 09:00</td><td align="center" width="82">서마포</td><td align="center" width="82">집하입고</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl02$ctl00','')">서마포</a></td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl02$ctl01','')"></a></td><td align="center" width="80">김병주</td><td align="center" width="80">&nbsp;</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl02$ctl02','')">김병주</a></td>
	</tr><tr>
		<td align="center" width="145">2015-12-16 01:31</td><td align="center" width="82">이천센터</td><td align="center" width="82">터미널입고</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl03$ctl00','')">서마포</a></td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl03$ctl01','')">이천센터</a></td><td align="center" width="80">&nbsp;</td><td align="center" width="80">&nbsp;</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl03$ctl02','')"></a></td>
	</tr><tr>
		<td align="center" width="145">2015-12-16 01:36</td><td align="center" width="82">이천센터</td><td align="center" width="82">터미널출고</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl04$ctl00','')">이천센터</a></td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl04$ctl01','')">북송파</a></td><td align="center" width="80">&nbsp;</td><td align="center" width="80">&nbsp;</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl04$ctl02','')"></a></td>
	</tr><tr>
		<td align="center" width="145">2015-12-16 07:50</td><td align="center" width="82">북송파</td><td align="center" width="82">배송입고</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl05$ctl00','')">이천센터</a></td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl05$ctl01','')">북송파</a></td><td align="center" width="80">송파기본</td><td align="center" width="80">&nbsp;</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl05$ctl02','')">송파기본</a></td>
	</tr><tr>
		<td align="center" width="145">2015-12-16 11:04</td><td align="center" width="82">북송파</td><td align="center" width="82">배송출고</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl06$ctl00','')">북송파</a></td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl06$ctl01','')"></a></td><td align="center" width="80">(신천)박종팔</td><td align="center" width="80">&nbsp;</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl06$ctl02','')">(신천)박종팔</a></td>
	</tr><tr>
		<td align="center" width="145">2015-12-16 16:21</td><td align="center" width="82">북송파</td><td align="center" width="82">배송완료</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl07$ctl00','')"></a></td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl07$ctl01','')"></a></td><td align="center" width="80">(신천)박종팔</td><td align="center" width="80">&nbsp;</td><td align="center" width="80"><a href="javascript:__doPostBack('gridTrace$ctl07$ctl02','')">(신천)박종팔</a></td>
	</tr><tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	*/
    $content_array4 =   explode("<tr", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    for ($i = 1; $i < $content_array4_count; $i++) {                    // 1~
        // echo "<br />" . $content_array4[$i];
        
        $text_temp = array();   // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array5 =   explode("</tr>", $content_array4[$i]);   
                     
        
        ////////////////////////////////////////////////////////////////////////////////
        // (1) 날짜
        $content_array6 =   explode("<td align=\"center\" style=\"width:145px;\">", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[1]);
        
        // html중 text 데이터만 구함                            
        $content_array7[0] = get_html_to_text_data($content_array7[0]);
                        
        $text_temp[1]   =   trim($content_array7[0]);
        // echo "<br />날짜 : <xmp>" . $text_temp[1] . "</xmp>"; exit;
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (2) 사업장
        $content_array6 =   explode("<td align=\"center\" style=\"width:145px;\">", $content_array5[0]);
        $content_array7 =   explode("<td align=\"center\" style=\"width:82px;\">", $content_array6[1]);
        $content_array8 =   explode("</td>", $content_array7[1]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);
                        
        $text_temp[2]   =   trim($content_array8[0]);
        // echo "<br />사업장 : <xmp>" . $text_temp[2] . "</xmp>"; exit;
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (3) 상태
        $content_array6 =   explode("<td align=\"center\" style=\"width:145px;\">", $content_array5[0]);
        $content_array7 =   explode("<td align=\"center\" style=\"width:82px;\">", $content_array6[1]);
        $content_array8 =   explode("</td>", $content_array7[2]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);
                        
        $text_temp[3]   =   trim($content_array8[0]);
        // echo "<br />상태 : <xmp>" . $text_temp[3] . "</xmp>"; exit;
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (4) 발송점
        $content_array6 =   explode("<td align=\"center\" style=\"width:145px;\">", $content_array5[0]);
        $content_array7 =   explode("ctl00','')\">", $content_array6[1]);
        $content_array8 =   explode("</a>", $content_array7[1]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);

        $text_temp[4]   =   trim($content_array8[0]);
        // echo "<br />발송점 : <xmp>" . $text_temp[4] . "</xmp>"; exit;
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (5) 도착점
        $content_array6 =   explode("<td align=\"center\" style=\"width:145px;\">", $content_array5[0]);
        $content_array7 =   explode("ctl01','')\">", $content_array6[1]);
        $content_array8 =   explode("</a>", $content_array7[1]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);

        $text_temp[5]   =   trim($content_array8[0]);
        // echo "<br />도착점 : <xmp>" . $text_temp[5] . "</xmp>"; exit;
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (6) 담당직원
        $content_array6 =   explode("<td align=\"center\" style=\"width:145px;\">", $content_array5[0]);
        $content_array7 =   explode("ctl01','')\">", $content_array6[1]);
        $content_array8 =   explode("<td align=\"center\" style=\"width:80px;\">", $content_array7[1]);
        $content_array9 =   explode("</td>", $content_array8[1]);
        
        // html중 text 데이터만 구함                            
        $content_array9[0] = get_html_to_text_data($content_array9[0]);
                        
        $text_temp[6]   =   trim($content_array9[0]);
        // echo "<br />담당직원 : <xmp>" . $text_temp[6] . "</xmp>"; exit;
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (7) 인수자
        $content_array6 =   explode("<td align=\"center\" style=\"width:145px;\">", $content_array5[0]);
        $content_array7 =   explode("ctl01','')\">", $content_array6[1]);
        $content_array8 =   explode("<td align=\"center\" style=\"width:80px;\">", $content_array7[1]);
        $content_array9 =   explode("</td>", $content_array8[2]);       // 2
        
        // html중 text 데이터만 구함                            
        $content_array9[0] = get_html_to_text_data($content_array9[0]);
                        
        $text_temp[7]   =   trim($content_array9[0]);
        // echo "<br />인수자 : <xmp>" . $text_temp[7] . "</xmp>"; exit;
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (8) 영업소
        $content_array6 =   explode("<td align=\"center\" style=\"width:145px;\">", $content_array5[0]);
        $content_array7 =   explode("ctl02','')\">", $content_array6[1]);
        $content_array8 =   explode("</a>", $content_array7[1]);
        
        // html중 text 데이터만 구함                            
        $content_array8[0] = get_html_to_text_data($content_array8[0]);

        $text_temp[8]   =   trim($content_array8[0]);
        // echo "<br />영업소 : <xmp>" . $text_temp[8] . "</xmp>"; exit;
        
        
        // 통과할 항목 처리
        if ($text_temp[1] == "") {
            
        }
        else {
            $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[4]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[5]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[6]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[7]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[8]) . "</td>
                </tr>
            ";    
        }
    }
    
    $result_deliverytracking  .=  "
            </tbody>
        </table>
    ";
    
    
    // 인수자정보            
    
    // 인수자 구분, 인수자, 인수자 사인
    $content_array  =   explode("<img src=\"../img/delivery/Sign.jpg\" alt=\"제목줄(인수자 구분, 인수자, 인수자 사인) \">", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    /*
    <tr>
        <td colspan="3" style="height: 41px"><img src="../img/delivery/Sign.jpg" alt="제목줄(인수자 구분, 인수자, 인수자 사인) ">
        </td>
    </tr>
    <tr style="padding-bottom:5px; height:20px">
        <td style=" width:133px; height: 1px;">
            &nbsp; &nbsp; &nbsp; &nbsp;<input name="tbSignGubun" type="text" value="없음" id="tbSignGubun" title="인수자구분" border="0" /></td>
        <td style="width: 119px">
           <input name="tbSignNM" type="text" value="없음" id="tbSignNM" title="인수자명" border="0" /></td>
        <td style="width:600px; height: 1px;">
            <img id="SignImage" alt="인수자 사인" src="http://pds.ilogen.com/Data/Photo/PDA_SIGN/NoSign.jpg" border="0" /></td>                   
    </tr>
    <tr>
        <td colspan="3" bgcolor="#cccccc" style="height:1px;"> </td>
    </tr>
	*/
	
	$text_temp = array();       // 텍스트 데이터 저장할 배열 변수
	
	// (1) 인수자 구분
    $content_array3 =   explode("<input name=\"tbSignGubun\" type=\"text\" value=\"", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbSignGubun\"", $content_array3[1]);            
    $text_temp[1]   =   get_html_to_text_data($content_array4[0]);                          // html중 text 데이터만 구함
    // echo "<br />인수자구분 : <xmp>" . $text_temp[1] . "</xmp>"; exit;
    
    
    // (2) 인수자
    $content_array3 =   explode("<input name=\"tbSignNM\" type=\"text\" value=\"", $content_array2[0]);            
    $content_array4 =   explode("\" id=\"tbSignNM\"", $content_array3[1]);            
    $text_temp[2]   =   get_html_to_text_data($content_array4[0]);
    // echo "<br />인수자 : <xmp>" . $text_temp[2] . "</xmp>"; exit;
	
	
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"50%\" />
                <col width=\"50%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"2\">인수자정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">인수자구분</th>
                    <th class=\"text-center\">인수자명</th>                   
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                </tr>
            </tbody>
        </table>
    ";
    
    return $result_deliverytracking;
}

?>