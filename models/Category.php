<?php
    class Category {
        private $conn;
        private $tablec = 'categories';

        public $id;
        public $category;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT id, category FROM ' . $this->tablec . ' ORDER BY id';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            $query = 'SELECT id, category FROM ' . $this->tablec . '
                WHERE id = ' . $this->id . '';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $this->category = htmlspecialchars(strip_tags($this->category));
          
            $query = "INSERT INTO $this->tablec(category)
                VALUES ('$this->category')";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
          
            $query = "SELECT id FROM $this->tablec 
                WHERE category = '$this->category'";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
          
            return true;
        }

        public function update() {
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));

            $query = "SELECT category FROM $this->tablec 
                WHERE id = $this->id";
        
            $stmt = $this->conn->prepare($query);
        
            $stmt->execute();

            $num = $stmt->rowCount();
        
            if($num == 0) {
                echo json_encode(array('message' => 'No Categories Found'));
                return false;
            }
          
            $query = "UPDATE $this->tablec
                SET category = '$this->category'
                WHERE id = $this->id";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
          
            return true;
        }

        public function delete() {
            $this->id = htmlspecialchars(strip_tags($this->id));
                     
            $query = "DELETE FROM $this->tablec WHERE id = $this->id";

            $stmt = $this->conn->prepare($query);
          
            $stmt->execute();
            
            $num = $stmt->rowCount();
                
            if($num > 0) {
                return true; 
            }
                
            return false;
        }
    }