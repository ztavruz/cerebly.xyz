<?php
echo getIntervalsModalWindow();
?>




<div class="modal fade select-audiosession-window" id="select_wind_id" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Выбрать аудиосеанс</h4>
            </div>
            <div class="modal-body">
                <ul>
                    <li onclick="selectDetails()"><img src="../assets/img/blue-box.png" alt=""><span>Терапевтический Аудио сеанс избавления от навязчивых мыслей</span></li>
                    <li onclick="selectDetails()"><img src="../assets/img/blue-box.png" alt=""><span>Терапевтический Аудио сеанс избавления от навязчивых мыслей</span></li>
                    <li onclick="selectDetails()"><img src="../assets/img/blue-box.png" alt=""><span>Терапевтический Аудио сеанс избавления от навязчивых мыслей</span></li>
                    <li onclick="selectDetails()"><img src="../assets/img/blue-box.png" alt=""><span>Терапевтический Аудио сеанс избавления от навязчивых мыслей</span></li>
                    <li onclick="selectDetails()"><img src="../assets/img/blue-box.png" alt=""><span>Терапевтический Аудио сеанс избавления от навязчивых мыслей</span></li>
                    <li onclick="selectDetails()"><img src="../assets/img/blue-box.png" alt=""><span>Терапевтический Аудио сеанс избавления от навязчивых мыслей</span></li>
                    <li onclick="selectDetails()"><img src="../assets/img/blue-box.png" alt=""><span>Терапевтический Аудио сеанс избавления от навязчивых мыслей</span></li>
                    <li onclick="selectDetails()"><img src="../assets/img/blue-box.png" alt=""><span>Терапевтический Аудио сеанс избавления от навязчивых мыслей</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade confirm-window" id="confirm_window">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Выбрать аудиосеанс</h4>
            </div>
            <div class="modal-body clearfix"></div>
        </div>
    </div>
</div>

<div class="modal fade confirm-window-simple" id="confirm_window_simple">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Вы уверены что хотите удалить сеанс?</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="buttons clearfix">
                    <a href="" class="btn btn-primary">Удалить</a>
                    <a href="" class="btn btn-success">Отмена</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade confirm-block-window" id="confirm_block_window">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Блокировать</h4>
            </div>
            <div class="modal-body clearfix">

                <div class="forms">
                    <div class="form-group">
                        <label class="control-label">С </label>
                        <input type="date"  class="form-control" >
                    </div>
                    <div class="form-group">
                        <label class="control-label">По </label>
                        <input type="date"  class="form-control">
                    </div>
                </div>

                <div class="buttons clearfix">
                    <a href="" class="btn btn-primary">Да</a>
                    <a href="" class="btn btn-success">Отмена</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade confirm-pay-window" id="confirm_pay_window">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Абонемент</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade block-window" id="block_window">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Блокировка</h4>
            </div>
            <div class="modal-body clearfix">
                <table class="admin-table">
                    <tr>
                        <th colspan="3">Пользователи</th>
                    </tr>
                    <tr>
                        <td>Добавление пользователей</td>
                        <td>
                            <span>Закончится:<br>20.09.2017 в 19:00</span>
                            <!--
                                                                <select name="add_user" class="form-control">
                                                                    <option value="0" selected>нет блокировки</option>
                                                                    <option value="1">2 дн.</option>
                                                                    <option value="1">3 дн.</option>
                                                                </select>
                            -->
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Удаление пользователей</td>
                        <td>
                            <select name="delete_user" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>Редактировать данные пользователя</td>
                        <td>
                            <select name="edit_user" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>


                    <tr>
                        <td>Просматривать данные пользователя</td>
                        <td>
                            <select name="view_user_data" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>


                    <tr>
                        <td>Блокировки пользователей</td>
                        <td>
                            <select name="block_user" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">Комментарии</th>
                    </tr>

                    <tr>
                        <td>Добавление комментариев</td>
                        <td>
                            <select name="add_comments" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>


                    <tr>
                        <td>Удаление комментариев</td>
                        <td>
                            <select name="delete_comments" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>


                    <tr>
                        <td>Одобрять комментарии</td>
                        <td>
                            <select name="review_comments" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">Аудиосеансы</th>
                    </tr>

                    <tr>
                        <td>Добавление аудиосеансов</td>
                        <td>
                            <select name="add_audiosessions" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>


                    <tr>
                        <td>Удаление аудиосеансов</td>
                        <td>
                            <select name="delete_audiosessions" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>


                    <tr>
                        <td>Редактирование аудиосеансов</td>
                        <td>
                            <select name="edit_audiosessions" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>Публикация аудиосеансов</td>
                        <td>
                            <select name="publish_audiosessions" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>Просмотр статистики аудиосеансов</td>
                        <td>
                            <select name="review_statistics" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">Абонементы</th>
                    </tr>
                    <tr>
                        <td>Редактирование абонементов</td>
                        <td>
                            <select name="edit_abonements" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>Удаление абонементов</td>
                        <td>
                            <select name="delete_abonements" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>Блокировка абонементов</td>
                        <td>
                            <select name="block_abonements" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>Просмотр истории изменений абонементов</td>
                        <td>
                            <select name="review_history" class="form-control">
                                <option value="1" selected>1 дн.</option>
                                <option value="1">2 дн.</option>
                                <option value="1">3 дн.</option>
                            </select>
                        </td>
                        <td>
                            <div class="delete-block-btn"></div>
                        </td>
                    </tr>

                </table>
                <div class="btn btn-primary" onclick="sendBlockForm()">Сохранить</div>
            </div>
        </div>
    </div>
</div>


<?php echo $data['price-table'] ?>

<div class="instructions-block">

    <h3>Инструкция по формированию абонемента</h3>
    <p>Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке, а начинающему оратору отточить навык публичных выступлений в домашних условиях. При создании генератора мы использовали небезизвестный универсальный код речей. Текст генерируется абзацами случайным образом от двух до десяти предложений в абзаце, что позволяет сделать текст более привлекательным и живым для визуально-слухового восприятия.</p>



</div>

<div class="abonement-create-block clearfix">

    <form id="create-abonement-form" action="<?php echo getActionLink("abonements","createnew") ?>" method="post">
    <div class="audiosession-settings">


        <select id="id_duration" name="duration" class="form-control duration">
            <option value="0" selected>Срок абонемента</option>
            <option value="1">6 месяцев</option>
            <option value="2">3 месяца</option>
            <option value="3">1 месяц</option>
            <option value="4">3 недели</option>
            <option value="5">2 недели</option>
            <option value="6">1 неделя</option>
        </select>

        <select id="id_times" name="times" class="form-control times" disabled>
            <option value="0">Кол-во сеансов</option>
            <option value="1">1 сеанс</option>
            <option value="2">2 сеанса</option>
            <option value="3">3 сеанса</option>
        </select>

        <div class="buttons-intervals">
        </div>
    </div>

    <div class="plan-list">
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
        <div class="audiosession-field empty-field disabled-field clearfix" onclick="getSessionsList(this)">
            <input type="hidden" name="listenplan[]" value="0">
            <div class="checked-lamp"></div>
            <div class="delete-lamp">×</div>
            <div class="audiosession-image">
                <img src="../assets/img/blue-box.png" alt="">
            </div>
            <div class="audiosession-name">Нажмите для добавления сеанса в очередь</div>
        </div>
    </form>

    </div>











</div>
<button class="btn btn-primary create-abonement-button" onclick="createAbonement()" disabled>
    Сформировать абонемент
</button>
