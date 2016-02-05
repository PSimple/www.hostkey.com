<?php

/**
 * Изменение решений
 *
 * @package Shop.Solution
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015-02-04
 */
class Shop_Solution_Edit extends Zero_Crud_Edit
{
    /**
     * The table stores the objects handled by this controller.
     *
     * @var string
     */
    protected $ModelName = 'Shop_Solution';

    /**
     * Template view
     *
     * @var string
     */
    protected $ViewName = 'Zero_Crud_Edit';
}