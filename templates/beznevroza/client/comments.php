<?php

if($data['user'] || count($data['comments'])):

?>
        <div class="reviews-block">
            <!--<ul class="tabs">
                <li>Отзывы <i><?php if( count($data['comments']) ) echo "(".count($data['comments']).")" ?></i></li>
            </ul>-->
            <div class="contents">
                <?php

                if($data['user']): ?>
                <form id="commentformid" name="commentform" action="<?php echo getActionLink("comments", "add") ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $data['user']->id?>">
                <input type="hidden" name="asid" value="<?php echo $data['asid'] ?>">
                <div class="review comment">
                    <h4 class="name"><?php echo $data['user']->firstname." ".$data['user']->lastname ?></h4>
                    <div class="corner"></div>
                    <textarea name="content" placeholder="Оставьте комментарий"></textarea>
                    <button class="btn btn-primary" type="submit">Оставить отзыв</button>
                </div>
                </form>
                <?php endif;

                foreach($data['comments'] as $comment){  ?>
                <div class="review">
                    <h4 class="name"><?php echo $comment['firstname']." ".$comment['lastname']  ?></h4> &nbsp;<i class="date"><?php echo $comment['time'] ?></i>
                    <p class="content"><?php echo $comment['content'] ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
<?php endif; ?>