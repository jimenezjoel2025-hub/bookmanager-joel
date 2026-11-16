<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Titulo.php';

$database = new Database();
$db = $database->connect();

$tituloModel = new Titulo($db);
$publicadores = $tituloModel->getPublicadores();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id_titulo', FILTER_VALIDATE_INT);
}

if (!$id) {
    header(
        'Location: index.php?mensaje=' .
        urlencode('Identificador de título no válido.')
    );
    exit;
}

$datos = $tituloModel->getById($id);

if (!$datos) {
    header(
        'Location: index.php?mensaje=' .
        urlencode('El título solicitado no existe.')
    );
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'id_titulo' => $id,
        'titulo' => trim($_POST['titulo'] ?? ''),
        'tipo' => trim($_POST['tipo'] ?? ''),
        'id_pub' => trim($_POST['id_pub'] ?? ''),
        'precio' => trim($_POST['precio'] ?? ''),
        'stock' => trim($_POST['stock'] ?? ''),
        'fecha_publicacion' => trim(
            $_POST['fecha_publicacion'] ?? ''
        ),
        'descripcion' => trim($_POST['descripcion'] ?? ''),
    ];

    if ($datos['titulo'] === '') {
        $errores[] = 'El título del libro es obligatorio.';
    }

    if ($datos['tipo'] === '') {
        $errores[] = 'El tipo o categoría es obligatorio.';
    }

    if (
        $datos['id_pub'] === '' ||
        filter_var($datos['id_pub'], FILTER_VALIDATE_INT) === false
    ) {
        $errores[] = 'Selecciona una editorial válida.';
    }

    if (
        $datos['precio'] === '' ||
        !is_numeric($datos['precio'])
    ) {
        $errores[] = 'El precio debe ser un número.';
    } elseif ((float) $datos['precio'] < 0) {
        $errores[] = 'El precio no puede ser negativo.';
    }

    if (
        $datos['stock'] === '' ||
        filter_var($datos['stock'], FILTER_VALIDATE_INT) === false
    ) {
        $errores[] = 'El stock debe ser un número entero.';
    } elseif ((int) $datos['stock'] < 0) {
        $errores[] = 'El stock no puede ser negativo.';
    }

    if (empty($errores)) {
        $datosGuardar = [
            'titulo' => $datos['titulo'],
            'tipo' => $datos['tipo'],
            'id_pub' => (int) $datos['id_pub'],
            'precio' => (float) $datos['precio'],
            'stock' => (int) $datos['stock'],
            'fecha_publicacion' =>
                $datos['fecha_publicacion'] !== ''
                    ? $datos['fecha_publicacion']
                    : null,
            'descripcion' => $datos['descripcion'],
        ];

        $tituloModel->update($id, $datosGuardar);

        header(
            'Location: index.php?mensaje=' .
            urlencode('Título actualizado correctamente.')
        );
        exit;
    }
}

$pageTitle = 'Editar título';
$pageSubtitle = 'Actualiza la información del libro';

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div
            class="d-flex justify-content-between
                   align-items-center mb-4"
        >
            <div>
                <h4 class="mb-1">Editar título</h4>

                <p class="text-muted mb-0">
                    Modifica la información del libro seleccionado.
                </p>
            </div>

            <a href="index.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Volver
            </a>
        </div>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <strong>Revisa los siguientes datos:</strong>

                <ul class="mb-0 mt-2">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form
            method="POST"
            action="editar.php?id=<?= (int) $id ?>"
        >
            <input
                type="hidden"
                name="id_titulo"
                value="<?= (int) $id ?>"
            >

            <div class="row g-3">
                <div class="col-md-8">
                    <label for="titulo" class="form-label">
                        Título del libro *
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="titulo"
                        name="titulo"
                        value="<?= htmlspecialchars($datos['titulo']) ?>"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label for="tipo" class="form-label">
                        Tipo o categoría *
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="tipo"
                        name="tipo"
                        value="<?= htmlspecialchars($datos['tipo']) ?>"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label for="id_pub" class="form-label">
                        Editorial *
                    </label>

                    <select
                        class="form-select"
                        id="id_pub"
                        name="id_pub"
                        required
                    >
                        <option value="">
                            Selecciona una editorial
                        </option>

                        <?php foreach ($publicadores as $publicador): ?>
                            <option
                                value="<?= (int) $publicador['id_pub'] ?>"
                                <?= (string) $datos['id_pub']
                                    === (string) $publicador['id_pub']
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars($publicador['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="precio" class="form-label">
                        Precio *
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">RD$</span>

                        <input
                            type="number"
                            class="form-control"
                            id="precio"
                            name="precio"
                            value="<?= htmlspecialchars(
                                (string) $datos['precio']
                            ) ?>"
                            min="0"
                            step="0.01"
                            required
                        >
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="stock" class="form-label">
                        Stock *
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        id="stock"
                        name="stock"
                        value="<?= htmlspecialchars(
                            (string) $datos['stock']
                        ) ?>"
                        min="0"
                        step="1"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label
                        for="fecha_publicacion"
                        class="form-label"
                    >
                        Fecha de publicación
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        id="fecha_publicacion"
                        name="fecha_publicacion"
                        value="<?= htmlspecialchars(
                            (string) ($datos['fecha_publicacion'] ?? '')
                        ) ?>"
                    >
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label">
                        Descripción
                    </label>

                    <textarea
                        class="form-control"
                        id="descripcion"
                        name="descripcion"
                        rows="4"
                    ><?= htmlspecialchars(
                        (string) ($datos['descripcion'] ?? '')
                    ) ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-floppy"></i>
                    Guardar cambios
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>