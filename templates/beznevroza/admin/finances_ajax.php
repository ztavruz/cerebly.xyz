<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 12.07.2017
 * Time: 22:42
 */
   
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
	<div class="admin-buttons">
      <div class="conteiner">
        <div class="col-md-5">
        <a class="btn btn-success" href="">
            Сегодня
        </a>
        <a class="btn btn-success" href="">
            Неделя
        </a>
		<a class="btn btn-success" href="">
            Месяц
        </a>
        </div>
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

<table class="admin-table ab-admin-table">
<tr>
    <td>Дата оплаты</td>
    <td>Пользователь (ФИО)</td>
    <td>ID транзакции</td>
    <td>Сумма оплаты, руб.</td>
    <td>Выручка сайта, руб.</td>
</tr>
    <?php
    $transactions = $data['transactions'];
    $user= $data['users'];
     foreach($transactions as $transaction): ?>
        <tr>
            <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['date'] ?></a></td>
            <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $user->firstname.' '.$user->lastname ?></a></td>
            <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['id'] ?></a></td>
            <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['summ'] ?></a></td>
            <td><a href="<?= getActionLink('finances', 'view') ?>"><?php echo $transaction['profit'] ?></a></td>
        </tr>

    <?php endforeach; ?>
</table>



</div>