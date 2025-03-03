<?php
ob_start();

// ID de l'utilisateur courant
$myUserId = $_SESSION['user_id'];
?>
<div class="card shadow-sm mb-4">
  <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
    <div>
      <strong>Produit : </strong><?= htmlspecialchars($product['name'] ?? 'N/A') ?>
    </div>
    <div>
      <strong>Avec : </strong><?= htmlspecialchars($otherUser['name'] ?? 'N/A') ?>
    </div>
  </div>

  <div class="card-body chat-container">
    <?php if (!empty($messages)): ?>
      <?php foreach ($messages as $msg): ?>
        <?php 
          // Savoir si c'est l'utilisateur courant
          $isMe = ($msg['sender_id'] == $myUserId);

          // Formater la date/heure
          $dateTime = new DateTime($msg['created_at']);
          $formattedDate = $dateTime->format('j F Y \à H:i');
        ?>

        <div class="message-row <?= $isMe ? 'me' : 'other' ?> mb-3">
          <div class="message-bubble p-3">
            <p class="message-sender fw-bold mb-1">
              <?= htmlspecialchars($msg['sender_name']) ?>
            </p>
            <p class="message-text mb-1">
              <?= nl2br(htmlspecialchars($msg['content'])) ?>
            </p>
            <small class="message-time text-muted">
              Envoyé le : <?= $formattedDate ?>
            </small>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Aucun message pour l’instant.</p>
    <?php endif; ?>
  </div>

  <div class="card-footer">
    <form method="POST" action="?action=message_send_in_conversation" class="row g-2 align-items-center">
      <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
      <input type="hidden" name="other_id" value="<?= htmlspecialchars($otherUser['id']) ?>">

      <div class="col-12 col-md-10">
        <label class="visually-hidden">Votre message</label>
        <textarea name="content" class="form-control" rows="2" placeholder="Tapez votre message..."></textarea>
      </div>
      <div class="col-12 col-md-2 text-end">
        <button class="btn btn-primary w-100">Envoyer</button>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
