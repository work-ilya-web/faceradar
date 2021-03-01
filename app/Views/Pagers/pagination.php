
<?php $pager->setSurroundCount(2); ?>

<?php if($pager && ($pager->hasPreviousPage() || $pager->hasNextPage())){ ?>
<nav class="navigation pagination" role="navigation">
	<div class="nav-links">
		<?php if ($pager->hasPrevious()){ ?>
			<a class="prew page-numbers" href="<?= $pager->getPrevious(); ?>">
				<i>
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M10 13L5 8L10 3" stroke="#A7B3C1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>											
				</i>
			</a>
		<?php } ?>

		<?php foreach ($pager->links() as $link){ ?>
			<<?= $link['active'] ? 'span' : 'a' ?> class="page-numbers <?= $link['active'] ? 'current' : '' ?>" href="<?= $link['uri'] ?>"><span class="meta-nav screen-reader-text"></span><?= $link['title'] ?></<?= $link['active'] ? 'span' : 'a' ?>>
		<?php } ?>


		<?php if ($pager->hasNext()){ ?>
			<a class="next page-numbers" href="<?= $pager->getNext(); ?>">
				<i>
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M6 3L11 8L6 13" stroke="#A7B3C1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>											
				</i>
			</a>
		<?php } ?>
	</div>
</nav>
<?php } ?>