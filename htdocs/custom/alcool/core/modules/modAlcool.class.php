<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) <2018> jamelbaz.com <jamelbaz@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once DOL_DOCUMENT_ROOT . "/core/modules/DolibarrModules.class.php";

// The class name should start with a lower case mod for Dolibarr to pick it up
// so we ignore the Squiz.Classes.ValidClassName.NotCamelCaps rule.
// @codingStandardsIgnoreStart
/**
 * Description and activation class for module Alcool
 */
class modAlcool extends DolibarrModules
{
	/** @var DoliDB Database handler */
	public $db;

	/**
	 * @var int numero Module unique ID
	 * @see http://wiki.dolibarr.org/index.php/List_of_modules_id Available ranges
	 */
	public $numero = 5556667779;

	/** @var string Text key to reference module (for permissions, menus, etc.) */
	public $rights_class = 'alcool';

	/**
	 * @var string Module family.
	 * Used to group modules in module setup page.
	 * Can be one of 'crm', 'financial', 'hr', 'projects', 'products', 'ecm', 'technic', 'other'
	 */
	public $family = 'products';

	/** @var int Module position in the family */
	public $module_position = 500;

	/** @var array Provide a custom family and options */
	public $familyinfo = array(
//        'myownfamily' => array(
//            'position' => '001',
//            'label' => 'MyOwnFamily'
//        )
	);

	/** @var string Module name */
	public $name = "Alcool";

	/** @var string Module short description */
	public $description = "ModuleAlcoolDesc";

	/** @var string Module long description */
	public $descriptionlong = "ModuleAlcoolDesc";

	/**
	 * @var string Module editor name
	 * @since 4.0
	 */
	public $editor_name = "jamelbaz";

	/**
	 * @var string Module editor website
	 * @since 4.0
	 */
	public $editor_url = "http://www.saasprov.com";

	/**
	 * @var string Module version string
	 * Special values to hide the module behind MAIN_FEATURES_LEVEL: development, experimental
	 * @see https://semver.org
	 */
	public $version = '1.0';

	/** @var string Key used in llx_const table to save module status enabled/disabled */
	public $const_name = 'MAIN_MODULE_ALCOOL';

	/**
	 * @var string Module logo
	 * Should be named object_alcool.png and store under alcool/img
	 */
	public $picto = 'alcool@alcool';

	/** @var array Define module parts */
	public $module_parts = array(
		/** @var bool Module ships triggers in alcool/core/triggers */
		'triggers' => true,
		/**
		 * @var bool Module ships login in alcool/core/login
		 * @todo: example
		 */
		'login' => false,
		/**
		 * @var bool Module ships substitution functions
		 * @todo example
		 */
		'substitutions' => false,
		/**
		 * @var bool Module ships menu handlers
		 * @todo example
		 */
		'menus' => false,
		/**
		 * @var bool Module ships theme in alcool/theme
		 * @todo example
		 */
		'theme' => false,
		/**
		 * @var bool Module shipped templates in alcool/core/tpl overload core ones
		 * @todo example
		 */
		'tpl' => false,
		/**
		 * @var bool Module ships barcode functions
		 * @todo example
		 */
		'barcode' => false,
		/**
		 * @var bool Module ships models
		 * @todo example
		 */
		'models' => false,
		/** @var string[] List of module shipped custom CSS relative file paths */
		'css' => array(),
		/** @var string[] List of module shipped custom JavaScript relative file paths */
		'js' => array(),
		/**
		 * @var string[] List of hook contexts managed by the module
		 * @ todo example
		 */
		'hooks' => array(),
		/**
		 * @var array List of default directory names to force
		 * @todo example
		 */
		'dir' => array(),
		/**
		 * @var array List of workflow contexts managed by the module
		 */
		'workflow' => array(),
	);

	/** @var string Data directories to create when module is enabled */
	public $dirs = array(
		'/alcool/temp'
	);

	/** @var array Configuration page declaration */
	public $config_page_url = 'setup.php@alcool';

	/** @var bool Control module visibility */
	public $hidden = false;

	/** @var string[] List of class names of modules to enable when this one is enabled */
	public $depends = array();

	/** @var string[] List of class names of modules to disable when this one is disabled */
	public $requiredby = array();

	/** @var string List of class names of modules this module conflicts with */
	public $conflictwith = array();

	/** @var int[] Minimum PHP version required by this module */
	public $phpmin = array(5, 3);

	/** @var int[] Minimum Dolibarr version required by this module */
	public $need_dolibarr_version = array(3, 2);

	/** @var string[] List of language files */
	public $langfiles = array('alcool@alcool');

	/** @var array Indexed list of constants options */
	public $const = array(
		0 => array(
			/** @var string Constant name */
			'ALCOOL_MYNEWCONST1',
			/**
			 * @var string Constant type
			 * @todo Are there other types than 'chaine'?
			 */
			'chaine',
			/** @var string Constant initial value */
			'myvalue',
			/** @var string Constant description */
			'This is a configuration constant',
			/** @var bool Constant visibility */
			true,
			/**
			 * @var string Multi-company entities
			 * 'current' or 'allentities'
			 */
			'current',
			/** @var bool Delete constant when module is disabled */
			true
		)
	);

	/**
	 * @var string List of pages to add as tab in a specific view
	 * @todo example
	 */
	public $tabs = array();

	/**
	 * @var array Dictionaries declared by the module
	 *@todo example
	 */
	public $dictionaries = array();

	/** @var array Indexed list of boxes options */
	public $boxes = array(
		0 => array(
			'file' => 'mybox@alcool',
			'note' => '',
			'enabledbydefaulton' => 'Home'
		)
	);

