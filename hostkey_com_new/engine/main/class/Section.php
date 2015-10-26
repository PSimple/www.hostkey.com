<?php

/**
 * Section.
 *
 * @package <Package>.Section
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.10.26
 *
 * @property string $Section_ID
 * @property string $Url
 * @property string $UrlThis
 * @property string $UrlRedirect
 * @property string $Layout
 * @property string $Controller
 * @property string $IsAuthorized
 * @property string $IsEnable
 * @property string $IsVisible
 * @property string $IsIndex
 * @property integer $Sort
 * @property string $Name
 * @property string $Title
 * @property string $Keywords
 * @property string $Description
 * @property string $Content
 * @property string $Currency
 * @property array $ComponentGrou
 */
class Section extends Zero_Model
{
    /**
     * The table stores the objects this model
     *
     * @var string
     */
    protected $Source = 'Section';

    /**
     * Configuration links many to many
     *
     * - 'table_target' => ['table_link', 'prop_this', 'prop_target']
     *
     * @param Section $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Link($Model, $scenario = '')
    {
        return [
            

        ];
    }

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
     * @param Section $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Prop($Model, $scenario = '')
    {
        return [
            'ID' => [
				'AliasDB' => 'z.ID',
				'DB' => 'ID',
				'IsNull' => 'NO',
				'Default' => '',
				'Form' => '',
			],
			'Section_ID' => [
				'AliasDB' => 'z.Section_ID',
				'DB' => 'ID',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Link',
			],
			'Url' => [
				'AliasDB' => 'z.Url',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
			],
			'UrlThis' => [
				'AliasDB' => 'z.UrlThis',
				'DB' => 'T',
				'IsNull' => 'NO',
				'Default' => '',
				'Form' => 'Text',
			],
			'UrlRedirect' => [
				'AliasDB' => 'z.UrlRedirect',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
			],
			'Layout' => [
				'AliasDB' => 'z.Layout',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
			],
			'Controller' => [
				'AliasDB' => 'z.Controller',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
			],
			'IsAuthorized' => [
				'AliasDB' => 'z.IsAuthorized',
				'DB' => 'E',
				'IsNull' => 'NO',
				'Default' => 'no',
				'Form' => 'Radio',
			],
			'IsEnable' => [
				'AliasDB' => 'z.IsEnable',
				'DB' => 'E',
				'IsNull' => 'NO',
				'Default' => 'yes',
				'Form' => 'Radio',
			],
			'IsVisible' => [
				'AliasDB' => 'z.IsVisible',
				'DB' => 'E',
				'IsNull' => 'NO',
				'Default' => 'no',
				'Form' => 'Radio',
			],
			'IsIndex' => [
				'AliasDB' => 'z.IsIndex',
				'DB' => 'E',
				'IsNull' => 'YES',
				'Default' => 'yes',
				'Form' => 'Select',
			],
			'Sort' => [
				'AliasDB' => 'z.Sort',
				'DB' => 'I',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Number',
			],
			'Name' => [
				'AliasDB' => 'z.Name',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
			],
			'Title' => [
				'AliasDB' => 'z.Title',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
			],
			'Keywords' => [
				'AliasDB' => 'z.Keywords',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
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
			'Currency' => [
				'AliasDB' => 'z.Currency',
				'DB' => 'E',
				'IsNull' => 'NO',
				'Default' => 'eur',
				'Form' => 'Radio',
			],
			'ComponentGroup' => [
				'AliasDB' => 'z.ComponentGroup',
				'DB' => 'S',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Checkbox',
			],
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
     * @param Section $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Filter($Model, $scenario = '')
    {
        return [
            'ID' => ['Visible' => true, 'AR' => true],
			'Section_ID' => ['Visible' => true, 'AR' => true],
			'Url' => ['Visible' => true, 'AR' => true],
			'UrlThis' => ['Visible' => true, 'AR' => true],
			'UrlRedirect' => ['Visible' => true, 'AR' => true],
			'Layout' => ['Visible' => true, 'AR' => true],
			'Controller' => ['Visible' => true, 'AR' => true],
			'IsAuthorized' => ['Visible' => true, 'AR' => true],
			'IsEnable' => ['Visible' => true, 'AR' => true],
			'IsVisible' => ['Visible' => true, 'AR' => true],
			'IsIndex' => ['Visible' => true, 'AR' => true],
			'Sort' => ['Visible' => true, 'AR' => true],
			'Name' => ['Visible' => true, 'AR' => true],
			'Title' => ['Visible' => true, 'AR' => true],
			'Keywords' => ['Visible' => true, 'AR' => true],
			'Description' => ['Visible' => true, 'AR' => true],
			'Content' => ['Visible' => true, 'AR' => true],
			'Currency' => ['Visible' => true, 'AR' => true],
			'ComponentGroup' => ['Visible' => true, 'AR' => true],
        ];
    }

    /**
     * Dynamic configuration properties for the Grid
     *
     * Каждое свойство имеет следующие настройки:
     * - 'AliasDB'=> 'z.PropName'       - Реальное название свойства (поля) в БД
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Section $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Grid($Model, $scenario = '')
    {
        return [
            'ID' => [],
			'Url' => [],
			'UrlThis' => [],
			'UrlRedirect' => [],
			'Layout' => [],
			'Controller' => [],
			'Name' => [],
			'Title' => [],
			'Keywords' => [],
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
     * @param Section $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Form($Model, $scenario = '')
    {
        return [
            'ID' => [],
			'Section_ID' => [],
			'Url' => [],
			'UrlThis' => [],
			'UrlRedirect' => [],
			'Layout' => [],
			'Controller' => [],
			'IsAuthorized' => [],
			'IsEnable' => [],
			'IsVisible' => [],
			'IsIndex' => [],
			'Sort' => [],
			'Name' => [],
			'Title' => [],
			'Keywords' => [],
			'Description' => [],
			'Content' => [],
			'Currency' => [],
			'ComponentGroup' => [],
        ];
    }

    /**
     * Sample. The total initial validation properties
     *
     * @param array $data verifiable data array
     * @param string $scenario scenario validation
     * @return array
     */
    public function Validate_Before($data, $scenario)
    {
        return $data;
    }

    /**
     * Sample. The validation property
     * May be removed
     *
     * @param mixed $value value to check and set
     * @param string $scenario scenario validation
     * @return string
     */
    public function VL_PropertyName($value, $scenario)
    {
        $this->PropertyName = $value;
        return '';
    }

    /**
     * Sample. Filter for property.
     * May be removed
     *
     * @return array
     */
    public function FL_PropertyName()
    {
        return [23 => 'Value'];
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
     * @return Section
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
     * @return Section
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
     * @return Section
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