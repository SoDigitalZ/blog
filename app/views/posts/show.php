<article class="post">
    <h1><?= htmlspecialchars($post->getTitle()) ?></h1>
    <p><?= nl2br(htmlspecialchars($post->getContent())) ?></p>
    <p><em>Publié le : <?= htmlspecialchars($post->getCreatedAt()) ?></em></p>
</article>