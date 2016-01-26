<?php

/**
 * A two-level navigation through the main sections of the site.
 *
 * - 2 и 3 уровень.
 * Sample: {plugin "Zero_Section_Plugin_NavigationAccordion" view="" section_id="0"}
 *
 * @package Zero.Section.Navigation
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2015.01.01
 */
class Content_Section_Plugin_NavigationAccordion extends Zero_Controller
{
    /**
     * Vy`polnenie dei`stvii`
     *
     * @return Zero_View or string
     */
    public function Action_Default()
    {

        $index = __CLASS__ . Zero_App::$Users->Groups_ID . Zero_App::$Config->Site_DomainSub;
        //  $Section = Zero_Model::Makes('Zero_Section');
        $Section = Zero_Section::Make();
        if ( isset($this->Params['section_id']) && 0 < $this->Params['section_id'] )
        {
            $Section = Zero_Model::Makes('Zero_Section', $this->Params['section_id']);
            $index .= $this->Params['section_id'];
        }
        else
            $Section->Init_Url('/');

        if ( false === $navigation = $Section->Cache->Get($index) )
        {
            $navigation = Zero_Section::DB_Navigation_Child($Section->ID);
            foreach (array_keys($navigation) as $id)
            {
                $navigation[$id]['child'] = Zero_Section::DB_Navigation_Child($id);
            }
            Zero_Cache::Set_Link('Section', $Section->ID);
            $Section->Cache->Set($index, $navigation);
        }

        foreach ($navigation as $key => $value)
        {
            $navigation[$key]['action'] = 0;
            $pattern = '*' . str_replace("/", "\/", $value["Url"]) . '*';
            preg_match($pattern, Zero_App::$Section->Url, $m);

            if ( preg_match($pattern, Zero_App::$Section->Url) )
            {
                $navigation[$key]['action'] = 1;
            }
            if ( isset($value['child']) )
            {

                foreach ($value['child'] as $k => $v)
                {
                    $pattern = '*(' . str_replace("/", "\/", $v["Url"]) . ')*';
                    $navigation[$key]['child'][$k]['action'] = 0;
                    if ( preg_match($pattern, Zero_App::$Section->Url, $m) )
                    {
                        $navigation[$key]['action'] = 1;
                        $navigation[$key]['child'][$k]['action'] = 1;
                    }
                }
            }
        }
        if ( isset($this->Params['view']) )
            $this->View = new Zero_View($this->Params['view']);
        else
            $this->View = new Zero_View(get_class($this));
        $this->View->Assign('Section', Zero_App::$Section);
        $this->View->Assign('NAVIGATION', $navigation);
        return $this->View;
    }
}