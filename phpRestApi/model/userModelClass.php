<?php
require_once PROJECT_ROOT_PATH . "/Model/databaseClass.php";
header('Access-Control-Allow-Origin: *'); 
class UserModel extends Database
{
    //Function gets the users, using the database class
    public function getCustomers($limit)
    {
        return $this->select("SELECT * FROM customer ORDER BY customer_id ASC LIMIT ?", ["i", $limit]);  
    }

    public function getPolicies($limit)
    {
        return $this->select("SELECT * FROM policy JOIN customer ON policy.customer = customer.customer_id  ORDER BY policy_id ASC LIMIT ?", ["i", $limit]);
    }

    public function getClient($limit)
    {
        return $this->select("SELECT * FROM client c JOIN client_policies cp ON c.client_id = cp.client_id JOIN policy p ON cp.policy_id = p.policy_id ORDER BY c.client_id ASC LIMIT ?", ["i", $limit]);
    }
}