<tr class="row <?=$style?>" data-id="<?= $item['id']; ?>">
    <td >
		<?php if (!empty($item['photo'])): ?>
			<div class="clients__avatar img-cover">
				<a href="<?=$url_photos?>/<?= $item['id']; ?>"><img src="<?= site_url('/writable/'.$item['photo']['url']); ?>" alt="<?= $item['name']; ?> <?= $item['surname']; ?>"></a>
			</div>
		<?php endif; ?>
		<?php if (empty($item['photo'])): ?>
			<a href="<?=$url_photos?>/<?= $item['id']; ?>/add" class=" clients__top-btn btn-item ">
                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.5 18.3333C5.89968 18.3283 2.17168 14.6003 2.16663 9.99998V9.83331C2.25824 5.25375 6.02878 1.6066 10.6089 1.66737C15.1889 1.72814 18.8614 5.47405 18.8314 10.0544C18.8015 14.6348 15.0804 18.3324 10.5 18.3333ZM6.33329 9.16664V10.8333H9.66663V14.1666H11.3333V10.8333H14.6666V9.16664H11.3333V5.83331H9.66663V9.16664H6.33329Z" fill="#383741"></path>
                </svg>
                <span>добавить</span>
            </a>
		<?php endif; ?>
	</td>
    <td class="profile--js" data-client-id="<?= $item['id']; ?>"><?= $item['name']; ?> <?= $item['surname']; ?> </td>
    <td <?=((empty($item['phone']))?'class="profile--js" data-client-id="'.$item['id'].'"':'')?>>
        <?php if (!empty($item['phone'])): ?>
            <?= $item['phone']; ?>
            <i class="fa fa-copy copy--js" data-copy="<?= $item['phone']; ?>" aria-hidden="true"></i>
        <?php endif; ?>

    </td>
    <td class="profile--js" data-client-id="<?= $item['id']; ?>"><?= $item['total_visits']; ?></td>
    <td class="profile--js" data-client-id="<?= $item['id']; ?>"><?= $item['update_at'] ?></td>
    <td>
        <div class="table-actions">
			<a href="<?= site_url('clients/delete_ajax/' . $item['id'] . ''); ?>"  data-id="<?= $item['id']; ?>" class="delete delete--js clients__delite ">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M7.11616 7.99992L2.55811 12.558L3.44199 13.4419L8.00005 8.88381L12.5581 13.4419L13.442 12.558L8.88393 7.99992L13.442 3.44187L12.5581 2.55798L8.00005 7.11604L3.44199 2.55798L2.55811 3.44187L7.11616 7.99992Z" fill="#828282"></path>
				</svg>
			</a>
        </div>
    </td>
</tr>
