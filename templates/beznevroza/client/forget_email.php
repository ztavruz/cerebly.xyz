<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 26.02.2017
 * Time: 18:46
 */
?>



<div class="psevdo-centered restore-password">
    <div>
        <div>
            <?php if(isset($data['restore-password'])){
                    if(isset($data['password-changed-success'])){  ?>

                <div>Пароль изменен</div>

                <?php } else { ?>
                <form action="<?php echo getActionLink("registration", "restorepassword"); ?>" method="post">

                    <?php if(isset($data['errors']['password'])): ?>
                    <div class="form-group">
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                    <?php echo $data['errors']['password']?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="">Введите новый пароль:</label>
                    </div>
                    <div class="form-group">
                        <input id="password-id" class="form-control" type="password" name="password">
                    </div>
                    <div class="form-group"><input id="confirm-id" class="form-control" type="password" name="confirm_password"></div>
                    <div class="form-group"><button type="submit" class="btn btn-primary btn-resultscreen">Сохранить пароль</button></div>

                </form>
                <?php } ?>

            <?php } elseif(isset($data['email-sended'])){ ?>
                <div class="form-group">Письмо для восстановления пароля отправлено на вашу почту.</div>
            <?php } else { ?>
            <form action="<?php echo getActionLink("registration", "remind"); ?>" method="post">


                <div class="form-group">
                    <?php if(isset($data['wrong-email'])) echo "Такой email не зарегистрирован"; ?>
                </div>
                <div class="form-group">
                    <label for="email-id">Введите email указанный при регистрации</label>
                </div> <div class="form-group">
                        <input id="email-id" class="form-control" type="email" name="email">
                </div>
                <div class="form-group"><button type="submit" class="btn btn-primary btn-resultscreen">Напомнить пароль</button></div>

            </form>
            <?php } ?>
            <a href="index.php" class="btn btn-primary btn-resultscreen">На главную</a>
        </div>
    </div>
</div>



