
<?= $this->include('profile/common/header_view'); ?>
<div class="page-content">
<div class="clients">

	<div class="clients__top flex">
		<div class="clients__top-left">
			<a href="<?= site_url('profile/companies/add'); ?>" class=" clients__top-btn btn-item ">
                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.5 18.3333C5.89968 18.3283 2.17168 14.6003 2.16663 9.99998V9.83331C2.25824 5.25375 6.02878 1.6066 10.6089 1.66737C15.1889 1.72814 18.8614 5.47405 18.8314 10.0544C18.8015 14.6348 15.0804 18.3324 10.5 18.3333ZM6.33329 9.16664V10.8333H9.66663V14.1666H11.3333V10.8333H14.6666V9.16664H11.3333V5.83331H9.66663V9.16664H6.33329Z" fill="#383741"/>
                </svg>
                <span>добавить</span>
            </a>
		</div>
	</div>
	<div class="clients__scroll horizontal dragscroll">
		<div class="clients__table">
			<table>
				<thead>
					<tr>
						<th>
							<div class="clients__caption">ID</div>
						</th>
						<th>
							<div class="clients__caption">Название</div>
						</th>
						<th>
							<div class="clients__caption">Адрес</div>
						</th>
						<th>
							<div class="clients__caption">Изменить</div>
						</th>
						<th>
                            <div class="clients__caption">Удалить</div>
                        </th>
					</tr>
				</thead>
				<tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr class="row" data-id="<?= $item['id']; ?>">
                            <td><span><?= $item['id']; ?></span></td>
                            <td><?= $item['name']; ?></td>
                            <td><?= $item['address']; ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?= site_url('profile/companies/edit/' . $item['id'] . ''); ?>" class="edit table-actions__edit table-icon">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i> Изменить
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?= site_url('companies/delete_ajax/' . $item['id'] . ''); ?>"  data-id="<?= $item['id']; ?>" class="delete delete--js table-actions__delete table-icon">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Удалить
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

				</tbody>
			</table>
			<?php echo $pager->links(); ?>
		</div>
	</div>
</div>
</div>



<?= $this->include('profile/common/footer_view'); ?>
