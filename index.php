<?php

require_once __DIR__ . '/config/database.php';

$pageTitle = 'Panel principal';

$totalTiendas = 0;
$totalTitulos = 0;
$totalPublicadores = 0;
$errorConexion = '';

try {
    $database = new Database();
    $db = $database->connect();

    $stmtTiendas = $db->prepare(
        "SELECT COUNT(*) FROM tiendas"
    );
    $stmtTiendas->execute();
    $totalTiendas = (int) $stmtTiendas->fetchColumn();

    $stmtTitulos = $db->prepare(
        "SELECT COUNT(*) FROM titulos"
    );
    $stmtTitulos->execute();
    $totalTitulos = (int) $stmtTitulos->fetchColumn();

    $stmtPublicadores = $db->prepare(
        "SELECT COUNT(*) FROM publicadores"
    );
    $stmtPublicadores->execute();
    $totalPublicadores = (int) $stmtPublicadores->fetchColumn();

} catch (PDOException $error) {
    $errorConexion = 'No fue posible consultar la base de datos.';
}

require_once __DIR__ . '/includes/header.php';
?>

<?php if ($errorConexion): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($errorConexion) ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-dashboard h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary mb-1">Tiendas registradas</p>
                        <h2 class="display-5 fw-bold mb-0">
                            <?= $totalTiendas ?>
                        </h2>
                    </div>

                    <div class="bg-primary text-white rounded-4 p-3">
                        <i class="bi bi-shop fs-2"></i>
                    </div>
                </div>

                <a
                    href="/views/tiendas/index.php"
                    class="btn btn-outline-primary mt-4"
                >
                    Administrar tiendas
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-dashboard h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary mb-1">Títulos disponibles</p>
                        <h2 class="display-5 fw-bold mb-0">
                            <?= $totalTitulos ?>
                        </h2>
                    </div>

                    <div class="bg-success text-white rounded-4 p-3">
                        <i class="bi bi-journal-bookmark fs-2"></i>
                    </div>
                </div>

                <a
                    href="/views/titulos/index.php"
                    class="btn btn-outline-success mt-4"
                >
                    Administrar títulos
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-dashboard h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary mb-1">Editoriales</p>
                        <h2 class="display-5 fw-bold mb-0">
                            <?= $totalPublicadores ?>
                        </h2>
                    </div>

                    <div class="bg-warning text-dark rounded-4 p-3">
                        <i class="bi bi-building fs-2"></i>
                    </div>
                </div>

                <p class="text-secondary mt-4 mb-0">
                    Editoriales disponibles para registrar libros.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card card-dashboard mt-4">
    <div class="card-body p-4">
        <h3 class="fw-bold">
            Bienvenido a BookManager
        </h3>

        <p class="text-secondary mb-0">
            Este sistema permite gestionar las tiendas, los títulos,
            las editoriales y el inventario de la librería utilizando
            PHP orientado a objetos, PDO y MariaDB.
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>