<?php

////////////////////////////////////////////////////////////////////////////////
// CU편의점PICK-UP

// 배송조회결과 구함 (CU편의점PICK-UP)
function get_result_deliverytracking_cupostpickup($content_temp) {                                 

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


    // result_error
    $content_array          =   explode("아직 접수되지 않는 상품입니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "아직 접수되지 않는 상품입니다.";
        
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

    ////////////////////////////////////////////////////////////////////////////////
    // (1)~(4) 송장번호, 쇼핑몰, 수취인명, 접수일자

    $content_array  =   explode("<caption>편의점PICK-UP 배송조회 결과 기본배송정보 표입니다. 순번, 쇼핑몰, 수취인명, 접수일자를 확인할 수 있습니다.</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);    
    $content_array4 =   explode("</tr>", $content_array3[1]);
    $content_array5 =   explode("<td", $content_array4[0]);

    // (1) 송장번호
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $content_array7 =   explode("<a href=\"javascript:getDetail('", $content_array6[0]);
    $content_array8 =   explode("',", $content_array7[1]);
    $text_temp[1]   =   get_html_to_text_data($content_array8[0]);       
    // echo "<br />" . $text_temp[1]; exit;

    // (2) 쇼핑몰
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $content_array7 =   explode("')\">", $content_array6[0]);
    $content_array8 =   explode("</a>", $content_array7[1]);
    $text_temp[2]   =   get_html_to_text_data($content_array8[0]);       
    // echo "<br />" . $text_temp[2]; exit;

    // (3) 수취인명
    $content_array6 =   explode("</td>", $content_array5[3]);                   // 3
    $content_array7 =   explode(">", $content_array6[0]);
    $text_temp[3]   =   get_html_to_text_data($content_array7[1]);       
    // echo "<br />" . $text_temp[3]; exit;

    // (4) 접수일자
    $content_array6 =   explode("</td>", $content_array5[4]);                   // 4
    $content_array7 =   explode(">", $content_array6[0]);
    $text_temp[4]   =   get_html_to_text_data($content_array7[1]);       
    // echo "<br />" . $text_temp[4]; exit;

    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"25%\" />
                <col width=\"25%\" />
                <col width=\"25%\" />
                <col width=\"25%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">예약정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">송장번호</th>
                    <th class=\"text-center\">쇼핑몰</th>
                    <th class=\"text-center\">수취인명</th>
                    <th class=\"text-center\">접수일자</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                </tr>
            </tbody>
        </table>
    ";    
    


    ////////////////////////////////////////////////////////////////////////////////
    // 2.기본배송정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수

    ////////////////////////////////////////////////////////////////////////////////
    // (1)~(12) 송하인 고객 정보, 수취인 고객정보, 쇼핑몰 정보, 벤더 정보 (성명, 전화, 주소)

    $content_array  =   explode("<caption>편의점PICK-UP 배송조회 결과 기본배송정보 표입니다. 송하인 고객 정보(성명,주소), 수취인 고객 정보(성명, 주소), 벤더정보(성명,주소) 를 확인할 수 있습니다.</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    // echo "<br /><xmp>" . $content_array2[0] . "</xmp>"; exit;
    
    ////////////////////////////////////////
    // 성명
    $content_array3 =   explode("<th>성 명</th>", $content_array2[0]);    
    $content_array4 =   explode("</tr>", $content_array3[1]);
    $content_array5 =   explode("<td style=\"text-align:center;\">", $content_array4[0]);

    // (1) 송하인 성명
    $content_array6 =   explode("</td>", $content_array5[1]);                   // 1
    $text_temp[1]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[1]; exit;

    // (2) 수취인 성명
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $text_temp[2]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[2]; exit;

    // (3) 쇼핑몰 성명
    $content_array6 =   explode("</td>", $content_array5[3]);                   // 3
    $text_temp[3]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[3]; exit;

    // (4) 벤더 성명
    $content_array6 =   explode("</td>", $content_array5[4]);                   // 4
    $text_temp[4]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[4]; exit;

    
    ////////////////////////////////////////
    // 전화
    $content_array3 =   explode("<th>전 화</th>", $content_array2[0]);    
    $content_array4 =   explode("</tr>", $content_array3[1]);
    $content_array5 =   explode("<td style=\"text-align:center;\">", $content_array4[0]);

    // (5) 송하인 전화
    $content_array6 =   explode("</td>", $content_array5[1]);                   // 1
    $text_temp[5]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[5]; exit;

    // (6) 수취인 전화
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $text_temp[6]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[6]; exit;

    // (7) 쇼핑몰 전화
    $content_array6 =   explode("</td>", $content_array5[3]);                   // 3
    $text_temp[7]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[7]; exit;

    // (8) 벤더 전화
    $content_array6 =   explode("</td>", $content_array5[4]);                   // 4
    $text_temp[8]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[4]; exit;


    ////////////////////////////////////////
    // 주소
    $content_array3 =   explode("<th>주 소</th>", $content_array2[0]);    
    $content_array4 =   explode("</tr>", $content_array3[1]);
    $content_array5 =   explode("<td style=\"text-align:center;\">", $content_array4[0]);

    // (9) 송하인 주소
    $content_array6 =   explode("</td>", $content_array5[1]);                   // 1
    $text_temp[9]   =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[9]; exit;

    // (10) 수취인 주소
    $content_array6 =   explode("</td>", $content_array5[2]);                   // 2
    $text_temp[10]  =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[10]; exit;

    // (11) 쇼핑몰 주소
    $content_array6 =   explode("</td>", $content_array5[3]);                   // 3
    $text_temp[11]  =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[11]; exit;

    // (12) 벤더 주소
    $content_array6 =   explode("</td>", $content_array5[4]);                   // 4
    $text_temp[12]  =   get_html_to_text_data($content_array6[0]);       
    // echo "<br />" . $text_temp[12]; exit;
    
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"10%\" />
                <col width=\"25%\" />
                <col width=\"25%\" />
                <col width=\"20%\" />
                <col width=\"20%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"5\">기본배송정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\"></th>
                    <th class=\"active text-center\">송하인 고객 정보</th>
                    <th class=\"active text-center\">수취인 고객정보</th>
                    <th class=\"active text-center\">쇼핑몰 정보</th>
                    <th class=\"active text-center\">벤더 정보</th>                      
                </tr>
                <tr>
                    <th class=\"active text-center\">성명</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">전화</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>
                    <td class=\"text-center\">" . $text_temp[8] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">주소</th>
                    <td class=\"text-center\">" . $text_temp[9] . "</td>
                    <td class=\"text-center\">" . $text_temp[10] . "</td>
                    <td class=\"text-center\">" . $text_temp[11] . "</td>
                    <td class=\"text-center\">" . $text_temp[12] . "</td>                         
                </tr>
            </tbody>
        </table>
    ";



    ////////////////////////////////////////////////////////////////////////////////
    // 3.편의점 정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수

    ////////////////////////////////////////////////////////////////////////////////
    // (1)~(3) 상품명, 배송구분, 도착 점포

    $content_array  =   explode("<caption>편의점PICK-UP 배송조회 결과 편의점정보 표입니다. 상품명, 배송구분, 도착점포 정보를 확인할 수 있습니다.</caption>", $content_temp);
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
    // 4.화물추적
    
    // 일자, 시간, 상태, 장소

    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"20%\" />
                <col width=\"30%\" />
                <col width=\"30%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">화물추적</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">일자</th>
                    <th class=\"text-center\">시간</th>
                    <th class=\"text-center\">상태</th>
                    <th class=\"text-center\">장소</th>                            
                </tr>
            </thead>
            <tbody>
    ";
    
    // 일자, 시간, 상태, 장소
    $content_array  =   explode("<caption>편의점PICK-UP 배송조회 결과 화물추적 표입니다. 일자, 시간, 상태, 장소 정보를 확인할 수 있습니다.</caption>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);    
    $content_array4 =   explode("</tbody>", $content_array3[1]);
    $content_array5 =   explode("<tr>", $content_array4[0]);
    
    $content_array5_count   =   count($content_array5);
    
    for ($i = 1; $i < $content_array5_count; $i++) {                    // 1~
        // echo "<br />" . $content_array4[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array6 =   explode("</tr>", $content_array5[$i]);   
                     
        
        ////////////////////////////////////////////////////////////////////////////////
        // (1) 일자
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[1]);               // 1
        
        // html중 text 데이터만 구함                            
        $text_temp[1] = get_html_to_text_data($content_array8[0]);
        // echo "<br />" . $text_temp[1]; exit;


        ////////////////////////////////////////////////////////////////////////////////
        // (2) 시간
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[2]);               // 2
        
        // html중 text 데이터만 구함                            
        $text_temp[2] = get_html_to_text_data($content_array8[0]);
        // echo "<br />" . $text_temp[2]; exit;


        ////////////////////////////////////////////////////////////////////////////////
        // (3) 시간
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[3]);               // 3
        
        // html중 text 데이터만 구함                            
        $text_temp[3] = get_html_to_text_data($content_array8[0]);
        // echo "<br />" . $text_temp[3]; exit;
        

        ////////////////////////////////////////////////////////////////////////////////
        // (4) 장소
        $content_array7 =   explode("<td>", $content_array6[0]);
        $content_array8 =   explode("</td>", $content_array7[4]);               // 4
        
        // html중 text 데이터만 구함                            
        $text_temp[4] = get_html_to_text_data($content_array8[0]);
        // echo "<br />" . $text_temp[4]; exit;
        
        $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
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