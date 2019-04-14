<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 26.02.2017
 * Time: 23:58
 */
?>

<div class="modal fade confirm-window-simple" id="delete_role_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Вы уверены что хотите удалить роль?</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="buttons clearfix">
                    <form action="<?php echo getActionLink("roles", "delete") ?>" method="post">
                        <input name="id" type="hidden" value="0">
                        <button type="submit" class="btn btn-primary">Удалить</button>
                        <button class="btn btn-success" data-dismiss="modal">Отмена</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="admin-left-menu">
    <ul>
        <li class="active">
            <a href="<?php echo getActionLink("users") ?>">Пользователи</a>
            <ul>
                <li><a href="<?php echo getActionLink("users") ?>">Пользователи</a></li>
                <li class="active"><a href="<?php echo getActionLink("roles") ?>">Роли</a></li>
            </ul>
        </li>
        <li><a href="<?php echo getActionLink("audiosessions") ?>">Аудиосеансы</a></li>
        <li><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li><?php endif; ?>
        <li><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>

<div class="admin-content">

    <!--      breadcrumbs        -->
    <div class="admin-breadcrumbs">
        <a href="<?php echo getActionLink("users") ?>">Пользователи</a> / <a class="active" href="#">Роли</a>
    </div>
    <!--      breadcrumbs        /-->

    <h2>Роли</h2>

    <div class="fields">
        <form name="create-role-form" action="<?php echo getActionLink("roles", "create") ?>" method="post">
            <input name="rolename" type="text" class="admin-textfield" placeholder="Введите название роли">
            <button type="submit" class="admin-button settings-button">
                Добавить
            </button>
        </form>
    </div>

    <?php foreach($data['roles'] as $role){
    ?>
        <div class="fields">
            <span><?php echo $role->caption ?></span>
            <a href="<?php echo getActionLink("roles", "edit", array("id" => $role->id )) ?>" class="admin-button settings-button">
                <i class="settings-icon"></i>  Настроить
            </a>
            <button onclick="deleteRoleModal(<?php echo $role->id ?>)" class="admin-button delete-button">
                <i class="delete-icon"></i>  Удалить
            </button>
        </div>
    <?php
    }
    ?>

</div>



