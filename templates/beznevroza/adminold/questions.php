<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 27.02.2017
 * Time: 18:55
 */
?>

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
        <li><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li><?php endif; ?>
        <li><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li class="active"><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>

<div class="admin-content">

    <!--      breadcrumbs        -->
    <div class="admin-breadcrumbs">
        <a class="active" href="">Техподдержка</a>
    </div>
    <!--      breadcrumbs        /-->

    <h2>Список абонементов</h2>

    <table class="admin-table ab-admin-table">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Дата вопроса</th>
            <th>Категория вопроса</th>
            <th>Вопрос</th>
            <th>Ответ</th>
            <th>Удалить</th>
        </tr>
<?php

?>

        <?php foreach($data['questions'] as $question): ?>
            <tr>
                <td><a ><?php echo $question->id ?></a></td>
                <td><a href="<?= getActionLink('questions','default', array("id" => $question->id))?>"><?php echo $question->email?></a></td>
                <td><a href="<?= getActionLink('questions','default', array("id" => $question->id))?>"><?php echo $question->firstname ?></a></td>
                <td><a href="<?= getActionLink('questions','default', array("id" => $question->id))?>"><?php echo $question->lastname ?></a></td>
                <td><a href="<?= getActionLink('questions','default', array("id" => $question->id))?>"><?php echo $question->date ?></a></td>
                <td><a href="<?= getActionLink('questions','default', array("id" => $question->id))?>"><?php echo $question->category ?></a></td>
                <td><div class="table_cont_hidden"><a href="<?= getActionLink('questions','default', array("id" => $question->id))?>"><?php echo $question->content ?></a></div></td>
                <td><div class="table_cont_hidden"><a href="<?= getActionLink('questions','default', array("id" => $question->id))?>"><?php echo $question->answer ?></a></div></td>
                <td><button type="button" class="btn btn-danger" onclick="deleteWindow(<?php echo $question->id ?>)">Удалить</button></td>
            </tr>

        <?php endforeach; ?>
    </table>


</div>

<div class="modal fade confirm-window-simple" id="confirm_window_simple">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Вы уверены что хотите удалить вопрос?</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="buttons clearfix">
                    <form id="deleteform" action="<?php echo getActionLink("questions", "delete") ?>" method="post">
                        <input id="deleteid" type="hidden" name="id" value="">
                        <button type="submit" class="btn btn-primary">Удалить</button>
                        <a href="" class="btn btn-success"  data-dismiss="modal" >Отмена</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>