	/**
	 * @var array Indexed list of cronjobs options
	 * @todo: example
	 */
	public $cronjobs = array();

	/**
	 * @var array Indexed list of permissions options
	 * @todo example
	 */
	public $rights = array();

	/**
	 * @var array Indexed list of menu options
	 * @todo example
	 */
	public $menu = array();

	/**
	 * @var array Indexed list of export IDs
	 * @todo example
	 */
	public $export_code = array();

	/**
	 * @var array Indexed list of export names
	 * @todo example
	 */
	public $export_label = array();

	/**
	 * @var array Indexed list of export enabling conditions
	 * @todo example
	 */
	public $export_enabled = array();

	/**
	 * @var array Indexed list of export required permissions
	 * @todo example
	 */
	public $export_permission = array();

	/**
	 * @var array Indexed list of export fields
	 * @todo example
	 */
	public $export_fields_array = array();

	/**
	 * @var array Indexed list of export entities
	 * @todo example
	 */
	public $export_entities_array = array();

	/**
	 * @var array Indexed list of export SQL queries start
	 * @todo example
	 */
	public $export_sql_start = array();

	/**
	 * @var array Indexed list of export SQL queries end
	 * @todo example
	 */
	public $export_sql_end = array();

	/** @var bool Module only enabled / disabled in main company when multi-company is in use */
	public $core_enabled = false;

	// @codingStandardsIgnoreEnd
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		global $langs, $conf;

		// DolibarrModules is abstract in Dolibarr < 3.8
		if (is_callable('parent::__construct')) {
			parent::__construct($db);
		} else {
			global $db;
			$this->db = $db;
		}


		// Array to add new pages in new tabs
		// Example:
		// $this->tabs = array('thirdparty:+Vehicle:Vehicle:$user->rights->alcool->read:/alcool/soc.php?socid=__ID__');
		$this->tabs = array('invoice:+STK:alcool:$user->rights->alcool->read:/alcool/invoice.php?id=__ID__');
		// Permissions
		// $r = 0;
		
		// $this->rights [$r] [0] = 199901;
		// $this->rights [$r] [1] = 'View items';
		// $this->rights [$r] [3] = 1;
		// $this->rights [$r] [4] = 'lire';
		// $r ++;
		
		// $this->rights [$r] [0] = 199902;
		// $this->rights [$r] [1] = 'Edit items';
		// $this->rights [$r] [3] = 0;
		// $this->rights [$r] [4] = 'modifier';
		// $r ++;
		
		// $this->rights [$r] [0] = 199903;
		// $this->rights [$r] [1] = 'Create items';
		// $this->rights [$r] [3] = 0;
		// $this->rights [$r] [4] = 'creer';
		// $r ++;
		
		// $this->rights [$r] [0] = 199904;
		// $this->rights [$r] [1] = 'Delete items';
		// $this->rights [$r] [3] = 0;
		// $this->rights [$r] [4] = 'supprimer';
		
		// Main menu entries
		$r=0;
		// Menu entries
		// Example to declare a new Top Menu entry and its Left menu entry:
		 $this->menu[$r]=array(
				'fk_menu' => 0,
				'type' => 'top',
				'titre' => 'Alcool',
				'mainmenu' => 'alcool',
				'leftmenu' => '0',
				'url' => '/alcool/index.php',
				'langs' => 'alcool@alcool',
				'position' => 100,
				// 'enabled' => '$user->rights->alcool->lire',
				// 'perms' => '$user->rights->alcool->lire',
				'target' => '',
				'user' => 2
		);
		$r++;
		$this->menu[$r]=array(
			'fk_menu' => 'fk_mainmenu=alcool',
			'type' => 'left',
			'titre' => 'Ajout tax',
			'leftmenu' => 'add_tx_alc',
			'url' => '/alcool/card.php?action=create',
			'langs' => 'alcool@alcool',
			'position' => 102,
			// 'enabled' => '$user->rights->alcool->lire',
			// 'perms' => '$user->rights->alcool->lire',
			'target' => '',
			'user' => 0 
		);
		$r++;/*
		$this->menu[$r]=array(
			'fk_menu' => 'fk_mainmenu=alcool',
			'type' => 'left',
			'titre' => 'Configuration',
			'leftmenu' => 'ConfigAlcool',
			'url' => '/alcool/admin/setup.php',
			'langs' => 'alcool@alcool',
			'position' => 104,
			// 'enabled' => '$user->rights->alcool->lire',
			// 'perms' => '$user->rights->alcool->lire',
			'target' => '',
			'user' => 0 
		); */
		
		
	}

	/**
	 * Function called when module is enabled.
	 * The init function add constants, boxes, permissions and menus
	 * (defined in constructor) into Dolibarr database.
	 * It also creates data directories
	 *
	 * @param string $options Options when enabling module ('', 'noboxes')
	 * @return int 1 if OK, 0 if KO
	 */
	public function init($options = '')
	{
		$sql = array();

		$result = $this->loadTables();

		return $this->_init($sql, $options);
	}

	/**
	 * Create tables, keys and data required by module
	 * Files llx_table1.sql, llx_table1.key.sql llx_data.sql with create table, create keys
	 * and create data commands must be stored in directory /alcool/sql/
	 * This function is called by this->init
	 *
	 * @return int <=0 if KO, >0 if OK
	 */
	private function loadTables()
	{
		return $this->_load_tables('/alcool/sql/');
	}

	/**
	 * Function called when module is disabled.
	 * Remove from database constants, boxes and permissions from Dolibarr database.
	 * Data directories are not deleted
	 *
	 * @param string $options Options when enabling module ('', 'noboxes')
	 * @return int 1 if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		$sql = array();

		return $this->_remove($sql, $options);
	}
}
