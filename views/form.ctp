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

<?php
/* ******************************* READ JAGR CONFIG FILE ************************************* */
$file = ROOT . DS . 'app/Config/jagr.config.php';

$groups = array();
$ignoredFields = array('created', 'modified', 'updated');

if(file_exists($file)){
	include($file);
	include_once(ROOT . DS . 'app/Console/Templates/jagr/utils.php');
	
	// Group fields
	if(isset($jagr['form']['groups'])){
		// Prepare groups
		$groups['default'] = array(
			'label' => 'Général',
			'fields' => array()
		);
		
		foreach($jagr['form']['groups'] as $k => $v){
			$groups[Inflector::slug($v)] = array(
				'label' => $v,
				'fields' => array()
			);
		}
		
		// Map fields
		foreach($fields as $field){
			$grouped = false;
			foreach($jagr['form']['groups'] as $k => $v){
				$slug = Inflector::slug($v);
				if(preg_match("/".$k."/", $field)){
					$groups[$slug]['fields'][] = $field;
					$grouped = true;
					break 1;
				}
			}
			
			if(!$grouped) $groups['default']['fields'][] = $field;
		}
		
		// Remove empty groups
		foreach($groups as $k => $v){
			if(empty($v['fields'])) unset($groups[$k]);
		}
	}
	
	// Children models embedded
	if(isset($jagr['form']['children'])){
		if(isset($jagr['form']['children'][$modelClass])){
			$config = $jagr['form']['children'][$modelClass];
			
			if(!isset($groups)){
				$groups['default'] = array(
					'label' => 'Général',
					'fields' => $fields
				);
			}
			
			foreach($config as $children){
				$groups[Inflector::slug($children['model'])] = array(
					'label' => $children['label'],
					'fields' => array()
				);
			}
		}
	}
	
	// Ignored fields
	if(isset($jagr['input']['ignore'])){
		$ignoredFields = array_merge($jagr['input']['ignore'], $ignoredFields);
	}
}
/* ******************************* END JAGR CONFIG FILE ************************************* */
?>


<?php echo "<?php /* @var \$this View */ ?>\n"; ?>

<div class="navbar navbar-default">
	<div class="navbar-header">
		<span class="navbar-brand"><?php 
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

<?php if(sizeof($groups) > 1):?>
	
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
		<?php 
		$cpt = 0;
		foreach($groups as $k => $group):?>
	<li class="<?php if($cpt==0) echo 'active';?>"><a data-toggle="tab" href="#<?php echo $k;?>"><i class="glyphicon glyphicon-chevron-down pull-right"></i> <?php echo $group['label'];?></a></li>
		<?php $cpt++;
		endforeach;?></ul>
	</div>
	<div class="col-md-12">
		<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('class' => 'form-horizontal', 'type' => 'file')); ?>\n"; ?>
			<fieldset>
				<div class="tab-content">
					<?php 
					$cpt = 0;
					foreach($groups as $k => $group):?>
						
					<!------------------------- <?php echo strtoupper($group['label']);?> PANEL ------------------------------------->
					
					
					<div id="<?php echo $k;?>" class="tab-pane <?php if($cpt==0) echo 'active';?>">
						<?php
						// Languages separation
						$languages = array();
						if(isset($jagr['form']['languages'])){
							$languages = getLanguageFields($group['fields'], $jagr);
							$tabs =  "\t\t\t\t\t\t";
								
						foreach($languages as $l => $language):
						?><div class="block-language <?php if($l == 'default') echo 'block-language-full';?>">
							<?php if($l != 'default'):?><h3><?php echo $language['label'];?></h3><?php endif;?>
									
							<div class="row"><?php
									foreach ($language['fields'] as $field) {
										if (strpos($action, 'add') !== false && $field == $primaryKey) {
											continue;
										} else if (!in_array($field, $ignoredFields)) {
											include('input.ctp');
										}
									}
								?>
							</div>
						</div>
							
						<?php endforeach;
								
							if ($k == 'default' && !empty($associations['hasAndBelongsToMany'])) {
								foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
									echo "\n\t\t\t\t\t\t<div class=\"form-group\">\n";
										echo "\t\t\t\t\t\t\t<?php echo \$this->Form->label('{$assocName}', null, array('class' => 'control-label col-sm-2')); ?>\n";
										echo "\t\t\t\t\t\t\t<?php echo \$this->Form->input('{$assocName}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control', 'multiple' => 'checkbox')); ?>\n";
									echo "\t\t\t\t\t\t</div>\n";
								}
							}
						}else{
							$tabs =  "\t\t\t\t";
							
							foreach ($group['fields'] as $field) {
								if (strpos($action, 'add') !== false && $field == $primaryKey) {
									continue;
								} else if (!in_array($field, $ignoredFields)) {
									include('input.ctp');
								}
							}
							
							if ($k == 'default' && !empty($associations['hasAndBelongsToMany'])) {
								foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
									echo "\t\t\t\t\t\t<div class=\"form-group\">\n";
										echo "\t\t\t\t\t\t\t<?php echo \$this->Form->label('{$assocName}', null, array('class' => 'control-label col-sm-2')); ?>\n";
										echo "\t\t\t\t\t\t\t<?php echo \$this->Form->input('{$assocName}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control', 'multiple' => 'checkbox')); ?>\n";
									echo "\t\t\t\t\t\t</div>\n";
								}
							}
						}
						?>
					</div>
				<?php $cpt++;
	endforeach;?></div>
						
				<div class="form-group">
					<?php echo "<?php echo \$this->Form->submit(__d('admin', 'Submit'), array('class' => 'btn btn-primary', 'div' => array('class' => 'col-sm-offset-2 col-sm-10')));?>\n";?>
				</div>
			</fieldset>
		<?php
			echo "<?php echo \$this->Form->end(); ?>\n";
		?>
	</div>
