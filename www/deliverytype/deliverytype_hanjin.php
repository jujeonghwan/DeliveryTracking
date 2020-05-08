<?php

////////////////////////////////////////////////////////////////////////////////
// 한진택배

// 배송조회결과 구함 (한진택배)
function get_result_deliverytracking_hanjin($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("window.location.href=\"result_error.jsp\";", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    <html><head><title>Object moved</title></head><body>
    <h2>Object moved to <a href="%2fiLOGEN.Web.New%2fTRACE%2fTraceNoView.aspx">here</a>.</h2>
    </body></html>
    */
    
    if ($content_array_count > 1) {
        $text_temp = "고객님께서 입력하신 조건의 운송 작업 내역을 찾을 수 없습니다.";
        
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
    $result_deliverytracking_last   =   "";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.기본정보
                
    // 운송장정보 상품명 운임(원) 보낸분 성명 받는분 성명 주소

    $content_array  =   explode("<caption>택배 운송장 기본 정보</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);
    $content_array4 =   explode("</tbody>", $content_array3[1]);
    /*
    <thead>
        <tr>
            <th rowspan="2" scope="col"><img src="../img/inquiry/h5_result_th01.gif" alt="운송장정보" width="48" height="12" /></th>      	  	
		    <th rowspan="2" scope="col"><img src="../img/inquiry/h5_result_th02.gif" alt="상품명" /></th>		  
		    <th rowspan="2" scope="col"><img src="../img/inquiry/h5_result_th02_01.gif" alt="운임(원)" /></th>		  
		    <!--국제특송 관부가세액 -->		  
		    <th class="bg" scope="col"><img src="../img/inquiry/h5_result_th03.gif" alt="보낸분" /></th>
		    <th colspan="2" scope="col" class="rw bg"><img src="../img/inquiry/h5_result_th04.gif" alt="받는분" /></th>
		</tr>
		<tr>
		    <th scope="col"><img src="../img/inquiry/h5_result_th05.gif" alt="성명" /></th>
		    <th scope="col"><img src="../img/inquiry/h5_result_th06.gif" alt="성명" /></th>
		    <th scope="col" class="rw"><img src="../img/inquiry/h5_result_th07.gif" alt="주소" /></th>
		</tr>
    </thead>
    
    <tbody>
        <tr>
            <td class="bb">
        	    <strong>5035 - 1783 - 4175</strong><br/>
        	          
            </td>
            <td class="bb">3도단가라 티 [레드]</td>        
            <td class="bb">신용</td>
            <!--국제특송 관부가세액 
            <td class="bb">10,000원<br />
            </td>
            -->
            <td class="bb">
                달려***
          
                님</td>
            <td class="bb">
                최영*
          
                님</td>
            <td class="bb rw">서울 송파 풍납2</td>
        </tr>
    </tbody>
    */
    
    $content_array5 =   explode("<td", $content_array4[0]);            
    
    $content_array5_count   =   count($content_array5);
    // echo "<br />content_array5_count : " . $content_array5_count;
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    for ($i = 1; $i <= $content_array5_count; $i++) {
        // echo "<br />" . $content_array5[$i];
         
        $content_array6 =   explode("</td>", $content_array5[$i]);
        
        if ($i == 1) {          // (1) 운송장정보
            $content_array7 =   explode("<strong>", $content_array6[0]);
            $content_array8 =   explode("</strong>", $content_array7[1]);
            
            $text_temp[1]   =   get_html_to_text_data($content_array8[0]);      // html중 text 데이터만 구함
            $text_temp[1]   =   blank_remove($text_temp[1]);                    // 공백을 제거함            
        }
        else if ($i == 2) {     // (2) 상품명
            $content_array7 =   explode("class=\"bb\">", $content_array6[0]);
            
            $text_temp[2]   =   get_html_to_text_data($content_array7[1]);
        }
        else if ($i == 3) {     // (3) 운임(원)
            $content_array7 =   explode("class=\"bb\">", $content_array6[0]);
            
            $text_temp[3]   =   get_html_to_text_data($content_array7[1]);
        }
        else if ($i == 5) {     // (4) 보낸분 성명
            $content_array7 =   explode("class=\"bb\">", $content_array6[0]);
            
            $text_temp[4]   =   get_html_to_text_data($content_array7[1]);
        }
        else if ($i == 6) {     // (5) 받는분 성명
            $content_array7 =   explode("class=\"bb\">", $content_array6[0]);
            
            $text_temp[5]   =   get_html_to_text_data($content_array7[1]);
        }
        else if ($i == 7) {     // (6) 받는분 주소
            $content_array7 =   explode("class=\"bb rw\">", $content_array6[0]);
            
            $text_temp[6]   =   get_html_to_text_data($content_array7[1]);
        }
    }
    
    // print_r($text_temp); exit;
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"15%\" />
                <col width=\"20%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"20%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"6\">기본정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">운송장정보</th>
                    <th class=\"text-center\">상품명</th>
                    <th class=\"text-center\">운임(원)</th>
                    <th class=\"text-center\">보낸분 성명</th>
                    <th class=\"text-center\">받는분 성명</th>
                    <th class=\"text-center\">받는분 주소</th>                        
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
    // 2.배송 진행상황
    
    // 배송 진행상황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>   
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                
                <col width=\"40%\" />
                <col width=\"15%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">배송 진행상황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜</th>
                    <th class=\"text-center\">시간</th>
                    <th class=\"text-center\">현재 위치</th>
                    
                    <th class=\"text-center\">현재 상태</th>                            
                    <th class=\"text-center\">전화번호</th>                          
                </tr>
            </thead>
            <tbody>
    ";
    
    // 날짜, 시간, 현재 위치, 현재 상태, 전화번호
    $content_array  =   explode("<caption>배송진행 상황</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);
    $content_array4 =   explode("</tbody>", $content_array3[1]);
    /*
    <!--배송 현황 table -->
    <table summary="이 표는 배송진행 상황 안내를 제공하며 날짜, 시간, 현재위치, 현재상태, 전화번호로 구성되어 있습니다.">
        <caption>배송진행 상황</caption>
        <colgroup>
        	<col style="width: 92px;" />
        	<col style="width: 57px;" />
        	<col style="width: 92px;" />
        	<col style="width: 262px;" />
        	<col style="width: 97px;" />
        </colgroup>
        <thead>
        <tr>
            <th scope="col"><img src="../img/inquiry/h5_result_th12.gif" alt="날짜" /></th>
            <th scope="col"><img src="../img/inquiry/h5_result_th13.gif" alt="시간" /></th>
            <th scope="col"><img src="../img/inquiry/h5_result_th14.gif" alt="현재위치" /></th>
            <th scope="col"><img src="../img/inquiry/h5_result_th15.gif" alt="현재상태" /></th>
            <th scope="col" class="rw"><img src="../img/inquiry/h5_result_th16.gif" alt="전화번호" /></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>2016-01-29</td>
                <td>20:38</td>
                <td>종로터미널</td>
                <td>
                	<div align="left">고객님 상품을 집하하여 <strong>종로터미널</strong>에 입고되었습니다.
            	  	
            	  	</div>
                </td>
                <td class="rw">-</td>
            </tr>
            
            <tr>
                <td>2016-01-30</td>
                <td>07:49</td>
                <td>THEDAY송파행낭</td>
                <td>
                	<div align="left"><strong>배송출발</strong> 하였습니다.
            	  	
            	  	</div>
                </td>
                <td class="rw">01081336588</td>
            </tr>
            
            <tr>
                <td>2016-02-01</td>
                <td>08:11</td>
                <td>THEDAY송파행낭</td>
                <td>
                	<div align="left"><strong>배송출발</strong> 하였습니다.
            	  	
            	  	</div>
                </td>
                <td class="rw">01081336588</td>
            </tr>
            
            <tr>
                <td rowspan="2" class="bb"><b>2016-02-01</b></td>
                <td rowspan="2" class="bb"><b>11:40</b></td>
                <td>THEDAY송파행낭</td>
                <td>
                	<div align="left"><strong>배송완료</strong> 되었습니다.
            	  	
            	  	</div>
                </td>
                <td class="rw">01081336588</td>
            </tr>            
            <tr>
              <td colspan="3" class="bb rw"><b>수령인 :
                최영*(기타)
                </b></td>
            </tr>
        </tbody>
    </table>
    <!-- //배송 현황 table -->
	*/
    $content_array5 =   explode("<tr>", $content_array4[0]);
    
    $content_array5_count   =   count($content_array5);
    
    for ($i = 1; $i < $content_array5_count; $i++) {                    // 1~
        // echo "<br />" . $content_array5[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array6 =   explode("</tr>", $content_array5[$i]);   
                     
        /*                     
        echo "<br /><br /><br />";
        echo "<xmp>";        
        echo $content_array6[0];
        echo "</xmp>";
        */
        
        ////////////////////////////////////////////////////////////////////////////////
        // 배송완료 부분 (마지막 위치)
        $content_temp_array         =   explode("<td rowspan=\"2\"", $content_array6[0]);
        $content_temp_array_count   =   count($content_temp_array);
        
        if ($content_temp_array_count > 1) {
               
            $content_array7         =   explode("</td>", $content_array6[0]);
            
            $content_array7_count   =   count($content_array7);
            
            for ($j = 0; $j < $content_array7_count; $j++) {
                
                ////////////////////////////////////////////////////////////////////////////////                
                if ($j == 0) {          // (1) 날짜
                    $content_array8 =   explode("<td rowspan=\"2\" class=\"bb\"><b>", $content_array7[$j]);
                    $content_array9 =   explode("</b>", $content_array8[1]);
                    
                    $text_temp[1]   =   get_html_to_text_data($content_array9[0]);                  // html중 text 데이터만 구함
                }
                else if ($j == 1) {     // (2) 시간
                    $content_array8 =   explode("<td rowspan=\"2\" class=\"bb\"><b>", $content_array7[$j]);
                    $content_array9 =   explode("</b>", $content_array8[1]);
                    
                    $text_temp[2]   =   get_html_to_text_data($content_array9[0]);
                }
                else if ($j == 2) {     // (3) 현재 위치
                    $content_array8 =   explode("<td>", $content_array7[$j]);
                    
                    $text_temp[3]   =   get_html_to_text_data($content_array8[1]);
                }
                else if ($j == 3) {     // (4) 현재 상태
                    $content_array8 =   explode("<div align=\"left\">", $content_array7[$j]);                    
                    $content_array9 =   explode("</div>", $content_array8[1]);
                    
                    $text_temp[4]   =   get_html_to_text_data($content_array9[0]);
                }
                else if ($j == 4) {     // (5) 전화번호
                    $content_array8 =   explode("<td class=\"rw\">", $content_array7[$j]);
                    
                    $text_temp[5]   =   get_html_to_text_data($content_array8[1]);
                }
                
            }   
            
            $result_deliverytracking_last  .=  "
                <tr>
                    <td class=\"text-center\" rowspan=\"2\">" . strip_tags($text_temp[1]) . "</td>
                    <td class=\"text-center\" rowspan=\"2\">" . strip_tags($text_temp[2]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[4]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[5]) . "</td>
                </tr>
            "; 
            
            // for ($i = 1; $i < $content_array5_count; $i++) { 빠져나감
            continue;        
        }
                
        
        ////////////////////////////////////////////////////////////////////////////////
        // 수령인 부분 (마지막 위치)
        $content_temp_array         =   explode("<td colspan=\"3\" class=\"bb rw\">", $content_array6[0]);
        $content_temp_array_count   =   count($content_temp_array);
        
        if ($content_temp_array_count > 1) {
            
            $content_array7 =   explode("</td>", $content_array6[0]);
            $content_array8 =   explode("<td colspan=\"3\" class=\"bb rw\">", $content_array7[0]);
            
            $text_temp[1]   =   get_html_to_text_data($content_array8[1]);      // html중 text 데이터만 구함
            
                
            $result_deliverytracking_last  .=  "
                <tr>
                    <td class=\"text-center\" colspan=\"3\">" . strip_tags($text_temp[1]) . "</td>
                </tr>
            ";   
            
            // for ($i = 1; $i < $content_array5_count; $i++) { 빠져나감
            continue;                 
        }
                
        
        ////////////////////////////////////////////////////////////////////////////////
        // 일반 목록
        
        if ($content_temp_array_count <= 1) {
            
            $content_array7         =   explode("</td>", $content_array6[0]);
            
            $content_array7_count   =   count($content_array7);
            
            for ($j = 0; $j < $content_array7_count; $j++) {
                
                ////////////////////////////////////////////////////////////////////////////////                
                if ($j == 0) {          // (1) 날짜
                    $content_array8 =   explode("<td>", $content_array7[$j]);
                    
                    $text_temp[1]   =   get_html_to_text_data($content_array8[1]);
                }
                else if ($j == 1) {     // (2) 시간
                    $content_array8 =   explode("<td>", $content_array7[$j]);
                    
                    $text_temp[2]   =   get_html_to_text_data($content_array8[1]);
                }
                else if ($j == 2) {     // (3) 현재 위치
                    $content_array8 =   explode("<td>", $content_array7[$j]);
                    
                    $text_temp[3]   =   get_html_to_text_data($content_array8[1]);
                }
                else if ($j == 3) {     // (4) 현재 상태
                    $content_array8 =   explode("<div align=\"left\">", $content_array7[$j]);                    
                    $content_array9 =   explode("</div>", $content_array8[1]);
                    
                    $text_temp[4]   =   get_html_to_text_data($content_array9[0]);
                }
                else if ($j == 4) {     // (5) 전화번호
                    $content_array8 =   explode("<td class=\"rw\">", $content_array7[$j]);
                    
                    $text_temp[5]   =   get_html_to_text_data($content_array8[1]);
                }
                
            }            
            
            $result_deliverytracking .= "
                <tr>
                    <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[4]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[5]) . "</td>
                </tr>
            ";
            
            // for ($i = 1; $i < $content_array5_count; $i++) { 빠져나감
            continue;        
        }
    }
    
    $result_deliverytracking  .=  $result_deliverytracking_last;
    
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