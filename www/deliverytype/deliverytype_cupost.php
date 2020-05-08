<?php

////////////////////////////////////////////////////////////////////////////////
// CU편의점택배

// 배송조회결과 구함 (CU편의점택배)
function get_result_deliverytracking_cupost($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("검색된 결과가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "검색된 결과가 없습니다.";
        
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
    // 1.예약정보
    // 운송장번호, 상품정보, 접수일자, 접수시간, 보내는분, 받는분, 점포명, 구분
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수

    $content_array  =   explode("<caption>당일특송 배송조회 결과 기본배송정보 표입니다. 운송장번호, 상품정보, 접수일자, 접수시간, 보내는분, 받는분, 점포명, 구분 정보를 확인할 수 있습니다.</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);            

    // (1) 운송장번호
    $content_array3 =   explode("<th scope=\"row\">운송장번호</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    $text_temp[1]   =   get_html_to_text_data($content_array5[1]);       
    // echo "<br />" . $text_temp[1]; exit;

    // (2) 상품정보
    $content_array3 =   explode("<th scope=\"row\">상품정보</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    $text_temp[2]   =   get_html_to_text_data($content_array5[1]);       
    // echo "<br />" . $text_temp[2]; exit;

    // (3) 접수일자
    $content_array3 =   explode("<th scope=\"row\">접수일자</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    $text_temp[3]   =   get_html_to_text_data($content_array5[1]);       
    // echo "<br />" . $text_temp[3]; exit;

    // (4) 접수시간
    $content_array3 =   explode("<th scope=\"row\">접수시간</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    $text_temp[4]   =   get_html_to_text_data($content_array5[1]);       
    // echo "<br />" . $text_temp[4]; exit;

    // (5) 보내는분
    $content_array3 =   explode("<th scope=\"row\">보내는분</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    $text_temp[5]   =   get_html_to_text_data($content_array5[1]);       
    // echo "<br />" . $text_temp[5]; exit;

    // (6) 받는분
    $content_array3 =   explode("<th scope=\"row\">받는분</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    $text_temp[6]   =   get_html_to_text_data($content_array5[1]);       
    // echo "<br />" . $text_temp[6]; exit;

    // (7) 점포명
    $content_array3 =   explode("<th scope=\"row\">점포명</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    $text_temp[7]   =   get_html_to_text_data($content_array5[1]);       
    // echo "<br />" . $text_temp[7]; exit;

    // (8) 구분
    $content_array3 =   explode("<th scope=\"row\">구분</th>", $content_array2[0]);
    $content_array4 =   explode("</td>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    $text_temp[8]   =   get_html_to_text_data($content_array5[1]);       
    // echo "<br />" . $text_temp[8]; exit;
    
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
                    <th class=\"text-center\" colspan=\"4\">예약정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">운송장번호</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">상품정보</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">접수일자</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">접수시간</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">보내는분</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <th class=\"active text-center\">받는분</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">점포명</th>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>
                    <th class=\"active text-center\">구분</th>
                    <td class=\"text-center\">" . $text_temp[8] . "</td>                         
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 2.배송정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수

    $content_array  =   explode("<caption style=\"display: none;\">배송 상세 내역 표</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);            
    $content_array3 =   explode("<tbody>", $content_array2[0]);
    $content_array4 =   explode("</tbody>", $content_array3[1]);
    $content_array5 =   explode("<td height=\"0\">", $content_array4[0]);

    $content_array5_count   =   count($content_array5);
    // echo "<br />" . $content_array5_count; exit;
    for ($i = 1; $i < $content_array5_count; $i++) {

        $content_array6 =   explode("</td>", $content_array5[$i]);
        $text_temp[$i]  =   get_html_to_text_data($content_array6[0]);       
        // echo "<br />" . $text_temp[$i]; exit;
    }
    // print_r($text_temp); exit;
    
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
                    <th class=\"text-center\" colspan=\"5\">배송정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">운송장번호</th>
                    <th class=\"text-center\">보내는분</th>
                    <th class=\"text-center\">받는분</th>
                    <th class=\"text-center\">물품정보</th>
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
                </tr>
            </tbody>
        </table>
    ";    
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 3.배송상태
    
    // 
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"40%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">배송상태</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">추적일시</th>
                    <th class=\"text-center\">화물상태</th>
                    <th class=\"text-center\">담당집배점</th>
                    <th class=\"text-center\">상대집배점</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    // 추적일시, 화물상태, 담당집배점, 상대집배점
    $content_array  =   explode("<caption style=\"display:none;\" >배송상태</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<th>상대집배점</th>", $content_array2[0]);
    
    
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
        // (1) 추적일시
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[1]);
        
        // html중 text 데이터만 구함                            
        $text_temp[1] = get_html_to_text_data($content_array7[0]);
        // echo "<br />" . $text_temp[1]; exit;
        

        ////////////////////////////////////////////////////////////////////////////////
        // (2) 화물상태
        $content_array6 =   explode("<td style=\"text-align: left; padding-left: 5px;\">", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[1]);
        
        // html중 text 데이터만 구함                            
        $text_temp[2] = get_html_to_text_data($content_array7[0]);
        // echo "<br />" . $text_temp[2]; exit;


        ////////////////////////////////////////////////////////////////////////////////
        // (3) 담당집배점
        $content_array6 =   explode("class=\"board_contents\">", $content_array5[0]);
        $content_array7 =   explode("</a></td>", $content_array6[1]);
        
        // html중 text 데이터만 구함                            
        $text_temp[3] = get_html_to_text_data($content_array7[0]);
        // echo "<br />" . $text_temp[3]; exit;


        ////////////////////////////////////////////////////////////////////////////////
        // (4) 상대집배점
        $content_array6 =   explode("<td", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[4]);               // 4
        $content_array8 =   explode(">", $content_array7[0]);

        // html중 text 데이터만 구함                            
        $text_temp[4] = get_html_to_text_data($content_array8[1]);
        // echo "<br />" . $text_temp[4]; exit;
        
        $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td>" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>                    
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                                
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