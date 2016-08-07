<?php

/**
 * View a list of objects by page.
 *
 * @package Shop.Controller.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.25
 */
class Shop_DomainsZone_Grid extends Zero_Web_Crud_Grid
{
    /**
     * The table stores the objects handled by this controller.
     *
     * @var string
     */
    protected $ModelName = 'Shop_DomainsZone';

    /**
     * Template view
     *
     * @var string
     */
    protected $ViewName = 'Zero_Web_Crud_Grid';
}