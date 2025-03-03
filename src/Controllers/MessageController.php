<?php
namespace App\Controllers;

use App\Models\Message;
use App\Models\Product;
use App\Models\User;

class MessageController
{
    /**
     * Affiche la liste des "catégories" (produits) pour lesquels
     * il y a une conversation. Pour l’admin : toutes les conversations.
     */
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }

        $messageModel = new Message();

        // 1) Récupérer toutes les "conversations" distinctes
        //    - Soit pour l'admin
        //    - Soit pour l'utilisateur courant
        if (!empty($_SESSION['is_admin'])) {
            $rawConversations = $messageModel->getDistinctConversationsForAdmin();
        } else {
            $rawConversations = $messageModel->getDistinctConversations($_SESSION['user_id']);
        }

        // 2) On va les regrouper par product_id
        //    $conversations[product_id] = [ [infos conversation], [infos conversation], ... ]
        $conversations = [];
        foreach ($rawConversations as $conv) {
            $pid = $conv['product_id'];

            // Dans le cas admin, on peut avoir userA/userB
            // Dans le cas user normal, on a un 'other_id'
            // On va unifier un peu pour afficher dans la vue
            if (!isset($conversations[$pid])) {
                $conversations[$pid] = [
                    'product_id' => $pid,
                    'product_name' => $conv['product_name'] ?? '(Produit inconnu)',
                    'threads' => []
                ];
            }

            // S'il y a un "other_id" direct
            if (isset($conv['other_id'])) {
                // c'est la version user
                $conversations[$pid]['threads'][] = [
                    'other_id' => $conv['other_id'],
                    'other_name' => $conv['other_name'] ?? '???'
                ];
            } else {
                // c'est la version admin, on a userA / userB
                $conversations[$pid]['threads'][] = [
                    'userA' => $conv['userA'],
                    'userB' => $conv['userB'],
                    'sender_name' => $conv['sender_name'] ?? '???',
                    'receiver_name' => $conv['receiver_name'] ?? '???'
                ];
            }
        }

        include __DIR__ . '/../Views/messages/index.php';
    }

    /**
     * Envoi direct (ancienne méthode)
     */
    public function sendMessage()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $receiver_id = $_POST['receiver_id'] ?? null;
            $product_id  = $_POST['product_id']  ?? null;
            $content     = $_POST['content']     ?? '';

            $messageModel = new Message();
            $messageModel->create($_SESSION['user_id'], $receiver_id, $product_id, $content);

            header('Location: ?action=messages');
            exit;
        }

        header('Location: ?action=messages');
    }

    /**
     * Conversation détaillée (nouveau système "catégorisé" par produit + interlocuteur)
     */
    public function conversation()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }

        $product_id = $_GET['product_id'] ?? null;
        $other_id   = $_GET['other_id']   ?? null;

        if (!$product_id || !$other_id) {
            header('Location: ?action=messages');
            exit;
        }

        $messageModel = new Message();
        $messages = $messageModel->getConversation($_SESSION['user_id'], $other_id, $product_id);

        // Récupérer le produit (pour afficher le titre, etc.)
        $product = (new Product())->findById($product_id);

        // Récupérer l'autre utilisateur
        $otherUser = (new User())->findById($other_id);

        include __DIR__ . '/../Views/messages/conversation.php';
    }

    /**
     * Envoi d'un message dans la conversation
     */
    public function sendMessageInConversation()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $other_id   = $_POST['other_id']   ?? null;
            $content    = $_POST['content']    ?? '';

            if ($product_id && $other_id && $content) {
                $messageModel = new Message();
                $messageModel->create($_SESSION['user_id'], $other_id, $product_id, $content);
            }
            header('Location: ?action=message_conversation&product_id=' . $product_id . '&other_id=' . $other_id);
            exit;
        }

        header('Location: ?action=messages');
    }
}
