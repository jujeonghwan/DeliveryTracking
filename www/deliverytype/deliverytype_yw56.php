<?php

////////////////////////////////////////////////////////////////////////////////
// YANWEN(국제)

// 배송조회결과 구함 (YANWEN(국제))
function get_result_deliverytracking_yw56($content_temp) {    



    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과

    // 조회결과
    $result_deliverytracking  =   "";
    
    $content_length = strlen(trim($content_temp));          // 데이터 문자열의 길이

    // 문자열의 길이가 0
    if ($content_length <= 0) {
        $text_temp = "조회된 데이터가 없습니다. (Not Found)";
        
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
    $content_array          =   explode("<h4 title=\"YANWEN No.-[Customer No.]\"> -[<em></em>]</h4>", $content_temp);   // 조회불가
    $content_array_count    =   count($content_array);          
    
    // Not Found
    if ($content_array_count > 1) {
        $text_temp = "이 배송 조회 번호를 찾을 수 없습니다. (Not Found)";
        
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
    <div id="11224016969" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th class="text-right" style="width:20%;"><b>DestinationCountry</b></th>
                    <th><code>Korea  </code></th>
                </tr>
                    <tr>
                        <td class="text-right">2015-06-04 00:00</td>
                        <td>Korea   Arrive at Korea   Airport-(Yanwen&#39;s Track End)</td>
                    </tr>
                <tr>
                    <th class="text-right"><b>Origin Country</b></th>
                    <th><code>China</code></th>
                </tr>
                    <tr>
                        <td class="text-right">2015-06-02 00:00</td>
                        <td>BeiJing Handled by Airline,Flight No. CA123</td>
                    </tr>
                    <tr>
                        <td class="text-right">2015-06-01 00:00</td>
                        <td>Beijing Internationg Mail Center Prepare to Dispatch</td>
                    </tr>
                    <tr>
                        <td class="text-right">2015-05-31 00:00</td>
                        <td>BeiJing Arrived at Beijing Internationg Mail Center</td>
                    </tr>
                    <tr>
                        <td class="text-right">2015-05-31 00:00</td>
                        <td>Beijing Internationg Mail Center Received</td>
                    </tr>
                    <tr>
                        <td class="text-right">2015-05-30 14:00</td>
                        <td> The post office of electronic information has been received</td>
                    </tr>
                    <tr>
                        <td class="text-right">2015-05-29 20:00</td>
                        <td>ShangHai Despatched from Yanwen ShangHai Sorting Center</td>
                    </tr>
                    <tr>
                        <td class="text-right">2015-05-29 18:00</td>
                        <td>ShangHai Accepted at Yanwen ShangHai Sorting Center</td>
                    </tr>
            </tbody>
        </table>
    </div>
    */
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.배송정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수 초기화

    
    $content_array  =   explode("<h4 title=\"YANWEN No.-[Customer No.]\">", $content_temp);    
    $content_array2 =   explode("</em>]</h4>", $content_array[1]);
    $content_array3 =   explode("-[<em>", $content_array2[0]);

    // (1) 운송장번호 (TrackNumber)
    $text_temp[1]   =   trim($content_array3[0]);
    // echo "<br />TrackNumber : " . $text_temp[1];

    // (2) 고객번호 (Customer No.) 
    $text_temp[2]   =   trim($content_array3[1]);
    // echo "<br />Customer No. : " . $text_temp[2]; 
    // exit;

    // (3) 발송국가 (Origin Country)
    $content_array  =   explode("<b>Origin Country</b></th>", $content_temp);    
    $content_array2 =   explode("</code></th>", $content_array[1]);
    $content_array3 =   explode("<th><code>", $content_array2[0]);
    $text_temp[3]   =   trim($content_array3[1]);
    // echo "<br />Origin Country : " . $text_temp[3]; exit;

    // (3) 도착국가 (Destination Country)
    $content_array  =   explode("<b>DestinationCountry</b></th>", $content_temp);    
    $content_array2 =   explode("</code></th>", $content_array[1]);
    $content_array3 =   explode("<th><code>", $content_array2[0]);
    $text_temp[4]   =   trim($content_array3[1]);
    // echo "<br />Origin Destination Country : " . $text_temp[4]; exit;

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
                    <th class=\"active text-center\">운송장번호 (TrackNumber)</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">고객번호 (Customer No.)</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">발송국가 (Origin Country)</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">도착국가 (Destination Country)</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 2.운송 내역
    
    // 운송 내역
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"30%\" />
                <col width=\"70%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"2\">운송 내역</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜/시간</th>
                    <th class=\"text-center\">내역</th>
                </tr>
            </thead>
            <tbody>
    ";  

    // 날짜/시간, 내역
    $InputTrackNumbers = $text_temp[1]; // 운송장번호


    $content_array  =   explode("<div id=\"" . $InputTrackNumbers . "\"", $content_temp);           // 예) <div id="11224016969"
    $content_array2 =   explode("</tbody>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);
    $content_array4 =   explode("<td class=\"text-right\">", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    // for ($i = 1; $i < $content_array4_count; $i++) {
    for ($i = ($content_array4_count - 1); $i >= 1; $i--) {
        // echo "<br />" . $content_array4[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        // (1) 날짜/시간
        $content_array5 =   explode("</td>", $content_array4[$i]);
        $text_temp[1]   =   trim($content_array5[0]);                           // 1
        // echo "<br />date : " . $text_temp[1]; exit;

        // (2) 내역
        $content_array5 =   explode("</tr>", $content_array4[$i]);
        $content_array6 =   explode("<td>", $content_array5[0]);
        $content_array7 =   explode("</td>", $content_array6[1]);
        $text_temp[2]   =   trim($content_array7[0]);                           // 2

        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . $text_temp[1] . "</td>
                <td class=\"text-center\">" . $text_temp[2] . "</td>
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