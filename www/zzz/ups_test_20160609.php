<?php

function post($host, $query, $others="") {                  // fsockopen 을 보다 쉽게 사용하기 위해 만든 함수 
    $path = explode('/', $host); 
    
    $host = $path[0]; 
    unset($path[0]) 
    $path = '/'.(implode('/',$path)); 
    
    $post=""; 
    $post.="POST http://wwwapps.ups.com/WebTracking/detail HTTP/1.1\r\n"; 
    $post.="Host: wwwapps.ups.comt\r\n"; 
    $post.="Content-type: application/x-www-form-urlencoded\r\n"; 
    $post.="Cookie: WT_FPC=id=112.221.253.82-868809984.30522696:lv=1465412261698:ss=1465412181880; defaultHome=kr_ko_home|1464924625248; fsr.s=%7B%22v2%22%3A1%2C%22v1%22%3A1%2C%22cp%22%3A%7B%22cxreplayaws%22%3A%22true%22%7D%2C%22rid%22%3A%22d2e4e33-111582210-1dc1-fedd-c98ca%22%2C%22to%22%3A10%2C%22mid%22%3A%22d2e4e33-111582545-bc31-3030-1d203%22%2C%22rt%22%3Afalse%2C%22rc%22%3Afalse%2C%22c%22%3A%22https%3A%2F%2Fwwwapps.ups.com%2FWebTracking%2Ftrack%22%2C%22pv%22%3A2%2C%22lc%22%3A%7B%22d0%22%3A%7B%22v%22%3A2%2C%22s%22%3Atrue%7D%7D%2C%22cd%22%3A0%2C%22sd%22%3A0%2C%22f%22%3A1465462627215%7D; UPS_SHARED_SESSION=BLgISQiqubovpckGtZWmDVzTxAvNrA2LBeQClcR86gLsUFTy8W2iIbuVzyMV8KhZpf7XoNUNM9uD40iMtyc0/bCjhQIgeF7vTCd3sO7qgEoHReLrVQgYYnRGv+YTes0zT2RgYjUBjBZ9mKH4X20jWihuJsHrNirCgHmWA7YxoKEEpssP55yZy0swUF0f/YFcRboILIXf0V+7NapTzisY5xAzp0zl9VVC8fNO7GI9xnFBK2mK9tQLbcjWj9Qfv9fW+xojBS0huIwloKRWNlU66iSgy4V9zYOYZ8mDcQ910sR2Lwiu1N+U3chR7mbPzf5JrDeiTEi49p7r672FLPgq2sWblOhCDvxMyaAg2Dlyg7SgIPAFQmwOGXZBkrl6QBTWywmZYBDeRrqGz+BHfwzfbE79z58jWqeWViK7u0gVEBGGoNr7kGgmn2m0pDLfjvVOUJ2/d73d2bw/d61Y8dlGULjmZ0uyl20leQG+yv+Z+21p8gwSmNOcG3mn+jdd0oRqkpFcbaqUt0M40l40sZw/rsT+A/Fgw+cSVGtn29KYygYdiqu09cZ85QCsSZ/Hc8s3nxmxKkYksrWfaPRMmaMvBw8gj7TMi2X6bRyaB57OxIFd/actIEB4rmli2Te8GLvg/LlEfaV70YoItdRti7UvkvFDkG+SXCFugAXPLOad9MyAPUXH+bAa++t1d3OVNY2jR0aAbu9orBfXz8NP8CXxb0iefxoVyitux50FBUJfmj6AujsY5WQ5+A3e/Gj8HJv3eQ1NlkAr5CrxT8fTBMXPgKUhPeTTN2szCELTGDyif68=A1f78c0fe1; User-Agent: Mozilla 4.0"; 
    $post.="\r\nContent-length: ".strlen("loc=en_US&USER_HISTORY_LIST=&progressIsLoaded=N&refresh_sii=&showSpPkgProg1=true&datakey=line1&HIDDEN_FIELD_SESSION=UjvC1bIlpu4B9zFt10GVj7ak6PKzsp14GqShABpV4VYBL3Dw4XpNaxe8NQzGtcKHjgju%2BhPhpxwcAJCBoN6%2BLRYB33HYFYY%2BAOvB3dAtxMrmS5IRf8LVpVPZ7%2F1VD5q%2FjELZd4BFhTg8H9VU3T74hZOaeHT8bYYw8%2BXpaPCEMHuufyFvWlqB4wx1Ra6CtcF83Du6Zz7XMCzH7JjJ%2FfCzprTgCvT1ZB5t6XJsXjq%2FNmcnAuTL9RDXojwlsyqOV4JCZsfkRXSo6PoK2wUpXI0AZFHTuJCYlUEkdDCdU1kC2hrmtKsL6BVCyiBs2KspH%2BlbVS50D%2F3H27ulrVcpRKTshz3c4z16qC2opDohsXFNpIitpyAcNKcdhxbkfQoxgHy66BmaKBvC799N9C5q4qB71cpzt7OaDBw%2BnUHptvyr8Hb9H8O%2FrLBM6ZVRgcDar3bWUYmcfFyTo4vqI7UkBVAy4xZABV4zWpMw93xIqgNKi%2FPi5T6CxRHxqUfo%2B52kLJ0ibRd1nbL5o4fvYK2DvIaWcn6RsazLW5OmOAq6s5UiAxzxqsyZ66y7qaCKR4qrGWtYfzF0CELzQrD9SBQGjya3vlVsEp%2BOadsMpcV%2B9eoovJAnieV7zlmE%2F4%2BvmxVQhcE37YDA%2BmBNFaEsnK30KzTEDoup1a3wy%2F%2Bw7LLhmPpOvVZs4y0z42G%2FryB29qVB8tcpxRQ1poSKgtmGn%2BIS4HRS07RdytscQHTkZxCYEdMZwytUD9fWRNyM73vFrOig7l9w5S3spkYqljLvPWsLciB8jdVv%2FVw6PZzCn1ewWbRk6DEbzkqELO6spHcg2oQi3YKVoYA5uNwUegSQzn6b2TQ7xuh8d7nKrGkSyOb0O5ec%2BU57yzptVi7ldr9GH4VvYVseMm4%2BHp6arS9AulS83HNIQBXgpO%2BD6dZ09iC4sbirtWYNcgt0g8IDImr1lrf%2BXZZE6TWCpP%2FDSWs6dNJQ9KWPDkyxkLJIjWtqO5l86azMR6Ze904d5lNYtzKuZ0t6E720tp%2BU3sCD5Z2vzFglDQjOwy%2BsNjSKctKhD%2BHKgJJ9cHKf6wHgfiEw0DVOZNNXz0UXjAi2l6EIxQsQamm2XMCbK%2BILdZXW8erNG%2BpPNrkVPf9kbpd6X6thgZx4fUcZteH%2BjR44t%2Fq%2FxRbbdiFDjtB9zjT8tSINsCmRcYO4gCcPWwYMlhp325o199gCNtnD6YveQk0EiMpeojfzEDETCXV5isTwX2jM%2F32mxLoAMO3fo3iQABgCz%2Fbqlun094AsZPHAw%2FmLksLsCKq%2ByokSLb9c1iQHgkw1bX9Jr3hNbazFP7UEwwna0EuJKpsiHaIM%2FNYEobn8saAoIcBT1J3FYXjqcGfOWb1waI%2BFMTGf6%2Brl0xIrFW1uUglBDUyMu2LESiSosC7xsgopG3F9cFT%2FWzTWGzsOxACYr7amlTImi2EGw%2FqIwJIzfd8z3ok3cIxYL%2F2k1eurQ0WdJO7G6xIcoqm0AR0b%2FhbOR2hcpIDeNZxwSH3IQUGHDvFiDQ95GAx9ta6DPrK0SB4rEFRWGL96nP2KmiJ6ZQl6bkj1YS%2Be%2BiDXCrD%2F8D6%2FvwI9Anjh6KVu2v3AbxraqnoeYx%2Ba3uVkuxQO3ia8QHM2YtdQPK4ROxAX%2FV%2F40gVVzapjCqCG4y6mQmpz4HWo9KdRaVXSnp6nV%2BRbjSBoA9qf8v%2FWHAFVVVmjg1V316%2BlD2yQnSr71jxGRnXUZbK%2BoERWV1rQ%2Bqg63W61pM1Ip2peM07suXC%2BFUMwbVgsuPqEp%2BBT%2Bk%2BVeKoPRrB7Q2KyVUBjzZxFybdyBLo7IbakYcPXd0tF6j5yEcjilAATIgmgzgeUgIP3JPU9hCEw9rlsPQCXzjQKJfFR0QTgw2fcgHQANxJ4fA3UEzSz64kmUCjIpdBqn%2BMeVyoghHKINS15d5Kn%2Fr63eUzQfjnAweeAIeQrwv77u5%2FyooiHnz2Z5AjVAtIfukq96f1kTiBSP7i5%2BzZfd3XpJ7DfF3MIkjxAQ%2B8K4Ln5GE%2BeieCo2f1OgYSu%2FUXtwTr1JkmhNgOmZYLPeAnCnMrYPD6LQll%2Bn%2BRnvrw%2BbVfwmBeXBLhFRUT1wRKrQeKOc5c%2Bl5dOAq6i72r6To8k%2BydaqyrmniFLOiO%2BBqCT8CcKxwlZ8FllBzXTN7Ph8%2BFUEaSWxQ8TLjbZByk1q9LAUYE2LnKmc0xcZzeJxUYHzDAvu0hkSpA1FHabJVcEbTT3I9N%2FnoN6mJT52utrPHmNUZ1Ww7lRf9mKS8o7sNlwVL19CrwDAJKhLaS%2BGP5X1LM9PIFLoBF5XbdWrMjcXoW73aBXbxSCxCggVEHoqOuJXvNxKgCjM1d6UM%2BNsM4BhW%2BUOZaGpdUPWwSgDq%2BC8tiPBY99kIZlMZoR%2F0Brp9S7lqfUFelsF7V%2F0j%2Fnvhj%2BOJO31GIyKTy%2FlSKk8hc0dpoLtRHQSHfVnzYRig%3D%3DA1bbe332b1&descValue1Z1041AV0325295726=&trackNums=1Z1041AV0325295726"); 
    $post.="\r\nConnection: close\r\n\r\n"; 
    $post.="$query"; 
    $h=fsockopen($host,443); 
    fwrite($h,$post); 
    for($a=0,$r='';!$a;){ 
      $b=fread($h,8192); 
      $r.=$b; 
      $a=(($b=='')?1:0); 
    } 
    fclose($h); 
    return $r; 
} 

