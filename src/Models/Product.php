<?php
namespace App\Models;

use PDO;

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT p.*, u.name as user_name FROM products p
                                  JOIN users u ON p.user_id = u.id
                                  ORDER BY p.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $price, $image, $description, $user_id)
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, price, image, description, user_id) 
                                    VALUES (:name, :price, :image, :description, :user_id)");
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':image', $image);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $price, $image, $description)
    {
        $stmt = $this->db->prepare("UPDATE products 
                                    SET name=:name, price=:price, image=:image, description=:description
                                    WHERE id=:id");
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':image', $image);
        $stmt->bindValue(':description', $description);
        $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}
