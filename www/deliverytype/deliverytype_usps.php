<?php

////////////////////////////////////////////////////////////////////////////////
// USPS(국제)

// 배송조회결과 구함 (USPS(국제))
function get_result_deliverytracking_usps($content_temp) {    


    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    
    // {}
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("<table class=\"tracking_history\">", $content_temp);               // 데이터 없을 경우
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
        <h3>Tracking Number: <span class="tracking-number"> 9400109699937749073286</span></h3>

        <!-- start status bar logic -->
        
        <div class="tracking-graphic-column shipped">
          <div class="track-bar-holder">
          <div class="track-status-bar">
            <div class="status-rectangle">
            </div>
            <div class="status-rectangle">
            </div>
            <div class="status-rectangle">
            </div>
          </div>
          <div class="tracking-checkmark">
          </div>
          </div>
          <span class="delivery-status-text status-green">Delivered</span>
        </div>
        
        <!-- end status bar logic -->

        <!-- START pdd, edd, gdd, etc. -->
        
        
        <p class="delivery-status-update updated_day">
          <strong>Updated Delivery Day:  </strong>Monday, July 17, 2017
          <a role="button" href="#" class="hint">
          <i class="icon-tooltip"></i>
          <span class="speech_bubble">
            Updated Delivery Day is the latest information on when the Postal Service&trade; expects to deliver your package.
          </span>
          </a>
        </p>
        <!-- END pdd, edd, gdd, etc. -->
        
        
        <div class="product_additional_information">
            <div class="product_tracking_header">
              <h2>Product &amp; Tracking Information</h2>
              <a href="#" class="avail_actions">See Available Actions</a>
              <table class="product_info">
                <tr style="vertical-align:top;">
                  <td class="postalproduct"><strong>Postal Product:</strong> First-Class Package Service</td>
                  <td class="postalfeatures"><strong>Features:</strong>                        
                            
                                USPS Tracking<SUP>&#174;</SUP><br />
                            
                  </td>
                  <td><strong>&nbsp;</strong> </td>
                </tr>
                <tr>
                  <td></td>
                  
                </tr>
              </table>
            </div>
            <div class="product_tracking_header_mobile mobileOnly">
              <p>Your item was delivered to an individual at the address at 10:59 am on July 17, 2017 in LITTLE FERRY, NJ 07643.</p>
            </div>
            <div class="product_tracking_details">
              <div class="tracking_history_container">
                               
                <h3 class="mobileOnly">Tracking History</h3>
                <table class="tracking_history">
                    <thead>
                        <tr>
                            <th>Date &amp; Time</th>
                            <th>Status of Item</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row_top">
                            <td>
                                July 17, 2017,
                                10:59 am
                            </td>
                            <td>
                                Delivered, Left with Individual
                            </td>
                            <td>
                                LITTLE FERRY,&nbsp;NJ&nbsp;07643&nbsp;
                            </td>
                        </tr>
                        <tr class="row_notification">
                            <td colspan="3">
                                <span class="callout">
                                    Your item was delivered to an individual at the address at 10:59 am on July 17, 2017 in LITTLE FERRY, NJ 07643.
                                </span>
                            </td>
                        </tr>
                        
                            <tr>
                                <td>
                                    July 17, 2017,
                                    9:45 am
                                </td>
                                <td>
                                    Arrived at Post Office 
                                </td>
                                <td>
                                    LITTLE FERRY,&nbsp;NJ&nbsp;07643&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 17, 2017,
                                    9:22 am
                                </td>
                                <td>
                                    Out for Delivery 
                                </td>
                                <td>
                                    LITTLE FERRY,&nbsp;NJ&nbsp;07643&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 17, 2017,
                                    9:12 am
                                </td>
                                <td>
                                    Sorting Complete 
                                </td>
                                <td>
                                    LITTLE FERRY,&nbsp;NJ&nbsp;07643&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 17, 2017,
                                    3:23 am
                                </td>
                                <td>
                                    Departed USPS Regional Facility 
                                </td>
                                <td>
                                    TETERBORO NJ DISTRIBUTION CENTER&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 16, 2017,
                                    10:20 pm
                                </td>
                                <td>
                                    Arrived at USPS Regional Destination Facility 
                                </td>
                                <td>
                                    TETERBORO NJ DISTRIBUTION CENTER&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 15, 2017,
                                    9:59 pm
                                </td>
                                <td>
                                    Arrived at USPS Regional Origin Facility 
                                </td>
                                <td>
                                    CINCINNATI OH NETWORK DISTRIBUTION CENTER&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 15, 2017,
                                    3:42 pm
                                </td>
                                <td>
                                    Departed Post Office 
                                </td>
                                <td>
                                    MIAMISBURG,&nbsp;OH&nbsp;45342&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 15, 2017,
                                    12:30 pm
                                </td>
                                <td>
                                    USPS in possession of item 
                                </td>
                                <td>
                                    MIAMISBURG,&nbsp;OH&nbsp;45342&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 15, 2017,
                                    2:58 am
                                </td>
                                <td>
                                    Shipping Label Created, USPS Awaiting Item 
                                </td>
                                <td>
                                    VANDALIA,&nbsp;OH&nbsp;45377&nbsp;
                                </td>
                            </tr>
                        
                            <tr>
                                <td>
                                    July 14, 2017
                                    
                                </td>
                                <td>
                                    Pre-Shipment Info Sent to USPS, USPS Awaiting Item 
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        
                    </tbody>
                </table>
    */
    
    // 조회결과
    $result_deliverytracking  =   "";

    ////////////////////////////////////////////////////////////////////////////////
    // 1.배송정보

    // (1) 운송장 번호 (Tracking Number)
    $content_array  =   explode("<h3>Tracking Number: <span class=\"tracking-number\">", $content_temp);
    $content_array2 =   explode("</span></h3>", $content_array[1]);

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
    // 2.운송 내역 (DATE & TIME, STATUS OF ITEM, LOCATION)
    
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
                    <th class=\"text-center\">현지 일시 (Date & Time)</th>
                    <th class=\"text-center\">상태 (Status of Item)</th>
                    <th class=\"text-center\">위치 (Location)</th>
                </tr>
            </thead>
            <tbody>
    ";
        
    // Date & Time, Status of Item, Location
    $content_array  =   explode("<table class=\"tracking_history\">", $content_temp);
    $content_array2 =   explode("</tbody>", $content_array[1]);    
    $content_array3 =   explode("<tbody>", $content_array2[0]);
    $content_array4 =   explode("<tr", $content_array3[1]);
    
    $content_array4_count   =   count($content_array4);
    
    // for ($i = 1; $i < $content_array4_count; $i++) {
    for ($i = ($content_array4_count - 1); $i >= 1; $i--) {
        // echo "<br /><xmp>" . $content_array4[$i] . "</xmp>"; exit;
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        // (1) 현지 일시 (Date & Time) 
        $content_array5 =   explode("</td>", $content_array4[$i]);
        $content_array6 =   explode("<td>", $content_array5[0]);

        // html중 text 데이터만 구함                            
        $text_temp[1] = get_html_to_text_data($content_array6[1]);
        // echo "<br />" . $text_temp[1]; exit;


        // (2) 상태 (Status of Item)
        $content_array5 =   explode("</td>", $content_array4[$i]);
        $content_array6 =   explode("<td>", $content_array5[1]);

        // html중 text 데이터만 구함                            
        $text_temp[2] = get_html_to_text_data($content_array6[1]);
        // echo "<br />" . $text_temp[2]; exit;


        // (3) 위치 (Location) 
        $content_array5 =   explode("</td>", $content_array4[$i]);
        $content_array6 =   explode("<td>", $content_array5[2]);

        // html중 text 데이터만 구함                            
        $text_temp[3] = get_html_to_text_data($content_array6[1]);
        // echo "<br />" . $text_temp[3]; exit;
        

        // 현재 일시 데이터가 있는 항목만 표시
        if (trim($text_temp[1]) != "") {
            $result_deliverytracking .= "
                <tr>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
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