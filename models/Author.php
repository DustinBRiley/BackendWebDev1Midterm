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
            $query = 'SELECT id, author FROM ' . $this->tablea . ' ORDER BY id';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            $query = 'SELECT id, author FROM ' . $this->tablea . '
                WHERE id = ' . $this->id . '';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $this->author = htmlspecialchars(strip_tags($this->author)); 
          
            $query = "INSERT INTO $this->tablea(author)
                VALUES ('$this->author')";

            $stmt = $this->conn->prepare($query);         

            $stmt->execute();
          
            $query = "SELECT id FROM $this->tablea 
                WHERE author = '$this->author'";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
          
            return true;
        }

        public function update() {
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            $query = "SELECT author FROM $this->tablea 
                WHERE id = $this->id";
        
            $stmt = $this->conn->prepare($query);
        
            $stmt->execute();

            $num = $stmt->rowCount();
        
            if($num == 0) {
                echo json_encode(array('message' => 'No Authors Found'));
                return false;
            }
          
            $query = "UPDATE $this->tablea
                SET author = '$this->author'
                WHERE id = $this->id";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
          
            return true;
        }

        public function delete() {
            $this->id = htmlspecialchars(strip_tags($this->id));
                     
            $query = "DELETE FROM $this->tablea WHERE id = $this->id";

            $stmt = $this->conn->prepare($query);
          
            $stmt->execute();
            
            $num = $stmt->rowCount();
                
            if($num > 0) {
                return true; 
            }
                
            return false;
        }
    }