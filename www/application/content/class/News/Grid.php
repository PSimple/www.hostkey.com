<?php

/**
 * Список новостей в админке
 *
 * Управление новостями
 *
 * @package Content.News.Controller
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.06.09
 */
class Content_News_Grid extends Zero_Crud_Grid
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
    protected $ViewName = 'Zero_Crud_Grid';

    /**
     * Initialization filters
     *
     * @return boolean flag stop execute of the next chunk
     */
    protected function Chunk_Init()
    {
        parent::Chunk_Init();
        $Filter = Zero_Filter::Factory($this->Model);
        if ( !$Filter->IsSet )
            $Filter->Set_Sort('DateCreate', 'DESC');
        return true;
    }

    /**
     * Initialization of the stack chunks and input parameters
     *
     * @return boolean flag stop execute of the next chunk
     */
    public function Action_FilterReset()
    {
        $this->Chunk_Init();

        $Filter = Zero_Filter::Factory($this->Model);
        $Filter->Reset();
        $Filter->Page = 1;
        $Filter->Set_Sort('DateCreate', 'DESC');

        $this->Chunk_View();
        return $this->View;
    }
}