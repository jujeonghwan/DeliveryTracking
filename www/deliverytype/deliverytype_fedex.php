<?php

////////////////////////////////////////////////////////////////////////////////
// FedEx(국제)

// 배송조회결과 구함 (FedEx(국제))
function get_result_deliverytracking_fedex($content_temp) {    


    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // JS String Decoding
    // 예) \uBC30\uC1A1 \uC644\uB8CC\u003a => 배송 완료
    // $content_temp = json_decode(sprintf('"%s"', $content_temp));



    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    // 예외조회 결과
    

    
    // 조회결과
    $result_deliverytracking  =   "";
    
    // result_error
    $content_array          =   explode("\uBCF4\uB958 \uC911", $content_temp);  // 보류 중
    $content_array_count    =   count($content_array);          
    
    // 보류 중
    
    if ($content_array_count > 1) {
        $text_temp = "이 배송 조회 번호를 찾을 수 없습니다. 번호를 확인하거나 발송인에게 문의하십시오. ";
        
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
       "TrackPackagesResponse":{  
          "successful":true,
          "passedLoggedInCheck":false,
          "errorList":[  
             {  
                "code":"0",
                "message":"Request was successfully processed.",
                "source":null,
                "rootCause":null
             }
          ],
          "packageList":[  
             {  
                "trackingNbr":"654288762203",
                "trackingQualifier":"2457518000\u007e654288762203\u007eFX",
                "trackingCarrierCd":"FDXE",
                "trackingCarrierDesc":"FedEx Express",
                "displayTrackingNbr":"654288762203",
                "shipperCmpnyName":"",
                "shipperName":"",
                "shipperAddr1":"",
                "shipperAddr2":"",
                "shipperCity":"KAWARAYAMACHI,CHUO\u002dKU,OSAKA",
                "shipperStateCD":"",
                "shipperZip":"",
                "shipperCntryCD":"JP",
                "shipperPhoneNbr":"",
                "shippedBy":"",
                "recipientCmpnyName":"",
                "recipientName":"",
                "recipientAddr1":"",
                "recipientAddr2":"",
                "recipientCity":"SEOUL",
                "recipientStateCD":"",
                "recipientZip":"",
                "recipientCntryCD":"KR",
                "recipientPhoneNbr":"",
                "shippedTo":"",
                "keyStatus":"\uBC30\uC1A1 \uC644\uB8CC",
                "keyStatusCD":"DL",
                "lastScanStatus":"",
                "lastScanDateTime":"",
                "receivedByNm":"S.ONGYOUNGKWON",
                "subStatus":"\uC11C\uBA85\uC790\u003a S.ONGYOUNGKWON",
                "mainStatus":"",
                "statusBarCD":"DL",
                "shortStatus":"",
                "shortStatusCD":"",
                "statusLocationAddr1":"",
                "statusLocationAddr2":"",
                "statusLocationCity":"SEOUL",
                "statusLocationStateCD":"",
                "statusLocationZip":"",
                "statusLocationCntryCD":"KR",
                "statusWithDetails":"\uBC30\uC1A1 \uC644\uB8CC\u003a 11\u002f05\u002f2016 14\u003a49 \uC11C\uBA85\uC790\u003aS.ONGYOUNGKWON\u003b SEOUL,KR",
                "shipDt":"2016\u002d05\u002d09T00\u003a00\u003a00\u002d06\u003a00",
                "displayShipDt":"09\u002f05\u002f2016",
                "displayShipTm":"",
                "displayShipDateTime":"09\u002f05\u002f2016",
                "pickupDt":"2016\u002d05\u002d09T16\u003a09\u003a00\u002b09\u003a00",
                "displayPickupDt":"09\u002f05\u002f2016",
                "displayPickupTm":"16\u003a09",
                "displayPickupDateTime":"09\u002f05\u002f2016 16\u003a09",
                "estDeliveryDt":"",
                "estDeliveryTm":"",
                "displayEstDeliveryDt":"",
                "displayEstDeliveryTm":"",
                "displayEstDeliveryDateTime":"",
                "actDeliveryDt":"2016\u002d05\u002d11T14\u003a49\u003a00\u002b09\u003a00",
                "displayActDeliveryDt":"11\u002f05\u002f2016",
                "displayActDeliveryTm":"14\u003a49",
                "displayActDeliveryDateTime":"11\u002f05\u002f2016 14\u003a49",
                "tenderedDt":"2016\u002d05\u002d09T16\u003a09\u003a00\u002b09\u003a00",
                "displayTenderedDt":"09\u002f05\u002f2016",
                "displayTenderedTm":"16\u003a09",
                "displayTenderedDateTime":"09\u002f05\u002f2016 16\u003a09",
                "apptDeliveryDt":"",
                "displayApptDeliveryDt":"",
                "displayApptDeliveryTm":"",
                "displayApptDeliveryDateTime":"",
                "nickName":"",
                "note":"",
                "matchedAccountList":[  
                   ""
                ],
                "fxfAdvanceETA":"",
                "fxfAdvanceReason":"",
                "fxfAdvanceStatusCode":"",
                "fxfAdvanceStatusDesc":"",
                "destLink":"",
                "originLink":"",
                "hasBillOfLadingImage":false,
                "hasBillPresentment":false,
                "signatureRequired":0,
                "totalKgsWgt":"1.3",
                "displayTotalKgsWgt":"1.3 \uD0AC\uB85C\uADF8\uB7A8",
                "totalLbsWgt":"2.87",
                "displayTotalLbsWgt":"2.87 \uD30C\uC6B4\uB4DC",
                "displayTotalWgt":"2.87 \uD30C\uC6B4\uB4DC \u002f 1.3 \uD0AC\uB85C\uADF8\uB7A8",
                "pkgKgsWgt":"1.3",
                "displayPkgKgsWgt":"1.3 \uD0AC\uB85C\uADF8\uB7A8",
                "pkgLbsWgt":"2.87",
                "displayPkgLbsWgt":"2.87 \uD30C\uC6B4\uB4DC",
                "displayPkgWgt":"2.87 \uD30C\uC6B4\uB4DC \u002f 1.3 \uD0AC\uB85C\uADF8\uB7A8",
                "totalDIMLbsWgt":"",
                "displayTotalDIMLbsWgt":"",
                "totalDIMKgsWgt":"",
                "displayTotalDIMKgsWgt":"",
                "displayTotalDIMWgt":"",
                "dimensions":"18x15x6 \uC778\uCE58",
                "masterTrackingNbr":"",
                "masterQualifier":"",
                "masterCarrierCD":"",
                "originalOutboundTrackingNbr":null,
                "originalOutboundQualifier":"",
                "originalOutboundCarrierCD":"",
                "invoiceNbrList":[  
                   "101"
                ],
                "referenceList":[  
                   ""
                ],
                "doorTagNbrList":[  
                   ""
                ],
                "referenceDescList":[  
                   ""
                ],
                "purchaseOrderNbrList":[  
                   ""
                ],
                "billofLadingNbrList":[  
                   ""
                ],
                "shipperRefList":[  
                   "101"
                ],
                "rmaList":[  
                   ""
                ],
                "deptNbrList":[  
                   ""
                ],
                "shipmentIdList":[  
                   ""
                ],
                "tcnList":[  
                   ""
                ],
                "partnerCarrierNbrList":[  
                   ""
                ],
                "hasAssociatedShipments":false,
                "hasAssociatedReturnShipments":false,
                "assocShpGrp":0,
                "drTgGrp":[  
                   "0"
                ],
                "associationInfoList":[  
                   {  
                      "trackingNumberInfo":{  
                         "trackingNumber":"",
                         "trackingQualifier":"",
                         "trackingCarrier":"",
                         "processingParameters":null
                      },
                      "associatedType":""
                   },
                   {  
                      "trackingNumberInfo":{  
                         "trackingNumber":"",
                         "trackingQualifier":"",
                         "trackingCarrier":"",
                         "processingParameters":null
                      },
                      "associatedType":""
                   }
                ],
                "returnReason":"",
                "returnRelationship":null,
                "skuItemUpcCdList":[  
                   ""
                ],
                "receiveQtyList":[  
                   ""
                ],
                "itemDescList":[  
                   ""
                ],
                "partNbrList":[  
                   ""
                ],
                "serviceCD":"INTERNATIONAL\u005fECONOMY",
                "serviceDesc":"FedEx International Economy",
                "serviceShortDesc":"IE",
                "packageType":"YOUR\u005fPACKAGING",
                "packaging":"Your Packaging",
                "clearanceDetailLink":"",
                "showClearanceDetailLink":false,
                "manufactureCountryCDList":[  
                   null
                ],
                "commodityCDList":[  
                   ""
                ],
                "commodityDescList":[  
                   ""
                ],
                "cerNbrList":[  
                   ""
                ],
                "cerComplaintCDList":[  
                   ""
                ],
                "cerComplaintDescList":[  
                   ""
                ],
                "cerEventDateList":[  
                   ""
                ],
                "displayCerEventDateList":[  
                   ""
                ],
                "totalPieces":"1",
                "specialHandlingServicesList":[  
                   "\uC8FC\uC911 \uBC30\uB2EC",
                   "\uAC70\uC8FC\uC9C0 \uBC30\uB2EC"
                ],
                "shipmentType":"",
                "pkgContentDesc1":"",
                "pkgContentDesc2":"",
                "docAWBNbr":"",
                "originalCharges":"",
                "transportationCD":"",
                "transportationDesc":"",
                "dutiesAndTaxesCD":"",
                "dutiesAndTaxesDesc":"",
                "origPieceCount":"",
                "destPieceCount":"",
                "billNoteMsg":"",
                "goodsClassificationCD":"",
                "receipientAddrQty":"0",
                "deliveryAttempt":"0",
                "codReturnTrackNbr":"",
                "returnMovementStatus":null,
                "scanEventList":[  
                   {  
                      "date":"2016\u002d05\u002d11",
                      "time":"14\u003a49\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uBC30\uB2EC \uC644\uB8CC",
                      "statusCD":"DL",
                      "scanLocation":"SEOUL KR",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":true
                   },
                   {  
                      "date":"2016\u002d05\u002d11",
                      "time":"13\u003a30\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uBC30\uB2EC\uC744 \uC704\uD574 FedEx \uC6B4\uC1A1 \uC218\uB2E8\uC5D0 \uC801\uC7AC\uB428",
                      "statusCD":"OD",
                      "scanLocation":"SEONGNAM\u002dSI KR",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d11",
                      "time":"13\u003a20\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"FedEx \uC0AC\uBB34\uC18C\uC5D0 \uC788\uC74C",
                      "statusCD":"AR",
                      "scanLocation":"SEONGNAM\u002dSI KR",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d11",
                      "time":"09\u003a56\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uC6B4\uC1A1 \uC911",
                      "statusCD":"IT",
                      "scanLocation":"SEONGNAM\u002dSI KR",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d11",
                      "time":"09\u003a00\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uAD6D\uC81C \uBC1C\uC1A1\uBB3C \uBC30\uB2EC \u002d \uC218\uC785",
                      "statusCD":"CC",
                      "scanLocation":"INCHEON\u002dSI JUNG\u002dGU KR",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d11",
                      "time":"08\u003a57\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uC6B4\uC1A1 \uC911",
                      "statusCD":"IT",
                      "scanLocation":"INCHEON\u002dSI JUNG\u002dGU KR",
                      "scanDetails":"\uD654\uBB3C \uD1B5\uAD00 \uAC00\uB2A5",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d10",
                      "time":"19\u003a50\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uB3C4\uCC29\uC9C0 \uBD84\uB958 \uC2DC\uC124\uC5D0 \uC788\uC74C",
                      "statusCD":"AR",
                      "scanLocation":"INCHEON\u002dSI JUNG\u002dGU KR",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d10",
                      "time":"17\u003a12\u003a00",
                      "gmtOffset":"\u002b08\u003a00",
                      "status":"\uC6B4\uC1A1 \uC911",
                      "statusCD":"IT",
                      "scanLocation":"BEIJING CN",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d10",
                      "time":"13\u003a08\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uC6B4\uC1A1 \uC911",
                      "statusCD":"IT",
                      "scanLocation":"SENNAN\u002dSHI JP",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d10",
                      "time":"03\u003a28\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uC6B4\uC1A1 \uC911",
                      "statusCD":"IT",
                      "scanLocation":"SENNAN\u002dSHI JP",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d09",
                      "time":"17\u003a41\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"FedEx \uC0AC\uBB34\uC18C \uCD9C\uBC1C ",
                      "statusCD":"DP",
                      "scanLocation":"OSAKA\u002dSHI SUMINOE\u002dKU JP",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d09",
                      "time":"02\u003a34\u003a34",
                      "gmtOffset":"\u002d05\u003a00",
                      "status":"FedEx\uB85C \uC804\uC1A1\uB41C \uBC1C\uC1A1 \uC815\uBCF4",
                      "statusCD":"OC",
                      "scanLocation":"",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   },
                   {  
                      "date":"2016\u002d05\u002d09",
                      "time":"16\u003a09\u003a00",
                      "gmtOffset":"\u002b09\u003a00",
                      "status":"\uD53D\uC5C5 \uC644\uB8CC",
                      "statusCD":"PU",
                      "scanLocation":"OSAKA\u002dSHI SUMINOE\u002dKU JP",
                      "scanDetails":"",
                      "scanDetailsHtml":"",
                      "rtrnShprTrkNbr":"",
                      "isException":false,
                      "isDelException":false,
                      "isClearanceDelay":false,
                      "isDelivered":false
                   }
                ],
                "originAddr1":"",
                "originAddr2":"",
                "originCity":"OSAKA\u002dSHI SUMINOE\u002dKU",
                "originStateCD":"",
                "originZip":"",
                "originCntryCD":"JP",
                "originLocationID":"",
                "originTermCity":"OSAKA\u002dSHI SUMINOE\u002dKU",
                "originTermStateCD":"",
                "destLocationAddr1":"",
                "destLocationAddr2":"",
                "destLocationCity":"SEONGNAM\u002dSI",
                "destLocationStateCD":"",
                "destLocationZip":"",
                "destLocationCntryCD":"KR",
                "destLocationID":"",
                "destLocationTermCity":"SEONGNAM\u002dSI",
                "destLocationTermStateCD":"",
                "destAddr1":"",
                "destAddr2":"",
                "destCity":"SEOUL",
                "destStateCD":"",
                "destZip":"",
                "destCntryCD":"KR",
                "halAddr1":"",
                "halAddr2":"",
                "halCity":"",
                "halStateCD":"",
                "halZipCD":"",
                "halCntryCD":"",
                "actualDelAddrCity":"SEOUL",
                "actualDelAddrStateCD":"",
                "actualDelAddrZipCD":"",
                "actualDelAddrCntryCD":"KR",
                "totalTransitMiles":"",
                "excepReasonList":[  
                   ""
                ],
                "excepActionList":[  
                   ""
                ],
                "exceptionReason":"",
                "exceptionAction":"",
                "statusDetailsList":[  
                   ""
                ],
                "trackErrCD":"",
                "destTZ":"\u002b09\u003a00",
                "originTZ":"\u002b09\u003a00",
                "isMultiStat":"0",
                "multiStatList":[  
                   {  
                      "multiPiec":"",
                      "multiTm":"",
                      "multiDispTm":"",
                      "multiSta":""
                   }
                ],
                "maskMessage":"",
                "deliveryService":"",
                "milestoDestination":"",
                "terms":"\uBC1C\uC1A1\uC778",
                "payorAcctNbr":"",
                "meterNumber":"",
                "originUbanizationCode":"",
                "originCountryName":"",
                "isOriginResidential":false,
                "halUrbanizationCD":"",
                "halCountryName":"",
                "actualDelAddrUrbanizationCD":"",
                "actualDelAddrCountryName":"",
                "destUrbanizationCD":"",
                "destCountryName":"",
                "delToDesc":"\uAC70\uC8FC\uC9C0",
                "recpShareID":"",
                "shprShareID":"",
                "requestedAppointmentInfoList":[  
                   {  
                      "spclInstructDesc":"",
                      "delivOptn":"",
                      "delivOptnStatus":"",
                      "reqApptWdw":"",
                      "reqApptDesc":"",
                      "rerouteTRKNbr":"",
                      "beginTm":"",
                      "endTm":""
                   }
                ],
                "defaultCDOType":"RTH",
                "returnAuthorizationName":"",
                "totalCustomsValueAmount":"",
                "totalCustomsValueCurrency":"",
                "packageInsuredValueAmount":"",
                "packageInsuredValueCurrency":"",
                "estDelTimeWindow":{  
                   "estDelTmWindowStart":"",
                   "estDelTmWindowEnd":"",
                   "displayEstDelTmWindowTmStart":"",
                   "displayEstDelTmWindowTmEnd":""
                },
                "serviceCommitMessage":"",
                "matched":false,
                "fxfAdvanceNotice":true,
                "codrequired":false,
                "mpstype":"",
                "rthavailableCD":"",
                "excepReasonListNoInit":[  
                   ""
                ],
                "excepActionListNoInit":[  
                   ""
                ],
                "statusDetailsListNoInit":[  
                   ""
                ],
                "isSuccessful":true,
                "isException":false,
                "isCanceled":false,
                "isDuplicate":false,
                "errorList":[  
                   {  
                      "code":"",
                      "message":"",
                      "source":null,
                      "rootCause":null
                   }
                ],
                "isInvalid":false,
                "isInTransit":false,
                "isOnSchedule":false,
                "isDelException":false,
                "isHAL":false,
                "isInProgress":true,
                "isShipPickupDtLabel":true,
                "isEstimatedDeliveryDtLabel":false,
                "isPrePickup":false,
                "isAnticipatedShipDtLabel":false,
                "isPickup":false,
                "isActualPickupLabel":false,
                "isClearanceDelay":false,
                "isDelivered":true,
                "isActualDeliveryDtLabel":true,
                "isDeliveryDtLabel":false,
                "isPending":false,
                "isExpiring":false,
                "isExpired":false,
                "isShipmentException":false,
                "isInFedExPossession":false,
                "isOrderReceivedLabel":false,
                "isOrderCompleteLabel":false,
                "isDeliveryToday":false,
                "isBeforePossessionStatus":false,
                "isTenderedDtLabel":false,
                "isWatch":false,
                "isHistorical":false,
                "isTenderedNotification":false,
                "isDeliveredNotification":true,
                "isExceptionNotification":false,
                "isCurrentStatusNotification":false,
                "isFSM":false,
                "isOutboundDirection":false,
                "isInboundDirection":false,
                "isThirdpartyDirection":false,
                "isUnknownDirection":false,
                "isFreight":false,
                "isSpod":true,
                "isSignatureAvailable":true,
                "isSignatureThumbnailAvailable":false,
                "isDocumentAvailable":false,
                "isMPS":false,
                "isGMPS":false,
                "isOriginalOutBound":false,
                "isReturn":false,
                "isDestResidential":true,
                "isHalEligible":false,
                "isSave":false,
                "isMtchdByRecShrID":false,
                "isMtchdByShiprShrID":false,
                "CDOExists":false,
                "isCDOEligible":false,
                "isReqEstDelDt":false,
                "CDOInfoList":[  
                   {  
                      "spclInstructDesc":"",
                      "delivOptn":"",
                      "delivOptnStatus":"",
                      "reqApptWdw":"",
                      "reqApptDesc":"",
                      "rerouteTRKNbr":"",
                      "beginTm":"",
                      "endTm":""
                   }
                ],
                "isEstDelTmWindowLabel":false,
                "isEstimatedDeliveryDateChangeNotification":false,
                "isShipDtLabel":false,
                "isChildPackage":false,
                "isParentPackage":false,
                "isReclassifiedAsSingleShipment":false,
                "isMaskShipper":false,
                "isFedexOfficeOnlineOrders":false,
                "isFedexOfficeInStoreOrders":false,
                "isMultipleStop":false,
                "isHALResidential":false,
                "isActualDelAddrResidential":false,
                "isNotFound":false,
                "isCustomCritical":false,
                "isResidential":false
             }
          ]
       }
    }
    */
    
    // 조회결과
    $result_deliverytracking  =   "";
    
    ////////////////////////////////////////////////////////////////////////////////
    // 1.배송정보
    
    $text_temp = array();               // 텍스트 데이터 저장할 배열 변수 초기화

    // (1) 배송 조회 번호 (Tracking Number)
    $content_array  =   explode("\"trackingNbr\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[1]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />trackingNbr : " . $text_temp[1]; exit;

    // (2) 운송 회사 (Tracking Carrier)
    $content_array  =   explode("\"trackingCarrierDesc\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[2]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />trackingCarrierDesc : " . $text_temp[2]; exit;

    // (3) 발송 도시 (Shipper City)
    $content_array  =   explode("\"shipperCity\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[3]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />shipperCity : " . $text_temp[3]; exit;

    // (4) 수취 도시 (Recipient City)
    $content_array  =   explode("\"recipientCity\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[4]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />recipientCity : " . $text_temp[4]; exit;

    // (5) 수취인 (Recipient City)
    $content_array  =   explode("\"receivedByNm\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[5]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />receivedByNm : " . $text_temp[5]; exit;

    // (6) 발송 날짜 (Ship Dt)
    $content_array  =   explode("\"shipDt\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[6]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />shipDt : " . $text_temp[6]; exit;

    // (7) 픽업 날짜 (Pickup Dt)
    $content_array  =   explode("\"pickupDt\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[7]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />pickupDt : " . $text_temp[7]; exit;

    // (8) 수취 날짜 (Act Delivery Dt)
    $content_array  =   explode("\"actDeliveryDt\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[8]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />actDeliveryDt : " . $text_temp[8]; exit;

    // (9) 무게 (Display Total Kgs Wgt)
    $content_array  =   explode("\"displayTotalKgsWgt\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[9]  =   json_string_decode(trim($content_array2[0]));
    // echo "<br />displayTotalKgsWgt : " . $text_temp[9]; exit;

    // (10) 치수 (Dimensions)
    $content_array  =   explode("\"dimensions\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[10]  =   json_string_decode(trim($content_array2[0]));
    // echo "<br />dimensions : " . $text_temp[10]; exit;

    // (11) 발송인 참조번호 (Shipper Ref List)
    $content_array  =   explode("\"shipperRefList\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[11]  =   json_string_decode(trim($content_array2[0]));
    // echo "<br />shipperRefList : " . $text_temp[11]; exit;

    // (12) 서비스 (Service Desc)
    $content_array  =   explode("\"serviceDesc\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[12]  =   json_string_decode(trim($content_array2[0]));
    // echo "<br />serviceDesc : " . $text_temp[12]; exit;

    // (13) 총 개수 (Total Pieces)
    $content_array  =   explode("\"totalPieces\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[13]  =   json_string_decode(trim($content_array2[0]));
    // echo "<br />totalPieces : " . $text_temp[13]; exit;

    // (14) 특별 취급 섹션 (Special Handling Services List)
    $content_array  =   explode("\"specialHandlingServicesList\":[", $content_temp);    
    $content_array2 =   explode("]", $content_array[1]);
    $content_array2[0] = str_replace("\"", "", $content_array2[0]);             // '"' 쌍따옴표 제거
    $text_temp[14]  =   json_string_decode(trim($content_array2[0]));
    // echo "<br />specialHandlingServicesList : " . $text_temp[14]; exit;

    // (15) 배송 상태 (Status With Details)
    $content_array  =   explode("\"statusWithDetails\":\"", $content_temp);    
    $content_array2 =   explode("\"", $content_array[1]);
    $text_temp[15]   =   json_string_decode(trim($content_array2[0]));
    // echo "<br />statusWithDetails : " . $text_temp[15]; exit;

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
                    <th class=\"active text-center\">배송 조회 번호 (Tracking Number)</th>
                    <td class=\"text-center\">" . $text_temp[1] . "</td>
                    <th class=\"active text-center\">운송 회사 (Tracking Carrier)</th>
                    <td class=\"text-center\">" . $text_temp[2] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">발송 도시 (Shipper City)</th>
                    <td class=\"text-center\">" . $text_temp[3] . "</td>
                    <th class=\"active text-center\">수취 도시 (Recipient City)</th>
                    <td class=\"text-center\">" . $text_temp[4] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">수취인 (Recipient City)</th>
                    <td class=\"text-center\">" . $text_temp[5] . "</td>
                    <th class=\"active text-center\">발송 날짜 (Ship Dt)</th>
                    <td class=\"text-center\">" . $text_temp[6] . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">픽업 날짜 (Pickup Dt)</th>
                    <td class=\"text-center\">" . $text_temp[7] . "</td>                         
                    <th class=\"active text-center\">수취 날짜 (Act Delivery Dt)</th>
                    <td class=\"text-center\">" . $text_temp[8] . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">무게 (Display Total Kgs Wgt)</th>
                    <td class=\"text-center\">" . $text_temp[9] . "</td>                         
                    <th class=\"active text-center\">치수 (Dimensions)</th>
                    <td class=\"text-center\">" . $text_temp[10] . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">발송인 참조번호 (Shipper Ref List)</th>
                    <td class=\"text-center\">" . $text_temp[11] . "</td>                         
                    <th class=\"active text-center\">서비스 (Service Desc)</th>
                    <td class=\"text-center\">" . $text_temp[12] . "</td>
                </tr>
                <tr>
                    <th class=\"active text-center\">총 개수 (Total Pieces)</th>
                    <td class=\"text-center\">" . $text_temp[13] . "</td>                         
                    <th class=\"active text-center\">특별 취급 섹션 (Special Handling Services List)</th>
                    <td class=\"text-center\">" . $text_temp[14] . "</td>                         
                </tr>
                <tr>
                    <th class=\"active text-center\">배송 상태 (Status With Details)</th>
                    <td class=\"text-center\" colspan=\"3\">" . $text_temp[15] . "</td>                         
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
                <col width=\"50%\" />
                <col width=\"30%\" />
            </colgroup>                        
            <thead>
                <tr class=\"active\">
                    <th class=\"text-center\" colspan=\"3\">운송 내역</th>          
                </tr>
                <tr class=\"active\">
                    <th class=\"text-center\">날짜/시간</th>
                    <th class=\"text-center\">작업</th>
                    <th class=\"text-center\">위치</th>
                </tr>
            </thead>
            <tbody>
    ";
        
    // 날짜/시간, 작업, 위치
    $content_array  =   explode("\"scanEventList\":[", $content_temp);
    $content_array2 =   explode("]", $content_array[1]);
    
    $content_array3 =   explode("{", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    // for ($i = 1; $i < $content_array3_count; $i++) {
    for ($i = ($content_array3_count - 1); $i >= 1; $i--) {
        // echo "<br />" . $content_array3[$i];
        
        $text_temp = array();           // 텍스트 데이터 저장할 배열 변수 초기화
        
        // (1) 날짜
        $content_array4 =   explode("\"date\":\"", $content_array3[$i]);
        $content_array5 =   explode("\"", $content_array4[1]);
        $text_temp[1]   =   json_string_decode(trim($content_array5[0]));       // 1
        // echo "<br />date : " . $text_temp[1]; exit;

        // (2) 시간
        $content_array4 =   explode("\"time\":\"", $content_array3[$i]);
        $content_array5 =   explode("\"", $content_array4[1]);
        $text_temp[2]   =   json_string_decode(trim($content_array5[0]));       // 2
        
        // (3) 작업
        $content_array4 =   explode("\"status\":\"", $content_array3[$i]);
        $content_array5 =   explode("\"", $content_array4[1]);
        $text_temp[3]   =   json_string_decode(trim($content_array5[0]));       // 3

        // (4) 위치
        $content_array4 =   explode("\"scanLocation\":\"", $content_array3[$i]);
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
    
    /*
    echo "<xmp>";
    echo $result_deliverytracking;
    echo "</xmp>";
    */
    
    return $result_deliverytracking;
}

?>