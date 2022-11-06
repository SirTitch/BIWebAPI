<?php
require_once PROJECT_ROOT_PATH . "/model/databaseClass.php";
header('Access-Control-Allow-Origin: *'); 
class UserModel extends Database
{
    //Function gets the users, using the database class
    public function getCustomers( $search)
    {
        return $this->select("SELECT * FROM customer  WHERE customer_name LIKE ? ORDER BY customer_id ASC LIMIT 20", ["s", $search]);  
    }

    public function getPolicies($search)
    {
        return $this->select("SELECT * FROM policy JOIN customer ON policy.customer = customer.customer_id  WHERE policy_name LIKE ? ORDER BY policy_id ASC LIMIT 20", ["s", $search]);
    }

    public function getClient($search)
    {
        return $this->select("SELECT * FROM client c WHERE c.client_name LIKE ? ORDER BY c.client_id ASC LIMIT 20 ", ["s", $search]);
    }

    public function getClientPolocies($search, $orderBy)
    {
        return $this->select("SELECT * FROM client c JOIN client_policies cp ON c.client_id = cp.client_id JOIN policy p ON cp.policy_id = p.policy_id JOIN customer cr ON p.customer = cr.customer_id WHERE c.client_id LIKE ? ORDER BY + $orderBy ASC LIMIT 20 ", ["s", $search]);
    }

    public function getClientPolociesFilter($search, $orderBy, $filterBy, $filterValue, $paramForFilter)
    {
        return $this->select("SELECT * FROM client c JOIN client_policies cp ON c.client_id = cp.client_id JOIN policy p ON cp.policy_id = p.policy_id JOIN customer cr ON p.customer = cr.customer_id WHERE c.client_id LIKE ? AND + $filterBy LIKE ? ORDER BY + $orderBy ASC LIMIT 20 ", ["s" . $paramForFilter, $search, $filterValue]);
    }
}