   <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $loginSuccess = $_SESSION['login_success'] ?? null;
    $loginError = $_SESSION['login_error'] ?? null;
    $oldLoginEmail = $_SESSION['old_login_email'] ?? '';
    unset($_SESSION['login_success'], $_SESSION['login_error'], $_SESSION['old_login_email']);
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
           <?php include 'header.php'; ?>
       </header>
       <main>
            <div 
                class="container-xl border border-1 rounded-3 py-5 my-5" 
                style="margin-top: 50px; text-align: center;height: 500px;">
                <div class="card-body">
               <div class="card border-primary " style="width:600px; margin-top:50px;margin-left:350px;background-color: #f1f1f1;text-align:center">
                   <div class="card-body">
                       <?php if ($loginSuccess): ?>
                           <div class="alert alert-success alert-dismissible fade show text-start" role="alert">
                               <?php echo htmlspecialchars($loginSuccess, ENT_QUOTES, 'UTF-8'); ?>
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                           </div>
                       <?php endif; ?>
                       <?php if ($loginError): ?>
                           <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
                               <?php echo htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8'); ?>
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                           </div>
                       <?php endif; ?>
                       <form id="loginForm" class="row g-3 needs-validation mt-3" novalidate action="users/validateUsers.php" method="post">
                           <div class="row align-items-center mb-3 text-start">
                               <label for="email" class="col-sm-3 col-form-label">Correo:</label>
                               <div class="col-sm-9">
                                   <input
                                       type="text"
                                       class="form-control"
                                       name="email"
                                       id="email"
                                       aria-describedby="helpId"
                                       placeholder=""
                                       value="<?php echo htmlspecialchars($oldLoginEmail, ENT_QUOTES, 'UTF-8'); ?>" />
                               </div>
                           </div>
                           <div class="row align-items-center mb-3 text-start">
                               <label for="password" class="col-sm-3 col-form-label">Contraseña:</label>
                               <div class="col-sm-9">
                                   <input
                                       type="password"
                                       class="form-control"
                                       name="password"
                                       id="password"
                                       aria-describedby="helpId"
                                       placeholder="" />
                               </div>
                           </div>
                           <div class="row align-items-center mb-3">
                               <label class="col-sm-8 col-form-label"></label>
                               <div class="col-sm-4 text-end">
                                   <button type="submit" form="loginForm" class="btn btn-primary">INICIAR SESION</button>
                               </div>
                           </div>
                           <!--div class="row align-items-center mb-3">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9 text-start">
                                    <p class="mb-2"><a href="password.php">¿Olvidó su contraseña?</a></p>
                                    <p class="mb-0"><a href="registro.php">¿No tiene una cuenta? Cree una aquí</a></p>
                                </div>
                            </div-->
                       </form>
                   </div>
               </div>
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
           crossorigin="anonymous"></script>
   </body>

   </html>