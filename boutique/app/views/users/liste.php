<?php
$title = "Gestion des utilisateurs";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users"></i> Gestion des utilisateurs</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucun utilisateur trouvé</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><strong>#<?= $user['id'] ?></strong></td>
                                <td><?= htmlspecialchars($user['nom']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <?php if ($user['role'] !== 'admin' || Session::getUserId() != $user['id']): ?>
                                            <button class="btn btn-outline-warning" title="Modifier le rôle"
                                                    onclick="toggleRole(<?= $user['id'] ?>, '<?= $user['role'] ?>')">
                                                <i class="fas fa-user-cog"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if (Session::getUserId() != $user['id']): ?>
                                            <a href="<?= BASE_URL ?>index.php?controller=user&action=supprimer&id=<?= $user['id'] ?>" 
                                               class="btn btn-outline-danger" title="Supprimer"
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
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

<script>
function toggleRole(userId, currentRole) {
    const newRole = currentRole === 'admin' ? 'client' : 'admin';
    const message = `Changer le rôle de cet utilisateur en ${newRole} ?`;
    
    if (confirm(message)) {
        window.location.href = `<?= BASE_URL ?>index.php?controller=user&action=toggleRole&id=${userId}&role=${newRole}`;
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>