<?php
$title = "Bienvenue chez Gaboshop";
ob_start();
?>

<?php if (Session::isLoggedIn()): ?>
    <div class="alert alert-success text-center mb-4" role="alert">
        <h4 class="alert-heading">Bienvenue <?= htmlspecialchars(Session::get('user_name')) ?> !</h4>
        <p>Vous pouvez maintenant ajouter des produits à votre panier et passer commande.</p>
        <hr>
        <p class="mb-0">Explorez nos dernières offres ci-dessous.</p>
    </div>
<?php endif; ?>

<!-- Section Héro -->
<div class="hero-section text-center text-white py-5 mb-4">
    <div class="container">
        <h1 class="display-4">Bienvenue chez Gaboshop</h1>
        <p class="lead">Découvrez nos produits exceptionnels et trouvez ce que vous cherchez.</p>
        <a href="#produits" class="btn btn-light btn-lg">Voir les produits</a>
    </div>
</div>

<!-- Filtres par catégorie -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-filter"></i> Filtrer par catégorie</h5>
                <div class="btn-group flex-wrap" role="group">
                    <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste" class="btn btn-outline-primary active">
                        <i class="fas fa-list"></i> Toutes
                    </a>
                    <?php foreach ($categories as $category): ?>
                        <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste&category=<?= $category['id'] ?>" 
                           class="btn btn-outline-primary">
                            <?= htmlspecialchars($category['nom']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grille des produits -->
<section id="produits">
    <h2 class="text-center mb-4 section-heading"><i class="fas fa-store"></i> Nos Produits</h2>
    <div class="row">
        <?php if (empty($produits)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Aucun produit disponible pour le moment.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($produits as $produit): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 product-card">
                        <?php if ($produit['image']): ?>
                            <img src="<?= UPLOAD_URL . $produit['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                            <p class="card-text text-muted small">
                                <?= htmlspecialchars($produit['category_name'] ?? 'Sans catégorie') ?>
                            </p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary fw-bold"><?= number_format($produit['prix'], 0) ?> FCFA</span>
                                    <small class="text-muted">Stock: <?= $produit['stock'] ?></small>
                                </div>
                                <div class="d-grid gap-2 mt-2">
                                    <a href="<?= BASE_URL ?>index.php?controller=produit&action=detail&id=<?= $produit['id'] ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> Voir détails
                                    </a>
                                    <a href="<?= BASE_URL ?>index.php?controller=user&action=login" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Acheter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Section Appel à l'action -->
<div class="call-to-action text-center py-5 mt-4 bg-light rounded">
    <div class="container">
        <h3>Prêt à faire des achats ?</h3>
        <p>Connectez-vous pour profiter de toutes les fonctionnalités ou créez un compte dès maintenant.</p>
        <a href="<?= BASE_URL ?>index.php?controller=user&action=login" class="btn btn-primary mx-2">
            <i class="fas fa-sign-in-alt"></i> Se connecter
        </a>
        <a href="<?= BASE_URL ?>index.php?controller=user&action=register" class="btn btn-success mx-2">
            <i class="fas fa-user-plus"></i> Créer un compte
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
