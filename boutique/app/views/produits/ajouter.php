<?php
$title = "Ajouter un produit";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Ajouter un produit</h2>
    <a href="<?= BASE_URL ?>index.php?controller=produit&action=admin" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= Session::getCSRF() ?>">
                    
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom du produit *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prix" class="form-label">Prix (FCFA) *</label>
                                <input type="number" class="form-control" id="prix" name="prix" 
                                       step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock *</label>
                                <input type="number" class="form-control" id="stock" name="stock" 
                                       min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Sélectionner une catégorie</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>">
                                    <?= htmlspecialchars($category['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Image du produit</label>
                        <input type="file" class="form-control" id="image" name="image" 
                               accept="image/jpeg,image/png,image/gif">
                        <div class="form-text">Formats acceptés : JPG, PNG, GIF. Taille max : 5MB</div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Ajouter le produit
                        </button>
                        <a href="<?= BASE_URL ?>index.php?controller=produit&action=admin" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-12 mt-3 mt-lg-0">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-info-circle"></i> Informations</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Les champs marqués * sont obligatoires</li>
                    <li><i class="fas fa-check text-success"></i> L'image sera redimensionnée automatiquement</li>
                    <li><i class="fas fa-check text-success"></i> Le produit sera visible immédiatement</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>