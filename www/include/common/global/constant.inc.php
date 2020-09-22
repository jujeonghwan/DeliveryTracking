<?php

////////////////////////////////////////////////////////////////////////////////////////////////////
// 사이트 설정

$SITE_VAR["host"] = "deliverytracking.kr";
$SITE_VAR["domain"] = "www.deliverytracking.kr";

$SITE_VAR["domain2_main"] = "www.deliverytracking.kr";      // 추가 도메인 (유지할 도메인)
$SITE_VAR["domain2_etc"] = "deliverytracking.kr";           // 추가 도메인 (변경할 도메인)

$SITE_VAR["url"] = "http://www.deliverytracking.kr/";
$SITE_VAR["title"] = "[딜리버리트래킹] www.DeliveryTracking.kr (국내국제 택배사 통합배송조회)";                     
$SITE_VAR["keywords"] = "택배배송조회 딜리버리트래킹 DeliveryTracking" . $SITE_VAR["title"];                 
$SITE_VAR["description"] = "택배배송조회 딜리버리트래킹 DeliveryTracking" . $SITE_VAR["title"];                 
$SITE_VAR["name"] = "딜리버리트래킹";
$SITE_VAR["logofile"] = "DeliveryTracking.png";             // 로고파일
$SITE_VAR["logotitle"] = "[딜리버리트래킹] 국내국제 택배사 통합배송조회";                     

$SITE_VAR["president"] = "주정환";
$SITE_VAR["tel"] = "070-8863-4373";
$SITE_VAR["fax"] = "070-8863-4373";
$SITE_VAR["mobile"] = "+1-226-792-4376";
$SITE_VAR["email"] = "jujeonghwan@gmail.com";
$SITE_VAR["address"] = "(28551) 충청북도 청주시 서원구 호국로150번길 21, 2층 (사직동)";
$SITE_VAR["bankaccount"] = "KEB하나은행 373-910281-24407 주정환(더블유에스티)";
$SITE_VAR["nateon"] = "jujh@nate.com";
$SITE_VAR["init_date"] = "20150401";
$SITE_VAR["copyright_begin_year"] = "2009";

$SITE_VAR["image_domain"] = "www.deliverytracking.kr";


// 저장할 기간
$SITE_VAR["common_file_init_date"] = 10;                    // 공통 파일 조회시작기간

$SITE_VAR["cookie_file_save_date"] = 2;                     // 쿠키 파일 저장할 기간
$SITE_VAR["deliverytracking_file_save_date"] = 2;           // 택배사배송조회 수집파일 저장할 기간
$SITE_VAR["deliverytracking_db_save_date"] = 20;            // 택배사배송조회 DB 저장할 기간

// $SITE_VAR["deliverytracking_db_save_count"] = 10000;     // 택배사배송조회 DB 저장할 항목수
$SITE_VAR["deliverytracking_db_save_count"] = 100000;       // 택배사배송조회 DB 저장할 항목수
$SITE_VAR["multisearch_db_save_count"] = 10000;             // 다중검색 DB 저장할 항목수


// PAGE
$PAGE_VAR["page_count"] =   20;
$PAGE_VAR["list_count"] =   20;

$LIST_COUNT_ARRAY = array (
    "20개"   =>  "20",
    "50개"   =>  "50",
    "100개"  =>  "100",
    "200개"  =>  "200",
    "500개"  =>  "500",
    "1000개" =>  "1000"
);


// 디버깅 관련
$DEBUG_MODE = false;


// 접속 차단할 IP주소
$BLOCK_IP_ADDRESS_ARRAY = array (
    // "121.130.82.6",
    "-"
);



////////////////////////////////////////////////////////////////////////////////////////////////////
// 공통 설정

////////////////////////////////////////////////////////////////////////////////

// 택배사구분 (알파벳순)
$COMMON_DELIVERYTYPE_ARRAY = array (
    // "쿠팡로켓배송" => "coupang",                               // 쿠팡배송조회 변경됨
    "CU편의점택배" => "cupost",
    "CU편의점PICK-UP" => "cupostpickup",    
    "대운글로벌(국제)" => "daewoonsys",
    "DHL(국제)" => "dhl",
    "CJ대한통운" => "doortodoor",
    "CJ대한통운NPlus" => "doortodoornplus",
    "대신택배" => "ds3211",
    "EMS국제우편(국제)" => "ems",
    "우체국택배" => "epost",
    "FedEx(국제)" => "fedex",
    "GTX로지스" => "gtxlogis",
    "한진택배" => "hanjin",
    "합동택배" => "hdexp",
    // "현대택배" => "hlc",
    // "현대로지스틱스국제특송(국제)" => "hyundaiexp",
    // "드림택배" => "idreamlogis",
    "로젠택배" => "ilogen",    
    "일양로지스" => "ilyanglogis",    
    // "KGB택배" => "kgbls",
    "KGB택배" => "kgbps",    
    // "KG로지스" => "kglogis",
    "대한통운국제특송(해외->한국)" => "korexinbound",
    // "대한통운국제특송(한국->해외)" => "korexoutbound",
    "롯데택배" => "lotteglogis",
    "롯데글로벌로지스(국제)" => "lotteglogis_i",   // international
    "매일택배(캐나다->한국)" => "mailexglobal",
    "PHLPOST필리핀국제우편(국제)" => "phlpost",
    "포스트박스편의점택배(GS25)" => "postbox",
    "포스트박스편의점PICK-UP(GS25)" => "postboxpickup",
    "TNT(국제)" => "tnt",
    // "UPS(국제)" => "ups",
    "USPS(국제)" => "usps",
    "YES24총알배송(당일/하루배송)" => "yes24",
    "YANWEN(국제)" => "yw56"
);


