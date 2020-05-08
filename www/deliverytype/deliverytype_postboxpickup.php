<?php

////////////////////////////////////////////////////////////////////////////////
// 포스트박스편의점PICK-UP(CU,GS25)

// 배송조회결과 구함 (포스트박스편의점PICK-UP(CU,GS25))
function get_result_deliverytracking_postboxpickup($content_temp) {                                 

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
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수

    // (1) 송장번호
    // <dd><input type="text" id=invoice_no name="invoice_no" maxlength="20" onkeydown="return onlyNumber(this,event)" value="7006753014"/><span>('-'없이 입력)</span></dd>
    $content_array  =   explode("<dd><input type=\"text\" id=invoice_no name=\"invoice_no\" maxlength=\"20\" onkeydown=\"return onlyNumber(this,event)\" value=\"", $content_temp);
    $content_array2 =   explode("\"/><span>('-'없이 입력)</span></dd>", $content_array[1]);
    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);       
    // echo "<br />" . $text_temp[1]; exit;


    ////////////////////////////////////////////////////////////////////////////////
    // (2)~(10) 송하인 고객 정보, 수취인 고객 정보, 벤더 정보 (성명, 전화번호, 주소)    

    $content_array  =   explode("<caption>예약현황 기본정보</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    // echo "<br /><xmp>" . $content_array2[0] . "</xmp>"; exit;
    
    ////////////////////////////////////////
    // 성명
    $content_array3 =   explode("<th>성 명</th>", $content_array2[0]);    
    $content_array4 =   explode("</tr>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    // (2) 송하인 성명
    $content_array6 =   explode("</td>", $content_array5[1]);                   // 1
    $text_temp[2]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[2]; exit;

    // (3) 수취인 성명
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $text_temp[3]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[3]; exit;

    // (4) 벤더 이름
    $content_array6 =   explode("</td>", $content_array5[3]);                   // 3
    $text_temp[4]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[4]; exit;

    ////////////////////////////////////////
    // 전화
    $content_array3 =   explode("<th>전 화</th>", $content_array2[0]);    
    $content_array4 =   explode("</tr>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    // (5) 송하인 전화
    $content_array6 =   explode("</td>", $content_array5[1]);                   // 1
    $text_temp[5]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[5]; // exit;

    // (6) 수취인 전화
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $text_temp[6]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[6]; // exit;

    // (7) 벤더 전화
    $content_array6 =   explode("</td>", $content_array5[3]);                   // 3
    $text_temp[7]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[7]; exit;

    ////////////////////////////////////////
    // 주소
    $content_array3 =   explode("<th>주 소</th>", $content_array2[0]);    
    $content_array4 =   explode("</tr>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    // (8) 송하인 주소
    $content_array6 =   explode("</td>", $content_array5[1]);                   // 1
    $text_temp[8]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[8]; // exit;

    // (9) 수취인 주소
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $text_temp[9]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[9]; // exit;

    // (10) 벤더 주소
    $content_array6 =   explode("</td>", $content_array5[3]);                   // 3
    $text_temp[10]  =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[10]; exit;
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"10%\" />
                <col width=\"30%\" />
                <col width=\"30%\" />
                <col width=\"30%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">예약정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\" colspan=\"2\">송장번호</th>
                    <td class=\"text-center\" colspan=\"2\">" . $text_temp[1] . "</td>
                </tr>

                <tr>
                    <th class=\"active text-center\">구분</th>
                    <th class=\"active text-center\">송하인</th>
                    <th class=\"active text-center\">수취인</th>
                    <th class=\"active text-center\">벤더</th>                      
                </tr>
                <tr>
                    <th class=\"active text-center\">성명</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">전화</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">주소</th>
                    <td class=\"text-center\">" . $text_temp[8] . "</td>
                    <td class=\"text-center\">" . $text_temp[9] . "</td>
                    <td class=\"text-center\">" . $text_temp[10] . "</td>                         
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 2.편의점 정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수

    ////////////////////////////////////////////////////////////////////////////////
    // (1)~(3) 상품명, 배송구분, 도착 점포

    $content_array  =   explode("<caption>편의점 정보</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);    
    $content_array4 =   explode("</tr>", $content_array3[1]);
    $content_array5 =   explode("<td>", $content_array4[0]);

    // (1) 상품명
    $content_array6 =   explode("</td>", $content_array5[1]);                   // 1
    $text_temp[1]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[1]; exit;

    // (2) 배송구분
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $text_temp[2]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[2]; exit;

    // (3) 도착 점포
    $content_array6 =   explode("</td>", $content_array5[3]);                   // 3
    $text_temp[3]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[3]; exit;

    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"40%\" />
                <col width=\"30%\" />
                <col width=\"30%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"3\">편의점 정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">상품명</th>
                    <th class=\"text-center\">배송구분</th>
                    <th class=\"text-center\">도착 점포</th>              
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                </tr>
            </tbody>
        </table>
    ";    
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 3.상품상태 확인
    
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
                    <th class=\"text-center\" colspan=\"4\">상품상태 확인</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">추적일시</th>
                    <th class=\"text-center\">화물상태</th>
                    <th class=\"text-center\">담당영업소</th>
                    <th class=\"text-center\">상대영업소</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    // 추적일시, 화물상태, 담당영업소, 상대영업소
    $content_array  =   explode("<caption style=\"display:none;\" >배송상태</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<th>상대영업소</th>", $content_array2[0]);
    
    
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
        // (3) 담당영업소
        $content_array6 =   explode("class=\"board_contents\">", $content_array5[0]);
        $content_array7 =   explode("</a></td>", $content_array6[1]);
        
        // html중 text 데이터만 구함                            
        $text_temp[3] = get_html_to_text_data($content_array7[0]);
        // echo "<br />" . $text_temp[3]; exit;


        ////////////////////////////////////////////////////////////////////////////////
        // (4) 상대영업소
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