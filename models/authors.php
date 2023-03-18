<?php
    class authors {
        private $conn;
        private $tablea = 'authors';

        public $id;
        public $category;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT id, author FROM ' . $this->tablea . '';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }


    }