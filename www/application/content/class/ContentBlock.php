<?php

/**
 * ContentBlock.
 *
 * @package Content
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.09.01
 *
 * @property integer $Section_ID
 * @property string $Head
 * @property string $Target
 * @property integer $IsEnable
 * @property string $Img
 * @property string $Link
 * @property string $PriceRUR
 * @property string $PriceEUR
 * @property string $Description
 * @property string $Conten
 * @property integer $Sort
 * @property string $Color
 */
class Content_ContentBlock extends Zero_Model
{
    /**
     * The table stores the objects this model
     *
     * @var string
     */
    protected $Source = 'ContentBlock';

    /**
     * Базовая конфигурация свойств модели
     *
     * Настройки свойств наследуются остальными конфигурациоными методами
     * Каждое свойство имеет следующие базовые настройки:
     * - 'AliasDB'=> 'z.PropName'       - Реальное название свойства (поля) в БД
     * - 'DB'=> 'T, I, F, E, S, D, B'   - Суффикс проверочного метода и косвенного типа хранения в БД
     * - 'IsNull'=> 'YES, NO'           - Разрешено ли значение NULL
     * - 'Default'=> mixed              - Значение по умолчанию
     * - 'Form'=> string                - Форма предстваления свйоства в виджетах и вьюхах
     *
     * @see Zero_Engine
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Content_ContentBlock $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Prop($Model, $scenario = '')
    {
        return [
            'ID' => [
                'AliasDB' => 'z.ID',
                'DB' => 'I',
                'IsNull' => 'NO',
                'Default' => '',
                'Form' => '',
            ],
            'Section_ID' => ['AliasDB' => 'z.Section_ID', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '', 'Form' => 'Link'],
            'Head' => [
                'AliasDB' => 'z.Head',
                'DB' => 'T',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Text',
            ],
            'Target' => [
                'AliasDB' => 'z.Target',
                'DB' => 'E',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Select',
            ],
            'IsEnable' => [
                'AliasDB' => 'z.IsEnable',
                'DB' => 'I',
                'IsNull' => 'YES',
                'Default' => '1',
                'Form' => 'Check',
            ],
            'Img' => [
                'AliasDB' => 'z.Img',
                'DB' => 'T',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Img',
            ],
            'Link' => [
                'AliasDB' => 'z.Link',
                'DB' => 'T',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Text',
            ],
            'PriceRUR' => [
                'AliasDB' => 'z.PriceRUR',
                'DB' => 'F',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Number',
            ],
            'PriceEUR' => [
                'AliasDB' => 'z.PriceEUR',
                'DB' => 'F',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Number',
            ],
            'Description' => [
                'AliasDB' => 'z.Description',
                'DB' => 'T',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Textarea',
            ],
            'Content' => [
                'AliasDB' => 'z.Content',
                'DB' => 'T',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Content',
            ],
            'Sort' => ['AliasDB' => 'z.Sort', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '', 'Form' => 'Number'],
            'Color' => ['AliasDB' => 'z.Color', 'DB' => 'E', 'IsNull' => 'YES', 'Default' => '', 'Form' => 'Select'],
        ];
    }

    /**
     * Dynamic configuration properties for the filter
     *
     * Каждое свойство имеет следующие настройки:
     * - 'AliasDB'=> 'z.PropName'       - Реальное название свойства (поля) в БД
     * - 'DB'=> 'T, I, F, E, S, D, B'   - Суффикс проверочного метода и косвенного типа хранения в БД
     * - 'AR'=> bool                    - Использовать ли в запросах к БД
     * - 'Visible'=> bool               - Видимость фильтра в виджите или вьюхе
     * - 'Form'=> 'Select, Radio, Checkbox, Null, Check, Datetime, Link' - Форма предстваления свйоства в виджетах и вьюхах
     * - 'List'=> array                 - Варианты значений (пользуйтесь системой перевода i18n)
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Content_ContentBlock $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Filter($Model, $scenario = '')
    {
        return [
            'ID' => ['Visible' => true, 'AR' => true],
            'Head' => ['Visible' => true, 'AR' => true],
            'Target' => ['Visible' => true, 'AR' => true],
            'IsEnable' => ['Visible' => true, 'AR' => true],
            'Img' => ['Visible' => true, 'AR' => true],
            'Description' => ['Visible' => true, 'AR' => true],
            'Content' => ['Visible' => true, 'AR' => true],
            'Sort' => ['Visible' => true, 'AR' => true],
            'Color' => ['Visible' => false, 'AR' => false],
        ];
    }

    /**
     * Dynamic configuration properties for the Grid
     *
     * Каждое свойство имеет следующие настройки:
     * - 'AliasDB'=> 'z.PropName'       - Реальное название свойства (поля) в БД
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Content_ContentBlock $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Grid($Model, $scenario = '')
    {
        return [
            'ID' => [],
            'Head' => [],
            'Sort' => [],
        ];
    }

    /**
     * Dynamic configuration properties for the form
     *
     * Каждое свойство имеет следующие настройки:
     * - 'IsNull'=> 'YES, NO'           - Разрешено ли значение NULL
     * - 'Form'=> string                - Форма предстваления свйоства в виджетах и вьюхах (смотри Zero_Engine)
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Content_ContentBlock $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Form($Model, $scenario = '')
    {
        return [
            'Target' => [],
            'Head' => [],
            'Description' => [],
            'Color' => [],
            'Img' => [],
            'Link' => [],
            'PriceRUR' => [],
            'PriceEUR' => [],
            'Content' => [],
            'IsEnable' => [],
            'Sort' => [],
        ];
    }

    /**
     * Динамический фабричный метод длиа создании объекта через фабрику и инстанс.
     */
    protected function Init()
    {
    }

    /**
     * Фабрика по созданию объектов.
     *
     * @param integer $id идентификатор объекта
     * @param bool $flagLoad флаг полной загрузки объекта
     * @return Content_ContentBlock
     */
    public static function Make($id = 0, $flagLoad = false)
    {
        return new self($id, $flagLoad);
    }

    /**
     * Фабрика по созданию объектов.
     *
     * Сохраниаетсиа в {$тис->_Инстанcе}
     *
     * @param integer $id идентификатор объекта
     * @param bool $flagLoad флаг полной загрузки объекта
     * @return Content_ContentBlock
     */
    public static function Instance($id = 0, $flagLoad = false)
    {
        $index = __CLASS__ . (0 < $id ? '_' . $id : '');
        if ( !isset(self::$Instance[$index]) )
        {
            $result = self::Make($id, $flagLoad);
            $result->Init();
            self::$Instance[$index] = $result;
        }
        return self::$Instance[$index];
    }

    /**
     * Фабрика по созданию объектов.
     *
     * Работает через сессию (Zero_Session).
     * Индекс имя класса
     *
     * @param integer $id идентификатор объекта
     * @param bool $flagLoad флаг полной загрузки объекта
     * @return Content_ContentBlock
     */
    public static function Factor($id = 0, $flagLoad = false)
    {
        if ( !$result = Zero_Session::Get(__CLASS__) )
        {
            $result = self::Make($id, $flagLoad);
            $result->Init();
            Zero_Session::Set(__CLASS__, $result);
        }
        return $result;
    }
}