function deleteWindow(id) {
    $('#deleteid').val(id);
    $('#confirm_window_simple').modal();
}

function sendBlockForm(){
    var formData = $('#blockform').serialize();
    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=saveblocks',
        data: formData,
        success: function(data) {
            var dataObj = JSON.parse(data);
            if(dataObj.error == false){
                $('#block_window').modal('hide');
                //window.location.reload(true);
            }
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
}

function blockWindow(id){

    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=getblocks&id='+id,
        data: "",
        success: function(data) {
            var dataObj = JSON.parse(data);
            if(dataObj['error'] == false){
                var content = dataObj['content'];
                $('#modal-body-content').html(content);
                $('#block_window').modal();
            } else {
                alert('Возникла ошибка: ' + dataObj['content']);
            }
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });


}


function deleteblock(element, name){
    var el = $('select[name='+name+']');
    if(!el.length)
        el = $('input[name='+name+']');
    if(!el.length) return;

    var parent_td = el.closest('td');
    var element_td = $(element).closest('td').html('');

    parent_td.html(getBlockSelectHTML(name));
}

function getBlockSelectHTML(name){
    return "<select name=\""+ name +"\" class=\"form-control\">" +
        "<option value=\"0\" selected>нет блокировки</option>" +
        "<option value=\"1\">1 дн.</option>" +
        "<option value=\"2\">1 нед.</option>" +
        "<option value=\"3\">1 мес.</option>" +
        "<option value=\"4\">3 дн.</option>" +
        "<option value=\"5\">6 дн.</option>" +
        "<option value=\"6\">навсегда</option>" +
        "</select>";
}

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
// Страница добавления сессии
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////

function preview(){
    var preview = document.querySelector('#preview_img');
    var file1    = document.querySelector('#uploadimage1').files[0];
    var file2    = document.querySelector('#uploadimage2').files[0];
    var file3    = document.querySelector('#uploadimage3').files[0];
    var file4    = document.querySelector('#uploadimage4').files[0];
    var reader1  = new FileReader();
    var reader2  = new FileReader();
    var reader3  = new FileReader();
    var reader4  = new FileReader();
    console.log("file1.name: "+file1.name);

    $('#image-url1, input[name=img]').val(file1.name);
    $('#image-url2, input[name=img]').val(file2.name);
    $('#image-url3, input[name=img]').val(file3.name);
    $('#image-url4, input[name=img]').val(file4.name);


    reader1.addEventListener("load", function () {
        preview.src = reader1.result;
    }, false);

    reader2.addEventListener("load", function () {
        preview.src = reader2.result;
    }, false);

    reader3.addEventListener("load", function () {
        preview.src = reader3.result;
    }, false);

    reader4.addEventListener("load", function () {
        preview.src = reader4.result;
    }, false);

    if (file1) {
        reader1.readAsDataURL(file1);
    }
        if (file2) {
        reader2.readAsDataURL(file2);
    }

        if (file3) {
        reader3.readAsDataURL(file3);
    }

        if (file4) {
        reader4.readAsDataURL(file4);
    }
}

function changesession(){
    var file    = document.querySelector('#uploadfile').files[0];
    $('#uploadfilename').val(file.name);
}


function drugAndDropAvalible(){
    var div = document.createElement('div');
    return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
}

