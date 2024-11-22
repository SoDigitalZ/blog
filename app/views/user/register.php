<div class="container my-5">
    <h2 class="text-center">Inscription</h2>

    <!-- Affichage des erreurs générales (en haut) -->
    <?php if (!empty($fieldErrors['general'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($fieldErrors['general']) ?>
        </div>
    <?php endif; ?>

    <!-- Affichage du message de succès -->
    <?php if (isset($success)): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'inscription -->
    <form action="/user/register" method="POST" class="w-50 mx-auto needs-validation" novalidate>
        <input type="hidden" name="form_token" value="<?= htmlspecialchars($form_token ?? '') ?>">

        <!-- Champ Prénom -->
        <div class="mb-3">
            <label for="first_name" class="form-label">Prénom</label>
            <input type="text" id="first_name" name="first_name"
                class="form-control <?= isset($fieldErrors['first_name']) ? 'is-invalid' : '' ?>"
                placeholder="Entrez votre prénom"
                value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>" required>
            <?php if (isset($fieldErrors['first_name'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['first_name']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Champ Nom -->
        <div class="mb-3">
            <label for="last_name" class="form-label">Nom</label>
            <input type="text" id="last_name" name="last_name"
                class="form-control <?= isset($fieldErrors['last_name']) ? 'is-invalid' : '' ?>"
                placeholder="Entrez votre nom"
                value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" required>
            <?php if (isset($fieldErrors['last_name'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['last_name']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Champ E-mail -->
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email"
                class="form-control <?= isset($fieldErrors['email']) ? 'is-invalid' : '' ?>"
                placeholder="Entrez votre e-mail"
                value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>
            <?php if (isset($fieldErrors['email'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['email']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Champ Mot de passe -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" id="password" name="password"
                class="form-control <?= isset($fieldErrors['password']) ? 'is-invalid' : '' ?>"
                placeholder="Entrez votre mot de passe" required>
            <?php if (isset($fieldErrors['password'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['password']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Champ Confirmation du mot de passe -->
        <div class="mb-3">
            <label for="confirmedPassword" class="form-label">Confirmer le mot de passe</label>
            <input type="password" id="confirmedPassword" name="confirmedPassword"
                class="form-control <?= isset($fieldErrors['confirmedPassword']) ? 'is-invalid' : '' ?>"
                placeholder="Confirmez votre mot de passe" required>
            <?php if (isset($fieldErrors['confirmedPassword'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['confirmedPassword']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Champ Téléphone (optionnel) -->
        <div class="mb-3">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="text" id="phone" name="phone"
                class="form-control <?= isset($fieldErrors['phone']) ? 'is-invalid' : '' ?>"
                placeholder="Entrez votre numéro de téléphone"
                value="<?= htmlspecialchars($formData['phone'] ?? '') ?>">
            <?php if (isset($fieldErrors['phone'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['phone']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Bouton de soumission -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </div>
    </form>
</div>