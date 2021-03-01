
<?= $this->include('profile/template/header'); ?>

<div class="container cities">
    <div class="container__body">
        
        <?= $this->include('profile/template/left-menu'); ?> 

        <div class="container__right">

            <?= $this->include('profile/template/top-menu'); ?>

            <div class="applications">
                <div class="applications__top flex">
                    <div class="applications__top-left">
                        <div class="title"><?= $title; ?> <span><?= ($count ? $count : '0'); ?></span></div>
                    </div>
                    <div class="applications__top-right flex">
                        <form method="get" class="applications__top-box flex">
                            <div class="applications__top-select">
                                <div class="select select_item">
                                    <div class="select-title">
                                        <div class="select-title__value">Название</div>
                                        <div class="select-title__arrow"></div>
                                    </div>
                                    <div class="select-options">
                                        <div class="select-options__value" data-value="title">
                                            <span>Название</span>
                                        </div>
                                        <div class="select-options__value" data-value="city_title">
                                            <span>Город</span>
                                        </div>
                                        <div class="select-options__value" data-value="street">
                                            <span>Улица</span>
                                        </div>
                                        <input type="hidden" name="type" value="title">
                                    </div>
                                </div>
                            </div>
                            <div class="search">
                                <button class="search__btn">
                                    <img src="<?= base_url();?>/assets/img/icons/search.svg" alt="">
                                </button>
                                <input type="text" name="search" class="search__field field" placeholder="Поиск..." <?= ($_GET['search'] ? 'value="' . $_GET['search'] . '"' : ''); ?>>
                            </div>
                        </form>
                        <a href="<?= site_url('profile/address/add'); ?>" class="applications__top-btn btn-item">
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 18.3333C5.89968 18.3283 2.17168 14.6003 2.16663 9.99998V9.83331C2.25824 5.25375 6.02878 1.6066 10.6089 1.66737C15.1889 1.72814 18.8614 5.47405 18.8314 10.0544C18.8015 14.6348 15.0804 18.3324 10.5 18.3333ZM6.33329 9.16664V10.8333H9.66663V14.1666H11.3333V10.8333H14.6666V9.16664H11.3333V5.83331H9.66663V9.16664H6.33329Z" fill="#383741"/>
                            </svg>
                            <span>добавить</span>							
                        </a>
                    </div>
                </div>
                <div class="applications__scroll horizontal dragscroll">
                    <div class="table-container">
                        <?php 
                        if($items){ ?>
                            <table>
                                <tr>
                                    <th><a href="?sort=title&sort_type=<?= ($_GET['sort'] == 'title' && $_GET['sort_type'] == 'asc' ? 'desc' : 'asc'); ?>" class="table-sort <?= ($_GET['sort'] == 'title' && $_GET['sort_type'] == 'asc' ? 'active' : ''); ?>">Название <i class="ic ic-sort"></i></a></th>
                                    <th><a href="?sort=create_at&sort_type=<?= ($_GET['sort'] == 'create_at' && $_GET['sort_type'] == 'asc' ? 'desc' : 'asc'); ?>" class="table-sort <?= ($_GET['sort'] == 'create_at' && $_GET['sort_type'] == 'asc' ? 'active' : ''); ?>">Добавлено <i class="ic ic-sort"></i></a></th>
                                    <th><a href="?sort=city_id&sort_type=<?= ($_GET['sort'] == 'city_id' && $_GET['sort_type'] == 'asc' ? 'desc' : 'asc'); ?>" class="table-sort <?= ($_GET['sort'] == 'city_id' && $_GET['sort_type'] == 'asc' ? 'active' : ''); ?>">Город <i class="ic ic-sort"></i></a></th>
                                    <th><a href="?sort=street&sort_type=<?= ($_GET['sort'] == 'street' && $_GET['sort_type'] == 'asc' ? 'desc' : 'asc'); ?>" class="table-sort <?= ($_GET['sort'] == 'street' && $_GET['sort_type'] == 'asc' ? 'active' : ''); ?>">Улица <i class="ic ic-sort"></i></a></th>
                                    <th><a href="?sort=house&sort_type=<?= ($_GET['sort'] == 'house' && $_GET['sort_type'] == 'asc' ? 'desc' : 'asc'); ?>" class="table-sort <?= ($_GET['sort'] == 'house' && $_GET['sort_type'] == 'asc' ? 'active' : ''); ?>">Дом (стр, кв, оф) <i class="ic ic-sort"></i></a></th>
                                    <th><a href="?sort=comment&sort_type=<?= ($_GET['sort'] == 'comment' && $_GET['sort_type'] == 'asc' ? 'desc' : 'asc'); ?>" class="table-sort <?= ($_GET['sort'] == 'comment' && $_GET['sort_type'] == 'asc' ? 'active' : ''); ?>">Комментарий <i class="ic ic-sort"></i></div></th>
                                    <th></th>
                                </tr>
                                <?php 
                                foreach ($items as $address) { ?>
                                    <tr data-id="<?= $address['address_id']; ?>">
                                        <td><?= $address['address_title']; ?></td>
                                        <td><?= date('d.m.Y', strtotime($address['create_at'])); ?></td>
                                        <td><?= $address['city_title']; ?></td>
                                        <td><?= $address['street']; ?></td>
                                        <td><?= $address['house']; ?>, кв/оф. <?= $address['flat']; ?></td>
                                        <td><?= $address['comment']; ?></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="<?= site_url('profile/address/edit/' . $address['address_id'] . ''); ?>" class="table-actions__edit"><i class="ic ic-edit"></i></a>
                                                <a href="#" data-title="<?= $address['address_title']; ?>" data-id="<?= $address['address_id']; ?>" class="table-actions__delete delete"><i class="ic ic-delete"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } else { ?>
                            <div class="title not__found">Ничего не найдено.</div>
                        <?php } ?>
                    </div>
                </div>
                <?php if($items){ ?>
                    <div class="applications__bottom flex-center">
                        <?= ($pager ? $pager->links('address', 'peoples_pagination') : ''); ?>
                        <form method="get" class="applications__bottom-select in-page">
                            <div class="select select_item">
                                <div class="select-title">
                                    <div class="select-title__value"><?= ($_GET['in_page'] ? $_GET['in_page'] : '10'); ?></div>
                                    <div class="select-title__arrow"></div>
                                </div>
                                <div class="select-options">
                                    <div class="select-options__value" data-value="10">
                                        <span>10</span>
                                    </div>
                                    <div class="select-options__value"  data-value="15">
                                        <span>15</span>
                                    </div>
                                    <div class="select-options__value"  data-value="20">
                                        <span>20</span>
                                    </div>
                                    <input type="hidden" name="in_page" value="10">
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

<div id="delete-modal" class="callback-modal modal" style="display: none;">
    <div class="modal__closed flex-center svg-contain" data-fancybox-close>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#383741"/>
        </svg>				
    </div>
    <div class="modal__body">
        <div class="modal__title">Подтвердите удаление</div>
        <div class="modal__subtitle">Вы действительно хотите удалить пользователя <span class="modal__name"></span></div>
        <div class="modal__buttons flex">
            <a href="#" class="modal__btn btn btn_dark" data-fancybox-close>назад</a>
            <a href="#" class="modal__btn btn delete-modal__btn modal__init">Подтвердить</a>
            <input type="hidden" name="delete_id">
            <input type="hidden" name="base_url" value="<?= site_url('Client/Address/delete_ajax'); ?>">
        </div>
    </div>
</div><!-- end delete-modal -->

<div id="delete-success-modal" class="callback-modal modal" style="display: none;">
    <div class="modal__closed flex-center svg-contain" data-fancybox-close>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#383741"/>
        </svg>				
    </div>
    <div class="modal__body">
        <div class="modal__title">Успешно удалено</div>
        <div class="modal__subtitle">Пользователь <span class="modal__name"></span> успешно удален!</div>
        <div class="modal__buttons flex">
            <a href="#" class="modal__btn btn btn_dark" data-fancybox-close>закрыть</a>
        </div>
    </div>
</div><!-- end delete-success-modal -->


<?= $this->include('profile/template/footer'); ?>