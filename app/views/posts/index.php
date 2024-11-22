<article class="posts">
    <h1 class="text-center mb-4">Articles</h1>
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Titre de l'article -->
                    <div class="card-body">
                        <h2 class="card-title h5"><?= htmlspecialchars($post->getTitle()) ?></h2>
                        <!-- Contenu de l'extrait -->
                        <p class="card-text">
                            <?= htmlspecialchars(substr($post->getContent(), 0, 100)) ?>...
                        </p>
                    </div>
                    <!-- Bouton "Lire la suite" -->
                    <div class="card-footer text-center">
                        <a href="/posts/show/<?= $post->getId() ?>" class="btn btn-primary w-100">
                            Lire la suite
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</article>