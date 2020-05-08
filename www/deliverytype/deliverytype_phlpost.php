<?php

////////////////////////////////////////////////////////////////////////////////
// PHLPOST필리핀국제우편(국제)

// 배송조회결과 구함 (PHLPOST필리핀국제우편(국제))
function get_result_deliverytracking_phlpost($content_temp) {    

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    // {}
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("COUNTRY</th>", $content_temp);         // 데이터 없을 경우
    $content_array_count    =   count($content_array);          
    
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

    /*
    <div style="margin-top:20px; background-color:white" >                  
    <div>

        <table cellspacing="0" rules="all" class="table table-striped table-bordered table-hover grid-header" border="1" id="GridView1" style="border-collapse:collapse;">
            <tr style="color:White;font-family:lato;font-weight:bold;">
                <th scope="col" style="background-color:#001862;font-size:Larger;">DATE and TIME</th>
                <th scope="col" style="background-color:#001862;font-size:Larger;">STATUS OF YOUR ITEM</th>
                <th scope="col" style="background-color:#001862;font-size:Larger;">COUNTRY</th>
            </tr>
            <tr align="left">
                <td style="font-size:Larger;">Mar 17 2017  7:16PM</td>
                <td style="font-size:Larger;"> Dispatch to provincial office</td>
                <td style="font-size:Larger;">PHILIPPINES</td>
            </tr>
            <tr align="left">
                <td style="font-size:Larger;">Mar 17 2017  5:38PM</td>
                <td style="font-size:Larger;"> Dispatch to provincial office</td>
                <td style="font-size:Larger;">PHILIPPINES</td>
            </tr>
            <tr align="left">
                <td style="font-size:Larger;">Mar 17 2017  2:43PM</td>
                <td style="font-size:Larger;"> Turn-over item to next office</td>
                <td style="font-size:Larger;">PHILIPPINES</td>
            </tr>
            <tr align="left">
                <td style="font-size:Larger;">Mar 17 2017  1:39PM</td>
                <td style="font-size:Larger;"> Receive at country of destination</td>
                <td style="font-size:Larger;">PHILIPPINES</td>
            </tr>
            <tr align="left">
                <td style="font-size:Larger;">Mar 17 2017  8:15AM</td>
                <td style="font-size:Larger;"> Dispatch to country of destination</td>
                <td style="font-size:Larger;">Korea (the Republic of)</td>
            </tr>
            <tr align="left">
                <td style="font-size:Larger;">Mar 16 2017  8:31PM</td>
                <td style="font-size:Larger;"> Prepare dispatch to destination country</td>
                <td style="font-size:Larger;">Korea (the Republic of)</td>
            </tr>
            <tr align="left">
                <td style="font-size:Larger;">Mar 16 2017  7:53PM</td>
                <td style="font-size:Larger;"> Receive item at origin country gateway</td>
                <td style="font-size:Larger;">Korea (the Republic of)</td>
            </tr>
            <tr align="left">
                <td style="font-size:Larger;">Mar 16 2017 10:53AM</td>
                <td style="font-size:Larger;"> Posting of item</td>
                <td style="font-size:Larger;">Korea (the Republic of)</td>
            </tr>
        </table>

    </div>
    </div>

    <input name="url" type="text" value="em368508077kr" maxlength="64" id="url" placeholder="EEXXXXXPH" />
    */
    
    // 조회결과
    $result_deliverytracking  =   "";

    ////////////////////////////////////////////////////////////////////////////////
    // 1.배송정보

    // (1) 운송장 번호 (Tracking Number)
    $content_array  =   explode("<input name=\"url\" type=\"text\" value=\"", $content_temp);
    $content_array2 =   explode("\"", $content_array[1]);

    $text_temp[1]   =   get_html_to_text_data($content_array2[0]);       
    // echo "<br />" . $text_temp[1]; exit;

    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"50%\" />
                <col width=\"50%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"2\">배송정보</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">운송장 번호 (Tracking Number)</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>                     
                </tr>
            </tbody>
        </table>
    ";

        
    ////////////////////////////////////////////////////////////////////////////////
    // 2.운송 내역 (DATE and TIME, STATUS OF YOUR ITEM, COUNTRY)
    
    // 운송 내역
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"30%\" />
                <col width=\"40%\" />
                <col width=\"30%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\">현지 일시 (DATE and TIME)</th>
                    <th class=\"text-center\">상태 (STATUS OF YOUR ITEM)</th>
                    <th class=\"text-center\">국가 (COUNTRY)</th>
                </tr>
            </thead>
            <tbody>
    ";
        
    // DATE and TIME, STATUS OF YOUR ITEM, COUNTRY
    $content_array  =   explode("id=\"GridView1\" style=\"border-collapse:collapse;\">", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);    
    $content_array3 =   explode(">COUNTRY</th>", $content_array2[0]);
    $content_array4 =   explode("<tr align=\"left\">", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    // for ($i = 1; $i < $content_array4_count; $i++) {
    for ($i = ($content_array4_count - 1); $i >= 1; $i--) {
        // echo "<br />" . $content_array4[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array5 =   explode("<td style=\"font-size:Larger;\">", $content_array4[$i]);


        // (1) 현지 일시 (DATE and TIME)    
        $content_array6 =   explode("</td>", $content_array5[1]);               // 1

        // html중 text 데이터만 구함                            
        $text_temp[1] = get_html_to_text_data($content_array6[0]);
        // echo "<br />" . $text_temp[1]; exit;


        // (2) 상태 (STATUS OF YOUR ITEM)   
        $content_array6 =   explode("</td>", $content_array5[2]);               // 2

        // html중 text 데이터만 구함                            
        $text_temp[2] = get_html_to_text_data($content_array6[0]);
        // echo "<br />" . $text_temp[2]; exit;


        // (3) 국가 (COUNTRY) 
        $content_array6 =   explode("</td>", $content_array5[3]);               // 3

        // html중 text 데이터만 구함                            
        $text_temp[3] = get_html_to_text_data($content_array6[0]);
        // echo "<br />" . $text_temp[3]; exit;

        
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . $text_temp[1] . "</td>
                <td class=\"text-center\">" . $text_temp[2] . "</td>
                <td class=\"text-center\">" . $text_temp[3] . "</td>
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