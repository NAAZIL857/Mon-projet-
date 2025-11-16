<?php
$title = "Mon panier";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shopping-cart"></i> Mon panier</h2>
    <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Continuer mes achats
    </a>
</div>

<?php if (empty($panier)): ?>
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
        <h4>Votre panier est vide</h4>
        <p class="text-muted">Découvrez nos produits et ajoutez-les à votre panier</p>
        <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste" class="btn btn-primary">
            <i class="fas fa-store"></i> Voir le catalogue
        </a>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list"></i> Articles dans votre panier</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($panier as $item): ?>
                        <div class="row align-items-center border-bottom py-3">
                            <div class="col-6 col-md-2">
                                <?php if ($item['image']): ?>
                                    <img src="<?= UPLOAD_URL . $item['image'] ?>" alt="<?= htmlspecialchars($item['nom']) ?>" 
                                         class="img-fluid rounded">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-6 col-md-4">
                                <h6><?= htmlspecialchars($item['nom']) ?></h6>
                                <small class="text-muted">Prix unitaire : <?= number_format($item['prix'], 0) ?> FCFA</small>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="updateQuantity(<?= $item['id'] ?>, -1, this)">-</button>
                                    <input type="text" class="form-control text-center" 
                                           value="<?= $item['quantite'] ?>" readonly id="qty-<?= $item['id'] ?>">
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="updateQuantity(<?= $item['id'] ?>, 1, this)">+</button>
                                </div>
                            </div>
                            <div class="col-4 col-md-2 text-end">
                                <strong><?= number_format($item['prix'] * $item['quantite'], 0) ?> FCFA</strong>
                            </div>
                            <div class="col-4 col-md-2 text-end">
                                <a href="<?= BASE_URL ?>index.php?controller=commande&action=retirerPanier&id=<?= $item['id'] ?>" 
                                   class="btn btn-outline-danger btn-sm" 
                                   onclick="return confirm('Retirer cet article du panier ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-12 mt-3 mt-lg-0">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-calculator"></i> Récapitulatif</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total :</span>
                        <span><?= number_format($total, 0) ?> FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Livraison :</span>
                        <span class="text-success">Gratuite</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total :</strong>
                        <strong class="text-primary"><?= number_format($total, 0) ?> FCFA</strong>
                    </div>
                    
                    <?php if (Session::isLoggedIn()): ?>
                        <div class="d-grid gap-2">
                            <a href="<?= BASE_URL ?>index.php?controller=commande&action=commander" 
                               class="btn btn-success btn-lg">
                                <i class="fas fa-credit-card"></i> Passer commande
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            Vous devez être connecté pour passer commande
                        </div>
                        <div class="d-grid gap-2">
                            <a href="<?= BASE_URL ?>index.php?controller=user&action=login" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Se connecter
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="<?= BASE_URL ?>index.php?controller=commande&action=viderPanier" 
                   class="btn btn-outline-danger w-100"
                   onclick="return confirm('Vider complètement le panier ?')">
                    <i class="fas fa-trash"></i> Vider le panier
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
?>

<?php ob_start(); ?>
<script>
function updateQuantity(productId, change, button) {
    const quantityInput = document.getElementById('qty-' + productId);
    if (!quantityInput) return;
    
    let currentQuantity = parseInt(quantityInput.value) || 1;
    let newQuantity = currentQuantity + change;
    
    if (newQuantity < 1) return;
    
    button.disabled = true;
    
    fetch('<?= BASE_URL ?>index.php?controller=commande&action=updateQuantity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'produit_id=' + productId + '&quantite=' + newQuantity
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Erreur');
            button.disabled = false;
        }
    })
    .catch(error => {
        alert('Erreur');
        button.disabled = false;
    });
}
</script>
<?php $extraScript = ob_get_clean(); ?>

<?php include __DIR__ . '/../layout.php'; ?>