<?php
/**
 * Model template file.
 *
 * Used by bake to create new Model files.
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
 * @package       Cake.Console.Templates.default.classes
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

echo "<?php\n";
echo "App::uses('{$plugin}AppModel', '{$pluginPath}Model');\n";
?>
/**
 * <?php echo $name ?> Model
 *
<?php
foreach (array('hasOne', 'belongsTo', 'hasMany', 'hasAndBelongsToMany') as $assocType) {
	if (!empty($associations[$assocType])) {
		foreach ($associations[$assocType] as $relation) {
			echo " * @property {$relation['className']} \${$relation['alias']}\n";
		}
	}
}
?>
 */
class <?php echo $name ?> extends <?php echo $plugin; ?>AppModel {

	/** 
	 *  Default Containable to all models
	 */
	public $actsAs = array('Containable');

<?php if ($useDbConfig != 'default'): ?>
	/**
	 * Use database config
	 *
	 * @var string
	 */
	public $useDbConfig = '<?php echo $useDbConfig; ?>';

<?php endif;

if ($useTable && $useTable !== Inflector::tableize($name)):
    $table = "'$useTable'";
    echo "\t/**\n\t * Use table\n\t *\n\t * @var mixed False or table name\n\t */\n";
    echo "\tpublic \$useTable = $table;\n\n";
endif;

if ($primaryKey !== 'id'): ?>
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = '<?php echo $primaryKey; ?>';

<?php endif;

if (!$displayField && !empty($modelFields)) {
	// Search for a display field in these keywords
	$search_for = array('name', 'title', 'name_fr', 'name_en', 'title_fr', 'title_en');
	
	// Loop through search terms
	foreach($search_for as $search) {
		$key = array_search($search, $modelFields);
		
		// If field found, use immediately as display field
		if ($key !== FALSE) {
			if(preg_match('/_fr$|_en$/', $search)){
				// Auto remove suffix from display field, because of virtual field
				$displayField = str_replace(array('_en', '_fr'), '', $search);
			}else{
				$displayField = $search;
			}
			break;
		}
	}
}

$hasAttachment = false;
if (!empty($modelFields)){
	$search_for = array('order', 'visible', 'image', 'file', 'path', 'active');
	
	foreach($search_for as $search) {
		$key = array_search($search, $modelFields);
		
		// If field found, use immediately as display field
		if ($key !== FALSE) :
			if($search == 'order'): ?>
				
	/**
	 * Default order
	 *
	 * @var array
	 */
	public $order= array('<?php echo "{$name}.order" ?>' => 'ASC');
				
			<?php elseif($search == 'visible' || $search == 'active'): ?>
				
	/**
	 * Default conditions
	 *
	 * @var array
	 */
	public $defaultConditions= array('<?php echo "{$name}.{$search}" ?>' => 1);
				
			<?php else : 
				if($hasAttachment) continue;
				$hasAttachment = true;?>
				
	/**
	 * Attachment path
	 *
	 * @var array
	 */
	public $attachmentPath = '/data/images/<?php echo $name ?>/';

			<?php endif;
		endif;
	}
}

if ($displayField): ?>
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = '<?php echo $displayField; ?>';

<?php endif;

?>
	
	/**
	 * Virtual fields
	 *
	 * @var array
	 */
	public $virtualFields = array();
	
	/**
	 * Attributes supported in mass assignment
	 *
	 * @var array
	 */
	public $attrAccessible = array();
	
<?php

if (!empty($validate)):
	echo "\t/**\n\t * Validation rules\n\t *\n\t * @var array\n\t */\n";
	echo "\tpublic \$validate = array(\n";
	foreach ($validate as $field => $validations):
		echo "\t\t'$field' => array(\n";
		foreach ($validations as $key => $validator):
			echo "\t\t\t'$key' => array(\n";
			echo "\t\t\t\t'rule' => array('$validator'),\n";
			echo "\t\t\t\t//'message' => 'Your custom message here',\n";
			echo "\t\t\t\t//'allowEmpty' => false,\n";
			echo "\t\t\t\t//'required' => false,\n";
			echo "\t\t\t\t//'last' => false, // Stop validation after this rule\n";
			echo "\t\t\t\t//'on' => 'create', // Limit validation to 'create' or 'update' operations\n";
			echo "\t\t\t),\n";
		endforeach;
		echo "\t\t),\n";
	endforeach;
	echo "\t);\n";
endif;

foreach ($associations as $assoc):
	if (!empty($assoc)):
?>

