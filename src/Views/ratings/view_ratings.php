<?php
ob_start();
?>
<h2>Liste des avis</h2>
<?php foreach($ratings as $r): ?>
<div class="border p-2 mb-2">
  <p><strong>Order ID:</strong> <?= $r['order_id'] ?></p>
  <p><strong>Note:</strong> <?= $r['rating'] ?>/5</p>
  <p><strong>Commentaire:</strong> <?= nl2br(htmlspecialchars($r['comment'])) ?></p>
  <p><small>Posté le: <?= $r['created_at'] ?></small></p>
</div>
<?php endforeach; ?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