// Key(택배사명)으로 정렬해서사용
ksort($COMMON_DELIVERYTYPE_ARRAY);

// Value(택배사코드)으로 정렬해서사용
// asort($COMMON_DELIVERYTYPE_ARRAY);

////////////////////////////////////////////////////////////////////////////////

// 택배사 배송조회 URL (알파벳순)
$COMMON_DELIVERYURL_ARRAY = array (
    // "coupang"        =>  "http://b2c.goodsflow.com/small/Coupang/whereis_sheetno.asp?trans_cd=coupangls&sheet_no={invoice_no}",                              // 예) http://b2c.goodsflow.com/small/Coupang/whereis_sheetno.asp?trans_cd=coupangls&sheet_no=10160717475893
    // "coupang"        =>  "http://b2c.goodsflow.com/small/Coupang/Whereis.aspx?logistics_code=coupangls&invoice_no={invoice_no}",                             // 예) http://b2c.goodsflow.com/small/Coupang/Whereis.aspx?logistics_code=coupangls&invoice_no=10160717475893
    // "coupang"        =>  "http://b2c.goodsflow.com/small/Coupang/TrackingList/Old2.aspx?{query_string}",                                                     // 예) http://b2c.goodsflow.com/small/Coupang/TrackingList/Old2.aspx?item_unique_code=&member_code=coupang&member_name=%25ec%25bf%25a0%25ed%258c%25a1&is_mobile=N&root_path=http%253a%252f%252fb2c.goodsflow.com%253a80%252fsmall%252fCoupang&top_bar_visible=Y&data_type=xml&tracking_data=goodsFLOWWherisEnc%2524%2524sCvWye...
    "cupost"            =>  "http://www.doortodoor.co.kr/jsp/cmn/TrackingCVS.jsp?pTdNo={invoice_no}",                                                           // 예) http://www.doortodoor.co.kr/jsp/cmn/TrackingCVS.jsp?pTdNo=6028269284
    "cupostpickup"      =>  "https://www.cupost.co.kr/postbox/delivery/pickupDetail.cupost?invoice_no={invoice_no}&newpickup_yn=N",                             // 예) https://www.cupost.co.kr/postbox/delivery/pickupDetail.cupost?invoice_no=798-103-2942&newpickup_yn=N&store_code=15208
    "daewoonsys"        =>  "http://www.daewoonsys.com/common/tracking.asp?shipping_no={invoice_no}&loading_no={invoice_no2}",                                  // 예) http://www.daewoonsys.com/common/tracking.asp?shipping_no=6074985060697&loading_no=PBNJ1601290061
    // "dhl"            =>  "http://www.dhl.co.kr/shipmentTracking?AWB={invoice_no}&countryCode=kr&languageCode=ko",                                            // 예) http://www.dhl.co.kr/shipmentTracking?AWB=2416844566&countryCode=kr&languageCode=ko
    "dhl"               =>  "http://www.dhl.co.kr/shipmentTracking?AWB={invoice_no}&countryCode=kr&languageCode=ko&_=1465978355293",
    // "doortodoor"     =>  "https://www.doortodoor.co.kr/main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no={invoice_no}",            // 예) https://www.doortodoor.co.kr/main/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=690052355203
    "doortodoor"        =>  "https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT2&invc_no={invoice_no}",         // 예) https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT2&invc_no=341619825572
    "doortodoornplus"   =>  "http://nplus.doortodoor.co.kr/web/detail.jsp?slipno={invoice_no}",
    "ds3211"            =>  "http://www.ds3211.co.kr/freight/internalFreightSearch.ht?billno={invoice_no}",                                                     // 예) http://www.ds3211.co.kr/freight/internalFreightSearch.ht?billno=2523601008141
    // "ems"            =>  "http://service.epost.go.kr/trace.RetrieveEmsRigiTraceList.comm?POST_CODE={invoice_no}&displayHeader=&x=75&y=32",                   // 예) http://service.epost.go.kr/trace.RetrieveEmsRigiTraceList.comm?POST_CODE=RI851019379CN&displayHeader=&x=75&y=32
    "ems"               =>  "https://service.epost.go.kr/trace.RetrieveEmsRigiTraceList.comm?POST_CODE={invoice_no}&displayHeader=",

    "epost"             =>  "https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?sid1={invoice_no}&displayHeader=",                                 // 예) https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?sid1=6899082239087&displayHeader=N
    // "fedex"          =>  "https://www.fedex.com/apps/fedextrack/?action=track&tracknumbers={invoice_no}&locale=ko_KR&cntry_code=kr",                         // 예) https://www.fedex.com/apps/fedextrack/?action=track&tracknumbers=654288762203&locale=ko_KR&cntry_code=kr
    // "fedex"          =>  'https://www.fedex.com/trackingCal/track?data={"TrackPackagesRequest":{"appType":"WTRK","uniqueKey":"","processingParameters":{},"trackingInfoList":[{"trackNumberInfo":{"trackingNumber":"{invoice_no}","trackingQualifier":"","trackingCarrier":""}}]}}&action=trackpackages&locale=ko_KR&version=1&format=json',
    
    // "fedex"             =>  "https://www.fedex.com/trackingCal/track?data=%7B%22TrackPackagesRequest%22%3A%7B%22appType%22%3A%22WTRK%22%2C%22uniqueKey%22%3A%22%22%2C%22processingParameters%22%3A%7B%7D%2C%22trackingInfoList%22%3A%5B%7B%22trackNumberInfo%22%3A%7B%22trackingNumber%22%3A%22{invoice_no}%22%2C%22trackingQualifier%22%3A%22%22%2C%22trackingCarrier%22%3A%22%22%7D%7D%5D%7D%7D&action=trackpackages&locale=ko_KR&version=1&format=json",
    "fedex"             =>  "http://www.fedex.com/trackingCal/track?data=%7B%22TrackPackagesRequest%22%3A%7B%22appType%22%3A%22WTRK%22%2C%22appDeviceType%22%3A%22DESKTOP%22%2C%22supportHTML%22%3Atrue%2C%22supportCurrentLocation%22%3Atrue%2C%22uniqueKey%22%3A%22%22%2C%22processingParameters%22%3A%7B%7D%2C%22trackingInfoList%22%3A%5B%7B%22trackNumberInfo%22%3A%7B%22trackingNumber%22%3A%22{invoice_no}%22%2C%22trackingQualifier%22%3A%22%22%2C%22trackingCarrier%22%3A%22%22%7D%7D%5D%7D%7D&action=trackpackages&locale=ko_KR&version=1&format=json",

    "gtxlogis"          =>  "http://www.gtxlogis.co.kr/tracking/default.asp?awblno={invoice_no}",                                                               // 예) http://www.gtxlogis.co.kr/tracking/default.asp?awblno=605030759163
    "hanjin"            =>  "http://www.hanjin.co.kr/Delivery_html/inquiry/result_waybill.jsp?wbl_num={invoice_no}",                                            // 예) http://www.hanjin.co.kr/Delivery_html/inquiry/result_waybill.jsp?wbl_num=406535669400
    // "hdexp"          =>  "http://www.hdexp.co.kr/parcel/order_result_t.asp?p_item={invoice_no}",                                                             // 예) http://www.hdexp.co.kr/parcel/order_result_t.asp?p_item=20924162010510
    // "hdexp"          =>  "http://www.hdexp.co.kr/deliverySearch.hd?company_gubun=H&search_month={search_month}&barcode={invoice_no}",                        // 예) http://www.hdexp.co.kr/deliverySearch.hd?company_gubun=H&search_month=201604&barcode=209016103305
    // "hdexp"             =>  "http://hdexp.co.kr/deliverySearch2.hd?barcode={invoice_no}",                                                                       // 예) https://www.hdexp.co.kr/deliverySearch2.hd?barcode=3301024100229
    "hdexp"             =>  "https://hdexp.co.kr/deliverySearch2.hd?barcode={invoice_no}",

    // "hlc"            =>  "https://www.hlc.co.kr/home/personal/inquiry/track?action=processInvoiceLinkSubmit",                                                // 기존기능(개인용)    
    // "hyundaiexp"     =>  "http://global.e-hlc.com/servlet/Tracking_View_DLV_ALL?DvlInvNo={invoice_no}",                                                      // 예) http://global.e-hlc.com/servlet/Tracking_View_DLV_ALL?DvlInvNo=6064836798562
    "idreamlogis"       =>  "http://www.idreamlogis.com/delivery/delivery_result.jsp?item_no={invoice_no}",                                                     // 예) http://www.idreamlogis.com/delivery/delivery_result.jsp?item_no=305105638165
    "ilogen"            =>  "https://www.ilogen.com/iLOGEN.Web.New/TRACE/TraceDetail.aspx?slipno={invoice_no}&gubun=fromview",
    "ilyanglogis"       =>  "http://www.ilyanglogis.com/functionality/popup_result.asp?hawb_no={invoice_no}",                                                   // 예) https://www.ilyanglogis.com/functionality/popup_result.asp?hawb_no=1901431641
    // "kgbls"          =>  "http://www.kgbls.co.kr/sub/trace.asp?f_slipno={invoice_no}&x=30&y=26",                                                             // 예) https://www.kgbls.co.kr/sub/trace.asp?f_slipno=71501092823&x=30&y=26
    "kgbps"             =>  "https://www.kgbps.com/delivery/delivery_result.jsp?item_no={invoice_no}",                                                          // 예) https://www.kgbps.com/delivery/delivery_result.jsp?item_no=360014967200
    // // "kglogis"     =>  "http://www.kglogis.co.kr/delivery/delivery_result.jsp?item_no={invoice_no}",                                                       // 예) http://www.kglogis.co.kr/delivery/delivery_result.jsp?item_no=304348927584
    "korexinbound"      =>  "http://ex.korex.co.kr:7004/fis20/KIL_HttpCallExpTrackingInbound_Ctr.do?rqs_HAWB_NO={invoice_no}",                                  // 예) http://ex.korex.co.kr:7004/fis20/KIL_HttpCallExpTrackingInbound_Ctr.do?rqs_HAWB_NO=422102056493
    "lotteglogis"       =>  "https://www.lotteglogis.com/home/personal/inquiry/track?action=processInvoiceLinkSubmit",
    "lotteglogis_i"     =>  "https://www.lotteglogis.com/home/reservation/global/track_ajax?inv_no={invoice_no}",
    // "mailexglobal"   =>  "http://www.mailexglobal.com/en/cs-detail.html?formselect1={invoice_no}&searen_val={invoice_no2}",                                  // http://www.mailexglobal.com/en/cs-detail.html?formselect1=2011&searen_val=3008615
    "mailexglobal"      =>  "http://system.swgexp.com/common/tracking_order.asp?order_no={invoice_no}",                                                         // http://system.swgexp.com/common/tracking_order.asp?order_no=20123008615
    "phlpost"           =>  "http://tnt.phlpost.gov.ph/index/?ctl09=UpdatePanel1%7CLinkButton1&__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=99KyByogGzuIH7aVTSTP3byyVqSzj0vu9UujOezBL9M2YZfl3gztW8%2BEMdlTB4Sg6ikgw1xAUPrRXLoWJiR%2FXPWiLREkLcFhT2rlWjWhAx%2B%2FfxysaEE9XDmet23fbveIXidzkvbblCca%2B1WyEqGS3xe2UuAgY1TI1JT1NS%2BeheJWOkGC%2Fu7i%2BJZBRu2y37fEJFdGnwf%2Bx2FFjEil3z3NX1tiJqNZEw0%2BYPopVjQm1D4ABHdDTkANdMP1iJoXX1C2CrNKq0qzaTXLpVSG8wHbog%3D%3D&__EVENTVALIDATION=RP%2BAZ092M6JT3%2FJjYgsZE57o5%2BUm0HnVLaE7QpMG5Q9cvlQHo1NJEQbpiN7E%2BgBDs2M1g7Bm5OKexniGQs6LkUgqVpfKmZrmW7mVqJzLUyw1kM6K3%2F00%2Fukj5yb6yZrvnHu3ePTxR8QCpBRcbJscHQ%3D%3D&url={invoice_no}&__ASYNCPOST=true&LinkButton1=Track%20this%20item",
    "postbox"           =>  "http://www.doortodoor.co.kr/jsp/cmn/TrackingCVS.jsp?pTdNo={invoice_no}",                                                           // 예) http://www.doortodoor.co.kr/jsp/cmn/TrackingCVS.jsp?pTdNo=6028269284
    "postboxpickup"     =>  "http://www.doortodoor.co.kr/jsp/cmn/TrackingCVS.jsp?pTdNo={invoice_no}",                                                           // 예) http://www.doortodoor.co.kr/jsp/cmn/TrackingCVS.jsp?pTdNo=7006753014
    // "ups"            =>  "https://wwwapps.ups.com/WebTracking/detail?loc={loc}&USER_HISTORY_LIST={USER_HISTORY_LIST}&progressIsLoaded={progressIsLoaded}&refresh_sii={refresh_sii}&showSpPkgProg1={showSpPkgProg1}&datakey={datakey}&HIDDEN_FIELD_SESSION={HIDDEN_FIELD_SESSION}&descValue{invoice_no}={descValue}        loc=ko_KR&USER_HISTORY_LIST=&progressIsLoaded=N&refresh_sii=&showSpPkgProg1=true&datakey=line1&HIDDEN_FIELD_SESSION={hidden_field_session}&descValue{invoice_no}=&trackNums={invoice_no}&trackNums={trackNums}",
    // "ups"            =>  "https://wwwapps.ups.com/WebTracking/detail?{query_string}",                                                                        // 예) https://wwwapps.ups.com/WebTracking/track?loc=ko_KR&USER_HISTORY_LIST=&progressIsLoaded=N&refresh_sii=&showSpPkgProg1=true&datakey=line1&HIDDEN_FIELD_SESSION=FxVyU8XoQd5iAi%2FEOX0BU9LryKS7knzmWF3OHjPGFdSu44UcVfFDT3Nrkq0S5PErUxYkX8IUPkEDEAxsipsliHUv%2Bs3Y2OrPHAWJcLQCRQ5vJH79g05so6Cz7DzmoY6TqzysP%2FNMXs5vlAQSijf6GUS7gh5cy1bhThKquGrSLONXSv7PD8OtFGbcP%2Bcg7VDNh2SFBtBZ72OkBcmNPYIDwuXl4iD8OS6hBlLYx36aSAUPWgREgDr6PXkTRq12Yjby8a%2FYeQuRPsXpWqfhwFTxzsiWimVzuwpyhgXIg2rLbfR68w0CHbF5m8EJq6xfJRh5K628iZiTcwZf29usJwpm2sLrjQ2QqCa%2B4a0OK6IthJiIBfSpj3%2BAKlJH89r%2FaLm7eVf6%2FC4wN4NO98qnaTaI%2BAwDV%2FTdNU5bHy3fNwgIjbYvaztxK0Dpt4%2BG0I2PrsrTchrSzbXqWpqP2YwXOTb1aebhPbdWgNeO4q%2FTPEVPlc84f5I5qTabXX8twyZZjcAl1mVh%2FGqLm8EUPOhHa%2Fj5lE0iTfltqiAy0LAgR0QhBFLd7tMOi2Y22T1085nZmkidALjhzWIcq2%2FLz48dI2%2BJGRokG4U8IRzwA79g5oGpT%2BrODMb92cQmqk4QoyreG8UO6%2BXmx3pYQT9Im2nlLGkrrEvm84og1DGletTj7wu41ZtS7cJuLohTTTBj13whfpusfQNrnm7y7lQiuk285jHQKH1UkHQxCPPby2IIidOXJb8hG0sqs4KZ9MMQEW8Z65XNbcXaCsWu%2BTKqFLruCPbriLeluWZu0ltCmXAubX1K5p9UgWGR%2B53GFim7HjhNX%2Fma6oPEPpE5S23XlgHM4lB9jz2biP9S4%2FPq%2BoCUuJEOPOLcmm8m9RL63XjY%2BnF%2FSacwiVcVzSPJ7VNRdtTLwKwqXezPMamgM07r0sQMy7m4zgH6fQ7nltbnBzS9fLKok07ay6eepWO0%2BEZd6vZ92qHKfq7ldfOdBXCz8BG5cidQ6n8Q4z9RZvY7H0OY7UY4U%2Fgq%2F0qxz2QQDjYhEPm8Ek%2FUCQ2Tk9Es0mzh%2FT5zXdnv9YeEUc7FDHlNAJyBqvoxbEkV2Ecsu6Wg2r3fDuuNbtlch2bFwrKRgBysAUp2E05fOrx11RXcfcxUXru27ryXkIwsy0kABWzXVeisZ7EVNIHcAmBH8eoMOT5%2Bo08Vv5XIPMb3Q1%2BHknO5g%2B1lS9k%2BJ%2FYYvoAA31%2F5jekUCPDZfVtaOa3473dErqCp%2F4OY1Bsd4oO%2ByrrjNp7wz%2BKbhJJLY9825H5yZTS1hGsn93sQXeRWsOG3ym2c4yyjZRwtyvVSSLNbAuPuHBlHxsOPdhooP%2B5ltOPtdGExUd2FU6vyRAYoAsVuUqhxK8ZUnhu1ua2V%2B1XqUTPJb8WpJ4GcXlGs94a4H%2FUSNCU2tQQoVX8A5VQK9Pe7xfu56dUB38k6PFk0f6JXFOQ10Huxwt97que7rr3VCoDtaIcPlYPSA%2FQcHeMtS5oKL95pq%2BLGU1Y%2BTHGa1Wt5LkS%2Feq8bOT%2BEjI9KUe6XdZL1pYxmNRBrRQb5wRhrbfTPdHOiWfar7%2BH%2FGj6sfexdeGxwLkOvWYm71wY1%2BWlVITjk1QowAzQstpPtplV6I%2Fam7Ih8z7bxCTnEwUeI3wam5yNcHF841L9%2FuD1FIsR9k0NF6sPCv%2B8d5h2%2BAo5VGiXjsRislDF8g5sKrmMaCs5ZwuLvdk8SvR3imghN9HyByiO10b1Eg73WC%2FmP3DHNk3sinFP2CcUJHsoBxpN4zP9fuoaRyuu34ZWfhlBWTJUCsZeBbu2KqIAkx4kimcCp40GpkHN4%2F8Lsk1RPDSGyNhjey0zqNmXoU0xJ1V5oE%2FEgk1e1jMMTy9yrBFflo3CltokLvU8MMw%2FIDkJBD56t%2FFOgYKj1VCjxMKm%2FRpcO81ihTnLDr5XeYz9xG38%2F0eqhD0L624Vv8oP0mcQ0kJfD%2FENf2JXC91SUPSVvMeld4MfTugAWXvNCHxyo%2Bvo%2F2%2F3e3UxsLoDws674RK%2BGnUzwYFQRAeruH5DvRmP7gssV5y2eIEwnw%2BKWtaFJxURI1l6%2BgYySmW69Ub8Qhhm10tG2De3Ky1O0s00QaOash3vfmpP8hR46qS%2BLqO9GDW5HdG2y5Ie3XYqPC%2F27aC1c4fmE1werdnLpXp8YHrxB6cH%2F7gIYTs3VHbiWaHbJ1oh8N3wAq2Jqy7bBJU8%2BXJgUv2Q7%2Fhhfc1OgI2iiDnduR8JEuWB%2BzAYva5YE7RoNflAAAnVsYgMr8E4ZJsMraMqvGf0St2pKRIUuPpSbR6xt0XJfx3NMG0S4FYPiyEM4cBmmFPvga4pq8yb%2BWaruY03%2F9673WieIhV8sw3uwcSZwTmrw7xoM0IgqRkhd9IYzUmUKBam1QAZncHr9Ord7GaCEP0fvXTmz7IuLVCi2Kv2DmqwXXM9E3Bxh3DCDe2LFQf2qDFfzjZoKdFIUDZAV1YmCY7l1FYkdqjIr71cr%2BB1MIfqvShN2y5OTQ6OsUhh5Uut54dcyLEu5aWTt6NaGFGgvN%2FP%2Bug0dNi4K5qMlYUFCjVFS5fRfQZYsyofMt9xG4yV6Bp3YMQ%3D%3DA1c84e5747&descValue1Z1041AV0325295726=&trackNums=1Z1041AV0325295726
    // "ups"            =>  "https://wwwapps.ups.com/WebTracking/track?HTMLVersion=5.0&loc=ko_KR&Requester=UPSHome&WBPM_lid=homepage%2Fct1.html_pnl_trk&trackNums={invoice_no}&track.x=%EC%A1%B0%ED%9A%8C", // 예) https://wwwapps.ups.com/WebTracking/track?HTMLVersion=5.0&loc=ko_KR&Requester=UPSHome&WBPM_lid=homepage%2Fct1.html_pnl_trk&trackNums=1Z1041AV0325295726&track.x=%EC%A1%B0%ED%9A%8C
    // "ups"            =>  "https://www.ups.com/track/api/Track/GetStatus?loc=ko_KR",
    "ups"               =>  "https://www.ups.com/track?loc=en_CA&tracknum={invoice_no}&requester=WT/trackdetails",

    "usps"              =>  "https://tools.usps.com/go/TrackConfirmAction?tLabels={invoice_no}",                                                                // 예)https://tools.usps.com/go/TrackConfirmAction?tLabels=UJ102299537US
    // "tnt"            =>  "http://www.tnt.com/express/ko_kr/site/home/applications/tracking.html?cons={invoice_no}&searchType=CON",                           // 예) http://www.tnt.com/express/ko_kr/site/home/applications/tracking.html?cons=118637702&searchType=CON
    // "tnt"            =>  "http://www.tnt.com/track-api/track?con={invoice_no}&locale=ko_KR&searchType=CON",  
    "tnt"               =>  "https://www.tnt.com/api/v1/shipment?con={invoice_no}&locale=ko_KR&searchType=CON",                                                 // 예) https://www.tnt.com/api/v1/shipment?con=303144038&locale=ko_KR&searchType=CON
    "yes24"             =>  "http://www.ddlogis.com/tracking/yes24/default.asp?awblno={invoice_no}",                                                            // 예) http://www.ddlogis.com/tracking/yes24/default.asp?awblno=790002248825
    "yw56"              =>  "http://track.yw56.com.cn/en-US/?InputTrackNumbers={invoice_no}"                                                                    // 예) http://track.yw56.com.cn/en-US/?InputTrackNumbers=11224016969
);

