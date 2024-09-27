<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Dynamic title -->
    <title><?= $title ?? 'Mon blog' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a href="/" class="navbar-brand">Mon Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="/posts" class="nav-link">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a href="/user/index" class="nav-link">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
                <a href="https://github.com/SofianSaintDenis" target="_blank">
                    <img src="/picture/icons/github.svg" alt="Github" class="img-fluid" style="max-width: 40px;">
                </a>
                <a href="https://www.linkedin.com/in/sofian-saint-denis/" target="_blank">
                    <img src="/picture/icons/linkedin.svg" alt="LinkedIn" class="img-fluid" style="max-width: 40px;">
                </a>
                <a href="https://twitter.com/SofianSaintDenis" target="_blank">
                    <img src="/picture/icons/twitter.svg" alt="Twitter" class="img-fluid" style="max-width: 40px;">
                </a>
                <a href="/picture/CV.pdf" target="_blank">
                    <img src="/picture/icons/cv.png" alt="CV" class="img-fluid" style="max-width: 40px;">
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-NNeHO6IQt1BzVr4NhvJOvOG6HrWfFzRflrjJzJ7nNWEvrDJZJjcTiZ2pcuBYNPqa" crossorigin="anonymous"></script>
</body>

</html>