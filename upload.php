<?php
header('Content-type: text/plain');

$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

if ($text == "") {
    // This is the first request. Show the main menu.
    $response  = "CON Welcome to My Service \n";
    $response .= "1. Check Balance \n";
    $response .= "2. Recharge";
} else if ($text == "1") {
    // User selected option 1. Display balance.
    $response = "END Your balance is $10";
} else if ($text == "2") {
    // User selected option 2. Prompt for recharge PIN.
    $response = "CON Enter your recharge PIN";
} else if (strpos($text, "2*") === 0) {
    // User entered the recharge PIN.
    $pin = substr($text, 2);
    // Process the PIN (this is just a simulation).
    $response = "END Your recharge PIN $pin has been accepted";
} else {
    $response = "END Invalid option";
}

echo $response;
?>
