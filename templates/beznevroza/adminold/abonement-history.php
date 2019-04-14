<?php

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
        <li class="active"><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li><?php endif; ?>
        <li class="active"><a href="<?php echo getActionLink("finances"); ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support"); ?>">Техподдержка</a></li>
    </ul>
</div>

<div class="admin-content">

    <!--      breadcrumbs        -->
    <div class="admin-breadcrumbs">
        <a href="<?php echo getActionLink("abonements") ?>">Абонементы</a> / <a class="active" href="#">Абонемент</a> / <a class="active" href="#">История изменений</a>
    </div>
    <!--      breadcrumbs        /-->

    <!-- --------------------Контент страницы---------------------------------------------- -->

    <h2>История изменений</h2>

    <?php if(!empty($data['history'])): ?>
    <div class="buttons-block">
        <a class="download-list-link" href=""><i class="download-icon"></i> Скачать одним файлом</a>
    </div>
    <?php endif; ?>

    <?php if(!empty($data['history'])): ?>
        <?php foreach($data['history'] as $historyItem): ?>
    <table class="admin-table-list history-list">
            <tr>
                <th colspan="2">Изменено <?php echo $historyItem['modifed'] ?></th>
            </tr>
            <?php for($i = 0; $i < 10; $i++):

                $caption = "";

                if(isset($historyItem['audiosessions'][$i])) {
                    $caption = $historyItem['audiosessions'][$i]['caption'];
                }
                ?>
        <tr>
            <td><?php echo $i+1 ?></td>
            <td><?php echo $caption ?></td>
        </tr>
        <?php endfor; ?>
    </table>
    <?php endforeach;
    endif; ?>
    </table>

    <!-- --------------------Контент страницы---------------------------------------------- -->

</div>


