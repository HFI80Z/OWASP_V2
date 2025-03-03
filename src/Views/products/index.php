<?php
ob_start();
?>
<!-- En-tête avec un conteneur stylisé -->
<div class="product-header mb-4">
  <h2 class="mb-0">Liste des produits</h2>
  <?php if (!empty($_SESSION['user_id'])): ?>
    <a class="btn btn-success" href="?action=product_create">Ajouter une annonce</a>
  <?php endif; ?>
</div>

<!-- Grille Bootstrap (3 colonnes sur md) avec un espacement g-4 -->
<div class="row g-4">
  <?php foreach ($products as $product): ?>
    <div class="col-md-4">
      <!-- Carte produit plus moderne -->
      <div class="product-card card h-100">
        <img src="<?= htmlspecialchars($product['image']) ?>"
             class="card-img-top product-img"
             alt="<?= htmlspecialchars($product['name']) ?>">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
          <p class="text-muted mb-2">
            <strong>Prix :</strong> <?= $product['price'] ?> €
          </p>
          <p class="text-muted mb-2">
            Vendu par : <?= htmlspecialchars($product['user_name']) ?>
          </p>
          <!-- Description : flex-grow-1 pour pousser le bouton en bas -->
          <p class="card-text flex-grow-1">
            <?= nl2br(htmlspecialchars($product['description'])) ?>
          </p>
          <a href="?action=product_show&id=<?= $product['id'] ?>" class="btn btn-primary mt-auto">
            Détails
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
