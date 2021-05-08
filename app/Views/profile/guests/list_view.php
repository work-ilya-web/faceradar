
<?= $this->include('profile/common/header_view'); ?>
<div class="page-content guests--js">
<div class="clients ">

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
		url: '/guests/get_quick_clients',
		method: 'POST',
		success: function (result) {

			$.each(result.clients,function(index,value){

				$('.row[data-id="'+value.id+'"]').remove();
				$.ajax({
				  url: '/guests/get_row/'+value.id,
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