// 택배사 배송조회 선처리 URL (알파벳순)
$COMMON_DELIVERYURL_PRE_ARRAY = array (
    // "coupang"    =>  "http://b2c.goodsflow.com/small/Coupang/Whereis.aspx?logistics_code=coupangls&invoice_no={invoice_no}",                                 // 예) http://b2c.goodsflow.com/small/Coupang/Whereis.aspx?logistics_code=coupangls&invoice_no=10160717475893
    "cupost"        =>  "https://www.cupost.co.kr/postbox/delivery/localResult.cupost?invoice_no={invoice_no}",
    "cupostpickup"  =>  "https://www.cupost.co.kr/postbox/delivery/pickupResultNew.cupost?search_type_temp=02&invoice_no={invoice_no}&search_type=02",
    "fedex"         =>  "https://www.fedex.com/apps/fedextrack/index.html?tracknumbers={invoice_no}&cntry_code=kr",
    // "hdexp"         =>  "https://hdexp.co.kr/delivery_search.hd",
    "hdexp"         =>  "http://hdexp.co.kr/basic_delivery.hd?barcode={invoice_no}",
    // "hlc"        =>  "https://www.hlc.co.kr/home/personal/inquiry/track?InvNo={invoice_no}&action=processInvoiceSubmit",
    // "hyundaiexp"    =>  "https://www.hlc.co.kr/home/personal/inquiry/track?InvNo={invoice_no}&action=processInvoiceSubmit",
    "lotteglogis"   =>  "https://www.lotteglogis.com/home/personal/inquiry/track?InvNo={invoice_no}&action=processInvoiceSubmit",   
    "lotteglogis_i" =>  "https://www.lotteglogis.com/home/reservation/global/track?InvNo={invoice_no}&action=processInvoiceSubmit",   
    "phlpost"       =>  "http://tnt.phlpost.gov.ph/index/",
    "postbox"       =>  "http://www.cvsnet.co.kr/postbox/m_delivery/local/local.jsp?click_ck=Y&invoice_no={invoice_no}",
    "postboxpickup" =>  "http://www.cvsnet.co.kr/postbox/m_delivery/pickup/pickup.jsp?search_type=02&invoice_no={invoice_no}",                                  // 예) http://www.cvsnet.co.kr/postbox/m_delivery/pickup/pickup.jsp?search_type=02&invoice_no=7006753014
    "tnt"           =>  "http://www.tnt.com/track-api/track?con={invoice_no}&locale=ko_KR&searchType=CON" 
); 