</div>
	
<?php else:?>

<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('class' => 'form-horizontal', 'type' => 'file')); ?>\n"; ?>
	<fieldset>
	<?php
		/*foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} else if (!in_array($field, $ignoredFields)) {
				include('input.ctp');
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t<div class=\"form-group\">\n";
					echo "\t\t<?php echo \$this->Form->label('{$assocName}', null, array('class' => 'control-label col-sm-2')); ?>\n";
					echo "\t\t<?php echo \$this->Form->input('{$assocName}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control', 'multiple' => 'checkbox')); ?>\n";
				echo "\t</div>\n";
			}
		}*/
	?>
		
	<?php
		// Languages separation
		$languages = array();
		if(isset($jagr['form']['languages'])){
			$languages = getLanguageFields($fields, $jagr);
			$tabs =  "\t\t";
				
		foreach($languages as $l => $language):
		?><div class="block-language <?php if($l == 'default') echo 'block-language-full';?>">
			<?php if($l != 'default'):?><h3><?php echo $language['label'];?></h3><?php endif;?>
					
			<div class="row"><?php
					foreach ($language['fields'] as $field) {
						if (strpos($action, 'add') !== false && $field == $primaryKey) {
							continue;
						} else if (!in_array($field, $ignoredFields)) {
							include('input.ctp');
						}
					}
				?>
			</div>
		</div>
			
		<?php endforeach;
				
			if ($k == 'default' && !empty($associations['hasAndBelongsToMany'])) {
				foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
					echo "\t\t\t<div class=\"form-group\">\n";
						echo "\t\t\t\t<?php echo \$this->Form->label('{$assocName}', null, array('class' => 'control-label col-sm-2')); ?>\n";
						echo "\t\t\t\t<?php echo \$this->Form->input('{$assocName}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control', 'multiple' => 'checkbox')); ?>\n";
					echo "\t\t\t</div>\n";
				}
			}
		}else{
			$tabs =  "";
			
			foreach ($fields as $field) {
				if (strpos($action, 'add') !== false && $field == $primaryKey) {
					continue;
				} else if (!in_array($field, $ignoredFields)) {
					include('input.ctp');
				}
			}
			
			if ($k == 'default' && !empty($associations['hasAndBelongsToMany'])) {
				foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
					echo "\t<div class=\"form-group\">\n";
						echo "\t\t<?php echo \$this->Form->label('{$assocName}', null, array('class' => 'control-label col-sm-2')); ?>\n";
						echo "\t\t<?php echo \$this->Form->input('{$assocName}', array('label' => false, 'div' => 'col-sm-4', 'class' => 'form-control', 'multiple' => 'checkbox')); ?>\n";
					echo "\t</div>\n";
				}
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
<?php endif;?>