<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

html_meta_charset_utf8();

exit;

// 디렉터리 삭제 (하위 파일 포함)
function remove_derctory($pathname) {
    if (!is_dir($pathname)) {
        return false;
    }

    echo "<br />pathname : " . $pathname;

    // 핸들 획득
    $dir_handle  = opendir($pathname);

    // 디렉터리에 포함된 파일을 저장한다.
    while (false !== ($filename = readdir($dir_handle))) {
        echo "<br />pathname filename : " . $pathname . "/" . $filename;

        if ($filename == "." || $filename == ".."){
            continue;
        }
     
        // 파일인 경우만 목록에 추가한다.
        if (is_file($pathname . "/" . $filename)){
            $files[] = $filename;
        }
    }

    // 핸들 해제 
    closedir($dir_handle);

    // 파일명을 출력한다.
    foreach ($files as $temp_file_name) {
        echo $temp_file_name;
        echo "<br />";

        // 파일 삭제
        unlink($pathname . "/" . $temp_file_name);

        break;
    }

    // 디렉터리 삭제
    $rmdir_result = rmdir($pathname);

    if ($rmdir_result) {
        return true;
    }
    else {
        return false;
    }
}





// 쿠키 파일 디렉터리 확인

$temp_date = "20170129";
$temp_path = $PATH_VAR["cookie_path"] . "/" . $temp_date;

echo "<br />temp_path : " . $temp_path;

$result_value = remove_derctory($temp_path);
echo "<br />result_value : " . $result_value;
exit;

/*
if (is_dir($temp_path)) {
    echo "<br />디렉터리 있음";

    // 핸들 획득
    $dir_handle  = opendir($temp_path);

    // 디렉터리에 포함된 파일을 저장한다.
    while (false !== ($filename = readdir($dir_handle))) {
        if($filename == "." || $filename == ".."){
            continue;
        }
     
        // 파일인 경우만 목록에 추가한다.
        if(is_file($temp_path . "/" . $filename)){
            $files[] = $filename;
        }
    }

    // 핸들 해제 
    closedir($dir_handle);


    // 파일명을 출력한다.
    foreach ($files as $temp_file_name) {
        echo $temp_file_name;
        echo "<br />";

        // 파일 삭제
        unlink($temp_path . "/" . $temp_file_name);

        break;
    } 


    // 디렉터리 삭제
    $rmdir_result = rmdir($temp_path);

    if ($rmdir_result) {
        echo "<br />디렉터리 삭제 성공";
    }
    else {
        echo "<br />디렉터리 삭제 실패";
    }

}
else {
    echo "<br />디렉터리 없음";
}

exit;

*/

/*
// 쿠키 파일 디렉터리 확인
check_directory ($PATH_VAR["cookie_path"]);
check_directory ($PATH_VAR["cookie_path"] . "/" . current_date());
$cookie_file_save_path = $PATH_VAR["cookie_path"] . "/" . current_date();
    
$cookie_file_name = current_datetime() . "_" . $deliverytype . "_cookie_" . urlencode($invoice_no) . ".txt";
$cookie_file = $cookie_file_save_path . "/" . $cookie_file_name;




// 택배사배송조회 수집파일 디렉터리 확인
check_directory ($PATH_VAR["deliverytracking_path"]);
check_directory ($PATH_VAR["deliverytracking_path"] . "/" . current_date());
$file_save_path = $PATH_VAR["deliverytracking_path"] . "/" . current_date();
    

// 결과 파일로 저장
$temp_file_name = current_datetime() . "_" . $deliverytype . "_" . urlencode($invoice_no);
$file = $file_save_path . "/" . $temp_file_name;

$fp2 = fopen($file, "w");
fputs($fp2, $data);
fclose($fp2);

// 파일 읽어서 파싱 DB입력
if (!file_exists($file)) {
    echo "파일이 없습니다.";   
}

$fp3    =   fopen($file, "r");
$text   =   fread($fp3, filesize($file));
fclose($fp3);
*/



?>