$(window).on('load', function(){

    if(drugAndDropAvalible()  && $('#dropblock').length){

        $('.can_drug').css('display', "block");

        dropbox = $('#dropblock');

        dropbox.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
        }).on('dragover dragenter', function() {
            dropbox.addClass('dragover-style');
        }).on('dragleave dragend drop', function() {
            dropbox.removeClass('dragover-style');
        }).on('drop', function(e) {

            var droppedFile = e.originalEvent.dataTransfer.files[0];
            var reader  = new FileReader();
            $('#image-url').val(droppedFile.name);
            document.querySelector('#uploadfile').files[0] = null;
            $('#dropblock').get(0).droppedFile = droppedFile;

            reader.addEventListener("load", function () {
                var preview_img = document.querySelector("#preview_img");
                preview_img.src = reader.result;
            }, false);

            if (droppedFile) {
                reader.readAsDataURL(droppedFile);
            }

        });


        $('#audiosession-form').on('submit', function(e){

            // Отменяем автоматическую отправку
            e.preventDefault();

            var that = this;
            var $form = $(this);
            var file = document.querySelector('#uploadfile').files[0];
            var fileAudio = document.querySelector('#uploadfile').files[0];
            console.log("document.querySelector('#uploadfile'): "+document.querySelector('#uploadfile'));
            console.log("document.querySelector('#uploadfile').files[0]: "+document.querySelector('#uploadfile').files[0]);



            var errors = false;
            // Проверяем не пусто ли название сеанса
            if( $('input[name=caption]').val() == '' )
            {
                $('#caption-errorfield').html('Вы не указали название аудиосеанса').css('display', 'block');
                errors = true;
            } else {
                $('#caption-errorfield').css('display', 'none');
            }

            // Прверяем загружен ли файл сеанса
            if(file == undefined)
            {
                // Файл может быть уже загружен, если аудиосеанс редактируется а не создается
                // Если в uploadfilename есть название то файл уже загружен
                if($('input[name=uploadfilename]').val() == ''){
                    $('#uploadfile-errorfield').html('Вы не выбрали файл аудиосеанса').css('display', 'block');
                    errors = true;
                }
            } else {
                var filename = file.name;
                $('#uploadfile-errorfield').css('display', 'none');
            }

            // Если есть ошибки отменяем отправку
            if(errors) return;

            var sendForm = function(){
                var ajaxData = new FormData(that);
                ajaxData.delete('uploadfile');

                // При редактировании сеанса картинка уже загружена, ее url записан в input[name=img]
                // обновить картинку можно загрузив новый файл в input, либо перетащив файл мышью в браузер,
                // в этом случае она будет находится в     $('#dropblock').get(0).droppedFile
                // При сохраниении нам нужно только проверить есть ли файл в dropblock, и если есть заменить его в форме,
                // Если его там нет, он в форме уже, если файл вообще не указывали то ничего загружать не нужно.
                if(file = $('#dropblock').get(0).droppedFile)
                    ajaxData.append('uploadimage1','uploadimage2','uploadimage3','uploadimage4', file);
                else
                    if(!(file = document.querySelector('#uploadimage1').files[0]))
                    {
                        ajaxData.delete('uploadimage1');
                    }

                $.ajax({
                    url: 'index.php?c=audiosessions&act=save',
                    type: $form.attr('method'),
                    data: ajaxData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var dataObj = data;
                        if(dataObj.error === false){
                            $('#success-field').css('display', 'block');
                            $('#uploadfile-errorfield').css('display', 'none');
                            $('input[name=id]').val(dataObj.id);
                            setTimeout(function () {
                                // Включаем все кнопки
                                $('.admin-buttons-bottom [type=submit]').prop('disable', false).removeClass('disabled');
                                $('#image-url, [name=uploadfilename]').closest('.input-group').show();
                                $('.admin-buttons-bottom button, .admin-buttons-bottom a').show();
                                $('#upload_progress').hide();
                            }, 1000)


                        } else {
                            $('#success-field').css('display', 'none');
                            if(dataObj.errors.uploadfile){
                                $('#uploadfile-errorfield').css('display', 'block');
                            } else {
                                $('#uploadfile-errorfield').css('display', 'none');
                            }
                        }

                    },
                    error: function() {}
                });
            };

            // Если ошибок нет начинаем закачку файла, если его обновили, иначе пропускаем и сразу отсылаем форму
            if(file == undefined) {
                sendForm();
                return;
            }

            // Отключаем кнопку чтобы не нажали повторно
            $('.admin-buttons-bottom [type=submit]').prop('disable', true).addClass('disabled');
            $('#image-url, [name=uploadfilename]').closest('.input-group').hide();
            $('.admin-buttons-bottom button, .admin-buttons-bottom a').hide();

            // Начинаем закачку файла аудиосеанса

            // Узнаем какими частями делить файл
            var blockSize = $('input[name=blocksize]').val();
            blockSize = Number(blockSize);

            var fileParts = [];
            var currentBlock = 0;

            var offset = 0;
            var bytesCount = blockSize;
            var token = 0;

            for(var i = 0 ; (i * blockSize) < (file.size); i++)
            {
                if( ((i + 1) * blockSize) > file.size )
                    bytesCount = file.size - (i * blockSize);
                else
                    bytesCount = blockSize;

                console.log("Сейчас будеть file:");
                console.log(file);
                fileParts[i] = file.slice(offset, offset + bytesCount);
                offset += bytesCount;
                console.log("fileParts[i]");
                console.log(fileParts[i]);
            }

            // Настраеваем и показываем индикатор прогресса
            $('#upload_progress')
                .attr('min', 0)
                .attr('max', fileParts.length)
                .attr('value', 0)
                .css('display', 'inline-block');


            var loadNextPart = function(){
                console.log("Здесь должен выйти formData аудиозаписы:  "+formData);
                if(fileParts.length > currentBlock){
                    $('#upload_progress').attr('value', currentBlock);
                    var formData = new FormData();
                    formData.append('file', fileParts[currentBlock]);
                    formData.append('token', token);
                    console.log("Здесь должен выйти formData аудиозаписы:  "+formData);
                    $.ajax({
                        url: 'index.php?c=audiosessions&act=upload',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false
                    }).done(function(data){
                        data = JSON.parse(data);
                        if(data.error) alert(data.message);
                        else {
                            currentBlock++;
                            setTimeout(function(){
                                loadNextPart();
                            }, 100);
                        }
                    });
                }
                else
                {
                    $.post('index.php?c=audiosessions&act=upload', {session_end: 1}, function(data){
                        data = JSON.parse(data);
                        if(data.error) alert(data.message);
                        else {
                            $('#upload_progress').attr('value', $('#upload_progress').attr('max'));
                            $('input[name=uri]').val(filename);
                            sendForm();
                        }
                    });
                }
            };

            $.post('index.php?c=audiosessions&act=upload', {
                start_upload_session: 1,
                filename: file.name
            }).done(function(data){
                data = JSON.parse(data);
                if(data.error) alert(data.message);
                else{
                    token = data.token;
                    loadNextPart();
                }
            });

        })



    }

});

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////





