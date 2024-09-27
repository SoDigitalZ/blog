<h2>Modifier la catégorie</h2>

<form method="post">
    <div class="form-group">
        <label for="name">Nom de la catégorie</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($category->getName()) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>