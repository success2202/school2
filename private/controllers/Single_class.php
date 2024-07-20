<?php
//single class controller

class Single_class extends controller
{
    function index($id = '')
    {
       
        $classes = new Classes_model();
        $row = $classes->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['classes', 'classes'];
       
        if($row)
        {
            $crumbs[] = [$row->class,''];
            
        }
            $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lecturers';
          $this->view('single-class',[
            'row'=>$row,
            'crumbs'=>$crumbs,
            'page_tab'=>$page_tab,
          ]);
    }
    
}


