<?php
ob_start();
?>
<h2><?= htmlspecialchars($product['name']) ?></h2>

<!-- On suppose que $product['image'] contient déjà "uploads/nom_fichier.jpg" -->
<img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid mb-3" alt="product image">
<p><strong>Prix:</strong> <?= $product['price'] ?> €</p>
<p><?= htmlspecialchars($product['description']) ?></p>

<?php if (!empty($_SESSION['user_id'])): ?>
  <?php if ($product['user_id'] == $_SESSION['user_id'] || !empty($_SESSION['is_admin'])): ?>
    <a href="?action=product_edit&id=<?= $product['id'] ?>" class="btn btn-warning">Modifier</a>
    <a href="?action=product_delete&id=<?= $product['id'] ?>" class="btn btn-danger" 
       onclick="return confirm('Supprimer cette annonce ?');">Supprimer</a>
  <?php else: ?>
    <!-- Acheter -->
    <form method="POST" action="#" class="d-inline-block">
      <!-- Ici, vous pouvez ajouter un système pour déclencher la création d'une commande (order) -->
      <button class="btn btn-success">Acheter</button>
    </form>

    <!-- Nouveau lien : contacter le vendeur (conversation) -->
    <a href="?action=message_conversation&product_id=<?= $product['id'] ?>&other_id=<?= $product['user_id'] ?>"
       class="btn btn-info">
       Contacter le vendeur
    </a>
  <?php endif; ?>
<?php else: ?>
  <p><a href="?action=login">Connectez-vous</a> pour acheter ou contacter le vendeur.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
