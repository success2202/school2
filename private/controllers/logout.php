<?php
//logout controller

class Logout extends controller
{
    function index()
    {
        Auth::logout();
      $this->redirect('login');
          
        }
         
    
    
}