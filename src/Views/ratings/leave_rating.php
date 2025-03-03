<?php
ob_start();
?>
<h2>Laisser un avis</h2>
<form method="POST" action="?action=store_rating">
  <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
  <div class="mb-3">
    <label>Note (1 à 5)</label>
    <input type="number" name="rating" min="1" max="5" class="form-control">
  </div>
  <div class="mb-3">
    <label>Commentaire</label>
    <textarea name="comment" class="form-control"></textarea>
  </div>
  <button class="btn btn-primary">Envoyer</button>
</form>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
