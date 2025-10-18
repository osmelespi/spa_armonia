<footer>
        <div class="redes">
            Encuentranos en:
            <a href="http://www.instagram.com/osmelscake?igsh=YTkyaDEwNGI0Yjht" target="_blank">
                <img class="icono" src="assets/images/instagram.png" alt="instagram" width="40">
            </a>
            <a href="https://www.tiktok.com/@osmelespinozarami?_t=8qzBMiQWNRR&_r=1" target="_blank">
                <img class="icono" src="assets/images/tiktok.png" alt="tiktok" width="40">
            </a>
            <a href="https://www.facebook.com/share/mLUH5zJj4Tm3GxZz/" target="_blank">
                <img class="icono" src="assets/images/facebook.png" alt="facebook" width="40">
            </a>
        </div>
        <div class="derechos">
            <div class="row">
                <div class="col-6">
                    Copyright © 2025 Pasteleria Osmel's Cakes
                </div>
                <div class="col-6">
                    Calle Barcelona nro. 22 Mostóles Madrid
                </div>
            </div>
        </div>
    </footer>
    <?php
    // Calcular base igual que en header para apuntar a la carpeta public
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $base = '/public';
    if (strpos($scriptName, '/public/') !== false) {
        $pos = strpos($scriptName, '/public/');
        $base = substr($scriptName, 0, $pos + strlen('/public'));
    }
    $base = rtrim($base, '/');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="<?= $base ?>/js/script.js"></script>
    <script type="module" src="<?= $base ?>/js/index.js"></script>
</body>
</html>