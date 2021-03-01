
<?= $this->include('template/head'); ?>

<?php $register_message = session()->getFlashdata('success'); ?>

<div class="container">
    <div class="main-window flex-center">
        <form action="<?= site_url('Auth/login'); ?>" method="post" class="main-window__form login-form">
            <div class="main-window__logo img-contain">
                <img src="<?= base_url();?>/assets/img/logo.svg" alt="">
            </div>
            <?= ($register_message ? $register_message : ''); ?>
            <div class="main-window__box">
                <div class="main-window__caption">Номер телефона</div>
                <input type="text" name="phone" class="main-window__field field phone-mask" placeholder="+ 7 (___) ___ - ___ - __">
            </div>
            <div class="main-window__box">
                <div class="main-window__caption">Пароль</div>
                <input type="password" name="password" class="main-window__field field" placeholder="">
            </div>
            <button class="main-window__btn">войти</button>
            <div class="main-window__center">
                <a href="<?= site_url('recovery'); ?>" class="main-window__link">Забыли пароль?</a>
            </div>
            <div class="main-window__bottom flex-center">
                нет аккаунта? <a href="<?= site_url('register'); ?>" class="main-window__link">зарегистрируйтесь</a>
            </div>
        </form>
    </div>
</div>

<?= $this->include('template/footer'); ?>
