<?php
$title = "Détail de la commande";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-receipt"></i> Commande #<?= $commande['id'] ?></h2>
    <a href="<?= BASE_URL ?>index.php?controller=commande&action=admin" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Informations de la commande</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Numéro :</strong> #<?= $commande['id'] ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande['created_at'])) ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Client :</strong> <?= htmlspecialchars($commande['user_name']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Email :</strong> <?= htmlspecialchars($commande['user_email']) ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Total :</strong> <?= number_format($commande['total'], 0) ?> FCFA
                    </div>
                    <div class="col-md-6">
                        <strong>Statut :</strong> 
                        <span class="badge bg-<?= 
                            $commande['statut'] === 'en_attente' ? 'warning' : 
                            ($commande['statut'] === 'confirmee' ? 'info' : 
                            ($commande['statut'] === 'expediee' ? 'primary' : 'success')) 
                        ?>">
                            <?= ucfirst(str_replace('_', ' ', $commande['statut'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Articles commandés</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($details as $detail): ?>
                                <tr>
                                    <td>
                                        <?php if ($detail['image']): ?>
                                            <img src="<?= UPLOAD_URL . $detail['image'] ?>" alt="<?= htmlspecialchars($detail['produit_name']) ?>" 
                                                 class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php endif; ?>
                                        <?= htmlspecialchars($detail['produit_name']) ?>
                                    </td>
                                    <td><?= number_format($detail['prix_unitaire'], 0) ?> FCFA</td>
                                    <td><?= $detail['quantite'] ?></td>
                                    <td><?= number_format($detail['prix_unitaire'] * $detail['quantite'], 0) ?> FCFA</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th colspan="3">Total de la commande :</th>
                                <th><?= number_format($commande['total'], 0) ?> FCFA</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-cog"></i> Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>index.php?controller=commande&action=updateStatut&id=<?= $commande['id'] ?>&statut=confirmee" 
                       class="btn btn-info btn-sm">Confirmer</a>
                    <a href="<?= BASE_URL ?>index.php?controller=commande&action=updateStatut&id=<?= $commande['id'] ?>&statut=expediee" 
                       class="btn btn-primary btn-sm">Expédier</a>
                    <a href="<?= BASE_URL ?>index.php?controller=commande&action=updateStatut&id=<?= $commande['id'] ?>&statut=livree" 
                       class="btn btn-success btn-sm">Marquer livrée</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>