// 택배사 배송조회 HTTP Method (알파벳순)
$COMMON_DELIVERYMETHOD_ARRAY = array (
    "cupost"            =>  "POST",
    "cupostpickup"      =>  "POST",
    "postbox"           =>  "GET",
    "daewoonsys"        =>  "GET",
    "dhl"               =>  "GET",
    "doortodoor"        =>  "GET",
    "doortodoornplus"   =>  "GET",
    "ds3211"            =>  "GET",
    "ems"               =>  "POST",
    "epost"             =>  "POST",
    "fedex"             =>  "GET",
    "gtxlogis"          =>  "GET",
    "hanjin"            =>  "POST",
    "hdexp"             =>  "POST",
    // "hlc"            =>  "POST",
    // "hyundaiexp"        =>  "POST",
    "idreamlogis"       =>  "POST",
    "ilogen"            =>  "GET",
    "ilyanglogis"       =>  "GET",
    // "kgbls"          =>  "POST",
    "kgbps"             =>  "POST",
    // "kglogis"        =>  "GET",
    "korexinbound"      =>  "GET",
    "lotteglogis"       =>  "POST",
    "lotteglogis_i"     =>  "POST",
    "mailexglobal"      =>  "GET",
    "phlpost"           =>  "POST",
    "postbox"           =>  "GET",
    "postboxpickup"     =>  "GET",
    "ups"               =>  "GET",
    "usps"              =>  "GET",
    "tnt"               =>  "GET",
    "yes24"             =>  "GET",
    "yw56"              =>  "POST"
);

