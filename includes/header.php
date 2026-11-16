<?php
$pageTitle = $pageTitle ?? 'BookManager';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?> | BookManager</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <div class="app-container">

        <aside class="sidebar">
            <div class="brand">
                <i class="bi bi-book-half"></i>
                <span>BookManager</span>
            </div>

            <nav class="nav flex-column">
                <a class="nav-link" href="/index.php">
                    <i class="bi bi-house-door"></i>
                    Inicio
                </a>

                <a class="nav-link" href="/views/tiendas/index.php">
                    <i class="bi bi-shop"></i>
                    Tiendas
                </a>

                <a class="nav-link" href="/views/titulos/index.php">
                    <i class="bi bi-journal-bookmark"></i>
                    Títulos
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div>
                    <h1><?= htmlspecialchars($pageTitle) ?></h1>
                    <p>Sistema de Gestión de Librería</p>
                </div>

                <div class="student">
                    <i class="bi bi-person-circle"></i>
                    Joel Barrientos Jiménez
                </div>
            </header>

            <section class="content">