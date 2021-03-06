<?php

/**
 * News.
 *
 * @package Content
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.06.09
 *
 * @property string $Name
 * @property string $Description
 * @property string $DateCreate
 */
class Content_News extends Zero_Model
{

    /**
     * The table stores the objects this model
     *
     * @var string
     */
    protected $Source = 'News';

    /**
     * Configuration links many to many
     *
     * - 'table_target' => ['table_link', 'prop_this', 'prop_target']
     *
     * @param Content_News $Model The exact working model
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
     * @param Content_News $Model The exact working model
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
            'Name' => [
                'AliasDB' => 'z.Name',
                'DB' => 'T',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Text',
            ],
            'DateCreate' => [
                'AliasDB' => 'z.DateCreate',
                'DB' => 'D',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Datetime',
            ],
            'IsDetails' => [
                'AliasDB' => 'z.IsDetails',
                'DB' => 'I',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Check',
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
     * - 'Form'=> 'Select, Radio, Checkbox, Null, Check, DateTime, Link' - Форма предстваления свйоства в виджетах и вьюхах
     * - 'List'=> array                 - Варианты значений (пользуйтесь системой перевода i18n)
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Content_News $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Filter($Model, $scenario = '')
    {
        return [
            'ID' => ['Visible' => true, 'AR' => true],
            'Name' => ['Visible' => true, 'AR' => true],
            'DateCreate' => ['Visible' => true, 'AR' => true],
            'Description' => ['Visible' => true, 'AR' => true],
            'Content' => ['Visible' => true, 'AR' => true],
        ];
    }

    /**
     * Dynamic configuration properties for the Grid
     *
     * Каждое свойство имеет следующие настройки:
     * - 'AliasDB'=> 'z.PropName'       - Реальное название свойства (поля) в БД
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Content_News $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Grid($Model, $scenario = '')
    {
        return [
            'ID' => [],
            'Name' => [],
            'DateCreate' => []

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
     * @param Content_News $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Form($Model, $scenario = '')
    {
        return [
            'ID' => [],
            'Name' => [],
            'DateCreate' => [],
            'IsDetails' => [],
            'Description' => [],
            'Content' => [],
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
    public function FL_PropNameSample()
    {
        return [23 => 'Value'];
    }

    public function Load_Page()
    {
        if (0 == $this->ID)
            return;
        //
        $sql = "
        SELECT
          `ID`,
          `Name`,
          `Description`,
          DATE_FORMAT(`DateCreate`, '%d.%m.%Y') DateCreate,
          `Content`,
          `IsDetails`
        FROM `News` WHERE ID = {$this->ID}
        ";
        $row = Zero_DB::Select_Row($sql);
        if (0 == count($row))
            return;
        //
        $this->Set_Props($row);
    }


    /**
     * Фабрика по созданию объектов.
     *
     * @param integer $id идентификатор объекта
     * @param bool $flagLoad флаг полной загрузки объекта
     * @return Content_News
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
     * @return Content_News
     */
    public static function Instance($id = 0, $flagLoad = false)
    {
        $index = __CLASS__ . (0 < $id ? '_' . $id : '');
        if (!isset(self::$Instance[$index])) {
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
     * @return Content_News
     */
    public static function Factor($id = 0, $flagLoad = false)
    {
        if (!$result = Zero_Session::Get(__CLASS__)) {
            $result = self::Make($id, $flagLoad);
            $result->Init();
            Zero_Session::Set(__CLASS__, $result);
        }
        return $result;
    }
}