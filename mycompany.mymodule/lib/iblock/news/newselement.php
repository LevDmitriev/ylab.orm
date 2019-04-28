<?php
namespace Mycompany\Mymodule\Iblock\News;

use Bitrix\Iblock\IblockTable;
use Ylab\ORM\Iblock\YlabElementTable;

/**
 * Class NewsElementTable
 * Класс для работы с элементами инфоблока news
 *
 * @package Mycompany\Mymodule\Iblock\News
 */
class NewsElementTable extends YlabElementTable
{
    
    /**
     * @inheritdoc
     */
    public static function getIblockId()
    {
        return IblockTable::getList(['filter' => ['CODE' => 'news']])->fetchObject()->getId();
    }
    
    /**
     * @inheritdoc
     */
    public static function getObjectClass() {
        return EO_NewsElement::class;
    }
    
    //public function setDefaultScope(Query $query)
    //{
    //    return $query->where('IBLOCK_ID', static::getIblockId());
    //}
    
}