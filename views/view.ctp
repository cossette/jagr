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
?>
<?php echo "<?php /* @var \$this View */ ?>\n"; ?>

<ol class="breadcrumb">
	<?php 
		echo "\t<?php\n";
		echo "\t\t\tif (!empty(\$admin_menu)) {\n";
		echo "\t\t\tforeach (\$admin_menu as \$label => \$item):\n";
		echo "\t\t\tif (!\$item['active']) continue;\n";
		echo "\t\t?>\n";
	?>
		<li class="active">
			<?php
				echo "<?php\n";
				echo "\t\t\t\techo \$this->Html->link(\$label, array( 'controller' => \$item['items'][0]['url'], 'action' => 'index', 'admin' => true));\n";
				echo "\t\t\t?>\n";
			?>
		</li>
	<?php 
		echo "\t<?php\n";
		echo "\t\t\tendforeach;\n";
		echo "\t\t\t}\n";
		echo "\t\t?>\n";
	?>
	<li><?php echo "<?php echo __d('admin', '{$pluralHumanName}'); ?>"; ?></li>
</ol>

<table class="table table-bordered table-striped table-hover table-condensed">
	<tbody>
		<?php foreach ($fields as $field) { ?>
		
		<tr>
		<?php 
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t<th><?php echo __d('admin', '" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></th>\n";
						echo "\t\t\t<td>\n\t\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t&nbsp;\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t<th><?php echo __d('admin', '" . Inflector::humanize($field) . "'); ?></th>\n";
				
				echo "\t\t\t<td>\n";
				if (preg_match('/file|picture|photo/i', $field)) {
					echo "\t\t\t\t<?php if (!empty(\${$singularVar}['{$modelClass}']['{$field}']) && is_file('.' . \${$singularVar}['{$modelClass}']['{$field}'])): ?>\n";
					echo "\t\t\t\t\t<?php echo \$this->Html->image(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n";
					echo "\t\t\t\t<?php else: ?>\n";
					echo "\t\t\t\t\t<?php echo __d('admin', 'No image found'); ?>\n";
					echo "\t\t\t\t<?php endif; ?>\n";
				} else {
					echo "\t\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n";
				}
				echo "\t\t\t</td>\n";
			}
		?>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details): ?>
	<div class="related">
		<h3><?php echo "<?php echo __d('admin', 'Related " . Inflector::humanize($details['controller']) . "'); ?>"; ?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
		<dl>
	<?php
			foreach ($details['fields'] as $field) {
				echo "\t\t<dt><?php echo __d('admin', '" . Inflector::humanize($field) . "'); ?></dt>\n";
				echo "\t\t<dd>\n\t<?php echo \${$singularVar}['{$alias}']['{$field}']; ?>\n&nbsp;</dd>\n";
			}
	?>
		</dl>
	<?php echo "<?php endif; ?>\n"; ?>
		<div class="actions">
			<ul>
				<li><?php echo "<?php echo \$this->Html->link(__d('admin', 'Edit " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?></li>\n"; ?>
			</ul>
		</div>
	</div>
	<?php
	endforeach;
endif;
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	?>
<div class="related">
	<h3><?php echo "<?php echo __d('admin', 'Related " . $otherPluralHumanName . "'); ?>"; ?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
	<table class="table table-bordered table-striped table-hover table-condensed">
	<thead>
	<tr>
<?php
			foreach ($details['fields'] as $field) {
				echo "\t\t<th><?php echo __d('admin', '" . Inflector::humanize($field) . "'); ?></th>\n";
			}
?>
		<th class="actions">
			<?php echo "<?php echo \$this->Html->link('<i class=\"glyphicon glyphicon-plus\"></i> ' . __d('admin', 'New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>"; ?>
		</th>
	</tr>
	</thead>
	<tbody>
<?php
echo "\t<?php
		\$i = 0;
		foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
		echo "\t\t<tr>\n";
			foreach ($details['fields'] as $field) {
				echo "\t\t\t<td><?php echo \${$otherSingularVar}['{$field}']; ?></td>\n";
			}

			echo "\t\t\t<td class=\"actions\">\n";
			echo "\t\t\t\t<?php echo \$this->Html->link('<i class=\"glyphicon glyphicon-eye-open\"></i>', array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-info', 'escape' => false)); ?>\n";
			echo "\t\t\t\t<?php echo \$this->Html->link('<i class=\"glyphicon glyphicon-pencil\"></i>', array('controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-primary', 'escape' => false)); ?>\n";
			echo "\t\t\t\t<?php echo \$this->Form->postLink('<i class=\"glyphicon glyphicon-remove\"></i>', array('controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('class' => 'btn btn-danger', 'escape' => false), __d('admin', 'Are you sure you want to delete # %s?', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";

echo "\t<?php endforeach; ?>\n";
?>
	</tbody>
	</table>
<?php echo "<?php else: ?>\n\n"; ?>
	<div class="actions">
		<?php echo "<?php echo \$this->Html->link('<i class=\"glyphicon glyphicon-plus\"></i> ' . __d('admin', 'New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>"; ?>
	</div>
</div>
<?php echo "<?php endif; ?>\n\n"; ?>
<?php endforeach; ?>