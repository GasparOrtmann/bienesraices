<?php

    !require 'includes/funciones.php';
 
    incluirTemplate('header');
?>


    <main class="contenedor seccion contenido-centrado">
        <h1>Guia para la decoracion de tu hogar</h1>

        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/jpg">
            <img loading="lazy" src="build/img/destacada.jpg" alt="imagen de la propiedad">
        </picture>

        <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>

        <div class="resumen-propiedad">
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Magni ullam sit fugiat excepturi dignissimos aliquid aspernatur hic eum omnis numquam sapiente corrupti eveniet dicta voluptates obcaecati architecto amet, repellat eaque.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi pariatur ipsum molestias possimus accusantium nihil cum quis laborum eius iusto, id omnis quisquam quidem commodi dolor magni accusamus numquam consequuntur!</p>
        </div>
    </main>

    <?php
    incluirTemplate('footer');
    ?>