<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 20.02.2017
 * Time: 6:17
 */

?>
<div class="admin-content-wrapper">

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
                <a href="">Пользователи</a> / <a class="active" href="">Добавить пользователя</a>
            </div>
            <!--      breadcrumbs        /-->

    <form method="post" action="<?php echo getActionLink("users", "save") ?>" class="autocomplite">
        <table class="admin-form add-user-form">
            <tr>
                <td>Имя</td>
                <td>
                    <input name="firstname" class="form-control" type="text" placeholder="Имя" value="<?php echo $data['form']->getField('firstname') ?>">
                </td>
                <td>
                    <?php if($data['form']->validationError('firstname')): ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php echo $data['form']->validationError('firstname') ?>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Фамилия</td>
                <td>
                    <input name="lastname" class="form-control" type="text" placeholder="Фамилия" value="<?php echo $data['form']->getField('lastname') ?>">
                </td>
                <td>
                    <?php if($data['form']->validationError('lastname')): ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php echo $data['form']->validationError('lastname') ?>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Отчество</td>
                <td>
                    <input name="patronymic" class="form-control" type="text" placeholder="Отчество" value="<?php echo $data['form']->getField('patronymic') ?>">
                </td>
                <td>
                    <?php if($data['form']->validationError('patronymic')): ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php echo $data['form']->validationError('patronymic') ?>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $data['form']->getField('email') ?>">
                </td>
                <td>
                    <?php if($data['form']->validationError('email')): ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php echo $data['form']->validationError('email') ?>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Пол</td>
                <td>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="0" <?php if($data['form']->getField('gender')) echo "checked"?>> Мужской
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="1" <?php if(!$data['form']->getField('gender')) echo "checked"?>> Женский
                    </label>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Дата рождения</td>
                <td>
                    <select class="form-control day-select" name="day">
                        <option value="0" <?php

                        $day = $data['form']->getField('day');
                        if(empty($day)) echo "selected";

                        ?>>День</option>

                        <?php
                        for($i = 1; $i <= 31; $i++)
                        {
                            echo "<option value=\"$i\" ";
                            if($day == $i) echo "selected";
                            echo ">$i</option>";
                        }
                        ?>
                    </select>
                    <select class="form-control mounth-select" name="mounth">
                        <option value="0" <?php

                        $mounth = $data['form']->getField('month');
                        if(empty($mounth)) echo "selected";

                        ?>>Месяц</option>

                        <?php
                        for($i = 1; $i <= 12; $i++)
                        {
                            echo "<option value=\"$i\" ";
                            if($mounth == $i) echo "selected";
                            echo ">".getMounth($i)."</option>";
                        }
                        ?>
                    </select>
                    <select class="form-control year-select" name="year">
                        <option value="0" <?php

                        $year = $data['form']->getField('year');
                        if(empty($year)) echo "selected";

                        ?>>Год</option>

                        <?php
                        for($i = 2017; $i >= 1900; $i--)
                        {
                            echo "<option value=\"$i\" ";
                            if($year == $i) echo "selected";
                            echo ">".$i."</option>";
                        }
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Пароль</td>
                <td>
                    <input type="text" id="password-field" class="form-control admin-form-password"  name="password">
                    <button type="button" class="btn btn-success" onclick="createPassword()">
                        Сгенерировать
                    </button>
                </td>
                <td>
                    <?php if($data['form']->validationError('password')): ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php echo $data['form']->validationError('password') ?>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>skype</td>
                <td>
                    <input type="text" class="form-control" name="skype" placeholder="Скайп" value="<?php echo $data['form']->getField('skype') ?>">
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td><input type="text" class="form-control phone" name="phone" placeholder="Телефон" value="<?php echo $data['form']->getField('phone') ?>"></td>
                <td>
                    <?php if($data['form']->validationError('phone')): ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php echo $data['form']->validationError('phone') ?>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Индекс</td>
                <td><input type="text" class="form-control" name="zipcode" placeholder="Индекс" value="<?php echo $data['form']->getField('zip') ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>Регион</td>
                <td><input type="text" class="form-control" name="region" placeholder="Регион" value="<?php echo $data['form']->getField('region') ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>Город</td>
                <td><input type="text" class="form-control" name="city" placeholder="Город" value="<?php echo $data['form']->getField('city') ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>Улица</td>
                <td><input type="text" class="form-control" name="street" placeholder="Улица" value="<?php echo $data['form']->getField('street') ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>Дом</td>
                <td><input type="text" class="form-control" name="building" placeholder="Дом" value="<?php echo $data['form']->getField('building') ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>Квартира</td>
                <td><input type="text" class="form-control" name="apartment" placeholder="Квартира" value="<?php echo $data['form']->getField('apartment') ?>"></td>
                <td></td>
            </tr>
            <tr>
                <td>Роль</td>
                <td>
                    <select name="role" class="form-control" >
                        <?php
                        foreach($data['roles'] as $role)
                            echo "<option value={$role->id}>{$role->caption}</option>";
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
        </table>
        <input name="id" type="hidden" value="<?php echo $data['form']->getField('id') ?>">
        <div class="admin-buttons-bottom">
            <button class="btn btn-primary" type="submit">Добавить</button>
            <a class="btn btn-success" href="<?php echo getActionLink("users") ?>">Отмена</a>
        </div>
    </form>
    </div>
</div>
