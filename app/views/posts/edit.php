<h1 class="text-center my-5">Modifier l'article</h1>

<div class="container">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php echo "<pre>";
                print_r($errors);
                var_dump($errors);
                die ?>

                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="" enctype="multipart/form-data" class="shadow p-4 rounded">
        <!-- Titre -->
        <div class="mb-3">
            <label for="title" class="form-label">Titre de l'article</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="<?= htmlspecialchars(is_string($formData['title'] ?? $post->getTitle()) ? ($formData['title'] ?? $post->getTitle()) : '') ?>"
                required>
        </div>

        <!-- Chapeau -->
        <div class="mb-3">
            <label for="chapo" class="form-label">Chapeau</label>
            <input
                type="text"
                id="chapo"
                name="chapo"
                class="form-control"
                value="<?= htmlspecialchars(is_string($formData['chapo'] ?? $post->getChapo()) ? ($formData['chapo'] ?? $post->getChapo()) : '') ?>"
                required>
        </div>

        <!-- Contenu -->
        <div class="mb-3">
            <label for="content" class="form-label">Contenu de l'article</label>
            <textarea
                id="content"
                name="content"
                class="form-control"
                rows="6"
                required><?= htmlspecialchars(is_string($formData['content'] ?? $post->getContent()) ? ($formData['content'] ?? $post->getContent()) : '') ?></textarea>
        </div>

        <!-- Image actuelle -->
        <div class="mb-3">
            <label for="image" class="form-label">Image actuelle</label>
            <div class="mb-3">
                <img src="<?= htmlspecialchars($post->getImage()) ?>" alt="Image actuelle de l'article" style="max-width:100%; height:auto; margin-bottom: 20px;">
            </div>
        </div>

        <!-- Nouvelle image -->
        <div class="mb-3">
            <label for="image" class="form-label">Télécharger une nouvelle image</label>
            <input
                type="file"
                id="image"
                name="image"
                class="form-control"
                accept="image/*">
            <?php if (!empty($errors['image'])): ?>
                <div class="text-danger"><?= htmlspecialchars($errors['image']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Catégorie -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Catégorie</label>
            <select id="category_id" name="category_id" class="form-select">
                <option value="1" <?= ($formData['category_id'] ?? $post->getCategoryId()) == 1 ? 'selected' : '' ?>>Catégorie 1</option>
                <option value="2" <?= ($formData['category_id'] ?? $post->getCategoryId()) == 2 ? 'selected' : '' ?>>Catégorie 2</option>
                <option value="3" <?= ($formData['category_id'] ?? $post->getCategoryId()) == 3 ? 'selected' : '' ?>>Catégorie 3</option>
            </select>
        </div>

        <!-- Boutons -->
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="/user/profile" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>