<article class="post mx-auto" style="max-width: 800px;">
    <!-- Titre centré -->
    <h1 class="text-center mb-4"><?= htmlspecialchars($post->getTitle()) ?></h1>

    <!-- Image centrée -->
    <div class="text-center">
        <img src="<?= htmlspecialchars($post->getImage()) ?>" alt="Image de l'article" style="max-width:100%; height:auto; margin-bottom: 20px;">
    </div>

    <!-- Contenu aligné à gauche -->
    <p><?= nl2br(htmlspecialchars($post->getContent())) ?></p>

    <p class="text-muted"><em>Publié le : <?= htmlspecialchars($post->getCreatedAt()) ?></em></p>

    <?php if ($_SESSION['user']['id'] === $post->getUserId()): ?>
        <a href="/posts/edit/<?= $post->getId() ?>" class="btn btn-warning">Modifier</a>
        <!-- Bouton Supprimer -->
        <form action="/posts/delete/<?= $post->getId() ?>" method="post" style="display:inline;">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');">Supprimer</button>
        </form>
    <?php endif; ?>
</article>