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
     * Доступ по telnet регистратора
     */
    const TelnetHost = 'is.yoursrs.com';
    const TelnetPort = 2001;
    const TelnetLogin = 'hostkey/admin';
    const TelnetPassword = 'sOd73hAps51^'; // 50ftWoman
    /**
     * Доступ к api регистратора
     */
    const HTTPHost = 'https://api.yoursrs.com';
    const HTTPHandle = 'hostkey';
    const HTTPLogin = 'admin';
    const HTTPPassword = 'sOd73hAps51^'; // 50ftWoman
    const HTTPPZonePricelist = '/v2/customers/hostkey/pricelist'; // sOd73hAps51^

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
            'Description' => [
                'AliasDB' => 'z.Description',
                'DB' => 'T',
                'IsNull' => 'YES',
                'Default' => '',
                'Form' => 'Textarea'
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
            'Sort' => ['AliasDB' => 'z.Sort', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '', 'Form' => 'Number'],
            'Dnsmanagement' => [
                'AliasDB' => 'z.Dnsmanagement',
                'DB' => 'I',
                'IsNull' => 'YES',
                'Default' => '0',
                'Form' => 'Check',
            ],
            'Idprotection' => [
                'AliasDB' => 'z.Idprotection',
                'DB' => 'I',
                'IsNull' => 'YES',
                'Default' => '0',
                'Form' => 'Check',
            ],
            'RegisterPeriod' => ['AliasDB' => 'z.RegisterPeriod', 'DB' => 'S', 'IsNull' => 'YES', 'Default' => '', 'Form' => 'Readonly'],
            'TransferPeriod' => ['AliasDB' => 'z.TransferPeriod', 'DB' => 'S', 'IsNull' => 'YES', 'Default' => '', 'Form' => 'Readonly'],
            'RenewPeriod' => ['AliasDB' => 'z.RenewPeriod', 'DB' => 'S', 'IsNull' => 'YES', 'Default' => '', 'Form' => 'Readonly'],
            'RenewPeriodAuto' => ['AliasDB' => 'z.RenewPeriodAuto', 'DB' => 'S', 'IsNull' => 'YES', 'Default' => '', 'Form' => 'Readonly'],
            'PriceRegister01' => ['AliasDB' => 'z.PriceRegister01', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister02' => ['AliasDB' => 'z.PriceRegister02', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister03' => ['AliasDB' => 'z.PriceRegister03', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister04' => ['AliasDB' => 'z.PriceRegister04', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister05' => ['AliasDB' => 'z.PriceRegister05', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister06' => ['AliasDB' => 'z.PriceRegister06', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister07' => ['AliasDB' => 'z.PriceRegister07', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister08' => ['AliasDB' => 'z.PriceRegister08', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister09' => ['AliasDB' => 'z.PriceRegister09', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRegister10' => ['AliasDB' => 'z.PriceRegister10', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer01' => ['AliasDB' => 'z.PriceTransfer01', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer02' => ['AliasDB' => 'z.PriceTransfer02', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer03' => ['AliasDB' => 'z.PriceTransfer03', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer04' => ['AliasDB' => 'z.PriceTransfer04', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer05' => ['AliasDB' => 'z.PriceTransfer05', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer06' => ['AliasDB' => 'z.PriceTransfer06', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer07' => ['AliasDB' => 'z.PriceTransfer07', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer08' => ['AliasDB' => 'z.PriceTransfer08', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer09' => ['AliasDB' => 'z.PriceTransfer09', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceTransfer10' => ['AliasDB' => 'z.PriceTransfer10', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew01' => ['AliasDB' => 'z.PriceRenew01', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew02' => ['AliasDB' => 'z.PriceRenew02', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew03' => ['AliasDB' => 'z.PriceRenew03', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew04' => ['AliasDB' => 'z.PriceRenew04', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew05' => ['AliasDB' => 'z.PriceRenew05', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew06' => ['AliasDB' => 'z.PriceRenew06', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew07' => ['AliasDB' => 'z.PriceRenew07', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew08' => ['AliasDB' => 'z.PriceRenew08', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew09' => ['AliasDB' => 'z.PriceRenew09', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'PriceRenew10' => ['AliasDB' => 'z.PriceRenew10', 'DB' => 'F', 'IsNull' => 'NO', 'Default' => '0.00', 'Form' => 'Readonly'],
            'SortTop20' => ['AliasDB' => 'z.SortTop20', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '0', 'Form' => 'Number'],
            'SortTop50' => ['AliasDB' => 'z.SortTop50', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '0', 'Form' => 'Number'],
            'SortTop100' => ['AliasDB' => 'z.SortTop100', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '0', 'Form' => 'Number'],
            'SortPromo' => ['AliasDB' => 'z.SortPromo', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '0', 'Form' => 'Number'],
            'SortPopular' => ['AliasDB' => 'z.SortPopular', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '0', 'Form' => 'Number'],
            'SortNew' => ['AliasDB' => 'z.SortNew', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '0', 'Form' => 'Number'],
            'SortNational' => ['AliasDB' => 'z.SortNational', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '0', 'Form' => 'Number'],
            'SortThematic' => ['AliasDB' => 'z.SortThematic', 'DB' => 'I', 'IsNull' => 'YES', 'Default' => '0', 'Form' => 'Number'],
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
            'Description' => ['Visible' => true, 'AR' => true],
            'Order' => ['Visible' => true, 'AR' => true],
            'PriceRegister' => ['Visible' => true, 'AR' => true],
            'PriceTransfer' => ['Visible' => true, 'AR' => true],
            'PriceRenew' => ['Visible' => true, 'AR' => true],
            'PriceOld' => ['Visible' => true, 'AR' => true],
            'Groups' => ['Visible' => true, 'AR' => true],
            'GroupsCheck' => ['AliasDB' => 'z.Groups', 'Form' => 'Null', 'Visible' => true, 'AR' => true],
            'DateAction' => ['Visible' => true, 'AR' => true],
            'Dnsmanagement' => ['Visible' => true, 'AR' => true],
            'Idprotection' => ['Visible' => true, 'AR' => true],
            'Sort' => ['Visible' => true, 'AR' => true],
            'RegisterPeriod' => ['Visible' => true, 'AR' => true, 'Form' => 'Checkbox'],
            'TransferPeriod' => ['Visible' => true, 'AR' => true, 'Form' => 'Checkbox'],
            'RenewPeriod' => ['Visible' => true, 'AR' => true, 'Form' => 'Checkbox'],
            'RenewPeriodAuto' => ['Visible' => true, 'AR' => true, 'Form' => 'Checkbox'],
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
     * @param Shop_DomainsZone $Model The exact working model
     * @param string $scenario Сценарий свойств
     * @return array
     */
    protected static function Config_Form($Model, $scenario = '')
    {
        return [
            'Name' => [],
            'Comment' => [],
            'Description' => [],
            'Order' => [],
            'PriceRegister' => [],
            'PriceTransfer' => [],
            'PriceRenew' => [],
            'PriceOld' => [],
            'Groups' => [],
            'DateAction' => [],
            'Img' => [],
            'Dnsmanagement' => ['Form' => 'Readonly'],
            'Idprotection' => ['Form' => 'Readonly'],
            'Sort' => [],
            'RegisterPeriod' => [],
            'TransferPeriod' => [],
            'RenewPeriod' => [],
            'RenewPeriodAuto' => [],
            'PriceRegister01' => [],
            'PriceRegister02' => [],
            'PriceRegister03' => [],
            'PriceRegister04' => [],
            'PriceRegister05' => [],
            'PriceRegister06' => [],
            'PriceRegister07' => [],
            'PriceRegister08' => [],
            'PriceRegister09' => [],
            'PriceRegister10' => [],
            'PriceTransfer01' => [],
            'PriceTransfer02' => [],
            'PriceTransfer03' => [],
            'PriceTransfer04' => [],
            'PriceTransfer05' => [],
            'PriceTransfer06' => [],
            'PriceTransfer07' => [],
            'PriceTransfer08' => [],
            'PriceTransfer09' => [],
            'PriceTransfer10' => [],
            'PriceRenew01' => [],
            'PriceRenew02' => [],
            'PriceRenew03' => [],
            'PriceRenew04' => [],
            'PriceRenew05' => [],
            'PriceRenew06' => [],
            'PriceRenew07' => [],
            'PriceRenew08' => [],
            'PriceRenew09' => [],
            'PriceRenew10' => [],
            'SortTop20' => [],
            'SortTop50' => [],
            'SortTop100' => [],
            'SortPromo' => [],
            'SortPopular' => [],
            'SortNew' => [],
            'SortNational' => [],
            'SortThematic' => [],
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