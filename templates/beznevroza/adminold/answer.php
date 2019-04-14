<?php

$question = $data['questions'];
$id_q = $data['id_q'];

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

            <!--      breadcrumbs        -->
            <div class="admin-breadcrumbs">
                <a href="<?php echo getActionLink("support") ?>">Техподдержка</a> / <a class="active" href="">Ответить</a>
            </div>
            <!--      breadcrumbs        /-->

    <h2>Ответить</h2>

<div class="row">
    <div class="col-md-4">
        <div class="white-block">
                         <?php foreach ($question as $key){
                              echo $key['firstname'].' '.$key['lastname'];
                              }?>       
        </div>
		<div>
                         <a class="btn btn-primary" href="<?php echo getActionLink("questions","сorrespondence",array("id" => $id_q)) ?>">Показать переписку</a>  
        </div>
    </div>
	
    <form action="<?php echo getActionLink("questions","answer", array("id" => $id_q)) ?>" method="post" class="answerform" >
        <div class="col-md-8">
            <div class="white-block">
                <div class="dialog">
                    Вопрос: 
                    <div class="question well">
                        <?php foreach ($question as $key){
                              echo $key['content'];     
                            }?>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="message" id="message" cols="30" rows="3" placeholder="Сообщение"></textarea>
                </div>
                <div class="form-group">
                    <button id="send-message" class="form-control"  type="submit">Отправить сообщение</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

<?php

?>