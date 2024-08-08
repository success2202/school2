<?php
//single test controller

class Single_test extends controller
{
    public function index($id = '')
    {
      $errors = array();
      if(!Auth::logged_in())
      {
          $this->redirect('login');
      }
        $tests = new Tests_model();
        $row = $tests->first('class_id', $id);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['tests', 'tests'];
       
        if($row)
        {
            $crumbs[] = [$row->test,''];
            
        }
        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'view';

        $limit = 3;
        $pager = new Pager($limit);
        $offset = $pager->offset;
       
        $results = false;

        $data['row']      = $row;
        $data['crumbs']   = $crumbs;
        $data['page_tab'] = $page_tab;
        $data['results']  = $results;
        $data['errors']  = $errors;
        $data['pager']  = $pager;

        $this->view('single-test',$data);

        }
   }


