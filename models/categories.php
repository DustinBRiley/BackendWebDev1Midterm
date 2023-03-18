<?php
    class categories {
        private $conn;
        private $tablec = 'categories';

        public $id;
        public $category;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT id, category FROM ' . $this->tablec . '';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }


    }