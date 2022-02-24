<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='shortcut icon' type='image/x-icon' href='../../Assest/favicon.ico' />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <title>STEP 1 : Setup Profile Picture</title>
</head>

<body>

    <?php
    include "../../../web_secure/session.php";
    include_once "../../includes/class_loader.php";


    if ((isset($_SESSION["Second_Stage"]) && $_SESSION["Second_Stage"] === (int)1) && (isset($_GET["Hash"]) && $_GET["Hash"] === $_SESSION["hash"])) {
        $UserIdObj = new View();
        $ProfileData = $UserIdObj->FetchUserDatas($_SESSION["User"]);
        $_SESSION["USER_ID"] = $ProfileData[0];

        $CountRow = $UserIdObj->CountRowProfiles($_SESSION["USER_ID"]);

        if ($CountRow === 1) {
            header("Location: ../Step2/Security_Quetions.php");
            exit();
        } else {
    ?>

            <div class="container">
                <div class="step-1-wrapper">
                    <div class="main-profile-wrapper">
                        <div class="profile-image">
                            <img src="profile_image/Female.png" alt="" />
                        </div>

                        <div class="profile-full-name m-40">
                            <h2>
                                <?php
                                echo  $ProfileData[1] . " " . $ProfileData[2];
                                echo "<p style='margin:1rem 0 0 0;font-size:1.7rem;font-weight:400;'>Set New Profile Picture</p>";
                                ?>
                            </h2>
                        </div>

                        <div class="profile_update_button">
                            <form action="" method="post" enctype="multipart/form-data">
                                <label for="ProfileFile" class="profile-uploader">
                                    <span class="material-icons">file_upload</span>
                                    <span class="text-material">Set Profile Picture</span>
                                    <input type="file" name="ProfileFile" id="ProfileFile" class="Profile-updater" />
                                </label>
                                <button type="submit" name="Profile-updater-btn" id="Profile-updater-btn" class="profile-updaterBtn">Next<span class="material-icons">arrow_forward </span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</body>

</html>
<?php

        }
    } else {
        $_SESSION["Second_Stage"] = false;
        header("location:../../../index.php");
        exit();
    }
