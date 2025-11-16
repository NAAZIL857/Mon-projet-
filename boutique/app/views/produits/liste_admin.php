<?php
$title = "Catalogue des produits - Admin";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-store"></i> Catalogue des produits (Admin)</h2>
    <a href="<?= BASE_URL ?>index.php?controller=produit&action=admin" class="btn btn-primary">
        <i class="fas fa-cog"></i> Gérer les produits
    </a>
</div>

<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> Vue administrateur - Vous pouvez gérer tous les produits
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
                <div class="card h-100 border-warning">
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
                                <a href="<?= BASE_URL ?>index.php?controller=produit&action=modifier&id=<?= $produit['id'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
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