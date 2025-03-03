<?php
ob_start();
?>
<div class="messenger-intro mb-4">
  <h2 class="mb-2">Messagerie</h2>
  <?php if (!empty($_SESSION['is_admin'])): ?>
    <p>Vous êtes administrateur. Vous voyez toutes les conversations.</p>
  <?php else: ?>
    <p>Vous voyez uniquement vos conversations.</p>
  <?php endif; ?>
</div>

<?php if (empty($conversations)): ?>
  <div class="alert alert-secondary">
    Aucune conversation pour le moment.
  </div>
<?php else: ?>
  <?php foreach ($conversations as $prodConv): ?>
    <div class="messenger-product-card">
      <h5>Produit : <?= htmlspecialchars($prodConv['product_name']) ?></h5>

      <?php if (!empty($_SESSION['is_admin'])): ?>
        <!-- ADMIN : userA/userB -->
        <?php foreach ($prodConv['threads'] as $thread): ?>
          <div class="border p-2 mb-2">
            <strong>Utilisateurs :</strong> 
            <?= htmlspecialchars($thread['sender_name']) ?> / <?= htmlspecialchars($thread['receiver_name']) ?><br>
            <a href="?action=message_conversation&product_id=<?= $prodConv['product_id'] ?>&other_id=<?= $thread['userA'] ?>"
               class="btn btn-sm btn-primary mt-1">
              Voir conversation (userA)
            </a>
            <a href="?action=message_conversation&product_id=<?= $prodConv['product_id'] ?>&other_id=<?= $thread['userB'] ?>"
               class="btn btn-sm btn-primary mt-1">
              Voir conversation (userB)
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- USER NORMAL : other_id / other_name -->
        <?php foreach ($prodConv['threads'] as $thread): ?>
          <div class="border p-2 mb-2">
            <strong>Autre utilisateur :</strong> 
            <?= htmlspecialchars($thread['other_name']) ?><br>
            <a href="?action=message_conversation&product_id=<?= $prodConv['product_id'] ?>&other_id=<?= $thread['other_id'] ?>"
               class="btn btn-sm btn-primary mt-1">
              Ouvrir la conversation
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
