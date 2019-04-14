<?php

?>
<div class="modal fade select-interval" id="select-interval-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Выберите интервал</h4>
            </div>
            <div class="modal-body clearfix">
                <form name="interval-select-form">
                    <input type="hidden" name="invoker">
                    <ul class="intervals-list">
                        <?php
                        for($start_time = 6, $end_time = 9, $counter = 1; $counter <= 24; $counter++ ) {
                            $id = "n$counter";
                            echo "<li><input id=\"$id\" name='interval' type=\"radio\" value='$start_time'><label for=\"$id\">$start_time:00 - $end_time:00</label></li>";
                            $start_time++;
                            $end_time++;
                            if ($start_time >= 24) $start_time = 0;
                            if ($end_time >= 24) $end_time = 0;
                        }
                        ?>
                    </ul>
                    <div class="buttons clearfix">
                        <button type="button" id="select-interval-btn" class="btn btn-primary">Выбрать</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal">Отмена</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
