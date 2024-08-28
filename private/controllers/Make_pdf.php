<?php
//make pdf controller

class Make_pdf extends controller
{
    function index()
    {
        if(!Auth::logged_in())
        {
            $this->redirect('login');
        }

        $folder = 'generated_pdfs/';
        if(!file_exists($folder))
        {
            mkdir($folder,0777,true);
        }
        require_once __DIR__ . '/../models/mpdf/autoload.php';
        
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->Output('mypdf.pdf');
        
    }
    
}


