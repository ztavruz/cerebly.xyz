<?php
?>
        <div class="wrapper">
            <div class="row">
                <div class="col-md-5">
                    <div class="merchpic">
                <!-- Slider -->
                        <div class="carousel slide article-slide" id="article-photo-carousel">

                          <!-- Wrapper for slides -->
                          <div class="center-block">
                          <div class=" carousel-inner cont-slider card_slider" >

                            <div class="item active">
                              <?php 
                                echo " <img src=".getMedia($data['audiosession']->img1)." alt='img1'>";
                                ?>
                            </div>
                            <div class="item">
                              <?php 
                                echo " <img src=".getMedia($data['audiosession']->img2)." alt='img2'>";
                                ?>
                            </div>
                            <div class="item">
                              <?php 
                                echo " <img src=".getMedia($data['audiosession']->img3)." alt='img3'>";
                                ?>
                            </div>
                            <div class="item">
                              <?php 
                                echo " <img src=".getMedia($data['audiosession']->img4)." alt='img4'>";
                                ?>
                            </div>
                            </div>
                          </div>
                          <!-- Indicators -->
                          <ol class="carousel-indicators">
                            <li class="active" data-slide-to="0" data-target="#article-photo-carousel">
                              <?php 
                                echo " <img src=".getMedia($data['audiosession']->img1)." alt='img1'>";
                                ?>
                            </li>
                            <li class="" data-slide-to="1" data-target="#article-photo-carousel">
                              <?php 
                                echo " <img src=".getMedia($data['audiosession']->img2)." alt='img2'>";
                                ?>
                            </li>
                            <li class="" data-slide-to="2" data-target="#article-photo-carousel">
                              <?php 
                                echo " <img src=".getMedia($data['audiosession']->img3)." alt='img3'>";
                                ?>
                            </li>
                            <li class="" data-slide-to="3" data-target="#article-photo-carousel">
                              <?php 
                                echo " <img src=".getMedia($data['audiosession']->img4)." alt='img4'>";
                                ?>
                            </li>
                          </ol>
                        </div>
                   </div> 
                </div>
                <div class="col-md-7">
                    <div class="desc">
                        <div class="reviews">Отзывов: <?php echo $data['reviews'] ?></div>
                        <h4><?php echo $data['audiosession']->caption ?></h4>
                        <p><b>Описание: </b> <?php echo $data['audiosession']->description?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

<div class="product">
    <div class="product name ">
      <a href="#">
        <div class="container-flex">
        <div class="col-md-4">
    <?php 
    echo " <img src=".getMedia($data['audiosession']->img1)." alt='img4'>";
    ?>
        </div>
        <div class="col-md-8" style="text-align: left;">
        <h4><?php echo $data['audiosession']->caption ?></h4>
        </div>
		<div class="col-md-8" style="text-align: left; color: black;">
		<h5>Цена: 500 р. </h5>
        </div> 
      </div> 
      </a>
    </div> 

    <div class="product name ">
	<a href="#">
        <div class="container-flex">
        <div class="col-md-4">
    <?php 
    echo " <img src=".getMedia($data['audiosession']->img2)." alt='img4'>";
    ?>
        </div>
        <div class="col-md-8" style="text-align: left;">
        <h4><?php echo $data['audiosession']->caption ?></h4>
        </div>
		<div class="col-md-8" style="text-align: left; color: black;">
		<h5>Цена: 500 р.</h5>
        </div> 
      </div> 
	  </a>
    </div> 

    <div class="product name ">
	<a href="#">
        <div class="container-flex">
        <div class="col-md-4">
    <?php 
    echo " <img src=".getMedia($data['audiosession']->img3)." alt='img4'>";
    ?>
        </div>
        <div class="col-md-8" style="text-align: left;  ">
        <h4><?php echo $data['audiosession']->caption ?></h4>
        </div>
		<div class="col-md-8" style="text-align: left; color: black;">
		<h5>Цена: 500 р.</h5>
        </div> 
      </div> 
    </div> 
	</a>
</div>
