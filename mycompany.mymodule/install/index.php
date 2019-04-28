<?php

use Bitrix\Main\Localization\Loc;

class mycompany_mymodule extends CModule
{
    public $MODULE_ID = "mycompany.mymodule";
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
        $this->PARTNER_NAME = "Partner name";
        $this->PARTNER_URI = "http://www.1c-bitrix.ru/";
        
        $this->MODULE_NAME = Loc::getMessage("MYCOMPANY_MYMODULE_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("MYCOMPANY_MYMODULE_MODULE_DESCRIPTION");
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