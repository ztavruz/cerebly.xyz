<?php
// Запрещает прямой запуск в обход index.php
defined('BEZNEVROZA') or die("Доступ запрещен...");

?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>Beznevroza</title>
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/bootstrap.css" >
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/datepicker.css" >
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/jquery.kladr.min.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/form.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/style.css">
    <!-- <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/jquery.jqzoom.css"> -->
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/player.css">

</head>
<body>

<header>
    <div class="container">
        <a href="index.php"><div class="logo"></div></a>
        <ul>
            <li><a role="button" class="btn" href="index.php">Все аудиосеансы</a></li>
            <?php if($data['user']): $id = $data['user']->id; ?>

            <li><a role="button" class="btn" data-toggle="modal" data-target="#support" >Техподдержка</a></li>
            <li><a role="button" class="btn" href="<?php echo getActionLink("questions", "historymails",array("id" => $id)) ?>">История сообщений</a></li>
            <?php if(!Abonement::userCanCreateAbonement()): ?><li>
            <a role="button" class="btn" href="<?php echo getActionLink("abonements", "view") ?>">Мои абонементы</a></li><?php endif; ?>
        </ul>
        <a href="<?php echo getActionLink('authorization', 'logout') ?>" class="btn btn-primary">Выйти</a>
        <?php else: ?>
            <li><a role="button" class="btn" href="<?php echo getActionLink('registration') ?>" >Зарегистрироваться</a></li>
            </ul>
            <button data-toggle="modal" data-target="#logonid" class="btn btn-primary">Войти</button>
        <?php endif; ?>
    </div>
</header>

<?php

if(!$data['user']) {

?>
    <div class="modal fade logon-form" id="logonid" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Вход</h4>
                </div>
                <div class="modal-body">
                    <form id="modal_login_form" method="post" action="<?php echo getActionLink("authorization", "login") ?>">
                        <div class="form-group">
                            <label for="login_email_id">Email</label>
                            <input name="email" type="email" class="form-control" id="login_email_id" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="login_password_id">Пароль</label>
                            <input name="password" type="password" class="form-control" id="login_password_id" placeholder="">
                        </div>
                        <div class="error-field">
                            <span></span>
                        </div>



                        <button type="button" class="btn btn-primary" id="sendbtn" onclick="sendLoginForm()">Войти</button>
                        <div class="clearfix">
                            <a href="<?php echo getActionLink("registration", "forget") ?>" class="forget-password">Забыли пароль?</a>
                            <a href="<?php echo getActionLink("registration") ?>" class="registration-link">Регистрация</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php

}

?>

<?php

if($data['user']) {

?>

    <div class="modal fade" id="support" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Задать вопрос</h4>
                </div>
                               <div class="modal-body">
                <form class="form" action="<?= getActionLink('support', 'ask') ?>" method="post">
                    <div class="white-block">
                    <div class="form-group">
                        <label for="send-question">Категория вопроса</label>
                        <select name="category">
                            <option value="0" selected>Выберите категорию вопроса</option>
                            <option value="1" >Проблемы с отображением страницы </option>
							<option value="2" >Проблемы с оплатой </option>
							<option value="3" >Другое </option>
                            <?php foreach($data['question_category'] as $q_category): ?>
                            <option value="<?= $q_category['id'] ?>"><?= $q_category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="send-question">Текст вопроса:</label>
                        <textarea name="content" class="form-control" placeholder="текст вопроса"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" value="Отправить">
                    </div>
                    </div>
                </form>
                                </div>
            </div>
        </div>
    </div>

<?php

}

?>

<div class="container">

