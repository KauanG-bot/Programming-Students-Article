<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:articleprogrammingstudents.database.windows.net,1433; Database = article", "CloudSAac6c2f7c", "{your_password_here}");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "CloudSAac6c2f7c", "pwd" => "{your_password_here}", "Database" => "article", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:articleprogrammingstudents.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>