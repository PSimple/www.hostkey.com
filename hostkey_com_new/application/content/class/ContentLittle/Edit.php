<?php
/**
 * Форма реадиткирования
 *
 * Управление текстовыми вставками.
 *
 * @package Content.ContentLittle.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.11.19
 */
class Content_ContentLittle_Edit extends Zero_Crud_Edit
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
    protected $ViewName = 'Zero_Crud_Edit';
}