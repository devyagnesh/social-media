<?php
//this class associated with insert,update or delete operation
class Control extends Model
{
    public function RegisterUser($firstname, $lastname, $email, $password, $dob, $gender)
    {
        return $this->RegisterUsers($firstname, $lastname, $email, $password, $dob, $gender);
    }

    public function SetProfile($userId, $DestinationLocation)
    {
        return $this->AddProfilePicture($userId, $DestinationLocation);
    }

    public function AddSecurityQue($UserID, $Questions, $Answer)
    {
        return $this->AddSecurityQuestion($UserID, $Questions, $Answer);
    }

    public function SendRequest($CurrentUser, $PersonToBeAdd, $RequestedTime)
    {
        return $this->addFriend($CurrentUser, $PersonToBeAdd, $RequestedTime);
    }

    public function AddNotification($CurrentUser, $type, $sounds, $time)
    {
        return $this->AddNotifications($CurrentUser, $type, $sounds, $time);
    }

    public function UpdateSound($notid, $userid)
    {
        return $this->ChangeSoundStatus($notid,$userid);
    }
}
