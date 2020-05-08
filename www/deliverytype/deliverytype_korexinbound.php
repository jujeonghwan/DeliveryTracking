<?php

////////////////////////////////////////////////////////////////////////////////
// 대한통운국제특송(해외->한국)

// 배송조회결과 구함 (대한통운국제특송(해외->한국))
function get_result_deliverytracking_korexinbound($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    
    // 조회결과
    $result_deliverytracking  =   "";

    // result_error
    $content_array          =   explode("HBL NO. NONEXISTENT.", $content_temp);
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
    

    

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 정상조회 결과
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.HBL(House Bill of Lading) Information (배송정보)
    
    // HBL No (운송장번호)
    $content_array  =   explode("<th>HBL No</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    $hbl_no         =   trim($content_array3[1]);
    // echo "<br />hbl_no : " . $hbl_no; exit;

    // MBL No (컨테이너번호) : Master Bill of Lading
    $content_array  =   explode("<th>MBL No</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    $mbl_no         =   trim($content_array3[1]);
    // echo "<br />mbl_no : " . $mbl_no; exit;

    // On Board DT (출발일자)
    $content_array  =   explode("<th>On Board DT</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    $on_board_dt    =   trim($content_array3[1]);
    // echo "<br />on_board_dt : " . $on_board_dt; exit;

    // Arrival DT (도착일자)
    $content_array  =   explode("<th>Arrival DT</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    $arrival_dt     =   trim($content_array3[1]);
    // echo "<br />arrival_dt : " . $arrival_dt; exit;


    // Shipper (발송인)
    $content_array  =   explode("<th>Shipper</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    $shipper        =   trim($content_array3[1]);
    // echo "<br />shipper : " . $shipper; exit;

    // Address [Shipper (발송인)]
    $content_array      =   explode("<th>Shipper</th>", $content_temp);
    $content_array2     =   explode("<th>Address</th>", $content_array[1]);
    $content_array3     =   explode("</td>", $content_array2[1]);
    $content_array4     =   explode("<td colspan=\"5\">", $content_array3[0]);
    $address_shipper    =   trim($content_array4[1]);
    // echo "<br />address_shipper : " . $address_shipper; exit;


    // Consignee (수취인)
    $content_array  =   explode("<th>Consignee</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    $consignee      =   trim($content_array3[1]);
    // echo "<br />consignee : " . $consignee; exit;

    // Address [Consignee (수취인)]
    $content_array      =   explode("<th>Consignee</th>", $content_temp);
    $content_array2     =   explode("<th>Address</th>", $content_array[1]);
    $content_array3     =   explode("</td>", $content_array2[1]);
    $content_array4     =   explode("<td colspan=\"5\">", $content_array3[0]);
    $address_consignee  =   trim($content_array4[1]);
    // echo "<br />address_consignee : " . $address_consignee; exit;


    // Notify (알림)
    $content_array  =   explode("<th>Notify</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td>", $content_array2[0]);
    $notify         =   trim($content_array3[1]);
    // echo "<br />notify : " . $notify; // exit;

    // Address [Notify (알림)]
    $content_array      =   explode("<th>Notify</th>", $content_temp);
    $content_array2     =   explode("<th>Address</th>", $content_array[1]);
    $content_array3     =   explode("</td>", $content_array2[1]);
    $content_array4     =   explode("<td colspan=\"5\">", $content_array3[0]);
    $address_notify  =   trim($content_array4[1]);
    // echo "<br />address_notify : " . $address_notify; exit;

   
    // Depature (출발지)
    $content_array  =   explode("<th>Depature</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td colspan=\"3\">", $content_array2[0]);
    $depature       =   trim($content_array3[1]);
    // echo "<br />depature : " . $depature; exit;

    // Destination (도착지)
    $content_array  =   explode("<th>Destination</th>", $content_temp);
    $content_array2 =   explode("</td>", $content_array[1]);
    $content_array3 =   explode("<td colspan=\"3\">", $content_array2[0]);
    $destination    =   trim($content_array3[1]);
    // echo "<br />destination : " . $destination; exit;

    // Relation Traking No (관련 운송장번호)
    $content_array          =   explode("<th>Relation Traking No</th>", $content_temp);
    $content_array2         =   explode("</td>", $content_array[1]);
    $content_array3         =   explode("<td colspan=\"3\">", $content_array2[0]);
    $relation_traking_no    =   trim($content_array3[1]);
    // echo "<br />relation_traking_no : " . $relation_traking_no; exit;

    // Tracking Url (배송추적URL)
    $content_array  =   explode("<th>Tracking Url</th>", $content_temp);
    $content_array2 =   explode("</a></td>", $content_array[1]);
    $content_array3 =   explode("<td colspan=\"3\"><a href=\"javascript:f_PopUrl();\">", $content_array2[0]);
    $tracking_url   =   trim($content_array3[1]);
    // echo "<br />tracking_url : " . $tracking_url; exit;

    // 항공기 도착 예정정보
    $content_array      =   explode("<th>항공기 도착 예정정보</th>", $content_temp);
    $content_array2     =   explode("</td>", $content_array[1]);
    $content_array3     =   explode("<td colspan=\"7\">", $content_array2[0]);
    $airplane_arrival   =   trim($content_array3[1]);
    // echo "<br />airplane_arrival : " . $airplane_arrival; exit;

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
                    <th class=\"text-center\" colspan=\"4\">HBL Information (배송정보)</th>          
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class=\"active text-center\">HBL No (운송장번호)</th>
                    <td class=\"text-center\">" . $hbl_no . "</td>
                    <th class=\"active text-center\">MBL No (컨테이너번호)</th>
                    <td class=\"text-center\">" . $mbl_no . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">On Board DT (출발일자)</th>
                    <td class=\"text-center\">" . get_date_format($on_board_dt) . "</td>
                    <th class=\"active text-center\">Arrival DT (도착일자)</th>
                    <td class=\"text-center\">" . get_date_format($arrival_dt) . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">Shipper (발송인)</th>
                    <td class=\"text-center\">" . $shipper . "</td>
                    <th class=\"active text-center\">Address (주소)</th>
                    <td class=\"text-center\">" . $address_shipper . "</td>
                </tr>


                <tr>
                    <th class=\"active text-center\">Consignee (수취인)</th>
                    <td class=\"text-center\">" . $consignee . "</td>
                    <th class=\"active text-center\">Address (주소)</th>
                    <td class=\"text-center\">" . $address_consignee . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">Notify (알림)</th>
                    <td class=\"text-center\">" . $notify . "</td>
                    <th class=\"active text-center\">Address (주소)</th>
                    <td class=\"text-center\">" . $address_notify . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">Depature (출발지)</th>
                    <td class=\"text-center\">" . $depature . "</td>
                    <th class=\"active text-center\">Destination (도착지)</th>
                    <td class=\"text-center\">" . $destination . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">Relation Traking No (관련 운송장번호)</th>
                    <td class=\"text-center\">" . $relation_traking_no . "</td>
                    <th class=\"active text-center\">Tracking Url (배송추적URL)</th>
                    <td class=\"text-center\">" . $tracking_url . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">항공기 도착 예정정보</th>
                    <td class=\"text-center\" colspan=\"3\">" . $airplane_arrival . "</td>
                </tr>
            </tbody>
        </table>
    ";  
    
    
    ////////////////////////////////////////////////////////////////////////////////
    // 2.Item Description (품목명세)

    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"50%\" />
                <col width=\"50%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"2\">Item Information (물품정보)</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">Item Description (품목명세)</th>
                    <th class=\"text-center\">Pieces (물품수)</th>
                </tr>
            </thead>
            <tbody>
    ";
    
    // Item Description, Pieces
    $content_array  =   explode("<th>Item Description</th>", $content_temp);
    $content_array2 =   explode("</table>", $content_array[1]);
    $content_array3 =   explode("<tbody class=\"ce\">", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {                    // 1~
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array4 =   explode("</tbody>", $content_array3[$i]);   

                     
        ////////////////////////////////////////////////////////////////////////////////
        // (1) Item Description (품목명세)
        $content_array5 =   explode("<td>", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[1]);
        
        // html중 text 데이터만 구함                            
        $content_array6[0] = get_html_to_text_data($content_array6[0]);
                        
        $text_temp[1]   =   trim($content_array6[0]);
        // echo "<br />text_temp[1] : " . $text_temp[1]; // exit;
        
        ////////////////////////////////////////////////////////////////////////////////
        // (2) Pieces (물품수)
        $content_array5 =   explode("<td class=\"textR\">", $content_array4[0]);
        $content_array6 =   explode("</td>", $content_array5[1]);
        
        // html중 text 데이터만 구함                            
        $content_array6[0] = get_html_to_text_data($content_array6[0]);
                        
        $text_temp[2]   =   trim($content_array6[0]);
        // echo "<br />text_temp[2] : " . $text_temp[2]; // exit;
        
        $result_deliverytracking  .=  "
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
    

    ////////////////////////////////////////////////////////////////////////////////
    // 3.Courier Tracking (배송추적)

    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"50%\" />
                <col width=\"50%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"2\">Courier Tracking (배송추적)</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">Delivery Status (배송상태)</th>
                    <th class=\"text-center\">Date (시간)</th>
                </tr>
            </thead>
            <tbody>
    ";
    
    // Item Description, Pieces
    $content_array  =   explode("<th>Delivery Status<br />(배송상태)</th>", $content_temp);
    $content_array2 =   explode("</tbody>", $content_array[1]);
    $content_array3 =   explode("<tbody>", $content_array2[0]);

    // 주석처리 부분 삭제
    // 주석 부분 : <!-- //임시 통관정보 ...... -->

    // 주석 앞부분 : $content_array4[0]
    $content_array4 =   explode("<!-- //임시 통관정보", $content_array3[1]);
    // echo "<br />content_array4[0] : <xmp>" . $content_array4[0] . "</xmp>"; // exit;

    // 주석 뒷부분 : $content_array5[1]
    $content_array5 =   explode("-->", $content_array4[1]);
    // echo "<br />content_array5[1] : <xmp>" . $content_array5[1] . "</xmp>"; exit;

    // 주석제외 부분 = 주석 앞부분 + 주석 뒷부분
    $content_temp_sub = $content_array4[0] . $content_array5[1];


    $content_array6 =   explode("<tr>", $content_temp_sub);
    $content_array6_count   =   count($content_array6);
    // echo "<br />content_array6_count : " . $content_array6_count; exit;
    for ($i = 1; $i < $content_array6_count; $i++) {        // 1~
        // echo "<br />" . $content_array6[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        $content_array7 =   explode("</tr>", $content_array6[$i]);   

                     
        ////////////////////////////////////////////////////////////////////////////////
        // (1) Delivery Status (배송상태)
        $content_array8 =   explode("<td>", $content_array7[0]);
        $content_array9 =   explode("</td>", $content_array8[1]);               // 1
        
        // html중 text 데이터만 구함                            
        $content_array9[0] = get_html_to_text_data($content_array9[0]);
                        
        $text_temp[1]   =   trim($content_array9[0]);
        // echo "<br />text_temp[1] : " . $text_temp[1]; // exit;
        
        ////////////////////////////////////////////////////////////////////////////////
        // (2) Date (시간)
        $content_array8 =   explode("<td>", $content_array7[0]);
        $content_array9 =   explode("</td>", $content_array8[2]);               // 2
        
        // html중 text 데이터만 구함                            
        $content_array9[0] = get_html_to_text_data($content_array9[0]);
                        
        $text_temp[2]   =   trim($content_array9[0]);
        // echo "<br />text_temp[2] : " . $text_temp[2]; // exit;
        
        if (trim($text_temp[2]) != "") {
            $result_deliverytracking  .=  "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                                
                </tr>
            ";    
        }
    }
    
    $result_deliverytracking  .=  "
            </tbody>
        </table>
    ";

    return $result_deliverytracking;
}

?>