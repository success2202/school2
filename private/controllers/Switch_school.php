<?php
//change school controller

class Switch_school extends controller
{
     function index($id = '')
    {
      if(Auth::access('superAdmin')){
        Auth::switch_school($id);
      }
       
      $this->redirect('schools');
          
        }
         
    
    
}