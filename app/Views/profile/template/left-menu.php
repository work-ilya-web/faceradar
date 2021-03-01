
<?php 

$segments = current_url(true)->getSegments();
$group = $_SESSION['user']['group'];

?>


<div class="container__mobile">
    <a href="#" class="logo img-conain">
        <img src="<?= base_url();?>/assets/img/icons/logo.svg" alt="">
    </a>
    <div class="burger">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<div class="container__left">
    <a href="<?= site_url('profile'); ?>" class="logo img-conain">
        <img src="<?= base_url();?>/assets/img/icons/logo.svg" alt="">
    </a>
    
    <div class="menu">
        <ul>
            <li <?= (end($segments) == 'profile' ? 'class="active"' : ''); ?>>
                <a href="<?= site_url('profile'); ?>">
                    <img src="<?= base_url();?>/assets/img/icons/menu-icon-1.svg" alt="">
                    <span>Профиль</span>
                </a>
            </li>
            <?php if($group == 1){ ?>
                <li <?= (in_array('cities', $segments) ? 'class="active"' : ''); ?>>
                    <a href="<?= site_url('profile/cities'); ?>">
                        <img src="<?= base_url();?>/assets/img/icons/menu-icon-2.svg" alt="">
                        <span>Города</span>
                    </a>
                </li>
                <li <?= (in_array('users', $segments) ? 'class="active"' : ''); ?>>
                    <a href="<?= site_url('profile/users'); ?>">
                        <img src="<?= base_url();?>/assets/img/icons/menu-icon-2.svg" alt="">
                        <span>Список клиентов</span>
                    </a>
                </li>
                <li <?= (in_array('users-main', $segments) ? 'class="active"' : ''); ?>>
                    <a href="<?= site_url('profile/users-main'); ?>">
                        <img src="<?= base_url();?>/assets/img/icons/menu-icon-2.svg" alt="">
                        <span>Список админов/операторов</span>
                    </a>
                </li>
            <?php } ?>


            <?php if($group == 2){ ?>
                <li <?= (in_array('address', $segments) ? 'class="active"' : ''); ?>>
                    <a href="<?= site_url('profile/address'); ?>">
                        <img src="<?= base_url();?>/assets/img/icons/menu-icon-2.svg" alt="">
                        <span>Адреса</span>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>