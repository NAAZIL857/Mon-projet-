<?php
$title = "Dashboard Administrateur";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt"></i> Dashboard Administrateur</h2>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats_produits['total_produits'] ?></h4>
                        <p class="mb-0">Produits</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= BASE_URL ?>index.php?controller=produit&action=admin" class="text-white">
                    Gérer les produits <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= $stats_commandes['total_commandes'] ?></h4>
                        <p class="mb-0">Commandes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= BASE_URL ?>index.php?controller=commande&action=admin" class="text-white">
                    Voir les commandes <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?= number_format($stats_commandes['total_ventes'], 0) ?> FCFA</h4>
                        <p class="mb-0">Chiffre d'affaires</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-money-bill-wave fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <span class="text-white">Total des ventes</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="<?= BASE_URL ?>index.php?controller=produit&action=ajouter" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Ajouter un produit
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= BASE_URL ?>index.php?controller=produit&action=admin" class="btn btn-secondary w-100">
                            <i class="fas fa-list"></i> Gérer les produits
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= BASE_URL ?>index.php?controller=commande&action=admin" class="btn btn-success w-100">
                            <i class="fas fa-shopping-cart"></i> Voir les commandes
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= BASE_URL ?>index.php?controller=user&action=liste" class="btn btn-info w-100">
                            <i class="fas fa-users"></i> Gérer les utilisateurs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>