function getSheduleButton(){
    var formdata = $('#sheduleform').serialize();
    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=shedule',
        data: formdata,
        success: function(data) {
            var dataObj = JSON.parse(data);
            $('#shedule-list').html(dataObj.content);
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });



}


function deleteRoleModal(id){
    $('input[name=id]').val(id);
    $('#delete_role_modal').modal('show');
}

$(window).on('load', function(){


    $('.delete-lamp').on('click', function(e) {
        e.stopPropagation();
        e.preventDefault();

        var active_elem = $(this).closest(".audiosession-field");
        $(active_elem).find('input[type=hidden]').val(0);
        $(active_elem).find('.audiosession-name').html("Нажмите для добавления сеанса в очередь");
        $(active_elem).addClass('empty-field');
        disableSubmitButton();
    });


    $('#sendbtn').on('click', function(e){
        sendLoginForm();
    });

    $('#logonid').on('shown.bs.modal', function (e){
        document.onkeydown = function (e) {
            e = e || window.event;
            if (e.keyCode === 13) {
                sendLoginForm();
            }
        }
    });

    $('#logonid').on('hide.bs.modal', function (e) {
        document.onkeydown = function(){};
    });


    if($(".phone").length)

    $('[data-toggle="datepicker"]').datepicker({
        language: 'ru-RU',
        format: 'dd.mm.yyyy'
    });


    // автодополнение полей адреса
    if($(".autocomplite").length){

        $(function(){

            var $region     = $('[name="region"]'),
                $city       = $('[name="city"]'),
                $street     = $('[name="street"]'),
                $building   = $('[name="building"]'),
                $zip        = $('[name="zipcode"]');

            $.kladr.setDefault({
                parentInput: '.autocomplite',
                verify: true,
                token: '58c29df87d11fd0f668b4568',
                select: function (obj) {
                    setLabel($(this), obj.type);
                },
                check: function (obj) {
                    var $input = $(this);

                    if (obj)
                        setLabel($input, obj.type);
                    else
                        showError($input, 'Введено неверно');
                },
                checkBefore: function () {
                    var $input = $(this);

                    if (!$.trim($input.val())) {
                        return false;
                    }
                }
            });

            $region.kladr('type', $.kladr.type.region);
            $city.kladr('type', $.kladr.type.city);
            $street.kladr('type', $.kladr.type.street);
            $building.kladr('type', $.kladr.type.building);
            $zip.kladrZip();

            function setLabel($input, text) {
                text = text.charAt(0).toUpperCase() + text.substr(1).toLowerCase();
                $input.parent().find('label').text(text);
            }

            function showError($input, message) {

            }
        });
    }

///////////////////////////////////////////////////////////////////////////
////////////////  Подгрузка адресов из ВК                 /////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////

    /*
    *
    * region
    * city
    * street
    * building
    *
    * */
    if($(".uploadVK").length){

        $('[name=city]').prop('disabled', true);
        $('[name=region]').prop('disabled', true);
        $('[name=country]').prop('disabled', true);
        $('[name=city]').get(0).needupload = 0;

        $.get('http://beznevrozanet.ru/service/api.php?act=country',function(data){
            var data =  JSON.parse(data);
            var response = data.response;
            var content = "<option value='0' checked>Выберите страну</option>";
            var checked = "";
            for(var i = 0; i < response.count; i++){
                if(response.items[i] != "undefined") {
                    content += "<option value='" + response.items[i].id + "' " + checked + ">" + response.items[i].title + "</option>";
                }
            }
            $('[name=country]').html(content);
            $('[name=country]').prop('disabled', false);
        });

        $('[name=country]').on('change', function(){
            $('[name=region]').html("");
            $('[name=city]').html("");
            var countryID = $(this).val();
            if(countryID == 0) {
                $('[name=city]').prop('disabled', true);
                $('[name=region]').prop('disabled', true);
                return;
            }
            $.get('http://beznevrozanet.ru/service/api.php?act=Regions&cid='+countryID,function(data) {
                var data = JSON.parse(data);
                var response = data.response;
                var content = "<option value='0' checked>Выберите регион</option>";
                for(var i = 0; i < response.length; i++){
                    content += "<option value='"+response[i].region_id+"'>"+response[i].title+"</option>";
                }
                $('[name=region]').html(content);
                $('[name=region]').prop('disabled', false);
                $('[name=city]').prop('disabled', false);
            });


        });

        $('[name=region]').on('change', function(){
            uploadcities();
        });


    }

///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////





///////////////////////////////////////////////////////////////////////////
////////////////// Загрузка картинки drug and Drop           //////////////
///////   на странице создания аудиосеанса              ///////////////////
///////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////
    // форма создания / редактирования сеанса
///////////////////////////////////////////////////////////////////////////

    $('.confirm-window').on('click', 'div.btn', function(){
        var id = $(this).attr('data-session');
        var elem = $('#confirm_window').get(0).targetAudiosessionListItem;
        $(elem).find('input[type=hidden]').val(id);

        var src = $('#confirm_window').find('img').attr("src");
        $(elem).find('img').attr("src", src);

        var name = $('#confirm_window').find('h3').html();
        $(elem).find('.audiosession-name').html(name);

        $(elem).removeClass('empty-field');
        $('#confirm_window').modal('hide');
        enableSubmitButton();
    } );

    /**
     * активирует поля аудиосессий
     */
    function enableAudiosessionFields(){
        var fields = $('.plan-list .audiosession-field');
        fields.removeClass('disabled-field');
    }

    /**
     * При изменении селекта 'продолжительность' если его значение 0 - отключаем селект 'кол-во прослушиваний', иначе включаем.
     */
    $('#id_duration').on('change', function(){
        var val = $('#id_duration').val();
        if(val != "0")
            enableTimesField();
        else
            disableTimesField();
    });

    /**
     * Включает селект 'продолжительность'
     */
    function enableTimesField(){
        $('#id_times').removeAttr("disabled");
    }

    /**
     * Отключает селект 'продолжительность'
     */
    function disableTimesField(){
        $('#id_times').attr("disabled", "disabled").find('option[value=0]').prop('selected', true);
        disableButtons();
    }

    /**
     * Отключает кнопки выбора интервалов
     */
    function disableButtons(){
        $('.buttons-intervals').html('');
        disableAudiosessionFields();
    }

    /**
     *  Отключает поля выбора аудиосеанса
     */
    function disableAudiosessionFields(){
        var fields = $('.plan-list .audiosession-field');
        fields.addClass('empty-field');
        fields.each(function(index){
            $(this).find('input[type=hidden]').val(0);
            $(this).find('.audiosession-name').html("Нажмите для добавления сеанса в очередь");
        });
        fields.addClass('disabled-field');
        disableSubmitButton();
    }

    /**
     * При изменении селекта 'продолжительность'
     */
    $('#id_times').on('change', function(){

        var val = $('#id_times').val();

        if(val == '0'){
            disableButtons();
        } else {
            disableButtons();
            enableButtons(val);
        }
    });

    /**
     * Нажатие на кнопку интервала
     */
    $(".buttons-intervals").on('click', 'div.btn' ,function(){

        var $button = $(this);
        var current_interval = $button.attr('data-container');
        var $wnd = $('#select-interval-modal');

        // включить все поля
        $wnd.find('input[type=radio]').removeAttr('disabled');

        // Пробегаем по всем кнопками и проверяем значение их атрибута data-container
        // если он установлен, то отключаем указанное в нем поле

        var $buttons = $('.buttons-intervals div.btn');
        for(var i=0; i< $buttons.length; i++){
            var data_container = $($buttons.get(i)).attr('data-container');
            if( (data_container !== "") && (data_container != current_interval) ){
                data_container = Number(data_container);
                var d,k;
                for(k=-2; k<3; k++){
                    d = data_container + k;
                    if( d <= 0) d = 24 + d;
                    if( d > 24 ) d = d - 24;
                    if(k < 3)
                        $wnd.find('input[value='+d+']').prop('disabled', true);
                    else
                        $wnd.find('input[value='+d+']').prop('checked',true);
                }
            }
        }

        // Чтобы знать в какую кнопку записать значения после закрытия окна, запишем в окно id кнопки
        $wnd.data('target', $button );

        // Можно показывать окно
        $wnd.modal('show');
    });

    /**
     * Срабатывает при выборе интервала в модальном окне
     */
    $('#select-interval-btn').on('click', function(){
        selectInterval();
    });


    /**
     * Включает кнопки интервалов
     *
     * @param times
     */
    function enableButtons(times){
        for(; times-- > 0;)
            $('.buttons-intervals')
                .append('<div class="btn btn-primary" data-container="" style="display: block">  <input name="interval[]" type="hidden" value="" ><span>выбрать время</span></div>');
    }

    function enableSubmitButton(){

        var flag = true;

        $(".buttons-intervals div.btn").each(function(){
            var interval = $(this).attr('data-container');
            if(interval === "")
                flag = false;
        });

        if(!flag) return;

        var fields = $('.plan-list .audiosession-field');
        for(i=0; i< fields.length; i++){
            if($(fields.get(i)).hasClass('empty-field') == false) {
                $('.create-abonement-button').prop('disabled', false);
                return;
            };
        }

    }

    function disableSubmitButton(){
        $('.create-abonement-button').prop('disabled', true);
        enableSubmitButton();
    }

    function selectInterval(){

        var $intervalRadio = $('input[name=interval]:checked');
        var $wnd = $('#select-interval-modal');


        var val = $intervalRadio.val();
        if(val == "0") {
            $wnd.modal('hide');
            return;
        }

        var $destBtn = $wnd.data('target');
        var text = $intervalRadio.closest('li').find('label').html();
        $destBtn.attr("data-container", val).find('span').html(text);
        var inpt = $destBtn.find('input');
        $(inpt).val(val);
        $wnd.modal('hide');

        enableSubmitButton();
        enableAudiosessionFields();
    }

///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////


});


