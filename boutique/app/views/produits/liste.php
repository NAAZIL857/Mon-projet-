<?php
$title = "Catalogue des produits";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-store"></i> Catalogue des produits</h2>
</div>

<!-- Hero Banner -->
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bienvenue chez Gaboshop</h1>
        <p class="col-md-8 fs-4">Découvrez nos collections uniques et trouvez les articles qui vous correspondent. Qualité et style au meilleur prix.</p>
        <a href="#" class="btn btn-primary btn-lg">Explorer le catalogue</a>
    </div>
</div>

<!-- Filtres par catégorie -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h6>Filtrer par catégorie :</h6>
                <div class="btn-group flex-wrap" role="group">
                    <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste" class="btn btn-outline-primary">
                        Toutes
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
<div class="row">
    <?php if (empty($produits)): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Aucun produit disponible pour le moment.
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($produits as $produit): ?>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100">
                    <?php if ($produit['image']): ?>
                        <img src="<?= UPLOAD_URL . $produit['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']) ?>" style="height: 200px; object-fit: cover;">
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
                        <p class="card-text"><?= htmlspecialchars(substr($produit['description'], 0, 100)) ?>...</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary"><?= number_format($produit['prix'], 0) ?> FCFA</span>
                                <small class="text-muted">Stock: <?= $produit['stock'] ?></small>
                            </div>
                            <div class="d-grid gap-2 mt-2">
                                <a href="<?= BASE_URL ?>index.php?controller=produit&action=detail&id=<?= $produit['id'] ?>" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> Voir détails
                                </a>
                                <?php if ($produit['stock'] > 0): ?>
                                    <button class="btn btn-primary btn-sm add-to-cart" 
                                            data-product-id="<?= $produit['id'] ?>">
                                        <i class="fas fa-cart-plus"></i> Ajouter au panier
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-times"></i> Rupture de stock
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>