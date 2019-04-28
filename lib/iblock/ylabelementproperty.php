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
        $arMap = array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_ID_FIELD'),
            ),
            'IBLOCK_PROPERTY_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_IBLOCK_PROPERTY_ID_FIELD'),
            ),
            'IBLOCK_ELEMENT_ID' => array(
                'data_type' => 'integer',
                'required' => true,
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_IBLOCK_ELEMENT_ID_FIELD'),
            ),
            'VALUE' => array(
                'data_type' => 'text',
                'required' => true,
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_VALUE_FIELD'),
            ),
            'VALUE_TYPE' => array(
                'data_type' => 'enum',
                'values' => array('text', 'html'),
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_VALUE_TYPE_FIELD'),
            ),
            'VALUE_ENUM' => array(
                'data_type' => 'integer',
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_VALUE_ENUM_FIELD'),
            ),
            'VALUE_NUM' => array(
                'data_type' => 'float',
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_VALUE_NUM_FIELD'),
            ),
            'DESCRIPTION' => array(
                'data_type' => 'string',
                'validation' => array(__CLASS__, 'validateDescription'),
                //'title' => Loc::getMessage('ELEMENT_PROPERTY_ENTITY_DESCRIPTION_FIELD'),
            ),
            'IBLOCK_ELEMENT' => array(
                'data_type' => 'Bitrix\Iblock\IblockElement',
                'reference' => array('=this.IBLOCK_ELEMENT_ID' => 'ref.ID'),
            ),
            'IBLOCK_PROPERTY' => array(
                'data_type' => 'Bitrix\Iblock\IblockProperty',
                'reference' => array('=this.IBLOCK_PROPERTY_ID' => 'ref.ID'),
            ),
        );
    
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