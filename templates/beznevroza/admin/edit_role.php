<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 01.03.2017
 * Time: 21:08
 */
?>

<div class="admin-left-menu">
    <ul>
        <li class="active">
            <a href="<?php echo getActionLink("users") ?>">Пользователи</a>
            <ul>
                <li><a href="<?php echo getActionLink("users") ?>">Пользователи</a></li>
                <li class="active" ><a href="<?php echo getActionLink("roles") ?>">Роли</a></li>
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
        <a href="<?php echo getActionLink("users") ?>">Пользователи</a> / <a href="<?php echo getActionLink("roles") ?>">Роли</a> / <a class="active" href="#">Настройка роли</a>
    </div>
    <!--      breadcrumbs        /-->

    <h2>Настройка роли</h2>

    <form action="<?php echo getActionLink("roles", "save", array( 'id' => $data['role']->id )) ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $data['role']->id ?>">
        <div class="form-group">
            <label>Название роли</label>
            <input name="caption" type="text" class="form-control" placeholder="Введите название" value="<?php echo $data['role']->caption ?>">
        </div>

        <div class="checkbox">
            <label><input name="add_user" type="checkbox" value="1" <?php if($data['role']->add_user) echo "checked" ?> > Добавлять пользователей</label>
        </div>
        <div class="checkbox">
            <label><input name="delete_user" type="checkbox" value="1" <?php if($data['role']->delete_user) echo "checked" ?> > Удалять пользователей</label>
        </div>
        <div class="checkbox">
            <label><input name="edit_user" type="checkbox" value="1" <?php if($data['role']->edit_user) echo "checked" ?> > Редактировать данные пользователей</label>
        </div>
        <div class="checkbox">
            <label><input name="view_user_data" type="checkbox" value="1" <?php if($data['role']->view_user_data) echo "checked" ?> > Просматривать данные пользователей</label>
        </div>
        <div class="checkbox">
            <label><input name="block_user" type="checkbox" value="1" <?php if($data['role']->block_user) echo "checked" ?> > Блокировать пользователей</label>
        </div>
        <div class="checkbox">
            <label><input name="add_comments" type="checkbox" value="1" <?php if($data['role']->add_comments) echo "checked" ?> > Добавлять комментарии</label>
        </div>
        <div class="checkbox">
            <label><input name="review_comments" type="checkbox" value="1" <?php if($data['role']->review_comments) echo "checked" ?> > Одобрять комментарии</label>
        </div>
        <div class="checkbox">
            <label><input name="delete_comments" type="checkbox" value="1" <?php if($data['role']->delete_comments) echo "checked" ?> > Удалять комментарии</label>
        </div>
        <div class="checkbox">
            <label><input name="add_audiosessions" type="checkbox" value="1" <?php if($data['role']->add_audiosessions) echo "checked" ?> > Добавлять аудиосессии</label>
        </div>
        <div class="checkbox">
            <label><input name="delete_audiosessions" type="checkbox" value="1" <?php if($data['role']->delete_audiosessions) echo "checked" ?> > Удалять комментарии</label>
        </div>
        <div class="checkbox">
            <label><input name="edit_audiosessions" type="checkbox" value="1" <?php if($data['role']->edit_audiosessions) echo "checked" ?> > Редактировать комментарии</label>
        </div>
        <div class="checkbox">
            <label><input name="publish_audiosessions" type="checkbox" value="1" <?php if($data['role']->publish_audiosessions) echo "checked" ?> > Публиковать комментарии</label>
        </div>

        <div class="checkbox">
            <label><input name="review_statistics" type="checkbox" value="1" <?php if($data['role']->review_statistics) echo "checked" ?> > Просматривать статистику</label>
        </div>
        <div class="checkbox">
            <label><input name="delete_abonements" type="checkbox" value="1" <?php if($data['role']->delete_abonements) echo "checked" ?> > Удалять абонементы</label>
        </div>
        <div class="checkbox">
            <label><input name="edit_abonements" type="checkbox" value="1" <?php if($data['role']->edit_abonements) echo "checked" ?> > Редактировать абонементы</label>
        </div>
        <div class="checkbox">
            <label><input name="block_abonements" type="checkbox" value="1" <?php if($data['role']->block_abonements) echo "checked" ?> > Блокировать абонементы</label>
        </div>
        <div class="checkbox">
            <label><input name="review_history" type="checkbox" value="1" <?php if($data['role']->review_history) echo "checked" ?> > Прсматривать историю изменений аудиосеанса комментарии</label>
        </div>

        <div class="checkbox">
            <label><input name="admin_access" type="checkbox" value="1" <?php if($data['role']->admin_access) echo "checked" ?> > Доступ к административной части сайта</label>
        </div>


        <div class="admin-buttons-bottom">
            <button class="btn btn-primary" type="submit">Сохранить</button>
            <a class="btn btn-success" href="<?php echo getActionLink("roles") ?>">Отмена</a>
        </div>

    </form>
</div>