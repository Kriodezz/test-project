<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/../css/bootstrap.min.css">
    <link rel="stylesheet" href="/../css/bootstrap-utilities.css">
    <link rel="stylesheet" href="/../css/style.css">
    <title><?php echo $title ?? ''; ?></title>
</head>

<body>
<div class="main-wrapper">
    <div class="content">

        <!-- Навигационная панель -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Test</a>
                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav"
                        aria-controls="navbarNav"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                        <!-- Страница с материалами -->
                        <li class="nav-item">
                            <a class="nav-link <?php if ($title === 'Материалы') {
                                echo 'active';
                            } ?>" aria-current="page" href="/">
                                Материалы
                            </a>
                        </li>

                        <!-- Страница с тегами -->
                        <li class="nav-item">
                            <a class="nav-link <?php if ($title === 'Теги') {
                                echo 'active';
                            } ?>" href="/tags/show">Теги</a>
                        </li>
                        <!-- Страница с категориями -->
                        <li class="nav-item">
                            <a class="nav-link <?php if ($title === 'Категории') {
                                echo 'active';
                            } ?>" href="/categories/show">Категории</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
