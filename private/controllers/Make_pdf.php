<?php
//make pdf controller

class Make_pdf extends controller
{
    function index( $id = '',$user_id = '')
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
         
            $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

         $mpdf = new \Mpdf\Mpdf([
            'fontdata' => $fontData + [ // lowercase letters only in font key
                'dhyana' => [
                    'R' => 'Dhyana-Regular.ttf',
                    'B' => 'Dhyana-Bold.ttf',
                ]
            ],
       
    ]);
        $html = file_get_contents(ROOT.'/make_text_pdf/yRN7Go4Jl4NB4DFSv0CFcRROfvCy8WEGKvoYyDI60IdP5S5QgoumLj3Sh0UY/ada%20.uja');
        $mpdf->WriteHTML($html);
        $mpdf->Output($folder.$user_id.'_test_results_'.date("Y-m-d_H_i_s",time()).'.pdf');
        
    }
    
}


