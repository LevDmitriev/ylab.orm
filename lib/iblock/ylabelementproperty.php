<?php
namespace Ylab\ORM\Iblock;

use Bitrix\Main\Entity\Validator\Length;
use Bitrix\Main\ORM\Data\DataManager;
use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;

/**
 * Class YlabElementPropertyTable. Класс для работы с таблицей b_iblock_element_property.
 * Т.к. в модуле инфоблоков нет ORM класса для работы с этой таблицей. Воспользовался автоматическим формированием
 * ORM классов.
 *
 * @package Ylab\ORM\Iblock
 */
class YlabElementPropertyTable extends DataManager
{
    
    /**
     * @inheritdoc
     */
    public static function getTableName()
    {
        return 'b_iblock_element_property';
    }
    
    /**
     * @inheritdoc
     */
    public static function getMap()
    {
        $arMap = [
            'ID' => [
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_ID_FIELD'),
            ],
            'IBLOCK_PROPERTY_ID' => [
                'data_type' => 'integer',
                'required' => true,
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_IBLOCK_PROPERTY_ID_FIELD'),
            ],
            'IBLOCK_ELEMENT_ID' => [
                'data_type' => 'integer',
                'required' => true,
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_IBLOCK_ELEMENT_ID_FIELD'),
            ],
            'VALUE' => [
                'data_type' => 'text',
                'required' => true,
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_VALUE_FIELD'),
            ],
            'VALUE_TYPE' => [
                'data_type' => 'enum',
                'values' => ['text', 'html'],
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_VALUE_TYPE_FIELD'),
            ],
            'VALUE_ENUM' => [
                'data_type' => 'integer',
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_VALUE_ENUM_FIELD'),
            ],
            'VALUE_NUM' => [
                'data_type' => 'float',
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_VALUE_NUM_FIELD'),
            ],
            'DESCRIPTION' => [
                'data_type' => 'string',
                'validation' => [__CLASS__, 'validateDescription'],
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_DESCRIPTION_FIELD'),
            ],
            'IBLOCK_ELEMENT' => [
                'data_type' => 'Bitrix\Iblock\IblockElement',
                'reference' => ['=this.IBLOCK_ELEMENT_ID' => 'ref.ID'],
            ],
            'IBLOCK_PROPERTY' => [
                'data_type' => 'Bitrix\Iblock\IblockProperty',
                'reference' => ['=this.IBLOCK_PROPERTY_ID' => 'ref.ID'],
            ],
        ];
    
        $arMap = array_merge(RelationMapperStaticFactory::create(static::getTableName())->getRelations(), $arMap);
    
        return $arMap;
    }
    
    /**
     * Returns validators for DESCRIPTION field.
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentTypeException
     */
    public static function validateDescription()
    {
        return array(
            new Length(null, 255),
        );
    }
}