// 택배사 LINK (알파벳순)
$COMMON_DELIVERYLINK_ARRAY = array (
    // "coupang"        =>  "https://my.coupang.com/purchase/listByDelivery?eventCategory=GNB&eventLabel=mycoupang_3",
    "cupost"            =>  "https://www.cupost.co.kr/postbox/delivery/local.cupost",
    "cupostpickup"      =>  "https://www.cupost.co.kr/postbox/delivery/pickupNew.cupost",
    "daewoonsys"        =>  "http://www.daewoonglobal.com/",
    "dhl"               =>  "http://www.dhl.co.kr/ko/express/tracking.html",
    "doortodoor"        =>  "https://www.doortodoor.co.kr/parcel/pa_004.jsp",
    "doortodoornplus"   =>  "https://www.doortodoor.co.kr/parcel/pa_004.jsp",
    "ds3211"            =>  "https://www.ds3211.co.kr/",
    "ems"               =>  "https://service.epost.go.kr/iservice/usr/trace/usrtrc004k01.jsp",
    "epost"             =>  "https://service.epost.go.kr/iservice/usr/trace/usrtrc001k01.jsp",
    "fedex"             =>  "https://www.fedex.com/apps/fedextrack/?cntry_code=kr",
    "gtxlogis"          =>  "http://home.gtxlogis.co.kr/",
    "hanjin"            =>  "http://www.hanjin.co.kr/Delivery_html/inquiry/personal_inquiry.jsp",
    // "hdexp"          =>  "http://www.hdexp.co.kr/parcel/order_status.asp",
    "hdexp"             =>  "https://www.hdexp.co.kr/",
    // "hlc"            =>  "https://www.hlc.co.kr/home/personal/inquiry/track",
    // "hyundaiexp"     =>  "http://www.hyundaiexp.com/",
    "idreamlogis"       =>  "http://www.idreamlogis.com/",
    "ilogen"            =>  "http://www.ilogen.com/d2d/delivery/invoice_search.jsp",
    "ilyanglogis"       =>  "http://www.ilyanglogis.com/functionality/tracking.asp",
    // "kgbls"          =>  "https://www.kgbls.co.kr/",
    "kgbps"             =>  "https://www.kgbps.com/",
    // "kglogis"        =>  "http://www.kglogis.co.kr/delivery/waybill.jsp",
    "korexinbound"      =>  "https://www.doortodoor.co.kr/international/in_003.jsp",
    "lotteglogis"       =>  "https://www.lotteglogis.com/home/personal/inquiry/track",
    "lotteglogis_i"     =>  "https://www.lotteglogis.com/home/reservation/global/track",
    "mailexglobal"      =>  "http://www.mailexglobal.com/cs1.html",
    "phlpost"           =>  "http://tnt.phlpost.gov.ph/index/",
    "postbox"           =>  "http://www.cvsnet.co.kr/postbox/m_delivery/local/local.jsp",
    "postboxpickup"     =>  "http://www.cvsnet.co.kr/postbox/m_delivery/pickup/pickup.jsp",
    "ups"               =>  "https://www.ups.com/track?loc=ko_KR&requester=WT/",
    "usps"              =>  "https://tools.usps.com/go/TrackConfirmAction_input",
    "tnt"               =>  "http://www.tnt.com/express/ko_kr/site/home/applications/tracking.html",
    // "yes24"          =>  "http://www.yes24.com/",
    "yes24"             =>  "http://click.linkprice.com/click.php?m=yes24&l=0004&a=A100532968&l_cd1=6",
    "yw56"              =>  "http://track.yw56.com.cn/en-US"
);

