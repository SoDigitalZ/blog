<h1>Ajouter une catégorie</h1>

<form method="POST" action="/categories/create">
    <div class="form-group">
        <label for="name">Nom de la catégorie</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($formData['name'] ?? '') ?>">
        <?php if (!empty($errors['name'])): ?>
            <small class="text-danger"><?= $errors['name'] ?></small>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-success">Créer</button>
    <a href="/categories" class="btn btn-secondary">Annuler</a>
</form>