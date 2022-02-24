<?php
//this class associated with fetching data
class View extends Model
{


    public function CheckEmailExists($email)
    {
        return $this->CheckEmailExist($email);
    }

    public function FetchUserDatas($email)
    {
        return $this->FetchUserData($email);
    }

    public function CountRowProfiles($Id)
    {
        return $this->FetchCountRowProfile($Id);
    }

    public function FetchProfilePic($UserId)
    {
        return $this->FetchProfilePicture($UserId);
    }

    public function FetchSecurityQue($UserId)
    {
        return $this->FetchSecurityQuestions($UserId);
    }

    public function FetchCountQuestions($UserId)
    {
        return $this->CountQuestion($UserId);
    }

    public function SearchedProfile($value)
    {
        return $this->SearchProfiles($value);
    }

    public function MyFriendList($CurrentUser, $to)
    {
        return $this->FriendLists($CurrentUser, $to);
    }

    public function ReallyIsMyFriend($CurrentUser, $frdid)
    {
        return $this->IsMyFriend($CurrentUser, $frdid);
    }

    public function FetchNotificationRowDatas()
    {
        return $this->FetchNotificationRowData();
    }

    public function WhoSentRequests($whosent, $whogot)
    {
        return $this->WhoSentRequest($whosent,$whogot);
    }
}
