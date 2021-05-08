
<?= $this->include('profile/common/header_view'); ?>
<div class="page-content">
	<div class="clients search">
		<div class="search__top">
			<div class="search__title title">Поиск по фото</div>
			<div class="search__subtitle">Загрузите фото для поиска по базе</div>
		</div>
		<?php //echo "<pre>"; print_r($item); echo "</pre>"; ?>
		<div class="search__body">
			<div class="search__left">
				<div class="search__box">
					<?php if (isset($img) and is_array($img)): ?>
						<div class="search__avatar img-cover">
							<img src="writable/<?=$img['url']?>" alt="">
						</div>
					<?php endif; ?>

					<form  action="/search" class="search__buttons" enctype="multipart/form-data" method="post">
						<div class="profile__coll ">
							<div class="profile__coll-caption">Загрузить фото</div>
							<label>
								<input type="file" name="face" value="" accept="image/jpeg" >
							</label>
						</div>
						<div class="profile__coll ">
	                        <div class="profile__coll-caption">Камера</div>
	                        <select class="select select-title__value select-title " name="idSource">
	                            <option value="1">1</option>
	                        </select>
	                    </div>
						<button type="submit" class="search__btn btn btn_gray">

							<div class="search__btn-caption">Искать</div>
						</button>
					</form>
				</div>
			</div>
			<div class="search__right">
			<?php if (!empty($item)): ?>
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
			                    <?php include 'row_view.php'; ?>
							</tbody>
						</table>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<?= $this->include('profile/common/footer_view'); ?>
