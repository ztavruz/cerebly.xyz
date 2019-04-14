<?php

?>
<div class="modal fade select-audiosession-window" id="select_wind_id_admin" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Выбрать аудиосеанс</h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>


<div class="admin-left-menu">
    <ul>
        <li>
            <a href="<?php echo getActionLink("users") ?>">Пользователи</a>
            <ul>
                <li><a href="<?php echo getActionLink("users") ?>">Пользователи</a></li>
                <?php if(User::can('edit_roles')): ?><li><a href="<?php echo getActionLink("roles") ?>">Роли</a></li><?php endif; ?>
            </ul>
        </li>
        <li><a href="<?php echo getActionLink("audiosessions") ?>">Аудиосеансы</a></li>
        <li class="active"><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li><?php endif; ?>
        <li class="active"><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>


<div class="admin-content">

    <div class="admin-breadcrumbs">
        <a href="<?php echo getActionLink("abonements") ?>">Абонементы</a> / <a class="active" href="#">Абонемент</a>
    </div>

    <h2>Абонемент</h2>

    <table class="admin-table-list abonement-info">
        <tr>
            <td>Срок действия абонемента</td>
            <td>с <?php echo $abonement->getStart()->format("d.m.Y") ?> по <?php echo $abonement->getEnd()->format("d.m.Y") ?></td>
        </tr>
        <tr>
            <td>Количество прослушиваний</td>
            <td><?php echo $abonement->getTimesTotal() ?></td>
        </tr>
        <tr>
            <td>Количество прослушиваний в день</td>
            <td><?php echo $abonement->times ?></td>
        </tr>
        <tr>
            <td>Интервалы прослушивания</td>
            <td>
                <?php foreach( $abonement->getIntervals()  as $interv) echo "<div>".$interv.":00"."</div>" ?>
            </td>
        </tr>
        <tr>
            <td>Сумма абонемента</td>
            <td><?php echo $abonement->outsum ?></td>
        </tr>
        <tr>
            <td>Количество оставшихся прослушиваний</td>
            <td><?php echo $abonement->getTimesLeft() ?></td>
        </tr>
    </table>



    <form action="<?php echo getActionLink("abonements", "changelist")?>" method="post">
    <table class="admin-table-list  history-list edit-buttons">

            <input type="hidden" name="id" value="<?php echo $abonement->id ?>">
        <?php for($i = 0; $i < 10; $i++):
            if(isset($data['audiosessionsPlan'][$i])): ?>
                <tr><td><?php echo $i+1 ?></td><td><span><?php echo $data['audiosessionsPlan'][$i]['caption'] ?></span><input type='hidden' name='asess[]' value='<?php echo $data['audiosessionsPlan'][$i]['id'] ?>'></td><td><?php if(User::can('edit_abonements')): ?><a onclick='getSessionsListAdmin(this)' disabled >редактировать</a><?php endif; ?></td></tr>
            <?php else: ?>
                <tr><td><?php echo $i+1 ?></td><td><span>Выберите аудиосеанс</span><input type='hidden' name='asess[]' value='0'></td><td><?php if(User::can('edit_abonements')): ?><a onclick='getSessionsListAdmin(this)' disabled >редактировать</a><?php endif; ?></td></tr>
            <?php endif; ?>
        <?php endfor; ?>

    </table>
        <div class="admin-buttons-bottom">
            <?php if(User::can('edit_abonements')): ?><button class="btn btn-primary" style="display: none;" type="submit">Сохранить изменения</button><?php endif; ?>
            <a class="btn btn-success" href="<?php echo getActionLink("abonements") ?>">Назад</a>
        </div>
    </form>

</div>
