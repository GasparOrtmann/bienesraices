<?php

    session_start();

    $auth = $_SESSION['login'];

    // if(!$auth){
    //     header('Location: /');
    // }

    require 'includes/config/database.php';
    $db = conectarDB();

    $errores = [];

// Autenticacion
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
       
        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email){
            $errores[] = "El email es obligatorio o no es valido";
        }
        if(!$password){
            $errores[] = "El password es obligatorio";
        }

        if(empty($errores)){
            
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            $resultado = mysqli_query($db,$query);

            if($resultado->num_rows){

                //REvisar password correcto
                $usuario = mysqli_fetch_assoc($resultado);

                $auth = password_verify($password, $usuario['password']);

                if($auth){
                    // El usuario esta autenticado
                    session_start();

                    // Llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');
                } else{
                    $errores[] = "El password es incorrecto";
                }
            } else{
                $errores[] = "El usuario no existe";
            }
        }

    }

//Header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>
        
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" require id="email">

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu Password" require id="password">

        </fieldset>

        <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>