<?php
class Products{
    // Connexion
    private $connexion;
    private $table = "products";

    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $categories_id;
    public $categories_name;
    public $created_at;

    /**
     * construct
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Reading products
     *
     * @return void
     */
    public function read(){
        // Write request
        $sql = "SELECT c.name as categories_name, p.id, p.name, p.description, p.price, p.categories_id, p.created_at FROM " . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id ORDER BY p.created_at DESC";

        // prepare request and execute
        $query = $this->connexion->prepare($sql);
        $query->execute();

        // then we return the result
        return $query;
    }

    /**
     * Create a product
     *
     * @return void
     */
    public function create(){

        $sql = "INSERT INTO " . $this->table . " SET name=:name, price=:price, description=:description, categories_id=:categories_id, created_at=:created_at";
        $query = $this->connexion->prepare($sql);

        // Protection vs sql injection
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->categories_id=htmlspecialchars(strip_tags($this->categories_id));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));

        // We add some protected data
        $query->bindParam(":name", $this->name);
        $query->bindParam(":price", $this->price);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":categories_id", $this->categories_id);
        $query->bindParam(":created_at", $this->created_at);

        // request execution
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Read a product
     *
     * @return void
     */
    public function readOne(){
        // Write request
        $sql = "SELECT c.name as categories_name, p.id, p.name, p.description, p.price, p.categories_id, p.created_at FROM " . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id WHERE p.id = ? LIMIT 0,1";

        //Prepare request
        $query = $this->connexion->prepare( $sql );

        // add id
        $query->bindParam(1, $this->id);

        // then execute request
        $query->execute();

        // got the line
        $row = $query->fetch(PDO::FETCH_ASSOC);

        // Hydrate
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->categories_id = $row['categories_id'];
        $this->categories_name = $row['categories_name'];
    }

    /**
     * delete a product
     *
     * @return void
     */
    public function delete(){
        // Write request and prepare
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";
        $query = $this->connexion->prepare( $sql );

        // Securize data
        $this->id=htmlspecialchars(strip_tags($this->id));

        // add the id
        $query->bindParam(1, $this->id);

        // finally, execute
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * UPDATE
     *
     * @return void
     */
    public function update(){
        // Write request and prepare
        $sql = "UPDATE " . $this->table . " SET name = :name, price = :price, description = :description, categories_id = :categories_id WHERE id = :id";
        $query = $this->connexion->prepare($sql);
        
        // Securize vs sql injection
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->categories_id=htmlspecialchars(strip_tags($this->categories_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        // Attach variables
        $query->bindParam(':name', $this->name);
        $query->bindParam(':price', $this->price);
        $query->bindParam(':description', $this->description);
        $query->bindParam(':categories_id', $this->categories_id);
        $query->bindParam(':id', $this->id);
        
        // Then execute
        if($query->execute()){
            return true;
        }
        
        return false;
    }

}