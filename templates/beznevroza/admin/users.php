<?php

getAdminLeftMenu();

?>


<div class="modal fade block-window" id="block_window">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Блокировка</h4>
            </div>
            <div id="modal-body-content" class="modal-body clearfix">

            </div>
        </div>
    </div>
</div>



<div class="modal fade  confirm-window-simple confirm-window-simple-test" id="confirm_window_simple">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Вы уверены что хотите удалить пользователя?</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="buttons clearfix">
                    <form id="deleteform" action="<?php echo getActionLink("users", "delete") ?>" method="post">
                        <input id="deleteid" type="hidden" name="id" value="">
                        <button type="submit" class="btn btn-primary">Удалить</button>
                        <a href="" class="btn btn-success" data-dismiss="modal">Отмена</a>
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
                <li class="active"><a href="<?php echo getActionLink("users") ?>">Пользователи</a></li>
                <li><a href="<?php echo getActionLink("roles") ?>">Роли</a></li>
            </ul>
        </li>
        <li><a href="<?php echo getActionLink("audiosessions") ?>">Аудиосеансы</a></li>
        <li><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a>
        </li><?php endif; ?>
        <li><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>


<div class="admin-content">

    <h2>Пользователи</h2>

    <?php if(User::can('add_user')):?>
    <div class="admin-buttons">
        <a class="btn btn-primary" href="<?php echo getActionLink("users", "new") ?>">
            Добавить пользователя
        </a>
    </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ul class="list-group list-group-horizontal">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                </ul>
            </div>
        </div>
    </div>

    <table class="admin-table users-admin-table">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Регистрация</th>
            <th>Коммен-тарии</th>
            <th>Блокирован</th>
            <th>Удалить</th>
            <th>Роль</th>
        </tr>

        <?php
        foreach($data['users'] as $user):
            ?>

        <tr>
            <td><a
                    href="<?php if(User::can('view_user_data')) echo getActionLink("users", "user", array("id" => $user['id'])) ?>">
                    <?php echo $user['id'] ?></a></td>
            <td><a
                    href="<?php if(User::can('view_user_data')) echo getActionLink("users", "user", array("id" => $user['id'])) ?>">
                    <?php echo $user['email'] ?></a></td>
            <td><a
                    href="<?php if(User::can('view_user_data')) echo getActionLink("users", "user", array("id" => $user['id'])) ?>">
                    <?php echo $user['firstname'] ?></a></td>
            <td><a
                    href="<?php if(User::can('view_user_data')) echo getActionLink("users", "user", array("id" => $user['id'])) ?>">
                    <?php echo $user['lastname'] ?></a></td>
            <td><a
                    href="<?php if(User::can('view_user_data')) echo getActionLink("users", "user", array("id" => $user['id'])) ?>">
                    <?php echo $user['register_time'] ?></a></td>
            <td><?php echo $user['comments_count'] ?></td>
            <td><button <?php if(!User::can('block_user')): ?>disabled<?php endif; ?> type="button"
                    class="btn btn-primary block-button" onclick="blockWindow(<?php echo $user['id'] ?>)">
                    <?php
                        if($user['blocks_count']) echo "блокировок: ".$user['blocks_count'];
                        else echo "нет";
                        ?>
                </button>
            </td>
            <td><button <?php if(!User::can('delete_user')): ?>disabled<?php endif; ?> type="button"
                    class="btn btn-danger" onclick="deleteWindow(<?php echo $user['id'] ?>)">Удалить</button>
            </td>
            <td><a
                    href="<?php if(User::can('view_user_data')) echo getActionLink("users", "user", array("id" => $user['id'])) ?>">
                    <?php echo $user['role'] ?></a></td>
        </tr>
        <?php
        endforeach;
        ?>
    </table>



</div>