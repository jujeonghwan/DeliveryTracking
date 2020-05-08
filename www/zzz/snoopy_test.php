<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();
html_meta_charset_utf8();

// Snoopy class
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/snoopy/Snoopy.class.php");

    // Initialize
    $snoopy = new Snoopy;

    $snoopy->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
    $snoopy->referer = "https://www.lotteglogis.com/open/tracking";
    
    $snoopy->cookies["SessionID"] = "238472834723489l";
    $snoopy->cookies["favoriteColor"] = "RED";
    
    $snoopy->rawheaders["Pragma"] = "no-cache";
    
    $snoopy->maxredirs = 3;
    $snoopy->offsiteok = false;
    $snoopy->expandlinks = false;


    // $submit_url = "https://www.lotteglogis.com/home/personal/inquiry/track";
    $submit_url = "https://www.lotteglogis.com/open/tracking?invno=305854318232";

    $snoopy->fetch("$submit_url");
    /*
    $submit_vars["action"] = "processInvoiceSubmit";
    $submit_vars["InvNo"] = "305854318232";
    */

    // $snoopy->submit($submit_url,$submit_vars);

    $snoopy->setcookies();

    sleep(3);
    // print $snoopy->results;

    // exit;
    $submit_vars["action"] = "processSubmit";

    $snoopy->submit($submit_url,$submit_vars);

    $snoopy->fetch("https://www.lotteglogis.com/open/tracking");
    print $snoopy->results;

    
    /*
    $snoopy->user = "joe";
    $snoopy->pass = "bloe";
    
    // if($snoopy->fetchtext("https://www.lotteglogis.com/home/personal/inquiry/track"))
    if($snoopy->fetch("https://www.lotteglogis.com/open/tracking"))
    {
        while(list($key,$val) = each($snoopy->headers))
            echo $key.": ".$val."<br>\n";
        echo "<p>\n";
        
        echo "<PRE>".htmlspecialchars($snoopy->results)."</PRE>\n";
    }
    else
        echo "error fetching document: ".$snoopy->error."\n";

    */
/*
$snoopy->referer = "www.lotteglogis.com";

//로그인 정보를 저장할 배열 auth를 만듭니다 
//배열의 key는 해당 폼에서 넘겨줄 name이 되겠습니다 
$auth['action'] = 'processInvoiceSubmit'; 
$auth['InvNo'] = '305854318232';

//스누피의 submit함수로 폼정보를 넘겨줍시다 
$snoopy->submit($uri,$auth); 

//로그인에 관련하여 쿠키를 사용하는 경우가 있으니 쿠키정보를 저장해둡니다 
$snoopy->setcookies(); 
$snoopy->cookies["JSESSIONID"] = "872BEE865A2F3C3A85AEDE9306C6E89E";

sleep(3);

//배열의 key는 해당 폼에서 넘겨줄 name이 되겠습니다 
$auth2['action'] = 'processInvoiceLinkSubmit'; 
// $auth['InvNo'] = '305854318232';

//스누피의 submit함수로 폼정보를 넘겨줍시다 
$snoopy->submit($uri,$auth2); 

// $snoopy->setcookies(); 

//이제 로그인 정보를 가지고 있으니 다시 uri로 접속해봅시다 
$snoopy->fetch($uri); 

sleep(3);

// result
// echo "<xmp>" . $snoopy->results . "</xmp>";
echo $snoopy->results;

/*
//그리고 정규식을 이용해서 해당 엘리먼트를 뽑아옵니다 
preg_match('/<table id="account-information">(.*?)<\/table>/is', $snoopy->results, $result); 

//마지막으로 결과를 출력하구요 
echo '<table id="info">'.$result[1].'</table>'; 
*/

?>