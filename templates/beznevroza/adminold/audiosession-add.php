<?php ?>

<div class="admin-left-menu">
    <ul>
        <li>
            <a href="<?php echo getActionLink("users") ?>">Пользователи</a>
            <ul>
                <li><a href="<?php echo getActionLink("users") ?>">Пользователи</a></li>
                <?php if(User::can('edit_roles')): ?><li><a href="<?php echo getActionLink("roles") ?>">Роли</a></li><?php endif; ?>
            </ul>
        </li>
        <li class="active"><a href="<?php echo getActionLink("audiosessions") ?>">Аудиосеансы</a></li>
        <li><a href="<?php echo getActionLink("abonements") ?>">Абонементы</a></li>
        <?php if(User::can('review_comments')): ?><li><a href="<?php echo getActionLink("comments") ?>">Комментарии</a></li><?php endif; ?>
        <li><a href="<?php echo getActionLink("finances") ?>">Финансы</a></li>
        <li><a href="<?php echo getActionLink("support") ?>">Техподдержка</a></li>
    </ul>
</div>



<div class="admin-content">

    <!--      breadcrumbs        -->
    <div class="admin-breadcrumbs">
        <a href="<?php echo getActionLink("audiosessions") ?>">Аудиосеансы</a> / <a class="active" href="<?php echo getActionLink("audiosessions", "add") ?>">Редактировать</a>
    </div>
    <!--      breadcrumbs        /-->

    <h2>Аудиосеанс</h2>

    <form id="audiosession-form" action="<?php echo getActionLink("ajax", "savesession") ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="blocksize" value="<?php echo $data['blocksize'] ?>" />
        <input type="hidden" name="redirect" value="<?php echo getActionLink("audiosessions") ?>">
        <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
        <input type="hidden" name="img" value="<?php echo $data['img'] ?>" />
        <input type="hidden" name="uri" value="<?php echo $data['uri'] ?>" />
    <table class="audiosession-table">
        <tr>
            <td>
                <div class="form-group">
                    <div id="success-field" class="alert alert-success" style="display: none;" role="alert">Аудиосеанс успешно сохранен</div>
                </div>
                <?php if(isset($data['success'])): ?>
                    <div class="form-group">
                        <div id="success-field" class="alert alert-success" role="alert">Аудиосеанс успешно сохранен</div>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <input type="text" class="form-control" name="caption" placeholder="Название сеанса" value="<?php echo $data['caption'] ?>">
                </div>
            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>
                <div id="uploadfile-errorfield" class="alert alert-danger" style="display: none" role="alert">
                    <a href="#" class="alert-link">Вы не указали файл сеанса</a>
                </div>
                <?php if(isset($data['errors'])): ?>
                    <div id="uploadfile-errorfield" class="alert alert-danger" role="alert">
                        <a href="#" class="alert-link">
                        <?php foreach ($data['errors'] as $error):
                          echo $error;
                         endforeach; ?>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="input-group">
                    <input id="uploadfilename" type="text" class="form-control" placeholder="Выберите файл аудиосеанса" disabled value="<?php echo $data['uri'] ?>">
                    <span class="input-group-btn">
                        <input type="file" name="uploadfile" id="uploadfile" onchange="changesession()" style="display: none">
                        <label class="btn btn-default" for="uploadfile">Выберите файл</label>
                    </span>
                </div>

            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">

                    <div class="upload-image" id="dropblock">
                        <div class="dragover-shadow"></div>
                        <img id="preview_img" src="<?php if($data['img1']) echo getMedia($data['img1']); else echo getAssetsUrl()."img/noimage.jpg";   ?>" alt="">
                    </div>

                    <div class="form-group can-drug">
                        <div class="well"> 
                            Перетяните файл с изображением с вашего компьютера в блок выше
                        </div>
                    </div>

                    <div class="input-group">
                        <input id="image-url1" type="text" class="form-control" placeholder="Выберите файл картинки" value="<?php if($data['img1']) echo $data['img1'];   ?>" disabled>
                        <span class="input-group-btn">
                            <input type="file" name="uploadimage1" id="uploadimage1" onchange="preview()" style="display: none">
                            <label class="btn btn-default" for="uploadimage1">Выберите файл</label>
                          </span>
                    </div>

                    <div class="input-group">
                        <input id="image-url2" type="text" class="form-control" placeholder="Выберите файл картинки" value="<?php if($data['img2']) echo $data['img2'];   ?>" disabled>
                        <span class="input-group-btn">
                            <input type="file" name="uploadimage2" id="uploadimage2" onchange="preview()" style="display: none">
                            <label class="btn btn-default" for="uploadimage2">Выберите файл</label>
                          </span>
                    </div>

                    <div class="input-group">
                        <input id="image-url3" type="text" class="form-control" placeholder="Выберите файл картинки" value="<?php if($data['img3']) echo $data['img3'];   ?>" disabled>
                        <span class="input-group-btn">
                            <input type="file" name="uploadimage3" id="uploadimage3" onchange="preview()" style="display: none">
                            <label class="btn btn-default" for="uploadimage3">Выберите файл</label>
                          </span>
                    </div>

                    <div class="input-group">
                        <input id="image-url4" type="text" class="form-control" placeholder="Выберите файл картинки" value="<?php if($data['img4']) echo $data['img4'];   ?>" disabled>
                        <span class="input-group-btn">
                            <input type="file" name="uploadimage4" id="uploadimage4" onchange="preview()" style="display: none">
                            <label class="btn btn-default" for="uploadimage4">Выберите файл</label>
                          </span>
                    </div>                                                            
                </div>

            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="player-placeholder"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="form-group"> Краткое описание:
                    <textarea id='editor' name="description" cols="30" rows="10" class="form-control"><?php echo $data['description'] ?></textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="form-group"> Полное описание:
                    <textarea id='editor' name="full_description" cols="30" rows="10" class="form-control"><?php echo $data['full_description'] ?></textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td>
            
                <div class="checkbox">
                    <label>
                        <input  <?php if(!User::can('publish_audiosessions')): ?>disabled<?php endif; ?>  type="checkbox" name="published" <?php if($data['published']) echo "checked" ?>> Опубликовано
                    </label>
                </div>

            </td>
            <td></td>
        </tr>
    </table>


    <div class="admin-buttons-bottom">
        <button class="btn btn-primary" type="submit">Сохранить</button>
        <a class="btn btn-success" href="<?php echo getActionLink("audiosessions") ?>">Отмена</a>
        <progress id="upload_progress" value="10" max="100" style="display: none;"></progress>
    </div>
    </form>
</div>


