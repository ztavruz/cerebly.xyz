<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 26.02.2017
 * Time: 16:46
 */


?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>Beznevroza</title>
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/bootstrap.css" >
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/style.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
</head>


<body>




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


                    <button type="button" class="btn btn-primary"  id="sendbtn"  onclick="sendLoginForm()">Войти</button>
                    <div class="clearfix">
                        <a href="http://www.cerebry.xyz/<?php echo getActionLink("registration", "forget") ?>" class="forget-password">Забыли пароль?</a>
                        <a href="http://www.cerebry.xyz/<?php echo getActionLink("registration") ?>" class="registration-link">Регистрация</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    window.addEventListener("load", function(){
        $('#logonid').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo getAssetsUrl() ?>js/bootstrap.js"></script>
<script src="<?php echo getAssetsUrl() ?>js/scripts.js"></script><script src="../assets/js/bootstrap.js"></script>
</body>

</html>