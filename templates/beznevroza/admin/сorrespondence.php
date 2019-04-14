<?php

$questions = $data['questions'];

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
        <li><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li class="active"><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>

<div class="admin-content">
  <div class="container" style="margin-left: 100px;">
    <div class="row">
    <?php foreach ($questions as $key){ ?> 
        <div class="col-md-7" >
            <div class="question-block pull-left">
                             
                                <?php  echo '<strong>'.$key['firstname'].' '.$key['lastname'].':</strong> '.$key['content']; ?>       
            </div>
        </div>
        <div class="col-md-7">
            <div class="answer-block pull-right" >

                                 <?php echo '<strong>Вы:</strong> '.' '.$key['answer'];?> 
                                      
            </div>
        </div>
        <?php } ?>   
    </div>
  </div>
</div>