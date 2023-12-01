<?php

class AttributNutriscoreValueProduct extends ObjectModel
{
    public $id_attribut_nutriscore;
    public $id_product;
    public $attribut_nutriscore_value;

    public static function getAllbyProduct($id_product)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.'attribut_nutriscore_product a 
        INNER JOIN '._DB_PREFIX_.'attribut_nutriscore s ON s.id_attribut_nutriscore = a.id_attribut_nutriscore 
        INNER JOIN '._DB_PREFIX_.'attribut_nutriscore_lang l ON l.id_attribut_nutriscore = s.id_attribut_nutriscore
        WHERE id_product = '.$id_product;

        try {
            $result = DB::getInstance()->executeS($sql);
            return $result;
        } catch (PDOException $e) {
            // Gérer l'exception selon les besoins
            // Log l'erreur, renvoyer un message d'erreur, etc.
            die('Erreur SQL : '.$e->getMessage());
        }
    }

    public static function getIdProductExist($productId)
    {
        $sql = 'SELECT id_product 
                FROM '._DB_PREFIX_.'attribut_nutriscore_product 
                WHERE id_product = '.$productId;

        return DB::getInstance()->getValue($sql);
    }

}