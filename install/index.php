<?php
use Bitrix\Main\Localization\Loc;

/**
 * Класс установки модуля Ylab.ORM
 */
class ylab_orm extends CModule
{
    /** @var string $MODULE_ID ID модуля */
    public $MODULE_ID = "ylab.orm";
    /** @var string $MODULE_VERSION Версия модуля */
    public $MODULE_VERSION;
    /** @var mixed Дата версии модуля */
    public $MODULE_VERSION_DATE;
    /** @var string Имя модуля */
    public $MODULE_NAME;
    /** @var string $MODULE_DESCRIPTION Текстовое описание модуля */
    public $MODULE_DESCRIPTION;
    /** @var string $MODULE_CSS Путь к CSS файлам модуля */
    public $MODULE_CSS;
    /** @var string $MODULE_GROUP_RIGHTS Поддерживает ли модуль индивидуальную схему распределения прав */
    public $MODULE_GROUP_RIGHTS = "Y";
    
    /**
     * Конструктор класса
     */
    public function __construct()
    {
        $arModuleVersion = [];
        
        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path . "/version.php");
        
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->PARTNER_NAME = "Ylab";
        $this->PARTNER_URI = "https://ylab.io";
        
        $this->MODULE_NAME = Loc::getMessage("YLAB_ORM_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("YLAB_ORM_MODULE_DESCRIPTION");
    }
    
    /**
     * Установить базу данных модуля
     * @return bool
     */
    public function InstallDB()
    {
        RegisterModule($this->MODULE_ID);
        
        return true;
    }
    
    /**
     * Удалить базу данных модуля
     * @return bool
     */
    public function UnInstallDB()
    {
        UnRegisterModule($this->MODULE_ID);
        
        return true;
    }
    
    /**
     * Установить события модуля
     * @return bool
     */
    public function InstallEvents()
    {
        return true;
    }
    
    /**
     * Установить модуль.
     */
    public function DoInstall()
    {
        if (!IsModuleInstalled($this->MODULE_ID)) {
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();
        }
    }
    
    /**
     * Удалить модуль.
     */
    public function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
    }
}