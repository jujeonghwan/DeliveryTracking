<?php

////////////////////////////////////////////////////////////////////////////////
// GTX로지스

// 배송조회결과 구함 (GTX로지스)
function get_result_deliverytracking_gtxlogis($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("조회하신 운송장 번호에 대한 자료가 없습니다! 확인후 다시 조회를 해 주시기 바랍니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    조회하신 운송장 번호에 대한 자료가 없습니다! 확인후 다시 조회를 해 주시기 바랍니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "조회하신 운송장 번호에 대한 자료가 없습니다! 확인후 다시 조회를 해 주시기 바랍니다.";
        
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
                
    // 운송장번호 보내는 분 받는 분 주소 배송상태 인수자

    /*
    <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="200"><img src="../img/sotit4_2_3.gif" width="200" height="25"></td>
            <td style="padding-right:10px" align="right" class="chan_12"><b>운송장번호 : 605030759163</b></td>
        </tr>
    </table>
    
    <!-- 기본정보-->
    <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="7" bgcolor="333333" height="2"></td>
        </tr>
        <tr>
            <td width="100" height="34" class="lee_07" align="center"><strong>보내는 분</strong></td>
            <td valign="top" width="10" align="Center">
                <table width="1" border="0" cellpadding="0" cellspacing="0" >
    			    <tr bgcolor="#333333">
    				    <td width="1" height="20"></td>
    			    </tr>
    		    </table>
    		</td>
            <td width="150" align="center" class="jeon_07">(주)아보키스트</td>
            <td width="10">&nbsp;</td>
            <td width="100" class="lee_07"  align="center"><strong>배송상태</strong></td>
            <td valign="top" width="10" align="Center">
				<table width="1" border="0" cellpadding="0" cellspacing="0" >
					<tr bgcolor="#333333">
						<td width="1" height="20"></td>
					</tr>
				</table>
			</td>
            <td align="center" class="jeon_07">배달완료</td>
      </tr>
      <tr>
            <td colspan="7" bgcolor="#DDDDDD" height="1"></td>
      </tr>
      <tr>
            <td height="34" class="lee_07"  align="center"><strong>받는 분</strong></td>
            <td valign="top" align="center">
    		    <table width="1" border="0" cellpadding="0" cellspacing="0" >
    			    <tr bgcolor="#DfDfDf">
    				    <td width="1" height="20"></td>
    				</tr>
    			</table>
    		</td>
            <td align="center" class="jeon_07">서동진</td>
            <td>&nbsp;</td>
            <td class="lee_07"  align="center"><strong><!-- 배송(예정)영업소 --></strong></td>
            <td valign="top" align="center">
				<table width="1" border="0" cellpadding="0" cellspacing="0" >
					<tr bgcolor="#DfDfDf">
						<td width="1" height="20"></td>
					</tr>
				</table>
			</td>
            <td align="center" class="jeon_07">    </td>
        </tr>
        <tr>
            <td colspan="7" bgcolor="#DDDDDD" height="1"></td>
        </tr>
        <tr>
            <td height="34" class="lee_07"  align="center"><strong>주소</strong></td>
            <td valign="top" align="center">
				<table width="1" border="0" cellpadding="0" cellspacing="0" >
    				<tr bgcolor="#DfDfDf">
    					<td width="1" height="20"></td>
    				</tr>
				</table>
			</td>
            <td align="center" class="jeon_07">    
    		    충남 천안시 서북구&times;&times;&times;&times;
    		</td>
            <td>&nbsp;</td>
            <td class="lee_07"  align="center"><strong>인수자</strong></td>
            <td valign="top" align="center">
				<table width="1" border="0" cellpadding="0" cellspacing="0" >
					<tr bgcolor="#DfDfDf">
						<td width="1" height="20"></td>
					</tr>
				</table>
			</td>
            <td align="center" class="jeon_07">경비실 </td>
        </tr>
      
        <tr>
            <td colspan="7" bgcolor="#DDDDDD" height="2"></td>
        </tr>
    </table>
    */
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) 운송장번호
    $content_array  =   explode("<b>운송장번호 : ", $content_temp);
    $content_array2 =   explode("</b></td>", $content_array[1]);
    
    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);              // html중 text 데이터만 구함
    
    // (2) 보내는 분
    $content_array  =   explode("<strong>보내는 분</strong>", $content_temp);
    $content_array2 =   explode("<td width=\"10\">&nbsp;</td>", $content_array[1]);
    $content_array3 =   explode("<td width=\"150\" align=\"center\" class=\"jeon_07\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    
    $text_temp[2]   =   get_html_to_text_data($content_array4[0]);
    
    // (3) 받는 분
    $content_array  =   explode("<strong>받는 분</strong>", $content_temp);
    $content_array2 =   explode("<td>&nbsp;</td>", $content_array[1]);
    $content_array3 =   explode("<td align=\"center\" class=\"jeon_07\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    
    $text_temp[3]   =   get_html_to_text_data($content_array4[0]);
    
    // (4) 주소
    $content_array  =   explode("<strong>주소</strong>", $content_temp);
    $content_array2 =   explode("<td>&nbsp;</td>", $content_array[1]);
    $content_array3 =   explode("<td align=\"center\" class=\"jeon_07\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    
    $text_temp[4]   =   get_html_to_text_data($content_array4[0]);
    
    // (5) 배송상태
    $content_array  =   explode("<strong>배송상태</strong>", $content_temp);
    $content_array2 =   explode("<td colspan=\"7\" bgcolor=\"#DDDDDD\" height=\"1\"></td>", $content_array[1]);
    $content_array3 =   explode("<td align=\"center\" class=\"jeon_07\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    
    $text_temp[5]   =   get_html_to_text_data($content_array4[0]);
    
    // (6) 인수자
    $content_array  =   explode("<strong>인수자</strong>", $content_temp);
    $content_array2 =   explode("<td colspan=\"7\" bgcolor=\"#DDDDDD\" height=\"2\"></td>", $content_array[1]);
    $content_array3 =   explode("<td align=\"center\" class=\"jeon_07\">", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    
    $text_temp[6]   =   get_html_to_text_data($content_array4[0]);
    
    // print_r($text_temp); exit;
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"25%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />                
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"6\">기본정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">운송장번호</th>
                    <th class=\"text-center\">보내는 분</th>
                    <th class=\"text-center\">받는 분</th>
                    <th class=\"text-center\">주소</th>
                    <th class=\"text-center\">배송상태</th>
                    <th class=\"text-center\">인수자</th>                        
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
    // 2.추적현황
    
    // 추적현황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"40%\" />
                
                <col width=\"15%\" />
                <col width=\"15%\" />  
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">추적현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜</th>
                    <th class=\"text-center\">시간</th>
                    <th class=\"text-center\">위치</th>
                    
                    <th class=\"text-center\">연락처</th>                            
                    <th class=\"text-center\">진행현황</th>                          
                </tr>
            </thead>
            <tbody>
    ";
    
    // 날짜, 시간, 위치, 연락처, 진행현황
    $content_array  =   explode("<td><img src=\"../img/sotit4_2_4.gif\" width=\"200\" height=\"25\"></td>", $content_temp);
    $content_array2 =   explode("<td colspan=\"9\" bgcolor=\"#dddddd\" height=\"3\"></td>", $content_array[1]);
    /*
    <table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="../img/sotit4_2_4.gif" width="200" height="25"></td>
              </tr>
            </table>
            <table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="9" bgcolor="#333333" height="2"></td>
              </tr>
              <tr>
                <td width="80" height="34" align="Center" class="lee_07"><strong>날 짜</strong></td>
                <td valign="top" width="10" align="Center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#333333">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td width="50" align="Center" class="lee_07"><strong>시간</strong></td>
                <td valign="top" width="10" align="Center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#333333">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td width="100" align="Center" class="lee_07"><strong>위치</strong></td>
                <td valign="top" width="10" align="Center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#333333">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td width="100" align="Center" class="lee_07"><strong>연락처</strong></td>
                <td valign="top" width="10" align="Center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#333333">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td align="Center" class="lee_07"><strong>진행현황</strong></td>
              </tr>
              <tr>
                <td colspan="9" bgcolor="#dddddd" height="1"></td>
              </tr>

<!-- 임의스캔 S-->

<!-- 임의스캔 E-->



              <tr>
                <td height="34" class="lee_09" align="Center">2015/04/22</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">11:15</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">본사(아보키(CJ)_본사)</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">1588-1756</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">집하&nbsp;<FONT COLOR="BLUE">1</FONT></td>
              </tr>
              <tr>
                <td colspan="9" bgcolor="#dddddd" height="1"></td>
              </tr>


<!-- 임시S -->

<!-- 임시E -->


              <tr>
                <td height="34" class="lee_09" align="Center">2015/04/25</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">02:39</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">천안</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">010-9638-5225</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">간선하차&nbsp;<FONT COLOR="BLUE"></FONT></td>
              </tr>
              <tr>
                <td colspan="9" bgcolor="#dddddd" height="1"></td>
              </tr>


<!-- 임시S -->

<!-- 임시E -->


              <tr>
                <td height="34" class="lee_09" align="Center">2015/04/25</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">02:42</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">천안(이승룡_천안)</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">010-9638-5225</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">배달준비&nbsp;<FONT COLOR="BLUE"></FONT></td>
              </tr>
              <tr>
                <td colspan="9" bgcolor="#dddddd" height="1"></td>
              </tr>


<!-- 임시S -->

<!-- 임시E -->


              <tr>
                <td height="34" class="lee_09" align="Center">2015/04/25</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">20:41</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">천안(이승룡_천안)</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">010-9638-5225</td>
                <td valign="top" align="center">
									<table width="1" border="0" cellpadding="0" cellspacing="0" >
											<tr bgcolor="#DfDfDf">
												<td width="1" height="20"></td>
											</tr>
									</table>
								</td>
                <td class="lee_09" align="Center">배달완료&nbsp;<FONT COLOR="BLUE">경비실|02</FONT></td>
              </tr>
              <tr>
                <td colspan="9" bgcolor="#dddddd" height="1"></td>
              </tr>


<!-- 임시S -->

<!-- 임시E -->
	


              <tr>
                <td colspan="9" bgcolor="#dddddd" height="3"></td>
              </tr>
           
            </table>
            <br>

			<!-- 하단 테이블 -->
            <table width="500" border="0" cellpadding="8" cellspacing="1" bgcolor="#dddddd">
              <tr>
                <td height="32" align="Center" bgcolor="#FFFFFF" class="hoo_04">배송완료 시간은 실제 받으신 시간과 다를 수 있습니다. </td>
              </tr>
            </table></td>
	*/
    $content_array3 =   explode("<td height=\"34\" class=\"lee_09\" align=\"Center\">", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array4 =   explode("<td colspan=\"9\" bgcolor=\"#dddddd\" height=\"1\"></td>", $content_array3[$i]);   
                     
        /*                     
        echo "<br /><br /><br />";
        echo "<xmp>";        
        echo $content_array4[0];
        echo "</xmp>";
        */
        
        // (1) 날짜
        $content_array5 =   explode("</td>", $content_array4[0]);
        
        $text_temp[1]   =   get_html_to_text_data($content_array5[0]);
        
        // (2) 시간
        $content_array5 =   explode("<td class=\"lee_09\" align=\"Center\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[1]);               // 1
        
        $text_temp[2]   =   get_html_to_text_data($content_array6[0]);
        
        // (3) 위치
        $content_array5 =   explode("<td class=\"lee_09\" align=\"Center\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[2]);               // 2
        
        $text_temp[3]   =   get_html_to_text_data($content_array6[0]);
        
        // (4) 연락처
        $content_array5 =   explode("<td class=\"lee_09\" align=\"Center\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[3]);               // 3
        
        $text_temp[4]   =   get_html_to_text_data($content_array6[0]);
        
        // (5) 진행현황
        $content_array5 =   explode("<td class=\"lee_09\" align=\"Center\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[4]);               // 4
        
        $text_temp[5]   =   get_html_to_text_data($content_array6[0]);
        
        
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