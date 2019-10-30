<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//use PDF;
use mikehaertl\wkhtmlto\Pdf;

class PDFController extends Controller
{
    //
    public function index()
    {
        $user_data = $this->getPaginatedUsers();
        return view('data-list', compact('user_data'));
    }

    public function getPaginatedUsers()
    {
        return DB::table('users')->paginate(20);
    }

    public function getUsers()
    {
        return DB::table('users')->get();
    }

    /* public function getUsersCount()
    {
        return DB::table('users')->count();
    } */

    public function convertDataToHTML()
    {
        $user_data = $this->getUsers();
        $output = '<h1 style="margin-top: 3rem; text-align: center;" >Username list from the database</h1>
                <table width="100%" style="border-collapse: collapse; border: 2px solid rgb(200, 200, 200); letter-spacing: 1px; font-family: sans-serif; font-size: .8rem;">
                    <thead style="background-color: #3f87a6; color: #fff;" >
                        <tr>
                            <th style="border: 1px solid rgb(190, 190, 190); padding: 5px 10px;" width="5%">Id</th>
                            <th style="border: 1px solid rgb(190, 190, 190); padding: 5px 10px;" width="20%">Name</th>
                            <th style="border: 1px solid rgb(190, 190, 190); padding: 5px 10px;" width="30%">Email address</th>
                            <th style="border: 1px solid rgb(190, 190, 190); padding: 5px 10px;" width="25%">Time verified</th>
                        </tr>
                    </thead>';
        foreach($user_data as $user)
        {
            $output .= '<tbody style="background-color: #e4f0f5;" >
                            <tr>
                                <td style="border: 1px solid rgb(190, 190, 190); text-align: center; padding: 5px 10px;">'. $user->id .'</td>
                                <td style="border: 1px solid rgb(190, 190, 190); text-align: center; padding: 5px 10px;">'. $user->name .'</td>
                                <td style="border: 1px solid rgb(190, 190, 190); text-align: center; padding: 5px 10px;">'. $user->email .'</td>
                                <td style="border: 1px solid rgb(190, 190, 190); text-align: center; padding: 5px 10px;">'. $user->email_verified_at .'</td>
                            </tr>
                        </tbody>';
        }

        $output .= '</table>';
        return $output;
    }

    // TODO:
    // 1. Create the tax payer table
    // 2. Fill it up with appropriate columns from the tax payer's sheet
    // 3. Generate data for the tax payer table with its factory
    // 4. Parse the data to pdf converter
    // 5. Stream the generated pdf file

    public function generatePDF()
    {
        $pdf = new Pdf(array(
            'no-outline',         // Make Chrome not complain
            'margin-top'    => 0,
            'margin-right'  => 0,
            'margin-bottom' => 0,
            'margin-left'   => 0,
        
            // Default page options
            'disable-smart-shrinking',
        ));

        $pdf->binary = 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe';
        $pdf->addPage($this->convertDataToHTML());

        if (!$pdf->send()) {
            $error = $pdf->getError();
            // ... handle error here
        }
    }

}
