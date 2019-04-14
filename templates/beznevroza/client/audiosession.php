<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 26.02.2017
 * Time: 12:18
 */

echo $data['card'];

?>

	<div class="buttons_tab abonements-block">
  <ul class="nav nav-tabs" id="audiosession_tabs" role="tablist">
    <li class="active"><a class="btn" href="#content" aria-controls="content" role="tab" data-toggle="tab">Описание</a></li>
    <li class=""><a class="btn" href="#price" aria-controls="price" role="tab" data-toggle="tab">Расчет стоимости</a></li>
    <li class=""><a class="btn" href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Отзывы</a></li>
	<li class=""><a class="btn" href="#questionanswer" aria-controls="questionanswer" role="tab" data-toggle="tab">Вопрос-ответ</a></li>
  </ul>
  </div>
	<div class="tab-content">
	  <div class="tab-pane active" id="content">
	  <?php
	   foreach ($data['audiosessions'] as $key ) {
	   	echo $key['full_description'];
	  	}; 
		?>
		</div>
	  <div class="tab-pane" id="price">
	  <?php
		echo $data['price-table']; 
		?>
		</div>
	  <div class="tab-pane" id="messages">
	  <?php
	  echo $data['comments'];
	  ?>
	  </div>
	  <div class="tab-pane" id="questionanswer">
	  <?php 
	  echo $data['questionanswer'];
	  ?>
	  </div>
	  </div>

		<?php 

		if(Abonement::userCanCreateAbonement()): ?>
				<a href="<?php echo getActionLink("abonements", "create") ?>" class="btn btn-primary create-abonement-button">
				    Сформировать абонемент
				</a>
		<?php endif; ?>
