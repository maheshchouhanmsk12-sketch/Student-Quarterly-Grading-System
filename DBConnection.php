<?php
Class DBConnection{
    protected $db;
    function __construct(){
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $dbname = 'sqgs_db';
        $port = 3306;

        // 1. Support for full Aiven/Cloud Service URI (e.g., mysql://user:pass@host:port/dbname)
        $conn_url = getenv('DATABASE_URL') ?: (getenv('MYSQL_URL') ?: getenv('JAWSDB_URL'));
        if (!empty($conn_url)) {
            // Regex handles special characters in passwords (e.g. #, @, $, etc.) safely
            if (preg_match('/^mysql(?:i)?:\/\/([^:]+):(.*)@([^:\/]+)(?::(\d+))?\/(.+?)(?:\?.*)?$/', $conn_url, $m)) {
                $user = urldecode($m[1]);
                $password = urldecode($m[2]);
                $host = $m[3];
                $port = !empty($m[4]) ? (int)$m[4] : 3306;
                $dbname = $m[5];
            } else {
                $parsed = parse_url($conn_url);
                if ($parsed) {
                    if (isset($parsed['host'])) $host = $parsed['host'];
                    if (isset($parsed['port'])) $port = (int)$parsed['port'];
                    if (isset($parsed['user'])) $user = urldecode($parsed['user']);
                    if (isset($parsed['pass'])) $password = urldecode($parsed['pass']);
                    if (isset($parsed['path'])) $dbname = ltrim($parsed['path'], '/');
                }
            }
        }

        // 2. Support all common environment variable name variants
        if (getenv('DB_HOST')) $host = getenv('DB_HOST');
        elseif (getenv('MYSQL_HOST')) $host = getenv('MYSQL_HOST');
        elseif (getenv('MYSQLHOST')) $host = getenv('MYSQLHOST');

        if (getenv('DB_USER')) $user = getenv('DB_USER');
        elseif (getenv('MYSQL_USER')) $user = getenv('MYSQL_USER');
        elseif (getenv('MYSQLUSER')) $user = getenv('MYSQLUSER');

        if (getenv('DB_PORT')) $port = (int)getenv('DB_PORT');
        elseif (getenv('MYSQL_PORT')) $port = (int)getenv('MYSQL_PORT');
        elseif (getenv('MYSQLPORT')) $port = (int)getenv('MYSQLPORT');

        if (getenv('DB_NAME')) $dbname = getenv('DB_NAME');
        elseif (getenv('MYSQL_DATABASE')) $dbname = getenv('MYSQL_DATABASE');
        elseif (getenv('MYSQLDATABASE')) $dbname = getenv('MYSQLDATABASE');

        if (getenv('DB_PASSWORD') !== false && getenv('DB_PASSWORD') !== '') $password = getenv('DB_PASSWORD');
        elseif (getenv('MYSQL_PASSWORD') !== false && getenv('MYSQL_PASSWORD') !== '') $password = getenv('MYSQL_PASSWORD');
        elseif (getenv('MYSQLPASSWORD') !== false && getenv('MYSQLPASSWORD') !== '') $password = getenv('MYSQLPASSWORD');
        elseif (getenv('DB_PASS') !== false && getenv('DB_PASS') !== '') $password = getenv('DB_PASS');
        elseif (getenv('PASSWORD') !== false && getenv('PASSWORD') !== '') $password = getenv('PASSWORD');

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
