<?php
/**
 * Постраничный вывод
 *
 * Управление текстовыми вставками.
 *
 * @package Content.Controller.ContentLittle
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.11.19
 */
class Content_ContentLittle_Grid extends Zero_Web_Crud_Grid
{
    /**
     * The table stores the objects handled by this controller.
     *
     * @var string
     */
    protected $ModelName = 'Content_ContentLittle';

    /**
     * Template view
     *
     * @var string
     */
    protected $ViewName = 'Zero_Web_Crud_Grid';
}