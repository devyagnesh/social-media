<?php
class Database
{
    private $Host_Name = "localhost";
    private $Host_User = "snapters_admin";
    private $Host_Password = "1-Y9d#uQS7bV8o";
    private $Host_Selected_DB = "snapter_users";

    protected function Connect()
    {
        try {
            $DSN  = "mysql:host=" . $this->Host_Name . ";" . "dbname=" . $this->Host_Selected_DB;
            $Connection = new PDO($DSN, $this->Host_User, $this->Host_Password);
            $Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $Connection;
        } catch (PDOException $error) {
            die("Connection Failed !" . $error);
        }
    }
}
