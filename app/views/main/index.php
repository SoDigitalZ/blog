<article class="main-header">
    <div class="main-header-phrasing">
        <h1>Mon Parcours de Développeur</h1>
        <h2>Formation, apprentissage, et projets.</h2>
        <div class="main-header-button">
            <a href="/posts" class="btn btn-primary articles">Mes Articles</a>
            <a href="#contact" class="btn btn-secondary contact">Contactez-moi</a>
        </div>
    </div>
    <img src="/picture/Acceuil.webp" alt="Image de présentation" class="img-fluid">
</article>

<article class="main-form">
    <h2>Une question, une suggestion ?</h2>
    <form method="POST" id="contact">
        <div class="main-form-text mb-3">
            <input type="text" name="firstname" class="form-control mb-2" placeholder="Nom" required>
            <input type="text" name="lastname" class="form-control mb-2" placeholder="Prénom" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
        </div>
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="4" placeholder="Votre message..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Envoyer</button>
    </form>
</article>