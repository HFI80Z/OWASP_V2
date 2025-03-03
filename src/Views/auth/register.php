<?php
ob_start();
?>
<div class="form-container">
  <h2>Inscription</h2>
  <?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST" action="?action=register">
    <div class="mb-3">
      <label>Nom</label>
      <input type="text" name="name" class="form-control">
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
      <label>Mot de passe</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
      <label>Description (optionnelle)</label>
      <textarea name="description" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">S'inscrire</button>
  </form>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
