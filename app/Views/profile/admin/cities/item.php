
<?= $this->include('profile/template/header'); ?>


<div class="container cities">
    <div class="container__body">
        
        <?= $this->include('profile/template/left-menu'); ?> 

        <div class="container__right">

            <?= $this->include('profile/template/top-menu'); ?>

            <div class="applications">
                <div class="applications__top flex">
                    <div class="applications__top-left">
                        <div class="title"><?= $title; ?></div>
                    </div>
                </div>
                <div class="applications__scroll horizontal dragscroll">
                    <form method="post" class="applications__form">
                        <div class="applications__form-two">
                            <div class="applications__form-item">
                                <p>название</p>
                                <input type="text" name="city" placeholder="Город" class="field" value="<?= $city['title']; ?>">
                            </div>
                            <div class="applications__form-item">
                                <p>Статус</p>
                                <div class="select select_item">
                                    <div class="select-title">
                                        <div class="select-title__value"><?= ($city['status'] == 1 ? 'Активный' : 'Не активный'); ?></div>
                                        <div class="select-title__arrow"></div>
                                    </div>
                                    <div class="select-options">
                                        <div class="select-options__value" data-value="1">
                                            <span>Активный</span>
                                        </div>
                                        <div class="select-options__value" data-value="2">
                                            <span>Не активный</span>
                                        </div>
                                        <input type="hidden" name="status" value="<?= ($city['status'] == 1 ? 1 : 2); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="applications__form-btn">
                            <a href="<?= $back_url; ?>" class="btn-item btn-item--big">назад</a>
                            <input type="submit" value="сохранить" class="btn-item btn-item--big applications-save">
                            <input type="hidden" name="back_url" value="<?= $back_url; ?>">
                            <?php if($city){ ?>
                                <input type="hidden" name="city_id" value="<?= $city['id']; ?>">
                            <?php } ?>
                            <input type="hidden" name="base_url" value="<?= $action; ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="saved-modal" class="callback-modal modal" style="display: none;">
    <div class="modal__closed flex-center svg-contain" data-fancybox-close>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#383741"/>
        </svg>
    </div>
    <div class="modal__body">
        <div class="modal__title">Успешно сохранено</div>
        <div class="modal__subtitle">Город <span class="modal__name"></span> успешно сохранен!</div>
        <div class="modal__buttons flex">
            <a href="<?= $back_url; ?>" class="modal__btn btn btn_dark" data-fancybox-close>закрыть</a>
        </div>
    </div>
</div><!-- end saved-modal -->

<?= $this->include('profile/template/footer'); ?>