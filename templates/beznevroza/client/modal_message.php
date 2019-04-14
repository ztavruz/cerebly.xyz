<?php
// Запрещает запуск скрипта напрямую в обход index.php
defined('APPRUNNING') or die('');
?>
    <div class="modal fade pay" id="messagemodal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $data ?></h4>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-primary edit" onclick="$('#messagemodal').modal('hide');">Ок</button>
                </div>
            </div>
        </div>
    </div>
