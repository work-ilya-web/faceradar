<?php
	use App\Models\CompaniesModel;
	$model = new CompaniesModel();
?>
<?= $this->include('profile/common/header_view'); ?>
<div class="page-content">
<div class="clients">

	<div class="clients__top flex">
		<div class="clients__top-left">
			<!--a href="#" class="clients__top-btn btn-item">Экспорт в excel</a-->
            <a href="<?= site_url('users/add'); ?>" class=" clients__top-btn btn-item ">
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
							<div class="clients__caption">ФИО</div>
						</th>
						<!--th>
							<div class="clients__caption">Телефон</div>
						</th -->
						<th>
							<div class="clients__caption">Email</div>
						</th>
						<th>
							<div class="clients__caption">Компания</div>
						</th>
						<th>
							<div class="clients__caption">Должность</div>
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
                    <?php foreach ($items as $user) { ?>
                        <tr data-id="<?= $user['user_id']; ?>">
                            <td><span><?= $user['user_id']; ?></span></td>
                            <td><?= $user['surname']; ?> <?= $user['user_name']; ?> <?= $user['patronymic']; ?> <i class="fa fa-copy copy--js" data-copy="<?= $user['surname']; ?> <?= $user['user_name']; ?> <?= $user['patronymic']; ?>" aria-hidden="true"></i></td>
                            <!--td><?= $user['phone']; ?></td-->
                            <td><?= $user['email']; ?> <i class="fa fa-copy copy--js" data-copy="<?= $user['email']; ?>" aria-hidden="true"></i></td>
                            <td><?= $user['company_name']?> <i class="fa fa-copy copy--js" data-copy="<?= $user['company_name']; ?>" aria-hidden="true"></i></td>
                            <td><?= $user['group_name']; ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?= site_url('users/edit/' . $user['user_id'] . ''); ?>" class="edit table-actions__edit table-icon">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i> Изменить
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?= site_url('users/delete_ajax/' . $user['user_id'] . ''); ?>"  data-id="<?= $user['user_id']; ?>" class="delete delete--js table-actions__delete table-icon">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Удалить
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

				</tbody>
			</table>
		</div>
	</div>
</div>
</div>


<?= $this->include('profile/common/footer_view'); ?>
