<div class="container my-5">
    <h1 class="text-center">Créer un nouvel article</h1>

    <form method="POST" action="/posts/create" enctype="multipart/form-data" novalidate>
        <!-- Titre -->
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Entrez le titre" value="<?= htmlspecialchars($formData['title'] ?? '') ?>" required>
            <?php if (!empty($errors['title'])): ?>
                <div class="text-danger"><?= htmlspecialchars($errors['title']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Chapeau -->
        <div class="mb-3">
            <label for="chapo" class="form-label">Chapeau</label>
            <input type="text" name="chapo" id="chapo" class="form-control" placeholder="Entrez le chapeau" value="<?= htmlspecialchars($formData['chapo'] ?? '') ?>" required>
            <?php if (!empty($errors['chapo'])): ?>
                <div class="text-danger"><?= htmlspecialchars($errors['chapo']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Contenu -->
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea name="content" id="content" rows="6" class="form-control" placeholder="Entrez le contenu de l'article" required><?= htmlspecialchars($formData['content'] ?? '') ?></textarea>
            <?php if (!empty($errors['content'])): ?>
                <div class="text-danger"><?= htmlspecialchars($errors['content']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Image de l'article</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <?php if (!empty($errors['image'])): ?>
                <div class="text-danger"><?= htmlspecialchars($errors['image']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Soumettre -->
        <button type="submit" class="btn btn-success">Créer l'article</button>

        <!-- Retour -->
        <a href="/user/profile" class="btn btn-secondary">Retour</a>
    </form>
</div>