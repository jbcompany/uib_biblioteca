<?php
require_once __DIR__ . '/loans.php';
require_once __DIR__ . '/books.php';
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/models/Loan.php';

use App\Models\Loan;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$LoansService = new LoansService($conn);
$BooksService = new BooksService($conn);
$books = $BooksService->getAllBooks();

$formMessage = '';
// Mensajes despues del redirect (patron Post/Redirect/Get)
$statusMessages = [
    'add_ok' => ['success', 'Préstamo añadido correctamente.'],
    'add_error' => ['danger', 'Error al añadir el préstamo.'],
    'add_invalid' => ['warning', 'Por favor completa todos los campos.'],
    'edit_ok' => ['success', 'Préstamo actualizado correctamente.'],
    'edit_error' => ['danger', 'Error al actualizar el préstamo.'],
    'edit_invalid' => ['warning', 'Por favor completa todos los campos.'],
    'delete_ok' => ['success', 'Préstamo eliminado correctamente.'],
    'delete_error' => ['danger', 'Error al eliminar el préstamo.'],
    'delete_invalid' => ['warning', 'No se pudo identificar el préstamo a eliminar.'],
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

    if (isset($_POST['addLoan'])) {
        $userName = trim($_POST['user_name'] ?? '');
        $universityDegree = trim($_POST['university_degree'] ?? '');
        $bookName = trim($_POST['book_name'] ?? '');
        $loanDate = trim($_POST['loan_date'] ?? '');
        $returnDate = trim($_POST['return_date'] ?? '');
        $returnDate = $returnDate === '' ? null : $returnDate;

        if ($userName && $universityDegree && $bookName && $loanDate) {
            $loan = new Loan(null, $userName, $bookName, $universityDegree, $loanDate, $returnDate);
            $status = $LoansService->createLoan($loan) ? 'add_ok' : 'add_error';
        } else {
            $status = 'add_invalid';
        }
    }

    if (isset($_POST['editLoan'])) {
        $loanId = intval($_POST['loan_id'] ?? 0);
        $userName = trim($_POST['edit_user_name'] ?? '');
        $universityDegree = trim($_POST['edit_university_degree'] ?? '');
        $bookName = trim($_POST['edit_book_name'] ?? '');
        $loanDate = trim($_POST['edit_loan_date'] ?? '');
        $returnDate = trim($_POST['edit_return_date'] ?? '');
        $returnDate = $returnDate === '' ? null : $returnDate;

        if ($loanId && $userName && $universityDegree && $bookName && $loanDate) {
            $loan = new Loan($loanId, $userName, $bookName, $universityDegree, $loanDate, $returnDate);
            $status = $LoansService->updateLoan($loan) ? 'edit_ok' : 'edit_error';
        } else {
            $status = 'edit_invalid';
        }
    }

    if (isset($_POST['deleteLoan'])) {
        $loanId = intval($_POST['loan_id_delete'] ?? 0);
        if ($loanId) {
            $status = $LoansService->deleteLoan($loanId) ? 'delete_ok' : 'delete_error';
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

$loans = $LoansService->getAllLoans();
?>

<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>UIB Biblioteca - Préstamos</title>
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
            style="margin-top: 50px; text-align: center;">
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Préstamos de Libros</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLoanModal">Añadir Préstamo</button>
                </div>
                <?php echo $formMessage; ?>
                <!-- capçalera -->
                <div class="row border bg-dark text-white fw-bold text-center">
                    <div class="col-md-2 p-2 border-end">Usuario</div>
                    <div class="col-md-2 p-2 border-end">Grado</div>
                    <div class="col-md-2 p-2 border-end">Libro</div>
                    <div class="col-md-2 p-2 border-end">Fecha Préstamo</div>
                    <div class="col-md-2 p-2 border-end">Fecha Devolución</div>
                    <div class="col-md-2 p-2">Acciones</div>
                </div>

                <?php foreach ($loans as $loan): ?>
                    <div class="row border border-top-0 align-items-center text-center">
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($loan->getUserName()); ?>
                        </div>
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($loan->getUniversityDegree()); ?>
                        </div>
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($loan->getBookName()); ?>
                        </div>
                        <div class="col-md-2 p-2 border-end">
                            <?php echo htmlspecialchars($loan->getLoanDate()); ?>
                        </div>
                        <div class="col-md-2 p-2 border-end">
                            <?php echo $loan->getReturnDate() ? htmlspecialchars($loan->getReturnDate()) : '-'; ?>
                        </div>
                        <div class="col-md-2 p-2">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editLoanModal" onclick="loadEditLoan(<?php echo htmlspecialchars(json_encode($loan->toArray())); ?>)">Editar</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteLoan(<?php echo $loan->getId(); ?>)">Eliminar</button>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

    </main>

    <!-- Modal Añadir Préstamo -->
    <div class="modal fade" id="addLoanModal" tabindex="-1" aria-labelledby="addLoanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addLoanModalLabel">Añadir Nuevo Préstamo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Nombre del Usuario</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="university_degree" class="form-label">Grado Universitario</label>
                            <input type="text" class="form-control" id="university_degree" name="university_degree" required>
                        </div>
                        <div class="mb-3">
                            <label for="book_name" class="form-label">Nombre del Libro</label>
                            <select class="form-select" id="book_name" name="book_name" required>
                                <option value="">-- Selecciona un libro --</option>
                                <?php foreach ($books as $book): ?>
                                    <option value="<?php echo htmlspecialchars($book->getTitle()); ?>"><?php echo htmlspecialchars($book->getTitle()); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="loan_date" class="form-label">Fecha de Préstamo</label>
                            <input type="date" class="form-control" id="loan_date" name="loan_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="return_date" class="form-label">Fecha de Devolución (Opcional)</label>
                            <input type="date" class="form-control" id="return_date" name="return_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="addLoan">Añadir Préstamo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Préstamo -->
    <div class="modal fade" id="editLoanModal" tabindex="-1" aria-labelledby="editLoanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editLoanModalLabel">Editar Préstamo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="loan_id" name="loan_id">
                        <div class="mb-3">
                            <label for="edit_user_name" class="form-label">Nombre del Usuario</label>
                            <input type="text" class="form-control" id="edit_user_name" name="edit_user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_university_degree" class="form-label">Grado Universitario</label>
                            <input type="text" class="form-control" id="edit_university_degree" name="edit_university_degree" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_book_name" class="form-label">Nombre del Libro</label>
                            <select class="form-select" id="edit_book_name" name="edit_book_name" required>
                                <option value="">-- Selecciona un libro --</option>
                                <?php foreach ($books as $book): ?>
                                    <option value="<?php echo htmlspecialchars($book->getTitle()); ?>"><?php echo htmlspecialchars($book->getTitle()); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_loan_date" class="form-label">Fecha de Préstamo</label>
                            <input type="date" class="form-control" id="edit_loan_date" name="edit_loan_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_return_date" class="form-label">Fecha de Devolución (Opcional)</label>
                            <input type="date" class="form-control" id="edit_return_date" name="edit_return_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="editLoan">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Préstamo -->
    <div class="modal fade" id="deleteLoanModal" tabindex="-1" aria-labelledby="deleteLoanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteLoanModalLabel">Confirmar Eliminación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este préstamo? Esta acción no se puede deshacer.
                </div>
                <form method="POST">
                    <input type="hidden" id="loan_id_delete" name="loan_id_delete">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger" name="deleteLoan">Eliminar Préstamo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <!-- place footer here -->
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

        function loadEditLoan(loan) {
            document.getElementById('loan_id').value = loan.id;
            document.getElementById('edit_user_name').value = loan.user_name;
            document.getElementById('edit_university_degree').value = loan.university_degree;
            document.getElementById('edit_book_name').value = loan.book_name;
            document.getElementById('edit_loan_date').value = loan.loan_date;
            document.getElementById('edit_return_date').value = loan.return_date || '';
        }

        function deleteLoan(loanId) {
            document.getElementById('loan_id_delete').value = loanId;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteLoanModal'));
            deleteModal.show();
        }
    </script>
</body>

</html>
