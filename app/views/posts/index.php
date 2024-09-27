<article class="posts">
    <h1>Articles</h1>
    <?php foreach ($posts as $post): ?>
        <div class="post-extract mb-3">
            <h2><?= $post->title ?></h2>
            <p><?= substr($post->content, 0, 100) ?>...</p>
            <a href="/posts/show/<?= $post->id ?>" class="btn btn-primary">Lire la suite</a>
        </div>
    <?php endforeach; ?>
</article>