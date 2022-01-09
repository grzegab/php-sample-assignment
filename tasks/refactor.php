<?php

$requestEmail = htmlentities($_REQUEST['email']);
$requestMasterEmail = htmlentities($_REQUEST["masterEmail"]);

$masterEmail = $requestEmail ?? $requestMasterEmail ?? 'unknown';

echo 'The master email is ' . $masterEmail . '\n';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "sldjfpoweifns", "my_database");

$query = sprintf("SELECT * FROM users WHERE email='%s'", $mysqli->real_escape_string($masterEmail));
$result = $mysqli->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        printf("%s\n", $row['username']);
    }
}