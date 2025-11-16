<?php
$title = "Catalogue des produits";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-store"></i> Catalogue des produits</h2>
    <a href="<?= BASE_URL ?>index.php?controller=commande&action=panier" class="btn btn-success">
        <i class="fas fa-shopping-cart"></i> Mon panier (<?= count(Session::get('panier', [])) ?>)
    </a>
</div>

<div class="alert alert-success">
    <i class="fas fa-user"></i> Bienvenue <?= Session::get('user_name') ?> ! Vous pouvez ajouter des produits à votre panier.
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
                                <?php if ($produit['stock'] > 0): ?>
                                    <button class="btn btn-success btn-sm add-to-cart" 
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
?>

<?php ob_start(); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const originalText = this.innerHTML;
            
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Ajout...';
            this.disabled = true;
            
            fetch('<?= BASE_URL ?>index.php?controller=commande&action=ajaxAjouterAuPanier', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'produit_id=' + productId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const countElement = document.querySelector('.btn-success');
                    if (countElement) {
                        countElement.innerHTML = '<i class="fas fa-shopping-cart"></i> Mon panier (' + data.panierCount + ')';
                    }
                    
                    this.innerHTML = '<i class="fas fa-check"></i> Ajouté !';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-primary');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-success');
                        this.disabled = false;
                    }, 2000);
                } else {
                    alert(data.message || 'Erreur');
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                alert('Erreur');
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
});
</script>
<?php $extraScript = ob_get_clean(); ?>

<?php include __DIR__ . '/../layout.php'; ?>