<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 12.07.2017
 * Time: 22:42
 */

//$time = $data['time'];
$transactions = $data['transactions'];
?>

<div class="admin-left-menu">
    <ul>
        <li>
            <a href="<?php echo getActionLink("users") ?>">Пользователи</a>
            <ul>
                <li><a href="<?php echo getActionLink("users") ?>">Пользователи</a></li>
                <?php if(User::can('edit_roles')): ?><li><a href="<?php echo getActionLink("roles") ?>">Роли</a></li><?php endif; ?>
            </ul>
        </li>
        <li><a href="<?php echo getActionLink("audiosessions") ?>">Аудиосеансы</a></li>
        <li><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li><?php endif; ?>
        <li class="active"><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>



<div class="admin-content">

    <!--      breadcrumbs        -->
    <div class="admin-breadcrumbs">
        <a class="active" href="">Финансы</a>
    </div>
    <!--      breadcrumbs        /-->

    <h2>Финансы</h2>
    <div class="conteiner">
    <div class="row">
	<div class="admin-buttons">
        <div class="col-md-5">
        <a class="btn btn-success" name="now_time" id="now_time" href="<?php echo getActionLink("finances", "getdatenow") ?>">
            Сегодня
        </a>
        <a class="btn btn-success" name="week_time" id="week_time" href="<?php echo getActionLink("finances", "getdateweek") ?>">
            Неделя
        </a>
		<a class="btn btn-success" name="month_time" id="month_time" href="<?php echo getActionLink("finances", "getdatemonth") ?>">
            Месяц
        </a>
        </div>
            <div class="col-md-7">
        <form action="<?php echo getActionLink("finances", "getdate") ?>" method="post">
            		 С <input type="text" name="start_time" id="start_time">
                     По <input type="text" name="end_time" id="end_time">
                    <button class="btn btn-primary" name="filter" id="filter" type="submit">
                        Показать
                    </button>
		</form>
            </div>
        </div>
    </div>
    </div>
    <!--<?php // echo $time ?> -->
    <div class="container finance-mar">

        <table class="admin-table ab-admin-table">
        <tr>
            <th>Дата оплаты</th>
            <th>Пользователь</th>
            <th>ID транзакции</th>
            <th>Сумма оплаты, руб.</th>
            <th>Выручка сайта, руб.</th>
        </tr>
            <?php
             foreach($transactions as $transaction): ?>
                <tr>
                    <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['date'].' '.$transaction['time'] ?></a></td>
                    <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['firstname'].' '.$transaction['lastname'] ?></a></td>
                    <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['id'] ?></a></td>
                    <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['summ'] ?></a></td>
                    <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['profit'] ?></a></td>
                </tr>

            <?php endforeach; ?>
        </table>
    </div>


</div>