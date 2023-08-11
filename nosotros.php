<?php

    !require 'includes/funciones.php';
 
    incluirTemplate('header');
?>


    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 Años de experiencia
                </blockquote>

                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore quibusdam fugit magni repellendus ut explicabo facere, aspernatur animi, possimus cum enim odit, necessitatibus eius error laudantium esse accusamus dolorum repellat!
                </p>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore quibusdam fugit magni repellendus ut explicabo facere, aspernatur animi, possimus cum enim odit, necessitatibus eius error laudantium esse accusamus dolorum repellat!
                </p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime earum odio incidunt fuga accusantium possimus eligendi non accusamus adipisci laborum, doloribus magni nesciunt! Mollitia tempore, similique harum iusto amet doloremque?</p>
            </div>

            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime earum odio incidunt fuga accusantium possimus eligendi non accusamus adipisci laborum, doloribus magni nesciunt! Mollitia tempore, similique harum iusto amet doloremque?</p>
            </div>

            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maxime earum odio incidunt fuga accusantium possimus eligendi non accusamus adipisci laborum, doloribus magni nesciunt! Mollitia tempore, similique harum iusto amet doloremque?</p>
            </div>
        </div>
    </section>

    <?php
   incluirTemplate('footer');
    ?>