	//The Associations below have been created with all possible keys, those that are not needed can be removed
<?php
		break;
	endif;
endforeach;

foreach (array('hasOne', 'belongsTo') as $assocType):
	if (!empty($associations[$assocType])):
		$typeCount = count($associations[$assocType]);
		echo "\n\t/**\n\t * $assocType associations\n\t *\n\t * @var array\n\t */";
		echo "\n\tpublic \$$assocType = array(";
		foreach ($associations[$assocType] as $i => $relation):
			$out = "\n\t\t'{$relation['alias']}' => array(\n";
			$out .= "\t\t\t'className' => '{$relation['className']}',\n";
			$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
			$out .= "\t\t\t'conditions' => '',\n";
			$out .= "\t\t\t'fields' => '',\n";
			$out .= "\t\t\t'order' => ''\n";
			$out .= "\t\t)";
			if ($i + 1 < $typeCount) {
				$out .= ",";
			}
			echo $out;
		endforeach;
		echo "\n\t);\n";
	endif;
endforeach;

if (!empty($associations['hasMany'])):
	$belongsToCount = count($associations['hasMany']);
	echo "\n\t/**\n\t * hasMany associations\n\t *\n\t * @var array\n\t */";
	echo "\n\tpublic \$hasMany = array(";
	foreach ($associations['hasMany'] as $i => $relation):
		$out = "\n\t\t'{$relation['alias']}' => array(\n";
		$out .= "\t\t\t'className' => '{$relation['className']}',\n";
		$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
		$out .= "\t\t\t'dependent' => false,\n";
		$out .= "\t\t\t'conditions' => '',\n";
		$out .= "\t\t\t'fields' => '',\n";
		$out .= "\t\t\t'order' => '',\n";
		$out .= "\t\t\t'limit' => '',\n";
		$out .= "\t\t\t'offset' => '',\n";
		$out .= "\t\t\t'exclusive' => '',\n";
		$out .= "\t\t\t'finderQuery' => '',\n";
		$out .= "\t\t\t'counterQuery' => ''\n";
		$out .= "\t\t)";
		if ($i + 1 < $belongsToCount) {
			$out .= ",";
		}
		echo $out;
	endforeach;
	echo "\n\t);\n\n";
endif;

if (!empty($associations['hasAndBelongsToMany'])):
	$habtmCount = count($associations['hasAndBelongsToMany']);
	echo "\n\t/**\n\t * hasAndBelongsToMany associations\n\t *\n\t * @var array\n\t */";
	echo "\n\tpublic \$hasAndBelongsToMany = array(";
	foreach ($associations['hasAndBelongsToMany'] as $i => $relation):
		$out = "\n\t\t'{$relation['alias']}' => array(\n";
		$out .= "\t\t\t'className' => '{$relation['className']}',\n";
		$out .= "\t\t\t'joinTable' => '{$relation['joinTable']}',\n";
		$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
		$out .= "\t\t\t'associationForeignKey' => '{$relation['associationForeignKey']}',\n";
		$out .= "\t\t\t'unique' => 'keepExisting',\n";
		$out .= "\t\t\t'conditions' => '',\n";
		$out .= "\t\t\t'fields' => '',\n";
		$out .= "\t\t\t'order' => '',\n";
		$out .= "\t\t\t'limit' => '',\n";
		$out .= "\t\t\t'offset' => '',\n";
		$out .= "\t\t\t'finderQuery' => '',\n";
		$out .= "\t\t\t'deleteQuery' => '',\n";
		$out .= "\t\t\t'insertQuery' => ''\n";
		$out .= "\t\t)";
		if ($i + 1 < $habtmCount) {
			$out .= ",";
		}
		echo $out;
	endforeach;
	echo "\n\t);\n\n";
endif;
?>
	
