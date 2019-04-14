<?php 
// Запрещает запуск скрипта напрямую в обход index.php
defined('APPRUNNING') or die();

$user = getUser();

loadTemplate('header', array("user" => $user) );

if(empty($_GET['audiosession'])) {
    loadTemplate ('404');
} else {
    $audiosession_id = intval($_GET['audiosession']);
    if(!$audiosession = getOne('audiosessions', "id=$audiosession_id"))
        loadTemplate ('404');
    else {
        
        if(isset($_GET['comment']) && !empty($_POST['content']) && $user){
            if(!addComment($user['id'], $audiosession['id'], $_POST['content'])){   // ИСПРАВИТЬ УЯЗВИМОСТЬ!!!
                die("Комментарий не записан");
            }      
        }
        
        $isOwner = isUserOwner($audiosession, $user);
        if(!$isOwner && $user) loadTemplate('modal_pay', array('user' => $user));
        
        $comments = audiosessionComments($audiosession['id']);
        
        if($user) $avalible = getAvalibleParams($user['id'], $audiosession['id']);
        else $avalible = false;
        
        if(isset($_GET['listening']) && $avalible['when']=='Сейчас'){
            $listening = true;
        } else $listening = false;
        
        loadTemplate('card', array(
            'as_img' =>$audiosession['img'],
            'is_owner' => $isOwner,
            'as_desc' => $audiosession['description'],
            'as_caption' => $audiosession['caption'],
            'as_id' => $audiosession['id'],
            'reviews' => count($comments),
            'avalible' => $avalible,
            'listening' => $listening
            ));
        
        if($listening && $isOwner) loadTemplate ('player',$user);
        
        if(!$isOwner && $user)  loadTemplate('form', array('asid' => $audiosession['id']));
        
        
        loadTemplate('comments', array(
            'user' => $user, 
            'comments' => $comments, 
            'count_reviews' => count($comments),
            'asid' => $audiosession['id'] 
        ) );
        
    }
    
}

loadTemplate('footer');