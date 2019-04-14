<?php
// Запрещает запуск скрипта напрямую в обход index.php
defined('APPRUNNING') or die();
?>
    <div class="modal fade logon" id="logonid" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Вход</h4>
                </div>
                <div class="modal-body">
                    <form id="logonform" action="index.php" method="post">
                        <div class="form-group">
                            <label for="login_email_id">Email</label>
                            <input name="email" type="email" class="form-control" id="login_email_id" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="login_password_id">Пароль</label>
                            <input name="password" type="password" class="form-control" id="login_password_id" placeholder="">
                        </div>      
                        <button id="logonbut" type="button" class="btn btn-primary">Войти</button>            
                    </form>
                </div>
            </div>
        </div>
    </div>