<?php
// header("Content-Type: application/json");
include "../../web_secure/session.php";
if (($_SERVER["REQUEST_METHOD"] === "POST") && ($_SERVER["HTTP_REQUESTED_WITH"] === "SecuredConnectionOnly")) {
    $JsonFormattedValue = stripslashes(file_get_contents("php://input"));
    $GetValue = json_decode($JsonFormattedValue, true);
    include "class_loader.php";
    $SearchObject = new View();
    $FetchedData = $SearchObject->SearchedProfile($GetValue["SearchValue"]);



    if ($FetchedData !== "notfound") {

        if (is_null($FetchedData) === false) {

            foreach ($FetchedData as $ReceivedData) {
                $ProfilePath = str_replace("../", "", $ReceivedData[2]);

                echo "<div class='result___wrapper'>"; // result wrapper starts from here
                echo "<div class='result-profile-wrapper'>"; // result profile wrapper starts from here
                echo "<img src='../../" . $ProfilePath . "'style='width:5.5rem;height:5.5rem;' />";
                echo "</div>"; // result profile wrapper ends here

                echo "<div class='profile-info'>"; // profile information starts from here
                echo "<div class='profile-username'>"; // profile username starts from here
                echo "<a href='../../users/profile.php?id=" . $ReceivedData[0] . "' class='links-searched'>";
                echo $ReceivedData[1];
                echo "</a>";
                if ($ReceivedData[0] === $_SESSION["USER_ID"] || $ReceivedData[0] === hex2bin($_COOKIE["CUI"])) {
                    echo "<p>You <span>Created at " . date("d/m/Y", strtotime($ReceivedData[3])) . "</span></p>";
                }
                echo "</div>"; //profile username ends here

                echo "<div class='request-actions'>"; //request action starts from here
                if ($ReceivedData[0] !== $_SESSION["USER_ID"] || $ReceivedData[0] !== hex2bin($_COOKIE["CUI"])) {
                    $FriendStatus = $SearchObject->ReallyIsMyFriend($_SESSION["USER_ID"], $ReceivedData[0]);
                    if ($FriendStatus === false) {
                        echo "<div class='btns'><button type='button' name='add-friend-btn' id='add-friend-btn' class='btn-add-btn btn-add-btn-stat-hover' data-vals='" . $ReceivedData[0] . "'>Follow</button></div>";
                    } else {
                        if (($FriendStatus[0][0] === $ReceivedData[0] || $FriendStatus[0][1] === $ReceivedData[0]) && $FriendStatus[0][2] === "Friends") {
                            echo "<p class='status-class' style='font-size:1.2rem;font-weight:600;font-family:'.'Montserrat'.''>Your Friend</p>";
                        } else if (($FriendStatus[0][0] === $ReceivedData[0] || $FriendStatus[0][1] === $ReceivedData[0]) && $FriendStatus[0][2] === "Pending") {
                            echo "<p class='status-class' style='font-size:1.2rem;font-weight:600;font-family:'.'Montserrat'.''>Request Sent</p>";
                        } else {
                            echo "<div class='btns'><button type='button' name='add-friend-btn' id='add-friend-btn' class='btn-add-btn btn-add-btn-stat-hover' data-vals='" . $ReceivedData[0] . "'>Follow</button></div>";
                        }
                    }
                }
                echo "</div>"; // request action ends here


                echo "</div>"; // profile information ends here
                echo "</div>"; //result wrapper closes here
                echo "</div>";
            }
        }
    } else {
        echo "<h4 style='text-align:center;margin-top:2rem;font-size:2rem;display:flex;align-items:center;justify-content:center;'><span class='material-icons-outlined' style='padding:1rem;border-radius:50%;background-color:#f0f2f5;margin-right:2rem;color:#8D949E;'>search</span><span style='color:#ddd'>0 Result Found</span></h4>";
    }
} else {
    header("location: ../../index.php");
    exit();
}
