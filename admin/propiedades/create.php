<?php
    //DB
    require '../../includes/config/database.php';

    $db = conectarDB();

    // COnsultar para obtener vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db,$consulta);

    // Arreglo con mensaje de errores
    $errores = [];

    $titulo="";
    $precio="";
    $descripcion="";
    $habitaciones="";
    $wc="";
    $estacionamiento="";
    $vendedorId="";

    // Ejecutar el codigo despues de que el usuario envia el form

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $titulo = mysqli_real_escape_string ($db, $_POST['titulo']);
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
    // if(!$imagen['name'] || $imagen['error']){
    //     $errores[] = "La imagen es obligatoria";
    // }

    // Validar por tamaño (1mb max)

    $medida = 1000 * 1000;

    if($imagen['size'] > $medida){
        $errores[] = "La imagen es muy pesada";
    }


    //Revisar array
    if(empty($errores)){
        // SUBIDA DE ARCHIVOS

        // Crear folder
        $folder = '../../imagenes/';

        if(!is_dir($folder)){
            mkdir($folder);
        }
       
        //Generar un nombre unico
        $nombreImg = md5(uniqid(rand(),true));

        // Subir la imagen
        move_uploaded_file($imagen['tmp_name'], $folder . $nombreImg . ".jpg");

        //Insertar
        $query = "INSERT INTO propiedades (titulo,precio,imagen,descripcion,habitaciones,wc,estacionamiento, creado,
        vendedores_Id) VALUES ('$titulo','$precio','$nombreImg','$descripcion','$habitaciones','$wc',
        '$estacionamiento','$creado','$vendedorId')";

        $resultado = mysqli_query($db,$query);

        if($resultado){
           //Redireccionar al usuario.

           header('Location: /admin?resultado=1');
        }
    }

    
}

    require '../../includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin/index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error;  ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/propiedades/create.php" enctype="multipart/form-data"> <!-- enctype permitira ver info de los archivos subidos -->
        <fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="descripcion"></textarea>
        </fieldset>

        <fieldset>
            <legend>Informacion Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1",  max="9">

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1",  max="9">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1",  max="9">
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

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>