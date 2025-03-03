<?php
namespace App\Models;

use PDO;
use App\Models\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $password, $description)
    {
        // On force un compte admin si c'est l'email "test@test.com", par exemple
        $is_admin = ($email === 'test@test.com') ? true : false;

        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, description, is_admin) 
                                    VALUES (:name, :email, :password, :description, :is_admin)");
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    // Méthode ajoutée pour récupérer un utilisateur par son ID
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
