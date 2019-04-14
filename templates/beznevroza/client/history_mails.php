<?php

$questions = $data['questions'];

?>

<div class="conteiner client-dialog-margin">
<div class="row">
<?php if (empty($questions)) {
    echo "<div class='psevdo-centered'> <div class='fail-comment'> <h3> У вас нет сообщений. </h3> </div> </div>";
} else {?>
<?php
 foreach ($questions as $key){ ?> 
    <div class="col-xs-12" >
        <div class="question-block pull-left">
                         
                            <?php  echo '<strong>Вы:</strong> '.$key['content']; ?>       
        </div>
    </div>
    <div class="col-xs-12">
        <div class="answer-block pull-right" >

                             <?php echo '<strong>Администратор:</strong> '.' '.$key['answer'];?> 
                                  
        </div>
    </div>
     <?php }
     } ?>   

</div>
</div>