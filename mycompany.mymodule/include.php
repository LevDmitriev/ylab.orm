<?php
Bitrix\Main\Loader::includeModule('ylab.orm');
/*
Используется в include.php в корневой папке модуля
*/
Bitrix\Main\Loader::registerAutoLoadClasses('mycompany.mymodule', [
        '\Mycompany\Mymodule\Iblock\News\NewsElementTable' => 'lib/iblock/news/newselement.php',
    ]);