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
	
		<div class="form-group <?php echo "<?php echo (\$this->Form->isFieldError('{$field}')) ? 'has-error' : '' ?>" ?>">
			<?php echo "<?php echo \$this->Form->label('{$field}', null, array('class' => 'control-label col-sm-2')); ?>\n"; ?>
	<?php if (preg_match('/file|picture|photo|image/i', $field)): ?>
		<div class="col-sm-6">
				<?php echo "<?php echo \$this->Form->input('{$field}', array('type' => 'file', 'label' => false, 'div' => false, 'class' => '' {$value})); ?>\n"; ?>
				<p class="help-block">
					<span class="label label-info">
						<?php echo "<?php echo __d('admin', 'Recommended dimensions : %d pixels wide by %d pixels high', 940, 528); ?>\n"; ?>
					</span>
				</p>
			</div>
		
			<?php echo "<?php if (!empty(\$this->data['{$modelClass}']['{$field}']) && is_file('.' . \$this->data['{$modelClass}']['{$field}'])) : ?>\n"; ?>
		</div>
		<div class="form-group">
			<div class="col-sm-6 col-sm-offset-2">
				<p class="picture">
					<?php echo "<?php echo \$this->Html->image(\$this->data['{$modelClass}']['{$field}'], array('class' => 'img-thumbnail')); ?>\n"; ?>
					<a class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></a>
				</p>
			</div>
			<?php echo "<?php endif; ?>\n"; ?>
	<?php elseif (preg_match('/url/i', $field)): ?>
		<div class="col-sm-4">
				<div class="input-group">
					<span class="input-group-addon">/</span>
					<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control' {$value})); ?>\n"; ?>
				</div>
			</div>
	<?php elseif (preg_match('/overage/i', $field)): ?>
		<div class="col-sm-2">
				<div class="input-group">
					<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control' {$value})); ?>\n"; ?>
					<span class="input-group-addon">%</span>
				</div>
			</div>
	<?php elseif (preg_match('/price/i', $field)): ?>
		<div class="col-sm-2">
				<div class="input-group">
					<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control' {$value})); ?>\n"; ?>
					<span class="input-group-addon">$</span>
				</div>
			</div>
	<?php elseif (preg_match('/weight/i', $field)): ?>
		<div class="col-sm-2">
				<div class="input-group">
					<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control' {$value})); ?>\n"; ?>
					<span class="input-group-addon">g</span>
				</div>
			</div>
	<?php elseif (preg_match('/text|desc|content/i', $field)): ?>
		<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => 'col-sm-6', 'class' => 'form-control' {$value})); ?>\n"; ?>
	<?php elseif (preg_match('/parent/i', $field)): ?>
		<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control', 'options' => \$parent".Inflector::pluralize($modelClass).", 'empty' => __d('admin','Choose'))); ?>\n"; ?>
	<?php else: ?>
		<?php echo "<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control' {$value})); ?>\n"; ?>
	<?php endif; ?>
	</div>
<?php endif ?>