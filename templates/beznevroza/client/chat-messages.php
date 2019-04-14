<?php
/**
 * Created by PhpStorm.
 * User: hust
 * Date: 13.07.2017
 * Time: 23:22
 */

?>
<?php foreach($data['messages'] as $message ): ?>
    <div class="col-sm-10 alert  <?= $message['owner_id'] != $user->id ? 'alert-warning col-sm-offset-2' : 'alert-info' ?>">
        <?= $message['content'] ?>
    </div>
<?php endforeach; ?>
