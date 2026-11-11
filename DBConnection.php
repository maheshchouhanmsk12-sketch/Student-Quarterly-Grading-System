<?php
Class DBConnection{
    protected $db;
    function __construct(){
        $host = getenv('DB_HOST') ?: (getenv('MYSQLHOST') ?: 'localhost');
        $user = getenv('DB_USER') ?: (getenv('MYSQLUSER') ?: 'root');
        $password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : (getenv('MYSQLPASSWORD') !== false ? getenv('MYSQLPASSWORD') : '');
        $dbname = getenv('DB_NAME') ?: (getenv('MYSQLDATABASE') ?: 'sqgs_db');
        $port = getenv('DB_PORT') ?: (getenv('MYSQLPORT') ?: 3306);

        // Support for full Aiven/Cloud Service URI (e.g., mysql://user:pass@host:port/dbname)
        $conn_url = getenv('DATABASE_URL') ?: getenv('MYSQL_URL');
        if (!empty($conn_url)) {
            $parsed = parse_url($conn_url);
            if ($parsed) {
                if (isset($parsed['host'])) $host = $parsed['host'];
                if (isset($parsed['port'])) $port = $parsed['port'];
                if (isset($parsed['user'])) $user = $parsed['user'];
                if (isset($parsed['pass'])) $password = $parsed['pass'];
                if (isset($parsed['path'])) $dbname = ltrim($parsed['path'], '/');
            }
        }

        $this->db = mysqli_init();
        if (!$this->db) {
            die("mysqli_init failed");
        }

        // Enable SSL for cloud databases (like Aiven)
        $is_remote = ($host !== 'localhost' && $host !== '127.0.0.1');
        $use_ssl = getenv('DB_SSL') !== false ? filter_var(getenv('DB_SSL'), FILTER_VALIDATE_BOOLEAN) : $is_remote;

        if ($use_ssl) {
            $this->db->ssl_set(NULL, NULL, NULL, NULL, NULL);
            $flags = MYSQLI_CLIENT_SSL;
            if (defined('MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT')) {
                $flags |= MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
            }
            @$this->db->real_connect($host, $user, $password, $dbname, (int)$port, NULL, $flags);
        } else {
            @$this->db->real_connect($host, $user, $password, $dbname, (int)$port);
        }

        if ($this->db->connect_errno) {
            die("Database Connection Failed. Error (" . $this->db->connect_errno . "): " . $this->db->connect_error);
        }
    }
    function db_connect(){
        return $this->db;
    }
    function __destruct(){
        if ($this->db) {
            $this->db->close();
        }
    }
}
function format_num($number = '', $decimal=''){
    if(is_numeric($number)){
        $ex = explode('.',$number);
        $dec_len = isset($ex[1]) ? strlen($ex[1]) : 0;
        if(is_numeric($decimal)){
            return number_format($number,$decimal);
        }else{
            return number_format($number,$dec_len);
        }
    }else{
        return 'Invalid Input';
    }
}
$database = new DBConnection();
$conn= $database->db_connect();
