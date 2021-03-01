
<?= $this->include('template/head'); ?>
<div class="container">
    <div class="main-window flex-center">
        <form action="<?= site_url('Admin/Auth/login'); ?>" method="post" class="main-window__form login-form">
            <div class="main-window__logo img-contain">
                <img src="<?= base_url();?>/assets/img/logo.svg" alt="">
            </div>
            <div class="main-window__box">
                <div class="main-window__caption">Номер телефона</div>
                <input type="text" name="phone" class="main-window__field field phone-mask" placeholder="+ 7 (___) ___ - ___ - __">
            </div>
            <div class="main-window__box">
                <div class="main-window__caption">Пароль</div>
                <input type="password" name="password" class="main-window__field field" placeholder="">
            </div>
            <button class="main-window__btn">войти</button>
        </form>
    </div>
</div>
<?= $this->include('template/footer'); ?>
