<?php
    class Author {
        private $conn;
        private $tablea = 'authors';

        public $id;
        public $author;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT id, author FROM ' . $this->tablea . '';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            $query = 'SELECT id, author FROM ' . $this->tablea . '
                WHERE id = ?
                LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->author = $row['category'];

            return $stmt;
        }

        public function create() {
            $query = 'INSERT INTO ' . $this->tablea . '
                SET author = :author';

            $stmt = $this->conn->prepare($query);

            $this->author = htmlspecialchars(strip_tags($this->author));

            $stmt->bindParam(':author', $this->author);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function update() {
            $query = 'UPDATE ' . $this->tablea . '
                SET author = :author
                WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':author', $this->author);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function delete() {
            $query = 'DELETE FROM ' . $this->tablea . ' WHERE id = :id';

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