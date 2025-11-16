<?php
$title = "Gestion des produits";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-box"></i> Gestion des produits</h2>
    <a href="<?= BASE_URL ?>index.php?controller=produit&action=ajouter" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter un produit
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produits)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucun produit trouvé</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produits as $produit): ?>
                            <tr>
                                <td>
                                    <?php if ($produit['image']): ?>
                                        <img src="<?= UPLOAD_URL . $produit['image'] ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" 
                                             class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($produit['nom']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars(substr($produit['description'], 0, 50)) ?>...</small>
                                </td>
                                <td><?= htmlspecialchars($produit['category_name'] ?? 'Sans catégorie') ?></td>
                                <td><?= number_format($produit['prix'], 0) ?> FCFA</td>
                                <td>
                                    <span class="badge <?= $produit['stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $produit['stock'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>index.php?controller=produit&action=detail&id=<?= $produit['id'] ?>" 
                                           class="btn btn-outline-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>index.php?controller=produit&action=modifier&id=<?= $produit['id'] ?>" 
                                           class="btn btn-outline-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>index.php?controller=produit&action=supprimer&id=<?= $produit['id'] ?>" 
                                           class="btn btn-outline-danger" title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
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