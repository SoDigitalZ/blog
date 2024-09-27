<h2>Catégorie : <?= htmlspecialchars($category->getName()) ?></h2>
<a href="/category/update/<?= $category->getId() ?>" class="btn btn-warning">Modifier</a>
<a href="/category/delete/<?= $category->getId() ?>" class="btn btn-danger" onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</a>

<h2>Liste des catégories</h2>
<a href="/category/add" class="btn btn-success mb-2">Ajouter une catégorie</a>
<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category->getName()) ?></td>
                <td>
                    <a href="/category/read/<?= $category->getId() ?>" class="btn btn-info">Voir</a>
                    <a href="/category/update/<?= $category->getId() ?>" class="btn btn-warning">Modifier</a>
                    <a href="/category/delete/<?= $category->getId() ?>" class="btn btn-danger" onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>