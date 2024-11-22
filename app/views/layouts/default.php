<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? 'Mon blog' ?></title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .footer img {
            transition: transform 0.2s ease;
        }

        .footer img:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <!-- Header/Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a href="/" class="navbar-brand">Mon Blog</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="/posts" class="nav-link" aria-label="Voir les articles">Articles</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact" class="nav-link" aria-label="Me contacter">Contact</a>
                        </li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <!-- Utilisateur connecté -->
                            <li class="nav-item">
                                <a href="/user/profile" class="nav-link" aria-label="Voir votre profil"><?= htmlspecialchars($_SESSION['user']['email']) ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/logout" class="nav-link" aria-label="Se déconnecter">Se déconnecter</a>
                            </li>
                        <?php else: ?>
                            <!-- Utilisateur non connecté -->
                            <li class="nav-item">
                                <a href="/user/login" class="nav-link" aria-label="Se connecter">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/register" class="nav-link" aria-label="S'inscrire">Inscription</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main content -->
    <main class="flex-shrink-0">
        <div class="container mt-4">
            <?= $content ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light py-4 footer mt-auto">
        <div class="container text-center">
            <p class="mb-1">© 2024 Mon Blog - Tous droits réservés</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="https://github.com/SofianSaintDenis" target="_blank" aria-label="Visitez mon profil GitHub">
                    <img src="/picture/icons/github-48.png" alt="GitHub" class="img-fluid" style="max-width: 40px;">
                </a>
                <a href="https://www.linkedin.com/in/sofian-saint-denis/" target="_blank" aria-label="Visitez mon profil LinkedIn">
                    <img src="/picture/icons/linkedin-48.png" alt="LinkedIn" class="img-fluid" style="max-width: 40px;">
                </a>
                <a href="https://twitter.com/SofianSaintDenis" target="_blank" aria-label="Visitez mon profil Twitter">
                    <img src="/picture/icons/twitter-48.png" alt="Twitter" class="img-fluid" style="max-width: 40px;">
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>