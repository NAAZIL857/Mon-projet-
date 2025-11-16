<?php
$title = "Commande confirmée";
ob_start();
?>

<div class="text-center mb-4">
    <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
    <h2 class="text-success">Commande confirmée !</h2>
    <p class="lead">Votre commande n°<?= $commande['id'] ?> a été enregistrée avec succès</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-receipt"></i> Détails de votre commande</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Numéro de commande :</strong> #<?= $commande['id'] ?>
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
                        <strong>Statut :</strong> 
                        <span class="badge bg-warning">En attente</span>
                    </div>
                </div>
                
                <hr>
                
                <h6>Articles commandés :</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
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
        
        <div class="text-center mt-4">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                Vous recevrez un email de confirmation à l'adresse <?= htmlspecialchars($commande['user_email']) ?>
            </div>
            
            <div class="d-grid gap-2 d-md-block">
                <a href="<?= BASE_URL ?>index.php?controller=commande&action=historique" class="btn btn-primary">
                    <i class="fas fa-history"></i> Voir mes commandes
                </a>
                <a href="<?= BASE_URL ?>index.php?controller=produit&action=liste" class="btn btn-outline-primary">
                    <i class="fas fa-store"></i> Continuer mes achats
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>