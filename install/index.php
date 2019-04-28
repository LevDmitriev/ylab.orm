<?php

use Bitrix\Main\Localization\Loc;

/**
 * Class ylab_orm
 * Класс установки модуля Ylab.ORM
 */
class ylab_orm extends CModule
{
    public $MODULE_ID = "ylab.orm";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $MODULE_GROUP_RIGHTS = "Y";
    
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
    
    public function InstallDB()
    {
        RegisterModule($this->MODULE_ID);
        
        return true;
    }
    
    public function UnInstallDB()
    {
        UnRegisterModule($this->MODULE_ID);
        
        return true;
    }
    
    public function InstallEvents()
    {
        return true;
    }
    
    public function UnInstallEvents()
    {
        return true;
    }
    
    public function InstallFiles()
    {
        return true;
    }
    
    public function UnInstallFiles()
    {
        
        return true;
    }
    
    public function DoInstall()
    {
        if (!IsModuleInstalled($this->MODULE_ID)) {
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();
        }
    }
    
    public function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
    }
}