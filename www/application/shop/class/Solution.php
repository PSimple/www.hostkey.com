<?php

/**
 * Решения, группы.
 *
 * @package Shop
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-02-04
 *
 * @property string $Typ
 * @property string $Image
 * @property string $Title
 * @property string $Description
 * @property string $Subtitle
 * @property float $PriceRUR
 * @property float $PriceEUR
 * @property string $Groups
 * @property string $Locatio
 */
class Shop_Solution extends Zero_Model
{
    /**
     * The table stores the objects this model
     *
     * @var string
     */
    protected $Source = 'Solution';

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
     * @param Shop_Solution $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Prop($Model, $scenario = '')
    {
        return [
            'ID' => [
				'AliasDB' => 'z.ID',
				'DB' => 'ID',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => '',
			],
			'Typ' => [
				'AliasDB' => 'z.Typ',
				'DB' => 'E',
				'IsNull' => 'NO',
				'Default' => 'dedicated',
				'Form' => 'Radio',
			],
			'Image' => [
				'AliasDB' => 'z.Image',
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
			'TitleSub' => [
				'AliasDB' => 'z.TitleSub',
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
			'Subtitle' => [
				'AliasDB' => 'z.Subtitle',
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
			'Groups' => [
				'AliasDB' => 'z.Groups',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
			],
			'Location' => [
				'AliasDB' => 'z.Location',
				'DB' => 'E',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Select',
			],
			'Theme' => [
				'AliasDB' => 'z.Theme',
				'DB' => 'E',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Select',
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
     * @param Shop_Solution $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Filter($Model, $scenario = '')
    {
        return [
            'ID' => ['Visible' => true, 'AR' => true],
			'Typ' => ['Visible' => false, 'AR' => false],
			'Image' => ['Visible' => true, 'AR' => true],
			'Title' => ['Visible' => true, 'AR' => true],
			'Description' => ['Visible' => true, 'AR' => true],
			'Subtitle' => ['Visible' => true, 'AR' => true],
			'PriceRUR' => ['Visible' => true, 'AR' => true],
			'PriceEUR' => ['Visible' => true, 'AR' => true],
			'Groups' => ['Visible' => true, 'AR' => true],
			'Location' => ['Visible' => true, 'AR' => true],
			'Theme' => ['Visible' => false, 'AR' => false],
        ];
    }

    /**
     * Dynamic configuration properties for the Grid
     *
     * Каждое свойство имеет следующие настройки:
     * - 'AliasDB'=> 'z.PropName'       - Реальное название свойства (поля) в БД
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Shop_Solution $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Grid($Model, $scenario = '')
    {
        return [
            'ID' => [],
			'Image' => [],
			'Title' => [],
			'Subtitle' => [],
			'Groups' => [],
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
     * @param Shop_Solution $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Form($Model, $scenario = '')
    {
        return [
            'ID' => [],
			'Title' => [],
			'TitleSub' => [],
			'Subtitle' => [],
			'Description' => [],
			'Image' => [],
			'PriceRUR' => [],
			'PriceEUR' => [],
			'Typ' => [],
			'Groups' => [],
			'Location' => [],
			'Theme' => [],
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
	 * Получение всех вариантов конфигураций для калькуляторов
	 *
	 * @return array
	 */
	public static function Get_ConfigGroupsAll()
	{
		$sql = "SELECT CONCAT(`Location`, ',', `Groups`) FROM Solution";
		return Zero_DB::Select_List($sql);
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
     * @return Shop_Solution
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
     * @return Shop_Solution
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
     * @return Shop_Solution
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