function uploadcities(){
    var countryID = $('[name=country]').val();
    var regionID = $('[name=region]').val();
    var inputcity = $('[name=city]').get(0);
    if(!inputcity.needupload) inputcity.needupload = 0;

    $.get('http://beznevrozanet.ru/service/api.php?act=cities&cid='+countryID+"&rid="+regionID+"&offset="+inputcity.needupload,function(data) {
        var data = JSON.parse(data);
        var response = data.response;
        var $inputcity = $('[name=city]');
        var inputcity = $inputcity.get(0);

        var content = "<option value='0' checked>Выберите город</option>";

        if(inputcity.needupload) {
            content = "";
        }

        for(var i = 0; i < response.length; i++){
            content += "<option value='"+response[i].cid+"'>"+response[i].title+"</option>";
        }

        if(inputcity.needupload){
            $inputcity.html( $inputcity.html() + content);
        } else {
            $inputcity.html(content);
        }

        $inputcity.prop('disabled', false);

        if(response.length == 1000){
            inputcity.needupload++;
            uploadcities();
        } else {
            inputcity.needupload = 0;
        }
    });
}



function openDetails(){
    $('#confirm_window').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#select_wind_id').off('hidden.bs.modal');
}

function selectSession(id){
    $('#select_wind_id').on('hidden.bs.modal', function(){
        $.ajax({
            type: 'POST',
            url: 'index.php?c=ajax&act=sessiondetails&id='+id,
            data: "",
            success: function(data) {
                var dataObj = JSON.parse(data);
                if(dataObj.error == false){
                    $('#confirm_window .modal-body').html(dataObj.content);
                    openDetails();
                }
            },
            error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
    });
    $('#select_wind_id').modal('hide');
}






function sendLoginForm(){
    var formData = $('#modal_login_form').serialize();
        $.ajax({
            type: 'POST',
            url: 'index.php?c=ajax&act=login',
            data: formData,
            success: function(data) {
                var dataObj = JSON.parse(data);
                if(dataObj['error'] == false){
                    $('#logonid').modal('hide');
                    $('#modal_login_form').submit();
                } else {
                    $('#logonid .error-field').html(dataObj['content']);
                }
            },
            error:  function(xhr, str){
                $('#logonid .error-field').html("неизвестная ошибка: " + xhr.responseCode);
            }
        });
}

function getSessionsList(elem){

    if($(elem).hasClass( "disabled-field" )) return;

    $('#confirm_window').get(0).targetAudiosessionListItem = elem;

    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=sessionlist',
        data: "",
        success: function(data) {
            var dataObj = JSON.parse(data);
            if(dataObj.error == false){
                $('.select-audiosession-window .modal-body').html(dataObj.list);
                $('#select_wind_id').modal('show');
            }
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });

}

function backToList(){
    $('#confirm_window').modal('hide').on('hidden.bs.modal', function(){
        $('#select_wind_id').modal('show');
        $('#confirm_window').off('hidden.bs.modal');
    });

}

function createAbonement(){

    var formData = $('#create-abonement-form').serialize();

    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=preparepayform',
        data: formData,
        success: function(data) {
            var dataObj = JSON.parse(data);
            if(dataObj['error'] == false){
                $('#confirm_pay_window .modal-body').html(dataObj.content);
                $('#confirm_pay_window').modal('show');
            } else {

            }
        },
        error:  function(xhr, str){
            $('#logonid .error-field').html("неизвестная ошибка: " + xhr.responseCode);
        }
    });
}

