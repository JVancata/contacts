<?php
require_once 'autoload.php';

class Database {
    private $dbserver = DATABASESERVER;
    private $dbname = DATABASENAME;
    private $dbuser = DATABASEUSER;
    private $dbpass = DATABASEPASSWORD;
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO(
                "mysql:host=" . $this->dbserver . ";dbname=" . $this->dbname . ";",
                $this->dbuser,
                $this->dbpass,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8",
                )
            );
            if (!PRODUCTION) {
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
        } catch (Exception $e) {
            if (!PRODUCTION) {
                print_r($e);
            }
            echo "Db connection error";
            exit();
        }
    }

    /**
     * @param string $query SQL Query, parameters are used like this: :username
     * @param array|null $parameterArray associative array of parameters - array(":username"=>$username)
     * @return any resulting query data with PDO::FETCH_ASSOC
     */

    public function fetchOne($query, $parameterArray) {
        $prepared = $this->db->prepare($query);
        $prepared->execute($parameterArray);
        $values = $prepared->fetch(PDO::FETCH_ASSOC);

        return $values;
    }
    
    public function fetchAll($query, $parameterArray) {
        $prepared = $this->db->prepare($query);
        $prepared->execute($parameterArray);
        $values = $prepared->fetchAll(PDO::FETCH_ASSOC);

        return $values;
    }
}
