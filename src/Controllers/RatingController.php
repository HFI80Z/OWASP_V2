<?php
namespace App\Controllers;

use App\Models\Rating;

class RatingController
{
    public function leaveRating()
    {
        session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }

        // On suppose qu'on passe un paramètre order_id
        $order_id = $_GET['order_id'] ?? null;
        if (!$order_id) {
            header('Location: ?action=products');
            exit;
        }

        include __DIR__ . '/../Views/ratings/leave_rating.php';
    }

    public function storeRating()
    {
        session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }

        $order_id = $_POST['order_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $comment = $_POST['comment'] ?? '';

        if ($order_id && $rating) {
            $ratingModel = new Rating();
            $ratingModel->create($order_id, $rating, $comment);
        }

        header('Location: ?action=view_ratings');
    }

    public function viewRatings()
    {
        session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }

        $ratingModel = new Rating();
        // On récupère simplement tous les ratings, 
        // ou uniquement ceux concernant l’utilisateur ? 
        // À adapter selon la logique souhaitée.
        $ratings = $ratingModel->getAll();
        include __DIR__ . '/../Views/ratings/view_ratings.php';
    }
}
