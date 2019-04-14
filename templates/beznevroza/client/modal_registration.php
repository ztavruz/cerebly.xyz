<?php
// Запрещает запуск скрипта напрямую в обход index.php
defined('APPRUNNING') or die();
?>
<div class="modal fade registration" id="regid" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Регистрация</h4>
                </div>
                <div class="modal-body">
                    <form id="regform" method="get" action="index.php">
                        <div class="form-group">
                            <label for="reg_firstname_id">Имя</label>
                            <input name="firstname" type="text" class="form-control" id="reg_firstname_id" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="reg_lastname_id">Фамилия</label>
                            <input name="lastname" type="text" class="form-control" id="reg_lastname_id" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="reg_email_id">Email</label>
                            <input name="email" type="email" class="form-control" id="reg_email_id" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="reg_password_id">Пароль</label>
                            <input name="password" type="password" class="form-control" id="reg_password_id" placeholder="">
                        </div>      
                        <button id="sendbut" type="button" class="btn btn-primary">Зарегистрироваться</button>            
                    </form>
                </div>
            </div>
        </div>
    </div>