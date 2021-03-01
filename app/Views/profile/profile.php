
<?= $this->include('profile/template/header'); ?>

<div class="container cities">
    <div class="container__body">
        
        <?= $this->include('profile/template/left-menu'); ?> 

        <div class="container__right">
            <?= $this->include('profile/template/top-menu'); ?>
            <div class="profile">
            	<div class="profile__left">
            		<div class="profile-form">
            			<div class="profile-form__section">
            				<div class="profile-form__title">Информация</div>
            				<div class="profile-form__wrap">
		            			<form method="post">
		            				<div class="profile-form__row">
		            					<div class="profile-form__item">
				                            <p>Фамилия</p>
			                                <input type="text" class="field" name="surname" placeholder="Константинов" value="<?= $user_item['surname']; ?>">
		            					</div>
		            					<div class="profile-form__item">
				                            <p>Имя</p>
			                                <input type="text" class="field" name="name" placeholder="Ваше имя" value="<?= $user_item['name']; ?>">
		            					</div>
		            					<div class="profile-form__item">
				                            <p>Отчество</p>
			                                <input type="text" class="field" name="patronymic" placeholder="Валентинович" value="<?= $user_item['patronymic']; ?>">
		            					</div>
		            					<div class="profile-form__item">
				                            <p>Email</p>
			                                <input type="text" class="field" name="email" placeholder="konstantinov@gmail.com" value="<?= $user_item['email']; ?>">
		            					</div>
		            					<div class="profile-form__item">
											<input type="hidden" name="base_url" value="<?= site_url('Profile/info_ajax'); ?>">
		            						<button type="submit" class="btn-profile-info btn-item btn-item--big btn-item--full save-profile">Сохранить изменения</button>
		            					</div>
		            				</div>
		            			</form>
            				</div>            				
            			</div>
            			<div class="profile-form__section">
            				<div class="profile-form__title">Сменить пароль</div>
            				<div class="profile-form__wrap">
			        			<form method="post">
			        				<div class="profile-form__row">
			        					<div class="profile-form__item">
				                            <p>Старый пароль</p>
			                                <input type="password" name="password" class="field" placeholder="•••••••••••••••••">
			        					</div>
			        					<div class="profile-form__item"></div>
			        					<div class="profile-form__item">
				                            <p>Новый пароль</p>
			                                <input type="password" name="new_password" class="field" placeholder="•••••••••••••••••">
			        					</div>
			        					<div class="profile-form__item">
				                            <p>Повторите новый пароль</p>
			                                <input type="password" name="new_password_confirm" class="field" placeholder="•••••••••••••••••">
			        					</div>
			        					<div class="profile-form__item">
											<input type="hidden" name="base_url" value="<?= site_url('Profile/password_ajax'); ?>">
			        						<button type="submit" class="btn-profile-password btn-item btn-item--big btn-item--full save-password">Сохранить пароль</button>
			        					</div>
			        				</div>
			        			</form>
            				</div>
            			</div>
            		</div>
            	</div>
            	<div class="profile__right">
            		<div class="profile-address">
            			<div class="profile-address__top">
            				<div class="profile-address__title">Адреса</div>
            				<a href="<?= site_url('profile/address'); ?>" class="profile-address__all">Все адреса</a>
            			</div>
            			<div class="profile-address__content">
            				<div class="profile-address__subtitle">Последние добавленные</div>
							<?php 
						
							if($address_list){ ?>
								<div class="profile-address__list">
									<?php foreach ($address_list as $list) { ?>
										<div class="profile-address__item"><i class="ic ic-address"></i>
											<?= ($list['city_title'] ? 'г. ' . $list['city_title'] . '' : ''); ?><?= ($list['street'] ? ',' . $list['street'] . '' : ''); ?> <?= ($list['house'] ? $list['house'] : ''); ?><?= ($list['floo'] ? ', ' . $list['floo'] . ' этаж' : ''); ?><?= ($list['flat'] ? ', кв./офис ' . $list['flat'] . '' : ''); ?>
										</div>
									<?php } ?>
								</div>
							<?php } else { ?>
								Адресов не найдено
							<?php } ?>
            				<a href="<?= site_url('profile/address/add'); ?>" class="profile-address__add btn-item btn-item--big btn-item--full"><i class="ic ic-address2"></i> Добавить адрес</a>
            			</div>
            		</div>
            	</div>
            </div>

        </div>
    </div>

</div>

<div id="modal-profile-info" class="callback-modal modal" style="display: none;">
	<div class="modal__closed flex-center svg-contain" data-fancybox-close>
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#383741"/>
		</svg>
	</div>
	<div class="modal__body">
		<div class="modal__title">Успешно сохранено</div>
		<div class="modal__subtitle">Изменения в профиле успешно сохранены!</div>
		<div class="modal__buttons flex">
			<a href="#" class="modal__btn btn btn_dark" data-fancybox-close>закрыть</a>
		</div>
	</div>
</div><!-- end modal-profile-info -->

<div id="modal-profile-password" class="callback-modal modal" style="display: none;">
	<div class="modal__closed flex-center svg-contain" data-fancybox-close>
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#383741"/>
		</svg>
	</div>
	<div class="modal__body">
		<div class="modal__title">Успешно сохранено</div>
		<div class="modal__subtitle">Новый пароль успешно сохранен!</div>
		<div class="modal__buttons flex">
			<a href="#" class="modal__btn btn btn_dark" data-fancybox-close>закрыть</a>
		</div>
	</div>
</div><!-- end modal-profile-password -->

<?= $this->include('profile/template/footer'); ?>