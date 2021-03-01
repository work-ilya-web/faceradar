<?= $this->include('template/head'); ?>

<div class="container">

    <div class="main-window flex-center">
		<form action="<?= site_url('Auth/recovery'); ?>" method="post" class="main-window__form recovery-form">
			<div class="main-window__step active" data-step="1">
				<div class="main-window__logo img-contain">
					<img src="<?= base_url();?>/assets/img/logo.svg" alt="">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Номер телефона</div>
					<input type="text" name="phone" class="main-window__field field phone-mask" placeholder="+ 7 (___) ___ - ___ - __" value="+7 (999) 999-99-98">
				</div>
				<div class="main-window__box code"></div>
                <input type="hidden" name="data_step" value="1">
				<div class="main-window__btn step--js" data-next-step="2" onclick="">Изменить пароль</div>
				<div class="main-window__bottom flex-center">
					нет аккаунта? <a href="<?= site_url('register'); ?>" class="main-window__link">зарегистрируйтесь</a>
				</div>
			</div>
			<div class="main-window__step" data-step="2">
				<div class="main-window__logo img-contain">
					<img src="<?= base_url();?>/assets/img/logo.svg" alt="">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Новый пароль</div>
					<input type="password" name="password" class="main-window__field field" placeholder="•••••••••••••••••">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Подтвердите пароль</div>
					<input type="password" name="password_confirm" class="main-window__field field" placeholder="•••••••••••••••••">
				</div>
				<button class="main-window__btn">готово</button>
				<div class="main-window__bottom flex-center">
					нет аккаунта? <a href="<?= site_url('register'); ?>" class="main-window__link">зарегистрируйтесь</a>
				</div>
			</div>
		</form>
	</div>

</div>

<?= $this->include('template/footer'); ?>