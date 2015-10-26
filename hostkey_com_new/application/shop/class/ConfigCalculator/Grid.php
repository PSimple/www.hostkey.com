<?php

/**
 * View a list of objects by page.
 *
 * To work with the item.
 *
 * @package Shop.ConfigCalculator.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.10.26
 */
class Shop_ConfigCalculator_Grid extends Zero_Crud_Grid
{
    /**
     * The table stores the objects handled by this controller.
     *
     * @var string
     */
    protected $ModelName = 'Shop_ConfigCalculator';

    /**
     * Template view
     *
     * @var string
     */
    protected $ViewName = 'Zero_Crud_Grid';
}