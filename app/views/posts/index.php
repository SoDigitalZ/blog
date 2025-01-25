<article class="posts">
    <h1 class="text-center mb-4">Articles</h1>
    <div class="row">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title h5"><?= htmlspecialchars($post->getTitle()) ?></h2>
                            <p class="card-text">
                                <?= htmlspecialchars(wordwrap(substr($post->getContent(), 0, 100), 75, "\n", true)) ?>...
                            </p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="/posts/show/<?= $post->getId() ?>" class="btn btn-primary w-100" aria-label="Lire l'article : <?= htmlspecialchars($post->getTitle()) ?>">Lire la suite</a>
                            <?php if ($_SESSION['user']['id'] === $post->getUserId()): ?>
                                <!-- Bouton Supprimer -->
                                <form action="/posts/delete/<?= $post->getId() ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-danger w-100 mt-2" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">Aucun article n'est disponible pour le moment.</div>
        <?php endif; ?>
    </div>
</article>