// 택배사 로고이미지 (알파벳순)
$COMMON_DELIVERYIMAGE_ARRAY = array (
    // "coupang"        =>  "coupang.png",
    "cupost"            =>  "cupost.png",
    "cupostpickup"      =>  "cupostpickup.png",
    "daewoonsys"        =>  "daewoonsys.gif",
    "dhl"               =>  "dhl.gif",
    "doortodoor"        =>  "doortodoor.gif",
    "doortodoornplus"   =>  "doortodoornplus.gif",
    "ds3211"            =>  "ds3211.gif",
    "ems"               =>  "ems.gif",
    "epost"             =>  "epost.gif",
    "fedex"             =>  "fedex.png",
    "gtxlogis"          =>  "gtxlogis.gif",
    "hanjin"            =>  "hanjin.png",
    // "hdexp"          =>  "hdexp.png",
    "hdexp"             =>  "hdexp.jpg",
    // "hlc"            =>  "hlc.gif",
    // "hyundaiexp"     =>  "hyundaiexp.gif",
    "idreamlogis"       =>  "idreamlogis.gif",
    "ilogen"            =>  "ilogen.jpg",
    "ilyanglogis"       =>  "ilyanglogis.png",
    // "kgbls"          =>  "kgbls.png",
    "kgbps"             =>  "kgbps.jpg",
    // "kglogis"        =>  "kglogis.gif",    
    "korexinbound"      =>  "korexinbound.jpg",
    "lotteglogis"       =>  "lotteglogis.gif",
    "lotteglogis_i"     =>  "lotteglogis_i.jpg",
    "mailexglobal"      =>  "mailexglobal.jpg",
    "phlpost"           =>  "phlpost.jpg",
    "postbox"           =>  "postbox.gif",
    "postboxpickup"     =>  "postboxpickup.gif",
    "ups"               =>  "ups.gif",
    "usps"              =>  "usps.png",
    "tnt"               =>  "tnt.png",
    "yes24"             =>  "yes24.png",
    "yw56"              =>  "yw56.png"
);


