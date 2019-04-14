<?php

$isok = $data['isok'];

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
                <a href="<?php echo getActionLink("support") ?>">Техподдержка</a> / <a class="active" href="">Ответить</a>
            </div>
            <!--      breadcrumbs        /-->

    <div class="container">
    <div class="row">
        <div class="white-block">
                         <?php //foreach ($isok as $key){
                              if ($isok) {
                                  echo "<h2>Успешно отправлено!</h2>";
                              } else {
                                  echo "<h2>Возикла ошибка!</h2>";
                              };   
                            ?>       
        </div>
    </div>
    </div>