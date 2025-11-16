<?php
$title = "Gestion des commandes";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shopping-cart"></i> Gestion des commandes</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($commandes)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucune commande trouvée</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($commandes as $commande): ?>
                            <tr>
                                <td><strong>#<?= $commande['id'] ?></strong></td>
                                <td>
                                    <strong><?= htmlspecialchars($commande['user_name']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($commande['user_email']) ?></small>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($commande['created_at'])) ?></td>
                                <td><strong><?= number_format($commande['total'], 0) ?> FCFA</strong></td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $commande['statut'] === 'en_attente' ? 'warning' : 
                                        ($commande['statut'] === 'confirmee' ? 'info' : 
                                        ($commande['statut'] === 'expediee' ? 'primary' : 'success')) 
                                    ?>">
                                        <?= ucfirst(str_replace('_', ' ', $commande['statut'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>index.php?controller=commande&action=detail&id=<?= $commande['id'] ?>" 
                                           class="btn btn-outline-info" title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                                                    data-bs-toggle="dropdown" title="Changer statut">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=commande&action=updateStatut&id=<?= $commande['id'] ?>&statut=en_attente">En attente</a></li>
                                                <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=commande&action=updateStatut&id=<?= $commande['id'] ?>&statut=confirmee">Confirmée</a></li>
                                                <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=commande&action=updateStatut&id=<?= $commande['id'] ?>&statut=expediee">Expédiée</a></li>
                                                <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=commande&action=updateStatut&id=<?= $commande['id'] ?>&statut=livree">Livrée</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>