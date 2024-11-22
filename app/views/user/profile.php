<div class="container my-5">
    <h1 class="text-center">Profil de <?= htmlspecialchars($user['email']) ?></h1>

    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <p><strong>Email : </strong><?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Prénom : </strong><?= htmlspecialchars($user['first_name'] ?? 'Non renseigné') ?></p>
            <p><strong>Nom : </strong><?= htmlspecialchars($user['last_name'] ?? 'Non renseigné') ?></p>
            <a href="/" class="btn btn-primary w-100">Retour à l'accueil</a>
        </div>
    </div>
</div>