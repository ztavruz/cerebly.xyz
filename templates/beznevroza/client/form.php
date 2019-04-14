<?php
// Запрещает запуск скрипта напрямую в обход index.php
defined('APPRUNNING') or die();
?>
<form id="paymentform" class="payment">
    <input type="hidden" name="asid" value="<?php echo $data['asid'] ?>">
            <div class="clearfix">
               <div class="duration">
                    <label>Длительность абонемента:</label>
                    <select name="duration" id="duration">
                        <option value="1" selected>1 неделя</option>
                        <option value="2">2 недели</option>
                        <option value="3">3 недели</option>
                        <option value="4">1 месяц</option>
                        <option value="5">3 месяца</option>
                        <option value="6">6 месяцев</option>
                    </select>
                </div>
                <div class="times">
                    <label>Кол-во раз:</label>
                    <select name="times" id="times">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            
            
                <div class="intervals-wrapper">
                    <label>Временные интервалы: <sub>Вы можете выбрать от 1 до 3</sub></label>
                    <div class="intervals">
                        <select name="interval1" id="interval1">
                            <option value="1" selected>6:00-9:00</option>
                            <option value="2" >7:00-10:00</option>
                            <option value="3" >8:00-11:00</option>
                            <option value="4" >9:00-12:00</option>
                            <option value="5" >10:00-13:00</option>
                            <option value="6" >11:00-14:00</option>
                            <option value="7" >12:00-15:00</option>
                            <option value="8" >13:00-16:00</option>
                            <option value="9" >14:00-17:00</option>
                            <option value="10" >15:00-18:00</option>
                            <option value="11" >16:00-19:00</option>
                            <option value="12" >17:00-20:00</option>
                            <option value="13" >18:00-21:00</option>
                            <option value="14" >19:00-22:00</option>
                            <option value="15" >20:00-23:00</option>
                            <option value="16" >21:00-0:00</option>
                            <option value="17" >22:00-1:00</option>
                            <option value="18" >23:00-2:00</option>
                            <option value="19" >0:00-3:00</option>
                            <option value="20" >1:00-4:00</option>
                            <option value="21" >2:00-5:00</option>
                            <option value="22" >3:00-6:00</option>
                            <option value="23" >4:00-7:00</option>
                            <option value="24" >5:00-8:00</option>
                        </select>
                        <select name="interval2" id="interval2">
                            <option value="0" selected>Не выбрано</option>
                            <option value="1" >6:00-9:00</option>
                            <option value="2" >7:00-10:00</option>
                            <option value="3" >8:00-11:00</option>
                            <option value="4" >9:00-12:00</option>
                            <option value="5" >10:00-13:00</option>
                            <option value="6" >11:00-14:00</option>
                            <option value="7" >12:00-15:00</option>
                            <option value="8" >13:00-16:00</option>
                            <option value="9" >14:00-17:00</option>
                            <option value="10" >15:00-18:00</option>
                            <option value="11" >16:00-19:00</option>
                            <option value="12" >17:00-20:00</option>
                            <option value="13" >18:00-21:00</option>
                            <option value="14" >19:00-22:00</option>
                            <option value="15" >20:00-23:00</option>
                            <option value="16" >21:00-0:00</option>
                            <option value="17" >22:00-1:00</option>
                            <option value="18" >23:00-2:00</option>
                            <option value="19" >0:00-3:00</option>
                            <option value="20" >1:00-4:00</option>
                            <option value="21" >2:00-5:00</option>
                            <option value="22" >3:00-6:00</option>
                            <option value="23" >4:00-7:00</option>
                            <option value="24" >5:00-8:00</option>
                        </select><select name="interval3" id="interval3">
                            <option value="0" selected>Не выбрано</option>
                            <option value="1" >6:00-9:00</option>
                            <option value="2" >7:00-10:00</option>
                            <option value="3" >8:00-11:00</option>
                            <option value="4" >9:00-12:00</option>
                            <option value="5" >10:00-13:00</option>
                            <option value="6" >11:00-14:00</option>
                            <option value="7" >12:00-15:00</option>
                            <option value="8" >13:00-16:00</option>
                            <option value="9" >14:00-17:00</option>
                            <option value="10" >15:00-18:00</option>
                            <option value="11" >16:00-19:00</option>
                            <option value="12" >17:00-20:00</option>
                            <option value="13" >18:00-21:00</option>
                            <option value="14" >19:00-22:00</option>
                            <option value="15" >20:00-23:00</option>
                            <option value="16" >21:00-0:00</option>
                            <option value="17" >22:00-1:00</option>
                            <option value="18" >23:00-2:00</option>
                            <option value="19" >0:00-3:00</option>
                            <option value="20" >1:00-4:00</option>
                            <option value="21" >2:00-5:00</option>
                            <option value="22" >3:00-6:00</option>
                            <option value="23" >4:00-7:00</option>
                            <option value="24" >5:00-8:00</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <a href="" id="calculate" class="btn btn-primary morelink">Подсчитать стоимость</a>
                <input name="code" type="text" placeholder="Cкидочный код">
            </div>
            
        </form>
