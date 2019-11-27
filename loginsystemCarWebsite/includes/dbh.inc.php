<?php
$dBServername = "quaadcars.co.uk.mysql";
$dBUsername = "quaadcars_co_uk";
$dBPassword = "Fku2iz6mwwrPUghNDnMghyCh";
$dBName = "quaadcars_co_uk";

// Create connection
$conn = mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