////////////////////////////////////////////////////////////////////////////////////////////////////
// Social Media Buttons

$ADDTHIS_SHARING_BUTTONS_SCRIPT = '
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <div class="addthis_sharing_toolbox">
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56dd660806a65409"></script>
        </div>
';


////////////////////////////////////////////////////////////////////////////////////////////////////
// 경로관련

// 기본 경로
$PATH_VAR["default_url"] = "/";

// 파일이미지경로
// $PATH_VAR["home_path"] = "/home/users/wst002/www";                           // 홈디렉터리
$PATH_VAR["home_path"] = "/home/users/deliverytracking/www";                    // 홈디렉터리

$PATH_VAR["ad_url"] = "/files/ad";                                              // 광고 이미지 파일
$PATH_VAR["ad_path"] = $_SERVER["DOCUMENT_ROOT"] . $PATH_VAR["ad_url"];

$PATH_VAR["cookie_url"] = "/files/cookie";                                      // 쿠키 파일
$PATH_VAR["cookie_path"] = $_SERVER["DOCUMENT_ROOT"] . $PATH_VAR["cookie_url"];

$PATH_VAR["deliverytracking_url"] = "/files/deliverytracking";                  // 택배사배송조회 수집파일
$PATH_VAR["deliverytracking_path"] = $_SERVER["DOCUMENT_ROOT"] . $PATH_VAR["deliverytracking_url"];

