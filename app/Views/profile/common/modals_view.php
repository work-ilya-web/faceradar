
<?php if ($GLOBALS['user']['permission']['id']!=3): ?>
<div id="profile-modal" class="profile-modal profile modal" style="display: none;">
<div class="modal__closed flex-center svg-contain" data-fancybox-close>
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5859 16L5.29297 25.2928L6.70718 26.7071L16.0001 17.4142L25.293 26.7071L26.7072 25.2928L17.4143 16L26.7072 6.70706L25.293 5.29285L16.0001 14.5857L6.70718 5.29285L5.29297 6.70706L14.5859 16Z" fill="white"/>
    </svg>
</div>
<div class="modal__body">
    <div class="modal-loader">
        <img src="<?= base_url(); ?>/assets/img/loader.gif" alt="">
    </div>
    <form method="post" action="/clients/update" class="profile-form">
        <div class="profile__top">
            <div class="profile__title flex">
                <input type="text" class="profile-name--js field" name="name"  placeholder="Имя">
                <input type="text" class="profile-surname--js field" name="surname"  placeholder="Фамилия">
                <input type="text" class="profile-patronymic--js field" name="patronymic" placeholder="Отчество">
            </div>
        </div>
        <div class="profile__wrap">
            <div class="profile__left">
                <div class="profile__img ">
                    <img src="<?= base_url(); ?>/assets/img/profile/img.jpg" class="profile-photo--js" alt="">
                </div>
                <div class="profile__items">
                    <div class="profile__item">
                        <div class="profile__item-caption">Количество посещений:</div>
                        <div class="profile__item-value profile-visited--js"></div>
                    </div>
                    <div class="profile__item">
                        <div class="profile__item-caption">Последнее посещение:</div>
                        <div class="profile__item-value profile-last-visited--js">Неделю назад</div>
                    </div>
                </div>
            </div>
            <div class="profile__right">
                <div  class="profile__row">
                    <div class="profile__coll profile__coll_small input-year-birth--js">
                        <div class="profile__coll-caption">Год рождения <i class="fa fa-retweet retweet--js" aria-hidden="true"></i></div>
                        <label class="profile__coll-label">
                            <input type="text" name="year_birth" class="profile__coll-field field datepicker-here profile-year-birth--js" >
                        </label>
                    </div>
                    <div class="profile__coll profile__coll_small input-date-birth--js" style="display:none;">
                        <div class="profile__coll-caption">Дата рождения <i class="fa fa-retweet retweet--js" aria-hidden="true"></i></div>
                        <label class="profile__coll-label">
                            <input type="text" name="date_birth" class="profile__coll-field field datepicker-here profile-date-birth--js" >
                        </label>
                    </div>
                    <div class="profile__coll profile__coll_small">
                        <div class="profile__coll-caption">Пол</div>
                        <select class="select select-title__value select-title profile-sex--js" name="sex">
                            <option value="0">Не указан</option>
                            <option value="1">Мужской</option>
                            <option value="2">Женский</option>
                        </select>
                    </div>
                    <div class="profile__coll">
                        <div class="profile__coll-caption">Телефон</div>
                        <label class="profile__coll-label">
                            <input type="text" name="phone" class="profile__coll-field field phone-mask profile-phone--js" value="">
                        </label>
                    </div>
                    <div class="profile__coll">
                        <div class="profile__coll-caption">Email</div>
                        <label class="profile__coll-label">
                            <input type="text" name="email" class="profile__coll-field field profile-email--js" value="">
                        </label>
                    </div>
                    <div class="profile__coll">
                        <div class="profile__coll-caption">Комментарий к пользователю</div>
                        <label class="profile__coll-label">
                            <textarea class="profile__coll-field field profile-comment--js" name="comment" placeholder=""></textarea>
                        </label>
                    </div>
                    <input type="hidden" name="id" class="profile-id--js" value="">
                    <button class="form__btn btn send--js">Сохранить</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div><!-- end profile-modal -->
<?php endif; ?>

<?php if ($GLOBALS['user']['permission']['id']==3): ?>
<div id="profile-modal" class="profile-modal profile modal" style="display: none;">
<div class="modal__closed flex-center svg-contain" data-fancybox-close>
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5859 16L5.29297 25.2928L6.70718 26.7071L16.0001 17.4142L25.293 26.7071L26.7072 25.2928L17.4143 16L26.7072 6.70706L25.293 5.29285L16.0001 14.5857L6.70718 5.29285L5.29297 6.70706L14.5859 16Z" fill="white"/>
    </svg>
