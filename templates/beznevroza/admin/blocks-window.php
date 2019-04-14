<?php
?>
<form id="blockform" method="post" action="<?php echo getActionLink("ajax", "saveblocks") ?>">
    <input type="hidden" name="id" value="<?php echo $data['userid'] ?>">
    <table class="admin-table">
        <tr>
            <th colspan="3">Пользователи</th>
        </tr>
        <tr>
            <td>Добавление пользователей</td>
            <?php getBlockField($data['blocks'], "add_user") ?>
        </tr>
        <tr>
            <td>Удаление пользователей</td>
            <?php getBlockField($data['blocks'], "delete_user") ?>
        </tr>
        <tr>
            <td>Редактировать данные пользователя</td>
            <?php getBlockField($data['blocks'], "edit_user") ?>
        </tr>
        <tr>
            <td>Просматривать данные пользователя</td>
            <?php getBlockField($data['blocks'], "view_user_data") ?>
        </tr>


        <tr>
            <td>Блокировки пользователей</td>
            <?php getBlockField($data['blocks'], "block_user") ?>
        </tr>
        <tr>
            <th colspan="3">Комментарии</th>
        </tr>
        <tr>
            <td>Добавление комментариев</td>
            <?php getBlockField($data['blocks'], "add_comments") ?>
        </tr>
        <tr>
            <td>Удаление комментариев</td>
            <?php getBlockField($data['blocks'], "delete_comments") ?>
        </tr>
        <tr>
            <td>Одобрять комментарии</td>
            <?php getBlockField($data['blocks'], "review_comments") ?>
        </tr>
        <tr>
            <th colspan="3">Аудиосеансы</th>
        </tr>
        <tr>
            <td>Добавление аудиосеансов</td>
            <?php getBlockField($data['blocks'], "add_audiosessions") ?>
        </tr>
        <tr>
            <td>Удаление аудиосеансов</td>
            <?php getBlockField($data['blocks'], "delete_audiosessions") ?>
        </tr>
        <tr>
            <td>Редактирование аудиосеансов</td>
            <?php getBlockField($data['blocks'], "edit_audiosessions") ?>
        </tr> <tr>
            <td>Блокирование аудиосеансов</td>
            <?php getBlockField($data['blocks'], "block_audiosessions") ?>
        </tr>
        <tr>
            <td>Публикация аудиосеансов</td>
            <?php getBlockField($data['blocks'], "publish_audiosessions") ?>
        </tr>
        <tr>
            <td>Просмотр статистики аудиосеансов</td>
            <?php getBlockField($data['blocks'], "review_statistics") ?>
        </tr>
        <tr>
            <th colspan="3">Абонементы</th>
        </tr>
        <tr>
            <td>Редактирование абонементов</td>
            <?php getBlockField($data['blocks'], "edit_abonements") ?>
        </tr>
        <tr>
            <td>Удаление абонементов</td>
            <?php getBlockField($data['blocks'], "delete_abonements") ?>
        </tr>
        <tr>
            <td>Блокировка абонементов</td>
            <?php getBlockField($data['blocks'], "block_abonements") ?>
        </tr>
        <tr>
            <td>Просмотр истории изменений абонементов</td>
            <?php getBlockField($data['blocks'], "review_history") ?>
        </tr>
        <tr>
            <td>Доступ к административному разделу</td>
            <?php getBlockField($data['blocks'], "admin_access") ?>
        </tr>
        <tr>
            <td>Изменять роли</td>
            <?php getBlockField($data['blocks'], "edit_roles") ?>
        </tr>
    </table><!-- onclick="sendBlockForm() -->
    <button class="btn btn-primary" type="submit" ">Сохранить</button>
</form>