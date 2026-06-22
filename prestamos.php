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
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <!-- place navbar here -->
            <?php include 'header.php'; ?>
        </header>
        <main>
            <div 
                class="container-xl border border-1 rounded-3 py-5 my-5" 
                style="margin-top: 50px; text-align: center;height: 500px;">
                <div class="card-body">
                    <h1 class="card-title">Bienvenido a la Biblioteca de la UIB</h1>
                    <p class="card-text">Explora nuestra colección de libros y recursos académicos.</p>
                    
            </div>
            
        </main>
        <footer>
            <!-- place footer here -->
            <?php include 'footer.php'; ?>
        </footer>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
