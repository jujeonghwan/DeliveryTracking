<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/snoopy/Snoopy.class.php");

/*
    Example:    fetch a web page and display the return headers and
                the contents of the page (html-escaped):

    include "Snoopy.class.php";
    $snoopy = new Snoopy;
    
    $snoopy->user = "joe";
    $snoopy->pass = "bloe";
    
    if($snoopy->fetch("http://www.slashdot.org/"))
    {
        echo "response code: ".$snoopy->response_code."<br>\n";
        while(list($key,$val) = each($snoopy->headers))
            echo $key.": ".$val."<br>\n";
        echo "<p>\n";
        
        echo "<PRE>".htmlspecialchars($snoopy->results)."</PRE>\n";
    }
    else
        echo "error fetching document: ".$snoopy->error."\n";
*/


/*
    Example:    submit a form and print out the result headers
                and html-escaped page:

    include "Snoopy.class.php";
*/
    $snoopy = new Snoopy;

    // loc=ko_KR&HTMLVersion=5.0&USER_HISTORY_LIST=&trackNums=1Z1041AV0325295726+&track.x=%EC%A1%B0%ED%9A%8C
    $submit_url = "https://wwwapps.ups.com/WebTracking/track";

    $submit_vars["loc"] = "ko_KR";
    $submit_vars["HTMLVersion"] = "5.0";
    $submit_vars["USER_HISTORY_LIST"] = "";
    $submit_vars["trackNums"] = "1Z1041AV0325295726+";
    $submit_vars["track.x"] = "%EC%A1%B0%ED%9A%8C";

    $snoopy->httpmethod = "POST";


    

    if($snoopy->submit($submit_url,$submit_vars))
    {        
        while(list($key,$val) = each($snoopy->headers))
            echo $key.": ".$val."<br>\n";
        echo "<p>\n";

        $snoopy->setcookies();
        
        // $setCookies = getCookies($snoopy->headers); 
        // echo "<PRE>".htmlspecialchars($snoopy->results)."</PRE>\n";
        // echo "<PRE>".$snoopy->results."</PRE>\n";
    }
    else
        echo "error fetching document: ".$snoopy->error."\n";


    //로그인에 관련하여 쿠키를 사용하는 경우가 있으니 쿠키정보를 저장해둡니다
    // $snoopy->setcookies();
    // $snoopy->cookies = $setCookies;

    // /*    
    $submit_url = "https://wwwapps.ups.com/WebTracking/detail";
    
    $submit_vars["loc"] = "ko_KR";
    $submit_vars["USER_HISTORY_LIST"] = "";
    $submit_vars["progressIsLoaded"] = "Y";
    $submit_vars["refresh_sii"] = "";
    $submit_vars["showSpPkgProg1"] = "true";
    $submit_vars["datakey"] = "line1";
    $submit_vars["HIDDEN_FIELD_SESSION"] = "lX%2BsKlLB5%2B3VylwKl%2BcJm3Yp2nb9TkpFstb8i2xLPXdYpmZKceB%2FAy5cNCzKipecP3jUkqE%2F6oBDvkUjuepWaviHOSrJuadUYzVmtQwHg9OR2VSBUiFrsq1KGmQ5qAFzAlc44reAZrncMzyPfhY8djVrhoIKeI%2FNdT2QLdQ7hzYWH%2FsarpuX%2FtbNk54mT558X6sRVqwvyOc2xGQVfFXPeh2iSc3o1NmdPmH8mfpZDgpTTVyNsxwlryeVpZLk2jRxSFuTCutPJwfqaj1CWSYF1gmY7gsIqUYJMlilEcNepWq9jk1l4V3Sv9V7MyK3NNFxYUrO5OBDXJqxTFiS%2B3YMSGLm2W9UxMHDOep%2Bh1LMj2qtm%2BX1ST5Jrx6atPjTDAJq%2Bg99wkk3gOZyCVhyNXW2g8n59Izin0L%2BqEYninm%2FoBNkuijWnNhKH1cbfVGQmk84sbN39H0tu%2Fq0QOCJTxTFTbg9FUmgQiitJfEFfrda%2Fq078UEdPA76SBwejwxxq%2B%2F1WjMTxH7ERtpzjP8XNtfUIB3ytmOB7hANfNPtWN16GpIQgaF3gASDUdFe7zzN7d5fh36gDKRDRLO4EG4ip9he1ZTvBuT4TfQKMqqhOs0cEtBz4h12zBMoFTXv2cB%2B30JASo5CXeyJcsh601NWZ2TUWxiC5xNnPqWpasWKljrb26OjnsXJpBvl3PHVZnGLPctaFAYc3%2FviBudi7TvqvGs0rThVvQISI0ZN6sYpjiGIYlLaSEp1l%2BMfRJAVx5QikyJfa%2FQKmQr9ovepb7E9zAJmTVXeD8ZNrNnyCrQ%2Bd9ExXhn9Room22S%2BnL1Wr3oWW34sq6zUmjsgMoai3RXzIMSKG2VDsLcZ%2BouKZQ%2BifAFyYBs0TAuzzI7Ync5MfTiSd%2FZ0IghSt4wWeb9UPmsQn0sEOIZMV3WodUFUxIE9WETqpOF8wJWyjtMVx4DOsPm1ht%2FNPqAXsf0bUp44V5dP1b4Cbf6VvsuvBYuOAhAfbPlnYslskdHkBgoxf3VwZBVeJUEvEDP4vQXBqQLGipj1bqxlsLU1zJzCGTiYg4RW34Dy7w1s3Sg3XbpmFfE51ZuQIrqEnVUgfCuD7Tlke9VAEMitZPDK%2BdPsDJgfkSapL2Qwk1ItmWDRG8NFB4IYD9lnjaCkli%2F4L9Wu3OZfyDKx6nwJ8yna85qM48uABENoY6hQ%2BGU4xUwOvxDn6LjJ1WifWQDIH2eItaEqwUvSZCkM7btZrF5DvCROBk23TlaJhmZrMm8KKSFibPgJ3L5ZV0BLKwW1T4GSMvQrS5w4QblbtrSHoegc1rMwF20rJz5HvDWXXGwT%2FlXkugDrNJqw6IkVZHVDSu2M4rMxzQoHoBZsCSvZBtqfhwK3j5yaDIBJI6%2FmS3JO7t66%2FOTRF73rz51fP4qlN2ughDSTrP9ZRN3LgRR5tgrkPIDfLeRH8H45F0w9WgrUglXNkQC1Sn8%2BNwxO9ymLO0gyyM9YrlU547SYyXbNQpzQxq%2BZ5F5idkXrG2zrOkpzVWwmCHWY87REsOTABXh9HnuF4QS%2BzyHm3SQ%2Fg3K6Dkz%2FJDz2mVNULQctG3db8496N5PR2TSJi2vemgw6UtC%2BmA1zuo2jcpZ6iGqLxoDt8TvpPso4c3IlkP2WGNKjqVBE4uXx%2BXFmzzgYyWDGIQlqZ%2BcMBvp%2FBIB2TF%2FPfY0Otr6l2S5r1dEoNgmzmGb2iO74knE9TyNOH1gGhfLQoupRFsdvsKIQZR23aKQ0jEJhzwVtCwx7FIdJWt1h1C32LWhMTdOw44uw%2BIXQARwWN8UAkR5oWuvTTuOmPBT%2BReXer5FmqH%2FugP4l5gAzA1phtbxvLmgBDHhDCLJ29dInzwfEB3v7lqN6gieovHhXdzpWMbf1JhTiWy7KTeVNr2yg6NmgOljVYS3zQrheIAry5k5FDvsgou%2F3Dj%2FOPnMTR2cUR4Wdr8jTtfXGKB935y8unX3IZHNDW4b%2BsfyyXekLMfGA0swdetvJ4qErhWLQNTGjJxF5fmNvwrf1IzP9ibX%2F3fAotuFXnPcyq6ij32r2vf%2FbxUyogojlTpsmu5A4PndJGWwj8C0fIMUFdQwH3S8QkApQZzaV2PHuBWj0v4BtAfA%2FbVQWaVP1Gpv1u1o%2FFsVNdqV34NfwNReGu2ksj1xChWyj0wCJSfwmmiraE%2F8RQ1bmartpU4y%2F0ml1KyN6hTs41tituJXTHe0%2B%2FXGcbquthY5OSanXzNhvxJQaaC9e7WunT6MPlr0XLIDNk4Zrfbx69%2FGSRQ0aD6tOJ2GJgBYt9MGYa%2BxwELbCy%2B6pNSZSVMft%2F%2BAygJpSxWbO5NntvzNQygrJ2JaoU9uD5aWOlMeqoUICQN0XClpZGTN%2BfIECDBioTjkash0B6fWHiIpCMCtCsPaRUBbgvttxezeUj4GCjJrlJ%2Bpjw33iwqp99pvQoQkMRdQ%2Bjm7rsfIUBoAqV6iJieRDqcG%2B7aFvqMHkngXPZ9Y%3DA1f0d84424";
    $submit_vars["descValue1Z1041AV0325295726"] = "";
    $submit_vars["trackNums"] = "1Z1041AV0325295726";
    // */
        
    $snoopy->httpmethod = "POST";

    if($snoopy->submit($submit_url,$submit_vars))
    {
        while(list($key,$val) = each($snoopy->headers))
            echo $key.": ".$val."<br>\n";
        echo "<p>\n";
        
        echo "<PRE>".htmlspecialchars($snoopy->results)."</PRE>\n";
        // echo "<PRE>".$snoopy->results."</PRE>\n";
    }
    else
        echo "error fetching document: ".$snoopy->error."\n";



