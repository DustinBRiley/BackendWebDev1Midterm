<?php
    class Database {
        private $conn;
        private $host;
        private $port;
        private $dbname;
        private $username;
        private $password;

        public function connect() {
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->dbname = getenv('DBNAME');
            $this->host = getenv('HOST');
            $this->port = getenv('PORT');
            if ($this->conn) {
                return $this->conn;     //connection already exists, return it
            } else {
                try {
                    $dsn = "pgsql:host='$this->host';port='$this->port';dbname='$this->dbname'";
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                } catch (PDOException $e) {
                    echo 'Connection Error: ' . $e->getMessage();
                }
            }
        }
    }