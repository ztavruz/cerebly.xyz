<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 27.02.2017
 * Time: 18:55
 */
?>

<div class="modal fade confirm-window-simple" id="delete-abonement">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Вы уверены что хотите удалить абонемент?</h4>
            </div>
            <form action="<?php echo getActionLink("abonements", "delete") ?>" method="post">
                <input id="id-field" type="hidden" name="id" value="0">
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

<div class="modal fade confirm-block-window" id="block-abonement">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Блокировать</h4>
            </div>
            <div class="modal-body clearfix">

                <form action="<?php echo getActionLink("abonements", "saveblock") ?>" method="post">
                    <input id="block-id" type="hidden" name="id" val="0">
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
                <form action="<?php echo getActionLink("abonements", "freeblock") ?>" method="post">
                    <input id="free-block-id" type="hidden" name="id" val="0">
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
        <li><a href="<?php echo getActionLink("audiosessions") ?>">Аудиосеансы</a></li>
        <li  class="active"><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li><?php endif; ?>
        <li><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>

<div class="admin-content">

    <!--      breadcrumbs        -->
    <div class="admin-breadcrumbs">
        <a class="active" href="">Абонементы</a>
    </div>
    <!--      breadcrumbs        /-->

    <h2>Список абонементов</h2>

    <table class="admin-table ab-admin-table">
        <tr>
            <th>ID</th>
            <th>Стоимость</th>
            <th>Владелец</th>
            <th>Кол-во</th>
            <th>Осталось</th>
            <th>На сумму</th>
            <th>Оплачен</th>
            <th>Блокировка</th>
            <th>Удалить</th>
        </tr>


        <?php foreach($data as $row): ?>
            <tr>
                <td><a href="<?php if(User::can('review_statistics')) echo getActionLink("abonements","viewadmin", array("id" => $row['abonement']->id )) ?>"><?php echo $row['abonement']->id ?></a></td>
                <td><a href="<?php if(User::can('review_statistics')) echo getActionLink("abonements","viewadmin", array("id" => $row['abonement']->id )) ?>"><?php echo round($row['abonement']->outsum, 2)." руб." ?></a></td>
                <td><a href="<?php if(User::can('review_statistics')) echo getActionLink("abonements","viewadmin", array("id" => $row['abonement']->id )) ?>"><?php echo $row['owner-name']?></a></td>
                <td><a href="<?php if(User::can('review_statistics')) echo getActionLink("abonements","viewadmin", array("id" => $row['abonement']->id )) ?>"><?php echo $row['abonement']->getTimesTotal() ?></a></td>
                <td><a href="<?php if(User::can('review_statistics')) echo getActionLink("abonements","viewadmin", array("id" => $row['abonement']->id )) ?>"><?php echo $row['abonement']->getTimesLeft() ?></a></td>
                <td><a href="<?php if(User::can('review_statistics')) echo getActionLink("abonements","viewadmin", array("id" => $row['abonement']->id )) ?>"><?php echo $row['abonement']->getLeftSum()." руб." ?></a></td>
                <td><a href="<?php if(User::can('review_statistics')) echo getActionLink("abonements","viewadmin", array("id" => $row['abonement']->id )) ?>"><?php echo $row['abonement']->getPaidLabel() ?></a></td>
                <td>

                        <?php

                        $canBlock = User::can('block_abonements') ? "" : "disabled" ;

                            if($row['abonement']->blocked){
                                echo "<button type=\"button\" class=\"btn btn-primary block-button\" onclick='blockAbonement({$row['abonement']->id})' $canBlock >".
                                        $row['abonement']->getBlockStart("d.m.Y")."<br>".$row['abonement']->getBlockEnd("d.m.Y").
                                    "</button>";
                            }
                            else
                                echo "<button type=\"button\" class=\"btn btn-primary block-button\" onclick='blockAbonement({$row['abonement']->id})' $canBlock>".
                                    "НЕТ".
                                    "</button>";
                        ?>

                </td>
                <td>
                    <button <?php if(!User::can('delete_abonements')): ?>disabled<?php endif; ?> type="button" class="btn btn-danger" onclick="deleteAbonement(<?php echo $row['abonement']->id ?>)">Удалить</button>

                </td>
            </tr>

            <?php endforeach; ?>
    </table>


</div>