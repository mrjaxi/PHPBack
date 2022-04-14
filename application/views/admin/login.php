<div class="login-screen">
    <div class="login-form">
        <form action="<?php echo base_url() . 'adminaction/login'?>" method="POST">
            <div class="loginlogo">
                <img src="<?php echo base_url() . 'public/img/logotype_atmaguru.svg'?>" />
            </div>
            <?php if(!isset($error)): ?>
            <div class="form-group">
                <input type="text" class="form-control login-field" value="" placeholder="Введите ваш email" id="login-name" name="email" />
                <label class="login-field-icon fui-user" for="login-name"></label>
            </div>

            <div class="form-group">
                <input type="password" class="form-control login-field" value="" placeholder="Пароль" id="login-pass" name="password"/>
                <label class="login-field-icon fui-lock" for="login-pass"></label>
            </div>
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Войти">
    </div>
    <?php elseif($error == 'noadmin'):?>
        <div style="color:#C0392B;font-size:20px">Вы не являетесь администратором</div>
    <?php else: ?>
    <div style="color:#C0392B;font-size:15px">Электронная почта или пароль неверны</div>
    <div class="form-group">
        <input type="text" class="form-control login-field" value="" placeholder="Введите ваш email" id="login-name" name="email" />
        <label class="login-field-icon fui-user" for="login-name"></label>
    </div>

    <div class="form-group">
        <input type="password" class="form-control login-field" value="" placeholder="Пароль" id="login-pass" name="password"/>
        <label class="login-field-icon fui-lock" for="login-pass"></label>
    </div>
    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Войти">
</div>
<?php endif; ?>
</form>
</div>
</div>
</body>
</html>