	public function __construct($id = false, $table = null, $ds = null) {
	<?php if (!empty($modelFields)){
		$search_for = array('order', 'image', 'file', 'path');
		
		foreach($search_for as $search) {
			$key = array_search($search, $modelFields);
			
			// If field found, use immediately as display field
			if ($key !== FALSE) :
				switch($search):
					case 'order': ?>
						
		$this->actsAs['Ordered'] =  array(
			'field' => 'order',
			'foreign_key' 	=> ''
		);
				
					<?php break;
					default: ?>
						
		$this->actsAs['Uploader.Attachment'] = array(
			'path' => array(
				'name'		=> 'format_file_name',
				'uploadDir'	=> ltrim($this->attachmentPath, '/'),
				'dbColumn'	=> '<?php echo $search;?>',
				'saveAsFilename' => true
			),
		);
						
				<?php break;
				endswitch;
			endif;
		}
	}?>

		parent::__construct($id, $table, $ds);
		
<?php
// Add virtual fields for i18n fields (_en & _fr)
if (!empty($modelFields)):
	$fields_no_suffix = array();
	$attachmentFields = array('image', 'file', 'path');
	
	$out = "";
	foreach ($modelFields as $field):
		$field_no_suffix = preg_replace('/_(fr|en)/', '', $field);
		
		if (preg_match('/_(fr|en)/', $field) && !in_array($field_no_suffix, $fields_no_suffix)):
			$out .= "\t\t\$this->virtualFields['{$field_no_suffix}'] = \"{\$this->alias}.{$field_no_suffix}_{\$this->language}\";\n";
			
			$fields_no_suffix[] = $field_no_suffix;
		endif;
	
		if(in_array($field, $attachmentFields)):
			$out .= "\t\t\$this->virtualFields['{$field}'] = \"(IF({\$this->alias}.{$field} LIKE 'http%', {\$this->alias}.{$field}, CONCAT('{\$this->attachmentPath}', {\$this->alias}.{$field})))\";\n";
		endif;
		
	endforeach;
	
	echo $out;
endif;
?>
		
	}


	/** ------------------------------------------------------------
	 *    Callbacks
	-------------------------------------------------------------- */


	public function beforeSave($options = array()) {
		<?php 
		$fields_no_suffix = array();
		foreach($modelFields as $field):
			$field_no_suffix = preg_replace('/_(fr|en)/', '', $field);
			if(preg_match('/price/', $field) && !in_array($field_no_suffix, $fields_no_suffix)): ?>
// Convert price to cents
		if (!empty($this->data[$this->alias]['<?php echo $field_no_suffix;?>'])) {
			$this->data[$this->alias]['<?php echo $field_no_suffix;?>'] = $this->convertToCents($this->data[$this->alias]['<?php echo $field_no_suffix;?>']);
		}
				<?php $fields_no_suffix[] = $field_no_suffix;
			endif;
		endforeach;?>

		return parent::beforeSave($options);
	}
	
	public function afterSave($created, $options = array()){
	
		parent::afterSave($created, $options);
	}

	
	public function afterFind($results, $primary = false) {
		<?php 
		$fields_no_suffix = array();
		$out = "";
		foreach($modelFields as $field):
			$field_no_suffix = preg_replace('/_(fr|en)/', '', $field);
			if(preg_match('/price/', $field) && !in_array($field_no_suffix, $fields_no_suffix)):
		$out .= "\t// Convert price back to dollars
		\t\$resultsArray[\$k][\$this->alias]['{$field_no_suffix}'] = CakeNumber::format(
		\t\t\$result[\$this->alias]['{$field_no_suffix}']/100,
		\t\tarray('before' => '', 'places' => 2, 'decimals' => '.', 'thousands' => ' ')
		\t);\n";
				
				$fields_no_suffix[] = $field_no_suffix;
			endif;
		endforeach;?><?php if(!empty($out)): ?>
$results = $this->prepareAfterFind($results);
	
		foreach ($results as $k => $result) {
		<?php echo $out;?>
		}
		<?php else : ?>
/*$results = $this->prepareAfterFind($results);
			
		foreach ($results as $k => $result) {
			
		}*/
		<?php endif;?>

		return parent::afterFind($results, $primary);
	}


	/** ------------------------------------------------------------
	 *    Functions
	-------------------------------------------------------------- */

}