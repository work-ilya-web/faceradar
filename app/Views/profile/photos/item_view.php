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
                <?php foreach ($fields as $name => $input): ?>
                    <?php if ($input['type']=='text'): ?>
                        <div class="form__coll">
                            <div class="form__caption"><?=$input['title']?></div>
                            <input type="text" name="<?=$name?>" class="form__field field" value="<?=@$item[$name]?>" >
                        </div>
                    <?php endif; ?>
                    <?php if ($input['type']=='file'): ?>
                        <div class="form__coll">
                            <div class="form__caption"><?=$input['title']?></div>
                            <input type="file" name="<?=$name?>" class="form__field field" value="<?=@$item[$name]?>"  <?=$input['accept']?>>
                        </div>
                    <?php endif; ?>
                    <?php if ($input['type']=='select'): ?>
                        <div class="form__coll">
                            <div class="form__caption"><?=$input['title']?></div>
                            <select class="form__field field" name="<?=$name?>">
                                <?php foreach ($input['options'] as $val => $text): ?>
                                    <option value="<?=$val?>"><?=$text?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="form__coll">
                        <div class="form__caption">Клиент</div>
                        <input type="text" class="form__field field" value="<?=@$client['name']?> <?=@$client['surname']?> ID: <?=@$client['id']?>" readonly  >
                    </div>
                <?php endforeach; ?>



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
            file = form.find('input[name="url"]');

        form.find('input.error').removeClass('active');
        form.find('.main-window__notice').remove();

        var formData = new FormData();
        jQuery.each($('input[type="file"]')[0].files, function(i, file) {
    		formData.append('file', file);
    	});

    

        $.ajax({
            url: form.attr('action'),
            type: "POST",
    		dataType : "json",
    		cache: false,
    		contentType: false,
    		processData: false,
    		data: formData,
            success: function (result) {
                console.log(result);
                if (result.validation){
                    if (result.validation.file){
                        file.addClass('error');
                        file.after('<div class="main-window__notice">'+result.validation.file+'</div>');
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
