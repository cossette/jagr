<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @var $this View
 */

$excluded_fields = '/created|updated|key|picture|text|description|keywords|legacy/';
$filtered_fields = array();
foreach ($fields as $field) {
	if (preg_match($excluded_fields, $field)) continue;
	$filtered_fields[]  = $field;
}

$fields = $filtered_fields;
?>
<?php echo "<?php /* @var \$this View */ ?>\n"; ?>

<div class="navbar">
	<div class="navbar-inner">
		<span class="brand"><?php echo "<?php echo __d('admin', '{$pluralHumanName}'); ?>\n"; ?></span>
	</div>
</div>

<div class="results">
	
	<div class="pagination">
		<ul>
			<?php
				echo "<?php\n";
				echo "\t\t\t\techo \$this->Paginator->prev('‹ ' . __d('admin', 'previous'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'prev disabled'));\n";
				echo "\t\t\t\techo \$this->Paginator->numbers(array('separator' => '', 'tag' => 'li'));\n";
				echo "\t\t\t\techo \$this->Paginator->next(__d('admin', 'next') . ' ›', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'next disabled'));\n";
				echo "\t\t\t?>\n";
			?>
			<li>
				<?php
					echo "<?php\n";
					echo "\t\t\t\t\tif (!empty(\$this->request->params['named']['limit'])) {\n";
					echo "\t\t\t\t\t\techo \$this->Paginator->link(__d('admin', 'all pages'), array('page' => '1', 'limit' => null), array('tag' => 'li', 'class' => 'next'));\n";
					echo "\t\t\t\t\t} else {\n";
					echo "\t\t\t\t\t\techo \$this->Paginator->link(__d('admin', 'all results'), array('page' => '1', 'limit' => 100000), array('tag' => 'li', 'class' => 'next'));\n";
					echo "\t\t\t\t\t}\n";
					echo "\t\t\t\t?>\n";
				?>
			</li>
		</ul>
	</div>
	
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
			<?php  
				foreach ($fields as $field):
			?>
				<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
			<?php endforeach; ?>
				<th class="actions">
					<?php echo "<?php echo \$this->Html->link('<i class=\"icon-plus icon-white\"></i> ' . __d('admin', 'Add'), array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>\n"; ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			echo "<?php
			foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
			echo "\t<tr>\n";
				foreach ($fields as $field) {
					if (preg_match($excluded_fields, $field)) continue;
					
					$isKey = false;
					if (!empty($associations['belongsTo'])) {
						foreach ($associations['belongsTo'] as $alias => $details) {
							if ($field === $details['foreignKey']) {
								$isKey = true;
								echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
								break;
							}
						}
					}
					if ($isKey !== true) {
						echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
					}
				}
			
				echo "\t\t<td class=\"actions\">\n";
				echo "\t\t\t<?php echo \$this->Html->link('<i class=\"icon-eye-open icon-white\"></i>', array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-small btn-info', 'title' => __d('admin', 'View'), 'escape' => false)); ?>\n";
			    echo "\t\t\t<?php echo \$this->Html->link('<i class=\"icon-pencil icon-white\"></i>', array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-small btn-primary', 'title' => __d('admin', 'Edit'), 'escape' => false)); ?>\n";
			    echo "\t\t\t<?php echo \$this->Form->postLink('<i class=\"icon-remove icon-white\"></i>', array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-small btn-danger', 'title' => __d('admin', 'Delete'), 'escape' => false), __d('admin', 'Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
				echo "\t\t</td>\n";
			echo "\t</tr>\n";
			
			echo "<?php endforeach; ?>\n";
			?>
		</tbody>
	</table>
	<p>
	<?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __d('admin', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>"; ?>
	</p>
	
	<div class="pagination">
		<ul>
			<?php
				echo "<?php\n";
				echo "\t\t\t\techo \$this->Paginator->prev('‹ ' . __d('admin', 'previous'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'prev disabled'));\n";
				echo "\t\t\t\techo \$this->Paginator->numbers(array('separator' => '', 'tag' => 'li'));\n";
				echo "\t\t\t\techo \$this->Paginator->next(__d('admin', 'next') . ' ›', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'next disabled'));\n";
				echo "\t\t\t?>\n";
			?>
			<li>
				<?php
					echo "<?php\n";
					echo "\t\t\t\t\tif (!empty(\$this->request->params['named']['limit'])) {\n";
					echo "\t\t\t\t\t\techo \$this->Paginator->link(__d('admin', 'all pages'), array('page' => '1', 'limit' => null), array('tag' => 'li', 'class' => 'next'));\n";
					echo "\t\t\t\t\t} else {\n";
					echo "\t\t\t\t\t\techo \$this->Paginator->link(__d('admin', 'all results'), array('page' => '1', 'limit' => 100000), array('tag' => 'li', 'class' => 'next'));\n";
					echo "\t\t\t\t\t}\n";
					echo "\t\t\t\t?>\n";
				?>
			</li>
		</ul>
	</div>
</div>