<?= $this->include('head_view'); ?>

<?php $register_message = session()->getFlashdata('success'); ?>


<div class="entry flex-center">
    <form action="<?= site_url('Auth/login'); ?>" method="post" class="entry__form main-window__form login-form">
        <a href="/" class="logo">Faceradar</a>
        <div class="entry__body">
            <?= ($register_message ? $register_message : ''); ?>
            <input type="text" name="email" class="entry__field field" placeholder="Email">
            <input type="password" name="password" class="entry__field field" placeholder="Пароль">
            <button class="entry__btn btn main-window__btn">Войти</button>
        </div>
    </form>
</div>



<?= $this->include('footer_view'); ?>
