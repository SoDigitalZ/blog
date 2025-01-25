<h1>Modifier une catégorie</h1>

<form method="POST" action="/categories/edit/<?= $category->getId() ?>">
    <div class="form-group">
        <label for="name">Nom de la catégorie</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($category->getName()) ?>">
        <?php if (!empty($errors['name'])): ?>
            <small class="text-danger"><?= $errors['name'] ?></small>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-warning">Modifier</button>
    <a href="/categories" class="btn btn-secondary">Annuler</a>
</form>