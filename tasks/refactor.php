<?php

$requestEmail = $_REQUEST['email'] ?? null;
$requestMasterEmail = $_REQUEST["masterEmail"] ?? null;

$masterEmail = $requestEmail ?? $requestMasterEmail ?? 'unknown';

echo 'The master email is ' . $masterEmail . '\n';

$conn = mysqli_connect('localhost', 'root', 'sldjfpoweifns', 'my_database');
$res = mysqli_query($conn, "SELECT * FROM users WHERE email='" . $masterEmail . "'");
$row = mysqli_fetch_row($res);

echo $row['username'] . "\n";