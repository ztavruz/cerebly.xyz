<?php

$question = $data['questions'];
$dialog = $data['dialog'];
$user = $data['users'];
?>


<div class="row">
    <div class="col-md-4">
        <div class="white-block">
        ...
        </div>
    </div>
    <div class="col-md-8">
        <div class="white-block">
            <div class="dialog">

                <div class="question well">
                    <?= $question->content ?>
                </div>
                <?php foreach($dialog as $message ): ?>
                    <div class="col-sm-10 alert  <?= $message['owner_id'] != $user->id ? 'alert-warning col-sm-offset-2' : 'alert-info' ?>">
                        <?= $message['content'] ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="message" id="message" cols="30" rows="3" placeholder="сообщение"></textarea>
            </div>
            <div class="form-group">
                <button id="send-message" class="form-control"  type="button">Отправить сообщение</button>
            </div>
        </div>
    </div>
</div>

<?php
$qID = $question->id;
$urlToMessage = getActionLink('support', 'message' );
$urlToRefresh = getActionLink('support', 'update' );
$current_datetime = date_create()->format('Y.m.d H:i:s');
$script = <<< JS
var lastUpdate = '$current_datetime';
var soundtick = new Audio();
soundtick.src = '/media/sounds/123.mp3';
$('#send-message').click(function(){
        var textfield = $('#message');
        var content = textfield.val();
        textfield.val('');
        textfield.focus();
        var id = $('.dialog').attr('question-id');

        $.post('$urlToMessage', { id: $qID, content: content, last_update: lastUpdate }, function(data){
            if(data.ok) {
                var elem = $('<div class="col-sm-10 alert alert-info new"></div>');
                $(elem).html(data.content);
                $('.dialog').append(elem);
                soundtick.play();
                soundtick = new Audio();
                soundtick.src = '/media/sounds/123.mp3';
            }
            else {
                alert(data.message);
            }
        }, 'json');
    });
    
    

    setInterval(function(){
        $.post('$urlToRefresh', { id: $qID, last_update: lastUpdate }, function(data){
            if(data.ok)
            {
                $('.dialog.new').remove();
                $('.dialog').append(data.content);
                if(data.hasNew)
                {
                    soundtick.play();
                    soundtick = new Audio();
                    soundtick.src = '/media/sounds/123.mp3';    
                }
                lastUpdate = data.update_time;
            }
            else
            {
                alert(data.message);
            }
        }, 'json');
    }, 3000);
    
    
    
    
JS;

Document::registerJS($script, 'chat');
