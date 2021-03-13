<?php
    use App\Libraries\AuthLib;
    $loginLib = new AuthLib();
?>
<aside class="aside">
    <a href="/" class="logo">F<span>aceradar</span></a>
    <div class="menu">
        <ul>
            <li>
                <a href="<?= base_url();?>/profile/main">
                    <img src="<?= base_url();?>/assets/img/aside/icon-1.svg" alt="">
                    <span>Главная</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="<?= base_url();?>/assets/img/aside/icon-2.svg" alt="">
                    <span>Поиск</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="<?= base_url();?>/assets/img/aside/icon-3.svg" alt="">
                    <span>Клиенты</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="<?= base_url();?>/assets/img/aside/icon-4.svg" alt="">
                    <span>Гости</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="<?= base_url();?>/assets/img/aside/icon-5.svg" alt="">
                    <span>Интеграции</span>
                </a>
            </li>
        </ul>
    </div>
    <?php if ($loginLib->isAdmin()): ?>
        <div class="menu">
            <ul>
                <li><strong>Администрирование:</strong></li>
                <li <?=(($menu_users)?'class="active"':'')?>>
                    <a href="<?= base_url();?>/profile/users">
                        <span><?=(($menu_users)?'>':'')?> Пользователи</span>
                    </a>
                </li>
                <li <?=(($menu_companies)?'class="active"':'')?>>
                    <a href="<?= base_url();?>/profile/companies">
                        <span><?=(($menu_companies)?'>':'')?> Компании</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</aside>
