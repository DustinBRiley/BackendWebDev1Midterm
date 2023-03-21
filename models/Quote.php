<?php
    class Quote {
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
            $query = 'SELECT q.id, q.quote,
                (SELECT author FROM ' . $this->tablea . ' a WHERE q.author_id = a.id) as author,
                (SELECT category FROM ' . $this->tablec . ' c WHERE q.category_id = c.id) as category
                FROM ' . $this->tableq . ' q, ' . $this->tablea . ' a, ' . $this->tablec . ' c';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            $query = 'SELECT q.id, q.quote,
                (SELECT author FROM ' . $this->tablea . ' a WHERE q.author_id = a.id) as author,
                (SELECT category FROM ' . $this->tablec . ' c WHERE q.category_id = c.id) as category
                FROM ' . $this->tableq . ' q, ' . $this->tablea . ' a, ' . $this->tablec . ' c
                WHERE id = ?';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];

            return $stmt;
        }

        public function create() {
            $query = 'INSERT INTO ' . $this->tableq . '
                SET quote = :quote, author_id = :author_id, category_id = :category_id';

            $stmt = $this->conn->prepare($query);

            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));

            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author);
            $stmt->bindParam(':category_id', $this->category);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function update() {
            $query = 'UPDATE ' . $this->tableq . '
                SET quote = :quote, author_id = :author_id, category_id = :category_id
                WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author);
            $stmt->bindParam(':category_id', $this->category);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function delete() {
            $query = 'DELETE FROM ' . $this->tableq . ' WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }