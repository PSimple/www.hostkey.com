<?php

/**
 * Управление FaqSpeedtest редактирование
 *
 * @package Content.Controller.FaqSpeedtest
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.11.19
 */
class Content_FaqSpeedtest_Edit extends Zero_Web_Crud_Edit
{
    /**
     * The table stores the objects handled by this controller.
     *
     * @var string
     */
    protected $ModelName = 'Content_FaqSpeedtest';

    /**
     * Template view
     *
     * @var string
     */
    protected $ViewName = 'Zero_Web_Crud_Edit';
}