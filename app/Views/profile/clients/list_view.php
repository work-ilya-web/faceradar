
<?= $this->include('profile/common/header_view'); ?>
<div class="page-content">
<div class="clients">
	<form class="flex" method="get" action="">
		<?php if (!empty($companies)): ?>
			<div>
				<div class="form__caption">Название компании</div>
				<select class="form__field field companies-filter--js" onchange="$(this).parents('form').submit();"  name="companies_id">
                    <option value="0">Не выбрано</option>
					<?php foreach ($companies as $key => $value): ?>
						<option value="<?=$value['id']?>" <?=(($_GET['companies_id']==$value['id'])?'selected':'')?>><?=$value['name']?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>

		<?php if (!$admin): ?>
			<div class="clients__top flex">
				<div class="clients__top-left">
					<a href="<?= $url_add?>" class=" clients__top-btn btn-item ">
		                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
		                    <path d="M10.5 18.3333C5.89968 18.3283 2.17168 14.6003 2.16663 9.99998V9.83331C2.25824 5.25375 6.02878 1.6066 10.6089 1.66737C15.1889 1.72814 18.8614 5.47405 18.8314 10.0544C18.8015 14.6348 15.0804 18.3324 10.5 18.3333ZM6.33329 9.16664V10.8333H9.66663V14.1666H11.3333V10.8333H14.6666V9.16664H11.3333V5.83331H9.66663V9.16664H6.33329Z" fill="#383741"/>
		                </svg>
		                <span>добавить</span>
		            </a>
				</div>
			</div>
		<?php endif; ?>

	</form>
	<?php if (count($items) > 0): ?>
		<div class="clients__scroll horizontal dragscroll">
			<div class="clients__table">
				<table>
					<thead>
						<tr>
							<th>
								<div class="clients__caption">Фото</div>
							</th>
							<th>
								<div class="clients__caption">ФИО</div>
							</th>
							<th>
								<div class="clients__caption">Телефон</div>
							</th>
							<th>
								<div class="clients__caption">Количество посещений</div>
								<a href="#" class="clients__icon img-contain">
									<img src="<?=base_url()?>/assets/img/icons/arrows.svg" alt="">
								</a>
							</th>
							<th>
								<div class="clients__caption">Последнее посещение</div>
								<a href="#" class="clients__icon img-contain">
									<img src="<?=base_url()?>/assets/img/icons/arrows.svg" alt="">
								</a>
							</th>
							<th>
	                            <div class="clients__caption">Удалить</div>
	                        </th>
						</tr>
					</thead>
					<tbody class="clients-list--js">
	                    <?php foreach ($items as $item) { ?>
	                        <?php include 'row_view.php'; ?>
	                    <?php } ?>

					</tbody>
				</table>
				<?php echo $pager->links(); ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if (count($items) == 0): ?>
		<p>Клиентов не найдено</p>
	<?php endif; ?>
</div>
</div>

<script type="text/javascript">
setInterval(function(){
	$.ajax({
		url: '/clients/get_quick_clients',
		method: 'POST',
		success: function (result) {

			$.each(result.clients,function(index,value){

				$('.row[data-id="'+value.id+'"]').remove();
				$.ajax({
				  url: '/clients/get_row/'+value.id,
				  data: {quick_show:0, style: 'row_new'},
				  method: 'POST',
				  success: function (row) {
					  $('.clients-list--js').prepend(row.html);
					  if(index == 0){
							if (!$('body').hasClass('fancybox-active')) {
							   $('.row[data-id="'+row.id+'"]').find('.profile--js').first().click();
							}
	  				  }
				  }
				});

			});
		}
	});
}, 5000);

</script>

<?= $this->include('profile/common/footer_view'); ?>
