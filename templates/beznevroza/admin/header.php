<?php
// Запрещает прямой запуск в обход index.php
defined('BEZNEVROZA') or die("Доступ запрещен...");

?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>Beznevroza</title>
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/bootstrap.css" >
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/jquery.kladr.min.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/form.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/style.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/jquery.cleditor.css">
	<script src="<?php echo getAssetsUrl() ?>js/ckeditor.js"></script>
	<script src="<?php echo getAssetsUrl() ?>js/sample.js"></script>
	<link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/samples.css">
	<link rel="stylesheet" href="<?php echo getAssetsUrl() ?>css/neo.css">	

</head>
<body>
    <header>
        <div class="container">
            <div class="logo"></div>

                <?php if($data['user']): ?>

                <a href="<?php echo getActionLink('authorization', 'logout') ?>" class="btn btn-primary morelink">Выйти</a>
            <?php else: ?>

                <button data-toggle="modal" data-target="#logonid" class="btn btn-primary morelink">Войти</button>
            <?php endif; ?>
        </div>
    </header>
    
    <div class="container">
        <div class="admin-content-wrapper clearfix">