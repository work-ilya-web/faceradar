<html>

<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/libs.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/index.css">
</head>

<body>
    <div class="page-lock"></div>

    <div class="page-closed img-contain">
        <img src="<?= base_url();?>/assets/img/icons/close-menu.svg" alt="">
    </div>
    <?= $this->include('profile/template/left-menu'); ?>


    <div class="page-body">

        <header class="header  ">
            <div class="header__burger img-contain">
                <img src="<?= base_url();?>/assets/img/icons/burger.svg" alt="">
            </div>
            <div class="header__last flex">
                <a href="#" class="header__profile">n0irizz00@gmail.com</a>
                <a href="#" class="header__exit img-contain admin--js">
                    <img src="<?= base_url();?>/assets/img/icons/exit.svg" alt="">
                </a>
            </div>
        </header>
