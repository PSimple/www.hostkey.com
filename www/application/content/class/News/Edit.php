<?php

/**
 * Редактирование новости
 *
 * @package Content.Controller.News
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.06.09
 */
class Content_News_Edit extends Zero_Web_Crud_Edit
{
    /**
     * The table stores the objects handled by this controller.
     *
     * @var string
     */
    protected $ModelName = 'Content_News';

    /**
     * Template view
     *
     * @var string
     */
    protected $ViewName = 'Zero_Web_Crud_Edit';
}