<?php


foreach (getallheaders() as $name => $value) {
    echo "<br />" . $name . " : " . $value;
}


?>