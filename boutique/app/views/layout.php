<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Boutique E-commerce' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>css/style.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>favicon.ico">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary custom-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="<?= BASE_URL ?>">
                <i class="fas fa-store"></i> GabonShop
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?controller=produit&action=liste">
                            <i class="fas fa-home"></i> Accueil
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (Session::isLoggedIn() && !Session::isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>index.php?controller=commande&action=panier">
                                <i class="fas fa-shopping-cart"></i> Panier 
                                <span class="badge bg-warning" id="panier-count">
                                    <?= count(Session::get('panier', [])) ?>
                                </span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (Session::isLoggedIn()): ?>
                        <?php if (Session::isAdmin()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog"></i> Admin
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=user&action=dashboard">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=produit&action=admin">Produits</a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=commande&action=admin">Commandes</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?= Session::get('user_name') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=commande&action=historique">Mes commandes</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=user&action=logout">Déconnexion</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>index.php?controller=user&action=login">
                                <i class="fas fa-sign-in-alt"></i> Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>index.php?controller=user&action=register">
                                <i class="fas fa-user-plus"></i> Inscription
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container my-4">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>GabonShop</h5>
                    <p>Votre boutique en ligne de confiance</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>&copy; 2025 GabonShop. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>js/app.js"></script>
    <?= $extraScript ?? '' ?>
</body>
</html>