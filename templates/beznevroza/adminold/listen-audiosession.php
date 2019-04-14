<?php
    $uri = $data[0]['uri'];
    $img=$data[0]['img1'];
    $caption=$data[0]['caption'];
?>
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
                        <h1><?php echo $caption?> </h1>
                    </div>
                    <div class="time-ekvail">
                        <div class="time">
                            <h1 id="time" >13:50</h1>
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
                    <img src="<?php echo getAssetsUrl() ?>img/player/player-icon-playlist.png">
                </div>
                <div class="buttons">
                    <div class="play" >
                        <img id="playPause" src="<?php echo getAssetsUrl() ?>img/player/player-icon-play.png" alt="">
                    </div>
                    <div class="stop">
                        <img onclick="stop()" src="<?php echo getAssetsUrl() ?>img/player/player-icon-stop.png" alt="">
                    </div>
                    <!-- <div class="next" onclick="pause()">
                        Pause
                    </div> -->
                </div>
                <div id="load" class="load">
                    <img id="loadImg" class="loadImg" src="<?php echo getAssetsUrl() ?>img/player/player-load.gif" alt="">
                    <h3>Loading...</h3>
                </div>
            </div>
        </div>
        <div class="img">
            <img src="<?php echo getMedia($img)?>" alt="">
        </div>
    </div>
    <div class="playlist">
        <div class="playlist-list activ">
            <img onclick="toggleState()" id="playlist-playPause" src="<?php echo getAssetsUrl() ?>img/player/playlist-icon-play.png" alt="">
            <h3><?php echo $caption?></h3>
            <h3 id="playlist-time-current-audiosession" class="playlist-time">00:56</h3>
        </div>
        <div class="playlist-list next">
            <img src="<?php echo getAssetsUrl() ?>img/player/playlist-icon-play.png" alt="">
            <h3>Терапевтический аудио сеанс избавления навязчивых мыслей</h3>
            <h3>00:56</h3>
        </div>
        <div class="playlist-list inactiv">
            <img src="<?php echo getAssetsUrl() ?>img/player/playlist-icon-play.png" alt="">
            <h3>Терапевтический аудио сеанс избавления навязчивых мыслей</h3>
            <h3>00:56</h3>
        </div>
        <div class=playlist-list "inactiv">
            <img src="<?php echo getAssetsUrl() ?>img/player/playlist-icon-play.png" alt="">
            <h3>Терапевтический аудио сеанс избавления навязчивых мыслей</h3>
            <h3>00:56</h3>
        </div>
    </div>
</div>