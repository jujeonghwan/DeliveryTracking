<?php

////////////////////////////////////////////////////////////////////////////////
// KGB택배

// 배송조회결과 구함 (KGB택배)
function get_result_deliverytracking_kgbls($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // 데이터가 없을 경우
    $content_array  =   explode("배송조회결과</td>", $content_temp);
    $content_array2 =   explode("처리상태</td>", $content_array[1]);
    $content_array3 =   explode("/images/img_sub0505_02.png", $content_array2[1]);
    $content_array4 =   explode("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">", $content_array3[0]);
    $content_array5 =   explode("<td colspan=\"4\" class=\"board_middleline\"></td>", $content_array4[1]);
    
    $content_array5_count   =   count($content_array5);
    
    // echo "<br />content_array5[0] : <xmp>" . $content_array5[0] . "</xmp>";
    // echo "<br />content_array5[1] : <xmp>" . $content_array5[1] . "</xmp>";
    // echo "<br />content_array5_count : " . $content_array5_count; exit;
    
    if ($content_array5_count < 2) {
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
    
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("운송장번호를 정확하게 입력해 주십시오", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "운송장번호를 정확하게 입력해 주십시오";
        
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
    // 1.배송조회결과
    
    // 처리대리점, 처리일시, 처리상태
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"30%\" />
                <col width=\"50%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"3\">배송조회결과</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">처리대리점</th>
                    <th class=\"text-center\">처리일시</th>
                    <th class=\"text-center\">처리상태</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    // 처리대리점, 처리일시, 처리상태
    $content_array  =   explode("배송조회결과</td>", $content_temp);
    $content_array2 =   explode("처리상태</td>", $content_array[1]);
    $content_array3 =   explode("/images/img_sub0505_02.png", $content_array2[1]);
    $content_array4 =   explode("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">", $content_array3[0]);
    /*
    </tr>
           <tr>
        <td colspan="4" height="40" class="text01">배송조회결과</td>
      </tr>
      <tr>
        <td class="board_topline"></td>
      </tr>
      <tr>
        <td valign="middle" class="board_title"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" width="15%">처리대리점</td>
              <td align="center" width="30%">처리일시</td>
              <td align="center" width="55%">처리상태</td>
            </tr>
          </table></td>
      <tr>
        <td class="board_middleline"></td>
      </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>
                <td width="15%" height="34" align="center">안산</td>
                <td align="center" width="30%">2016-05-16</td>
        <td height="34" colspan=3>고객님의 물품이 KGB택배에 접수되었습니다.</td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
    
      <tr>
        <td width="15%" height="34" align="center">안산</td>
        <td align="center" width="30%">2016-05-16&nbsp;00:00</td>
        <td  width="55%">
                            안산대리점(0505-1100-306) <BR />안산대리점에서 물품을 접수했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">안산</td>
        <td align="center" width="30%">2016-05-16&nbsp;00:00</td>
        <td  width="55%">
                            안산대리점(0505-1100-306) <BR />안산대리점에서 물품을 접수했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">옥천TML</td>
        <td align="center" width="30%">2016-05-17&nbsp;02:45</td>
        <td  width="55%">
                            KGB터미널에 도착했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">옥천TML</td>
        <td align="center" width="30%">2016-05-19&nbsp;22:18</td>
        <td  width="55%">
                            KGB터미널에 도착했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">옥천TML</td>
        <td align="center" width="30%">2016-05-17&nbsp;03:01</td>
        <td  width="55%">
                            KGB터미널에서 출발했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">옥천TML</td>
        <td align="center" width="30%">2016-05-19&nbsp;22:21</td>
        <td  width="55%">
                            KGB터미널에서 출발했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">서부산</td>
        <td align="center" width="30%">2016-05-17&nbsp;09:55</td>
        <td  width="55%">
                            서부산대리점(0505-1100-511) <BR />서부산대리점에 도착했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">안산</td>
        <td align="center" width="30%">2016-05-20&nbsp;08:26</td>
        <td  width="55%">
                            안산대리점(0505-1100-306) <BR />안산대리점에 도착했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">서부산</td>
        <td align="center" width="30%">2016-05-17&nbsp;11:41</td>
        <td  width="55%">
                            김민호 영업소장님<B>[HP:070--8022--181]</b>이 배송을 시작했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">서부산</td>
        <td align="center" width="30%">2016-05-18&nbsp;10:28</td>
        <td  width="55%">
                            김민호 영업소장님<B>[HP:070--8022--181]</b>이 배송을 시작했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
      <tr>
        <td width="15%" height="34" align="center">서부산</td>
        <td align="center" width="30%">2016-05-19&nbsp;11:13</td>
        <td  width="55%">
                            김민호 영업소장님<B>[HP:070--8022--181]</b>이 배송을 시작했습니다.

        </td>
      </tr>
      <tr>
        <td colspan="4" class="board_middleline"></td>
      </tr>
                
        </tr>




       <tr>
        <td colspan="4" height="20"></td>
      </tr>
      <tr>
        <td align="center" colspan="4"><img src="/images/img_sub0505_02.png" onclick="history.back()" style="cursor:pointer;"></td>
      </tr>
    </table>
    */
    $content_array5 =   explode("<td colspan=\"4\" class=\"board_middleline\"></td>", $content_array4[1]);
    
    $content_array5_count   =   count($content_array5);
    
    // echo "<br />content_array5_count : " . $content_array5_count; exit;
    
    for ($i = 0; $i < ($content_array5_count - 1); $i++) {                      // 0~
        // echo "<br />" . $content_array4[$i];
        
        $text_temp = array();   // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array6 =   explode("</td>", $content_array5[$i]);   
                     
        
        ////////////////////////////////////////////////////////////////////////////////
        // (1) 처리대리점
        $content_array7 =   explode("<td width=\"15%\" height=\"34\" align=\"center\">", $content_array6[0]);
        
        // html중 text 데이터만 구함                            
        $content_array7[1] = get_html_to_text_data($content_array7[1]);
                        
        $text_temp[1]   =   trim($content_array7[1]);
        
        
        ////////////////////////////////////////////////////////////////////////////////
        // (2) 처리일시
        $content_array7 =   explode("<td align=\"center\" width=\"30%\">", $content_array6[1]);
        
        // html중 text 데이터만 구함                            
        $content_array7[1] = get_html_to_text_data($content_array7[1]);
                        
        $text_temp[2]   =   trim($content_array7[1]);

        
        ////////////////////////////////////////////////////////////////////////////////
        // (3) 처리상태

        // $content_array7 =   explode("<td  width=\"55%\">", $content_array6[2]);      
        // $content_array7 =   explode("<td height=\"34\" colspan=3>", $content_array6[2]);      
        $content_array7 =   explode(">", $content_array6[2]);      

        // html중 text 데이터만 구함                            
        $content_array7[1] = get_html_to_text_data($content_array7[1]);
                        
        $text_temp[3]   =   trim($content_array7[1]);

                
        $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                    <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                    <td class=\"text-left\">" . $text_temp[3] . "</td>
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