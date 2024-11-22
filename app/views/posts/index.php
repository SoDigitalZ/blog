<article class="posts">
    <h1 class="text-center mb-4">Articles</h1>
    <div class="row">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Titre de l'article -->
                        <div class="card-body">
                            <h2 class="card-title h5"><?= htmlspecialchars($post->getTitle()) ?></h2>
                            <!-- Contenu de l'extrait -->
                            <p class="card-text">
                                <?= htmlspecialchars(wordwrap(substr($post->getContent(), 0, 100), 75, "\n", true)) ?>...
                            </p>
                        </div>
                        <!-- Bouton "Lire la suite" -->
                        <div class="card-footer text-center">
                            <a href="/posts/show/<?= $post->getId() ?>" class="btn btn-primary w-100" aria-label="Lire l'article : <?= htmlspecialchars($post->getTitle()) ?>">
                                Lire la suite
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">Aucun article n'est disponible pour le moment.</div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Pagination des articles" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="/posts?page=<?= $i ?>" aria-label="Aller à la page <?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</article>