<?php
namespace App\Controllers;

use App\Models\User;

class AdminController
{
    public function index()
    {
        session_start();
        if (empty($_SESSION['user_id']) || !$_SESSION['is_admin']) {
            header('Location: ?action=home');
            exit;
        }

        // L'admin voit tous les utilisateurs
        $userModel = new User();
        $users = $userModel->getAll();
        include __DIR__ . '/../Views/admin/index.php';
    }

    public function deleteUser()
    {
        session_start();
        if (empty($_SESSION['user_id']) || !$_SESSION['is_admin']) {
            header('Location: ?action=home');
            exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $userModel = new User();
            $userModel->delete($id);
        }
        header('Location: ?action=admin');
    }
}
