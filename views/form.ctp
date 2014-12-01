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
<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('class' => 'form-horizontal', 'type' => 'file')); ?>\n"; ?>
	<fieldset>
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
		
	<?php
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} else if (!in_array($field, array('created', 'modified', 'updated'))) {
				include('input.ctp');
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t<div class=\"form-group\">\n";
					echo "\t\t<?php echo \$this->Form->label('{$assocName}', null, array('class' => 'control-label col-sm-2')); ?>\n";
					echo "\t\t<?php echo \$this->Form->input('{$assocName}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control')); ?>\n";
				echo "\t</div>\n";
			}
		}
	?>
		
		<div class="form-group">
			<?php echo "<?php echo \$this->Form->submit(__d('admin', 'Submit'), array('class' => 'btn btn-primary', 'div' => array('class' => 'col-sm-offset-2 col-sm-10')));?>\n";?>
		</div>
	</fieldset>
<?php
	echo "<?php echo \$this->Form->end(); ?>\n";
?>