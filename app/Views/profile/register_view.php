<?= $this->include('head'); ?>
<div class="container">

    <div class="main-window flex-center">
		<form action="<?= site_url('Auth/register'); ?>" method="post" class="main-window__form register-form">
			<div class="main-window__step active" data-step="1">
				<div class="main-window__logo img-contain">
					<img src="<?= base_url();?>/assets/img/logo.svg" alt="">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Номер телефона</div>
					<input type="text" name="phone" class="main-window__field field phone-mask" placeholder="+ 7 (___) ___ - ___ - __">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Email</div>
					<input type="text" name="email" class="main-window__field field" placeholder="example@gmail.com">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Новый пароль</div>
					<input type="password" name="password" class="main-window__field field" placeholder="•••••••••••••••••">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Подтвердите пароль</div>
					<input type="password" name="password_confirm" class="main-window__field field" placeholder="•••••••••••••••••">
				</div>
				<div class="main-window__btn step--js" data-next-step="2" onclick="">далее</div>
				<div class="main-window__bottom flex-center">
					Уже зарегистрированы? <a href="<?= site_url('login'); ?>" class="main-window__link">войдите</a>
				</div>
			</div>
			<div class="main-window__step" data-step="2">
				<div class="main-window__logo img-contain">
					<img src="<?= base_url();?>/assets/img/logo.svg" alt="">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Фамилия</div>
					<input type="text" name="surname" class="main-window__field field" placeholder="Введите фамилию">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Имя</div>
					<input type="text" name="name" class="main-window__field field" placeholder="Введите имя">
				</div>
				<div class="main-window__box">
					<div class="main-window__caption">Отчество</div>
					<input type="text" name="patronymic" class="main-window__field field" placeholder="Введите отчество">
				</div>
                <?php if($cities){ ?>
                    <div class="main-window__box">
                        <div class="main-window__caption">Введите город</div>
                        <div class="select">
                            <div class="select-title">
                                <div class="select-title__value"><?= $cities[0]['title']; ?></div>
                                <div class="select-title__arrow"></div>
                            </div>
                            <div class="select-options">
                                <?php foreach ($cities as $city) { ?>
                                    <div class="select-options__value" data-value="<?= $city['id']; ?>">
                                        <span><?= $city['title']; ?></span>
                                    </div>
                                <?php } ?>
                                <input type="hidden" name="type" value="1">
                            </div>
                        </div>
                    </div>
                <?php } ?>
				<div class="main-window__box code"></div>
				<button class="main-window__btn">регистрация</button>
				<div class="main-window__bottom flex-center">
					Уже зарегистрированы? <a href="<?= site_url('login'); ?>" class="main-window__link">войдите</a>
				</div>
			</div>
		</form>
	</div>

</div>

<?= $this->include('footer'); ?>
