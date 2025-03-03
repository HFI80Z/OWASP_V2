<?php
namespace App\Controllers;

use App\Models\Database;
use App\Models\User;

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Ne pas faire session_start() ici, 
                // la session est déjà démarrée dans public/index.php (ou le routeur).
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['is_admin'] = $user['is_admin'];
                header('Location: ?action=products');
                exit;
            } else {
                $error = "Identifiants incorrects";
                include __DIR__ . '/../Views/auth/login.php';
                return;
            }
        }
        include __DIR__ . '/../Views/auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $description = $_POST['description'] ?? '';

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userModel = new User();
            $exists = $userModel->findByEmail($email);
            if ($exists) {
                $error = "Cet email est déjà utilisé.";
                include __DIR__ . '/../Views/auth/register.php';
                return;
            }

            $userModel->create($name, $email, $hashedPassword, $description);
            header('Location: ?action=login');
            exit;
        }
        include __DIR__ . '/../Views/auth/register.php';
    }

    public function logout()
    {
        // Ne pas faire session_start() ici non plus,
        // la session est déjà active.
        session_destroy();
        header('Location: ?action=home');
    }
}
