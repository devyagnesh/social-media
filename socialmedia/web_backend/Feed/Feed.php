<?php
include "../../web_secure/session.php";
include "../../web_secure/TokenGen.php";

if (((!isset($_SESSION["LogedIN"])) && (!$_SESSION["LogedIN"] === true)) && (!isset($_SESSION["Current_User_Token"]) && (!isset($_COOKIE["CUT"])) && ($_COOKIE["CUT"] !== bin2hex($_SESSION["Current_User_Token"])) && (!isset($_SESSION["USER_ID"])) && (!isset($_COOKIE["CUI"])) && ($_COOKIE["CUI"] !== bin2hex($_SESSION["USER_ID"])) && (!isset($_SESSION["User"])))) {
    header("location: ../../index.php");
    exit();
} else {
    include "../includes/class_loader.php";
    $UserDataObject = new View();
    $UserData = $UserDataObject->FetchUserDatas($_SESSION["User"]);
    $UserPicture = $UserDataObject->FetchProfilePic($_SESSION["USER_ID"]);
    $OriginalPath = str_replace("../", "", $UserPicture);
    $UserFullName = $UserData[1] . " " . $UserData[2];
    $ProfileLink = explode("/profile", $OriginalPath[0])[0];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='shortcut icon' type='image/x-icon' href='../Assest/favicon.ico' />
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <title><?php echo "Welcome " . ucwords($UserFullName) ?></title>
    </head>

    <body>
        <header id="header">
            <nav class="nav___header" id="nav">
                <div class="logo___nav">
                    <a href="../../index.php">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 98.14 100" width="45" height="45">
                            <g id="Layer_2" data-name="Layer 2">
                                <g id="Layer_1-2" data-name="Layer 1">
                                    <path class="cls-1" d="M38.22,90.93A19.54,19.54,0,0,1,21,80.59L8.73,57.77a19.56,19.56,0,0,1,0-18.5L21,16.45A19.56,19.56,0,0,1,38.22,6.11H59.93A19.56,19.56,0,0,1,77.19,16.45L89.41,39.27a19.51,19.51,0,0,1,0,18.5L77.19,80.59A19.54,19.54,0,0,1,59.93,90.93Z" />
                                    <path class="cls-2" d="M59.93,8.11a17.56,17.56,0,0,1,15.5,9.29L87.65,40.22a17.51,17.51,0,0,1,0,16.6L75.43,79.64a17.56,17.56,0,0,1-15.5,9.29H38.22a17.57,17.57,0,0,1-15.51-9.29L10.49,56.82a17.56,17.56,0,0,1,0-16.6L22.71,17.4A17.57,17.57,0,0,1,38.22,8.11H59.93m0-4H38.22a21.57,21.57,0,0,0-19,11.4L7,38.33A21.58,21.58,0,0,0,7,58.71L19.19,81.53a21.57,21.57,0,0,0,19,11.4H59.93a21.59,21.59,0,0,0,19-11.4L91.18,58.71a21.58,21.58,0,0,0,0-20.38L79,15.51a21.59,21.59,0,0,0-19-11.4Z" />
                                    <path class="cls-1" d="M62.13,4a17.55,17.55,0,0,1,15.5,9.28L92.06,40.22a17.56,17.56,0,0,1,0,16.6L77.63,83.76A17.55,17.55,0,0,1,62.13,93H36a17.56,17.56,0,0,1-15.5-9.28L6.08,56.82a17.56,17.56,0,0,1,0-16.6L20.51,13.28A17.56,17.56,0,0,1,36,4H62.13m0-4H36A21.59,21.59,0,0,0,17,11.4L2.56,38.33a21.58,21.58,0,0,0,0,20.38L17,85.65A21.6,21.6,0,0,0,36,97H62.13a21.6,21.6,0,0,0,19-11.39L95.58,58.71a21.58,21.58,0,0,0,0-20.38L81.16,11.4A21.59,21.59,0,0,0,62.13,0Z" /><text class="cls-3" transform="translate(25.22 75.33) scale(0.93 1)">S</text>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>

                <div class="searchbar___nav">
                    <form action="" method="post" autocomplete="off">
                        <span class="material-icons">search</span>
                        <input type="text" name="searchaction" id="searchaction" class="search-input" placeholder="Search Profiles">


                    </form>
                    <div class="search-result-container src-hide max-height-45 scrollY hideScrollY">

                    </div>
                </div>

                <div class="usertabs___nav">
                    <div class="wrap">
                        <div class="home tab-sm">
                            <a href="<?php echo 'Feed.php?Hash=' . $_SESSION["Current_User_Token"]; ?>" class="active-tab">
                                <span class="material-icons material-icons-outlined">
                                    home
                                </span>
                            </a>
                        </div>

                        <div class="friends tab-sm">
                            <a href="#">
                                <span class="material-icons material-icons-outlined">
                                    group_work
                                </span>
                            </a>
                        </div>

                        <div class="messages tab-sm">
                            <a href="#">
                                <span class="material-icons material-icons-outlined">
                                    sms
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="userprofile___nav">
                    <div class="user-profile-pics">
                        <a href="<?php echo "../../users/profile.php?Id=" . $_SESSION["USER_ID"]; ?>">
                            <div class="img">
                                <img src="<?php echo '../../' . $OriginalPath[0]; ?>" alt="" />
                            </div>
                            <div class="username">
                                <h5><?php echo $UserData[1]; ?></h5>
                            </div>
                        </a>
                    </div>

                    <div class="wrap-others">
                        <div class="sm-nav notifications___nav">
                            <div class="sm-profile-tab notification">
                                <span class="notify-alert"></span>
                                <button type="button" id="notification-button" class="hover-states">
                                    <span class="material-icons-outlined">
                                        notifications
                                    </span>
                                </button>
                                <div class="noti-list hide scrollY max-height-45" id="notifyme">

                                </div>
                            </div>
                        </div>

                        <div class="sm-nav settings__nav">
                            <div class="sm-profile-tab settings">
                                <button type="button" id="settings-button" class="hover-states">
                                    <span class="material-icons-outlined">
                                        settings
                                    </span>
                                </button>
                                <span class="notify-alert no-display"></span>
                                <div class="noti-list hide setting" id="mysettings">
                                    <div class="quick__setting">
                                        <div class="setting__icon">
                                            <span class="material-icons-outlined">
                                                vpn_key
                                            </span>
                                        </div>
                                        <a href="<?php $_SESSION["pwd_change"] = md5(bin2hex("change"));
                                                    echo "../../users/profile.php?hash=" . $_SESSION["pwd_change"] . "&Id=" . $_SESSION["USER_ID"] ?>">Change Password</a>
                                    </div>

                                    <div class="quick__setting">
                                        <div class="setting__icon">
                                            <span class="material-icons-outlined">
                                                edit
                                            </span>
                                        </div>
                                        <a href="<?php $_SESSION["edit_profile"] = md5(bin2hex("change"));
                                                    echo "../../users/profile.php?hash=" . $_SESSION["edit_profile"] . "&Id=" . $_SESSION["USER_ID"] ?>">Edit Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sm-nav others__nav">
                            <div class="sm-profile-tab others">
                                <button type="button" id="others-button" class="hover-states">
                                    <span class="material-icons-outlined">
                                        expand_more
                                    </span>
                                </button>
                                <div class="noti-list prof hide" id="myothersettings">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    </body>
    <script src="js/app.js"></script>
    <script src="js/follow.js"></script>
    <script defer src="js/sp.js"></script>
    <script src="js/polls.js"></script>

    </html>
<?php
}
?>