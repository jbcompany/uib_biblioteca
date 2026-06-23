<?php
require_once __DIR__ . '/books.php';
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/models/Book.php';

use App\Models\Book;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$BooksService = new BooksService($conn);

$formMessage = '';
// Mensajes despues del redirect (patron Post/Redirect/Get)
$statusMessages = [
    'add_ok' => ['success', 'Libro añadido correctamente.'],
    'add_error' => ['danger', 'Error al añadir el libro.'],
    'add_invalid' => ['warning', 'Por favor completa todos los campos.'],
    'edit_ok' => ['success', 'Libro actualizado correctamente.'],
    'edit_error' => ['danger', 'Error al actualizar el libro.'],
    'edit_invalid' => ['warning', 'Por favor completa todos los campos.'],
    'delete_ok' => ['success', 'Libro eliminado correctamente.'],
    'delete_error' => ['danger', 'Error al eliminar el libro.'],
    'delete_invalid' => ['warning', 'No se pudo identificar el libro a eliminar.'],
];

if (isset($_GET['status']) && isset($statusMessages[$_GET['status']])) {
    $alertData = $statusMessages[$_GET['status']];
    $formMessage = '<div class="alert alert-' . $alertData[0] . ' alert-dismissible fade show" role="alert">'
        . htmlspecialchars($alertData[1])
        . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
        . '</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = '';

    if (isset($_POST['addBook'])) {
        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $publishedYear = intval($_POST['published_year'] ?? 0);
        $genre = trim($_POST['genre'] ?? '');
        $ubication = trim($_POST['ubication'] ?? '');

        if ($title && $author && $publishedYear && $genre && $ubication) {
            $book = new Book(null, $title, $author, $publishedYear, $genre, $ubication);
            $status = $BooksService->createBook($book) ? 'add_ok' : 'add_error';
        } else {
            $status = 'add_invalid';
        }
    }

    if (isset($_POST['editBook'])) {
        $bookId = intval($_POST['book_id'] ?? 0);
        $title = trim($_POST['edit_title'] ?? '');
        $author = trim($_POST['edit_author'] ?? '');
        $publishedYear = intval($_POST['edit_published_year'] ?? 0);
        $genre = trim($_POST['edit_genre'] ?? '');
        $ubication = trim($_POST['edit_ubication'] ?? '');

        if ($bookId && $title && $author && $publishedYear && $genre && $ubication) {
            $book = new Book($bookId, $title, $author, $publishedYear, $genre, $ubication);
            $status = $BooksService->updateBook($book) ? 'edit_ok' : 'edit_error';
        } else {
            $status = 'edit_invalid';
        }
    }

    if (isset($_POST['deleteBook'])) {
        $bookId = intval($_POST['book_id_delete'] ?? 0);
        if ($bookId) {
            $status = $BooksService->deleteBook($bookId) ? 'delete_ok' : 'delete_error';
        } else {
            $status = 'delete_invalid';
        }
    }

    $redirectUrl = $_SERVER['PHP_SELF'];
    if ($status !== '') {
        $redirectUrl .= '?status=' . urlencode($status);
    }

    header('Location: ' . $redirectUrl);
    exit();
}

$books = $BooksService->getAllBooks();
?>

<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>UIB Biblioteca</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS v5.3.8 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
        <?php include_once 'header.php'; ?>
    </header>
    <main>
        <div
            class="container-xl border border-1 rounded-3 py-5 my-5"
            style="margin-top: 50px; text-align: center;height: 500px;">
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Stock de Libros disponibles</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">Añadir Libro</button>
                </div>
                <?php echo $formMessage; ?>
                <!-- capçalera -->
                <div class="row border bg-dark text-white fw-bold text-center">
                    <div class="col-md-2 p-2 border-end">Titulo</div>
                    <div class="col-md-2 p-2 border-end">Autor</div>
                    <div class="col-md-2 p-2 border-end">Año</div>
                    <div class="col-md-2 p-2 border-end">Genero</div>
                    <div class="col-md-2 p-2 border-end">Ubicación</div>
                    <div class="col-md-2 p-2">Acciones</div>
                </div>

                <?php foreach ($books as $book): ?>
                    <div class="row border border-top-0 align-items-center text-center">
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($book->getTitle()); ?>
                        </div>
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($book->getAuthor()); ?>
                        </div>
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($book->getPublishedYear()); ?>
                        </div>
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($book->getGenre()); ?>
                        </div>
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($book->getUbication()); ?>
                        </div>
                        <div class="col-md-2 p-2">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editBookModal" onclick="loadEditBook(<?php echo htmlspecialchars(json_encode($book->toArray())); ?>)">Editar</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteBook(<?php echo $book->getId(); ?>)">Eliminar</button>
                        </div>
                    </div>
                <?php endforeach; ?>


            </div>

    </main>

    <!-- Modal Añadir Libro -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addBookModalLabel">Añadir Nuevo Libro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Autor</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="published_year" class="form-label">Año de Publicación</label>
                            <input type="number" class="form-control" id="published_year" name="published_year" min="1000" max="2099" required>
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Género</label>
                            <input type="text" class="form-control" id="genre" name="genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="ubication" class="form-label">Ubicación</label>
                            <select class="form-select" id="ubication" name="ubication" required>
                                <option value="">-- Selecciona una ubicación --</option>
                                <option value="PASILLO A">PASILLO A</option>
                                <option value="PASILLO B">PASILLO B</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="addBook">Añadir Libro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Libro -->
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editBookModalLabel">Editar Libro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="book_id" name="book_id">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="edit_title" name="edit_title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_author" class="form-label">Autor</label>
                            <input type="text" class="form-control" id="edit_author" name="edit_author" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_published_year" class="form-label">Año de Publicación</label>
                            <input type="number" class="form-control" id="edit_published_year" name="edit_published_year" min="1000" max="2099" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_genre" class="form-label">Género</label>
                            <input type="text" class="form-control" id="edit_genre" name="edit_genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ubication" class="form-label">Ubicación</label>
                            <select class="form-select" id="edit_ubication" name="edit_ubication" required>
                                <option value="">-- Selecciona una ubicación --</option>
                                <option value="PASILLO A">PASILLO A</option>
                                <option value="PASILLO B">PASILLO B</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="editBook">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Libro -->
    <div class="modal fade" id="deleteBookModal" tabindex="-1" aria-labelledby="deleteBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteBookModalLabel">Confirmar Eliminación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este libro? Esta acción no se puede deshacer.
                </div>
                <form method="POST">
                    <input type="hidden" id="book_id_delete" name="book_id_delete">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger" name="deleteBook">Eliminar Libro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <!-- place navbar here -->
        <?php include_once 'footer.php'; ?>
    </footer>
    <!-- Bootstrap JavaScript Bundle (includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script>
        // Limpiar parámetro ?status de la URL después de mostrar la alerta
        if (window.location.search.includes('status=')) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        function loadEditBook(book) {
            document.getElementById('book_id').value = book.id;
            document.getElementById('edit_title').value = book.title;
            document.getElementById('edit_author').value = book.author;
            document.getElementById('edit_published_year').value = book.published_year;
            document.getElementById('edit_genre').value = book.genre;
            document.getElementById('edit_ubication').value = book.ubication;
        }

        function deleteBook(bookId) {
            document.getElementById('book_id_delete').value = bookId;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteBookModal'));
            deleteModal.show();
        }
    </script>
</body>

</html>
