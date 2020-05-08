<?php

$server="211.115.92.212:1433";
$username="A_BASEZONE_ABO";
$password="dpdlqldhdkqhzltmxm";
$sqlconnect=mssql_connect($server, $username, $password);
$sqldb=mssql_select_db("A_BASEZONE_ABO",$sqlconnect);

$sqlquery="SELECT TOP 5 CONNECTION_CODE, CONNECTION_NAME FROM B_CONNECTION";

$results= mssql_query($sqlquery);
while ($row=mssql_fetch_array($results)){
    echo $row['CONNECTION_CODE']."<br>\n";
    echo $row['CONNECTION_NAME']."<br>\n";

}
mssql_close($sqlconnect);

?>