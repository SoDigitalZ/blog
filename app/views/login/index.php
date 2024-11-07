<!-- views/user/login.php -->

<!-- Intégration de Bootstrap pour le formulaire de connexion -->
<div class="container my-5">
    <article class="login-form">
        <!-- Section d'en-tête du formulaire de connexion -->
        <div class="text-center mb-4">
            <h2 class="h3">Connexion</h2>
            <img src="/picture/bvn.jpg" alt="Logo" class="img-fluid" style="max-width: 150px;">
        </div>

        <!-- Affichage des messages d'erreur -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <form method="POST" class="w-50 mx-auto">
            <!-- Champ E-mail -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Entrez votre e-mail" required>
            </div>

            <!-- Champ Mot de passe -->
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
            </div>

            <!-- Bouton Valider -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Valider</button>
            </div>
        </form>

        <!-- Lien vers l'inscription -->
        <div class="text-center mt-3">
            <p>Pas encore inscrit ? <a href="/user/register">Créez un compte</a></p>
        </div>
    </article>
</div>