<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\User;

class ProductController
{
    public function index()
    {
        // La session doit être démarrée ailleurs (public/index.php ou router)
        $productModel = new Product();
        $products = $productModel->getAll();
        include __DIR__ . '/../Views/products/index.php';
    }

    public function create()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }
        include __DIR__ . '/../Views/products/create.php';
    }

    public function store()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?action=login');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';

        // Gestion de l'image
        $image = $_FILES['image']['name'] ?? '';
        $tmpName = $_FILES['image']['tmp_name'] ?? '';
        if ($image && $tmpName) {
            // Chemin physique vers public/uploads/
            $uploadDir = __DIR__ . '/../../public/uploads/';
            // Créer le dossier si nécessaire
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $targetFile = $uploadDir . $image;
            move_uploaded_file($tmpName, $targetFile);
        }

        $productModel = new Product();
        // On enregistre en base le chemin relatif "uploads/nom_fichier"
        $productModel->create($name, $price, 'uploads/' . $image, $description, $_SESSION['user_id']);
        header('Location: ?action=products');
        exit;
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?action=products');
            exit;
        }

        $productModel = new Product();
        $product = $productModel->findById($id);
        include __DIR__ . '/../Views/products/show.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?action=products');
            exit;
        }

        $productModel = new Product();
        $product = $productModel->findById($id);

        // Vérifier si c'est le propriétaire (ou admin)
        if ($product['user_id'] != $_SESSION['user_id'] && empty($_SESSION['is_admin'])) {
            header('Location: ?action=products');
            exit;
        }

        include __DIR__ . '/../Views/products/create.php'; // On peut réutiliser le même formulaire
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: ?action=products');
            exit;
        }

        $productModel = new Product();
        $product = $productModel->findById($id);

        // Vérifier si c'est le propriétaire (ou admin)
        if ($product['user_id'] != $_SESSION['user_id'] && empty($_SESSION['is_admin'])) {
            header('Location: ?action=products');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';

        // Gestion de l'image
        $image = $product['image']; // On garde l'ancienne image par défaut
        if (!empty($_FILES['image']['name'])) {
            $imageFile = $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];

            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $targetFile = $uploadDir . $imageFile;
            move_uploaded_file($tmpName, $targetFile);

            $image = 'uploads/' . $imageFile;
        }

        $productModel->update($id, $name, $price, $image, $description);
        header('Location: ?action=products');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?action=products');
            exit;
        }

        $productModel = new Product();
        $product = $productModel->findById($id);

        // Vérifier si c'est le propriétaire (ou admin)
        if ($product['user_id'] != $_SESSION['user_id'] && empty($_SESSION['is_admin'])) {
            header('Location: ?action=products');
            exit;
        }

        $productModel->delete($id);
        header('Location: ?action=products');
        exit;
    }
}
