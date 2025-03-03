<?php
namespace App\Models;

use PDO;

class Message
{
    private $db;

    public function __construct()
    {
        // On récupère la connexion depuis Database
        $this->db = Database::getConnection();
    }

    /**
     * Créer un nouveau message
     *
     * @param int    $sender_id   L'ID de l'expéditeur
     * @param int    $receiver_id L'ID du destinataire
     * @param int    $product_id  L'ID du produit concerné
     * @param string $content     Le contenu du message
     */
    public function create($sender_id, $receiver_id, $product_id, $content)
    {
        $stmt = $this->db->prepare("
            INSERT INTO messages (sender_id, receiver_id, product_id, content)
            VALUES (:sender, :receiver, :product, :content)
        ");
        $stmt->execute([
            ':sender'   => $sender_id,
            ':receiver' => $receiver_id,
            ':product'  => $product_id,
            ':content'  => $content
        ]);
    }

    /**
     * Ancienne méthode : récupérer tous les messages
     * (utile pour l'admin, si vous n'utilisez pas la logique de conversation).
     */
    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT m.*, s.name AS sender_name, r.name AS receiver_name
            FROM messages m
            JOIN users s ON m.sender_id = s.id
            JOIN users r ON m.receiver_id = r.id
            ORDER BY m.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ancienne méthode : récupérer les messages d'un user
     * (reçus + envoyés), sans notion de conversation groupée.
     */
    public function getMessagesForUser($user_id)
    {
        $stmt = $this->db->prepare("
            SELECT m.*, s.name AS sender_name, r.name AS receiver_name
            FROM messages m
            JOIN users s ON m.sender_id = s.id
            JOIN users r ON m.receiver_id = r.id
            WHERE sender_id = :uid OR receiver_id = :uid
            ORDER BY m.created_at DESC
        ");
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Nouvelle méthode : liste des conversations (pour un user).
     * Chaque conversation est (product_id + 'autre utilisateur').
     * Ici, on utilise JOIN et on groupe par toutes les colonnes
     * nécessaires pour PostgreSQL.
     */
    public function getDistinctConversations($user_id)
    {
        $sql = "
            SELECT
                m.product_id,
                CASE WHEN m.sender_id = :uid THEN m.receiver_id ELSE m.sender_id END AS other_id,
                u.name AS other_name,
                p.name AS product_name
            FROM messages m
            JOIN products p ON p.id = m.product_id
            JOIN users u 
              ON u.id = CASE WHEN m.sender_id = :uid THEN m.receiver_id ELSE m.sender_id END
            WHERE m.sender_id = :uid OR m.receiver_id = :uid
            GROUP BY
                m.product_id,
                m.sender_id,
                m.receiver_id,
                CASE WHEN m.sender_id = :uid THEN m.receiver_id ELSE m.sender_id END,
                u.name,
                p.name
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Version admin : liste toutes les conversations (sans filtrer par user).
     * L'admin voit tous les (product_id, user1, user2), regroupés.
     * On remplace également les sous-requêtes par des JOIN pour PostgreSQL.
     */
    public function getDistinctConversationsForAdmin()
    {
        $sql = "
            SELECT
                m.product_id,
                LEAST(m.sender_id, m.receiver_id) AS userA,
                GREATEST(m.sender_id, m.receiver_id) AS userB,
                p.name AS product_name,
                s.name AS sender_name,
                r.name AS receiver_name
            FROM messages m
            JOIN products p ON p.id = m.product_id
            JOIN users s ON s.id = m.sender_id
            JOIN users r ON r.id = m.receiver_id
            GROUP BY
                m.product_id,
                m.sender_id,
                m.receiver_id,
                p.name,
                s.name,
                r.name
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Nouvelle méthode : récupérer tous les messages
     * entre $currentUser et $otherUser pour un $product_id
     *
     * @param int $currentUser L'utilisateur courant
     * @param int $otherUser   L'autre interlocuteur
     * @param int $product_id  L'ID du produit concerné
     * @return array           Les messages triés par date
     */
    public function getConversation($currentUser, $otherUser, $product_id)
    {
        $sql = "
            SELECT m.*,
                   s.name AS sender_name,
                   r.name AS receiver_name
            FROM messages m
            JOIN users s ON m.sender_id = s.id
            JOIN users r ON m.receiver_id = r.id
            WHERE m.product_id = :pid
              AND (
                (m.sender_id = :user1 AND m.receiver_id = :user2)
                OR
                (m.sender_id = :user2 AND m.receiver_id = :user1)
              )
            ORDER BY m.created_at ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':pid'   => $product_id,
            ':user1' => $currentUser,
            ':user2' => $otherUser
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
