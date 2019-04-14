<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 03.03.2017
 * Time: 2:19
 */
?>
<div class="modal fade modal-change-password" id="modal-change-password">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo getActionLink("users", "chpass") ?>" method="post">
                <div class="modal-body clearfix">
                    <input type="text" name="password" class="form-control" placeholder="Введите пароль">
                    <input type="hidden" name="id" value="<?php echo $data['user']->id ?>">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-change-password" id="modal-change-role">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo getActionLink("users", "chrole", array("id" => $data['user']->id )) ?>" method="post" class="roles-list-form">
                <div class="modal-body clearfix">
                    <?php foreach($data['roles'] as $role): ?>
                    <input id="role-radio-<?php echo $role->id ?>" type="radio" name="role" value="<?php echo $role->id ?>">
                    <label for="role-radio-<?php echo $role->id ?>"><?php echo $role->caption ?></label>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="admin-left-menu">
    <ul>
        <li class="active">
            <a href="<?php echo getActionLink("users") ?>">Пользователи</a>
            <ul>
                <li  class="active" ><a href="<?php echo getActionLink("users") ?>">Пользователи</a></li>
                <?php if(User::can('edit_roles')): ?><li><a href="<?php echo getActionLink("roles") ?>">Роли</a></li><?php endif; ?>
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
        <a href="">Пользователи</a> / <a class="active" href="">Данные пользователя</a>
    </div>
    <!--      breadcrumbs        /-->


    <!-- --------------------Контент страницы---------------------------------------------- -->



    <h2>Данные пользователя</h2>

    <div class="fields">
        <div class="admin-button settings-button user-top" <?php if(User::can('edit_user')):?> data-toggle="modal" data-target="#modal-change-password" >Сменить пароль<?php else: ?>>Вы не можете менять пароль<?php endif; ?></div>
        <a href="<?php echo getActionLink("comments","viewcomments", array( "id" => $data['user']->id ) ) ?>" class="admin-button settings-button user-top">Комментарии<?php if($data['comments_count']) echo " (".$data['comments_count'].")" ?></a>
        <div class="admin-button settings-button user-top" <?php if(User::can('edit_roles') && User::can('edit_user')):?> data-toggle="modal" data-target="#modal-change-role" >Сменить роль<?php else: ?>>Вы не можете менять роли<?php endif; ?></div>
    </div>

    <table class="admin-table-list user-info">
        <tr>
            <td>Имя</td>
            <td><?php echo $data['user']->firstname ?></td>
        </tr>
        <tr>
            <td>Фамилия</td>
            <td><?php echo $data['user']->lastname ?></td>
        </tr>
        <tr>
            <td>Отчество</td>
            <td><?php echo $data['user']->patronymic ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $data['user']->email ?></td>
        </tr>
        <tr>
            <td>Пароль</td>
            <td><?php echo $data['user']->password ?></td>
        </tr>		
        <tr>
            <td>Пол</td>
            <td><?php if($data['user']->gender == 0) echo "Мужской";
                        else echo "Женский";?></td>
        </tr>
        <tr><td>Возраст</td><td><?php echo $data['user']->getAge() ?></td></tr>
        <tr><td>skype</td><td><?php echo $data['user']->skype ?></td></tr>
        <tr><td>Телефон</td><td><?php echo $data['user']->phone ?></td></tr>
        <tr>
            <td>Регион</td>
            <td><?php echo $data['user']->region ?></td>
        </tr>
        <tr>
            <td>Город</td>
            <td><?php echo $data['user']->city ?></td>
        </tr>
        <tr>
            <td>Улица</td>
            <td><?php echo $data['user']->street ?></td>
        </tr>
        <tr>
            <td>Дом</td>
            <td><?php echo $data['user']->building ?></td>
        </tr>
        <tr>
            <td>Квартира</td>
            <td><?php echo $data['user']->apartment ?></td>
        </tr>
        <tr>
            <td>Индекс</td>
            <td><?php echo $data['user']->zipcode ?></td>
        </tr>
        <tr>
            <td>Роль</td>
            <td><?php echo $data['roles'][$data['user']->role]->caption ?></td>
        </tr>
    </table>


    <?php if($data['abonement']): ?>
    <table class="admin-table-2">
        <tr>
            <th>Срок действия</th>
            <th>Длительность</th>
            <th>Кол-во сеансов</th>
            <th>Интервалы</th>
            <th>Скидка</th>
            <th>Код</th>
            <th>Оплачен</th>
            <th>Сумма</th>
        </tr>
        <tr>
            <td>с <?php echo $data['abonement']['start_date'] ?> <br> по <?php echo $data['abonement']['end_date'] ?></td>
            <td><?php echo $data['abonement']['duration'] ?></td>
            <td><?php echo $data['abonement']['sessions_num'] ?></td>
            <td>
                <?php echo implode("<br>",$data['abonement']['intervals']) ?>
            </td>
            <td>0%</td>
            <td><?php echo $data['abonement']['code'] ?></td>
            <td><?php echo $data['abonement']['paytime'] ?></td>
            <td><?php echo $data['abonement']['cost'] ?></td>
        </tr>
        <?php for( $i = 0 ; $i < 10 ; $i++ ): ?>
        <tr>
            <td><?php echo $i+1 ?></td>
            <td colspan="7"><?php if(isset($data['abonement']['plan'][$i])) echo $data['abonement']['plan'][$i]['caption'] ?></td>
        </tr>
        <?php endfor; ?>

    </table>


        <?php if(User::can('review_history')): ?>
    <a class="send-message-button" style="width: 300px;" href="<?php echo getActionLink("abonements", "history", array("id" => $data['abonement']['id'])) ?>">Посмотреть историю изменений</a>
        <?php endif; ?>
    <?php endif; ?>


    <!-- --------------------Контент страницы---------------------------------------------- -->

</div>

