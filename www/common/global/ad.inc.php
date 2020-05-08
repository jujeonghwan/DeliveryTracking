<?php

////////////////////////////////////////////////////////////////////////////////////////////////////
// 구글 애드센스 (광고)

$GOOGLE_ADSENSE_HTML = '
    <!-- Google AdSense WST 시작 -->
    <!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7596282956342906"
         data-ad-slot="1612483676"
         data-ad-format="auto"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <!-- Google AdSense WST 끝 -->
';


////////////////////////////////////////////////////////////////////////////////////////////////////
// 링크프라이스 (광고)

// 엑셀 수식 [="    """ & TRIM(A2) & """ => """ & TRIM(B2) & " (" & TRIM(C2) & ")"","]
// 예) "http://ad.linkprice.com/stlink.php?m=yes24&a=A100532968&width=150&height=60&target=_blank",
$AD_LINKPRICE_150_60_ARRAY = array (
    "072com" => "땡처리닷컴 (여행/항공/숙박)",
    "1033game" => "열혈삼국3 (게임/모바일)",
    "11st" => "11번가 (오픈마켓)",
    "21dress" => "21드레스룸 (패션/소호)",
    "99flower" => "(주)99플라워 기분좋은 꽃배달 (꽃배달)",
    "acrmart" => "아크릴마트 (생활/인테리어/팬시)",
    "afrimo" => "아프리모 (화장품/뷰티)",
    "agoda" => "아고다호텔 (해외쇼핑몰)",
    "ahappy" => "해피로pc방 (기타 서비스)",
    "aipmk" => "AIP ONLINE SURVEYS KOREA (패널/설문조사)",
    "aliexpress" => "AliExpress (알리익스프레스) (해외쇼핑몰)",
    "allcredit" => "올크레딧 (금융/신용/카드/대출)",
    "allcredit1" => "올크레딧 무료회원가입 (금융/신용/카드/대출)",
    "allcredit2" => "올크레딧app (금융/신용/카드/대출)",
    "allofyou" => "올오브유 (종합쇼핑몰)",
    "ampmvvip" => "토네이도 급등주 연구소 (금융/신용/카드/대출)",
    "applecom" => "Apple 공식사이트 (해외쇼핑몰)",
    "ashford1" => "애쉬포드 (해외쇼핑몰)",
    "asos" => "아소스 (해외쇼핑몰)",
    "auction" => "옥션 (오픈마켓)",
    "autodesk" => "오토데스크 코리아 (해외쇼핑몰)",
    "babosarang" => "바보사랑 (생활/인테리어/팬시)",
    "bandibook" => "반디앤루니스 (도서/티켓)",
    "banggood" => "banggood(뱅굿) (해외쇼핑몰)",
    "bcountry" => "Backcountry (백컨트리) (해외쇼핑몰)",
    "benevmall" => "BENEV KOREA 온라인총판몰 (화장품/뷰티)",
    "bizmailer" => "비즈메일러 (인터넷)",
    "blindqueen" => "블라인드퀸 (생활/인테리어/팬시)",
    "blooming" => "블루밍데일즈 (해외쇼핑몰)",
    "bodyup" => "바디업 (식품)",
    "bookingcom" => "부킹닷컴 (해외쇼핑몰)",
    "boribori" => "보리보리 (유아/아동용품)",
    "brolico" => "브로리코액티브 (식품)",
    "calolina" => "미스칼로리나 (식품)",
    "cappstory" => "앱스토리몰 (디지털/영상/휴대폰)",
    "cjbrand" => "CJON mart(CJ온마트) (식품)",
    "cjbrandapp" => "CJ온마트 (식품)",
    "cjmall" => "CJmall (종합쇼핑몰)",
    "cjmall1" => "CJmall 무료회원가입 (종합쇼핑몰)",
    "club5678" => "CLUB5678 (미팅/채팅/결혼)",
    "coupang" => "쿠팡 (소셜커머스)",
    "crossgame4" => "촉산협객전 웹게임 (게임/모바일)",
    "ctrip" => "트립닷컴 (여행/항공/숙박)",
    "cuchen" => "쿠첸샵 (가전/가구)",
    "cyberlink" => "CyberLink (해외쇼핑몰)",
    "cybermall" => "신세계몰 (종합쇼핑몰)",
    "daisomall" => "다이소몰 (생활/인테리어/팬시)",
    "daoumocci" => "알뜰장문 (인터넷)",
    "daouwsms" => "반값문자 (인터넷)",
    "datafree" => "최신스마트폰 (디지털/영상/휴대폰)",
    "daycell1" => "데이셀몰 (화장품/뷰티)",
    "dazedayz" => "데이즈데이즈 (패션/소호)",
    "deesse" => "청담여신성형외과 (건강/의료/병원)",
    "dfbexport" => "정원e샵 (식품)",
    "disney" => "디즈니 스토어 (해외쇼핑몰)",
    "dkecofarm" => "DK에코팜 (식품)",
    "dmtourmall" => "대명투어몰 (여행/항공/숙박)",
    "domgabia" => "가비아 (컴퓨터/소프트웨어)",
    "dongwon" => "동원몰 (식품)",
    "dootadfs" => "두타면세점 (종합쇼핑몰)",
    "eastdane" => "East Dane (이스트 데인) (해외쇼핑몰)",
    "ecosigong" => "주식회사 아이스크림 에듀 (교육)",
    "edaymall11" => "이데이몰 (종합쇼핑몰)",
    "eduwang" => "에듀왕 (도서/티켓)",
    "egalleria" => "갤러리아몰 (종합쇼핑몰)",
    "ellotte" => "엘롯데 (종합쇼핑몰)",
    "emart" => "이마트인터넷쇼핑몰 (종합쇼핑몰)",
    "embrain" => "엠브레인 리서치 회원가입 (패널/설문조사)",
    "emmilkt" => "천재교육 밀크T (교육)",
    "emuphone" => "민병철유폰 (교육)",
    "enfax" => "엔팩스 (인터넷)",
    "epost" => "우체국 쇼핑 (종합쇼핑몰)",
    "eranzi" => "이란지코리아 (패션/소호)",
    "evasion" => "에바종 (여행/항공/숙박)",
    "expedia" => "익스피디아 (해외쇼핑몰)",
    "eyoumall" => "이유몰 (종합쇼핑몰)",
    "farfetch" => "파페치 (해외쇼핑몰)",
    "finishline" => "Finish Line (피니쉬 라인) (해외쇼핑몰)",
    "flower365" => "플라워 365 (꽃배달)",
    "forzieri1" => "포지에리 (해외쇼핑몰)",
    "franken" => "프랑켄모노 (패션/소호)",
    "gabangpop" => "가방팝&멀티팝 (패션/종합)",
    "gajago" => "가자고 (여행/항공/숙박)",
    "gearbest" => "Gearbest (기어베스트) (해외쇼핑몰)",
    "gettyimage" => "게티이미지뱅크 (기타 서비스)",
    "gfairsm" => "MEGASHOW (박람회)",
    "giftishow" => "기프티쇼 (종합쇼핑몰)",
    "gilt" => "길트닷컴 (해외쇼핑몰)",
    "gmarket" => "G마켓 (오픈마켓)",
    "gnc" => "GNC (해외쇼핑몰)",
    "gosister" => "언니가간다 (패션/소호)",
    "granddfs" => "그랜드면세점 (패션/종합)",
    "gseshop" => "GS SHOP (종합쇼핑몰)",
    "halfclub1" => "하프클럽 (패션/종합)",
    "hanatour1" => "하나투어리스트 (여행/항공/숙박)",
    "harrods" => "헤롯백화점 (해외쇼핑몰)",
    "healthpost" => "헬스포스트 (해외쇼핑몰)",
    "himart" => "하이마트쇼핑몰 (가전/가구)",
    "hmall" => "Hmall (종합쇼핑몰)",
    "hodoomall" => "호두몰 (디지털/영상/휴대폰)",
    "homeplus2" => "홈플러스 온라인 마트 (종합쇼핑몰)",
    "hotelskr" => "호텔스닷컴 (해외쇼핑몰)",
    "ichiba" => "라쿠텐 이치바 (해외쇼핑몰)",
    "ihometax" => "아이홈택스 (인터넷)",
    "interpark2" => "인터파크 도서 (도서/티켓)",
    "isaypanel" => "i-Say (패널/설문조사)",
    "isense" => "케어센스몰 (건강/의료/병원)",
    "istyle24" => "아이스타일24 (패션/종합)",
    "itemmania" => "아이템매니아 무료회원가입 (게임/모바일)",
    "itscase" => "잇츠케이스 (디지털/영상/휴대폰)",
    "jennypark" => "JENNY PARK (패션/종합)",
    "jestina" => "제이에스티나 (패션/종합)",
    "joins1" => "조인스 (도서/티켓)",
    "kbbook" => "인터넷교보문고 (도서/티켓)",
    "kbhvitamin" => "팔레오 비타민나무 (식품)",
    "koreasang" => "박씨상방 (생활/인테리어/팬시)",
    "kshop1" => "K쇼핑 (종합쇼핑몰)",
    "kukka" => "꾸까 (꽃배달)",
    "kumkang" => "금강-랜드로바몰 (패션/종합)",
    "kyungrok" => "경록 (교육)",
    "lastsave4" => "라스트세이브 (인터넷)",
    "lfmall" => "LFmall (패션/종합)",
    "lightb" => "LightInTheBox (해외쇼핑몰)",
    "linkprice" => "링크프라이스 (기타 서비스)",
    "lotte" => "롯데닷컴 (종합쇼핑몰)",
    "lottorich" => "로또리치 (운세/복권)",
    "louisclub" => "루이까또즈직영몰 (패션/종합)",
    "louisclub1" => "루이스클럽 (패션/종합)",
    "luxkorea1" => "룩스코리아 (오픈마켓 셀러)",
    "macys" => "메이시스 (해외쇼핑몰)",
    "madam4060" => "마담4060 (패션/소호)",
    "makeprice" => "위메프 (소셜커머스)",
    "matches1" => "매치스패션 (해외쇼핑몰)",
    "menovel" => "미소설 (음악/만화/영화)",
    "miodio" => "미오디오 (디지털/영상/휴대폰)",
    "mootoon" => "무툰 (음악/만화/영화)",
    "mpchunjae" => "밀크T중학 (교육)",
    "mrporter" => "미스터포터 (해외쇼핑몰)",
    "mskorea" => "MS스토어 (해외쇼핑몰)",
    "musinsa" => "무신사 (패션/종합)",
    "mustit" => "머스트잇 (패션/종합)",
    "mycredit1" => "NICE지키미 (금융/신용/카드/대출)",
    "mysimcafe" => "마이심카페 (디지털/영상/휴대폰)",
    "mytheresa" => "마이테레사 (해외쇼핑몰)",
    "naingirl" => "나인 (패션/소호)",
    "nashcard" => "현대카드 발급신청 이벤트 (금융/신용/카드/대출)",
    "negg" => "Newegg.com (해외쇼핑몰)",
    "netaporter" => "네타포르테 (해외쇼핑몰)",
    "newbalance" => "Joe's New Balance Outlet (조스 뉴발란스) (해외쇼핑몰)",
    "ninewest" => "나인웨스트 (해외쇼핑몰)",
    "nsseshop" => "NS홈쇼핑 (종합쇼핑몰)",
    "nubelle" => "누벨르 (화장품/뷰티)",
    "officekeep" => "오피스키퍼 (가전/디지털/IT)",
    "onlinetour" => "온라인투어 (여행/항공/숙박)",
    "paleo" => "팔레오 슈퍼푸드 (식품)",
    "partzone" => "파트존 (자동차/용품)",
    "pati" => "파티지 (패션/소호)",
    "pcherry" => "petite cherry (해외쇼핑몰)",
    "portfolio" => "포트폴리오박스 (해외쇼핑몰)",
    "posttelink" => "하나팩스 (인터넷)",
    "ppurio" => "뿌리오 (인터넷)",
    "qoo10" => "큐텐(Qoo10) (해외쇼핑몰)",
    "rakuten" => "라쿠텐글로벌마켓 (해외쇼핑몰)",
    "rakutentr" => "라쿠텐 트래블 (해외쇼핑몰)",
    "re4akor" => "레일유럽 (해외쇼핑몰)",
    "rebecca" => "레베카 밍코프 (해외쇼핑몰)",
    "rentking" => "렌트킹 (자동차/용품)",
    "research" => "패널나우 (패널/설문조사)",
    "rnrpanel" => "리서치앤리서치 온라인패널 (패널/설문조사)",
    "rockport" => "락포트 (해외쇼핑몰)",
    "rosastory" => "에게이안스토리 (화장품/뷰티)",
    "saksavenue" => "Saks Fifth Avenue (해외쇼핑몰)",
    "saksfifth" => "Saks Fifth Avenue Off 5th (해외쇼핑몰)",
    "sbdi" => "Market Research Report (기타 서비스)",
    "seadna" => "씨디앤에이 (식품)",
    "shopbop1" => "Shopbop (샵밥) (해외쇼핑몰)",
    "shutter" => "셔터스톡(shutterstock) (해외쇼핑몰)",
    "signgate" => "한국정보인증 (금융/신용/카드/대출)",
    "slim19" => "먹어도좋아 (화장품/뷰티)",
    "smmall" => "AK몰 (종합쇼핑몰)",
    "soohyun" => "노블레스수현 (미팅/채팅/결혼)",
    "ssense" => "센스닷컴 (해외쇼핑몰)",
    "ssfshop" => "삼성물산 패션부문 SSFSHOP (패션/종합)",
    "strawberry" => "스트로베리넷(딸기넷) (해외쇼핑몰)",
    "stylebop" => "스타일밥 (해외쇼핑몰)",
    "surveylink" => "서베이링크 신규회원가입 (패널/설문조사)",
    "syberiyan" => "베리얀 (화장품/뷰티)",
    "syboli" => "비올리 (화장품/뷰티)",
    "sycocomedi" => "코코메디 (건강/의료/병원)",
    "symizcare" => "미즈케어솔루션 (화장품/뷰티)",
    "taillist" => "테일리스트 (해외쇼핑몰)",
    "testgut" => "테스트굿 (화장품/뷰티)",
    "thehfng" => "365더건강 (식품)",
    "thehyundai" => "현대백화점몰 (종합쇼핑몰)",
    "timemecca" => "타임메카 (패션/종합)",
    "tmon" => "티몬 (소셜커머스)",
    "tomtop" => "Tomtop (해외쇼핑몰)",
    "tplusmall" => "티플러스몰 티플러스모바일 (디지털/영상/휴대폰)",
    "tripadviso" => "트립어드바이저 (해외쇼핑몰)",
    "unse" => "운세.com (운세/복권)",
    "villeroy" => "빌레로이 앤 보흐 (해외쇼핑몰)",
    "walmart" => "월마트 USA (해외쇼핑몰)",
    "webtour" => "웹투어 (여행/항공/숙박)",
    "welbu" => "세븐라이너 (뷰티)",
    "wibee" => "위비마켓 (오픈마켓)",
    "wisecampa" => "와이즈캠프 (교육)",
    "wizwid" => "위즈위드 (패션/종합)",
    "wmf" => "WMF (해외쇼핑몰)",
    "woomarket" => "우마켓 (오픈마켓)",
    "woori" => "롯데홈쇼핑 (종합쇼핑몰)",
    "wsketch" => "뇌새김영어 (교육)",
    "xkeeper" => "엑스키퍼 (컴퓨터/소프트웨어)",
    "yeoin" => "여인닷컴 (화장품/뷰티)",
    "yes24" => "예스이십사 (도서/티켓)",
    "yoox" => "육스닷컴(yoox.com) (해외쇼핑몰)",
    "ypbooks" => "인터넷영풍문고 (도서/티켓)",
    "zulily" => "Zulily (줄릴리) (해외쇼핑몰)",
);                                                                                         

