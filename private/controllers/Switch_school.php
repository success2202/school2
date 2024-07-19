<?php
//change school controller

class Switch_school extends controller
{
    function index($id = '')
    {
        Auth::switch_school($id);
      $this->redirect('schools');
          
        }
         
    
    
}