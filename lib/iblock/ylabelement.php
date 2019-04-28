<?php
namespace Ylab\ORM\Iblock;

use \Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\EO_Property_Collection;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;
use Ylab\ORM\Iblock\YlabPropertyEnumTable;
use Ylab\ORM\Main\YlabFileTable;

/**
 * Class YlabElementTable. Класс для работы с таблицей b_iblock_element
 *
 * @package Ylab\ORM\Iblock
 */
class YlabElementTable extends ElementTable
{
    
    /**
     * @inheritdoc
     */
    public static function getIblockId()
    {
        return null; // Наследники переопределяют
    }
    
    /**
     * @inheritdoc
     */
    public static function getMap()
    {
        $arResult = [];
    
        // Перебираем все свойства инфоблока и выставляем соответствующие отношения
        if ($iIblockId = static::getIblockId()) {
            /** @var EO_Property_Collection $oIblockPropCollection Список всех свойств инфоблока*/
            $oIblockPropCollection = PropertyTable::getList(['filter' => ['IBLOCK_ID' => $iIblockId]])->fetchCollection();
            foreach ($oIblockPropCollection as $oIblockProp) {
                /** @var string $sPropertyName Имя свойства, по которому ео можно будет получить */
                $sPropertyName = 'PROPERTY_' . $oIblockProp->getCode();
                /** @var string $sPropertyType Тип свойства */
                $sPropertyType = $oIblockProp->getPropertyType();
                /** @var boolean $isMultiple Является ли свойство множественным */
                $isMultiple = $oIblockProp->getMultiple();
                if (PropertyTable::TYPE_FILE === $sPropertyType && !$isMultiple) { // Свойство с привязкой к 1 файлу
                    $arResult[] = (new Reference(
                        $sPropertyName,
                        YlabFileTable::class,
                        Join::on('this.PROPERTIES.VALUE', 'ref.ID')->where('this.PROPERTIES.IBLOCK_PROPERTY_ID',$oIblockProp->getId())
                    ))->configureJoinType('inner');
                } elseif ( PropertyTable::TYPE_LIST === $sPropertyType && !$isMultiple ) { // Свойство типа список с одиночным выбором
                    $arResult[] = (new Reference(
                        $sPropertyName,
                        YlabPropertyEnumTable::class,
                        Join::on('this.PROPERTIES.VALUE_ENUM', 'ref.ID')->whereNotNull('this.PROPERTIES.VALUE_ENUM')))
                    ->configureJoinType('inner');
                } elseif (PropertyTable::TYPE_ELEMENT === $sPropertyType && !$isMultiple) { // Привязка к 1 элементу
                    $arResult[] = (new Reference($sPropertyName,
                        YlabElementTable::class,
                        Join::on('this.PROPERTIES.VALUE', 'ref.ID')->where('ref.IBLOCK_ID', $oIblockProp->getLinkIblockId()))
                    )->configureJoinType('inner');
                } elseif (PropertyTable::TYPE_SECTION === $sPropertyType && !$isMultiple) { // Привязка к 1 разделу инфоблока
                    $arResult[] = (new Reference($sPropertyName,
                        YlabSectionTable::class,
                        Join::on('this.PROPERTIES.VALUE', 'ref.ID')->where('ref.IBLOCK_ID', $oIblockProp->getLinkIblockId()))
                    )->configureJoinType('inner');
                } elseif ($isMultiple) { // Оставшееся, относящиеся к множественному выбору
                    $arResult[] = new OneToMany($sPropertyName, YlabElementPropertyTable::class, 'PRIVATE_ELEMENT_BY_PROPERTY_'.$oIblockProp->getCode());
                } else { // Оставшееся, относящееся к одиночному выбору
                    $arResult[] = (new Reference(
                        $sPropertyName,
                        YlabElementPropertyTable::class,
                        Join::on('this.ID', 'ref.IBLOCK_ELEMENT_ID')->where('ref.IBLOCK_PROPERTY_ID', $oIblockProp->getId())
                    ))->configureJoinType('inner');
                }
                
            }
        }
    
        $arResult = array_merge(RelationMapperStaticFactory::create(static::getTableName())->getRelations(), $arResult, parent::getMap());
    
        return $arResult;
    }
}