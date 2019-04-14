<div class="abonements-block">
    <h3 class="abonements-block-header">Абонемент на аудиотерапию</h3>
    <div class="abonements-block-content-wrapper">
        <div class="abonements-block-section clearfix">
            <div class="left-field">Срок действия</div>
            <div class="right-field"><?php echo $data['abonement']->getStart()->format("d.m.Y")." - ".$data['abonement']->getEnd()->format("d.m.Y")?></div>

        </div>
        <div class="abonements-block-section clearfix">
            <div class="left-field">Количество прослушиваний в день</div>
            <div class="right-field"><?php echo $data['abonement']->times ?></div>

        </div>
        <div class="abonements-block-section clearfix">
            <div id="uri" class="uri" style="display:none;"><?php echo $uri ?></div>
            <div class="wrapper-player">
                <div class="panel">
                    <img src="<?php echo getAssetsUrl() ?>img/player/fon-player.png" alt="">
                    <div class="controls">
                        <div class="header">
                            <div class="volume">
                                <img src="<?php echo getAssetsUrl() ?>img/player/player-icon-volume.png">
                                <div id="points" class="point-volume">
                                    <div id="point0" class="point-activ"></div>
                                    <div id="point1" class="point-activ"></div>
                                    <div id="point2"  class="point-activ"></div>
                                    <div id="point3"  class="point-activ"></div>
                                    <div id="point4"  class="point-activ"></div>
                                    <div id="point5"  class="point-inactiv"></div>
                                    <div id="point6"  class="point-inactiv"></div>
                                    <div id="point7"  class="point-inactiv"></div>
                                    <div id="point8"  class="point-inactiv"></div>
                                    <div id="point9"  class="point-inactiv"></div>
                                </div>
                            </div>
                        </div>
                        <div class="center">
                            <div class="titel-ekvail-progress">
                                <div class="titel">
                                    <h1 id="playerPanelTitle">Пока не доступно для прослушивания</h1>
                                </div>
                                <div class="time-ekvail">
                                    <div class="time">
                                        <h1 id="playerPanelTime">00:00</h1>
                                    </div>
                                    <div class="ekvail" id="ekvalaizer">
                                    <canvas height='37' width='180' id='canvas'>Обновите браузер</canvas>
                                    </div>
                                </div>
                                <div class="wrapper-progress">
                                    <div id="rels" class="rels">
                                        <div id="auditioned" class="auditioned">

                                        </div>
                                        <div id="begunok" class="begunok">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="wrapper-icon-playlist">
                                <img onclick="diplay_hide('#block_id');return false;" src="<?php echo getAssetsUrl() ?>img/player/player-icon-playlist.png">
                            </div>
                            <div class="buttons">
                                <div class="play" >
                                    <img id="playPause" src="<?php echo getAssetsUrl() ?>img/player/player-icon-play.png" alt="">
                                </div>
                                <div class="stop">
                                    <img onclick="stop()" src="<?php echo getAssetsUrl() ?>img/player/player-icon-stop.png" alt="">
                                </div>
                            </div>
                            <div id="load" class="load">
                                <img id="loadImg" class="loadImg" src="<?php echo getAssetsUrl() ?>img/player/player-load.gif" alt="">
                                <h3>Loading...</h3>
                            </div>
                        </div>
                        <div class="audio">
                            <audio id="audio" src="" ></audio>
                        </div>
                    </div>
                    <div class="img">
                        <img id="playerPanelImg" src="" alt="">
                    </div>
                </div>
                <div id="block_id"  class="wrapper-playlist">
                    <div class="playlist">
                    
                        <?php
                        // ini_set('date.timezone', 'Europe/Oslo');
                        // echo ini_get('date.timezone');
                        // echo date('Y-m-d H:i:s'); // 2011-12-28 18:24:45
                        // echo ini_get('date.timezone');
                        // $date =new DateTime('now');
                        // echo $date->format("H:i:s");
                        // echo DateTime('now')-format('Y:M:D H:I:S');
                            for( $i = 0 ; $i < count($data['plan']) ; $i++ ){
                                $order = $i+1;
                                if( isset($data['plan'][$i]) ){
                                    $audiosession = $data['plan'][$i]['index'];
                                    $time = $data['plan'][$i]['time'];
                                    $status='inactiv';

                                    if($time->m==0 && $time->d==0 && $time->h<3){
                                        if($time->h<1)
                                            $colorTime="red";
                                        $status='next';

                                        echo "<div class='playlist-list $status' id='interval_$order' onclick='toggleState()'>";
                                            echo "<div style='display:none;' id='href_interval_$order'>{$audiosession['uri']}</div>";
                                            echo "<div style='display:none;' id='href_img_interval_$order'>{$audiosession['img1']}</div>";
                                            echo "<img id='icon_interval_$order' src=".getAssetsUrl()."img/player/playlist-icon-play.png>";
                                            echo "<h3 id='caption_interval_$order'>{$audiosession['caption']}</h3>";
                                            echo "<h3 id='time_interval_$order' class='playlist-time activ-time $colorTime '>".$time->format('%H:%I:%S')."</h3>";
                                        echo "</div>";

                                    }
                                    else{
                                        $hours=$time->format('%H');
                                        $days=$time->format('%D');
                                        if($hours==0){
                                            $hours=21;
                                            $days--;
                                        }
                                        else if($hours==1){
                                            $hours=22;
                                            $days--;
                                        }
                                        else if($hours==2){
                                            $hours=23;
                                            $days--;
                                        }
                                        else{
                                            $hours-=3;
                                        }
                                        if(strlen($hours)==1){
                                            $hours='0'.$hours;
                                        }
                                        if(strlen($days)==1){
                                            $days='0'.$days;
                                        }
                                            
                                        $timeBeforeStart=$days.".".$hours.$time->format(':%I:%S');

                                        echo "<div class='playlist-list $status' id='interval_$order' onclick='showingBlockWindowsAboniment(event)'>";
                                            echo "<img id='icon_interval_$order' src=".getAssetsUrl()."img/player/playlist-icon-play.png>";
                                            echo "<h3 id='caption_interval_$order'>{$audiosession['caption']}</h3>";
                                            echo "<h3 id='time_interval_$order' class='playlist-time'>".$timeBeforeStart."</h3>";
                                        echo "</div>";
                                    }
                                    
                                }

                            }
                        ?>
                    </div>
                    
                    <div onclick='showingBlockWindowsAboniment(event)' class="block-playlist-window" id="black-layout-block-playlist-window">
                    </div>

                    <div class="block-window" id="block-playlist-window">
                        Данное абонемент будет доступен через:<br/>
                        <span id="timeInBlockWin"></span>
                    </div>
                </div>
            </div>
            <p>
                <a href="<?php echo getActionLink("abonements", "change") ?>" class="btn btn-primary">Редактировать абонемент</a>
            </p>
            <p>
                <a href="<?php echo getActionLink("support", "chat") ?>" class="btn btn-primary">Задать вопрос</a>
            </p>
        </div>
        <div class="shedule-search-form-block">
            <span>Посмотреть расписание аудиотерапии</span>
            <div class="search-interval-fields">
                <form id="sheduleform" action="<?php echo getActionLink("ajax", "shedule") ?>">С <input name="start_time" data-toggle="datepicker"> По <input name="end_time" data-toggle="datepicker">
                    <input name="id" type="hidden" value="<?php echo $data['abonement']->id ?>">
                </form>
            </div>
            <div class="btn btn-primary" onclick="getSheduleButton()">Посмотреть</div>
            <div class="link-section">
                <a href="<?php echo getActionLink("abonements", "getshedulefile") ?>" class="blue-link"> <i class="blue-link-icon"></i> &nbsp; Скачать полную распечатку расписания абонемента</a>
            </div>
        </div>
    </div>

</div>
<div id="shedule-list">

</div>

<div class="abonements-block">
    <h3 class="abonements-block-header">Видеокурс</h3>
</div>
<div class="abonements-block">
    <h3 class="abonements-block-header">Видеокурс</h3>
</div>
<div class="abonements-block">
    <h3 class="abonements-block-header">Видеокурс</h3>
</div>
