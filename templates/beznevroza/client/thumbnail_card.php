<?php
?>   
                <div class="card">
                    <img class="card-img-top" src="<?php echo getMedia($data->img1) ?>" alt="Card">
                    <div class="card-block">
                        <h4 class="card-title"><?php echo $data->caption ?></h4>
                        <p class="card-text"><b>Описание: </b><?php echo $data->description ?></p>
                        <a href="<?php echo getActionLink("audiosessions", "view", array("id" => $data->id)) ?>" class="btn btn-primary morelink">Подробнее &nbsp;</a>
                    </div>
                </div>
<?php 