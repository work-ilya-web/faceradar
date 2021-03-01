$(document).ready(function () {
    $('.table-actions').on('click', '.delete', function(e){
        e.preventDefault();
        let title = $(this).data('title'),
            id = $(this).data('id');

        $('.modal__name').text(title);
        $('input[name="delete_id"]').val(id);
    });

    $('#delete-modal').on('click', '.modal__init', function(e){
        e.preventDefault();

        let modal = $(this).closest('.modal__body'),
            id = modal.find('input[name="delete_id"]').val(),
            base = modal.find('input[name="base_url"]').val();
        
        if(id && base){
            $.ajax({
                url: base,
                method: 'POST',
                data: {
                    id : id
                },
                success: function (result) {
                    if(result.success == true){
                        $('body').find('tr[data-id="'+id+'"]').remove();
                        $.fancybox.open({
                            closeExisting: true,
                            src  : "#delete-success-modal",
                            baseClass: "dark__bg",
                            touch: false,
                            transitionEffect: "circular",
                        });
                    }
                }
            });
        } 

    });

    // Cities add
    $('.applications__form').on('click', '.applications-save', function(e){
        e.preventDefault();

        let form = $(this).closest('form'),
            back_url = form.find('input[name="back_url"]').val(),
            base_url = form.find('input[name="base_url"]').val();
        
            form.find('input.error').removeClass('error');
            form.find('.main-window__notice').remove();

            if(base_url){
                $.ajax({
                    url: base_url,
                    method: 'POST',
                    data: form.serialize(),
                    success: function (result) {
                        if (result.validation){
                            $.each(result.validation, function(e, index) {
                                form.find('input[name="'+e+'"]').addClass('error');
                                form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                            });
                        } else {
                            if(result.success == true){
                                $.fancybox.open({
                                    closeExisting: true,
                                    src  : "#saved-modal",
                                    baseClass: "dark__bg",
                                    touch: false,
                                    transitionEffect: "circular",
                                });
                                setTimeout(function(){
                                    window.location.href = back_url;
                                }, 2000);
                            } 
                        }
                    }
                });
            } 

    });


    // In page
    $('.in-page').on('click', '.select-options__value', function(){
        let form = $(this).closest('form');
            form.submit();
    })

    // Save profile
    $('.profile').on('click', '.save-profile', function(e){
        e.preventDefault();

        let form = $(this).closest('form'),
            base_url = form.find('input[name="base_url"]').val();
        
            form.find('input.error').removeClass('error');
            form.find('.main-window__notice').remove();

            if(base_url){
                $.ajax({
                    url: base_url,
                    method: 'POST',
                    data: form.serialize(),
                    success: function (result) {
                        if (result.validation){
                            $.each(result.validation, function(e, index) {
                                form.find('input[name="'+e+'"]').addClass('error');
                                form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                            });
                        } else {
                            if(result.success == true){
                                $.fancybox.open({
                                    closeExisting: true,
                                    src  : "#modal-profile-info",
                                    baseClass: "dark__bg",
                                    touch: false,
                                    transitionEffect: "circular",
                                });
                            } 
                        }
                    }
                });
            } 

    });

    // Save password
    $('.profile').on('click', '.save-password', function(e){
        e.preventDefault();

        let form = $(this).closest('form'),
            base_url = form.find('input[name="base_url"]').val();
        
            form.find('input.error').removeClass('error');
            form.find('.main-window__notice').remove();

            if(base_url){
                $.ajax({
                    url: base_url,
                    method: 'POST',
                    data: form.serialize(),
                    success: function (result) {
                        if (result.validation){
                            $.each(result.validation, function(e, index) {
                                form.find('input[name="'+e+'"]').addClass('error');
                                form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                            });
                        } else {
                            if(result.success == true){
                                $.fancybox.open({
                                    closeExisting: true,
                                    src  : "#modal-profile-password",
                                    baseClass: "dark__bg",
                                    touch: false,
                                    transitionEffect: "circular",
                                });

                                setTimeout(function(){
                                    location.reload();
                                }, 2000);

                            } 
                        }
                    }
                });
            } 

    });

});