// 링크프라이스 (헤더 광고)
$AD_LINKPRICE_HEADER_150_60_ARRAY = $AD_LINKPRICE_150_60_ARRAY;

// 링크프라이스 (푸터 광고)
$AD_LINKPRICE_FOOTER_150_60_ARRAY = $AD_LINKPRICE_150_60_ARRAY;

/*                                                                                       
// 테스트                                                                                     
$AD_LINKPRICE_150_60_ARRAY = array (                                                   
    "yes24" => "예스이십사"
);
*/

/*
// 로고링크
$AD_LINKPRICE_LOGOLINK_WIDTH = 468;
$AD_LINKPRICE_LOGOLINK_HEIGHT = 78;
$AD_LINKPRICE_LOGOLINK_SCRIPT = '<iframe scrolling="no" src="http://minishop.linkprice.com/minishop.php?minishop_id=logo&affiliate_id=A100532968&width=600&margin=10&scroll=&direction=L&speed=61&border=&color=FFFFFF" width="' . $AD_LINKPRICE_LOGOLINK_WIDTH . '" height="' . $AD_LINKPRICE_LOGOLINK_HEIGHT . '" border="0" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0"></iframe>';
// $AD_LINKPRICE_LOGOLINK_SCRIPT = '<iframe scrolling="no" src="http://minishop.linkprice.com/minishop.php?minishop_id=logo&affiliate_id=A100532968&width=600&margin=10&scroll=_s&direction=L&speed=61&border=&color=FFFFFF" width="' . $AD_LINKPRICE_LOGOLINK_WIDTH . '" height="' . $AD_LINKPRICE_LOGOLINK_HEIGHT . '" border="0" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0"></iframe>';

// 자동배너링크
$AD_LINKPRICE_AUTOBANNERLINK_468_60_SCRIPT = '<script type="text/javascript" src="http://smart.linkprice.com/minishop.php?minishop_id=4&affiliate_id=A100532968&width=468&height=60&target=_blank&show_type="> </script>';

// 카테고리링크 메뉴형
$AD_LINKPRICE_CATEGORYLINK_WIDTH = 300;
$AD_LINKPRICE_CATEGORYLINK_HEIGHT = 320;
$AD_LINKPRICE_CATEGORYLINK_SCRIPT = '<iframe scrolling="no" scrollbars="yes" src="http://minishop.linkprice.com/minishop.php?minishop_id=category&l_cd1=S&affiliate_id=A100532968&style=3&line=10&color=skyblue&show_cat=CiGOAPaJYRkdFQLnbWNjgmhSBVclKEfUHZopIDqs&width=' . $AD_LINKPRICE_CATEGORYLINK_WIDTH . '&height=' . $AD_LINKPRICE_CATEGORYLINK_HEIGHT . '" width="' . $AD_LINKPRICE_CATEGORYLINK_WIDTH . '" height="' . $AD_LINKPRICE_CATEGORYLINK_HEIGHT . '" border="0" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0"></iframe>';
*/

// 앱설치형광고 API
$AD_LINKPRICE_APP_API_ARRAY["a_id"] = "A100532968";
$AD_LINKPRICE_APP_API_ARRAY["auth_key"] = "76e3d6592ff51cdf96afbc35f23c9db9";
$AD_LINKPRICE_APP_API_ARRAY["url"] = "http://api.linkprice.com/affiliate/nonrewardapp.php?a_id=" . $AD_LINKPRICE_APP_API_ARRAY["a_id"] . "&auth_key=" . $AD_LINKPRICE_APP_API_ARRAY["auth_key"];

// 정보(웹/앱)
$INFO_TYPE_ARRAY = array(
    "웹사이트(Web Site)" => "web",
    "아이폰앱(iOS App)" => "ios",    
    "안드로이드앱(Android App)" => "android"
);

?>