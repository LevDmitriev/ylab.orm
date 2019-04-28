# Ylab.ORM
Модуль является обёрткой над ORM битрикса для более удобной работы с
сущностями Bitrix.

# Установка
1. Создать папку `/local/modules/ylab.orm` и поместить туда все файлы.
2. Установите зависимости composer
3. В административном интерфейсе установите модуль.
4. Для получения подсказок IDE, сделайте аннотацию классов
```
cd bitrix
php bitrix.php orm:annotate -m ylab.orm
```

# Использование
1. Cоздайте свой модуль (Как пример, можете использовать модуль
   `mycompany.mymodule` из репозитория)
2. В папке lib создайте свой класс, наследник
   ``Ylab\ORM\Iblock\YlabElementTable``, реализовав метод
   ``getIblockId()``, который должен возвращать ID инфоблока, с
   элементами которого будет работать класс.
3. Установите ваш модуль
4. Сделайте
   [аннотацию классов](https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=11733&LESSON_PATH=3913.5062.5748.11733)
   вашего модуля
5. Работайте с вашим классом, как с обычной ORM сущностью битрикса

# Примеры использования
Примеры будут использовать пространство имён модуля
`mycompany.mymodule`.
## Работа с элементами инфоблока
 Как пример, будем использовать инфоблок "Новости", у которого
символьный код `news`.  
Инфоблок имеет следующие свойства:

|Название|Тип|Множественное|Символьный код|
|---|---|---|---|
|Одиночная картинка|Файл|-|ONE_PICTURE|
|Картинки новостей|Файл|&#x2714;|PICS_NEWS|
|Список одиночного выбора|Список|-|ONE_VALUE_LIST|
|Список множественного выбора|Список|&#x2714;|MULTIPLE_LIST|
|Одна строка|Строка|-|ONE_TEXT|
|Множество строк|Строка|&#x2714;|MULTIPLE_TEXT|
|Привязка к 1 элементу|Привязка к элементам|-|BIND_ONE_ELEMENT|
|Привязка к множеству элементов|Привязка к элементам|&#x2714;|BIND_MULTIPLE_ELEMENTS|
|Привязка к 1 разделу|Привязка к разделам|-|BIND_ONE_SECTION|
|Привязка к множеству разделов|Привязка к разделам|&#x2714;|BIND_MULTIPLE_SECTIONS|

