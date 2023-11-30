<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

use PrestaShop\PrestaShop\Core\Product\ProductExtraContent;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_.'nutriscoreplus/classes/AttributNutriscore.php';
require_once _PS_MODULE_DIR_.'nutriscoreplus/classes/AttributNutriscoreValueProduct.php';

class NutriscorePlus extends Module
{
    public function __construct()
    {
        $this->name = 'nutriscoreplus';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Doryan Fourrichon';
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        
        //récupération du fonctionnement du constructeur de la méthode __construct de Module
        parent::__construct();
        $this->bootstrap = true;

        $this->displayName = $this->l('Nutriscore plus');
        $this->description = $this->l('Le module qui permet d\'ajouter le nutriscore à vos produits');

        $this->confirmUninstall = $this->l('Do you want to delete this module');

    }

    public function install()
    {
        if (!parent::install() ||
        !$this->registerHook('displayAdminProductsMainStepLeftColumnMiddle') ||
        !$this->registerHook('displayProductTab') ||
        !$this->registerHook('displayProductTabContent') ||
        !$this->registerHook('productTab') ||
        !$this->registerHook('productTabContent') ||
        !$this->registerHook('displayProductExtraContent') ||
        !$this->registerHook('displayAdminProductsExtra') ||
        !$this->registerHook('actionProductUpdate') ||
        !$this->createTable() ||
        !$this->createTableLang() ||
        !$this->createTableRelationnel() ||
        !$this->installTab('AdminInfoNutritionnelles','Informations Nutritionnelles', 'AdminCatalog')
        ) {
            return false;
        }
            return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
        !$this->unregisterHook('displayAdminProductsMainStepLeftColumnMiddle') ||
        !$this->unregisterHook('displayProductTab') ||
        !$this->unregisterHook('displayProductTabContent') ||
        !$this->unregisterHook('productTab') ||
        !$this->unregisterHook('productTabContent') ||
        !$this->unregisterHook('displayProductExtraContent') ||
        !$this->unregisterHook('displayAdminProductsExtra') ||
        !$this->unregisterHook('actionProductUpdate') ||
        !$this->deleteTable() ||
        !$this->deleteTableLang() ||
        !$this->deleteTableRelationnel() ||
        !$this->uninstallTab()
        ) {
            return false;
        }
            return true;
    }


    public function getContent()
    {
        
        

        
        // dump($tabAttribut);
    }

    public function installTab($className, $tabName, $tabParentName = false)
    {
        // ajouter un lien vers le controller d'admin
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $className;
        $tab->name = array();

        foreach(Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tabName;
        }

        if($tabParentName){

            $tab->id_parent = Tab::getIdFromClassName($tabParentName);
        } else{
            $tab->id_parent =  10;
        }

        $tab->module = $this->name;

        return $tab->add();
    }

    public function uninstallTab()
    {
        $idTab = Tab::getIdFromClassName('AdminParametre');
        $tab =  new Tab($idTab);
        $tab->delete();
    }

    public function createTable()
    {
        return DB::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'attribut_nutriscore(
                id_attribut_nutriscore INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
                obligatoire BOOLEAN NOT NULL,
                active BOOLEAN NOT NULL,
                position INT NOT NULL
            )'
        );
    }

    public function deleteTable()
    {
        return Db::getInstance()->execute(
            'DROP TABLE IF EXISTS '._DB_PREFIX_.'attribut_nutriscore'
        );
    }

    public function createTableLang()
    {
        return Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'attribut_nutriscore_lang(
                id_attribut_nutriscore INT UNSIGNED NOT NULL,
                id_lang INT UNSIGNED NOT NULL,
                attribut_nutriscore_name VARCHAR(255) NOT NULL,
                PRIMARY KEY (id_attribut_nutriscore, id_lang)
            )'
        );
    }

    public function deleteTableLang()
    {
        return Db::getInstance()->execute(
            'DROP TABLE IF EXISTS '._DB_PREFIX_.'attribut_nutriscore_lang'
        );
    }

    public function createTableRelationnel()
    {
        return Db::getInstance()->execute(
            'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'attribut_nutriscore_product(
                id_attribut_nutriscore INT UNSIGNED NOT NULL,
                id_product INT UNSIGNED NOT NULL,
                attribut_nutriscore_value VARCHAR(255) NOT NULL,
                PRIMARY KEY (id_attribut_nutriscore, id_product)
            )'
        );
    }

    public function deleteTableRelationnel()
    {
        return Db::getInstance()->execute(
            'DROP TABLE IF EXISTS '._DB_PREFIX_.'attribut_nutriscore_product'
        );
    }

    public function hookDisplayAdminProductsMainStepLeftColumnMiddle($params)
    {
    
    }
    
    public function hookProductTab()
    {
        return $this->hookDisplayProductTab();
    }
    public function hookDisplayProductTab()
    {
        // return $this->display(__FILE__, 'views/templates/hook/tab.tpl');
    }

    public function hookProductTabContent()
    {
        return $this->hookDisplayProductTabContent();
    }
    public function hookDisplayProductTabContent()
    {
        // $allAttribut = AttributNutriscore::getAttributByPosition();

        // $this->smarty->assign(array(
        //     'attributs' => $allAttribut
        // ));

        // return $this->display(__FILE__, 'views/templates/hook/tabContent.tpl');
    }

    public function hookDisplayProductExtraContent($params)
    {
        // $productExtraContent = new ProductExtraContent();
        // $productExtraContent->setTitle($this->l('Attributs Nutritionnelles'));
        // $productExtraContent->setContent($this->context->smarty->fetch(
        //     'module:nutriscoreplus/views/templates/hook/tabContent.tpl'
        // ));
            
        // return array($productExtraContent);
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        $allAttribut = AttributNutriscore::getAttributByPosition();

        $this->smarty->assign(array(
            'attributs' => $allAttribut,
            'product' => $params["id_product"]
        ));
            
        return $this->display(__FILE__, 'views/templates/hook/tabContent.tpl');
    }
    
    public function hookActionProductUpdate($params)
    {

    }

    public function hookDisplayReassurance($params)
    {
        $url = explode('/',$_SERVER['REQUEST_URI']);
        $url2 = explode('-',end($url));

        // dump($url2);

        $tabValueNutriscore = AttributNutriscoreValueProduct::getAllbyProduct($url2[0]);
        $tabAttribut = [];
        foreach ($tabValueNutriscore as $data) {
            $tabAttribut[] = [
                "name" => $data["attribut_nutriscore_name"],
                "valeur" => $data["attribut_nutriscore_value"]
            ];
        }

        $this->smarty->assign(array(
            "values" => $tabAttribut
        ));

        return $this->display(__FILE__,'views/templates/hook/attributsNutriscore.tpl');
    }
}