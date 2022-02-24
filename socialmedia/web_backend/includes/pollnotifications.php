<?php
include "../../web_secure/session.php";

if ($_SERVER["REQUEST_METHOD"] === "GET" && $_SERVER["HTTP_REQUESTED_WITH"] === "SecuredConnectionOnly" && isset($_COOKIE["CUT"]) && isset($_COOKIE["CUI"]) && isset($_COOKIE["CULS"])) {
    include "class_loader.php";
    $ViewObject = new View();
    $ControlObject = new Control();
    $Result = $ViewObject->FetchNotificationRowDatas();
    if (!isset($_SESSION["lpt"])) {
        $_SESSION["lpt"] = 0;
        exit();
    } else {
        if ($Result !== false) {
            foreach ($Result as $ReceivedData) {


                if ((int)$ReceivedData[0] > (int)$_SESSION["lpt"]) {
                    if ($ReceivedData[2] === "Request") {
                        $_SESSION["lpt"] = (int)$ReceivedData[0];
                        
                        $getdata = $ViewObject->WhoSentRequests($ReceivedData[1], $_SESSION["USER_ID"]);

                        if ($getdata) {
                            $GetDate = new DateTime($getdata[0][5]);
                            $date = $GetDate->format('d-m-y');
                            echo "<div class='request_wrapper'>";
                            if ($getdata[0][4] === "No") {
                                echo "<audio autoplay style='display:none;opacity:0;width:0;height:0;'>";
                                echo "<source src='effects/tone.wav' type='audio/wav'>";
                                echo "</audio>";
                                $ControlObject->UpdateSound($_SESSION["lpt"], $ReceivedData[1]);
                            }
                            echo "<div class='wrap_data'>";
                            echo "<div class='profile_img'>";
                            echo "<img src='../../" . str_replace("../", "", $getdata[0][2]) . "'" . "alt=" . '" "' . "/>";
                            echo "</div>";

                            echo "<div class='profile_data'>";
                            if ($date === date('d-m-y')) {
                                echo "<p>" . $getdata[0][1] . " Sent You Friend Request <span>" . "Today " . $getdata[0][6] . "</span></p>";
                            } else if ($date > date('d-m-y')) {
                                echo "<p>" . $getdata[0][1] . " Sent You Friend Request <span>" . "Yesterday " . $getdata[0][6] . "</span></p>";
                               
                            }
                            echo "<div class='req_act'>";
                            echo "<form method='POST' id='reqact'>";
                            echo "<button type='button' id='acpt' data-id=" . $getdata[0][0] . ">Accept</button>";
                            echo "</form>";

                            echo "<form method='POST' id='reqrjt'>";
                            echo "<button type='button' id='rjrs' data-id=" . $getdata[0][0] . ">Reject</button>";
                            echo "</form>";

                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "went wrong";
                    }
                } else {
                    $getdata = $ViewObject->WhoSentRequests($ReceivedData[1], $_SESSION["USER_ID"]);
                    if ($ReceivedData[2] === "Request") {


                        if ($getdata) {
                            $GetDate = new DateTime($getdata[0][5]);
                            $date = $GetDate->format('d-m-y');
                            echo "<div class='request_wrapper'>";
                            if ($getdata[0][4] === "No") {
                                echo "<audio autoplay style='display:none;opacity:0;width:0;height:0;'>";
                                echo "<source src='effects/tone.wav' type='audio/wav'>";
                                echo "</audio>";
                                $ControlObject->UpdateSound($_SESSION["lpt"], $ReceivedData[1]);
                            }
                            echo "<div class='wrap_data'>";
                            echo "<div class='profile_img'>";
                            echo "<img src='../../" . str_replace("../", "", $getdata[0][2]) . "'" . "alt=" . '" "' . "/>";
                            echo "</div>";

                            echo "<div class='profile_data'>";
                            if ($date === date('d-m-y')) {
                                echo "<p>" . $getdata[0][1] . " Sent You Friend Request <span>" . "Today " . $getdata[0][6] . "</span></p>";
                            } else if ($date > date('d-m-y')) {
                                echo "<p>" . $getdata[0][1] . " Sent You Friend Request <span>" . "Yesterday " . $getdata[0][6] . "</span></p>";
                            }
                            echo "<div class='req_act'>";
                            echo "<form method='POST' id='reqact'>";
                            echo "<button type='button' id='acpt' data-id=" . $getdata[0][0] . ">Accept</button>";
                            echo "</form>";

                            echo "<form method='POST' id='reqrjt'>";
                            echo "<button type='button' id='rjrs' data-id=" . $getdata[0][0] . ">Reject</button>";
                            echo "</form>";

                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                }
            }
        } else {
            $_SESSION["lpt"] = 0;
            exit();
        }
    }
} else {
    header("location: ../../index.php");
    exit;
}
