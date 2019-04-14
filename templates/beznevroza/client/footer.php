<?php
// Запрещает прямой запуск в обход index.php
defined('BEZNEVROZA') or die("Доступ запрещен...");
?>
    </div> <!-- container-end -->
    <footer>
        <div class="container">
            <div class="logo">
                <span class="copyrights">© 2017 BeznervozaNet | Все права защищены.</span>
            </div>
            
            <div class="socials">
                <ul>
                    <li class="g"><a href="index.php"></a></li>
                    <li class="vk"><a href="index.php"></a></li>
                    <li class="tw"><a href="index.php"></a></li>
                    <li class="odn"><a href="index.php"></a></li>
                </ul>
                <span>Мы в социальных сетях</span>
            </div>
        </div>
    </footer>
    <?php /*echo Message('get'); */?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo getAssetsUrl() ?>/js/bootstrap.js"></script>
    <script src="<?php echo getAssetsUrl() ?>/js/datepicker.js"></script>
    <script src="<?php echo getAssetsUrl() ?>/js/jquery.maskedinput.js"></script>
    <script src="<?php echo getAssetsUrl() ?>/js/jquery.kladr.min.js"></script>
    <script src="<?php echo getAssetsUrl() ?>/js/scripts.js"></script>
    <!-- <script src="<?php echo getAssetsUrl() ?>/js/image_slider.js"></script> -->
    <script src="<?php echo getAssetsUrl() ?>/js/bootstrap-tabs.js"></script>
    <script src="<?php echo getAssetsUrl() ?>js/player.js"></script>
    
    
    <?= Document::getScripts() ?>

</body>

</html>
