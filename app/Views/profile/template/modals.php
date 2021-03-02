<div id="profile-modal" class="profile-modal profile modal" style="display: none;">
<div class="modal__closed flex-center svg-contain" data-fancybox-close>
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5859 16L5.29297 25.2928L6.70718 26.7071L16.0001 17.4142L25.293 26.7071L26.7072 25.2928L17.4143 16L26.7072 6.70706L25.293 5.29285L16.0001 14.5857L6.70718 5.29285L5.29297 6.70706L14.5859 16Z" fill="white"/>
    </svg>
</div>
<div class="modal__body">
    <div class="profile__top">
        <a href="#" class="profile__title flex">
            <span>Ефимов Антон</span>
            <div class="profile__title-icon img-contain">
                <img src="img/profile/edit.svg" alt="">
            </div>
        </a>
    </div>
    <div class="profile__wrap">
        <div class="profile__left">
            <div class="profile__img img-cover">
                <img src="img/profile/img.jpg" alt="">
            </div>
            <div class="profile__items">
                <div class="profile__item">
                    <div class="profile__item-caption">Количество посещений:</div>
                    <div class="profile__item-value">53</div>
                </div>
                <div class="profile__item">
                    <div class="profile__item-caption">Последнее посещение:</div>
                    <div class="profile__item-value">Неделю назад</div>
                </div>
            </div>
        </div>
        <div class="profile__right">
            <form action="#" class="profile__row">
                <div class="profile__coll profile__coll_small">
                    <div class="profile__coll-caption">Дата рождения</div>
                    <label class="profile__coll-label">
                        <div class="profile__coll-icon img-contain">
                            <img src="img/profile/calendar.svg" alt="">
                        </div>
                        <input type="text" name="text" class="profile__coll-field field datepicker-here" value="01.01.1980">
                    </label>
                </div>
                <div class="profile__coll profile__coll_small">
                    <div class="profile__coll-caption">Пол</div>
                    <div class="select">
                        <div class="select-title">
                            <div class="select-title__value">Мужской</div>
                            <div class="select-title__arrow"></div>
                        </div>
                        <div class="select-options">
                            <div class="select-options__value">
                                <span>Мужской</span>
                            </div>
                            <div class="select-options__value">
                                <span>Женский</span>
                            </div>
                            <input type="hidden" name="type" value="Мужской">
                        </div>
                    </div>
                    </label>
                </div>
                <div class="profile__coll">
                    <div class="profile__coll-caption">Телефон</div>
                    <label class="profile__coll-label">
                        <input type="text" name="text" class="profile__coll-field field phone-mask" value="+7 (902) 430-93-86">
                    </label>
                </div>
                <div class="profile__coll">
                    <div class="profile__coll-caption">Комментарий к пользователю</div>
                    <label class="profile__coll-label">
                        <textarea class="profile__coll-field field" placeholder="Немного грубоват, но платит чаевые."></textarea>
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>
</div><!-- end profile-modal -->

<div id="admin-modal" class="admin-modal modal" style="display: none;">
<div class="modal__closed flex-center svg-contain" data-fancybox-close>
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5859 16L5.29297 25.2928L6.70718 26.7071L16.0001 17.4142L25.293 26.7071L26.7072 25.2928L17.4143 16L26.7072 6.70706L25.293 5.29285L16.0001 14.5857L6.70718 5.29285L5.29297 6.70706L14.5859 16Z" fill="white"/>
    </svg>
</div>
<div class="admin-modal__body">
    <div class="admin-modal__img img-cover">
        <img src="img/admin/img.png" alt="">
    </div>
    <div class="admin-modal__name">Петров Андрей</div>
    <div class="admin-modal__value">Администратор</div>
    <div class="admin-modal__desc">Подписка до 01.01.2021</div>
    <div class="admin-modal__button">
        <a href="#" class="admin-modal__btn btn btn_white">Профиль</a>
        <a href="#" class="admin-modal__btn btn btn_white">Создать пользователя</a>
        <a href="#" class="admin-modal__btn btn">Выход</a>
    </div>
</div>
</div><!-- end admin-modal -->
