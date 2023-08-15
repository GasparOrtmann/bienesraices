<?php
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth){
        header('Location: /');
    }
    
    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }

    //DB
    require '../../includes/config/database.php';

    $db = conectarDB();

    // Obtener datos de propiedad
    $consulta = "SELECT * FROM propiedades WHERE id =".$id;
    $resultado = mysqli_query($db, $consulta);
    $propiedad = mysqli_fetch_assoc($resultado); //arma el array con los datos
    
    // COnsultar para obtener vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db,$consulta);

    // Arreglo con mensaje de errores
    $errores = [];

    $titulo = strval($propiedad['titulo']);
    $precio= $propiedad['precio'];
    $descripcion= $propiedad['descripcion'];
    $habitaciones= $propiedad['habitaciones'];
    $wc= $propiedad['wc'];
    $estacionamiento= $propiedad['estacionamiento'];
    $vendedorId= $propiedad['vendedorId'];

    // Ejecutar el codigo despues de que el usuario envia el form

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";


    //SANITIZAR = QUE LOS DATOS LLEGUEN LIMPIOS Y NO AFECTEN A LA DB
    $titulo = mysqli_real_escape_string ($db, $_POST['titulo']); //elimina caracteres especiales que molesten en la consulta SQL
    $precio = mysqli_real_escape_string ($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string ($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string ($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string ($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string ($db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string ($db, $_POST['vendedor']);
    $creado = date('Y/m/d');

    // Asignar files hacia una variable
    $imagen = $_FILES['imagen'];

    if(!$titulo){
        $errores[] = "Debes añadir un titulo";
    }
    if(!$precio){
        $errores[] = "Debes añadir un precio";
    }
    if(!$descripcion){
        $errores[] = "Debes añadir una descripcion";
    }
    if(!$habitaciones){
        $errores[] = "Debes añadir habitaciones";
    }
    if(!$wc){
        $errores[] = "Debes añadir baños";
    }
    if(!$estacionamiento){
        $errores[] = "Debes añadir un estacionamiento";
    }
    if(!$vendedorId){
        $errores[] = "Debes elegir un vendedor";
    }

    // Validar por tamaño (1mb max)

    $medida = 1000 * 1000;

    if($imagen['size'] > $medida){
        $errores[] = "La imagen es muy pesada";
    }


    //Revisar array
    if(empty($errores)){
        // Crear folder
        $folder = '../../imagenes/';

        //Si no existe lo crea
        if(!is_dir($folder)){
            mkdir($folder);
        }

        $nombreImg = '';

        // SUBIDA DE ARCHIVOS

        if($imagen['name']){ //si es una imagen nueva
            //Eliminar imagen previa
            unlink($folder . $propiedad['imagen']); //unlink para eliminar archivos

            //Generar un nombre unico
             $nombreImg = md5(uniqid(rand(),true)).".jpg";

            // Subir la imagen
             move_uploaded_file($imagen['tmp_name'], $folder . $nombreImg);
        }else{
            $nombreImg = $propiedad['imagen'];
        }

        //Insertar
        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImg}', descripcion = '${descripcion}',
                    habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id = ${id}";
    
        $resultado = mysqli_query($db,$query);
        
        
        if($resultado){
           //Redireccionar al usuario.

           header('Location: /admin?resultado=2');
        }
    }

    
}

    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="../index.php" class="boton boton-verde">Volver</a>

        <!-- MENSAJES DE ERROR -->
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error;  ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data"> <!-- enctype permitira ver info de los archivos subidos -->
        <fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <img src="/imagenes/<?php echo $imagen; ?>" class="imagen-small">

            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Informacion Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1",  max="9" value="<?php echo $habitaciones ?>">

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1",  max="9" value="<?php echo $wc ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1",  max="9" value="<?php echo $estacionamiento ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="" selected disabled>-- Seleccione --</option>
                <?php while($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedorId == $vendedor['id'] ? 'selected' : ''; ?>
                    value="<?php echo $vendedor['id'] ?>">
                    <?php echo $vendedor['nombre'] . " " . $vendedor['apellido'] ?></option>
                <?php endwhile; ?>
                
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>