<?= $this->include('profile/common/header_view'); ?>

<div class="page-content">
    <div class="info-profile">
        <div class="info-profile__top flex">
            <div class="info-profile__title title flex">
                <span><?= $title; ?></span>
            </div>
        </div>
        <form action="<?= $action; ?>" class="form form--js">
            <div class="form__row">
                <div class="form__coll">
                    <div class="form__caption">Название</div>
                    <input type="text" name="name" class="form__field field" value="<?=@$item['name']?>" >
                </div>
                <div class="form__coll">
                    <div class="form__caption">Адрес</div>
                    <input type="text" name="address" class="form__field field" value="<?=@$item['address']?>" >
                </div>

            </div>
            <div class="form__bottom">
                <input type="hidden" name="back_url" value="<?= $back_url; ?>">
                <?php if($item){ ?>
                    <input type="hidden" name="id" value="<?= $item['id']; ?>">
                <?php } ?>
                <input type="hidden" name="base_url" value="<?= $action; ?>">
                <button class="form__btn btn send--js">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$( document ).ready(function() {
    $('.form--js .send--js').click(function (e) {
        e.preventDefault();

        let form = $(this).closest('form'),
            name = form.find('input[name="name"]'),
            address = form.find('input[name="address"]');

        form.find('input.error').removeClass('active');
        form.find('.main-window__notice').remove();

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (result) {

                if (result.validation){
                    if (result.validation.name){
                        name.addClass('error');
                        name.after('<div class="main-window__notice">'+result.validation.name+'</div>');
                    }
                    if (result.validation.address){
                        address.addClass('error');
                        address.after('<div class="main-window__notice">'+result.validation.address+'</div>');
                    }
                } else {
                    $.fancybox.open({loop:!1,src:"#complited-modal",baseClass:"bg-fancybox",touch:!1});
                }

            }
        });

    });
});

</script>
<div id="complited-modal" class="complited-modal modal" style="display: none;">
    <div class="modal__closed flex-center svg-contain" data-fancybox-close>
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5859 16L5.29297 25.2928L6.70718 26.7071L16.0001 17.4142L25.293 26.7071L26.7072 25.2928L17.4143 16L26.7072 6.70706L25.293 5.29285L16.0001 14.5857L6.70718 5.29285L5.29297 6.70706L14.5859 16Z" fill="white"/>
        </svg>
    </div>
    <div class="admin-modal__body">
        <div class="complited-modal__name">Операция выполнена!</div>
        <div class="buttons flex">
            <a href="<?=$url_add?>" class="btn">Новая запись</a>
            <a href="<?=$url_list?>" class="btn">Вернуться в список записей</a>
        </div>
    </div>
</div><!-- end admin-modal -->
<?= $this->include('profile/common/footer_view'); ?>
