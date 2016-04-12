<?php
/**
 * Форма реадиткирования выбранного контент-блока
 *
 * Управление контент-блоками на страницах.
 *
 * @package Content.Controller.ContentBlock
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.09.01
 */
class Content_ContentBlock_EditSection extends Zero_Crud_Edit
{
    /**
     * The table stores the objects handled by this controller.
     *
     * @var string
     */
    protected $ModelName = 'Content_ContentBlock';

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
        $this->Params['obj_parent_prop'] = 'Section_ID';
        $this->Params['obj_parent_name'] = '';
        parent::Chunk_Init();
        return true;
    }
}