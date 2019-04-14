<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="modal-header">
            
                    <h4 class="modal-title">К ОПЛАТЕ</h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                          <p id="price"><?php echo $data; ?></p>
                          <button type="button" class="btn btn-primary edit" onclick="$('#pricemodal').modal('hide');">Редактировать</button>&nbsp;&nbsp;<button type="button" class="btn btn-primary" onclick="pay()">Оплатить</button>

                    </form>
                </div>