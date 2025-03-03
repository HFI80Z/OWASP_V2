<?php
ob_start();
$editing = isset($product); // si on est en édition
?>
<h2><?= $editing ? "Modifier l'annonce" : "Nouvelle annonce" ?></h2>
<form method="POST" action="?action=<?= $editing ? 'product_update' : 'product_store' ?>" enctype="multipart/form-data">
  <?php if($editing): ?>
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label>Nom</label>
    <input type="text" name="name" class="form-control" value="<?= $editing ? htmlspecialchars($product['name']) : '' ?>">
  </div>
  <div class="mb-3">
    <label>Prix</label>
    <input type="text" name="price" class="form-control" value="<?= $editing ? $product['price'] : '' ?>">
  </div>
  <div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control">
    <?php if($editing): ?>
      <p>Image actuelle : <strong><?= htmlspecialchars($product['image']) ?></strong></p>
    <?php endif; ?>
  </div>
  <div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control"><?= $editing ? htmlspecialchars($product['description']) : '' ?></textarea>
  </div>
  <button class="btn btn-primary"><?= $editing ? 'Mettre à jour' : 'Créer' ?></button>
</form>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
