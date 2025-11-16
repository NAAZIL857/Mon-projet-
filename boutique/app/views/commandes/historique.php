<?php
$title = "Mes commandes";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-history"></i> Mes commandes</h2>
    <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste" class="btn btn-primary">
        <i class="fas fa-store"></i> Continuer mes achats
    </a>
</div>

<?php if (empty($commandes)): ?>
    <div class="text-center py-5">
        <i class="fas fa-shopping-bag fa-5x text-muted mb-3"></i>
        <h4>Aucune commande</h4>
        <p class="text-muted">Vous n'avez pas encore passé de commande</p>
        <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste" class="btn btn-primary">
            <i class="fas fa-store"></i> Découvrir nos produits
        </a>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($commandes as $commande): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Commande #<?= $commande['id'] ?></h6>
                        <span class="badge bg-<?= 
                            $commande['statut'] === 'en_attente' ? 'warning' : 
                            ($commande['statut'] === 'confirmee' ? 'info' : 
                            ($commande['statut'] === 'expediee' ? 'primary' : 'success')) 
                        ?>">
                            <?= ucfirst(str_replace('_', ' ', $commande['statut'])) ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <small class="text-muted">Date :</small><br>
                                <strong><?= date('d/m/Y H:i', strtotime($commande['created_at'])) ?></strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted">Total :</small><br>
                                <strong class="text-primary"><?= number_format($commande['total'], 0) ?> FCFA</strong>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <a href="<?= BASE_URL ?>index.php?controller=commande&action=confirmation&id=<?= $commande['id'] ?>" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>