В вашем модуле, в `lib/iblock/news` создайте файл `newselement.php`, с
классом:
```php
namespace Mycompany\Mymodule\Iblock\News;

use Bitrix\Iblock\IblockTable;
use Ylab\ORM\Iblock\YlabElementTable;

class NewsElementTable extends YlabElementTable
{
    
    /**
     * Получить ID инфоблока
     * 
     * @return int
     */
    public static function getIblockId()
    {
        return IblockTable::getList(['filter' => ['CODE' => 'news']])
        ->fetchObject()
        ->getId();
    }
    
    public static function getObjectClass() {
        return EO_NewsElement::class;
    }
}
```
Путь, и имя класса может быть произвольным. Главное, они должны
соответствовать правилам Bitrix по именованию ORM классов.  
Для получения подсказок IDE, сделайте аннотацию своего модуля:
```
php bitrix.php orm:annotate -m mycompany.mymodule
```
Теперь вы можете работать с элементами инфоблока "Новости", используя
ваш ORM класс. В примерах отсутствуют проверки на наличие значений в
свойствах элементов для большей наглядности. Убедитесь, что все свойства
в элементах с которыми вы работаете заполнены.
### Работа с одним элементом инфоблока
```php
use Mycompany\Mymodule\Iblock\News\NewsElementTable;
use Mycompany\Mymodule\Iblock\News\EO_NewsElement;

\Bitrix\Main\Loader::includeModule('mycompany.mymodule');

/** @var EO_NewsElement Объект элемента инфоблока */
$oNews = NewsElementTable::getList([
        'filter' => ['ID' => 2],
])->fetchObject();
```
Получить ID файла, указанного в свойстве ONE_PICTURE
```php
$oNews->fillPropertyOnePicture()->getId();
```
Вывести оригинальные имена всех файлов, указанных в свойстве PICS_NEWS  
```php
$oNews->fillPropertyPicsNews()->fillFile(); // Получаем записи из таблицы b_file
foreach ($oNews->getPropertyPicsNews()->getFileList() as $oFile) {
    echo $oFile->getOriginalName();
}
```
Если нужно получить ID всех файлов, указанных в свойстве PICS_NEWS, то
можно их получить сразу из таблицы b_iblock_element_property
```php
$oNews->fillPropertyPicsNews()->getValueList();
```
Получить значение, указанное в свойстве ONE_VALUE_LIST  
```php
$oNews->fillPropertyOneValueList()->getValue();
```
Вывести список значений, указанных в свойстве MULTIPLE_LIST 
```php
$oNews->fillPropertyMultipleList()->fillEnum(); // Получаем записи из таблицы b_iblock_property_enum
foreach ($oNews->getPropertyMultipleList()->getEnumList() as $oEnum) {
    echo $oEnum->getValue();
}
```
Получить значение свойства ONE_TEXT 
```php
$oNews->fillPropertyOneText()->getValue();
```
Получить значение свойства MULTIPLE_TEXT 
```php
$oNews->fillPropertyMultipleText()->getValueList();
```
Получить название элемента, к которому идёт привязка по свойству
BIND_ONE_ELEMENT
```php
$oNews->fillPropertyBindOneElement()->getName();
```
Вывести названия всех элементов, к которым идёт привязка по свойству
BIND_MULTIPLE_ELEMENTS
```php
$oNews->fillPropertyBindMultipleElements()->fillBindElement(); // Получаем записи из таблицы b_iblock_elent
foreach ($oNews->getPropertyBindMultipleElements()->getBindElementList() as $oElement) {
    echo $oElement->getName();
}
```
Получить название раздела, к которому идёт привязка по свойству
BIND_ONE_SECTION
```php
$oNews->fillPropertyBindOneSection()->getName();
```
ывести названия всех разделов, к которым идёт привязка по свойству
BIND_MULTIPLE_SECTIONS
```php
$oNews->fillPropertyBindMultipleSections()->fillBindSection(); // Получаем записи из таблицы b_iblock_section
foreach ($oNews->getPropertyBindMultipleSections()->getBindSectionList() as $oSection) {
    echo $oSection->fillName();
}
```
### Работа с коллекцией элементов инфоблока
Работа с несколькими элементами инфоблоков осуществляется стандартными
методами коллекции ORM Bitrix
```php
use Mycompany\Mymodule\Iblock\News\NewsElementTable;
use \Mycompany\Mymodule\Iblock\News\EO_NewsElement_Collection;

\Bitrix\Main\Loader::includeModule('mycompany.mymodule');

/** @var EO_NewsElement_Collection $oNewsCollection Коллекция элементов инфоблока */
$oNewsCollection = NewsElementTable::getList([
    'filter' => ['ID' => [1, 2]],
])->fetchCollection();
```
Вывести оригинальные навания файлов из свойства ONE_PICTURE 
```php
$oNewsCollection->fillPropertyOnePicture();
foreach ($oNewsCollection->getPropertyOnePictureList() as $oFile) {
    echo $oFile->getOriginalName();
}
```
Вывести оригинальные навания файлов из свойства PICS_NEWS 
```php
$oNewsCollection->fillPropertyPicsNews(); // Получаем значения из таблицы b_iblock_element_property
foreach ($oNewsCollection->getPropertyPicsNewsList() as $oPropertyCollection) {
    $oPropertyCollection->fillFile(); // Получаем значения из таблицы b_file
    foreach ($oPropertyCollection->getFileList() as $oFile) {
        echo $oFile->getOriginalName();
    }
}
```
Вывести выбранные значения из свойства ONE_VALUE_LIST
```php
$oNewsCollection->fillPropertyOneValueList();
foreach ($oNewsCollection->getPropertyOneValueListList() as $oEnum) {
    echo $oEnum->getValue();
}
```
Вывести выбранные значения из свойства MULTIPLE_LIST
```php
$oNewsCollection->fillPropertyMultipleList();// Получаем значения из таблицы b_iblock_element_property
foreach ($oNewsCollection->getPropertyMultipleListList() as $oPropertyCollection) {
    $oPropertyCollection->fillEnum(); // Получаем значения из таблицы b_iblock_property_enum
    foreach ($oPropertyCollection->getEnumList() as $oEnum) {
        echo $oEnum->getValue();
    }
}
```
Вывести значения из свойства ONE_TEXT
```php
$oNewsCollection->fillPropertyOneText();
foreach ($oNewsCollection->getPropertyOneTextList() as $oPropertyOneText) {
    echo $oPropertyOneText->getValue();
};
```
Вывести значения из свойства MULTIPLE_TEXT
```php
$oNewsCollection->fillPropertyMultipleText();// Получаем значения из таблицы b_iblock_element_property
foreach ($oNewsCollection->getPropertyMultipleTextList() as $oPropertyCollection) {
    /* Т.к значения текстовых свойств хранятся непосредственно 
     * в b_iblock_element_property, то запросов к другим таблицам делать не нужно */
    foreach ($oPropertyCollection as $oProperty) {
        echo $oProperty->getValue();
    }
}
```
Вывести названия элементов из свойства BIND_ONE_ELEMENT
```php
$oNewsCollection->fillPropertyBindOneElement();// Получаем значения из таблицы b_iblock_element
foreach ($oNewsCollection->getPropertyBindOneElementList() as $oElement) {
        echo $oElement->getName();
}
```
Вывести названия элементов из свойства BIND_MULTIPLE_ELEMENTS
```php
$oNewsCollection->fillPropertyBindMultipleElements();// Получаем значения из таблицы b_iblock_element_property
foreach ($oNewsCollection->getPropertyBindMultipleElementsList() as $oPropertyCollection) {
    $oPropertyCollection->fillBindElement(); // Получаем значения из таблицы b_iblock_element
    foreach ($oPropertyCollection->getBindElementList() as $oElement) {
        echo $oElement->getName();
    }
}
```
Вывести названия разделов из свойства BIND_ONE_SECTION
```php
$oNewsCollection->fillPropertyBindOneSection();// Получаем значения из таблицы b_iblock_section
foreach ($oNewsCollection->getPropertyBindOneSectionList() as $oSection) {
        echo $oSection->getName();
}
```
Вывести названия разделов из свойства BIND_MULTIPLE_SECTIONS
```php
$oNewsCollection->fillPropertyBindMultipleSections();// Получаем значения из таблицы b_iblock_element_property
foreach ($oNewsCollection->getPropertyBindMultipleSectionsList() as $oPropertyCollection) {
    $oPropertyCollection->fillBindSection(); // Получаем значения из таблицы b_iblock_section
    foreach ($oPropertyCollection->getBindSectionList() as $oSection) {
        echo $oSection->getName();
    }
}
```
# Диаграммы классов
Все диаграммы находятся в `/diagrams`. Если вы используете PhpStorm вы
можете просматривать их в IDE. Для этого установите плагин
[PlantUML](https://plugins.jetbrains.com/plugin/7017-plantuml-integration),
[Graphviz](https://graphviz.gitlab.io/download/) и в
`diagrams/constants.puml` установите значение константы ROOT -
абсолютный путь к папке `/diagrams`