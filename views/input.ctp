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
	
		<?php echo $tabs;?><div class="form-group <?php echo "<?php echo (\$this->Form->isFieldError('{$field}')) ? 'has-error' : '' ?>" ?>">
			<?php echo "{$tabs}<?php echo \$this->Form->label('{$field}', null, array('class' => 'control-label col-sm-2')); ?>\n"; ?>
	<?php if (preg_match('/picture|photo|image/i', $field)): ?>
		<?php echo $tabs;?><div class="col-sm-6">
				<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('type' => 'file', 'label' => false, 'div' => false, 'class' => '' {$value})); ?>\n"; ?>
				<?php echo $tabs;?><p class="help-block">
					<?php echo $tabs;?><span class="label label-info">
						<?php echo "{$tabs}<?php echo __d('admin', 'Recommended dimensions : %d pixels wide by %d pixels high', 940, 528); ?>\n"; ?>
					<?php echo $tabs;?></span>
				<?php echo $tabs;?></p>
			<?php echo $tabs;?></div>
		
			<?php echo "{$tabs}<?php if (!empty(\$this->data['{$modelClass}']['{$field}']) && is_file('.' . \$this->data['{$modelClass}']['{$field}'])) : ?>\n"; ?>
		<?php echo $tabs;?></div>
		<?php echo $tabs;?><div class="form-group">
			<?php echo $tabs;?><div class="col-sm-6 col-sm-offset-2">
				<?php echo $tabs;?><p class="picture">
					<?php echo "{$tabs}<?php echo \$this->Html->image(\$this->data['{$modelClass}']['{$field}'], array('class' => 'img-thumbnail')); ?>\n"; ?>
					<?php echo $tabs;?><a class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></a>
				<?php echo $tabs;?></p>
			<?php echo $tabs;?></div>
			<?php echo "{$tabs}<?php endif; ?>\n"; ?>
	<?php elseif (preg_match('/file|path/i', $field)): ?>
		<?php echo $tabs;?><div class="col-sm-6">
				<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('type' => 'file', 'label' => false, 'div' => false, 'class' => '' {$value})); ?>\n"; ?>
			<?php echo $tabs;?></div>
		
			<?php echo "{$tabs}<?php if (!empty(\$this->data['{$modelClass}']['{$field}']) && is_file('.' . \$this->data['{$modelClass}']['{$field}'])) : ?>\n"; ?>
		<?php echo $tabs;?></div>
		<?php echo $tabs;?><div class="form-group">
			<?php echo $tabs;?><div class="col-sm-6 col-sm-offset-2">
				<?php echo $tabs;?><p class="picture">
					<?php echo $tabs;?><a href="<?php echo $this->data['{$modelClass}']['{$field}'];?>">Voir le fichier</a>
					<?php echo $tabs;?><a class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></a>
				<?php echo $tabs;?></p>
			<?php echo $tabs;?></div>
			<?php echo "{$tabs}<?php endif; ?>\n"; ?>
	<?php elseif (preg_match('/url/i', $field)): ?>
		<?php echo $tabs;?><div class="col-sm-4">
				<?php echo $tabs;?><div class="input-group">
					<?php echo $tabs;?><span class="input-group-addon">/</span>
					<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control' {$value})); ?>\n"; ?>
				<?php echo $tabs;?></div>
			<?php echo $tabs;?></div>
	<?php elseif (preg_match('/overage/i', $field)): ?>
		<?php echo $tabs;?><div class="col-sm-2">
				<?php echo $tabs;?><div class="input-group">
					<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control' {$value})); ?>\n"; ?>
					<?php echo $tabs;?><span class="input-group-addon">%</span>
				<?php echo $tabs;?></div>
			<?php echo $tabs;?></div>
	<?php elseif (preg_match('/price/i', $field)): ?>
		<?php echo $tabs;?><div class="col-sm-2">
				<?php echo $tabs;?><div class="input-group">
					<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control' {$value})); ?>\n"; ?>
					<?php echo $tabs;?><span class="input-group-addon">$</span>
				<?php echo $tabs;?></div>
			<?php echo $tabs;?></div>
	<?php elseif (preg_match('/weight/i', $field)): ?>
		<?php echo $tabs;?><div class="col-sm-2">
				<?php echo $tabs;?><div class="input-group">
					<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control' {$value})); ?>\n"; ?>
					<?php echo $tabs;?><span class="input-group-addon">g</span>
				<?php echo $tabs;?></div>
			<?php echo $tabs;?></div>
	<?php elseif (preg_match('/text|desc|content/i', $field)): ?>
		<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => 'col-sm-6', 'class' => 'form-control' {$value})); ?>\n"; ?>
	<?php elseif (preg_match('/time/i', $field)): ?>
		<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => 'col-sm-4 time-holder', 'class' => 'form-control', 'type' => 'time' {$value})); ?>\n"; ?>
	<?php elseif (preg_match('/date/i', $field)): ?>
		<?php echo $tabs;?><div class="col-sm-2">
				<?php echo $tabs;?><div class="input-group">
					<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => false, 'class' => 'form-control datepicker', 'type' => 'text' {$value})); ?>\n"; ?>
					<?php echo $tabs;?><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				<?php echo $tabs;?></div>
			<?php echo $tabs;?></div>
	<?php elseif (preg_match('/parent/i', $field)): ?>
		<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control', 'options' => \$parent".Inflector::pluralize($modelClass).", 'empty' => __d('admin','Choose'))); ?>\n"; ?>
	<?php else: ?>
		<?php echo "{$tabs}<?php echo \$this->Form->input('{$field}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control' {$value})); ?>\n"; ?>
	<?php endif; ?>
	<?php echo $tabs;?></div>
<?php endif ?>