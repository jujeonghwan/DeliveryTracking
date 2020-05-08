<?php

$preview = "
    <th >th_title 1</th><td>td_content1 </td>
    <th>th_title 2</th><td>td_content2 </td>
";

// $preview_default = preg_replace('/<th>(.*)<\/th>/', "<code class=\"prettyprint\">$1</code>", $preview);
$preview_default = preg_replace('/<th(.*)<\/th>/', "", $preview);
echo "<xmp>". $preview_default . "</xmp>";
exit;

/*
a bunch of stuff <code>this that</code> and more stuff <code>with a second code block</code> then extra at the end
a bunch of stuff <code class="prettyprint">this that</code> and more stuff <code>with a second code block</code> then extra at the end
*/

$patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/',
                   '/^\s*{(\w+)}\s*=/');
$replace = array ('\3/\4/\1\2', '$\1 =');
echo preg_replace($patterns, $replace, '{startDate} = 1999-5-27');




preg_match_all('/<td([^<]+)<\/td>/', $str, $matches); 


foreach ($matches as $val) {
    echo "matched: " . $val[0] . "\n";
    echo "part 1: " . $val[1] . "\n";
    echo "part 2: " . $val[2] . "\n";
    echo "part 3: " . $val[3] . "\n";
    echo "part 4: " . $val[4] . "\n\n";
}
exit;

// echo "<xmp>". $temp1 . "</xmp>";
print_r($temp1);

/*



function get_html_data_td_only($str) {                      // html중 <td> 데이터만 구함
    $return_string = "";

    $content_temp = trim($str);

    $content_array          =   explode("<td>", $content_temp);
    $content_array_count    =   count($content_array);
    
    for ($i = 1; $i < $content_array_count; $i++) {

        $content_array2 =   explode("</td>", $content_array[$i]);
    
        $content_array3 =   explode("<tr class=\"info_row", $content_array2[0]);
    
    $content_array3_count   =   count($content_array3);
    
    for ($i = 1; $i < $content_array3_count; $i++) {
    // 줄바꿈을 " "로 변경
    $str = str_replace("\r\n", " ", $str);
    $str = str_replace("\r", " ", $str);
    $str = str_replace("\n", " ", $str);
    
    // 공백을 한개만 남김    
    $str = blank_one_only($str);

    // 태그를 제거
    // $str = strip_tags($str);
    
    $str = trim($str);
                
    return $str;
}

*/

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