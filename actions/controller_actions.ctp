<?php
/**
 * Bake Template for Controller action generation.
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
 * @package       Cake.Console.Templates.default.actions
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
	
		/** ------------------------------------------------------------
	 *	Callbacks / Overrides
	 -------------------------------------------------------------- */
	
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
	}
	
	public function beforeFilter() {
		//$this->page_data['page_title'][] = __('Section title');
		
		parent::beforeFilter();
	}
	
	/** ------------------------------------------------------------
	 *	Public methods
	 -------------------------------------------------------------- */
	
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->set('<?php echo $pluralName ?>', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid %s', __('<?php echo strtolower($singularHumanName); ?>')));
		}
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->read(null, $id));
	}
	
	/** ------------------------------------------------------------
	 *	Admin methods
	 -------------------------------------------------------------- */
	
	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->set('<?php echo $pluralName ?>', $this->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid %s', __d('admin', '<?php echo strtolower($singularHumanName); ?>')));
		}
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->read(null, $id));
	}

	<?php $compact = array(); ?>
	
	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__d('admin', 'The %s has been saved', __d('admin', '<?php echo strtolower($singularHumanName); ?>')), 'alert-success');
				$this->redirect(array('action' => 'admin_index'));
<?php else: ?>
				$this->flash(__d('admin', '%s saved.', __d('admin', '<?php echo ucfirst(strtolower($currentModelName)); ?>')), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__d('admin', 'The %s could not be saved. Please, try again.', __d('admin', '<?php echo strtolower($singularHumanName); ?>')), 'alert-error');
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}

	<?php $compact = array(); ?>
	
	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid %s', __d('admin', '<?php echo strtolower($singularHumanName); ?>')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__d('admin', 'The %s has been saved', __d('admin', '<?php echo strtolower($singularHumanName); ?>')), 'alert-success');
				$this->redirect(array('action' => 'admin_index'));
<?php else: ?>
				$this->flash(__d('admin', 'The %s has been saved.', __d('admin', '<?php echo strtolower($singularHumanName); ?>')), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__d('admin', 'The %s could not be saved. Please, try again.', __d('admin', '<?php echo strtolower($singularHumanName); ?>')), 'alert-error');
<?php endif; ?>
			}
		} else {
			$this->request->data = $this-><?php echo $currentModelName; ?>->read(null, $id);
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
	}

	/**
	 * admin_delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid %s', __d('admin', '<?php echo strtolower($singularHumanName); ?>')));
		}
		if ($this-><?php echo $currentModelName; ?>->delete()) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__d('admin', '%s deleted', __d('admin', '<?php echo ucfirst(strtolower($singularHumanName)); ?>')), 'alert-success');
			$this->redirect(array('action' => 'admin_index'));
<?php else: ?>
			$this->flash(__d('admin', '%s deleted', __d('admin', '<?php echo ucfirst(strtolower($singularHumanName)); ?>')), array('action' => 'index'));
<?php endif; ?>
		}
<?php if ($wannaUseSession): ?>
		$this->Session->setFlash(__d('admin', '%s was not deleted', __d('admin', '<?php echo ucfirst(strtolower($singularHumanName)); ?>')), 
	'alert-error');
<?php else: ?>
		$this->flash(__d('admin', '%s was not deleted', __('admin', '<?php echo ucfirst(strtolower($singularHumanName)); ?>')), array('action' => 'index'));
<?php endif; ?>
		$this->redirect(array('action' => 'admin_index'));
	}
