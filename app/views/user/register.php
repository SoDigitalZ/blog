<!-- views/user/register.php -->

<div class="container my-5">
    <h2 class="text-center">Inscription</h2>

    <!-- Affichage des messages d'erreur -->
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Affichage des messages de succès -->
    <?php if (isset($success)): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'inscription -->
    <form action="/user/register" method="POST" class="w-50 mx-auto">
        <!-- Champ caché pour le form_token -->
        <input type="hidden" name="form_token" value="<?= htmlspecialchars($form_token ?? '') ?>">

        <!-- Champ Prénom -->
        <div class="mb-3">
            <label for="first_name" class="form-label">Prénom</label>
            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Entrez votre prénom" required>
        </div>

        <!-- Champ Nom -->
        <div class="mb-3">
            <label for="last_name" class="form-label">Nom</label>
            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Entrez votre nom" required>
        </div>

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

        <!-- Champ Confirmation du mot de passe -->
        <div class="mb-3">
            <label for="confirmedPassword" class="form-label">Confirmer le mot de passe</label>
            <input type="password" id="confirmedPassword" name="confirmedPassword" class="form-control" placeholder="Confirmez votre mot de passe" required>
        </div>

        <!-- Champ Téléphone (optionnel) -->
        <div class="mb-3">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="text" id="phone" name="phone" class="form-control" placeholder="Entrez votre numéro de téléphone">
        </div>

        <!-- Bouton de soumission -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </div>
    </form>
</div>