$PATH_VAR["deliveryimage_url"] = "/files/deliveryimage";                        // 택배사 이미지 파일
$PATH_VAR["deliveryimage_path"] = $_SERVER["DOCUMENT_ROOT"] . $PATH_VAR["deliveryimage_url"];

$PATH_VAR["logo_url"] = "/files/logo";                                          // 로코 파일
$PATH_VAR["logo_path"] = $_SERVER["DOCUMENT_ROOT"] . $PATH_VAR["logo_url"];


////////////////////////////////////////////////////////////////////////////////////////////////////
// 배열상수

// 요일
$WDATE_ARRAY = array (
    "일" =>  "0",
    "월" =>  "1",
    "화" =>  "2",
    "수" =>  "3",
    "목" =>  "4",
    "금" =>  "5",
    "토" =>  "6"
);

// 월
$MONTH_ARRAY = array (
    "01" => "01",
    "02" => "02",
    "03" => "03",
    "04" => "04",
    "05" => "05",
    "06" => "06",
    "07" => "07",
    "08" => "08",
    "09" => "09",
    "10" => "10",
    "11" => "11",
    "12" => "12"
);

// 일
$DAY_ARRAY = array (
    "01" => "01",
    "02" => "02",
    "03" => "03",
    "04" => "04",
    "05" => "05",
    "06" => "06",
    "07" => "07",
    "08" => "08",
    "09" => "09",
    "10" => "10",
    "11" => "11",
    "12" => "12",
    "13" => "13",
    "14" => "14",
    "15" => "15",
    "16" => "16",
    "17" => "17",
    "18" => "18",
    "19" => "19",
    "20" => "20",
    "21" => "21",
    "22" => "22",
    "23" => "23",
    "24" => "24",
    "25" => "25",
    "26" => "26",
    "27" => "27",
    "28" => "28",
    "29" => "29",
    "30" => "30",
    "31" => "31"
);

// 시
$HOUR_ARRAY = array (
    "00" => "00",
    "01" => "01",
    "02" => "02",
    "03" => "03",
    "04" => "04",
    "05" => "05",
    "06" => "06",
    "07" => "07",
    "08" => "08",
    "09" => "09",
    "10" => "10",
    "11" => "11",
    "12" => "12",
    "13" => "13",
    "14" => "14",
    "15" => "15",
    "16" => "16",
    "17" => "17",
    "18" => "18",
    "19" => "19",
    "20" => "20",
    "21" => "21",
    "22" => "22",
    "23" => "23"
);

// 분
$MINUTE_ARRAY = array (
    "00" => "00",
    "01" => "01",
    "02" => "02",
    "03" => "03",
    "04" => "04",
    "05" => "05",
    "06" => "06",
    "07" => "07",
    "08" => "08",
    "09" => "09",
    "10" => "10",
    "11" => "11",
    "12" => "12",
    "13" => "13",
    "14" => "14",
    "15" => "15",
    "16" => "16",
    "17" => "17",
    "18" => "18",
    "19" => "19",
    "20" => "20",
    "21" => "21",
    "22" => "22",
    "23" => "23",
    "24" => "24",
    "25" => "25",
    "26" => "26",
    "27" => "27",
    "28" => "28",
    "29" => "29",
    "30" => "30",
    "31" => "31",
    "32" => "32",
    "33" => "33",
    "34" => "34",
    "35" => "35",
    "36" => "36",
    "37" => "37",
    "38" => "38",
    "39" => "39",
    "40" => "40",
    "41" => "41",
    "42" => "42",
    "43" => "43",
    "44" => "44",
    "45" => "45",
    "46" => "46",
    "47" => "47",
    "48" => "48",
    "49" => "49",
    "50" => "50",
    "51" => "51",
    "52" => "52",
    "53" => "53",
    "54" => "54",
    "55" => "55",
    "56" => "56",
    "57" => "57",
    "58" => "58",
    "59" => "59"
);

// 초
$SECOND_ARRAY = array (
    "00" => "00",
    "01" => "01",
    "02" => "02",
    "03" => "03",
    "04" => "04",
    "05" => "05",
    "06" => "06",
    "07" => "07",
    "08" => "08",
    "09" => "09",
    "10" => "10",
    "11" => "11",
    "12" => "12",
    "13" => "13",
    "14" => "14",
    "15" => "15",
    "16" => "16",
    "17" => "17",
    "18" => "18",
    "19" => "19",
    "20" => "20",
    "21" => "21",
    "22" => "22",
    "23" => "23",
    "24" => "24",
    "25" => "25",
    "26" => "26",
    "27" => "27",
    "28" => "28",
    "29" => "29",
    "30" => "30",
    "31" => "31",
    "32" => "32",
    "33" => "33",
    "34" => "34",
    "35" => "35",
    "36" => "36",
    "37" => "37",
    "38" => "38",
    "39" => "39",
    "40" => "40",
    "41" => "41",
    "42" => "42",
    "43" => "43",
    "44" => "44",
    "45" => "45",
    "46" => "46",
    "47" => "47",
    "48" => "48",
    "49" => "49",
    "50" => "50",
    "51" => "51",
    "52" => "52",
    "53" => "53",
    "54" => "54",
    "55" => "55",
    "56" => "56",
    "57" => "57",
    "58" => "58",
    "59" => "59"
);



// 인코딩 확인
$ENCODING_TYPE_ARRAY = array (
    "ASCII",
    "EUC-KR",
    "UTF-8"
);

?>