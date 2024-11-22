<article class="main-header text-center py-5 bg-light">
    <div class="container">
        <div class="main-header-phrasing">
            <h1 class="display-4">Sofian Saint-Denis</h1>
            <h2 class="text-secondary">Formation, apprentissage, et projets.</h2>
            <p class="lead mt-3">"Le développeur qu'il vous faut pour vos projets ambitieux !"</p>
            <div class="main-header-button mt-4">
                <a href="/posts" class="btn btn-primary btn-lg me-2 articles">Mes Articles</a>
                <a href="#contact" class="btn btn-outline-secondary btn-lg contact">Contactez-moi</a>
            </div>
        </div>
        <div class="mt-4">
            <img src="/picture/Acceuil.webp" alt="Image de présentation" class="img-fluid rounded shadow" style="max-width: 600px;">
        </div>
    </div>
</article>

<article class="main-form my-5">
    <div class="container">
        <h2 class="text-center text-primary">Une question, une suggestion ?</h2>
        <p class="text-center text-muted">Remplissez le formulaire ci-dessous, et je vous répondrai rapidement.</p>
        <form method="POST" id="contact" class="mt-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="firstname" class="form-label">Nom</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Nom" required>
                </div>
                <div class="col-md-6">
                    <label for="lastname" class="form-label">Prénom</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Prénom" required>
                </div>
            </div>
            <div class="mt-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Votre email" required>
            </div>
            <div class="mt-3">
                <label for="content" class="form-label">Message</label>
                <textarea id="content" name="content" class="form-control" rows="5" placeholder="Votre message..." required></textarea>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-lg px-5">Envoyer</button>
            </div>
        </form>
    </div>
</article>