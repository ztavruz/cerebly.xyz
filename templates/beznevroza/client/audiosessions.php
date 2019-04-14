<?php
?>


        <!--список товаров-->
        <?php
        $counter = count($data['audiosessions']);
        while ($counter > 0){
            ?><div class="row"><?php
            for($i = 0; $i < 3; $i++){
                ?><div class="col-sm-4"><?php
                
                if($counter-- > 0)  getCardThumbnail($data['audiosessions'][$counter]);
                ?></div><?php
            }
            ?></div><?php
        }
        ?>
    </div>
<?php



