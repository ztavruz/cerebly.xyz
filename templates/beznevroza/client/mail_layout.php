<?php




?>

<div style="background-color: white; font-family: Tahoma, sans-serif; color: #727272; width: 800px;">

    <div style="display: block;float:none;-webkit-box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.12);-moz-box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.12);box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.12);height: 72px;background: white url('http://beznevrozanet.ru/logo.jpg') 20px 20px no-repeat; "></div>
    <div style="padding: 30px">

        <h3 style="color: rgb(1,139,0); font-size:20px; margin-top: 0; font-weight: bold">Подтверждение регистрации на портале beznevrozanet.ru</h3>
        <p style="font-size: 19px;">Здравствуйте, <?php echo $data['firstname'] ?>!<br>Для завершения регистрации на портале beznevrozanet.ru, пожалуйста подтвердите<br>Ваш Email:</p>
        
		
		<p>
		   <a href="http://beznevrozanet.ru//<?php echo $data['urlcode'] ?>" class="design" style="display: inline-block; background-color: rgb(1,139,0); border-radius: 3px; border: 0; padding:0 20px; margin:0; line-height: 35px; text-align: center;text-decoration: none; color: white">Ссылка</a>
			<p style="font-size: 14px">Если переход по ссылке не работает, скопируйте ее в адресную строку браузера: <br>
            <span style="text-decoration: underline;color: dodgerblue">http:/beznevrozanet.ru/<?php echo $data['urlcode'] ?></span>
            </p>
        </p>


        <p style="border-top:1px solid #e9e9e9; padding-top: 30px; margin-top: 30px; font-size: 14px">Это необходимо для проверки и подтверждения указанного вами email.Если вы не активируете аккаунт в течение 48 часов, он будет удален автоматически. Если вы не регистрировались на портале beznevrozanet.ru просто проигнорируйте это письмо.</p>

    </div>
</div>