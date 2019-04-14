<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 13.07.2017
 * Time: 15:28
 */
/*
$questions = $data['questions'];
$dialog = $data['dialog'];

/*

   <form class="form" action="<?= getActionLink('support', 'ask') ?>" method="post">
    <div class="white-block">
    <div class="form-group">
        <label for="send-question">Категория вопроса</label>
        <select name="category">
            <option value="0" selected>Выберите категорию вопроса</option>
			<?php foreach($data['categories'] as $q_category): ?>
            <option value="<?= $q_category['id'] ?>"><?= $q_category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="send-question">Текст вопроса:</label>
        <textarea name="content" class="form-control" placeholder="текст вопроса"></textarea>
    </div>
    <div class="form-group">
        <input class="form-control" color="green" type="submit" value="Отправить">
    </div>
    </div>
</form>
*/
?>
<div class="psevdo-centered">
<div class="conteiner">
<div class="row">
<h2> Возможно вы не выбрали категорию вопроса или его не ввели. </h2>
<h2> Извините, попробуйте задать вопрос позже. </h2>
</div>
</div>
</div>