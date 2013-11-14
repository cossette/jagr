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
	$hidden = (isset($primaryKey) && ($field == $primaryKey)) ? true : false;
	$value = empty($value) ? '' : $value;
?>
<?php if ($hidden): ?>
	
	<?php echo "<?php echo \$this->Form->hidden('{$field}', array('label' => false, 'div' => false {$value})); ?>\n"; ?>
	
<?php else: ?>
	
	<div class="control-group <?php echo "<?php echo (\$this->Form->isFieldError('{$field}')) ? 'error' : '' ?>" ?>">
		<?php echo "<?php echo \$this->Form->label('{$field}', null, array('class' => 'control-label')); ?>\n"; ?>
		<div class="controls">
			<?php if (preg_match('/file|picture|photo|image/i', $field)): ?>
				
				<?php echo "<?php echo \$this->Form->input('{$field}', array('type' => 'file', 'label' => false, 'div' => false {$value})); ?>\n"; ?>
				<p>
					<span class="label label-info">
						<?php echo "<?php echo __d('admin', 'Recommended dimensions : %d pixels wide by %d pixels high', 940, 528); ?>\n"; ?>
					</span>
				</p>
				
				<?php echo "<?php if (!empty(\$this->data['{$modelClass}']['{$field}']) && is_file('.' . \$this->data['{$modelClass}']['{$field}'])) : ?>"; ?>
					<p class="picture">
						<?php echo "<?php echo \$this->Html->image(\$this->data['{$modelClass}']['{$field}'], array('class' => 'img-polaroid')); ?>"; ?>
						<a class="btn btn-danger"><i class="icon-white icon-remove"></i></a>
					</p>
				<?php echo "<?php endif; ?>"; ?>
				
			<?php elseif (preg_match('/url/i', $field)): ?>
				
				<div class="input-prepend">
					<span class="add-on">/</span>
					<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false {$value})); ?>\n"; ?>
				</div>
				
			<?php elseif (preg_match('/overage/i', $field)): ?>
				
				<div class="input-append">
					<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'input-small' {$value})); ?>\n"; ?>
					<span class="add-on">%</span>
				</div>
				
			<?php elseif (preg_match('/price/i', $field)): ?>
				
				<div class="input-append">
					<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'input-small' {$value})); ?>\n"; ?>
					<span class="add-on">$</span>
				</div>
				
			<?php elseif (preg_match('/weight/i', $field)): ?>
					
				<div class="input-append">
					<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'input-small' {$value})); ?>\n"; ?>
					<span class="add-on">g</span>
				</div>
					
			<?php elseif (preg_match('/parent/i', $field)): ?>
				
				<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'options' => \$parent".Inflector::pluralize($modelClass).", 'empty' => true)); ?>\n"; ?>
				
			<?php else: ?>
				
				<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false {$value})); ?>\n"; ?>
				
			<?php endif; ?>
			
		</div>
	</div>
<?php endif ?>