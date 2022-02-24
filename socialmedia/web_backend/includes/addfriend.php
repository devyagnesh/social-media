<?php
include "../../web_secure/session.php";
include "../../web_secure/TokenGen.php";

function SendRequestData($user, $to)
{
    date_default_timezone_set("asia/kolkata");
    $CurrentTime = date("h:ma");

    $ControlObject = new Control();
    $AddNotification = $ControlObject->AddNotification($_SESSION["USER_ID"], "Request", "No", $CurrentTime);



    if ($AddNotification === true) {
        $Added = $ControlObject->SendRequest($user, $to, $CurrentTime);

        if ($Added === true) {
            echo json_encode("Request has been sent", true);
            exit();
        } else {
            echo json_encode("Coudn't Send Request", true);
            exit();
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_SERVER["HTTP_REQUESTED_WITH"] === "SecuredConnectionOnly") {
    $JsonFormattedValue = stripslashes(file_get_contents("php://input"));
    $GetValue = json_decode($JsonFormattedValue, true);
    include "class_loader.php";
    $GetViewObject = new View();
    $FrienshipStatus = $GetViewObject->ReallyIsMyFriend($_SESSION["USER_ID"], $GetValue["personID"]);

    if ($FrienshipStatus !== false) {
        if ($FrienshipStatus[0][0] === $_SESSION["USER_ID"] && $FrienshipStatus[0][1] === $_SESSION["USER_ID"]) {
            echo json_encode("Invalid Request", true);
            exit();
        } else if (($FrienshipStatus[0][0] === $_SESSION["USER_ID"] && $FrienshipStatus[0][1] === $GetValue["personID"] && $FrienshipStatus[0][2] === "Pending") || ($FrienshipStatus[0][0] === $GetValue["personID"] && $FrienshipStatus[0][1] === $_SESSION["USER_ID"] && $FrienshipStatus[0][2] === "Pending")) {
            echo json_encode("Request Sent", true);
            exit();
        } else {
            SendRequestData($_SESSION["USER_ID"], $GetValue["personID"]);
        }
    } else {
        SendRequestData($_SESSION["USER_ID"], $GetValue["personID"]);
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] !== "POST" || $_SERVER["HTTP_REQUESTED_WITH"] !== "SecuredConnectionOnly") {
        header("location: ../../index.php");
        exit();
    }
}
