<?php

echo getIntervalsModalWindow();

$abonement = $data['abonement'];
$intervals = json_decode($abonement->intervals, false);
$plan = $abonement->getPlanList();

?>



<div class="modal fade select-audiosession-window" id="select_wind_id" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Выбрать аудиосеанс</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade confirm-window" id="confirm_window">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Выбрать аудиосеанс</h4>
            </div>
            <div class="modal-body clearfix"></div>
        </div>
    </div>
</div>

<div class="instructions-block">
    <h3>Инструкция по формированию абонемента</h3>
    <p>Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке, а начинающему оратору отточить навык публичных выступлений в домашних условиях. При создании генератора мы использовали небезизвестный универсальный код речей. Текст генерируется абзацами случайным образом от двух до десяти предложений в абзаце, что позволяет сделать текст более привлекательным и живым для визуально-слухового восприятия.</p>
</div>

<div class="abonement-create-block clearfix">

    <form id="create-abonement-form" action="<?php echo getActionLink("abonements","savechanges") ?>" method="post">
        <input name="id" value="<?php echo $abonement->id ?>" type="hidden">
        <div class="audiosession-settings">


            <select id="id_duration" name="duration" class="form-control duration" disabled>
                <option value="0" selected><?php echo $abonement->duration ?></option>
            </select>

            <select id="id_times" name="times" class="form-control times" disabled>
                <option value="0" selected><?php $price = new Price(); echo $price->times[$abonement->times] ?></option>
            </select>

            <div class="buttons-intervals">
                <?php foreach( $intervals as $interval ): ?>

                    <div class="btn btn-primary" data-container="<?php echo $interval ?>" style="display: block;"><input name="interval[]" type="hidden" value="<?php echo $interval ?>"><span><?php echo intervalLablel($interval) ?></span></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="plan-list">
        <?php for($i = 0; $i < 10; $i++):
            $audiosession = $plan[$i];
            ?>
            <div class="audiosession-field <?php if(!$audiosession) echo "empty-field" ?> clearfix" onclick="getSessionsList(this)">
                <input type="hidden" name="listenplan[]" value="<?php if($audiosession) echo $audiosession['id']; else echo "0" ?>">
                <div class="checked-lamp"></div>
                <div class="delete-lamp">×</div>
                <div class="audiosession-image">
                    <img src="<?php if($audiosession) echo getMedia($audiosession['img']); else echo "" ?>" alt="">
                </div>
                <div class="audiosession-name"><?php if($audiosession) echo $audiosession['caption']; else echo "Нажмите для добавления сеанса в очередь" ?></div>
            </div>
        <?php endfor; ?>
        </div>
    </form>

</div>
<button class="btn btn-primary create-abonement-button" onclick="saveAbonementChanges()">
    Сохранить
</button>
<a href="<?php echo getActionLink("abonements", "view") ?>" class="btn btn-primary">
    Назад
</a>