// $txt = post("wcm.yonsei.ac.kr/haksa/sj/sj10_r020_1.jsp","strRet=start&hyhg=20091&master_id=640&sub_id=20","Cookie: USER_ID=".$userid."; IDEN_GB=1; AUTH_CODE=H7; CONTROL_CODE=; CAMPUS_GB=9; MASTER_ID=MASTER_ID; SUB_ID=SUB_ID;"); 
$txt = post (
    "wwwapps.ups.com/WebTracking/detail",
    "loc=en_US&USER_HISTORY_LIST=&progressIsLoaded=N&refresh_sii=&showSpPkgProg1=true&datakey=line1&HIDDEN_FIELD_SESSION=UjvC1bIlpu4B9zFt10GVj7ak6PKzsp14GqShABpV4VYBL3Dw4XpNaxe8NQzGtcKHjgju%2BhPhpxwcAJCBoN6%2BLRYB33HYFYY%2BAOvB3dAtxMrmS5IRf8LVpVPZ7%2F1VD5q%2FjELZd4BFhTg8H9VU3T74hZOaeHT8bYYw8%2BXpaPCEMHuufyFvWlqB4wx1Ra6CtcF83Du6Zz7XMCzH7JjJ%2FfCzprTgCvT1ZB5t6XJsXjq%2FNmcnAuTL9RDXojwlsyqOV4JCZsfkRXSo6PoK2wUpXI0AZFHTuJCYlUEkdDCdU1kC2hrmtKsL6BVCyiBs2KspH%2BlbVS50D%2F3H27ulrVcpRKTshz3c4z16qC2opDohsXFNpIitpyAcNKcdhxbkfQoxgHy66BmaKBvC799N9C5q4qB71cpzt7OaDBw%2BnUHptvyr8Hb9H8O%2FrLBM6ZVRgcDar3bWUYmcfFyTo4vqI7UkBVAy4xZABV4zWpMw93xIqgNKi%2FPi5T6CxRHxqUfo%2B52kLJ0ibRd1nbL5o4fvYK2DvIaWcn6RsazLW5OmOAq6s5UiAxzxqsyZ66y7qaCKR4qrGWtYfzF0CELzQrD9SBQGjya3vlVsEp%2BOadsMpcV%2B9eoovJAnieV7zlmE%2F4%2BvmxVQhcE37YDA%2BmBNFaEsnK30KzTEDoup1a3wy%2F%2Bw7LLhmPpOvVZs4y0z42G%2FryB29qVB8tcpxRQ1poSKgtmGn%2BIS4HRS07RdytscQHTkZxCYEdMZwytUD9fWRNyM73vFrOig7l9w5S3spkYqljLvPWsLciB8jdVv%2FVw6PZzCn1ewWbRk6DEbzkqELO6spHcg2oQi3YKVoYA5uNwUegSQzn6b2TQ7xuh8d7nKrGkSyOb0O5ec%2BU57yzptVi7ldr9GH4VvYVseMm4%2BHp6arS9AulS83HNIQBXgpO%2BD6dZ09iC4sbirtWYNcgt0g8IDImr1lrf%2BXZZE6TWCpP%2FDSWs6dNJQ9KWPDkyxkLJIjWtqO5l86azMR6Ze904d5lNYtzKuZ0t6E720tp%2BU3sCD5Z2vzFglDQjOwy%2BsNjSKctKhD%2BHKgJJ9cHKf6wHgfiEw0DVOZNNXz0UXjAi2l6EIxQsQamm2XMCbK%2BILdZXW8erNG%2BpPNrkVPf9kbpd6X6thgZx4fUcZteH%2BjR44t%2Fq%2FxRbbdiFDjtB9zjT8tSINsCmRcYO4gCcPWwYMlhp325o199gCNtnD6YveQk0EiMpeojfzEDETCXV5isTwX2jM%2F32mxLoAMO3fo3iQABgCz%2Fbqlun094AsZPHAw%2FmLksLsCKq%2ByokSLb9c1iQHgkw1bX9Jr3hNbazFP7UEwwna0EuJKpsiHaIM%2FNYEobn8saAoIcBT1J3FYXjqcGfOWb1waI%2BFMTGf6%2Brl0xIrFW1uUglBDUyMu2LESiSosC7xsgopG3F9cFT%2FWzTWGzsOxACYr7amlTImi2EGw%2FqIwJIzfd8z3ok3cIxYL%2F2k1eurQ0WdJO7G6xIcoqm0AR0b%2FhbOR2hcpIDeNZxwSH3IQUGHDvFiDQ95GAx9ta6DPrK0SB4rEFRWGL96nP2KmiJ6ZQl6bkj1YS%2Be%2BiDXCrD%2F8D6%2FvwI9Anjh6KVu2v3AbxraqnoeYx%2Ba3uVkuxQO3ia8QHM2YtdQPK4ROxAX%2FV%2F40gVVzapjCqCG4y6mQmpz4HWo9KdRaVXSnp6nV%2BRbjSBoA9qf8v%2FWHAFVVVmjg1V316%2BlD2yQnSr71jxGRnXUZbK%2BoERWV1rQ%2Bqg63W61pM1Ip2peM07suXC%2BFUMwbVgsuPqEp%2BBT%2Bk%2BVeKoPRrB7Q2KyVUBjzZxFybdyBLo7IbakYcPXd0tF6j5yEcjilAATIgmgzgeUgIP3JPU9hCEw9rlsPQCXzjQKJfFR0QTgw2fcgHQANxJ4fA3UEzSz64kmUCjIpdBqn%2BMeVyoghHKINS15d5Kn%2Fr63eUzQfjnAweeAIeQrwv77u5%2FyooiHnz2Z5AjVAtIfukq96f1kTiBSP7i5%2BzZfd3XpJ7DfF3MIkjxAQ%2B8K4Ln5GE%2BeieCo2f1OgYSu%2FUXtwTr1JkmhNgOmZYLPeAnCnMrYPD6LQll%2Bn%2BRnvrw%2BbVfwmBeXBLhFRUT1wRKrQeKOc5c%2Bl5dOAq6i72r6To8k%2BydaqyrmniFLOiO%2BBqCT8CcKxwlZ8FllBzXTN7Ph8%2BFUEaSWxQ8TLjbZByk1q9LAUYE2LnKmc0xcZzeJxUYHzDAvu0hkSpA1FHabJVcEbTT3I9N%2FnoN6mJT52utrPHmNUZ1Ww7lRf9mKS8o7sNlwVL19CrwDAJKhLaS%2BGP5X1LM9PIFLoBF5XbdWrMjcXoW73aBXbxSCxCggVEHoqOuJXvNxKgCjM1d6UM%2BNsM4BhW%2BUOZaGpdUPWwSgDq%2BC8tiPBY99kIZlMZoR%2F0Brp9S7lqfUFelsF7V%2F0j%2Fnvhj%2BOJO31GIyKTy%2FlSKk8hc0dpoLtRHQSHfVnzYRig%3D%3DA1bbe332b1&descValue1Z1041AV0325295726=&trackNums=1Z1041AV0325295726",
    "Cookie: WT_FPC=id=112.221.253.82-868809984.30522696:lv=1465412261698:ss=1465412181880; defaultHome=kr_ko_home|1464924625248; fsr.s=%7B%22v2%22%3A1%2C%22v1%22%3A1%2C%22cp%22%3A%7B%22cxreplayaws%22%3A%22true%22%7D%2C%22rid%22%3A%22d2e4e33-111582210-1dc1-fedd-c98ca%22%2C%22to%22%3A10%2C%22mid%22%3A%22d2e4e33-111582545-bc31-3030-1d203%22%2C%22rt%22%3Afalse%2C%22rc%22%3Afalse%2C%22c%22%3A%22https%3A%2F%2Fwwwapps.ups.com%2FWebTracking%2Ftrack%22%2C%22pv%22%3A2%2C%22lc%22%3A%7B%22d0%22%3A%7B%22v%22%3A2%2C%22s%22%3Atrue%7D%7D%2C%22cd%22%3A0%2C%22sd%22%3A0%2C%22f%22%3A1465462627215%7D; UPS_SHARED_SESSION=BLgISQiqubovpckGtZWmDVzTxAvNrA2LBeQClcR86gLsUFTy8W2iIbuVzyMV8KhZpf7XoNUNM9uD40iMtyc0/bCjhQIgeF7vTCd3sO7qgEoHReLrVQgYYnRGv+YTes0zT2RgYjUBjBZ9mKH4X20jWihuJsHrNirCgHmWA7YxoKEEpssP55yZy0swUF0f/YFcRboILIXf0V+7NapTzisY5xAzp0zl9VVC8fNO7GI9xnFBK2mK9tQLbcjWj9Qfv9fW+xojBS0huIwloKRWNlU66iSgy4V9zYOYZ8mDcQ910sR2Lwiu1N+U3chR7mbPzf5JrDeiTEi49p7r672FLPgq2sWblOhCDvxMyaAg2Dlyg7SgIPAFQmwOGXZBkrl6QBTWywmZYBDeRrqGz+BHfwzfbE79z58jWqeWViK7u0gVEBGGoNr7kGgmn2m0pDLfjvVOUJ2/d73d2bw/d61Y8dlGULjmZ0uyl20leQG+yv+Z+21p8gwSmNOcG3mn+jdd0oRqkpFcbaqUt0M40l40sZw/rsT+A/Fgw+cSVGtn29KYygYdiqu09cZ85QCsSZ/Hc8s3nxmxKkYksrWfaPRMmaMvBw8gj7TMi2X6bRyaB57OxIFd/actIEB4rmli2Te8GLvg/LlEfaV70YoItdRti7UvkvFDkG+SXCFugAXPLOad9MyAPUXH+bAa++t1d3OVNY2jR0aAbu9orBfXz8NP8CXxb0iefxoVyitux50FBUJfmj6AujsY5WQ5+A3e/Gj8HJv3eQ1NlkAr5CrxT8fTBMXPgKUhPeTTN2szCELTGDyif68=A1f78c0fe1"
); 

echo "<xmp>" . $txt . "</xmp>";

// wcm.yonsei.ac.kr/haksa/sj/sj10_r020_1.jsp 의 주소로 
// strRet=start&hyhg=20091&master_id=640&sub_id=20 을 POST 방식으로 
// Cookie: USER_ID=".$userid."; IDEN_GB=1; AUTH_CODE=H7; CONTROL_CODE=; CAMPUS_GB=9; MASTER_ID=MASTER_ID; SUB_ID=SUB_ID; 을 헤더로 
// fsockopen 을 호출 

?>