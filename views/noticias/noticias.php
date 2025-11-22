<?php
require_once '../controllers/noticiaController.php';
$noticiaController = new NoticiaController();
$noticias = $noticiaController->obtenerNoticias();
?>
<main>
    <section class="container">
        <h1 class="titulo">Últimas Noticias</h1>
        <div class="noticias">
            <?php foreach ($noticias as $noticia): ?>
                <article class="noticia d-flex flex-column align-items-center mb-4 p-3 border rounded">
                    <h2 class="noticia-titulo mb-3"><?php echo htmlspecialchars($noticia['titulo']); ?></h2>
                    <?php if (!empty($noticia['imagen'])): ?>
                        <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="Imagen de la noticia" class="noticia-imagen w-50">
                    <?php endif; ?>
                    <p class="noticia-texto mt-3"><?php echo nl2br(htmlspecialchars($noticia['texto'])); ?></p>
                    <p class="noticia-fecha">Publicado el: <?php echo htmlspecialchars($noticia['fecha']); ?></p>
                    <p class="noticia-autor">Autor: <?php echo htmlspecialchars($noticia['autor']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>