function saveAbonementChanges(){
    for(var i = 1; i <=3 ; i++){
        var elem = $('#interval_button_'+i);
        var text = elem.html();
        if(text != 'выберите'){
            var data = elem.attr('data-container');
            $('input[name=interval'+i+']').val(data);
        }
    }
    $('#create-abonement-form').submit();
}

function deleteCommentModal(id){
    $('input[name=id]').val(id);
    $('#del_comment').modal();

}

function deleteAbonement($id){
    $('#id-field').val($id);
    $('#delete-abonement').modal();
}

function deleteAudiosession($id){
    $('#id-delete-audiosession').val($id);
    $('#delete-audiosession').modal('show');
}



function blockAbonement(id){

    $('#block-id').val(id);
    $('#free-block-id').val(id);


    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=getblock&id='+id,
        data: "",
        success: function(data) {
            var dataObj = JSON.parse(data);
            if(dataObj['error'] == false){
                var block_start = 0;
                var block_end = 0;
                if(dataObj.block.blocked) {
                    block_start = dataObj.block.block_start;
                    block_end = dataObj.block.block_end;
                }

                $('#block-abonement input[name=start_date]').val(block_start);
                $('#block-abonement input[name=end_date]').val(block_end);
                $('#block-abonement').modal();

            } else {

            }
        },
        error:  function(xhr, str){
            $('#logonid .error-field').html("неизвестная ошибка: " + xhr.responseCode);
        }
    });
}

