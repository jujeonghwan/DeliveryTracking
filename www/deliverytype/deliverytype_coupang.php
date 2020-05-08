<?php

////////////////////////////////////////////////////////////////////////////////
// 쿠팡로켓배송

// 배송조회결과 구함 (쿠팡로켓배송)
function get_result_deliverytracking_coupang($content_temp) {                                 

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과

    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("내부 서버 오류가 발생했기 때문에 페이지를 표시할 수 없습니다.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    내부 서버 오류가 발생했기 때문에 페이지를 표시할 수 없습니다.
    */
    
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


        
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("배송 정보를 읽을 수 없습니다.<br />입력값(배송번호 등)을 확인해 주십시오.", $content_temp);
    $content_array_count    =   count($content_array);          
    /*
    배송 정보를 읽을 수 없습니다.<br />입력값(배송번호 등)을 확인해 주십시오.
    */
    
    if ($content_array_count > 1) {
        $text_temp = "배송 정보를 읽을 수 없습니다. 입력값(배송번호 등)을 확인해 주십시오.";
        
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
    
    
    
    // <td class="info_label text_col last_col" colspan="5" style="color:gray;">집화예정</td>
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("<td class=\"info_label text_col last_col\" colspan=\"5\" style=\"color:gray;\">집화예정</td>", $content_temp);

    $content_array_count    =   count($content_array);          
        
    if ($content_array_count > 1) {
        $text_temp = "조회하신 운송장번호는 쿠팡로켓배송 집화예정입니다.";
        
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
    // 1.주문정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수 초기화

    // (1) 주문번호
    $content_array  =   explode("<span id=\"tb_order_no\" class=\"green_content\">", $content_temp);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[1]   =   trim($content_array2[0]);           // 쿠팡은 텍스트 대신 이미지임 예) <img alt="주문번호" src="data:image/png;base64,iVBOR..."/>

    // (2) 주문일자
    $content_array  =   explode("<span id=\"tb_order_datetime\">", $content_temp);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[2]   =   trim($content_array2[0]);

    // (3) 상품명
    $content_array  =   explode("<span id=\"tb_item_name\" class=\"blue_content\">", $content_temp);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[3]   =   trim($content_array2[0]);           // 쿠팡은 텍스트 대신 이미지임 예) <img alt="상품명" src="data:image/png;base64,iVBOR..."/>

    // (4) 수량
    $content_array  =   explode("<span id=\"tb_item_count\">", $content_temp);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[4]   =   trim($content_array2[0]);


    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"60%\" />
                <col width=\"40%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"2\">주문정보</th>          
                </tr>                
            </thead>
            <tbody>
                <tr class=\"active\">
                    <th class=\"text-center\">주문번호</th>
                    <th class=\"text-center\">주문일자</th>                         
                </tr>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">상품명</th>
                    <th class=\"text-center\">수량</th>                            
                </tr>
                <tr>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 2.배송정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수 초기화

    // (1) 배송사
    $content_array  =   explode("<div id=\"tb_logistics_name\">", $content_temp);    
    $content_array2 =   explode("</div>", $content_array[1]);
    $text_temp[1]   =   trim($content_array2[0]);

    // (2) 운송장번호
    $content_array  =   explode("<span id=\"tb_invoice_no\">", $content_temp);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[2]   =   trim($content_array2[0]);

    // (3) 집화일자
    $content_array  =   explode("<span id=\"tb_pickup_date\">", $content_temp);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[3]   =   trim($content_array2[0]);

    // (4) 배달일시
    $content_array  =   explode("<span id=\"tb_dlv_datetime\">", $content_temp);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[4]   =   trim($content_array2[0]);

    // (5) 인수자
    $content_array  =   explode("<span id=\"tb_taker\">", $content_temp);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[5]   =   trim($content_array2[0]);

    // (6) 상태
    // $content_array   =   explode("<span id=\"tb_last_dlv_stat_name\" style=\"color:#4176AE;font-weight:bold\">", $content_temp);    
    // 일부분 텍스트 삭제 (집하예정일 경우와 아닐 경우 공통 처리하기 위해)
    $content_temp2  =   str_replace(" style=\"color:#4176AE;font-weight:bold\"", "", $content_temp);
    $content_array  =   explode("<span id=\"tb_last_dlv_stat_name\">", $content_temp2);    
    $content_array2 =   explode("</span>", $content_array[1]);
    $text_temp[6]   =   trim($content_array2[0]);

    $result_deliverytracking  .=  "
        <table class=\"table table-bordered table-condensed table-hover\">
            <colgroup>
                <col width=\"20%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"15%\" />
                <col width=\"20%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"6\">배송정보</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">배송사</th>
                    <th class=\"text-center\">운송장번호</th>
                    <th class=\"text-center\">집화일자</th>
                    <th class=\"text-center\">배달일시</th>                            
                    <th class=\"text-center\">인수자</th>                            
                    <th class=\"text-center\">상태</th>                            
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                </tr>
            </tbody>
        </table>
    ";


    ////////////////////////////////////////////////////////////////////////////////
    // 3.배송추적현황
    
    // 배송추적현황
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
                    <th class=\"text-center\" colspan=\"5\">배송추적현황</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">처리일시</th>
                    <th class=\"text-center\">처리점</th>
                    <th class=\"text-center\">전화번호</th>
                    <th class=\"text-center\">상태</th>                            
                    <th class=\"text-center\">담당</th>                          
                </tr>
            </thead>
            <tbody>
    ";
        
    // 처리일시, 처리점, 전화번호, 상태, 담당
    /*
    <tbody id="traceinfo">
        <tr class="info_row" style="background-color:#fff;">
            <td class="info_text align_center" style="padding:0px 0px;"><img alt="처리일시" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJDSURBVGhD7ZoNdoMgDIA93R4H8jbjLj3KPEkZCUQCDRFt57qZ7z2fmmDID6LYToZhnEG4zQF2aZvDLQQ4RsLig+vogMU7UQ4kXbp2jg1Q2GGrHyD56YJfNmwp8RCjtk4nRHfnmK18mhx1PkQ/I1HHnMYE57ZJNwXnfdx3CrW2XYL3pY8WrR+C2jinJ1GLJ4uGbb0F6CwVBILhwWEgdfJHZRoj/dxmuMtiYXcmEW01BTlq61fAqSMnB0aqix6jIoIjvQlCLEi2AYHDKU0N9/t9bcPZ6ocKJvW/BY8HeMbWy+klhEhOluQeLggEHXcQ93rejFKO1g/3aW8S23iesXU6koNyoprkxzOxIKwA3Hb98E4yrR/QrYVtfJRsgRxo2wJfnx9dW29Fzzm6vfNpbPc4H3enrIeC1G04/X7ANiW83iixElI8yc/9tk5HGykpiKJrRzIgFgRtjk9ZI/0Amq/ESBtgtN3pQPBxV298dEMyJTkGxK7BrRSmnk76dwfR64czksSteIi3LYhhHGbrLfFyWEIMwzAM4wJo646RNYm0rqk+p+xc10hc5qVEWmnTpxCug4RwHUdbqGn2DQHxW1QexZs6OtYKotjIIoMDI/bxa21KrqbLIiTJ2ZTFCjBqw8i8oiAt8OMWXWcF2YmcsDSlaLosEsGHeP4oeNTGv6f3liLO8TmZmi6LRHhBjtq4LJigzu8Zmo4D7fx6DdwBZcoatfHT/KnX5vTGlB/Izejt6ZK8TD3lTxH1GgTQ7BuGYRg7maZvJzN/3NY59SoAAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="처리점" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAHpSURBVGhD7ZgBkoMgDEU9ngfiON7Fq3iSsvlA2hAjllbdbjdvJoNgwCQfmE4Hx3Ec5yVut1ssj47jmPgpcRznj+HXlvO5xGWKIzV4hIU53nfrHMY4LY8+k+aQY+kmYlziNIZI0+/jyzSmNZMpf1C9VzbSh6mt6PUHOgesgRy5LcOrOmTLc63cTiHSJ0L5qNXXycxBB5wNiemgsdZEk/Mz3tViA10UJs5hs8AWLf8uQWigdCuuE8RIRI69e0IkKID+FsaoMc0qcK9/jinnIOd+nyDkM4wThUngmYay2UEflZAu4h6pyIhLFJrXMAVJOchccGPI/nvx79J7ZQH2CfROimkV/SFWvU4tYttk0eQuX1nZIPSckLngquV1moLQQOlWXHZCgN4ZMkgtSE4y++QgaU5JohU0+1rXCoMCtd73oDcWYFGOEuRXfqpLQbioMgmARFFIK2iJlTCKQo1p1el78URZHCXIaaTdpI47s31lrYPTQaOIMmEWrnSbYO6W76qQDV+gc2gKQg0eK0u1sQU55ZS0BLHYEkSTBRKJGbsPRaHGtLMEeYWPOSEWzwryDLq4z/CJghx6UnKB7V0K08nu+fcUuHVC9K8mpl8QY202WojaXS49IY7zlfg/1o6zh58Sx3Ecx/m3DMMP2kEdZviJRqEAAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="전화번호" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABFSURBVGhD7dSxDQAgDAPB7D90oKEPBUJB3FVewB8Ad2XmWBPoy1WhI88E2CKX8ARXBShJJUDpRCrlFp7gqgAlqQTgHxET1wInu4eUXwoAAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="상태" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAHdSURBVGhD7ZmNEYMgDIUdz4Ecx11cxUlKE9AW6IsgP1f18t1xtCqQ5Bka7aAoylnMMhnu/DbOK/cB6LphnM1qmNXM42QW+kTHP6zz+Dtma/EafC1ad5lGQ4cNn59oge2wZZnw3LbRxdSLGLJ2iscELfQnts+Nd9dI/p/GBmwL6naIFuLJsSg+FCEzZggSB1GiRBAJe/MkBImx4h6MqRHk9Xrl2cJGICdzHLqCIDUZsmP9oI7ndrsADmyNINnwIrkZ0nrLigPmOxyudSSIO7d9PcXHth//v1uZHwPsS2NBGLQQulM5SOg4k2OQH3CEdP44Q8oFOUtsX5cMOUMsiL8vxgbBbBLaHuQyQfCcrskBamFfU0FKDKrNkBQlgvhI43NJje8qCCJlkCwiGyIbBO9iiiz1Abw+dUFjAVoJgiodf87UeGRfl9+QnZRBR0gGsRhoTuscEAWBBCnJcIQ/Zw//q/i3IFKtnpshJbSa8zaCMLlblkRvQajDLSqHj+giiKLcmuzXIcoXDZqiPAb/JRpuWjX8DVe2kQgnSj2lE64Wd7U+Ffv2v4HS5xGlgv2hSHySVmGeiZaeGbR6Oad0hLcp3aIukNG1L/+UhkhZcfVseezv0l0FeTS6ZSmKZRje8I1vJoTfZCAAAAAASUVORK5CYII="/></td>
            <td class="info_text last_col"><img alt="담당" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFYSURBVGhD7ZgBDoMgDEU9HgfiON7Fo8yTwFpBV4VKmGwR81/SgAhY+luybAAAgDzOOR+7AAAA8uCqBKALUKrgGfjJcibvzE4+m93zaJK5m9EialV4rRlndU6yNzvhZz8a65cevZd+sd/afnJdHOqDIMbecU9PlpqcKMeg1DDZsmgrFH1vLgji3Ks/QcJhjaczJU4vATEjzdi/S7JYWDH7KUDWnM9bWYP9rSByXRy6P98KUlshS2XEvcI36flQKds4dYMFv2RgS4KkydKZIEw4xN7xVlfWIoSyT7gq6f1BGEYmQ40gErkuDv2FJr8st+AI04KeZqGwTEXVckyGENjPN+4uSFM42NoBc8j5LTJjTQzpQ28V0pQrglxFuyZLgnCTGs/vTBD9MKlxEH49n9osZ4Kc8YgKuSMlQbSrEoL8iJIgGjWC4D83ALoApQoAAEVwVQIAQIcMwxtujrnoELqk6QAAAABJRU5ErkJggg=="/></td>
        </tr>
        <tr class="info_row" style="background-color:#fafafa;">
            <td class="info_text align_center" style="padding:0px 0px;"><img alt="처리일시" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJJSURBVGhD7ZoBkoMgDEU9HgfyONzFo6wnKZsE0IAh4Dpr7W7ejGMFDMkPQrGdDMO4g7DMAU/xmMMSAn4mwuqDa9Qhq3diORLr4r0zNKDCBr1+kOinC37t2FLiyYzaup0A7s6gVrqMjjofvl4vCAPqmNMkcGob66bgvIdzI1Fb2zV4v/dRo/WTyW2cO4r4Al/Tx2Y8cEvZpmHrcZCzKQAKhgdHgZTij5ZpjPSzzPiUQWJPiki2qoT81NZboKkjiYMj1YHHVAHQSK+CEBOSbGDgeNmbGnr95IRJ/ffg8SBXbN1OdHIX98cJwaDhhHFv19Uo5Wj9cJ/OiljHc8XW7UgOykJV4sOVmBCWAG67XLxjmdYP1m2JrXyUbGE5UrdFNFtvhS+CSMu5/HinS2h3nI+bU9YhIWUbTrsftJ0FL48srIQUT/TzvK3b0UZKDGKvq0cyIiaEbI5PWSP9IJqvmZE2yGi728Hg4VQefHSjmFI5BcTuoWNPTDmdtJ+OTKsfzoiIvXgyj02I8cvU68OT+SRfDcMwDOMKH73m2YL9ALS9R7HPUPYlLRvSvkfaPBoJabedX4dQHX810ti56zZsI3cKEpmLTuLKTwLVpYTEJye202xYQk5Sv3/SBKRpiQmf0Wwcpizh/qv8qXVvNCGxXH5yziQVf/yyNURBFrMUXhMYGbGRqV/xGxXi/M8E6yUD6dngWEI6xAV4F5yP9pFkILqNJfjC3rkp61/ui+I3prTostGLwm7lVT3/lgXlTRvI/qcJWz8MwzAuMU3fgXdekVEvU5UAAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="처리점" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAHqSURBVGhD7ZgNcoQgDIU9ngfiNvUs9Sj1JNKEnzXEgLo7Wrf7vpkMihFIHsFtOwDAFczz7NMlAODtQAUDAAD4C97q+4OP5cn4afA9NXzJ5kb/SPjoej9My30mvEOO6Tbg/eSH3nl6/dHvRxfGjFY+Y6ahF89L62liaguO+jM6Bh6DY8xt6l7lIVp814rtFDxN4dKk1r0OZnR6wdE4ML3oMJYQLYjTD+S1jKeTkmHfWoItWv6HBBHrlVwniBGI7Hu1QiRBIEMQakyzEnzUP64pxiDf/X+CkE/e7eGauqI1BGkEvBedxC3CnLwuMW8ewxQkxCBj4RND3p8tSJhwSfrWkcVkH0fPpJitXZSffacfBKWIbZNJk7t8Zar6ZCx81OZxmoJQR7otuKxCGL0z5CK1IDFI+c2gd1IQtUXH/rWwGk6Qdew8g95YTBalJsj883UPQVpIQeKiSsEYDpQTaS069tXF4KRQY1pRfU9WlEVNkPtUCO8mVe6Z+pFVq4Slf0uMFixArVpWiWz4MjqGpiDU8GVhITc3EcSiJoiGA6amNDWP6ZNMJln+MfqqIM9wmwqx2CvIHnRy9/AZglDDl5bpYLf8jyS4VSG6mjLHBTHGzkYDUbvJliD4dxIA4FPB+Qd2g80CAAAA1Oi6X1VIJw79BAYWAAAAAElFTkSuQmCC"/></td>
            <td class="info_text"><img alt="전화번호" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABESURBVGhD7dSxDQAgDAPB7D90oKFHJBJFdFd5gXcAAPBDZq4zgSfqAQZxaVClHqhSD3QoCKrUAwzhzqBDQVClHoCLiA39QCe7VxWHowAAAABJRU5ErkJggg=="/></td>
            <td class="info_text"><img alt="상태" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAHeSURBVGhD7ZmBkYQgDEUtj4Iox15sxUqWS0D2kP0RQdxTL28mg4sCSb4guoOiKLW4yTouUjPjzOUKdN1gRjc7ZnajsW6iI6p/M4/ms81i+Rh8LRp3ssZRtePzlgZYqj2TxX17o4upFHHkrc3brGwdT+5faB+ukeKvxidsSepSRQNx51iUFMqQMzsEyZMo0SII4vV6Ua7o5ikIkuPF3WjzFUHYCRTknoCuIEjrDGHRlsMQBxXcd1gFcGK/IggPsneG9F6y8oSlAa/H2hIknFt+VvH27SP+36UszQGOpbMgDBoI3amcJFTP7HEoTThCOr89Q9oFqSX375QZUkONIHA2CRaT3CYI7jOYnKAe/nUVpMWhozOkRIsgKVL7SPrcQJTanyoIouSQLCI7IjsE72LKLJUreHwqVsYC9BIEkfZZao/8O+UZEmkJKCI5xGKgPn1wQBQEEqRlhiPSPs+I/xB3EqQXvfq8jSDM3iVLAglSeh7sxd8YuW/Rsu3wFqcI8jR6iaYoiqIolyf9iIbtfruGxzzIw7aNRKjY6t2RWwgW9uJhr0+bff/fQOv7iHKA+FIkvkmrMMq/pdfHub/m0W/jvEw9cYm6nWhHP/4pHZFmxVNny+VRQS6ILlmK4hmGH2RJbyY3/Dj4AAAAAElFTkSuQmCC"/></td>
            <td class="info_text last_col"><img alt="담당" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFPSURBVGhD7ZgBDoMgDEU9HgfiOJ5lXsWT2LWCrgKVkGwR3X9JI2rB0t+SZQMAAFzHsiwUh+AxQFUAALgUHMMAPBaavLT3wfxExZafR5f57saT+Goic904mz7Z2hIEzTQ6T+uI3+u4JG5rPT0vProHQYxj4MR3ni+pKHIup0lpYfJ10Tb4Q+T+TZAQtCPeUxb0mhA3ssfxXVbFyqrVzwny7txvY0s2BImcCdLaIWtnxLXCN/k+6ZT9OQ+Dhbh0YmuC5MVyM0GEsIlj4NaRJbQIsgphrBOOSn6fCCPoYmgRRKPnxUdFuvx5vCdHmZX0vAqVFTqqlbQYQmI/3/i2IF0jybY2WKLVv8ZWGHrNX3dI11wpiHVM1gSRS27ifzNB7M3kJklo8n8tbf6JCJozQc54RIf0CATpDAgCiuDfYwC+ze26CscAAODh4JgD4H8YhjdkILnpZsLI+gAAAABJRU5ErkJggg=="/></td>
        </tr>
        <tr class="info_row" style="background-color:#fff;">
            <td class="info_text align_center" style="padding:0px 0px;"><img alt="처리일시" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJaSURBVGhD7ZmLccMgDIY9XY+BvE2ZpR6lniRUEhALLARJW8d19d35XAP50QMrgU6GYRxBWOaAt3jNYQkB/ybC6oNr9CGf729iO7J6lz43hRkGUGOD3jxItNMFv3a0FH8yo1qHE8DcGaKVHqOhzgewE4A+ZjQFOI2NfVNw3sN973Q5dg3eb3PUaPNk8hjn9CBq/qSmptbtdmvqvgwyNicEneHOkSNl8LW2j0EHR+ZZZnzLILGdhNSQVpWQZ7VeApWOFBxcqQ4spg6AVnrlhJiQpIGO42OvNPTmyQmT5u/B/UG+o3U40cgtuE8nBJ2GG/p9f65WKUebh9v0aBBrf76jdTiSgXKgquDDk5gQlgCuXX55xzZtHuy7J7ayUdLCdqQei2hap6JlXH690yOM29fjZsnaJaQcw2nPg9o54OWVAysh+RPtfFzrcLSVEp3Y+uqVjIgJIc3xkjUyD6LZmhkZg4yOOxx0Hm7lxVc3BlNqJ4fYZ+jaElOWk/bbkWnNwxkJYs+fzGkTYhiX4JSbyJ/k8g4aJ8NWnPFrWL02roG29yj2Gcq+ZFhD2WgagLTbzsch1MePRho7d1WDErUlCE+Spd28kaAg86BTcOU3gfpSQuKqj+M0DewrDiCr8zKjoj5/0o4mKJgs8BlNY9/XTrgBjCYktsuB1DTqkoVjR87I/i1yMMuAtZKU6WnE8ha/1Ol/+Vay2oj1nwWslwykp8FplT0jEWv6FnC+2keSgegaS/AP6l2SRzaRvKTwn7Wx3qf2qj9+Ri5L9U9jrgMvx73d+MPYKYVhvIZp+gIan3wH2jNOKwAAAABJRU5ErkJggg=="/></td>
            <td class="info_text"><img alt="처리점" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAHjSURBVGhD7ZkJboQwDEU5Xg6U43CWcpRyElI7y+AYE5YZEOr8J1kJwVnsHzOV2gEAAAAAALCPaZpC7oIW35goXA4ALiWMfXDUcJfND+FVcoN3oR/n50KcQ475MRLCGHrnA01/jYfBxzWT1e+YsXfifW2ONqa24qg/o2PgNTjG0ubhRR6SpblWbJcQaAufN7WedTCD1wdOxoHpQ8e1hGhRHNeT17yeTkqBfdcSbNHyPySIOK/kPkGMQOTYuxUiiQIZglBjmpXgo/7pTCkGOff/CUI+5bbHPg0lawjSCHgvOolbxD35XGLfsoYpSIxBxsJfDPl8tSBxwznpW58spvh4eifFbN0i/a4WsW0yafKWL0xVn4yFP7VlnaYgNJAfK26rEEbfDHlILUgKUv5m0JwcxNqh0/hSWA0nSAr8zt/z+mIxRZQzgkzT732CtJCCFAH8T50oDpQTaQmyJQYnhRrTquo7WVEWZwSxYruMeJtUuRfWP1lrlTCPb4nRggWQgkgWiWz4MjqGpiDUcLeymJuHCGKxJoiGA6amNrWP6ZPtKkHO8JgKsdgryB50cvfwHYJQw13LdLBb/kcS3KoQXU2F44IYaxejhajd5FZBAABPAP8n2MmTEnXXWXA5AAAAAPBhuu4PmJwnD4piwv0AAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="전화번호" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABESURBVGhD7dYhDgAwCARB/v9oWlNfUdKEMKNQiFMbAABMlJnrnE+q/rQ1fgAA4E55FVBdAAC/yFcAgG6UVxFDAjQRsQE5Zye75oyo/wAAAABJRU5ErkJggg=="/></td>
            <td class="info_text"><img alt="상태" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGoSURBVGhD7ZgBkoMgDEU9ngfyOJ5lvYonkU0Qu8j+UKDq7uh/MxksWpL8D860HSGEPJhlWVy4JISQO8LXHCFHwhP1UOaxd/04/735bhq0iF2gwtBzXT+62SmzG/vBTXIl8y+0SRlgpDksQaahdzLt9P4gCcK0Zxrw2j7kYRlNnFQ7pN/Zxb6fNL/XI+SIrz/CCxZEDVNSqIqLTYkRhVxfYEgqokWLIRbLV51AP+b87mHjEkN0h6EmSxL8B0M+OSG6ngwh1trTUxPXs38+RMjh9Qpzpf1CfJLCExInfcUHr6xUMH12y7nPlTNkvRc+nkqaP960JRu4GCQa2qmaFM0rliExseAI637+hLQZAjeXEVtOpNMphpRSY0hrw/WG4DXXyG+QFCv/JbQIVmNICy2GxLQIqt+RAQZaK6vb0SfkXUN2MWqEbQjcxaB4JI4acKYhFrnNh/DaXG1IDuuEqBloTS9+YQPIkOxOTeKdiTLAQHVn8z7ZkKOoXbP25KRU/Q10hiFK6SvL4mxDZMCR/BxQ8icT90/uDv9tJYQcD98sd4OOEkIIMem6b6ynmNLEY0gGAAAAAElFTkSuQmCC"/></td>
            <td class="info_text last_col"><img alt="담당" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEjSURBVGhD7ZhRDoMgEEQ5HgfiONyFq3gSt6yIIoLRtEkleS/ZlFL8mWFnTQ0AAAzJPM+yLgEAYEDIcQC4iUgQFz90uZeLu7LESHBW/JTWyuRtcW4vq4dkEm/3Z0uCOz9jXDidg0iZ4TJ5sdZHaduGZJKRR/F7hqiJatj6daO3DwV6k+PF3UTqGqLGmeNvGPJjljiqYqRlSBI+GuecmKKbiKwvyVGVBW7d1tqQbeasYi4mrtF1ZUjdDW/qjle9didB27Gk1IboTa+FzJ1VGyIhdpCad6PKmIQfcdUh8IAcWbo8V2+GnIW/MoQZ8oAkZDu2+kP9fif05kW5/48cf+1fNm8wBAqSwI1IWapnSOtsqtaAJrJgbMhwABgAYgMAAGBUjPkA0ZfjbFJWbPwAAAAASUVORK5CYII="/></td>
        </tr>
        <tr class="info_row" style="background-color:#fafafa;">
            <td class="info_text align_center" style="padding:0px 0px;"><img alt="처리일시" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJfSURBVGhD7ZkLcoQgDED3dB0P5G3KWbpHqSeR5gMaMAHcTt3dTt6MoxAIJIE46M1xnCuI9znija853mPEZyIuIU6GDFnCpNYjLOO+MzSgSoPeOAjPc4ph6ehq2JMZ1XU5EaY7g7dSkSc6hQjzBEAmJk0OTm1ZdotTCHA3ArW1XWII+xg1rXEyuc00tZ3YsidVDet6CWiyOSBojDSODCmdP1rXYmSc+4y7DAJ70omkqwrIo7qeAqWO5BxcqRPMmAQArfTKCDUgSQcajsVeauiNkwOmjV+zrmshk/YgZ3Q9nXX9hknuzn04IGg03NDurVytUklrHH5m/WedKPvW5bO6LkeboO6oyvlQUgMiAiB1ly9vrmuNg7ItsNUcNV1Yj9RtkZaul8KaXN7eqQjtjvnYTFmHgJRtJPY4qDs7vLyyYzU0e3ie53X9mjqH9mitFDZil9UrGVEDQjrHU5Y2zsfn96Fta66ZkTbIaLvLQePhVl5ydaMztXoySPShaw9MmU7s3ZGxxpGMOLFnT+ZlA+I4zjM5+05zHMdx/h/+LngzeucOeT6wTsbFWUQ7/Rsyp0I7actPIbJMBzLl3wjpEH3k6b6n/235q7RDzpPOJAfyKpbPSbzBO8KQYb8ckEr/un6ZOh0AV6z5+RxTDThz9N9IJvfD55b+VOVImgFJ7wXwLcmpbHyrynD/fQd4QE6iOyylrCoAPWdq8pb+VOVI6hxf5H9MPYeAsDMPv1uVYCAt/anKkZCDjP8m7OR+yrKCgbT0OwbkaLjRVTncOkNwHy6jk1kuLrmzGvodx3Gck9xuPxfnfellqsguAAAAAElFTkSuQmCC"/></td>
            <td class="info_text"><img alt="처리점" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGmSURBVGhD7ZnrsYMgEIWtLkNBdBN7sZRrJZJ9YC5uECTJDzHnm2HUBWE9BzCPAQAAAABllmUJ8RSAD8FsAgCAn6f5VTCPjm/4L34KIcxhdD7IGdVziNvm4Ho3zsVBZQzqJF4Ok0/GM8X2pbkkbdxIEc0nTP6l31Ku3UHqB9dgiAhL7bwIpu1j1ZO1z3hZhAW2hvAYaSw1VwyhAxdJO8mb67tnFaRkiAiSiCBBIlBrH+NbAX3gLuNlEWtITmAdR2N2hTClCXR69IFVRC1OxCsZ0gL3c78dn7FvrRBjSMuKPDXyIHF/3jNEBKDDkcL3yGwuiCP15p1gDdFckr7tOyTGnzmaPrtEt4H0obYirPFWarPVisfmW0NKZFdI74ass2xv785tWX/3m9yTK9t+SJxGQ941f6VrQyR5OlgRaobsYbecmjgt4nEedNiWzL21VdklNUOy4sRit5zJ6wcFPk/3/FpJx5TxMiLntiyb7yV+oztiiI3t8Y0Zu2eIjad5x9A1+GSF5LaRb3yDzo5pxrrcN3UAwFnBH2QAXAWsZvB7YNYDcE6G4QG/nAPPbO575wAAAABJRU5ErkJggg=="/></td>
            <td class="info_text"><img alt="전화번호" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAI6SURBVGhD7ZbhbYQwDIWZrmIgtmlmKavcJJfmOTZ5QGLoXVX1hz8pAmJsP9vh2ikIgiAIgiAIgiAIgv9KfqQ8lwtup2nJa864n3J+5DTbfl1zeogNjPzAI826X9aybvvA88vrovsXtjkVdc0GOGdJudm8fKD6nffBMOaFlpfJRcYyzbn0WQKKAG1gHUizMb7fmpMOzoZqxVz5LXoPpGgttja1NW1d9ofjpDtRTC9fucwpletgUL2YF1reQormJojImswdiOOnWxsozATLe3SipDiKw/C7yHf6Os3m5L6Tr+fvxnS06NbrcLMAD6He26deFhXi+emWUPf3hdmJsvgl7M7H4Oad87WG2XuIC9NEXwS4ytcdiBPT06Jbr3O3sYA/zSs/+YIOhTDwH9lAjdeKlAZR0dVfB6K5rNHyfDixXr7uQJyYnhY8v0W/sf3gIkRF3fWr+22Qtfj9ieUvD9T9c/PakOFffvetQYcBsP+9fIOBDGJu9nLBYi2wvYUEJoEibhCcB8J+z+cTG76fvgs/b5CjYRzZxSRd8kwxr/KB7kCcmPICwVrepoppDeCTD9vxvyW2Df1KE4o+uQf8UyeD/PhshaIYbUZvGBg2rmctdFpVG3LK4UAOPjjcWMrHsU8DoZjyzDEdLb/C86skK7FlkXjQ/qi1phoisuNnxWy2w+mpv7lm3w+17euiuGzngYPaaPPbN3eU76RTVvO9G/OoBdiw/4SfJPtTYUEQBEEQBEEQBEEQBL/ANH0DnU5QU034VroAAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="상태" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAF/SURBVGhD7ZkLsoMgDEVZXYcFsZu6F5dSV2IeoeQN2KBg0f7umcmURiQkl9hOawAAAJh5nikOAQDdQGcBAAD4RQ77/KPR8cKZ2WF6CKbNM3agiZiJButo9CPv/2ca7OM90ZYxeK4Wd3SWvJv4uvMBolulJZ7gFybrF45vAyHXhe8UQgKxqNFl7sUtJyCERCoE2Sqi0EuQmniSIw9zu8c6SpDNrhqdUROo2dAnC5LysR3S+5G1TDgVJI91nCCSq8SI7ix+y3pd0IqmnVTepOZnSoKkpAXXKF2XDrldL10F8c8lcpwv38Bd4sdy78s6pIUWQfITvm5ShC1BaorNc/yLbkmBRYw0nvg4xumC7ClYiyB76CFICs+/XG+79/NySgURyiKyEGVB+IuDf8lNOX3a6WYBnhFkLR9G3ZuYssdTqUmgRKlDOGFtzVD8yoRrBNnT8WuE9SCIzt4OeYa3FKTlp4GSIEztI6vEzwoCvhT86QTAu4MuBaA36CoAAFjBmD8/8hxmljnUXgAAAABJRU5ErkJggg=="/></td>
            <td class="info_text last_col"><img alt="담당" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE4SURBVGhD7ZUNDoMgDEY5HgfiOJxlXMWT2LX8mMrAwbJEtnwvIYqCSh+tBgAAAAAAAAAAACsTnCE+pGY9bURybig4Mi7E8xraPNnGveAseX5A7h60xhO/yVtHIb8PMJu3p6Dr/jeEPLRs1XgqAyEnWgHR166ERHE5m+K4I9gXGaKyT4CQiiEhMchpR8cBDN8gZxx5lqKvC62SlZ6pM0PmF4FrCtn3/Z5vmi1ZKZgp6CXQRYosohZySI0msoiSWY0NAZjRn3oKYBXwSooWouVJvyDSbTS6hpDbsmGWVoYUZhZxLlF1Q4a8IIGXHZu7B1dCekEumTICSlaHnpAevVJUl6/CShnyE+VpRIheyGdCkAnDxNLEh3ZrB3KmZF1nyFyZm+Fnftbv+JuFgPvAJgIAAAAAAGBhjHkCyu8q1b6qkJwAAAAASUVORK5CYII="/></td>
        </tr>
        <tr class="info_row" style="background-color:#fff;">
            <td class="info_text align_center" style="padding:0px 0px;"><img alt="처리일시" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJlSURBVGhD7ZmN0YMgDIadrudAbvOxS0epk8hHEtCQhh/bq9VrnjvPChiSvIBiB8MwjsDfJw8nOiZ/9x5+I352fizUAbMb1XKA6ujeKTTAwgKtfgDyc/RubtiqxJPotfVRlmV5diy4O4VsxUtydHQ++BkIdcxpTHBsS3WDH50L54JQa9vZO7f1ISn1w/1NbcaxnsRaPLGo29YpQGeTIBAMDw4DyZPfW1ajp5/7BLMsCLsziWhLCPKqra+AS0dMDozUMXiMFQEc6SIIVZBoAwKHy9bS0OonCab134LHA7xj63DIyS25LwsCQYcTxL1ei1HKqfXDfdqbRBnPO7YOR3NQT5RIfrhSBWECcNv5w5vKav1A3Sqs8FGzBeWAbAvUbB2G9iCXlJxL0ztehnbP63FxyXoSJG/DKfcDtlPC8yMlVkOLh/zcb+twaiOFgtjq5EgGVEHQZv+S1dMPAHb/bjfV10QtHk5vu8OB4MMpP/johmRq5RgQuwePTZh8OSnPjkSpH05PElvxJE4riGEYxsnpefM6E1fz1zAMw9hPbe+xZ1/y+LupbbK9Ssfe5tR8+sGo7bbT55BaHYfa6f+xYB27p7X7/3kwQTxhmFxKKv7mu3yYLUksHPVK8hszQNo0BPL7k/w0Af+NQH365BL0qCe7JQgT1VBoCQLQd6b296OWIGS7LtjPowtCSaME5zNEe4YkaoJoQl+Co3e36jMkrvFQVxIrFmWUBFmWxzXF+AaUxC1ZfMbINyJ6Bd4nyGVnxjehN6a4TxBvQPT8SHuILbH8LWtdztZ2cFBdfn887C3LMAzjNYbhH06pWruEsiI0AAAAAElFTkSuQmCC"/></td>
            <td class="info_text"><img alt="처리점" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGhSURBVGhD7ZiBkYQgDEUtj4Iox15sxUrkkoB7mAsoLs4eO//NMGpAiD8hujsBAMCzbNsW0ikAb4BMAgCAR0B5BeApuu2udXY80W/zSwhhDbPzQc6on0081oL73bxWnZE1aJJ0OS0+W081PVf0JRvjZrJEf8Li/8xb83U4SP3gGgIiwtI4L4LF8anrxT5nuqxmEgusA8Jr5LY8uBIQOnATtzO/uX94dkFqARFBMhHESAQa7ZP9KKAPPGW6rKIDYgkc14k2vUOYWgL9e+IDRxFjcyJeLSAtWILWuLVDVED0jhwWeZBUn0sBEQHocKXxPZLNFXGkX70TdECiL9nc+h2S7C8f1Zx3+egncCwD+UMdRdjtrZxlqxaPg68DUsPcIZ0C8jH2LCvVbqtkSdmgYVY7zkPiNAbkbvB3hg6IOE8HLcJZQEroknMmTot4ZhIY957tyiHptUOYxccPBT7Pa/5Zy9eU9QyRrZLVkkDDcCUgVx+6R8aWAqLtud/J9B28s0OsMtLjF7S5plrr636pgzL4Jxj0A9kEwFNgdwEAAABXmaYfKuYLyIMiwaQAAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="전화번호" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAIvSURBVGhD7ZgLboMwDIZzPA7EcXIXrsJJmsUv4hhiWGGa1PqTUKnN7/iR0GkpCIIgCIIgeIjX61X4NvgoYrJBEPwjZc1lqh9wm9JcllLwlVTKWvIkdrqmvKIPGOmANU9sr9e8bHbA05VlZvuJb8o1u+YD9Jp1yc13TWfWOqvdyfMWpYaa01TqWhgQk+MGUlLNp/F1S8mcvBQmDTrTzXwPYNHcQBpiK3yZ+wbt8s58r3Tw26d1lAt8z/XzaCBO7YM82fQ+GEwHxyQpOTcpR8emDWhW1wSVPDZMxdHoZ2G93ekUn7O2p2PTYe5e7RZb0y10swCdCN2rY6sa5+nYhJC9L1Z2qcSvYTuNoIe1X681UZ6DuOBK5gSOdGwa2Ma1W7xN9WuuNtYe9zMdniAoRDVHA/qRD6B4rUlYtGoa6XkgvJYMFr/L6XF08B04GojFviIFm+dtjht7vAAWx4Ve1ZH96L2NUdBndx/Z98NqQwZ9fe9L09UA8DmjH+nAB1wZiK6dTcM8b4HJqoZgcmZhQSd1VQcnC3X8LOi8QV4tsotpmmVjarROeGcgfzIMgJJpgfXOB5/9a6nf6QNdbXqtGe+B7i8bGKQuDArlZnhF7nNpz0lusqZew9MJVEs/EL/2cZ6PgAXUD7zMLm8/lC0hYaSTAjaf2ZH0Hhd/P9Rm50vF1X49cIAGK7q+uSPdLk+8mnZU+1meQfAdxD9Rg+Bp4lQFwdcQxz0IniZOVRB8Pin9AC4nFDS9W0OtAAAAAElFTkSuQmCC"/></td>
            <td class="info_text"><img alt="상태" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAIjSURBVGhD7ZoBkoMgDEU9ngfiOJ5le5WepGy+kBqzEXHA1m7zZjIoIAn5gnRnB8f5t9ynMY7TPebbPtzCgAFN084QABXCQrzFGG9hjNQ1oj1QBfoCqonTmPrkqhX8XL5dYgkhhuwD45GDORYu584G0v/iG6Udn2YvwRTAMy7btufazN7k5+DGiabbTxBAg8SRBsE1j/cKQVKySZBCvJLU/2QRJDWT5/auggi/9ynM7WcLgnpOLCfa8pP6rVfDIkyyUnxNlCaPtiGvDtzLba9VEJm0HzFurSBUCCsLwv15TNzLa9n2cmalRZKtyacE00RFP1BeITJBi6GfJQjXzc+G5IdjqRGE/SffLMjaL9otpCAa+EZRYyUf1WhBdHCcXCvgLUH20ILQALSHZxHEt6RdkL/x9UhwScBmLEGOJLcH2PrYp05eb0GO8ng8nnFRYVpXcbQgW8z9RBDa9IRTYuy+A51qkCi6ThOlh3GtYzkiCBXC6gQxj/45llr2YtsFA6Cosdq3yprw8qZaiVhvWYxcKaBWEIvkf1sQ1FljluqpMK1JkFZ4CTO47yWI5mqC6DEuy7Yg9hslt6wSZwoCjmxZGIMK2yq2fMd5P3o7dRzHcfqjTx04xTx/nIlrp43qb5oLcjHMM7UUJNdJ0ZwTeccK8SNpgd0VcoIgjvNZyG/FH/uCFfIxW6hvWW/i21fI5YAg/CdtPwFdgOIKedU/gTnONRiGX0+nDb1WAhUzAAAAAElFTkSuQmCC"/></td>
            <td class="info_text last_col"><img alt="담당" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE/SURBVGhD7ZhhbsMgDEY5HgfiNuUuHGU5SVwbSGYcs65T2VbpexJq4lj94RebJAEAAP6Gfd+pHwIAwGowcgAALwLjBPwuRBvlGOSuMytRIaYkCqlIbKDGVT6nnDklRcrb5/mB3N0ljbmCFwOMFDlyJftpxRNCW6YYM6tsRbxKHYVsOapr1zwImVALZ4vvCJE8T9wRm3XIDAhx2D9uFHlMJVPMKqTf0UfRnu0QgfuA0nmdl5IMIYZWrFbEdtz2j3rN6RBBi5KlC2o7pAkbY7rLIEShZfTQKGgi5CsgZCE/EeJRxxz/yGFd6j/fXciydyP3aUjtFZbZI7Pd8B+BDnHwnrCE6R7SZdhC2ngbf1dp5+JECHFYJeQ7rBTy1p9a3JHlyDiYjaxni4sOAcDj0TjBl10AwIvAOAEAAAD+AyHcAdq26Zx98fNdAAAAAElFTkSuQmCC"/></td>
        </tr>
        <tr class="info_row" style="background-color:#fafafa;">
            <td class="info_text align_center" style="padding:0px 0px;"><img alt="처리일시" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJ2SURBVGhD7ZmLjcMgDEA73SkDZZtjlnaVThLOH9w4rvmkqtLo6idFScAx2AZT6CUIgiPItznjja8533LGZyLfU54qdcg9TW45wnX87QwCVFih1w7C/Zxyund0NewRRnUdTobuzuCt8sodnVKGfgJQpzpNDi6yXHfJU0pwrwTqIXvPKa1tWFrtCCIzTW0ntuwpRcO6TgF1VgKCxijjluX65Hw2rl/WwrbjfX+bcZZBYHc6UdtTil7W9REodRTn4EidoMdUAdBIN0a4ASk60HB87aWGXjsSMK/9Htoe5FVdy7IMt/k2uJOrc18OCBoNN7T78W5GqabVjvTpCg7Z60Rrj37fq+twvA76jjLOrwVEBUDr3i7eXNZqB+segTV99HRhOWJlkZauU1HrnEzv8gpyz/m4mrKeArKV0dTbQd3i8O0ljvXw7OF+7td1OK2RwkasdXYkI25ASOd4yhppB2n1VRiRQUblDgeNh9v20qMbnemVk0HqG7rWwGzTSX12CLV2NCNO7NkjnDYgR/KRXypnJZwRnIoYkEEQBEGwg9beY3RfstlHqN27u78Y2N/8W3q/Urzdtji0VadBuQRC/Mwbz9qxhj1uCQzueVQZwfSsd/k4WyRYtEP3RzoGzjtCQW7zl++ye1jn2aMJ/G8E63sjX2A5P1D28DJw6AUEoVRljskt65lWXQ719AL69fgBUSkLivQM6eV/kdM6EZ0KS1Hg4a4hJa1gXS1YpchFrzWCbSeowCN3TTN6xpATf34pOPROP4GfA4JyOhXJulNeSyDbKa/F151nkePhRpdZdHn9KHUqcPyNpLaSzkTOzo5YzIMgCN7D5fIHgdQ6L5L7s3MAAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="처리점" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGpSURBVGhD7ZgNcoUgDIQ9HgfiON7Fo9STSJMArzGN+FM7g85+M4waeIC7EGwHAAAAAPTHsiyp3PZH15MDAADQFTgzbmAeA4v4U+KUUprTGGKSO6rnELf14Powzk0jZAzqpDwOU1TjmWL7ynNRbcJIkTyfNMVf/da5vmJxkPopnDBEhKV2UQTL7UvVh9pneWzCAltDeAwd0+aKIXThItNW8+b6x1MFaRkigigRJEgkah1LfC1gTNxleWxiDfEEzuPkmN0hTGsBdU9+4SxiLkHEaxlyBk/QFpd2iDHkzI7sGnmRkp+3DBEB6HKk8G9kNTfEkXpzJlhD8lxU3/YMKfHPHE2fjySnAf1SaxFq/Cx1tW4dsFY8Nt8a0sLdIZ0Ycvmjoq6yrdztpSxJG9TMK+t+SBwjmMYz5Kr5lV4MuYRMni5WhD1DtrApZ0+cM+K5i8D5bd2V5fEd3LVDmCnmDwW+1zl/r+gxZTxHZC9lnVlAj+GIIUdf+o4Vu2WIjet5l9A7+MsO4TTyZQ40/Rf0VdwxTcryxsG/cwAAAICH0tMhjg8KAAAA/8swfAPs1gvFq5l1FQAAAABJRU5ErkJggg=="/></td>
            <td class="info_text"><img alt="전화번호" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAItSURBVGhD7ZgLbsMgDIZzuioHym3GWZar5CRh2NjhBwrNSCc1mj8JJTUYP6FVJ8MwDOPfs++7l1fD6GCdYlRYUxjGHbCTenf85vwcHvQ6TYtfveeKer95N6s8jtltPEe09IjNzSIPY1kPOdHT8+si8hdzswvepTkCbQaTx9ywvY6eEvVnH9JSzQ3hg5kFNuSgJIGxIM+N9fVW76RwWlRN0Cu9Rd4JDlYSH5OTkrIueXNUfjvYc8ReR0/RNXMjR0Ps38EJdIqNxMC7BSHnG3oiOqBgNHm8DrqbE10EquBasledzix5jQ6+YO9VfNQUy9rO0RCYLAKLoN1NYh7gYE9PREyU14GQru4fts10FExebS8lSNfRvjRVXiHvsZfHpwUr5Zc5m1gCr4lTDodH634lfZ179isk7pcKycmCDo36UhCxpYnmz3AqCLQnoozSXi8+XFvGfZnnhpNjCCdFAj2rF+WpkLGz847Fk0dEeR1kKjLpu/x6wWsJ9M/a+3o8Mnu9+GjuKD7Y4oVX4WDAQQ6g6C4FC/JrPVlLer1Cng0w2xP84s+w56i9dnyxwCQqR1hOz2uwITjK2Bk0V/5awrmmXggGncOrjgPF5FEy9eppJIeofUnr1De1iTau2GvFh/T2GIadDg8e4DyRvihTUpWWnibomINOIyi48JCRB53kMmBfnC+7MSZa9dIJIEbt9fKi/ElBDMN4B/YnmWF8OnZKDeMO2Ek1DMMwPoNp+gEYukzdVqxWnQAAAABJRU5ErkJggg=="/></td>
            <td class="info_text"><img alt="상태" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAIwSURBVGhD7ZqNccMgDIU9Xc8DsU28S0ZJJjHVMyiWicC4/ilN9d3psIFIQs8Qp9fOMD6W59D7fnj6eHsMd9fBoWppMCRAjTDn7977u+s9TfUYd9SBuYB6/NCHObFrAX8u3s65OOddjAF/FGDKhdtpsoKMP8dGq+eXslZgSuCVl275te5mbfFTcv1Ayz1OEEBOfE9OcM3+rhAkFJsEKeQrCfNPFkFSs3geP1QQEfc5uGn8bEHQz4XlQmtxwrzlbpiFCVbKbxelxWOsi7sD9/LY2yuILJr0WysINcLKgvB89ol7eS3HLmdSWhRZW3woMC1UzAPlHSILNBvmaYJw3/RZF+JwLjWCcPwQmwVZxsW4hhQkBbHR1FgpRjWpIGlyXFwt4Zwga6SCkAM6w6MI4rtkvyDv+R1R4JKAu9EE2VLcI8ARxTHT4h0tyE+BD2pUWxNnHMfi+IJUkBzTPJFEaumCQ2H0uR291aBQdB0WSh/GdZrLFkGoETYLcnuMWUHUV/+YSy1rua0CB2hqrPap0hYMQW5fKIxWiOWRxcidAmoF0QgPRH6HoE/zWeqnRrVdgpxBTpDcm1ZOkJTWBEl9NEteEP2JkkdWiTMFAVuOLPigRjflyN/0vfHpWDGMdrGn02gGexgFf7oY6VsH3mJeP87EtXERZwhi23UH6ju1FCT2SdGME7EjqzFWd4gJYvx75HfFm9kOaQc7sn4J2yGNAUG2/knbOJHiDrnqn8AMow267huQPwm/8bbWewAAAABJRU5ErkJggg=="/></td>
            <td class="info_text last_col"><img alt="담당" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEYSURBVGhD7dlhjoMgEIZhT9dwIG5TzrIcZT2JszOIRSjSumuyP/o+yURA4g++QG2cALxrWRaxyl38J4IAAADAh5iDE/9VXn8lepl8TP19uyVzENfcE5klOC9RpDxPe14v1izlJMzrnOhLG+r7fjsVSPTt4q6l09RBIC7onTK2D4FAduyPoe0QbdY1CGSTdkiz0ARygXRk6Qrm7vMO0YtVNSctfBmvjyUC+ZOXgeT25hFSSiIHkRecHXKBM0fWGsDzAtoznA0eBbI991EEcqn+Im9VB/IKgXQcvTmlao6skd4OMUfjhkBO6P2GmLM7ZBQIGqMPVONA3l9gAjlh9JHqdzukfkU2ayD9uVb2QqBXAAAAAAA+0TT9AKOAD0WweYjyAAAAAElFTkSuQmCC"/></td>
        </tr>
        <tr class="info_row_last" style="background-color:#fff;">
            <td class="info_text align_center" style="padding:0px 0px;"><img alt="처리일시" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAJUSURBVGhD7ZoNkrMgDIZ7uh0P5G2Wu/Qo60lk8yagkYaf1hnb79s8M44KGJK8ikJ7cxznCuJ9jtjJNsd7jDhm4hLiVKkDS5jMciB1cu1MDbiwwvrz3ewHiJ9TDItta11XLm/Fk+nZehuR3J0pW+lUHJ1CJD8JqlNOc4JTW6m7xSkE2leE2touMYS9j5JWP5ncZpraSWzFk4qGbX0E7GwWBMHo4DiQY/JHy1qM9HOf8ZSRsE8mkW0Vgrxq6y3wEJWSgzt1Io+5guA7vQjCFCTZQOA47Q0NvX6yYFb/PXQ84IytyxEn9+S+LAiCph3i3s6Lu1TT6kf79GwSy3jO2Locy0E7UUXy6cwURAmgbR8/EqSs1Q/qNmELH2Hrq7CFclC2BS1bH0XNufx4p1Nq9zgeV4esB0GObTT1fmA7J/y45cRaWPGIn8/bupzWnSJB7HXlnQxMQdjm+JA10g9o+ZoZaQNG210OgqfdcdN3N5JplXNA6hredmGOQ1P96cjU+tGMJLEXT+ZjBfkXyRNAx3EcxxnB3xv/IS6q815kDvA45zjMMRpzktrcxZrzWBNHJ5GXJazfRrhOL4tUZu3WbB3LKRhmfBL3ItYySgm3SYLIkyPt+VgLp2ydEeRPvzeGBMGwpBKfKdevtAgPQ5ZxvWPQE0QSa9e3BElFG/jhy98hA7QE6Q07tiAVW8XyvlOhJkhPDKDfIfIiJ1u1Vd+OID7fSFiCjIgB5Nq9nX5iUBe2Y9jzIatJThIO902E4c/XQzltxlcWlTd/E9n/MOFiOI7jnOZ2+wXBWTwiiXUHkAAAAABJRU5ErkJggg=="/></td>
            <td class="info_text"><img alt="처리점" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGtSURBVGhD7ZgBcoMgEEU9XccDcZt4lnqUeBLo7gIJ2a4oTtJK8t8Moy4I+D8sTQcAAAAAAJDw3od0CwD4TJAGwEs5tMCWaeSX7sXNIYQlTKMLckf1HOK2Flw/Tkt1YBmDOkmPw+yK8VTRfcW5FG3GiSJxPmF2v/qtzbU7SP0wNhgiwlI7J4LF9qnqRu4zPVZhgbUhPEYZK80VQ+jCRaZdzJvruycLUjNEBClEkCARqLVL8UcBXeAu02MVbYglsPffNE6M6R3C1BbQ6YkfHEWMZRTxaoa0YAla49AOUYa07MjTUR468iEpP68ZIgLQZU/hd2TXVMSRenUmaEPiXIq+9RmS4rc5qj67JKeb+0c9ipDjrWytVi0em68NqWHukN4NyatsLXdbKUvSBjWzymM/JE6jIUfNz3RtiEyeLlqELUPW0ClnS5wW8cxFYLzrr5d+z5A1SkOul6/DO4SZXfxDge/LnL9VyjFlPENkK2U9Y5edjj0pa+9Hb50je1gzRMfLeafQe7DHELrYxUgjz/gFbY6pxnq7X+qfAv6JCf4WrDgAAPg3kIIBAGCFYfgB4pQDzBvcjG8AAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="전화번호" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAIuSURBVGhD7ZiLbcQgDIYzXZWBsk2ZpRmlmeQov8HhhwTuSq7qy5+EkjMYPyFVJ8MwDOPPcrvdfHo1DMP4LuwqMgzjh/HrriW/OT+HB16nafGr9xKA95t3s8rjmN0mc6ClBzY3J3kYy7rLQU/Pr0uS35mbXfAuzwG2GUzuc8P2OnpK1J99SMthbggfzCy0oQSVEhgLcm6sr7d6lwqnRdUE3dNb0juQYFPiY3JyUt6WsjkOfjvac8ReR0/RNXMjR0OIE+yUGImBdwvS0UuiHQSjyZN11N2S6CpQhdfC3uF0FslrdPAFe/fiW0NTLGs7R0NwsgAXQbsbYhnkYE8viYQoPwYCXd0/bFvoKJy8o72cIF2HfTFVXyHPsVfGpwWr5Zd5NLFAA8P7Qw6HR+t+hX49xx/fuF8upCSLOjTqp4IkW5po+U2nApzZY2p7vfh4bR33Zc4NZ8cYSUoK9FG9KM+FjJ1ddiyfPBDlxyBzkaHvyuuFryXSH7XXiw9ze/FPdC8hwZCDEkDVXQoX5NN6aS30Xl7fSS8Hmn/fD7DYk/yS37Qn7PUap2WvHV8sMET1CMvxvIYYoqPMnYG5+q8lnmvqhWDYOb7qJFBOHpKpV08jOeDoS16nvqlNtnHFXis+prfHMOJ0eMgg50H+UOakKi09TdA+R50GEFx4pFEGneVp0L48X3djTLTq5RMARu318qJ8SUGegf2TzjCMb8auIcOwU2AYhvGvsc+AYTyXafoAw79M3xUfbDgAAAAASUVORK5CYII="/></td>
            <td class="info_text"><img alt="상태" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGqSURBVGhD7ZcJEoMgDEU5HgfyON7Fq3gSacLSxhhcaXWm/81kUIQQ8llaBwAAAAAAAAAAzJimKQydD/0YQq4CdxDGPngq+HFm3fAWaOx9oNeZUFYdQ52Cp075NSLbkrfQ+y4Msaz7l/B37XMLjoOLYu/xeb6+p9Hn4w2dmLs26kzl/WwJQoVpLQUJ1LJzJEjsY7fR6KQXHzxWTZAasb0QhE+S/Pg9UpKWCb17h3C9c0mIlNSl2BYlBpm8MkZNkEftEA5mnrCUKBmkTlhKlghamCUIFcLWBSntix9+l8/ym4VO+p4d8qj7sy6InTCNTJiF7J/8F0E+Il3xb7F6h+Q66fNRgqQkfYIvgVqC6ImuWelTF6SN/xppZ6QjL1edu9SVj9uRCTtzqR0R5CpyByyNxq0IwsS+FEh+vX/X1Cajj4uU1GW7Yro9J5wKYfsEMVetSNgZ4hx/IMjlX2PW9i7IO2YLPnL2nPdJ1LogXGf5qdVrdsfR8Ihsyr8Kwvzkv8UZ4palgh+l7Z0Y00oQ5sqRtb7y7YUHDvLYlQzAYbCaT4LEAQAAAAA0w7kXXFXOFdRX2pgAAAAASUVORK5CYII="/></td>
            <td class="info_text last_col"><img alt="담당" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEVSURBVGhD7djhrcIgFIZhxmMgxmEWu0on6ZHTllIQqii5uZr3SQhIkR/nC9hoAAAAAADAfzV7K24S2T+a5ebEhAkdy5TGy7Ica5TMXuz+LBKZxVsnYbtjXsInFzodpmbFz9uayaXxtyprc9Z61vxOGcg5hPM4mlxZ3K3pHs1ArA9P0tw5hF8IZCgNJHR5uwgkWk9IUWgCGeDpCQmdtmzNWvg0n19LBPKR3ivrCGlNYg9iLzgnZICeK2sL4LGAuofVyVYgcd+jEchQ9SLHlgfyDIFUtN6c1lZcWVdqJ0S15hWBdKj9hqjeE3IVCDpcB/J6gQlkkPdOSP6KrLZA6mu16QtB6AHgFd1/gOGtmlFPAACAv2PMHbHZFz3YWlUdAAAAAElFTkSuQmCC"/></td>
        </tr>
    </tbody>
    */

    
    // 집하예정
    $content_array          =   explode("<td class=\"info_label text_col last_col\" colspan=\"5\" style=\"color:gray;\">집하예정</td>", $content_temp);

    $content_array_count    =   count($content_array);          


    // 3.배송추적현황 - 1) 집하예정일 경우
    // <td class="info_label text_col last_col" colspan="5" style="color:gray;">집하예정</td>    
    if ($content_array_count > 1) {
        $text_temp = "조회하신 운송장번호는 쿠팡로켓배송 집하예정입니다.";
        
        $result_deliverytracking .= "
            <tr>
                <td class=\"text-center\" colspan=\"5\">" . $text_temp . "</td>
            </tr>
        ";     
    }
    // 3.배송추적현황 - 2) 집하예정이 아니고 데이터가 있을 경우
    else {
        $content_array  =   explode("<tbody id=\"traceinfo\">", $content_temp);
        $content_array2 =   explode("</tbody>", $content_array[1]);
        
        $content_array3 =   explode("<tr class=\"info_row", $content_array2[0]);
        
        $content_array3_count   =   count($content_array3);
        
        for ($i = 1; $i < $content_array3_count; $i++) {
            // echo "<br />" . $content_array3[$i];
            
            $text_temp = array();       // 텍스트 데이터 저장할 배열 변수 초기화
            
            $content_array4 =   explode("<td class=\"info_text", $content_array3[$i]);   
                         
            /*                     
            echo "<br /><br /><br />";
            echo "<xmp>";        
            echo $content_array4[0];
            echo "</xmp>";
            */
            /*
            <th class=\"text-center\">처리일시</th>
            <th class=\"text-center\">처리점</th>
            <th class=\"text-center\">전화번호</th>
            <th class=\"text-center\">상태</th>                            
            <th class=\"text-center\">담당</th> 
            */
            
            // (1) 처리일시
            $content_array5 =   explode("</td>", $content_array4[1]);           // 1
            $content_array6 =   explode("<img alt=", $content_array5[0]);
            $content_array6 =   explode("<img alt=", $content_array5[0]);

            $text_temp[1]   =   "<img alt=" . $content_array6[1];

            // (2) 처리점
            $content_array5 =   explode("</td>", $content_array4[2]);           // 2
            $content_array6 =   explode("<img alt=", $content_array5[0]);
            $content_array6 =   explode("<img alt=", $content_array5[0]);

            $text_temp[2]   =   "<img alt=" . $content_array6[1];

            // (3) 전화번호
            $content_array5 =   explode("</td>", $content_array4[3]);           // 3
            $content_array6 =   explode("<img alt=", $content_array5[0]);
            $content_array6 =   explode("<img alt=", $content_array5[0]);

            $text_temp[3]   =   "<img alt=" . $content_array6[1];

            // (4) 상태
            $content_array5 =   explode("</td>", $content_array4[4]);           // 4
            $content_array6 =   explode("<img alt=", $content_array5[0]);
            $content_array6 =   explode("<img alt=", $content_array5[0]);

            $text_temp[4]   =   "<img alt=" . $content_array6[1];

            // (5) 상태
            $content_array5 =   explode("</td>", $content_array4[5]);           // 5
            $content_array6 =   explode("<img alt=", $content_array5[0]);
            $content_array6 =   explode("<img alt=", $content_array5[0]);

            $text_temp[5]   =   "<img alt=" . $content_array6[1];
            
            $result_deliverytracking .= "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                </tr>
            ";            
        }
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