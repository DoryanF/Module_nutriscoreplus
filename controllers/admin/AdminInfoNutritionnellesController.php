<?php

require_once _PS_MODULE_DIR_.'nutriscoreplus/classes/AttributNutriscore.php';

class AdminInfoNutritionnellesController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table = AttributNutriscore::$definition['table'];
        $this->className = AttributNutriscore::class;
        $this->module = Module::getInstanceByName('nutriscoreplus');
        $this->identifier = AttributNutriscore::$definition['primary'];
        $this->_orderBy = AttributNutriscore::$definition['primary'];
        $this->bootstrap = true;

        parent::__construct();

        $this->fields_list = [
            'attribut_nutriscore_name' => [
                'title' => 'Nom',
                'search' => true
            ],
            'obligatoire' => [
                'title' => 'Obligatoire',
                'search' => true
            ],
            'active' => [
                'title' => 'Activée',
                'search' => true
            ],
            'position' => [
                'title' => 'Position',
                'search' => true
            ]
        ];

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->addRowAction('view');
    }
}