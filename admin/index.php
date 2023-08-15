<?php
    require '../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth){
        header('Location: /');
    }
    //importar la conexion
    require '../includes/config/database.php';
    $db = conectarDB();

    //escribir query
    $query = "SELECT * FROM propiedades";

    //consultar la db
    $resultadoConsulta = mysqli_query($db, $query);

    // ?? null: si no existe el valor, le pone null
    //Muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            //Eliminar archivo
            $query = "SELECT imagen FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);

            $propiedad = mysqli_fetch_assoc($resultado); //limpia el array y deja solo el atributo
            unlink('../imagenes/' . $propiedad['imagen']);

            //Eliminar la propiedad
            $query = "DELETE FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);

            if($resultado){
                header('Location: /admin?resultado=3');
            }
        }
    }

    // incluye un template
    
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <!-- intval convierte a entero -->
    <?php if(intval($resultado) == 1): ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php elseif(intval($resultado) == 2): ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php elseif(intval($resultado) == 3): ?>
        <p class="alerta exito">Anuncio eliminado correctamente</p>
    <?php endif; ?>

<a href="../admin/propiedades/create.php" class="boton boton-verde">Nueva Propiedad</a>    

<table class="propiedades">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)):  ?>
        <tr>
            <td><?php echo $propiedad['id']; ?></td>
            <td><?php echo $propiedad['titulo']; ?></td>
            <td><img src="/imagenes/<?php echo $propiedad['imagen'];?>.jpg" alt="imagen-tabla" class="imagen-small"></td>
            <td>$ <?php echo $propiedad['precio']; ?></td>
            <td>
                <a href="../../admin/propiedades/update.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">

                    <input type="submit" value="Eliminar" class="boton-rojo-block">
                </form>
                
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</main>

<?php

    //Cerrar la conexion
    mysqli_close($db);

    incluirTemplate('footer');
?>