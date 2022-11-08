<?php
require_once PROJECT_ROOT_PATH . "/model/databaseClass.php";
header('Access-Control-Allow-Origin: *'); 
class UserModel extends Database
{
    //Function gets the users, using the database class
    public function getCustomers( $search)
    {
        return $this->select("SELECT * FROM customer  WHERE customer_name LIKE ? ORDER BY customer_id ASC", ["s", $search]);  
    }

    public function getAllCustomers()
    {
        return $this->select("SELECT * FROM customer ORDER BY customer_id ASC", []);  
    }

    public function getPolicies($search)
    {
        return $this->select("SELECT * FROM policy JOIN customer ON policy.customer = customer.customer_id  WHERE policy_name LIKE ? ORDER BY policy_id ASC", ["s", $search]);
    }

    public function getAllPolicies()
    {
        return $this->select("SELECT * FROM policy JOIN customer ON policy.customer = customer.customer_id ORDER BY policy_id ASC", []);
    }

    public function getAllPoliciesFilter($search, $orderBy, $filterBy, $filterValue, $paramForFilter)
    {
        return $this->select("SELECT * FROM policy p JOIN customer cr ON p.customer = cr.customer_id WHERE + $filterBy LIKE ? ORDER BY p.policy_id ASC", [$paramForFilter, $filterValue]);
    }
    public function getClient($search)
    {
        return $this->select("SELECT * FROM client c WHERE c.client_name LIKE ? ORDER BY c.client_id ASC ", ["s", $search]);
    }

    public function getAllClients()
    {
        return $this->select("SELECT * FROM client c ORDER BY c.client_id ASC ", []);
    }

    public function getClientPolicies($search, $orderBy)
    {
        return $this->select("SELECT * FROM client c JOIN client_policies cp ON c.client_id = cp.client_id JOIN policy p ON cp.policy_id = p.policy_id JOIN customer cr ON p.customer = cr.customer_id WHERE c.client_id LIKE ? ORDER BY + $orderBy ASC", ["s", $search]);
    }

    public function getClientPoliciesFilter($search, $orderBy, $filterBy, $filterValue, $paramForFilter)
    {
        return $this->select("SELECT * FROM client c JOIN client_policies cp ON c.client_id = cp.client_id JOIN policy p ON cp.policy_id = p.policy_id JOIN customer cr ON p.customer = cr.customer_id WHERE c.client_id LIKE ? AND + $filterBy LIKE ? ORDER BY + $orderBy ASC", ["s" . $paramForFilter, $search, $filterValue]);
    }

    public function insertCustomer($customerArray)
    {
        return $this->insert("INSERT INTO customer ( customer_name, customer_address) VALUES ( ?, ? )", ["ss", $customerArray['customerName'], $customerArray["customerAddress"] ]);
    }

    public function insertPolicy($policyArray)
    {
        return $this->insert("INSERT INTO policy (  policy_type,
        policy_premium,
        insurer_name,
        customer) VALUES ( ?, ?, ?, ? )", ["sisi", $policyArray['policyType'], $policyArray["policyPremium"], $policyArray["insurerName"], $policyArray["customer"] ]);
    }
    public function insertClientPolicy($policyArray)
    {
        return $this->insert("INSERT INTO client_policies  (  client_id, policy_id) VALUES ( ?, ? )", ["ii", $policyArray["clientId"], $policyArray['policyId']  ]);
    }

    public function insertClient($clientArray)
    {
        return $this->insert("INSERT INTO client  (  client_name ) VALUES ( ? )", ["s", $policyArray["clientName"]  ]);
    }

    public function updatePolicy($policyArray)
    {
        return $this->update(" UPDATE policy
        SET 
            policy_type = ?,
            policy_premium  = ?,
            insurer_name  = ?,
            customer = ?
        WHERE policy_id = ?", ["sisii", $policyArray["policyType"], $policyArray['policyPremium'], $policyArray['insurerName'], $policyArray['customer'], $policyArray['policyId']]);
    }
}