function blockAudiosession(id){

    $('#block-audiosession-id').val(id);
    $('#free-audiosession-id').val(id);


    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=getaudioblock&id='+id,
        data: "",
        success: function(data) {
            var dataObj = JSON.parse(data);
            if(dataObj['error'] == false){
                var block_start = 0;
                var block_end = 0;
                if(dataObj.block.blocked) {
                    block_start = dataObj.block.block_start;
                    block_end = dataObj.block.block_end;
                }

                $('#block-audiosession input[name=start_date]').val(block_start);
                $('#block-audiosession input[name=end_date]').val(block_end);
                $('#block-audiosession').modal();

            } else {

            }
        },
        error:  function(xhr, str){

        }
    });
}


function getSessionsListAdmin(elem){
    $('#select_wind_id_admin').get(0).terget_list_element = $(elem).closest('tr');

    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=sessionlistadmin',
        data: "",
        success: function(data) {
            var dataObj = JSON.parse(data);
            if(dataObj.error == false){
                $('#select_wind_id_admin .modal-body').html(dataObj.list);
                $('#select_wind_id_admin').modal('show');
            }
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });

}

function selectSessionAdmin(id, capt){
    var elem = $('#select_wind_id_admin').get(0).terget_list_element;
    elem.find('span').html(capt);
    elem.find('input').val(id);
    $('.admin-buttons-bottom button').css('display', 'inline-block');
    $('#select_wind_id_admin').modal('hide');

}

