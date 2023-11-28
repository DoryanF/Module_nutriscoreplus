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
}