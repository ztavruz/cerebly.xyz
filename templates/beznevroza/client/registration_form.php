<?php
?>
        <h2 class="regform-header">Регистрация</h2>
        <div class="regform-wrapper">
            <form action="<?php echo getActionLink("registration") ?>" method="post" class="regform uploadVK">
                <?php if($data->validation_errors['title_message']): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="title-message">
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $data->validation_errors['title_message'] ?>
                            </div>

                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row" style="padding-top: 10px">
                    <div class="col-xs-12">
                     <span class="error">Поля обозначенные знаком (*) являются обязательными!</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="email"><a style="color: red">*</a>E-mail адрес</label>
                        <?php if($data->validationError('email')): ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $data->validationError('email') ?>
                            </div>
                        <?php endif; ?>
                        <input type="text" name="email" placeholder="E-mail" value="<?php echo $data->getField('email') ?>"> </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="phone"><a style="color: red">*</a>Телефон</label>
                        <?php if($data->validationError('phone')): ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $data->validationError('phone') ?>
                            </div>
                        <?php endif; ?>
                        <input type="text" name="phone" placeholder="Телефон" class="phone" value="<?php echo $data->getField('phone') ?>"> </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="password"><a style="color: red">*</a>Пароль</label>
                        <?php if($data->validationError('password')): ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $data->validationError('password') ?>
                            </div>
                        <?php endif; ?>
                        <input type="password" name="password" placeholder="Пароль"> </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="confirm"><a style="color: red">*</a>Подтвердите пароль</label>
                        <?php if($data->validationError('confirm')): ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $data->validationError('confirm') ?>
                            </div>
                        <?php endif; ?>
                        <input type="password" name="confirm" placeholder="Подтвердите пароль" value=""> </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="lastname"><a style="color: red">*</a>Фамилия</label>
                        <?php if($data->validationError('lastname')): ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $data->validationError('lastname') ?>
                            </div>
                        <?php endif; ?>
                        <input type="text" name="lastname" placeholder="Фамилия" value="<?php echo $data->getField('lastname') ?>">
                        </div>
                        
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="firstname"><a style="color: red">*</a>Имя</label>
                        <?php if($data->validationError('firstname')): ?>
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $data->validationError('firstname') ?>
                            </div>
                        <?php endif; ?>
                        <input type="text" name="firstname" placeholder="Имя" value="<?php echo $data->getField('firstname') ?>"> </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="patronymic"><a style="color: red">*</a>Отчество</label>
                        <span class="error"><?php echo $data->validationError('patronymic') ?></span>
                        <input type="text" name="patronymic" placeholder="Отчество" value="<?php echo $data->getField('patronymic') ?>"> </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                <label for=""><a style="color: red">*</a>Дата рождения</label> </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-4">
                        <select name="year" id="">
                            <option value="0" selected>Не указано</option>
                            <?php for($i = 1900; $i < 2015; $i++){
                                echo "<option value=\"$i\" >$i</option>";
                            }?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select name="mounth" id="">
                            <option value="0" selected>Не указано</option>
                            <option value="1">Январь</option>
                            <option value="2">Февраль</option>
                            <option value="3">Март</option>
                            <option value="4">Апрель</option>
                            <option value="5">Май</option>
                            <option value="6">Июнь</option>
                            <option value="7">Июль</option>
                            <option value="8">Август</option>
                            <option value="9">Сентябрь</option>
                            <option value="10">Октябрь</option>
                            <option value="11">Ноябрь</option>
                            <option value="12">Декабрь</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select name="day" id="">
                            <option value="0" selected>Не указано</option>
                            <?php for($i = 1; $i <= 31; $i++){
                                echo "<option value=\"$i\" >$i</option>";
                            }?>
                        </select>
                    </div>
                </div>
                <label for="gender"><a style="color: red">*</a>Пол</label>
                <input type="radio" id=men <?php if(!$data->getField('gender')) echo "checked" ?> value="0" name="gender"><label for="men">Мужской</label>
                <input type="radio" id=women value="1" name="gender" <?php if($data->getField('gender')) echo "checked" ?>><label for="women">Женский</label>
                <label for="address"><a style="color: red">*</a>Адрес проживания</label>
                <div class="row">
                    <div class="col-sm-12">
                        <select name="country">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <select name="region">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <select name="city">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="text" name="street" placeholder="Улица" value="<?php echo $data->getField('street') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <input type="text" name="building" placeholder="Дом" value="<?php echo $data->getField('building') ?>">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="apartment" placeholder="Квартира" value="<?php echo $data->getField('apartment') ?>">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="zipcode" placeholder="Индекс" value="<?php echo $data->getField('zip') ?>">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <label for="skype"><a style="color: red">*</a>Skype</label>
                        <input type="text" name="skype" placeholder="Skype" value="<?php echo $data->getField('skype') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="submit" value="Зарегистрироваться" class="btn btn-primary btn-reg"> 
                    </div>
                </div>
            </form>
        </div>
