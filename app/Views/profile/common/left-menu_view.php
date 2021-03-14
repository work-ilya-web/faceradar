<?php
    use App\Libraries\AuthLib;
    $loginLib = new AuthLib();
?>
<aside class="aside">
    <a href="/" class="logo">F<span>aceradar</span></a>
    <div class="menu">
        <ul>
            <?php if ($loginLib->isManager() OR $loginLib->isAdmin()): ?>
                <li>
                    <a href="<?= base_url();?>/dashboard">
                        <img src="<?= base_url();?>/assets/img/aside/icon-1.svg" alt="">
                        <span>Главная</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url();?>/search">
                        <img src="<?= base_url();?>/assets/img/aside/icon-2.svg" alt="">
                        <span>Поиск</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($loginLib->isManager() OR $loginLib->isAdmin() ): ?>
                <li>
                    <a href="<?= base_url();?>/clients">
                        <img src="<?= base_url();?>/assets/img/aside/icon-3.svg" alt="">
                        <span>Клиенты</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($loginLib->isReception() ): ?>
                <li>
                    <a href="<?= base_url();?>/guests">
                        <img src="<?= base_url();?>/assets/img/aside/icon-4.svg" alt="">
                        <span>Гости</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($loginLib->isAdmin() ): ?>
            <li>
                <a href="<?= base_url();?>/settings">
                    <img src="<?= base_url();?>/assets/img/aside/icon-5.svg" alt="">
                    <span>Интеграции</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php if ($loginLib->isAdmin()): ?>
        <div class="menu">
            <ul>
                <li <?=(($menu_users)?'class="active"':'')?>>
                    <a href="<?= base_url();?>/users">
                        <i class="fa fa-address-book-o" aria-hidden="true"></i>
                        <span><?=(($menu_users)?'>':'')?> Пользователи</span>
                    </a>
                </li>
                <li <?=(($menu_companies)?'class="active"':'')?>>
                    <a href="<?= base_url();?>/companies">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                        <span><?=(($menu_companies)?'>':'')?> Компании</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
    <?php if ($loginLib->isManager()): ?>
        <div class="menu">
            <ul>
                <li <?=(($menu_users)?'class="active"':'')?>>
                    <a href="<?= base_url();?>/receptions">
                        <i class="fa fa-address-book-o" aria-hidden="true"></i>
                        <span>Рецепшн</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</aside>
