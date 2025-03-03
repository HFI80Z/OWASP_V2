<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Valorant Ecom</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Votre CSS personnalisé -->
  <link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2c3e50;">
  <div class="container">
    <!-- Marque (logo) à gauche -->
    <a class="navbar-brand" href="?action=home">Valorant Ecom</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Liens de navigation -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Aligner les liens à droite grâce à ms-auto -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="?action=products">Produits</a>
        </li>
        <?php if(!empty($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="?action=messages">Messagerie</a>
          </li>
          <?php if(!empty($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <li class="nav-item">
              <a class="nav-link" href="?action=admin">Admin</a>
            </li>
          <?php endif; ?>
        <?php endif; ?>

        <?php if(empty($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="?action=login">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?action=register">Inscription</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="?action=logout">Déconnexion</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Contenu principal -->
<main class="container my-4">
  <?php
    // $content est injecté par la vue correspondante
    echo $content ?? '';
  ?>
</main>

<!-- FOOTER -->
<footer class="py-3" style="background-color: #2c3e50;">
  <div class="container text-center text-white">
    <p class="m-0">&copy; <?= date('Y') ?> - Valorant Ecom</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
