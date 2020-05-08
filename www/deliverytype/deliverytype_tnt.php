<?php

////////////////////////////////////////////////////////////////////////////////
// TNT(국제)

// 배송조회결과 구함 (TNT(국제))
function get_result_deliverytracking_tnt($content_temp) {    

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
	// {"tracker.output":{"notFound":[{"input":"118637799"}]}}
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("{\"tracker.output\":{\"notFound\":", $content_temp);  		// notFound
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "일치하는 운송장 번호가 없습니다.<br />픽업 후 배송 조회가 가능해질 때까지 최대 8시간이 소요될 수 있습니다.<br />배송 후 1개월 이상 경과했다면 배송 조회가 되지 않을 수 있습니다.";
        
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
    "error":{
        "errorSource": "API",
        "errorType": "Unsupported Resource",
        "code": "0001",
        "message": "Unsupported resource type or version"
    }}
    */
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("\"error\":{", $content_temp);          // error
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "배송 정보를 읽을 수 없습니다.";
        
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

    
    
    // {}
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("{}", $content_temp);  		            // 데이터 없을 경우
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
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
	{  
	    "tracker.output":{  
	        "consignment":[  
	            {  
	                "consignmentKey":"WW118637702      JCN  20160523090513",
	                "consignmentNumber":"118637702",
	                "customerReference":"",
	                "summaryCode":"DEL",
	                "collectionDate":"23 May 2016",
	                "deliveryDueDate":"26 May 2016 23:59:00",
	                "signatory":"DEALIM",
	                "deliveryTown":"SERI MANJONG",
	                "destinationCountry":"Malaysia",
	                "originCountry":"South Korea",
	                "originDepotCode":"JCN",
	                "originDepotName":"Incheon",
	                "pieceQuantity":"1",
	                "statusData":[  
	                    {  
	                        "statusCode":"OK",
	                        "statusDescription":"수령인에게 인도가 완료되었습니다.",
	                        "groupCode":"DELRED",
	                        "severity":"INFO",
	                        "localEventDate":"26 May 2016",
	                        "localEventTime":"12:00:00",
	                        "depot":"Petaling Jaya"
	                    },
	                    {  
	                        "statusCode":"OF",
	                        "statusDescription":"TNT이외의 운송사로 인계되었습니다.",
	                        "groupCode":"DELING",
	                        "severity":"INFO",
	                        "localEventDate":"25 May 2016",
	                        "localEventTime":"02:21:47",
	                        "depot":"Petaling Jaya"
	                    },
	                    {  
	                        "statusCode":"TR",
	                        "statusDescription":"다음 TNT 목적지로 운송되기 위하여 경유센터에서 분류되었습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"25 May 2016",
	                        "localEventTime":"02:18:07",
	                        "depot":"Petaling Jaya"
	                    },
	                    {  
	                        "statusCode":"IR",
	                        "statusDescription":"물품 배송 사무소에 화물이 도착하였습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"25 May 2016",
	                        "localEventTime":"01:55:04",
	                        "depot":"Petaling Jaya"
	                    },
	                    {  
	                        "statusCode":"RC",
	                        "statusDescription":"통관이 완료 되었습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"24 May 2016",
	                        "localEventTime":"22:18:17",
	                        "depot":"Kuala Lumpur"
	                    },
	                    {  
	                        "statusCode":"PC",
	                        "statusDescription":"정식통관 진행 중입니다. \/ 세관 신고가 진행 중입니다.",
	                        "groupCode":"INT",
	                        "severity":"null",
	                        "localEventDate":"24 May 2016",
	                        "localEventTime":"19:10:21",
	                        "depot":"Kuala Lumpur"
	                    },
	                    {  
	                        "statusCode":"PC",
	                        "statusDescription":"정식통관 진행 중입니다. \/ 세관 신고가 진행 중입니다.",
	                        "groupCode":"INT",
	                        "severity":"null",
	                        "localEventDate":"24 May 2016",
	                        "localEventTime":"17:07:23",
	                        "depot":"Kuala Lumpur"
	                    },
	                    {  
	                        "statusCode":"HW",
	                        "statusDescription":"TNT 물류센터에서 보관 중입니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"24 May 2016",
	                        "localEventTime":"10:44:06",
	                        "depot":"Kuala Lumpur"
	                    },
	                    {  
	                        "statusCode":"IS",
	                        "statusDescription":"TNT 센터에 화물이 도착하였습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"24 May 2016",
	                        "localEventTime":"10:36:56",
	                        "depot":"Kuala Lumpur"
	                    },
	                    {  
	                        "statusCode":"PAC",
	                        "statusDescription":"물품도착 전 전자 이미지를 이용하여 사전통관이 진행되었습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"23 May 2016",
	                        "localEventTime":"16:05:00",
	                        "depot":"Kuala Lumpur"
	                    },
	                    {  
	                        "statusCode":"TR",
	                        "statusDescription":"다음 TNT 목적지로 운송되기 위하여 경유센터에서 분류되었습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"23 May 2016",
	                        "localEventTime":"16:47:59",
	                        "depot":"Incheon International Airport"
	                    },
	                    {  
	                        "statusCode":"IS",
	                        "statusDescription":"TNT 센터에 화물이 도착하였습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"23 May 2016",
	                        "localEventTime":"16:46:55",
	                        "depot":"Incheon International Airport"
	                    },
	                    {  
	                        "statusCode":"OS",
	                        "statusDescription":"출발지에서 다음 TNT 목적지로 발송되었습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"23 May 2016",
	                        "localEventTime":"16:13:00",
	                        "depot":"Incheon"
	                    },
	                    {  
	                        "statusCode":"TR",
	                        "statusDescription":"다음 TNT 목적지로 운송되기 위하여 경유센터에서 분류되었습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"23 May 2016",
	                        "localEventTime":"15:58:59",
	                        "depot":"Incheon"
	                    },
	                    {  
	                        "statusCode":"CI",
	                        "statusDescription":"TNT에서 물품이 체크인 되었습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"23 May 2016",
	                        "localEventTime":"15:58:14",
	                        "depot":"Incheon"
	                    },
	                    {  
	                        "statusCode":"DH",
	                        "statusDescription":"화물이 TNT 발송센터에 도착되었습니다.",
	                        "groupCode":"INTRAN",
	                        "severity":"INFO",
	                        "localEventDate":"23 May 2016",
	                        "localEventTime":"13:39:09",
	                        "depot":"Cheonan"
	                    },
	                    {  
	                        "statusCode":"PU",
	                        "statusDescription":"드라이버가 고객으로부터 물건을 픽업하였습니다.",
	                        "groupCode":"COLING",
	                        "severity":"INFO",
	                        "localEventDate":"23 May 2016",
	                        "localEventTime":"12:48:18",
	                        "depot":"Cheonan"
	                    }
	                ]
	            }
	        ],
	        "duplicateConsignments":false
	    }
	}
	*/
    
    

    // 조회결과
    $result_deliverytracking  =   "";

    ////////////////////////////////////////////////////////////////////////////////
    // 송장번호 1개에 여러 배송정보가 있는 경우가 있음

    // 배송정보 갯수
    $delivery_info_array    =   explode("\"consignmentKey\":\"", $content_temp);        

    $delivery_info_count    =   count($delivery_info_array);


    // 배송정보가 여러 항목일 경우
    if ($delivery_info_count > 2) {
        $result_deliverytracking  .=  "
            <table class=\"table table-bordered table-condensed table-hover\">
                <colgroup>
                    <col width=\"100%\" />
                </colgroup>                        
                <thead>
                    <tr class=\"active\">
                        <th class=\"text-center\">동일한 운송장번호로 " . number_format($delivery_info_count - 1) . " 항목의 배송정보가 존재합니다.</th>          
                    </tr>                
                </thead>                
            </table>
        ";
    }


    
    for ($info_count = 1; $info_count < $delivery_info_count; $info_count++) {
        
        $content_temp   =   $delivery_info_array[$info_count];


        ////////////////////////////////////////////////////////////////////////////////
        // 배송정보별 반복되는 부분

        ////////////////////////////////////////////////////////////////////////////////
        // 1.배송정보
        
        $text_temp = array();               // 텍스트 데이터 저장할 배열 변수 초기화

        // (1) 운송장 번호
        $content_array  =   explode("\"consignmentNumber\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[1]   =   trim($content_array2[0]);
        // echo "<br />consignmentNumber : " . $text_temp[1]; exit;

        // (2) 배송 정보 항목수 
        $content_array  =   explode("\"pieceQuantity\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[2]   =   trim($content_array2[0]) . " 항목";
        // echo "<br />pieceQuantity : " . $text_temp[2]; exit;
        
        // (3) 출발지 도시
        $content_array  =   explode("\"originDepotName\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[3]   =   trim($content_array2[0]);

        // (4) 목적지 도시
        $content_array  =   explode("\"deliveryTown\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[4]   =   trim($content_array2[0]);

        // (5) 출발지 국가
        $content_array  =   explode("\"originCountry\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[5]   =   trim($content_array2[0]);

        // (6) 목적지 국가
        $content_array  =   explode("\"destinationCountry\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[6]   =   trim($content_array2[0]);

        // (7) 출발일자
        $content_array  =   explode("\"collectionDate\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[7]   =   trim($content_array2[0]);

        // (8) 도착일자
        $content_array  =   explode("\"deliveryDueDate\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[8]   =   trim($content_array2[0]);

        // (9) 수령 및 서명자 
        $content_array  =   explode("\"signatory\":\"", $content_temp);    
        $content_array2 =   explode("\"", $content_array[1]);
        $text_temp[9]   =   trim($content_array2[0]);

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
                        <th class=\"text-center\" colspan=\"4\">배송정보 [" . $info_count . "]</th>          
                    </tr>                
                </thead>
                <tbody>
                    <tr>
                        <th class=\"active text-center\">운송장 번호</th>
                        <td class=\"text-center\">" . $text_temp[1] . "</td>
                        <th class=\"active text-center\">배송 정보 항목수</th>
                        <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                    </tr>
                    <tr>
                        <th class=\"active text-center\">출발지 도시</th>
                        <td class=\"text-center\">" . $text_temp[3] . "</td>
                        <th class=\"active text-center\">목적지 도시</th>
                        <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                    </tr>
                    <tr>
                        <th class=\"active text-center\">출발지 국가</th>
                        <td class=\"text-center\">" . $text_temp[5] . "</td>
                        <th class=\"active text-center\">목적지 국가</th>
                        <td class=\"text-center\">" . $text_temp[6] . "</td>                         
                    </tr>
                    <tr>
                        <th class=\"active text-center\">출발일자</th>
                        <td class=\"text-center\">" . $text_temp[7] . "</td>
                        <th class=\"active text-center\">도착일자</th>
                        <td class=\"text-center\">" . $text_temp[8] . "</td>                         
                    </tr>
                    <tr>
                        <th class=\"active text-center\">수령 및 서명자</th>
                        <td class=\"text-center\" colspan=\"3\">" . $text_temp[9] . "</td>                         
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
                    <col width=\"20%\" />
                    <col width=\"30%\" />
                    <col width=\"50%\" />
                </colgroup>                        
                <thead>
                    <tr class=\"active\">
                        <th class=\"text-center\" colspan=\"3\">운송 내역 [" . $info_count . "]</th>          
                    </tr>
                    <tr class=\"active\">
                        <th class=\"text-center\">현지 일시</th>
                        <th class=\"text-center\">위치</th>
                        <th class=\"text-center\">상태</th>
                    </tr>
                </thead>
                <tbody>
        ";
            
        // 현지 시간, 위치, 상태
        $content_array  =   explode("\"statusData\":[", $content_temp);
        $content_array2 =   explode("]", $content_array[1]);
        
        $content_array3 =   explode("{", $content_array2[0]);
        
        $content_array3_count   =   count($content_array3);
        
        // for ($i = 1; $i < $content_array3_count; $i++) {
        for ($i = ($content_array3_count - 1); $i >= 1; $i--) {
            // echo "<br />" . $content_array3[$i];
            
            $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
            
            // (1) 현지 시간 (일자)
            $content_array4 =   explode("\"localEventDate\":\"", $content_array3[$i]);
            $content_array5 =   explode("\"", $content_array4[1]);
            $text_temp[1]   =   json_string_decode(trim($content_array5[0]));       // 1
            // echo "<br />localEventDate : " . $text_temp[1]; exit;

            // (2) 현지 시간 (시간)
            $content_array4 =   explode("\"localEventTime\":\"", $content_array3[$i]);
            $content_array5 =   explode("\"", $content_array4[1]);
            $text_temp[2]   =   json_string_decode(trim($content_array5[0]));       // 2
            
            // (3) 위치
            $content_array4 =   explode("\"depot\":\"", $content_array3[$i]);
            $content_array5 =   explode("\"", $content_array4[1]);
            $text_temp[3]   =   json_string_decode(trim($content_array5[0]));       // 3

            // (4) 상태
            $content_array4 =   explode("\"statusDescription\":\"", $content_array3[$i]);
            $content_array5 =   explode("\"", $content_array4[1]);
            $text_temp[4]   =   json_string_decode(trim($content_array5[0]));       // 3
            
            $result_deliverytracking .= "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . " " . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                </tr>
            ";            
        }
        
        $result_deliverytracking  .=  "
                </tbody>
            </table>
        ";

        // 배송정보별 반복되는 부분
        ////////////////////////////////////////////////////////////////////////////////

    }
    
    /*
    echo "<xmp>";
    echo $result_deliverytracking;
    echo "</xmp>";
    */
    
    return $result_deliverytracking;
}

?>