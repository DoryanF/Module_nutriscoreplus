<?php


class AttributNutriscore extends ObjectModel
{
    public $id_attribut_nutriscore;
    public $attribut_nutriscore_name;
    public $obligatoire;
    public $position;
    public $active;

    public static $definition = [
        'table' => 'attribut_nutriscore',
        'primary' => 'id_attribut_nutriscore',
        'multilang' => true,
        'fields' => [
            'obligatoire' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true],
            'position' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true],

            'attribut_nutriscore_name' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true]
        ]
    ];

    public static function getAttributByPosition()
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.'attribut_nutriscore a 
        INNER JOIN '._DB_PREFIX_.'attribut_nutriscore_lang s ON s.id_attribut_nutriscore = a.id_attribut_nutriscore 
        ORDER BY position ASC';

        return DB::getInstance()->executeS($sql);
    }

    public static function getAll()
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.'attribut_nutriscore';
        return DB::getInstance()->executeS($sql);
    }


    public static function getIdAttributNutriscore($name)
    {
        $sql = 'SELECT id_attribut_nutriscore FROM '._DB_PREFIX_.'attribut_nutriscore_lang
        WHERE attribut_nutriscore_name = '.$name;

        return DB::getInstance()->executeS($sql);
    }
}