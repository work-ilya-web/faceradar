"use strict";$(".header__burger").length>0&&$(".header__burger").on("click",(function(){$("body").toggleClass("lock"),$(".aside").toggleClass("active"),$(".page-body").toggleClass("active"),$(".page-closed").toggleClass("active")})),$(".page-lock").length>0&&($(".page-lock").on("click",(function(){$("body").removeClass("lock"),$(".aside").removeClass("active"),$(".page-body").removeClass("active"),$(".page-closed").removeClass("active")})),$(".page-closed").on("click",(function(){$("body").removeClass("lock"),$(".aside").removeClass("active"),$(".page-body").removeClass("active"),$(".page-closed").removeClass("active")}))),$(".phone-mask").mask("+7 (999)999-99-99"),$(".profile--js").on("click",(function(e){e.preventDefault(),$.fancybox.open({loop:!1,src:"#profile-modal",baseClass:"bg-fancybox",touch:!1})})),$(".admin--js").on("click",(function(e){e.preventDefault(),$.fancybox.open({loop:!1,src:"#admin-modal",baseClass:"bg-fancybox",touch:!1})})),$("[data-profile]").on("click",(function(e){e.preventDefault(),$(".profile__info-tab").removeClass("active"),$(".profile__info-block").removeClass("active"),$(this).addClass("active");var s=$(this).data("profile");$('[data-profile-block="'+s+'"]').toggleClass("active")})),$(".profile__info-link").on("click",(function(e){e.preventDefault(),$(this).toggleClass("active"),$(this).parent().find(".hidden").toggleClass("visible")})),$(".select").on("click",(function(e){$(this).hasClass("disabled")||($(".select").not(this).removeClass("active").find(".select-options").slideUp(300),$(this).toggleClass("active"),$(this).find(".select-options").slideToggle(300))})),$(".select-options__value").click((function(){$(this).parents(".select").find(".select-title__value").html($(this).html()),""!=$.trim($(this).data("value"))?$(this).parents(".select").find("input").val($(this).data("value")):$(this).parents(".select").find("input").val($(this).html())})),$(document).on("click",(function(e){$(e.target).is(".select *")||($(".select").removeClass("active"),$(".select-options").slideUp(300))}));