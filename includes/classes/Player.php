<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 26.04.2017
 * Time: 4:45
 */
class Player
{
    function __construct($audiosession)
    {

    }

    public function render()
    {
        return Document::getTemplate('player', array( 'player' => $this ));
    }
}