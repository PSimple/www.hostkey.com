<?php

/**
 * Контроллер изменения объекта
 *
 * @package Shop.ConfigCalculator.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.10.26
 */
class Shop_ConfigCalculator_Edit extends Zero_Crud_Edit
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
    protected $ViewName = 'Zero_Crud_Edit';

    /**
     * Initialization of the input parameters
     *
     * @return boolean flag stop execute of the next chunk
     */
    protected function Chunk_Init()
    {
        parent::Chunk_Init();
        return true;
    }
}