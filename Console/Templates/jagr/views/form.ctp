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
		<div class="navbar">
			<div class="navbar-inner">
				<span class="brand"><?php 
						printf(
							"<?php echo __d('admin', '%s %s'); ?>\n", 
							trim(Inflector::humanize(
								preg_replace('/admin/i', '', $action)
							)), 
							$singularHumanName
						); 
				?></span>
			</div>
		</div>
		
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
				echo "\t<div class=\"control-group\">\n";
					echo "\t\t<?php echo \$this->Form->label('{$assocName}', null, array('class' => 'control-label')); ?>\n";
					echo "\t<div class=\"controls\">\n";
						echo "\t\t<?php echo \$this->Form->input('{$assocName}', array('label' => false, 'div' => false)); ?>\n";
					echo "\t</div>\n";
				echo "\t</div>\n";
			}
		}
?>
	</fieldset>
<?php
	echo "<?php echo \$this->Form->end(array('label' => __d('admin', 'Submit'), 'class' => 'btn btn-primary', 'div' => array('class' => 'form-actions'))); ?>\n";
?>