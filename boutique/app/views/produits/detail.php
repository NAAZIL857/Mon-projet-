<?php
$title = htmlspecialchars($produit['nom']);
ob_start();
?>

<div class="row">
    <div class="col-lg-6 col-md-12 mb-4">
        <?php if ($produit['image']): ?>
            <img src="<?= UPLOAD_URL . $produit['image'] ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($produit['nom']) ?>">
        <?php else: ?>
            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                <i class="fas fa-image fa-5x text-muted"></i>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="col-lg-6 col-md-12">
        <div class="card h-100">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste">Catalogue</a>
                        </li>
                        <li class="breadcrumb-item active"><?= htmlspecialchars($produit['nom']) ?></li>
                    </ol>
                </nav>
                
                <h1><?= htmlspecialchars($produit['nom']) ?></h1>
                
                <p class="text-muted">
                    <i class="fas fa-tag"></i> <?= htmlspecialchars($produit['category_name'] ?? 'Sans catégorie') ?>
                </p>
                
                <div class="mb-3">
                    <span class="h3 text-primary"><?= number_format($produit['prix'], 0) ?> FCFA</span>
                </div>
                
                <div class="mb-3">
                    <strong>Stock disponible :</strong> 
                    <span class="badge <?= $produit['stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                        <?= $produit['stock'] ?> unité(s)
                    </span>
                </div>
                
                <div class="mb-4">
                    <h5>Description</h5>
                    <p><?= nl2br(htmlspecialchars($produit['description'])) ?></p>
                </div>
                
                <?php if (Session::isAdmin()): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-user-shield"></i> 
                        <strong>Mode administrateur</strong> - Vous pouvez modifier ce produit mais pas l'acheter.
                    </div>
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>index.php?controller=produit&action=modifier&id=<?= $produit['id'] ?>" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit"></i> Modifier ce produit
                        </a>
                    </div>
                <?php elseif (Session::isLoggedIn()): ?>
                    <?php if ($produit['stock'] > 0): ?>
                        <form method="POST" action="<?= BASE_URL ?>index.php?controller=commande&action=ajouterPanier" class="mb-3">
                            <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                            
                            <label for="quantite" class="form-label">Quantité</label>
                            <div class="input-group" style="max-width: 150px;">
                                <button class="btn btn-outline-secondary" type="button" id="quantity-minus">-</button>
                                <input type="text" class="form-control text-center" id="quantite" name="quantite" 
                                       value="1" min="1" max="<?= $produit['stock'] ?>" readonly>
                                <button class="btn btn-outline-secondary" type="button" id="quantity-plus">+</button>
                            </div>
                            
                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-cart-plus"></i> Ajouter au panier
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Ce produit est actuellement en rupture de stock.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Connectez-vous</strong> pour ajouter ce produit à votre panier.
                    </div>
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>index.php?controller=user&action=login" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </a>
                        <a href="<?= BASE_URL ?>index.php?controller=user&action=register" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus"></i> Créer un compte
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="d-grid">
                    <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour au catalogue
                    </a>
                </div>
            </div>
        </div>
</div>

<?php
$content = ob_get_clean();
?>

<?php ob_start(); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantite');
    const minusBtn = document.getElementById('quantity-minus');
    const plusBtn = document.getElementById('quantity-plus');
    
    if (quantityInput && minusBtn && plusBtn) {
        const maxStock = parseInt(quantityInput.getAttribute('max'));
        
        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            }
        });
    }
});
</script>
<?php $extraScript = ob_get_clean(); ?>

<?php include __DIR__ . '/../layout.php'; ?>