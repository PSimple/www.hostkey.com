<?php

/**
 * Domains.
 *
 * @package Shop
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.25
 *
 * @property string $Name
 * @property string $Comment
 * @property integer $Order
 * @property float $PriceRegister
 * @property float $PriceOld
 * @property array $Group
 */
class Shop_DomainsZone extends Zero_Model
{
    /**
     * The table stores the objects this model
     *
     * @var string
     */
    protected $Source = 'DomainsZone';

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
     * @param Shop_DomainsZone $Model The exact working model
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
			'Name' => [
				'AliasDB' => 'z.Name',
				'DB' => 'T',
				'IsNull' => 'NO',
				'Default' => '',
				'Form' => 'Readonly',
			],
			'Comment' => [
				'AliasDB' => 'z.Comment',
				'DB' => 'T',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Text',
			],
			'Order' => [
				'AliasDB' => 'z.Order',
				'DB' => 'I',
				'IsNull' => 'NO',
				'Default' => '0',
				'Form' => 'Readonly',
			],
			'PriceRegister' => [
				'AliasDB' => 'z.PriceRegister',
				'DB' => 'F',
				'IsNull' => 'NO',
				'Default' => '0.00',
				'Form' => 'Readonly',
			],
			'PriceTransfer' => [
				'AliasDB' => 'z.PriceTransfer',
				'DB' => 'F',
				'IsNull' => 'NO',
				'Default' => '0.00',
				'Form' => 'Readonly',
			],
			'PriceRenew' => [
				'AliasDB' => 'z.PriceRenew',
				'DB' => 'F',
				'IsNull' => 'NO',
				'Default' => '0.00',
				'Form' => 'Readonly',
			],
			'PriceOld' => [
				'AliasDB' => 'z.PriceOld',
				'DB' => 'F',
				'IsNull' => 'NO',
				'Default' => '0.00',
				'Form' => 'Number',
			],
			'Groups' => [
				'AliasDB' => 'z.Groups',
				'DB' => 'S',
				'IsNull' => 'YES',
				'Default' => '',
				'Form' => 'Checkbox',
			],
            'DateAction' => [
                'AliasDB' => 'z.DateAction',
                'DB' => 'D',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Datetime',
            ],
            'Img' => [
                'AliasDB' => 'z.Img',
                'DB' => 'T',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Img',
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
     * @param Shop_DomainsZone $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Filter($Model, $scenario = '')
    {
        return [
            'ID' => ['Visible' => true, 'AR' => true],
			'Name' => ['Visible' => true, 'AR' => true],
			'Comment' => ['Visible' => true, 'AR' => true],
			'Order' => ['Visible' => true, 'AR' => true],
			'PriceRegister' => ['Visible' => true, 'AR' => true],
			'PriceTransfer' => ['Visible' => true, 'AR' => true],
			'PriceRenew' => ['Visible' => true, 'AR' => true],
			'PriceOld' => ['Visible' => true, 'AR' => true],
			'Groups' => ['Visible' => true, 'AR' => true],
			'DateAction' => ['Visible' => true, 'AR' => true],
        ];
    }

    /**
     * Dynamic configuration properties for the Grid
     *
     * Каждое свойство имеет следующие настройки:
     * - 'AliasDB'=> 'z.PropName'       - Реальное название свойства (поля) в БД
     * - 'Comment' => string            - Комментарий свойства (пользуйтесь системой перевода i18n)
     *
     * @param Shop_DomainsZone $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Grid($Model, $scenario = '')
    {
        return [
            'ID' => [],
			'Name' => [],
			'Comment' => [],
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
     * @param Shop_DomainsZone $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Form($Model, $scenario = '')
    {
        return [
			'Name' => [],
			'Comment' => [],
			'Order' => [],
			'PriceRegister' => [],
			'PriceTransfer' => [],
			'PriceRenew' => [],
			'PriceOld' => [],
			'Groups' => [],
			'DateAction' => [],
			'Img' => [],
        ];
    }

    /**
     * Формирование from части запроса к БД
     * May be removed
     *
     * @param array $params параметры контроллера
     * @return string
     */
    public function AR_From($params)
    {
        $this->AR->Sql_From("FROM {$this->Source} as z");
    }

    /**
     * Создание и удаление связи многие ко многим
     *
     * @param $id
     * @return bool
     */
    public function DB_Cross_TableName($id, $flag = true)
    {
        if ( $flag )
        {
            $sql = "
            INSERT INTO TableName
              FieldName1, FieldName2
            VALUES
              {$id}, {$this->ID}
            ";
            return Zero_DB::Insert($sql);
        }
        else
        {
            $sqk_where = '';
            if ( 0 < $id )
                $sqk_where = "AND FieldName2 = {$id}";
            $sql = "DELETE FROM TableName WHERE FieldName1 = {$this->ID} {$sqk_where}";
            return Zero_DB::Update($sql);
        }
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
     * @return Shop_DomainsZone
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
     * @return Shop_DomainsZone
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
     * @return Shop_DomainsZone
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