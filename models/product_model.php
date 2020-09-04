<?php

require 'models/product.php';

class ProductModel extends Model {

    public function __construct(){
        parent::__construct();
    }

    /**
    * Obtener un producto
    */
    public function find($id){
        try{
            $query = $this->db->connect()->prepare('SELECT * FROM products WHERE id = :id');
            $query->execute(['id' => $id]);
            
            $product = null;
            while($row = $query->fetch()){
                $product = new Product($row);
            }

            return $product;
        }catch(PDOException $e){
            return null;
        }
    }

    /**
    * Obtener un producto
    */
    public function get($params){
        try{
            $query = $this->db->connect()->prepare('SELECT * FROM products');
            $query->execute();
            
            $products = [];
            while($row = $query->fetch()){
                array_push($products, new Product($row));
            }

            return $products;
        }catch(PDOException $e){
            return null;
        }
    }

    /**
    * Crear un producto
    */
    public function create($dto){
        $query = $this->db->connect()->prepare('INSERT INTO products (name, reference, price, weight, category, stock, created_at, last_selled_at) VALUES(:name, :reference, :price, :weight, :category, :stock, :created_at, :last_selled_at)');
        try{
            $query->execute([
                'name' => $dto['name'],
                'reference' => $dto['reference'],
                'price' => $dto['price'],
                'weight' => $dto['weight'],
                'category' => $dto['category'],
                'stock' => $dto['stock'],
                'created_at' => isset($dto['created_at']) ? $dto['created_at'] : null,
                'last_selled_at' => isset($dto['last_selled_at']) ? $dto['last_selled_at'] : null
            ]);

            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function update($id, $dto){
        $query = $this->db->connect()->prepare('UPDATE products set name = :name, reference = :reference, price = :price, weight = :weight, category = :category, stock = :stock, created_at = :created_at, last_selled_at = :last_selled_at where id = :id');
        try{
            $query->execute([
                'id' => $id,
                'name' => $dto['name'],
                'reference' => $dto['reference'],
                'price' => $dto['price'],
                'weight' => $dto['weight'],
                'category' => $dto['category'],
                'stock' => $dto['stock'],
                'created_at' => isset($dto['created_at']) ? $dto['created_at'] : null,
                'last_selled_at' => isset($dto['last_selled_at']) ? $dto['last_selled_at'] : null
            ]);

            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    /**
    * Eliminar un producto
    */
    public function destroy($id){
        $query = $this->db->connect()->prepare('DELETE FROM products WHERE id = :id');
        try{
            $query->execute(['id' => $id]);
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

}
?>