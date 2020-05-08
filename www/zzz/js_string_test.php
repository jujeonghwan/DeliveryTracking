<?php

/*
$str = '\uBC30\uC1A1';

function codepoint_decode($str) {
        return json_decode(sprintf('"%s"', $str));
    }
    
var_dump(codepoint_decode('\uBC30\uC1A1'));
*/
    
$str = "\uBC30\uC1A1 \uC644\uB8CC\u003a 11\u002f05\u002f2016 14\u003a49 \uC11C\uBA85\uC790\u003aS.ONGYOUNGKWON\u003b SEOUL,KR";
// echo    json_decode(sprintf('"%s"', $str));

echo    json_decode(sprintf('"%s"', $str));

/*
$str = '\uBC30\uC1A1';

$tmp = iconv('utf-8', 'euc-kr', urldecode($string)); 

echo $tmp;

exit;


echo json_decode($string);


$string = preg_replace('/%u([0-9A-F]+)/', '&#x$1;', $string);
// echo html_entity_decode($string, ENT_COMPAT, 'UTF-8');
echo html_entity_decode("\uBC30\uC1A1", ENT_COMPAT, 'UTF-8');

*/

/*
$str = iconv("UTF-8", "EUC-KR", "\uBC30\uC1A1");

$str = rawurldecode("\uBC30\uC1A1");
echo urlencode(iconv("euc-kr","utf-8","가"));
echo $str;
exit;
*/

/*
function js_string_escape($data)
{
    $safe = "";
    for($i = 0; $i < strlen($data); $i++)
    {
        if(ctype_alnum($data[$i]))
            $safe .= $data[$i];
        else
            $safe .= sprintf("\\x%02X", ord($data[$i]));
    }
    return $safe;
}


echo rawurlencode("배송");


$str = "\uBC30\uC1A1 \uC644\uB8CC\u003a 11\u002f05\u002f2016 14\u003a49 \uC11C\uBA85\uC790\u003aS.ONGYOUNGKWON\u003b SEOUL,KR";

echo rawurldecode($str);

exit;
*/




/*

function tostring($text){
return iconv('UTF-16LE', 'UHC', chr(hexdec(substr($text[1], 2, 2))).chr(hexdec(substr($text[1], 0, 2))));
}

function urlutfchr($text){
return urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', 'tostring', $text));
}


$str = "\uBC30\uC1A1 \uC644\uB8CC\u003a 11\u002f05\u002f2016 14\u003a49 \uC11C\uBA85\uC790\u003aS.ONGYOUNGKWON\u003b SEOUL,KR";

// $decoded = urlutfchr("%uD1A0%uC775%uC810%uC218");
// Variable $decoded contains value "토익점수";

$decoded = urlutfchr($str);
echo $decoded;
*/


?>