
<?php

$segments = current_url(true)->getSegments();
$group = $_SESSION['user']['group'];

?>
<aside class="aside">
    <a href="/" class="logo">F<span>aceradar</span></a>
    <div class="menu">
        <ul>
            <li>
                <a href="#">
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
</aside>
