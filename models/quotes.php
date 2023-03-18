<?php
    class quote {
        private $conn;
        private $tableq = 'quotes';
        private $tablea = 'authors';
        private $tablec = 'categories';

        public $id;
        public $quote;
        public $author;
        public $category;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT q.id q.quote,
                (SELECT author FROM a WHERE q.author_id=a.id) as author,
                (SELECT category FROM c WHERE q.category_id=c.id) as category
                FROM ' . $this->tableq . ' q, ' . $this->tablea . ' a, ' . $this->tablec . ' c'

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }


    }