function genPass(){
    var length = 8, charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

function createPassword(){
    $('#password-field').val(genPass());
}

function changeRole(role_id){
    $.ajax({
        type: 'POST',
        url: 'index.php?c=ajax&act=chrole',
        data: "",
        success: function(data) {
            var dataObj = JSON.parse(data);
            if(dataObj.error == false){
                $('#select_wind_id_admin .modal-body').html(dataObj.list);
                $('#select_wind_id_admin').modal('show');
            }
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
}

////////////////////////////////////////////////////////////////////////////////////
///////////// На странице мои абонементы                        ////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

$(window).on('load', function(){
    $('.listen-button').on('click', function(){
        $('.player').fadeIn(100);
    });
});

$(document).ready(function() {
    $.datepicker.regional["ru"];
    $.datepicker.setDefaults({
        dateFormat:'yy-mm-dd'
    })
    $(function() {
        $('#start_time').datepicker();
        $('#end_time').datepicker();
    });  
    $('#filter').click(function(){
        var start_time = $('#start_time').val();
        var end_time = $('#end_time').val();
        if(start_time == '' && end_time == ''){
        alert('Вы не выбрали дату.');
            /*$.ajax({
                url: "index.php?c=finances&act=getdate",
                method: "POST",
                data:{start_time:start_time, end_time:end_time},
                success:function(data){
                    $('#admin-table').html(data);
                }*/
        };
    });
});  

 $(document).ready(function() {
            $("textarea#editor").cleditor({
                width: 500, // width not including margins, borders or padding
                height: 250, // height not including margins, borders or padding
                controls: // controls to add to the toolbar
                    "bold italic underline strikethrough subscript superscript | font size " +
                    "style | color highlight removeformat | bullets numbering | outdent " +
                    "indent | alignleft center alignright justify | undo redo | " +
                    "rule image link unlink | cut copy paste pastetext | print source",
                colors: // colors in the color popup
                    "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
                    "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
                    "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
                    "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
                    "666 900 C60 C93 990 090 399 33F 60C 939 " +
                    "333 600 930 963 660 060 366 009 339 636 " +
                    "000 300 630 633 330 030 033 006 309 303",
                fonts: // font names in the font popup
                    "Arial,Arial Black,Comic Sans MS,Courier New,Narrow,Garamond," +
                    "Georgia,Impact,Sans Serif,Serif,Tahoma,Trebuchet MS,Verdana",
                sizes: // sizes in the font size popup
                    "1,2,3,4,5,6,7",
                styles: // styles in the style popup
                    [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"],
                    ["Header 3", "<h3>"],  ["Header 4","<h4>"],  ["Header 5","<h5>"],
                    ["Header 6","<h6>"]],
                useCSS: false, // use CSS to style HTML when possible (not supported in ie)
                docType: // Document type contained within the editor
                    '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
                docCSSFile: // CSS file used to style the document contained within the editor
                    "",
                bodyStyle: // style to assign to document body contained within the editor
                    "margin:4px; font:10pt Arial,Verdana; cursor:text"
            });
        });

 $(document).ready(function() { 
    $('#audiosession_tabs').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });
});

 ////////////////////////// galery image /////////////////////

$(document).ready(function($) {
    $('.carousel').carousel({
      interval: 3000
    });
});

$(document).ready(function($) {
		$('.collapse').collapse()
	});

