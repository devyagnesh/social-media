<?php
include "../../../web_secure/session.php";
include "../../../web_secure/TokenGen.php";
if ((isset($_SESSION["Second_Stage"]) && $_SESSION["Second_Stage"] === 2) && (isset($_GET["Hash"]) && $_GET["Hash"] === $_SESSION["SqHash"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <title>Step 2 : Add Security Question</title>
    </head>

    <body>
        <div id="container">
            <div id="wrapper">

                <?php
                include "../../includes/class_loader.php";
                $GetProfileData = new View();
                $ProfileData = $GetProfileData->FetchUserDatas($_SESSION["User"]);
                $UserName = $ProfileData[1] . " " . $ProfileData[2];
                $ProfileImage = $GetProfileData->FetchProfilePic($_SESSION["USER_ID"]);
                $OriginalProfileDestination = str_replace("../", "", $ProfileImage[0]);
                echo " <div class='profile___image'>";
                echo "<img src='" . "../../../" . $OriginalProfileDestination . "' />";
                echo " </div>";
                ?>

                <h4 class="uname">
                    <?php
                    echo $UserName;
                    ?>
                </h4>

                <div class="title">
                    <h2>Add Security Question</h2>
                    <p>This Will Help You While Account Recovery Process</p>
                </div>

                <div class="questions__wrapper">
                    <form action="../steps_backend/set_security_question.php" method="post">
                        <select class='sq' name="security_perform">
                            <option value="What Is Your Cousin Name ?">What Is Your Cousin Name ?</option>
                            <option value="What Is Your Hobby ?">What Is Your Hobby ?</option>
                            <option value="Which Food Do You Like The Most ?">Which Food Do You Like The Most ?</option>
                            <option value="Last Place That You Have Visited ?">Last Place That You Have Visited ?</option>
                            <option value="What Is Your Childhood Name ?">What Is Your Childhood Name ?</option>
                        </select>

                        <input type="text" name="sq_answer" id="sq_answer" class="sqAnswer" placeholder="Add Your Answer" />
                        <button type="submit" name="sqa_submit" id="sqa_submit" class="btn_sqa">Next<span class="material-icons">arrow_forward </span></button>
                        <input type="hidden" name="token" value="<?php $_SESSION["Sq_Token"] = TokenGenerate();
                                                                    echo $_SESSION['Sq_Token']; ?>" />
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
    if (isset($_SESSION["tmpFemale"]) && $_SESSION["tmpFemale"] === "Female") {

        header("location: ../Step1/Female.php");
    } else {

        header("location: ../Step1/Male.php");
    }
}

?>