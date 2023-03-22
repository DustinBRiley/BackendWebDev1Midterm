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
            $query = 'SELECT id, quote,
                (SELECT author FROM ' . $this->tablea . ' a WHERE q.author_id = a.id) as author,
                (SELECT category FROM ' . $this->tablec . ' c WHERE q.category_id = c.id) as category
                FROM ' . $this->tableq . ' q ORDER BY id';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            if($this->id != null) {
                $query = 'SELECT id, quote,
                (SELECT author FROM ' . $this->tablea . ' a WHERE q.author_id = a.id) as author,
                (SELECT category FROM ' . $this->tablec . ' c WHERE q.category_id = c.id) as category
                FROM ' . $this->tableq . ' q
                WHERE id = ' . $this->id . '';
            }
            if($this->author != null) {
                $query = 'SELECT id, quote,
                (SELECT author FROM ' . $this->tablea . ' a WHERE q.author_id = a.id) as author,
                (SELECT category FROM ' . $this->tablec . ' c WHERE q.category_id = c.id) as category
                FROM ' . $this->tableq . ' q
                WHERE author_id = ' . $this->author . '';
            } 
            if($this->category != null) {
                $query = 'SELECT id, quote,
                (SELECT author FROM ' . $this->tablea . ' a WHERE q.author_id = a.id) as author,
                (SELECT category FROM ' . $this->tablec . ' c WHERE q.category_id = c.id) as category
                FROM ' . $this->tableq . ' q
                WHERE category_id = ' . $this->category . '';
            } 
            if($this->author != null && $this->category != null) {
                $query = 'SELECT id, quote,
                (SELECT author FROM ' . $this->tablea . ' a WHERE q.author_id = a.id) as author,
                (SELECT category FROM ' . $this->tablec . ' c WHERE q.category_id = c.id) as category
                FROM ' . $this->tableq . ' q
                WHERE author_id = ' . $this->author . ' AND category_id = ' . $this->category . '';
            } 

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            
            $query = "SELECT id FROM $this->tablea 
                WHERE id = $this->author";
        
            $stmt = $this->conn->prepare($query);
        
            $stmt->execute();

            $num = $stmt->rowCount();
        
            if($num == 0) {
                $this->author = null;
                return false;
            }
        
            $query = "SELECT id FROM $this->tablec 
                WHERE id = $this->category";
        
            $stmt = $this->conn->prepare($query);
        
            $stmt->execute();

            $num = $stmt->rowCount();
        
            if($num == 0) {
                $this->category = null;
                return false;
            }

            $query = "INSERT INTO $this->tableq(quote, author_id, category_id)
                VALUES ('$this->quote','$this->author','$this->category')";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            
            $query = "SELECT id FROM $this->tableq 
                WHERE quote = '$this->quote' AND author_id = $this->author AND category_id = $this->category";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];

            return true;
        }

        public function update() {
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));

            $query = "SELECT quote FROM $this->tableq 
                WHERE id = $this->id";
        
            $stmt = $this->conn->prepare($query);
        
            $stmt->execute();

            $num = $stmt->rowCount();
        
            if($num == 0) {
                echo json_encode(array('message' => 'No Quotes Found'));
                return false;
            }
            
            $query = "SELECT id FROM $this->tablea 
                WHERE id = $this->author";
        
            $stmt = $this->conn->prepare($query);
        
            $stmt->execute();

            $num = $stmt->rowCount();
        
            if($num == 0) {
                echo json_encode(array('message' => 'author_id Not Found'));
                return false;
            }
        
            $query = "SELECT id FROM $this->tablec 
                WHERE id = $this->category";
        
            $stmt = $this->conn->prepare($query);
        
            $stmt->execute();

            $num = $stmt->rowCount();
        
            if($num == 0) {
                echo json_encode(array('message' => 'category_id Not Found'));
                return false;
            }

            $query = "UPDATE $this->tableq
                SET quote = '$this->quote', author_id = '$this->author', category_id = '$this->category'
                WHERE id = $this->id";

            $stmt = $this->conn->prepare($query);

            if($stmt->execute()) {
                return true;
            }

            return false;
        }

        public function delete() {
            $this->id = htmlspecialchars(strip_tags($this->id));
                     
            $query = "DELETE FROM $this->tableq WHERE id = $this->id";

            $stmt = $this->conn->prepare($query);
          
            $stmt->execute();
            
            $num = $stmt->rowCount();
                
            if($num > 0) {
                return true; 
            }
                
            return false;
        }
    }