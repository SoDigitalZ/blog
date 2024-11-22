<!-- views/user/login.php -->

<div class="container my-5">
    <article class="login-form">
        <!-- Section d'en-tête du formulaire de connexion -->
        <div class="text-center mb-4">
            <h2 class="h3">Connexion</h2>
            <img src="/picture/bvn.jpg" alt="Logo" class="img-fluid" style="max-width: 150px;">
        </div>

        <!-- Affichage des messages d'erreur généraux -->
        <?php if (!empty($fieldErrors['general'])): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($fieldErrors['general']) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <form method="POST" class="w-50 mx-auto" novalidate>
            <!-- Champ E-mail -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control <?= isset($fieldErrors['email']) ? 'is-invalid' : '' ?>"
                    placeholder="Entrez votre e-mail"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required>
                <?php if (isset($fieldErrors['email'])): ?>
                    <div class="invalid-feedback">
                        <?= htmlspecialchars($fieldErrors['email']) ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Champ Mot de passe -->
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control <?= isset($fieldErrors['password']) ? 'is-invalid' : '' ?>"
                    placeholder="Entrez votre mot de passe"
                    required>
                <?php if (isset($fieldErrors['password'])): ?>
                    <div class="invalid-feedback">
                        <?= htmlspecialchars($fieldErrors['password']) ?>
                    </div>
                <?php endif; ?>
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