<?php
class Model extends Database
{
    //This Function Will Insert Users Data (creating New Account)
    protected function RegisterUsers($firstname, $lastname, $email, $password, $dob, $gender)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ["cost" => 15]);
        $Query = "INSERT INTO users (Firstname,Lastname,Email,Password,Birthdate,Gender) VALUES (? , ? , ? , ? , ? , ?)";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $firstname);
        $Handler->bindParam(2, $lastname);
        $Handler->bindParam(3, $email);
        $Handler->bindParam(4, $hashedPassword);
        $Handler->bindParam(5, $dob);
        $Handler->bindParam(6, $gender);

        if ($Handler->execute() === true) {
            return true;
        } else if ($Handler->execute() !== true) {
            return false;
        }
    }

    // function will encrypt password


    //this function will check if email exist in database
    protected function CheckEmailExist($email)
    {
        $Query = "SELECT Email FROM users WHERE Email = ?;";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $email);
        $Handler->execute();

        if ($Handler->rowCount() >= 1) {
            return true;
        } else if ($Handler->rowCount() === 0) {
            return false;
        }
    }

    //this function will fetch all the user data where given email matches
    protected function FetchUserData($email)
    {
        $Query = "SELECT Id,Firstname,Lastname,Email,Password,Birthdate,Gender,OpeningDate FROM users WHERE Email = ?;";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $email);
        $Handler->execute();

        if ($Handler->rowCount() === 1) {
            $Datas = $Handler->fetch(PDO::FETCH_NUM);
            return $Datas;
        } else {
            return false;
        }
    }

    // this function will check profile if it is set or not
    protected function FetchCountRowProfile($Id)
    {
        $Query = "SELECT * FROM user_profile WHERE UserID = ?";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $Id);
        $Handler->execute();
        return $Handler->rowCount();
    }

    // this function will add profile picture data into database
    protected function AddProfilePicture($userId, $DestinationLocation)
    {
        $Query = "INSERT INTO user_profile (UserID , ProfileImage) VALUES (? , ?)";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $userId);
        $Handler->bindParam(2, $DestinationLocation);
        if ($Handler->execute() === true) {
            return true;
        } else {
            return false;
        }
    }

    // this function will fetch profile picture of user
    protected function FetchProfilePicture($UserId)
    {
        $Query = "SELECT user_profile.ProfileImage FROM user_profile RIGHT JOIN users ON user_profile.UserID = users.Id WHERE user_profile.UserID = ?";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $UserId);
        $Handler->execute();

        if ($Handler->rowCount() === 1) {
            return $Handler->fetch(PDO::FETCH_NUM);
        } else {
            return false;
        }
    }

    //this function will add security question 
    protected function AddSecurityQuestion($UserID, $Questions, $Answer)
    {
        $EncryotAnswer = password_hash($Answer, PASSWORD_BCRYPT, ["cost" => 15]);
        $Query = "INSERT INTO security_questions (UserID,Questions,Answers) VALUES (?, ?, ?)";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $UserID);
        $Handler->bindParam(2, $Questions);
        $Handler->bindParam(3, $EncryotAnswer);

        if ($Handler->execute() === true) {
            return true;
        } else {
            return false;
        }
    }

    //this function will fetch security questions data
    protected function FetchSecurityQuestions($userId)
    {
        $Query = "SELECT Questions , Answers FROM security_questions RIGHT JOIN users ON security_questions.UserID = users.Id WHERE users.Id = ?";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $userId);
        $Handler->execute();

        if ($Handler->rowCount() > 0) {
            return $Handler->fetch(PDO::FETCH_NUM);
        } else {
            return false;
        }
    }

    // this function will count rows of security_questions
    protected function CountQuestion($UserID)
    {
        $Query = "SELECT * FROM security_questions WHERE UserID = ?";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $UserID);
        $Handler->execute();

        return $Handler->rowCount();
    }

    //this function will fecth user name and matches
    protected function SearchProfiles($value)
    {
        $Query = "SELECT users.Id, CONCAT(users.Firstname,' ',users.Lastname) AS Username, user_profile.ProfileImage, users.OpeningDate FROM users RIGHT JOIN user_profile ON users.Id = user_profile.UserID WHERE (CONCAT(users.Firstname,' ',users.Lastname) LIKE ?) OR (users.Firstname LIKE ? OR users.Lastname LIKE ?) ORDER BY users.Firstname,users.Lastname,CONCAT( users.Firstname,' ',users.Lastname),CONCAT(users.Lastname,' ',users.Firstname) DESC;";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindValue(1, "%" . $value . "%");
        $Handler->bindValue(2, "%" . $value . "%");
        $Handler->bindValue(3, "%" . $value . "%");
        $Handler->execute();

        if ($Handler->rowCount() > 0) {
            return $Handler->fetchAll(PDO::FETCH_NUM);
        } else {
            return "notfound";
        }
    }

    // this function will fetch Friend Lists
    protected function FriendLists($CurrentUser, $to)
    {
        $Query = "SELECT users.Id, CONCAT(users.Firstname,' ',users.Lastname), user_profile.ProfileImage , friend_requests.Who_Sent, friend_requests.Who_Received , friend_requests.Request_Status FROM friend_requests ORDER BY users.Id , users.Firstname , users.Lastname DESC RIGHT JOIN users ON friend_requests.Who_Sent = users.Id LEFT JOIN user_profile ON users.Id = user_profile.UserID WHERE (friend_requests.Who_Sent = ? AND friend_requests.Who_Received = ?) AND (friend_requests.Request_Status = 'Friends');";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $CurrentUser);
        $Handler->bindParam(2, $to);
        $Handler->execute();

        if ($Handler->rowCount() === 1) {
            return $Handler->fetchAll(PDO::FETCH_NUM);
        } else {
            if ($Handler->rowCount() === (int)0) {
                return (int)0;
            }
        }
    }


    // this function will check if current user is friend of other users ?
    protected function IsMyFriend($CurrentUser, $frdid)
    {
        $Query = "SELECT friend_requests.Who_Sent , friend_requests.Who_Received , friend_requests.Request_Status FROM friend_requests WHERE (friend_requests.Who_Sent = ? OR friend_requests.Who_Received = ?) AND (friend_requests.Who_Sent = ? OR friend_requests.Who_Received = ?) AND friend_requests.Who_Sent != friend_requests.Who_Received";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $CurrentUser);
        $Handler->bindParam(2, $CurrentUser);
        $Handler->bindParam(3, $frdid);
        $Handler->bindParam(4, $frdid);
        $Handler->execute();

        if ($Handler->rowCount() === 1) {
            return $Handler->fetchAll(PDO::FETCH_NUM);
        } else {
            return false;
        }
    }

    //this function will add notification
    protected function AddNotifications($CurrentUser, $type, $Sounds, $time)
    {
        $Query = "INSERT INTO notifications(`UserId`,`Type`,`SoundPlayed`,`Time`) VALUES (?,?,?,?)";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $CurrentUser);
        $Handler->bindParam(2, $type);
        $Handler->bindParam(3, $Sounds);
        $Handler->bindParam(4, $time);

        if ($Handler->execute() === true) {
            return true;
        } else {
            return false;
        }
    }

    //this function will add friend
    protected function addFriend($CurrentUser, $PersonToBeAdd, $RequestedTime)
    {
        $Query = "INSERT INTO friend_requests (friend_requests.Who_Sent , friend_requests.Who_Received, friend_requests.Request_Status , friend_requests.Requested_Time) VALUES (? , ? , ?, ?)";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1, $CurrentUser);
        $Handler->bindParam(2, $PersonToBeAdd);
        $Handler->bindValue(3, "Pending");
        $Handler->bindValue(4, $RequestedTime);

        if ($Handler->execute() === true) {
            return true;
        } else {
            return false;
        }
    }

    //fetch notification data
    protected function FetchNotificationRowData()
    {
        $Query = "SELECT notifications.Id,notifications.UserId,notifications.Type,notifications.SoundPlayed,notifications.Time FROM notifications  ORDER BY notifications.Id DESC";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->execute();

        if ($Handler->rowCount() > 0) {
            return $Handler->fetchAll(PDO::FETCH_NUM);
        } else {
            return false;
        }
    }

    //this function will change sound status
    protected function ChangeSoundStatus($notid,$notuserid)
    {
        $Query = "UPDATE notifications SET notifications.SoundPlayed = 'Yes' WHERE notifications.Id = ? AND notifications.UserId = ?";
        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1,$notid);
        $Handler->bindParam(2,$notuserid);

        if($Handler->execute())
        {
            return true;
        }

        else
        {
            return false;
        }
    }

    //function to find who sent request to current user
    protected function WhoSentRequest($whosent,$whogot)
    {
        $Query = "SELECT users.Id,CONCAT(users.Firstname,' ',users.Lastname),user_profile.ProfileImage,notifications.Id,notifications.SoundPlayed,notifications.Dates,notifications.Time 
        FROM users RIGHT JOIN user_profile ON user_profile.UserID = users.Id 
        RIGHT JOIN friend_requests ON friend_requests.Who_Sent= users.Id 
        RIGHT JOIN notifications ON notifications.UserId = users.Id 
        WHERE friend_requests.Who_Sent = ? AND friend_requests.Who_Received = ? AND friend_requests.Request_Status = 'Pending';";

        $Handler = $this->Connect()->prepare($Query);
        $Handler->bindParam(1,$whosent);
        $Handler->bindParam(2,$whogot);

        if($Handler->execute())
        {
            if($Handler->rowCount() > 0)
            {
                return $Handler->fetchAll(PDO::FETCH_NUM);
            }

            else
            {
                return false;
            }
        }

        else
        {
            return false;
        }
    }
}
