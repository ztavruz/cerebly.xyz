<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 27.02.2017
 * Time: 18:18
 */

?>
<div class="modal fade confirm-window-simple" id="del_comment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Вы уверены что хотите удалить комментарий?</h4>
            </div>
            <div class="modal-body clearfix">
                <form id="removecomment" action="<?php echo getActionLink("comments", "delete") ?>" method="post">
                    <input type="hidden" name="id" value="0">
                    <div class="buttons clearfix">
                        <button type="submit" class="btn btn-primary">Удалить</button>
                        <button href="" class="btn btn-success" data-dismiss="modal">Отмена</button>
                    </div>
                </form>
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
        <li><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <li class="active"><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li>
        <li><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>

<div class="admin-content">

    <!--      breadcrumbs        -->
    <div class="admin-breadcrumbs">
        <a class="active" href="">Комментарии</a>
    </div>
    <!--      breadcrumbs        /-->

    <h2>Комментарии</h2>

    <div class="admin-buttons">
        <a class="btn btn-primary" href="<?php echo getActionLink("comments", "search") ?>">
            Все
        </a>
        <a class="btn btn-success" href="<?php echo getActionLink("comments", "search", array("filter" => "noapproved")) ?>">
            Ожидающие одобрения
        </a>
    </div>

    <div class="admin-comments">

        <?php
        $can_delete = User::can('delete_comments') ? true : false ;
        foreach($data['comments'] as $comment){

            ?>

            <div class="comment-item">
                <div class="admin-comment-buttons">
                    <?php if($can_delete): ?><button class="comment-delete-btn" onclick="deleteCommentModal(<?php echo $comment['id'] ?>)">Удалить</button><?php endif; ?>
                    <?php if(!$comment['approved']):   ?>
                    <a href="<?php echo getActionLink("comments", "approve", array("id" => $comment['id'])) ?>" class="comment-approve-btn">Одобрить</a>
                    <?php endif; ?>
                </div>

                <h3><?php echo $comment['firstname']." ".$comment['lastname'] ?></h3>
                <h4><span>Аудиосеанс:</span> <?php echo $comment['caption'] ?></h4>
                <p><?php echo $comment['content'] ?></p>

            </div>

            <?php

        }

        ?>






    </div>

</div>


