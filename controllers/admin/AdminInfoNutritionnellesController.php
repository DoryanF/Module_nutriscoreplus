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

        $this->_select .= 's.attribut_nutriscore_name';
        $this->_join .= 'INNER JOIN '._DB_PREFIX_.'attribut_nutriscore_lang s ON s.id_attribut_nutriscore = a.id_attribut_nutriscore';


        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->addRowAction('view');
    }

    public function renderForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => $this->l('Information nutritionnel')
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'attribut_nutriscore_name',
                    'required' => true,
                    'lang'  => true
                ],
                [
                    'type' => 'switch',
                    'label' => $this->l('Activer le paramètre ?'),
                    'name' => 'active',
                    'is_bool' => true,
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' =>'1',
                            'label' => $this->l('Yes'),
                        ],
                        [
                            'id' => 'active_off',
                            'value' => '0',
                            'label' => $this->l('No'),
                        ],
                    ],
                ],
                [
                    'type' => 'switch',
                    'label' => $this->l('Obligatoire ?'),
                    'name' => 'obligatoire',
                    'is_bool' => true,
                    'values' => [
                        [
                            'id' => 'obligatoire_on',
                            'value' =>'1',
                            'label' => $this->l('Yes'),
                        ],
                        [
                            'id' => 'obligatoire_off',
                            'value' => '0',
                            'label' => $this->l('No'),
                        ],
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Position'),
                    'name' => 'position',
                    'required' => true,
                ],
            ],
            'submit' => [
                'title' => 'Save',
                'class' => 'btn btn-primary'
            ]
        ];

        return parent::renderForm();
    }
}