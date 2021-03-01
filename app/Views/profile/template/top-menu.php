
<?php 

if(isset($_SESSION['user'])){
    $name = $_SESSION['user']['name'];
    $surname = $_SESSION['user']['surname'];
    $group = $_SESSION['user']['group'];

    if($group == 1 || $group == 3){
        $logout = site_url('Admin/Auth/logout');
    } else {
        $logout = site_url('Auth/logout');
    }
}

print_r($breadcrumb);

?>

<div class="container__top flex">
    <div class="container__top-right flex">
        <a href="#" class="notification flex">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 16.5C8.17157 16.5 7.5 15.8284 7.5 15H10.5C10.5 15.8284 9.82843 16.5 9 16.5ZM15 14.25H3V12.75L4.5 12V7.875C4.5 5.2785 5.56575 3.59475 7.5 3.135V1.5H9.75C9.26096 2.14795 8.99754 2.93821 9 3.75C8.99997 3.93853 9.01401 4.12681 9.042 4.31325H9C8.08489 4.25398 7.20226 4.66324 6.65625 5.4C6.18941 6.13842 5.96035 7.00229 6 7.875V12.75H12V7.875C12 7.71675 11.9947 7.5645 11.9842 7.425C12.4803 7.52748 12.992 7.52927 13.4887 7.43025C13.497 7.5885 13.5 7.73925 13.5 7.88025V12L15 12.75V14.25ZM12.75 6C12.2968 6.00055 11.8541 5.86379 11.4802 5.60775C10.5966 5.00369 10.2608 3.8607 10.6774 2.87468C11.0939 1.88865 12.1474 1.33259 13.1966 1.54503C14.2457 1.75747 14.9999 2.6796 15 3.75C15 4.99264 13.9926 6 12.75 6Z" fill="#383741"/>
            </svg>
            <span>15</span>
        </a>
        <div class="user">
            <a href="#" class="user-info">
                <div class="user-info__photo"><img src="<?= base_url();?>/assets/img/content/profile/user-photo.png" alt="img"></div>
                <div class="user-info__content">
                    <div class="user-info__name"><?= $name; ?> <?= $surname; ?></div>
                    <div class="user-info__type">Физ.лицо</div>
                </div>
            </a>
            <div class="user__arrow">
                <i class="ic ic-user-arrow"></i>
            </div>
            <a href="<?= $logout; ?>" class="user__logout">Выйти</a>
        </div>
        <a href="#" class="btn-item">
            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.5 18.3333C5.89968 18.3283 2.17168 14.6003 2.16663 9.99998V9.83331C2.25824 5.25375 6.02878 1.6066 10.6089 1.66737C15.1889 1.72814 18.8614 5.47405 18.8314 10.0544C18.8015 14.6348 15.0804 18.3324 10.5 18.3333ZM6.33329 9.16664V10.8333H9.66663V14.1666H11.3333V10.8333H14.6666V9.16664H11.3333V5.83331H9.66663V9.16664H6.33329Z" fill="#383741"/>
            </svg>
            <span>создать заявку</span>
        </a>
    </div>
    <div class="breadcrumbs">
        <ul>
            <li><?= $title; ?></li>
        </ul>
    </div>
</div><!-- end container__top -->