/*
    Example:    showing functionality of all the variables:
    

    include "Snoopy.class.php";
    $snoopy = new Snoopy;

    $snoopy->proxy_host = "my.proxy.host";
    $snoopy->proxy_port = "8080";
    
    $snoopy->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
    $snoopy->referer = "http://www.microsnot.com/";
    
    $snoopy->cookies["SessionID"] = 238472834723489l;
    $snoopy->cookies["favoriteColor"] = "RED";
    
    $snoopy->rawheaders["Pragma"] = "no-cache";
    
    $snoopy->maxredirs = 2;
    $snoopy->offsiteok = false;
    $snoopy->expandlinks = false;
    
    $snoopy->user = "joe";
    $snoopy->pass = "bloe";
    
    if($snoopy->fetchtext("http://www.phpbuilder.com"))
    {
        while(list($key,$val) = each($snoopy->headers))
            echo $key.": ".$val."<br>\n";
        echo "<p>\n";
        
        echo "<PRE>".htmlspecialchars($snoopy->results)."</PRE>\n";
    }
    else
        echo "error fetching document: ".$snoopy->error."\n";


/*
    Example:    fetched framed content and display the results
    
    include "Snoopy.class.php";
    $snoopy = new Snoopy;
    
    $snoopy->maxframes = 5;
    
    if($snoopy->fetch("http://www.ispi.net/"))
    {
        echo "<PRE>".htmlspecialchars($snoopy->results[0])."</PRE>\n";
        echo "<PRE>".htmlspecialchars($snoopy->results[1])."</PRE>\n";
        echo "<PRE>".htmlspecialchars($snoopy->results[2])."</PRE>\n";
    }
    else
        echo "error fetching document: ".$snoopy->error."\n";
*/


?>