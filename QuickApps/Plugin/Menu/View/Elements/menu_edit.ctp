<?php $this->Layout->css('/menu/css/sortable-menu.css'); ?>
<?php $this->Layout->script('/menu/js/nestedSortable/jquery-ui-1.8.11.custom.min.js'); ?>
<?php $this->Layout->script('/menu/js/nestedSortable/jquery.ui.nestedSortable'); ?>
<?php $this->Layout->script('/system/js/json.js'); ?>

<div id="menu-sortContainer">
	<?php
		echo $this->Menu->render($links,
			array(
				'id' => 'menuLinks',
				'class' => 'sortable',
				'element' => 'Menu.menu_link_node',
				'model' => 'MenuLink',
				'force' => true
			)
		);
	?>
</div>

<?php echo $this->Form->submit(__t('Save changes'), array('id' => 'saveChanges')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('ul.sortable').nestedSortable({
			listType: 'ul',
			disableNesting: 'no-nest',
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div'
		});

		$('#saveChanges').click(function(e) {
			$('#saveChanges').val('<?php echo __t('Saving...'); ?>');
			arraied = $('ul.sortable').nestedSortable('toArray', {startDepthCount: 0});
			$.ajax({
				type: 'POST',
				url: QuickApps.settings.url,
				data: 'data[MenuLink]=' + $.toJSON(arraied),
				success: function() {
					$('#saveChanges')
					.val('<?php echo __t('Saved!'); ?>')
					.delay(6000)
					.queue(function () {
						$('#saveChanges').val("<?php echo __t('Save changes'); ?>");
					});
				}
			});
		});
	});
</script>