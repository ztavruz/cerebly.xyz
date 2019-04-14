<?php
// Запрещает запуск скрипта напрямую в обход index.php
defined('APPRUNNING') or die();

$user = getUser();

loadTemplate('header', array("user" => $user));

$audiosessions = getQuery("SELECT audiosessions.id, audiosessions.uri,  audiosessions.description, audiosessions.img, audiosessions.caption FROM audiosessions, orders WHERE audiosessions.id = orders.asid AND orders.owner={$user['id']} AND orders.paid=1");

foreach($audiosessions as $item)
{
    $avalible = getAvalibleParams($user['id'], $item['id']);
    $comments = audiosessionComments($item['id']);
    loadTemplate('card', array(
            'as_img' =>$item['img'],
            'is_owner' => isUserOwner($item, $user),
            'as_desc' => $item['description'],
            'as_caption' => $item['caption'],
            'as_id' => $item['id'],
            'reviews' => count($comments),
            'avalible' => $avalible
            ));
}

loadTemplate('footer');