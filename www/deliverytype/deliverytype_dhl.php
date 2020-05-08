<?php

////////////////////////////////////////////////////////////////////////////////
// DHL(국제)

// 배송조회결과 구함 (DHL(국제))
function get_result_deliverytracking_dhl($content_temp) {    

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    /*
    {
      "errors" : [ {
        "code" : 404,
        "label" : "Not found",
        "message" : "No result found for your DHL query. Please try again.",
        "id" : "24168445008"
      } ]
    }
    */
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("No result found for your DHL query. Please try again.", $content_temp);
    $content_array_count    =   count($content_array);          
    
    if ($content_array_count > 1) {
        $text_temp = "일치하는 결과가 없습니다. 다시 시도해주세요.<br />No result found for your DHL query. Please try again.";
        
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
  "results" : [ {
    "id" : "2416844566",
    "label" : "운송장번호",
    "type" : "airwaybill",
    "duplicate" : false,
    "delivery" : {
      "code" : "101",
      "status" : "delivered"
    },
    "origin" : {
      "value" : "TREVISO - LEVADA (TV) - ITALY",
      "label" : "출발지",
      "url" : "http://www.dhl.it/en/country_profile.html"
    },
    "destination" : {
      "value" : "LEGHORN/LIVORNO - TIRRENIA - ITALY",
      "label" : "목적지 ",
      "url" : "http://www.dhl.it/en/country_profile.html"
    },
    "description" : "수취인 서명: MARTELLI  목요일, 4월 07, 2016  at 17:52",
    "hasDuplicateShipment" : false,
    "signature" : {
      "link" : {
        "url" : "",
        "label" : ""
      },
      "type" : "none",
      "description" : "목요일, 4월 07, 2016  at 17:52",
      "signatory" : "MARTELLI",
      "label" : "수취인 서명",
      "help" : "help"
    },
    "pieces" : {
      "value" : 1,
      "label" : "Piece",
      "showSummary" : true,
      "pIds" : [ "JD014600002906866591" ]
    },
    "checkpoints" : [ {
      "counter" : 10,
      "description" : "수취인에게 배달되었습니다.: MARTELLI ",
      "time" : "17:52",
      "date" : "목요일, 4월 07, 2016 ",
      "location" : "TIRRENIA                           ",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 9,
      "description" : "수취인의 업무가 끝나거나 사람이 없어 배달이 지연되고 있습니다.",
      "time" : "13:55",
      "date" : "목요일, 4월 07, 2016 ",
      "location" : "LEGHORN/LIVORNO - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 8,
      "description" : "DHL 직원이 배달하기 위해 출발했습니다.",
      "time" : "08:13",
      "date" : "목요일, 4월 07, 2016 ",
      "location" : "LEGHORN/LIVORNO - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 7,
      "description" : "배달 사무소에 발송물이 도착하였습니다 LEGHORN/LIVORNO - ITALY",
      "time" : "06:41",
      "date" : "목요일, 4월 07, 2016 ",
      "location" : "LEGHORN/LIVORNO - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 6,
      "description" : "발송물이 목적지 또는 경유지로 발송되었습니다. BOLOGNA - ITALY",
      "time" : "05:35",
      "date" : "목요일, 4월 07, 2016 ",
      "location" : "BOLOGNA - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 5,
      "description" : "발송물이 현재 위치에 표기된 국가에서 다음 연결을 위해 대기 중입니다 BOLOGNA - ITALY",
      "time" : "03:53",
      "date" : "목요일, 4월 07, 2016 ",
      "location" : "BOLOGNA - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 4,
      "description" : "발송물이 경유지 또는 목적지 DHL 에 도착되었습니다. BOLOGNA - ITALY",
      "time" : "00:09",
      "date" : "목요일, 4월 07, 2016 ",
      "location" : "BOLOGNA - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 3,
      "description" : "발송물이 목적지 또는 경유지로 발송되었습니다. TREVISO - ITALY",
      "time" : "21:15",
      "date" : "수요일, 4월 06, 2016 ",
      "location" : "TREVISO - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 2,
      "description" : "발송물이 현재 위치에 표기된 국가에서 다음 연결을 위해 대기 중입니다 TREVISO - ITALY",
      "time" : "21:14",
      "date" : "수요일, 4월 06, 2016 ",
      "location" : "TREVISO - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    }, {
      "counter" : 1,
      "description" : "DHL 직원이 발송물을 접수하였습니다.",
      "time" : "14:27",
      "date" : "수요일, 4월 06, 2016 ",
      "location" : "TREVISO - ITALY",
      "totalPieces" : 1,
      "pIds" : [ "JD014600002906866591" ]
    } ],
    "checkpointLocationLabel" : "위치",
    "checkpointTimeLabel" : "시간"
  } ]
}
	*/
    
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.배송정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수 초기화

    // (1) 운송장번호
    $content_array  =   explode("\"id\" : \"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[1]   =   trim($content_array2[0]);
    // echo "<br />id : " . $text_temp[1]; exit;

    // (2) 배송항목수 
    $content_array  =   explode("\"pieces\" : {", $content_temp);    
    $content_array2 =   explode("\"value\" :", $content_array[1]);
    $content_array3 =   explode(",", $content_array2[1]);
    $text_temp[2]   =   trim($content_array3[0]) . " 항목";
    // echo "<br />pieces : " . $text_temp[2]; exit;

    // (3) 출발지
    $content_array  =   explode("\"origin\" : {", $content_temp);    
    $content_array2 =   explode("\"value\" : \"", $content_array[1]);
    $content_array3 =   explode("\",", $content_array2[1]);
    $text_temp[3]   =   trim($content_array3[0]);
    // echo "<br />origin : " . $text_temp[3]; exit;

    // (4) 목적지
    $content_array  =   explode("\"destination\" : {", $content_temp);    
    $content_array2 =   explode("\"value\" : \"", $content_array[1]);
    $content_array3 =   explode("\",", $content_array2[1]);
    $text_temp[4]   =   trim($content_array3[0]);
    // echo "<br />destination : " . $text_temp[4]; exit;

    // (5) 수취 상태
    $content_array  =   explode("\"destination\" : {", $content_temp);    
    $content_array2 =   explode("\"hasDuplicateShipment\"", $content_array[1]);
    $content_array3 =   explode("\"description\" : \"", $content_array2[0]);
    $content_array4 =   explode("\",", $content_array3[1]);
    $text_temp[5]   =   trim($content_array4[0]);
    // echo "<br />description : " . $text_temp[5]; exit;

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
                    <th class=\"active text-center\">운송장번호</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">배송 항목수</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">출발지</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">목적지</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">수취 상태</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[5] . "</td>                         
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 2.배송 내역
    
    // 배송 내역
    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>      
                <col width=\"20%\" />  
                <col width=\"10%\" />
                <col width=\"20%\" />
                <col width=\"50%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"4\">배송 내역</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜</th>
                    <th class=\"text-center\">시간</th>
                    <th class=\"text-center\">위치</th>
                    <th class=\"text-center\">상태</th>
                </tr>
            </thead>
            <tbody>
    ";
        
    // 날짜, 시간, 위치, 상태
    $content_array  =   explode("\"checkpoints\" : [", $content_temp);
    $content_array2 =   explode("\"checkpointLocationLabel\"", $content_array[1]);
    
    $content_array3 =   explode("{", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    // for ($i = 1; $i < $content_array3_count; $i++) {
    for ($i = ($content_array3_count - 1); $i >= 1; $i--) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        // (1) 날짜
        $content_array4 =   explode("\"date\" : \"", $content_array3[$i]);
        $content_array5 =   explode("\"", $content_array4[1]);
        $text_temp[1]   =   trim($content_array5[0]);
        // echo "<br />date : " . $text_temp[1]; exit;

        // (2) 시간
        $content_array4 =   explode("\"time\" : \"", $content_array3[$i]);
        $content_array5 =   explode("\"", $content_array4[1]);
        $text_temp[2]   =   trim($content_array5[0]);
        // echo "<br />time : " . $text_temp[2]; exit;

        // (3) 위치
        $content_array4 =   explode("\"location\" : \"", $content_array3[$i]);
        $content_array5 =   explode("\"", $content_array4[1]);
        $text_temp[3]   =   trim($content_array5[0]);
        // echo "<br />location : " . $text_temp[3]; exit;

        // (4) 상태
        $content_array4 =   explode("\"description\" : \"", $content_array3[$i]);
        $content_array5 =   explode("\"", $content_array4[1]);
        $text_temp[4]   =   trim($content_array5[0]);
        // echo "<br />description : " . $text_temp[4]; exit;

        $result_deliverytracking .= "
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
    
    /*
    echo "<xmp>";
    echo $result_deliverytracking;
    echo "</xmp>";
    */
    
    return $result_deliverytracking;
}

?>