</div>
<div class="modal__body">
    <div class="modal-loader">
        <img src="<?= base_url(); ?>/assets/img/loader.gif" alt="">
    </div>
    <form method="post" action="/clients/update" class="profile-form">
        <div class="profile__top">
            <div class="profile__title flex">
                <input type="text" class="profile-name--js field" name="name"  placeholder="" disabled>
                <input type="text" class="profile-surname--js field" name="surname"  placeholder="" disabled>
                <input type="text" class="profile-patronymic--js field" name="patronymic" placeholder="" disabled>
            </div>
        </div>
        <div class="profile__wrap">
            <div class="profile__left">
                <div class="profile__img ">
                    <img src="<?= base_url(); ?>/assets/img/profile/img.jpg" class="profile-photo--js" alt="">
                </div>
                <div class="profile__items">
                    <div class="profile__item">
                        <div class="profile__item-caption">Количество посещений:</div>
                        <div class="profile__item-value profile-visited--js"></div>
                    </div>
                    <div class="profile__item">
                        <div class="profile__item-caption">Последнее посещение:</div>
                        <div class="profile__item-value profile-last-visited--js">Неделю назад</div>
                    </div>
                </div>
            </div>
            <div class="profile__right">
                <div  class="profile__row">
                    <div class="profile__coll profile__coll_small input-year-birth--js">
                        <div class="profile__coll-caption">Год рождения </div>
                        <label class="profile__coll-label">
                            <input type="text" name="year_birth" class="profile__coll-field field datepicker-here profile-year-birth--js" disabled >
                        </label>
                    </div>
                    <div class="profile__coll profile__coll_small input-date-birth--js" >
                        <div class="profile__coll-caption">Дата рождения</div>
                        <label class="profile__coll-label">
                            <input type="text" name="date_birth" class="profile__coll-field field datepicker-here profile-date-birth--js" disabled >
                        </label>
                    </div>
                    <div class="profile__coll profile__coll_small">
                        <div class="profile__coll-caption">Пол</div>
                        <select class="select select-title__value select-title profile-sex--js" name="sex" disabled>
                            <option value="0">Не указан</option>
                            <option value="1">Мужской</option>
                            <option value="2">Женский</option>
                        </select>
                    </div>
                    <div class="profile__coll">
                        <div class="profile__coll-caption">Телефон</div>
                        <label class="profile__coll-label">
                            <input type="text" name="phone" class="profile__coll-field field phone-mask profile-phone--js" value="" disabled>
                        </label>
                    </div>
                    <div class="profile__coll">
                        <div class="profile__coll-caption">Email</div>
                        <label class="profile__coll-label">
                            <input type="text" name="email" class="profile__coll-field field profile-email--js" value="" disabled>
                        </label>
                    </div>
                    <div class="profile__coll">
                        <div class="profile__coll-caption">Комментарий к пользователю</div>
                        <label class="profile__coll-label">
                            <textarea class="profile__coll-field field profile-comment--js" name="comment" placeholder="" disabled></textarea>
                        </label>
                    </div>
                    <input type="hidden" name="id" class="profile-id--js" value="">
                </div>
            </div>
        </div>
    </form>
</div>
</div><!-- end profile-modal -->
<?php endif; ?>

<div id="admin-modal" class="admin-modal modal" style="display: none;">
    <div class="modal__closed flex-center svg-contain" data-fancybox-close>
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5859 16L5.29297 25.2928L6.70718 26.7071L16.0001 17.4142L25.293 26.7071L26.7072 25.2928L17.4143 16L26.7072 6.70706L25.293 5.29285L16.0001 14.5857L6.70718 5.29285L5.29297 6.70706L14.5859 16Z" fill="white"/>
        </svg>
    </div>
    <div class="admin-modal__body">
        <div class="admin-modal__name"><?=$GLOBALS['user']['surname']?> <?=$GLOBALS['user']['name']?></div>
        <div class="admin-modal__value"><?=$GLOBALS['user']['permission']['name']?></div>
        <!--div class="admin-modal__desc">Подписка до 01.01.2021</div-->
        <div class="admin-modal__button">
            <a href="<?= base_url();?>/settings" class="admin-modal__btn btn btn_white">Профиль</a>
            <a href="<?= base_url();?>/auth/logout" class="admin-modal__btn btn">Выход</a>
        </div>
    </div>
</div><!-- end admin-modal -->

<div id="success-modal" class="admin-modal modal" style="display: none;">
    <div class="modal__closed flex-center svg-contain" data-fancybox-close>
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5859 16L5.29297 25.2928L6.70718 26.7071L16.0001 17.4142L25.293 26.7071L26.7072 25.2928L17.4143 16L26.7072 6.70706L25.293 5.29285L16.0001 14.5857L6.70718 5.29285L5.29297 6.70706L14.5859 16Z" fill="white"/>
        </svg>
    </div>
    <div class="admin-modal__body">
        <div class="admin-modal__name">Изменения сохранены</div>
    </div>
</div><!-- end admin-modal -->
