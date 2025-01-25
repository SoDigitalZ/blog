<h1>Liste des catégories</h1>
<a href="/categories/create" class="btn btn-primary">Ajouter une catégorie</a>

<?php if (Session::has('success')): ?>
    <div class="alert alert-success"><?= Session::get('success') ?></div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category->getId() ?></td>
                <td><?= htmlspecialchars($category->getName()) ?></td>
                <td>
                    <a href="/categories/edit/<?= $category->getId() ?>" class="btn btn-warning">Modifier</a>
                    <a href="/categories/delete/<?= $category->getId() ?>" class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>