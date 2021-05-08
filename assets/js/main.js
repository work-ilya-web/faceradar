function successShow(text) {
    $("body").append('<div class="info-success">'+text+'</div>');
    setTimeout(function(){
        $('.info-success').fadeOut();
    }, 1400);
    setTimeout(function(){
        $('.info-success').remove();
    }, 1500);
}
function errorShow(text) {
    $("body").append('<div class="info-error">'+text+'</div>');
    setTimeout(function(){
        $('.info-error').fadeOut();
    }, 1400);
    setTimeout(function(){
        $('.info-error').remove();
    }, 1500);
}
function copytext(el) {
    var $tmp = $("<textarea>");
    $("body").append($tmp);
    $tmp.val($(el).data('copy')).select();
    document.execCommand("copy");
    $tmp.remove();
    successShow('Скопировано в буфер');
}

function getStatistic(formattedDate = null, companies_id = null){

    $.ajax({
        url: '/dashboard/get_statistic',
        method: 'POST',
        data: {formattedDate:formattedDate, companies_id:companies_id},
        success: function (result) {
            if(result.success){
                $("#VisitsGrafik").html('');
                var visites = [];
                $.each( result.visites, function( key, value ) {
                    visites.push( value );
                });
                var VisitsGrafik = LightweightCharts.createChart(document.getElementById('VisitsGrafik'), {
                    height: 300
                });
                var Visits = VisitsGrafik.addLineSeries({
                    color: '#333333',
                    lineStyle: 0,
                    lineWidth: 2,
                    crosshairMarkerVisible: true,
                    crosshairMarkerRadius: 6,
                    lineType: 2,
                });
                VisitsGrafik.applyOptions({
                    handleScroll: true,
                    handleScale: false,
                });
                Visits.setData(visites);
                VisitsGrafik.timeScale().fitContent();


                if (typeof result.genders[0] !== 'undefined') {
                    $('.gender_0--js').css('width',result.genders[0].percent+'%' );
                    $('.gender_0--js').find('span').text(result.genders[0].percent+'%' );
                } else {
                    $('.gender_0--js').css('width','0%' );
                    $('.gender_0--js').find('span').text('0%' );
                }
                if (typeof result.genders[1] !== 'undefined') {
                    $('.gender_1--js').css('width',result.genders[1].percent+'%' );
                    $('.gender_1--js').find('span').text(result.genders[1].percent+'%' );
                } else {
                    $('.gender_1--js').css('width','0%' );
                    $('.gender_1--js').find('span').text('0%' );
                }
                if (typeof result.genders[2] !== 'undefined') {
                    $('.gender_2--js').css('width',result.genders[2].percent+'%' );
                    $('.gender_2--js').find('span').text(result.genders[2].percent+'%' );
                } else {
                    $('.gender_2--js').css('width','0%' );
                    $('.gender_2--js').find('span').text('0%' );
                }
                $('.attendance-new--js').css('width',result.attendance.new+'%' );
                $('.attendance-new--js').find('span').text(result.attendance.new+'%' );
                $('.attendance-old--js').css('width',result.attendance.old+'%' );
                $('.attendance-old--js').find('span').text(result.attendance.old+'%' );
            } else {
                $("#VisitsGrafik").html(result.mess);
                $('.gender_0--js').css('width','0%' );
                $('.gender_0--js').find('span').text('0%' );
                $('.gender_1--js').css('width','0%' );
                $('.gender_1--js').find('span').text('0%' );
                $('.gender_2--js').css('width','0%' );
                $('.gender_2--js').find('span').text('0%' );

                $('.attendance-new--js').css('width','0%' );
                $('.attendance-new--js').find('span').text('0%' );
                $('.attendance-old--js').css('width','0%' );
                $('.attendance-old--js').find('span').text('0%' );
            }
            setTimeout(function(){
                $('.loader').fadeOut();
            }, 100)
        }
    });
}

$(document).ready(function () {
    if($("#VisitsGrafik").length > 0){
        if($('.companies-filter--js').length > 0){
            var companies_id = $('.companies-filter--js').val();
        } else {
            var companies_id = null;
        }
        getStatistic(null, companies_id);
    }

    $('.datepicker-statistic').datepicker({
        multipleDates: true,
        onSelect: function(formattedDate, date, inst) {
            if($('.companies-filter--js').length > 0){
                var companies_id = $('.companies-filter--js').val();
            } else {
                var companies_id = null;
            }
            getStatistic(formattedDate, companies_id);
       }
    });
    $('body').on('change', '.companies-filter--js', function(){
        var date = $('.datepicker-statistic').val();
        var companies_id = $(this).val();
        if(date==''){date = null;}
        getStatistic(date, companies_id);
    });

    $('.copy--js').on('click', function(){
        copytext(this);
    });

    $(".profile-year-birth--js").mask("9999");
    $(".profile-date-birth--js").mask("99.99.9999");

    $('.input-date-birth--js .retweet--js').on('click', function(){
        $(this).parent().parent().hide();
        $('.input-year-birth--js').show();
        $('.input-year-birth--js .retweet--js').addClass('active');
    });
    $('.input-year-birth--js .retweet--js').on('click', function(){
        $(this).parent().parent().hide();
        $('.input-date-birth--js ').show();
    });





    $('body').on('click','.profile--js', function(){
        var el = $(this),
            id = el.data('client-id'),
            row =  el.closest('[data-id="'+id+'"]'),
            idField = $('.profile-id--js'),
            name = $('.profile-name--js'),
            surname = $('.profile-surname--js'),
            patronymic = $('.profile-patronymic--js'),
            sex = $('.profile-sex--js'),
            comment = $('.profile-comment--js'),
            phone = $('.profile-phone--js'),
            email = $('.profile-email--js'),
            visited = $('.profile-visited--js'),
            date_birth = $('.profile-date-birth--js'),
            year_birth = $('.profile-year-birth--js'),
            last_visited = $('.profile-last-visited--js'),
            photo = $('.profile-photo--js'),
            loader = $('.modal-loader'),
            client = null,
            url = '/clients/get_client';

        loader.show();

        if($('.guests--js').length > 0){
            url = '/guests/get_client';
        }

        row.removeClass('row_new');

        $.ajax({
            url: url,
            method: 'POST',
            data: {id:id},
            success: function (result) {
                if (result.success){
                    console.log(result);
                    client = result.client;
                    name.val(client.name);
                    surname.val(client.surname);
                    patronymic.val(client.patronymic);
                    phone.val(client.phone);
                    email.val(client.email);
                    comment.val(client.comment);
                    date_birth.val(client.date_birth);
                    year_birth.val(client.year_birth);
                    idField.val(client.id);
                    photo.attr('src',client.photo.url);
                    visited.text(client.total_visits);
                    last_visited.text(client.update_at);
                    sex.find('option[value="'+client.sex+'"]').prop('selected', true);
                    setTimeout(function(){
                        loader.fadeOut();
                    }, 100)
                } else {
                    errorShow(result.mess);
                }

            }
        });
    });


    $('.profile-form .send--js').click(function (e) {
        e.preventDefault();

        let form = $(this).closest('form');

        form.find('input.error').removeClass('active');
        form.find('.main-window__notice').remove();

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (result) {
                if(result.success){
                    successShow(result.mess);
                } else {
                    errorShow(result.mess);
                }
                console.log(result);
            }
        });

    });

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
                        errorShow(result.validation.phone);
                    }
                    if (result.validation.password){
                        errorShow(result.validation.password);
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
