<?php
require_once PROJECT_ROOT_PATH . "/Model/databaseClass.php";
 
class UserModel extends Database
{
    //Function gets the users, using the database class
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }
}