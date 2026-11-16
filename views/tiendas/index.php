<?php

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/models/Tienda.php';

$pageTitle = 'Gestión de tiendas';
$tiendas = [];
$error = '';

try {
    $database = new Database();
    $db = $database->connect();

    $tiendaModel = new Tienda($db);
    $tiendas = $tiendaModel->getAll();

} catch (PDOException $exception) {
    $error = 'No fue posible cargar las tiendas.';
}

require_once dirname(__DIR__, 2) . '/includes/header.php';
?>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= htmlspecialchars($_GET['mensaje']) ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card card-dashboard">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">
                    Tiendas registradas
                </h2>

                <p class="text-secondary mb-0">
                    Administra la red de distribución de BookManager.
                </p>
            </div>

            <a href="crear.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Nueva tienda
            </a>
        </div>

        <?php if (empty($tiendas)): ?>

            <div class="alert alert-info mb-0">
                No hay tiendas registradas.
            </div>

        <?php else: ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Ciudad</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($tiendas as $tienda): ?>
                            <tr>
                                <td>
                                    <?= (int) $tienda['id_tienda'] ?>
                                </td>

                                <td class="fw-semibold">
                                    <?= htmlspecialchars($tienda['nombre_tienda']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($tienda['ciudad']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($tienda['telefono']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($tienda['email']) ?>
                                </td>

                                <td class="text-center">
                                    <a
                                        href="editar.php?id=<?= (int) $tienda['id_tienda'] ?>"
                                        class="btn btn-sm btn-warning"
                                        title="Editar"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a
                                        href="eliminar.php?id=<?= (int) $tienda['id_tienda'] ?>"
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/includes/footer.php'; ?>