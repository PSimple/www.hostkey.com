<?php

/**
 * View a list of objects by page.
 *
 * To work with the item.
 *
 * @package <Package>.ConfigCalculator
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.12.16
 */
class ConfigCalculator_Grid extends Zero_Crud_Grid
{
    /**
     * The table stores the objects handled by this controller.
     *
     * @var string
     */
    protected $ModelName = 'ConfigCalculator';

    /**
     * Template view
     *
     * @var string
     */
    protected $ViewName = 'Zero_Crud_Grid';
}