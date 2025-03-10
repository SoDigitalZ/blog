<div class="container my-5">
    <h1 class="text-center">Profil de <?= htmlspecialchars($user['email']) ?></h1>

    <!-- Informations utilisateur -->
    <div class="card mx-auto mb-4 shadow-sm" style="max-width: 400px;">
        <div class="card-body">
            <h2 class="h5 mb-3">Informations personnelles</h2>
            <p><strong>Email : </strong><?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Prénom : </strong><?= htmlspecialchars($user['first_name'] ?? 'Non renseigné') ?></p>
            <p><strong>Nom : </strong><?= htmlspecialchars($user['last_name'] ?? 'Non renseigné') ?></p>
            <a href="/" class="btn btn-primary w-100 mt-3">Retour à l'accueil</a>
        </div>
    </div>

    <!-- Articles de l'utilisateur -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center">Vos articles</h2>
        <a href="/categories" class="btn btn-info">Gérer les catégories</a>
        <a href="/posts/create" class="btn btn-success">Créer un nouvel article</a>
    </div>

    <?php if (!empty($posts)): ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post->getTitle()) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($post->getContent(), 0, 100)) ?>...</p>
                            <a href="/posts/edit/<?= $post->getId() ?>" class="btn btn-warning">Modifier</a>
                            <!-- Bouton Supprimer -->
                            <form action="/posts/delete/<?= $post->getId() ?>" method="post" style="display:inline;">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');">Supprimer</button>
                            </form>
                        </div>
                        <div class="card-footer text-muted">
                            <i class="bi bi-calendar"></i>
                            Publié le <?= date('d/m/Y', strtotime($post->getCreatedAt())) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">
            Vous n'avez encore écrit aucun article.
        </div>
    <?php endif; ?>
</div>