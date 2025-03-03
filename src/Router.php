<?php
namespace App;

use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\MessageController;
use App\Controllers\AdminController;
use App\Controllers\RatingController;

class Router
{
    public function handleRequest()
    {
        // Assurez-vous que la session est démarrée une seule fois dans votre point d'entrée (ex. public/index.php)
        
        // On récupère l'action (par défaut 'home')
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            // Authentification
            case 'login':
                (new AuthController())->login();
                break;
            case 'register':
                (new AuthController())->register();
                break;
            case 'logout':
                (new AuthController())->logout();
                break;

            // Produits
            case 'products':
                (new ProductController())->index();
                break;
            case 'product_create':
                (new ProductController())->create();
                break;
            case 'product_store':
                (new ProductController())->store();
                break;
            case 'product_show':
                (new ProductController())->show();
                break;
            case 'product_edit':
                (new ProductController())->edit();
                break;
            case 'product_update':
                (new ProductController())->update();
                break;
            case 'product_delete':
                (new ProductController())->delete();
                break;

            // Messagerie
            case 'messages':
                (new MessageController())->index();
                break;
            case 'message_conversation':
                (new MessageController())->conversation();
                break;
            case 'message_send_in_conversation':
                (new MessageController())->sendMessageInConversation();
                break;
            case 'message_send': // Ancienne méthode "envoyer message direct"
                (new MessageController())->sendMessage();
                break;

            // Administration
            case 'admin':
                (new AdminController())->index();
                break;
            case 'admin_delete_user':
                (new AdminController())->deleteUser();
                break;

            // Avis / Notations
            case 'leave_rating':
                (new RatingController())->leaveRating();
                break;
            case 'store_rating':
                (new RatingController())->storeRating();
                break;
            case 'view_ratings':
                (new RatingController())->viewRatings();
                break;

            // Page d'accueil par défaut
            default:
                include __DIR__ . '/Views/home.php';
                break;
        }
    }
}
