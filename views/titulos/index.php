<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Titulo.php';

$database = new Database();
$db = $database->connect();

$tituloModel = new Titulo($db);
$titulos = $tituloModel->getAll();

$mensaje = trim($_GET['mensaje'] ?? '');

$pageTitle = 'Gestión de títulos';
$pageSubtitle = 'Administra los libros disponibles en BookManager';

require_once __DIR__ . '/../../includes/header.php';
?>

<?php if ($mensaje !== ''): ?>
    <div
        class="alert alert-success alert-dismissible fade show"
        role="alert"
    >
        <?= htmlspecialchars($mensaje) ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Cerrar"
        ></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div
            class="d-flex flex-column flex-md-row
                   justify-content-between align-items-md-center
                   gap-3 mb-4"
        >
            <div>
                <h4 class="mb-1">Títulos registrados</h4>

                <p class="text-muted mb-0">
                    Consulta y administra el inventario de libros.
                </p>
            </div>

            <a href="crear.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i>
                Nuevo título
            </a>
        </div>

        <?php if (empty($titulos)): ?>
            <div class="alert alert-info mb-0">
                No hay títulos registrados en la base de datos.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Editorial</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Publicación</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($titulos as $libro): ?>
                            <tr>
                                <td>
                                    <?= (int) $libro['id_titulo'] ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= htmlspecialchars($libro['titulo']) ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $libro['tipo'] ?? 'No especificado'
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $libro['nombre_publicador']
                                        ?? 'Sin editorial'
                                    ) ?>
                                </td>

                                <td>
                                    RD$ <?= number_format(
                                        (float) $libro['precio'],
                                        2
                                    ) ?>
                                </td>

                                <td>
                                    <?php
                                    $stock = (int) $libro['stock'];
                                    $claseStock = $stock > 0
                                        ? 'bg-success'
                                        : 'bg-danger';
                                    ?>

                                    <span class="badge <?= $claseStock ?>">
                                        <?= $stock ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if (!empty($libro['fecha_publicacion'])): ?>
                                        <?= htmlspecialchars(
                                            $libro['fecha_publicacion']
                                        ) ?>
                                    <?php else: ?>
                                        <span class="text-muted">
                                            Sin fecha
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a
                                        href="editar.php?id=<?= (int) $libro['id_titulo'] ?>"
                                        class="btn btn-warning btn-sm"
                                        title="Editar"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a
                                        href="eliminar.php?id=<?= (int) $libro['id_titulo'] ?>"
                                        class="btn btn-danger btn-sm"
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

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>