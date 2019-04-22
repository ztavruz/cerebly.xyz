<?php
?>
<div class="modal fade confirm-window-simple adminModal-deleteAudio" id="delete-audiosession">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Вы уверены что хотите удалить аудиосеанс?</h4>
            </div>
            <form action="<?php echo getActionLink("audiosessions", "delete") ?>" method="post">
                <input id="id-delete-audiosession" type="hidden" name="id" value="0">
                <div class="modal-body clearfix">
                    <div class="buttons clearfix">
                        <button type="submit" class="btn btn-primary">Удалить</button>
                        <a class="btn btn-success" data-dismiss="modal" >Отмена</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade confirm-block-window adminModal-lockAudio" id="block-audiosession">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Блокировать</h4>
            </div>
            <div class="modal-body clearfix">

                <form action="<?php echo getActionLink("audiosessions", "saveblock") ?>" method="post">
                    <input id="block-audiosession-id" type="hidden" name="id" val="0">
                    <div class="forms">
                        <div class="form-group">
                            <label class="control-label">С </label>
                            <input type="date"  class="form-control" name="start_date">
                        </div>
                        <div class="form-group">
                            <label class="control-label">По </label>
                            <input type="date"  class="form-control" name="end_date">
                        </div>
                    </div>
                    <div class="buttons clearfix">
                        <button class="btn btn-primary" type="submit">Блокировать</button>
                </form>
                <form action="<?php echo getActionLink("audiosessions", "freeblock") ?>" method="post">
                    <input id="free-audiosession-id" type="hidden" name="id" val="0">
                    <button class="btn btn-success" type="submit" >Отменить блок</button>
                </form>
                    </div>
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
        <li class="active"><a href="<?php echo getActionLink("audiosessions") ?>">Аудиосеансы</a></li>
        <li><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li><?php endif; ?>
        <li><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>

<div class="admin-content">

    <h2>Аудиосеансы</h2>

    <?php if(User::can('add_audiosessions')): ?>
    <div class="admin-buttons">
        <a class="btn btn-primary" href="<?php echo getActionLink("audiosessions", "add") ?>">
            Добавить аудиосеанс
        </a>
    </div>
    <?php endif; ?>

    <table class="admin-table as-admin-table">
        <tr>
            <th class="td-id">id</th>
            <th class="td-caption">Название сеанса</th>
            <th class="td-date">Дата</th>
            <th class="td-block">Блокировка</th>
            <th class="td-listen">Прослушать</th>
            <th class="td-delete">Удалить</th>
            <th class="td-publish">Опубликовано</th>
        </tr>
            <?php foreach($data['audiosessions'] as $asess): ?>

                <tr>
                    <td><a href="<?php if(User::can('edit_audiosessions')) echo getActionLink("audiosessions", "edit", array("id" => $asess->id )) ; else echo getActionLink("audiosessions");?>"><?php echo $asess->id ?></a></td>
                    <td><a href="<?php if(User::can('edit_audiosessions')) echo getActionLink("audiosessions", "edit", array("id" => $asess->id )) ; else echo getActionLink("audiosessions");?>"><?php echo $asess->caption ?></a></td>
                    <td><a href="<?php if(User::can('edit_audiosessions')) echo getActionLink("audiosessions", "edit", array("id" => $asess->id )) ; else echo getActionLink("audiosessions");?>"><?php echo $asess->created ?></a></td>

                <?php if($asess->blocked): ?>
                    <td><button onclick='blockAudiosession(<?php echo $asess->id ?>)' type="button" class="btn btn-danger block-button-blocked"><?php echo date_format(date_create($asess->blockstart), "d.m.y")."<br>".date_format(date_create($asess->blockend), "d.m.y") ?></button></td>
                <?php else: ?>
                    <td><button type="button" class="btn btn-primary block-button" onclick='blockAudiosession(<?php echo $asess->id ?>)'>НЕТ</button></td>
                <?php endif; ?>

                <td><a href="<?php if(User::can('edit_audiosessions')) echo getActionLink("abonements", "listen"); else echo getActionLink("audiosessions");?>" class="admin-play-button"></a></td>

                <td><button <?php if(!User::can('delete_audiosessions')): ?>disabled<?php endif; ?> class="btn btn-danger" onclick='deleteAudiosession(<?php echo $asess->id ?>)'>Удалить</button></td>

                <?php if($asess->published): ?>
                    <td><i class="fa fa-share-square-o"></i></td></tr>
                <?php else: ?>
                    <td></td></tr>
                <?php endif; ?>

            <?php endforeach; ?>
    </table>

</div>


