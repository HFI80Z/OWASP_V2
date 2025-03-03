<?php
namespace App\Models;

use PDO;

class Rating
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create($order_id, $rating, $comment)
    {
        $stmt = $this->db->prepare("INSERT INTO ratings (order_id, rating, comment) 
                                    VALUES (:order_id, :rating, :comment)");
        $stmt->bindValue(':order_id', $order_id);
        $stmt->bindValue(':rating', $rating);
        $stmt->bindValue(':comment', $comment);
        $stmt->execute();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM ratings ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
