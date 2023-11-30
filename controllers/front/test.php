<?php

require_once _PS_MODULE_DIR_.'nutriscoreplus/classes/AttributNutriscore.php';

class NutriscorePlusTestModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {


        parent::initContent();

        dump(Tools::getAllValues());

        $tab = Tools::getAllValues();
        $productId = $tab["product"];
        $attributs = AttributNutriscore::getAll();


        $tabNutriscore = [];

        if (Tools::isSubmit('submitForm')) {

            foreach ($attributs as $attribut) {
                $attributeId = $attribut["id_attribut_nutriscore"];
                $attributeValue = (int)$tab[$attributeId];

                $existingRecord = Db::getInstance()->getValue('
                    SELECT attribut_nutriscore_value 
                    FROM '._DB_PREFIX_.'attribut_nutriscore_product 
                    WHERE id_attribut_nutriscore = '.$attributeId.' 
                    AND id_product = '.$productId
                );

                if ($existingRecord !== false) {
                    // Si l'enregistrement existe, faire une mise à jour
                    $sql = 'UPDATE '._DB_PREFIX_.'attribut_nutriscore_product 
                            SET attribut_nutriscore_value = '.$attributeValue.' 
                            WHERE id_attribut_nutriscore = '.$attributeId.' 
                            AND id_product = '.$productId;
                } else {

                    $sql = 'INSERT INTO '._DB_PREFIX_.'attribut_nutriscore_product 
                            (id_attribut_nutriscore, id_product, attribut_nutriscore_value) 
                            VALUES ('.$attributeId.', '.$productId.', '.$attributeValue.')';
                }
                
                Db::getInstance()->execute($sql);
            }

        }
        
    }
}