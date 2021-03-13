$(document).ready(function () {


    $('.login-form .main-window__btn').click(function (e) {
        e.preventDefault();

        let form = $(this).closest('form'),
            phone = form.find('input[name="phone"]'),
            password = form.find('input[name="password"]');

        form.find('input.error').removeClass('active');
        form.find('.main-window__notice').remove();

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (result) {

                if (result.validation){
                    if (result.validation.phone){
                        phone.addClass('error');
                        phone.after('<div class="main-window__notice">'+result.validation.phone+'</div>');
                    }
                    if (result.validation.password){
                        password.addClass('error');
                        password.after('<div class="main-window__notice">'+result.validation.password+'</div>');
                    }
                } else {
                    form.submit();
                }

            }
        });

    });


    $('.profile_admin_save_ajax--js .send--js').click(function (e) {
        e.preventDefault();

        var form = $(this).closest('form'),
            name = form.find('input[name="name"]'),
            surname = form.find('input[name="surname"]'),
            email = form.find('input[name="email"]'),
            api = form.find('input[name="api"]');

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
                    if (result.validation.surname){
                        surname.addClass('error');
                        surname.after('<div class="main-window__notice">'+result.validation.surname+'</div>');
                    }
                    if (result.validation.email){
                        email.addClass('error');
                        email.after('<div class="main-window__notice">'+result.validation.email+'</div>');
                    }
                    if (result.validation.api){
                        api.addClass('error');
                        api.after('<div class="main-window__notice">'+result.validation.api+'</div>');
                    }
                } else {
                    $.fancybox.open({loop:!1,src:"#success-modal",baseClass:"bg-fancybox",touch:!1});
                }

            }
        });

    });

    $('.edit_password_ajax--js .send--js').click(function (e) {
        e.preventDefault();

        var form = $(this).closest('form'),
            password = form.find('input[name="password"]');

        form.find('input.error').removeClass('active');
        form.find('.main-window__notice').remove();

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (result) {
                if (result.validation){
                    if (result.validation.password){
                        password.addClass('error');
                        password.after('<div class="main-window__notice">'+result.validation.password+'</div>');
                    }
                } else {
                    password.attr('type', 'password');
                    $.fancybox.open({loop:!1,src:"#success-modal",baseClass:"bg-fancybox",touch:!1});
                }

            }
        });

    });

    $('.delete--js').click(function (e) {
        e.preventDefault();

        var link = $(this),
            action = link.attr('href'),
            id = link.data('id'),
            row = link.parent().parent().parent();

        if(confirm("Вы действительно хотите удалить элемент?")){
            row.addClass('deleting');
            $.ajax({
                url: action,
                method: 'POST',
                success: function (result) {
                    console.log(result.success);
                    if (!result.success){
                        alert('Произошла ошибка');
                    } else {
                        setTimeout(function(){
                            row.hide();
                        }, 300);                        
                    }
                }
            });
        }



    });

    // Code repeat
    /*$('.main-window__form').on('click', '.code-new', function(e){
        e.preventDefault();

        let form = $(this).closest('.main-window__item');

        $.ajax({
            url: '/CargoTaxiCrm/Auth/code_repeat_ajax',
            method: 'POST',
            success: function (result) {
                if(result.success == true){
                    form.find('input[name="code"]').attr('placeholder', result.code_session);
                }
            }
        });

    });*/

    // Register form
    /*$('.register-form .main-window__btn').click(function (e) {
        e.preventDefault();

        let form = $(this).closest('form'),
            step = $(this).closest('.main-window__step'),
            next_step = $(this).data('next-step');

            form.find('input.error').removeClass('error');
            form.find('.main-window__notice').remove();

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize() + '&step='+step.data('step')+'',
                success: function (result) {
                    if(step.data('step') == 1){
                        if (result.validation){
                            $.each(result.validation, function(e, index) {
                                form.find('input[name="'+e+'"]').addClass('error');
                                form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                            });
                        } else {
                            $(".main-window__step").removeClass("active");
                            form.find('.main-window__step[data-step="' + next_step + '"]').addClass("active");
                        }
                    } else {
                        if (result.validation){
                            $.each(result.validation, function(e, index) {
                                form.find('input[name="'+e+'"]').addClass('error');
                                form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                            });
                        } else {
                            $('.main-window__box.code').html('<div class="main-window__caption">Код из смс</div><div class="main-window__item"><div class="main-window__box-left"><input type="text" name="code" class="main-window__field field" placeholder="'+result.code_session+'"><input type="hidden" name="step_code" value="step_code"></div><div class="main-window__box-right"><a href="#" class="main-window__link code-new">выслать код повторно</a></div></div>');
                            if(result.code_rules) {
                                $.each(result.code_rules, function(e, index) {
                                    form.find('input[name="'+e+'"]').addClass('error');
                                    form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                                });
                            } else {
                                if(result.success){
                                    window.location.href = result.success.redirect;
                                }
                            }
                        }
                    }

                }
            });

    });*/

    // Recovery form
    /*$('.recovery-form .main-window__btn').click(function (e) {
        e.preventDefault();

        let form = $(this).closest('form'),
            step = $(this).closest('.main-window__step'),
            next_step = $(this).data('next-step');

            form.find('input.error').removeClass('error');
            form.find('.main-window__notice').remove();

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize() + '&step='+step.data('step')+'',
                success: function (result) {
                    if(step.data('step') == 1){
                        if (result.validation){
                            $.each(result.validation, function(e, index) {
                                form.find('input[name="'+e+'"]').addClass('error');
                                form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                            });
                        } else {
                            $('.main-window__box.code').html('<div class="main-window__caption">Код из смс</div><div class="main-window__item"><div class="main-window__box-left"><input type="text" name="code" class="main-window__field field" placeholder="'+result.code_session+'"><input type="hidden" name="step_code" value="step_code"></div><div class="main-window__box-right"><a href="#" class="main-window__link code-new">выслать код повторно</a></div></div>');
                            if(result.code_rules){
                                $.each(result.code_rules, function(e, index) {
                                    form.find('input[name="'+e+'"]').addClass('error');
                                    form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                                });
                            } else {
                                if(result.code_success){
                                    $(".main-window__step").removeClass("active");
                                    form.find('.main-window__step[data-step="' + next_step + '"]').addClass("active");
                                }
                            }
                        }
                    } else {
                        if (result.validation){
                            $.each(result.validation, function(e, index) {
                                form.find('input[name="'+e+'"]').addClass('error');
                                form.find('input[name="'+e+'"]').after('<div class="main-window__notice">'+index+'</div>');
                            });
                        } else {
                            if(result.success){
                                window.location.href = result.success.redirect;
                            }
                        }
                    }

                }
            });

    });*/


});
