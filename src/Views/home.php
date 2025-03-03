<?php
ob_start();
?>
<!-- Section Hero -->
<section class="hero">
  <div class="container">
    <h1>Bienvenue sur Valorant Ecom</h1>
    <p>La meilleure plateforme pour acheter et vendre des skins Valorant.</p>
    <a href="?action=products" class="btn btn-hero">Voir les produits</a>
  </div>
</section>

<!-- Section infos ou résumé -->
<div class="container mt-5">
  <h2 class="section-title">Pourquoi choisir Valorant Ecom ?</h2>
  <p>Retrouvez les meilleures annonces de skins Valorant, en toute simplicité.</p>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
