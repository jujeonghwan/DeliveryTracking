<?php

////////////////////////////////////////////////////////////////////////////////
// 롯데글로벌로지스(국제)

// 배송조회결과 구함 (롯데글로벌로지스(국제))
function get_result_deliverytracking_lotteglogis_i($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
        
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    
    // result_error
    $content_array          =   explode("조회결과가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    조회결과가 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "조회결과가 없습니다.";
        
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
    $content_array          =   explode("해당 번호에 대한 배송정보가 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    해당 번호에 대한 배송정보가 없습니다.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "해당 번호에 대한 배송정보가 없습니다.";
        
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

/*
{
   "responseHeader":{
      "result":"success",
      "message":"",
      "requestNo":null
   },
   "orderHeader":{
      "shipper":"RJ **",
      "shipperAddr":"530 S Catalina St., Los**",
      "deliveryTo":"",
      "consignee":"T**",
      "ordRefNo":"5283",
      "consigneeAddr":"Gyeonggi-do Icheon-si Majang-myeon**",
      "dlvNo":"6064802527783"
   },
   "trackingEvents":{
      "trackingEvents":[
         {
            "date":"20200112",
            "code":"20",
            "description":"상품을 발송(주문접수)하였습니다.",
            "location":"판매자",
            "time":"1232"
         },
         {
            "date":"20200114",
            "code":"28",
            "description":"LAX 공항에서 출발 예정입니다.",
            "location":"발송국 항공사",
            "time":"0919"
         },
         {
            "date":"20200114",
            "code":"29",
            "description":"ICN 공항에 (98824401974\/2020-01-15) 도착 예정입니다.",
            "location":"인천국제공항",
            "time":"1509"
         },
         {
            "date":"20200115",
            "code":"31",
            "description":"인천 특송창고 입고 전 세관 수입신고 중입니다.",
            "location":"특송장",
            "time":"1043"
         },
         {
            "date":"20200115",
            "code":"34",
            "description":"세관오류[납세의무자명은(는) 문자열길이가 맞지 않습니다.[Thiha Soe San=<...]",
            "location":"세관",
            "time":"1101"
         },
         {
            "date":"20200115",
            "code":"32",
            "description":"인천 특송창고에 입고 되었습니다.",
            "location":"특송장",
            "time":"1426"
         }
      ]
   }
}
*/

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 정상조회 결과
    
    // echo "<xmp>" . $content_temp . "</xmp>"; exit;
    
    // 조회결과
    $result_deliverytracking = "";
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.기본정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수
    
    // (1) Shipper (발송자)
    $content_array  =   explode("orderHeader", $content_temp);
    $content_array2 =   explode("},", $content_array[1]);
    $content_array3 =   explode("\"shipper\"", $content_array2[0]);
    $content_array4 =   explode("\",", $content_array3[1]);
    $content_array5 =   explode("\"", $content_array4[0]);
    $text_temp[1]   =   trim($content_array5[1]);
    // echo "<br />Shipper (발송자) : " . $text_temp[1]; exit;
    
    // (2) shipperAddr (발송자 주소)
    $content_array  =   explode("orderHeader", $content_temp);
    $content_array2 =   explode("},", $content_array[1]);
    $content_array3 =   explode("\"shipperAddr\"", $content_array2[0]);
    $content_array4 =   explode("\",", $content_array3[1]);
    $content_array5 =   explode("\"", $content_array4[0]);
    $text_temp[2]   =   trim($content_array5[1]);
    // echo "<br />shipperAddr (발송자 주소) : " . $text_temp[2]; exit;

    // (3) Consignee (수령자)
    $content_array  =   explode("orderHeader", $content_temp);
    $content_array2 =   explode("},", $content_array[1]);
    $content_array3 =   explode("\"consignee\"", $content_array2[0]);
    $content_array4 =   explode("\",", $content_array3[1]);
    $content_array5 =   explode("\"", $content_array4[0]);
    $text_temp[3]   =   trim($content_array5[1]);
    // echo "<br />Consignee (수령자) : " . $text_temp[3]; exit;

    // (4) consigneeAddr (수령자 주소)
    $content_array  =   explode("orderHeader", $content_temp);
    $content_array2 =   explode("},", $content_array[1]);
    $content_array3 =   explode("\"consigneeAddr\"", $content_array2[0]);
    $content_array4 =   explode("\",", $content_array3[1]);
    $content_array5 =   explode("\"", $content_array4[0]);
    $text_temp[4]   =   trim($content_array5[1]);
    // echo "<br />consigneeAddr (수령자 주소) : " . $text_temp[4]; exit;

    // (5) ordRefNo (신청번호)
    $content_array  =   explode("orderHeader", $content_temp);
    $content_array2 =   explode("},", $content_array[1]);
    $content_array3 =   explode("\"ordRefNo\"", $content_array2[0]);
    $content_array4 =   explode("\",", $content_array3[1]);
    $content_array5 =   explode("\"", $content_array4[0]);
    $text_temp[5]   =   trim($content_array5[1]);
    // echo "<br />ordRefNo (신청번호) : " . $text_temp[5]; exit;

    // (6) dlvNo (운송장번호)
    $content_array  =   explode("orderHeader", $content_temp);
    $content_array2 =   explode("},", $content_array[1]);
    $content_array3 =   explode("\"dlvNo\"", $content_array2[0]);
    $content_array4 =   explode("\",", $content_array3[1]);
    $content_array5 =   explode("\"", $content_array4[0]);
    $text_temp[6]   =   trim($content_array5[1]);
    // echo "<br />dlvNo (운송장번호) : " . $text_temp[6]; exit;

    // (7) deliveryTo (수령인)
    $content_array  =   explode("orderHeader", $content_temp);
    $content_array2 =   explode("},", $content_array[1]);
    $content_array3 =   explode("\"deliveryTo\"", $content_array2[0]);
    $content_array4 =   explode("\",", $content_array3[1]);
    $content_array5 =   explode("\"", $content_array4[0]);
    $text_temp[7]   =   trim($content_array5[1]);
    // echo "<br />deliveryTo (수령인) : " . $text_temp[7]; exit;
    
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
                    <th class=\"text-center\" colspan=\"4\">기본정보</th>          
                </tr>
            </thead>)
            <tbody>
                <tr>
                    <th class=\"active text-center\">Order No. (신청번호)</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <th class=\"active text-center\">Tracking No. (운송장번호)</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">Shipper (보내시는 분)</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">Address (주소)</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">Consignee (받는 분)</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">Address (주소)</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">Deliveryed To (수령인)</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[7] . "</td>                         
                </tr>
            </tbody>
        </table>
    "; 
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.처리현황
    
    // 처리현황
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>        
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"20%\" />
                <col width=\"50%\" />  
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">처리현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">Date (날짜)</th>
                    <th class=\"text-center\">Time (시간)</th>                    
                    <th class=\"text-center\">Location (현재위치)</th>                            
                    <th class=\"text-center\">Status (처리현황)</th>                          
                </tr>
            </thead>
            <tbody>
    ";
    
    // 날짜, 시간, 현재위치, 처리현황
    $content_array  =   explode("\"trackingEvents\":[", $content_temp);
    $content_array2 =   explode("]}}", $content_array[1]);
    
    $content_array3 =   explode("{", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        /*                     
        echo "<br /><br /><br />";
        echo "<xmp>";        
        echo $content_array3[0];
        echo "</xmp>";
        */
                
        $content_array4 =   explode("}", $content_array3[$i]);   
        
        // (1) Date (날짜)
        $content_array5 =   explode("\"date\":\"", $content_array4[0]);
        $content_array6 =   explode("\",", $content_array5[1]);
        
        $text_temp[1]   =   get_html_to_text_data($content_array6[0]);
        // echo "<br />Date (날짜) : " . $text_temp[1]; exit;

        // (2) Time (시간)
        $content_array5 =   explode("\"time\":\"", $content_array4[0]);
        $content_array6 =   explode("\"", $content_array5[1]);
        
        $text_temp[2]   =   get_html_to_text_data($content_array6[0]);
        // echo "<br />Time (시간) : " . $text_temp[2]; exit;

        // (3) Location (현재위치)
        $content_array5 =   explode("\"location\":\"", $content_array4[0]);
        $content_array6 =   explode("\",", $content_array5[1]);
        
        $text_temp[3]   =   get_html_to_text_data($content_array6[0]);
        // echo "<br />Location (현재위치) : " . $text_temp[3]; exit;
        
        // (4) Status (처리현황)
        $content_array5 =   explode("\"description\":\"", $content_array4[0]);
        $content_array6 =   explode("\",", $content_array5[1]);
        
        $text_temp[4]   =   get_html_to_text_data($content_array6[0]);
        // echo "<br />Status (처리현황) : " . $text_temp[4]; exit;
        
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\">" . strip_tags($text_temp[1]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[2]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[3]) . "</td>
                <td class=\"text-center\">" . strip_tags($text_temp[4]) . "</td>
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