<?php
ob_start();
?>
<h2>Administration</h2>
<p>Ici, l'admin peut voir tous les utilisateurs et éventuellement les supprimer.</p>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Email</th>
      <th>Admin?</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($users as $u): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><?= htmlspecialchars($u['name']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><?= $u['is_admin'] ? 'Oui' : 'Non' ?></td>
      <td>
        <?php if($u['id'] != $_SESSION['user_id']): ?>
          <a href="?action=admin_delete_user&id=<?= $u['id'] ?>" class="btn btn-danger"
             onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
