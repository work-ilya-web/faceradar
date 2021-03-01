$(document).ready(function () {
	// User
	$(".user__arrow").on("click", function () {
		$(this).toggleClass("active");
		$(".user__logout").toggleClass("active");
	});
	$(document).click(function(e) {
		if (!$(e.target).is(".user *")) {
			$(".user__arrow").removeClass("active");
			$(".user__logout").removeClass("active");
		};
	});

	// Nav steps
	$(".applications__form-next, .applications__form-prev").on("click", function () {
		$(".applications__step").removeClass("active");
	});
	$(".applications__step-1 .applications__form-next").on("click", function () {
		$(".applications__step-2").addClass("active");
		$(".applications__form-nav-item-2").addClass("active");
	});
	$(".applications__step-2 .applications__form-next").on("click", function () {
		$(".applications__step-3").addClass("active");
		$(".applications__form-nav-item-3").addClass("active");
	});
	$(".applications__step-3 .applications__form-next").on("click", function () {
		$(".applications__step-4").addClass("active");
		$(".applications__form-nav-item-4").addClass("active");
	});
	$(".applications__step-4 .applications__form-next").on("click", function () {
		$(".applications__step-4").addClass("active");
	});

	$(".applications__step-4 .applications__form-prev").on("click", function () {
		$(".applications__step-3").addClass("active");
		$(".applications__form-nav-item-4").removeClass("active");
	});
	$(".applications__step-3 .applications__form-prev").on("click", function () {
		$(".applications__step-2").addClass("active");
		$(".applications__form-nav-item-3").removeClass("active");
	});
	$(".applications__step-2 .applications__form-prev").on("click", function () {
		$(".applications__step-1").addClass("active");
		$(".applications__form-nav-item-2").removeClass("active");
	});

	//counter input
	$('.input-calc._calc .minus').click(function (e) {
		e.preventDefault();
		var $input = $(this).parent().find('input');
		var count = parseFloat($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count.toFixed(0));
		$input.change();
		return false;
	});
	$('.input-calc._calc .plus').click(function (e) {
		e.preventDefault();
		var $input = $(this).parent().find('input');
		var count = parseFloat($input.val()) + 1;
		$input.val(count.toFixed(0));
		$input.change();
		return false;
	});

	//counter input time
	$('.input-calc._time .minus').click(function (e) {
		e.preventDefault();
		var $input = $(this).parent().find('input');
		var count = parseFloat($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count.toFixed(0));
		$input.change();
		return false;
	});
	$('.input-calc._time .plus').click(function (e) {
		e.preventDefault();
		var $input = $(this).parent().find('input');
		var count = parseFloat($input.val()) + 1;
		$input.val(count.toFixed(0));
		$input.change();
		return false;
	});

	//clone input
	$("a.applications__form-addInput").on("click", function (e) {
		e.preventDefault();
		$(this).before($(this).prev().clone());
	});

	$(".burger").on("click", function (event) {
		event.preventDefault();
		$(this).toggleClass("active");
		$("body").toggleClass("lock");
		$(".container__left").toggleClass("active");
	});

    // Phone mask
	$(".phone-mask").mask("+7 (999) 999-99-99");
	
	
	// Custom Select
	$('.select').on("click", function(event) {
		if(!$(this).hasClass('disabled')){
			$('.select').not(this).removeClass('active').find('.select-options').slideUp(300);
			$(this).toggleClass('active');
			$(this).find('.select-options').slideToggle(300);
		}
	});
	$('.select-options__value').click(function() {
		$(this).parents('.select').find('.select-title__value').html($(this).html());
		if($.trim($(this).data('value'))!=''){
			$(this).parents('.select').find('input').val($(this).data('value'));
		}else{
			$(this).parents('.select').find('input').val($(this).html());
		}
	});
	$(document).on("click", function(e) {
		if (!$(e.target).is(".select *")) {
			$('.select').removeClass('active');
			$('.select-options').slideUp(300);
		};
	});

	// Fancybox
	if($('.fancybox').length > 0){
		$(".fancybox").fancybox({
			loop : false,
			arrows : true,
			buttons : [
				'thumbs',
				'close'
			],
		});
	}

	// Cars
	$(function() {
		$('.cars__list').each(function() {
			$(this).find('.cars-item').each(function(i) {
				$(this).click(function(){
					$(this).addClass('active').siblings().removeClass('active').closest('.cars').find('.cars__section').removeClass('active').eq(i).addClass('active');
				});
			});
		});
	});
	$(function() {
		$('.cars-gallery-thumbs').each(function() {
			$(this).find('.cars-gallery-thumbs__item').each(function(i) {
				$(this).click(function(){
					$(this).addClass('active').siblings().removeClass('active').closest('.cars-gallery').find('.cars-gallery-images__item').removeClass('active').eq(i).addClass('active');
				});
			});
		});
	});

	// Calendar
	if($('.operator-calendar-content').length > 0){
		$('.operator-calendar-content').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.operator-calendar-mounth-slider'
		});
		$('.operator-calendar-mounth-slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			asNavFor: '.operator-calendar-content',
			fade: true,
			arrows: false,
			dots: false,
		});
		$('.operator-calendar-mounth__arrow.slick-prev').click(function(event) {
		    $(this).parents('.operator-calendar').find('.operator-calendar-mounth-slider').slick('slickPrev');
		});
		$('.operator-calendar-mounth__arrow.slick-next').click(function(event) {
		    $(this).parents('.operator-calendar').find('.operator-calendar-mounth-slider').slick('slickNext');
		});
	}

	// 
    $(".operator-board-item-route__switcher").on("click", function(event){
		$(this).hide();
		$(this).parents(".operator-board-item").find(".operator-board-item-route-item").addClass("open");
	});




















	// Modals
    $(".table-actions__delete").on("click", function(event){
		event.preventDefault();
		$.fancybox.open({
			closeExisting: true,
			src  : "#delete-modal",
			baseClass: "dark__bg",
			touch: false,
			transitionEffect: "circular",
		});
	});
	$(".delete-modal__btn").on("click", function(event){
		event.preventDefault();
		$.fancybox.open({
			closeExisting: true,
			src  : "#delete-success-modal",
			baseClass: "dark__bg",
			touch: false,
			transitionEffect: "circular",
		});
	});
	$(".table-actions__rating").on("click", function(event){
		event.preventDefault();
		$.fancybox.open({
			closeExisting: true,
			src  : "#reviews-modal",
			baseClass: "dark__bg",
			touch: false,
			transitionEffect: "circular",
		});
	});
	$(".reviews-modal__success").on("click", function(event){
		event.preventDefault();
		$.fancybox.open({
			closeExisting: true,
			src  : "#reviews-modal-thanks",
			baseClass: "dark__bg",
			touch: false,
			transitionEffect: "circular",
		});
	});

	$(".table-actions__views ").on("click", function(event){
		event.preventDefault();
		$(this).toggleClass("hide");
	});
	/*$(".btn-profile-info").on("click", function(event){
		event.preventDefault();
		$.fancybox.open({
			closeExisting: true,
			src  : "#modal-profile-info",
			baseClass: "dark__bg",
			touch: false,
			transitionEffect: "circular",
		});
	});
	$(".btn-profile-password").on("click", function(event){
		event.preventDefault();
		$.fancybox.open({
			closeExisting: true,
			src  : "#modal-profile-password",
			baseClass: "dark__bg",
			touch: false,
			transitionEffect: "circular",
		});
	});*/
	$(".btn-tariffs").on("click", function(event){
		event.preventDefault();
		$.fancybox.open({
			closeExisting: true,
			src  : "#modal-tariffs",
			baseClass: "dark__bg",
			touch: false,
			transitionEffect: "circular",
		});
	});
	$(".btn-cars").on("click", function(event){
		event.preventDefault();
		$.fancybox.open({
			closeExisting: true,
			src  : "#modal-cars",
			baseClass: "dark__bg",
			touch: false,
			transitionEffect: "circular",
		});
	});
});