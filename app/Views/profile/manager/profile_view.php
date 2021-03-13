
    <?= $this->include('profile/common/header_view'); ?>

    <?php //echo "<pre>"; print_r($GLOBALS['user']); echo "</pre>"; ?>
    <div class="page-content">

        <div class="info-profile">
            <div class="info-profile__top flex">
                <div class="info-profile__title title flex">
                    <span>Здравствуйте, <?=$GLOBALS['user']['name']?></span>
                </div>
            </div>
            <form action="<?= base_url();?>/profile/profile_admin_save_ajax" class="form profile_admin_save_ajax--js">
                <div class="form__row">
                    <div class="form__coll">
                        <div class="form__caption">Имя</div>
                        <input type="text" name="name" class="form__field field" value="<?=$GLOBALS['user']['name']?>" >
                    </div>
                    <div class="form__coll">
                        <div class="form__caption">Фамилия</div>
                        <input type="text" name="surname" class="form__field field" value="<?=$GLOBALS['user']['surname']?>" >
                    </div>
                    <div class="form__coll">
                        <div class="form__caption">Email</div>
                        <input type="text" name="email" class="form__field field" value="<?=$GLOBALS['user']['email']?>" placeholder="email00@gmail.com">
                    </div>
                    <div class="form__coll ">
                        <div class="form__caption">Api ключ</div>
                        <input type="text" name="api" class="form__field field" value="<?=$GLOBALS['user']['api']?>">
                    </div>
                </div>
                <div class="form__bottom">
                    <button class="form__btn btn send--js">Сохранить</button>
                </div>
            </form>
        </div>

        <div class="info-profile">
            <div class="info-profile__top flex">
                <div class="info-profile__title title flex">
                    <span>Изменить пароль</span>
                </div>
            </div>
            <form action="<?= base_url();?>/profile/edit_password_ajax" class="form edit_password_ajax--js">
                <div class="form__row">
                    <div class="form__coll ">
                        <div class="form__caption">Новый пароль</div>
                        <input type="text" name="password" class="form__field field" >
                    </div>
                </div>
                <div class="form__row">
                    <div class="form__coll ">
                        <div class="form__caption">&nbsp;</div>
                        <button class="form__btn btn send--js">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>


    </div>


<?= $this->include('profile/common/footer_view'); ?>
