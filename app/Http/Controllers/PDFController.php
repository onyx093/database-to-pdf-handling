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
        $payer_data = $this->getPaginatedPayers();
        return view('data-list', compact('payer_data'));
    }

    public function getPaginatedPayers()
    {
        return DB::table('tax_payers')->paginate(20);
    }

    public function getPayers()
    {
        return DB::table('tax_payers')->get();
    }

    /* public function getPayersCount()
    {
        return DB::table('Payers')->count();
    } */

    public function convertDataToHTML()
    {
        $payer_data = $this->getPayers();
        $output = '<h1 style="margin-top: 3rem; text-align: center;" >Payer\'s name list from the database</h1>
                <table width="100%" style="border-collapse: collapse; border: 2px solid rgb(200, 200, 200); letter-spacing: 1px; font-family: sans-serif; font-size: .8rem;">
                    <thead style="background-color: #3f87a6; color: #fff;" >
                        <tr>
                            <th>S/N</th>
                            <th>RIN</th>
                            <th>Name</th>
                            <th>Start Month</th>
                            <th>End Month</th>
                            <th>Gross</th>
                            <th>CRA</th>
                            <th>Pension</th>
                            <th>NHF</th>
                            <th>NHIS</th>
                            <th>Taxfree Pay</th>
                            <th>CH.  Income</th>
                            <th>M.  Tax</th>
                            <th>EXP  .A.Tax</th>
                        </tr>
                    </thead><tbody style="background-color: #e4f0f5;" >';
        
        /* <td style="border: 1px solid rgb(190, 190, 190); text-align: center; padding: 5px 10px;">'. $payer->id .'</td>
        <td style="border: 1px solid rgb(190, 190, 190); text-align: center; padding: 5px 10px;">'. $payer->name .'</td>
        <td style="border: 1px solid rgb(190, 190, 190); text-align: center; padding: 5px 10px;">'. $payer->email .'</td>
        <td style="border: 1px solid rgb(190, 190, 190); text-align: center; padding: 5px 10px;">'. $payer->email_verified_at .'</td> */

        $i = 0;
        $total_gross_pay = 0;
        $total_tax_payable = 0;
        $total_annual_tax = 0;

        foreach($payer_data as $data)
        {
            $output .= '<tr>
                            <td>' . ++$i . '</td>
                            <td>' . $data->payer_rin . '</td>		
                            <td>' . $data->payer_name . '</td>
                            <td>' . $data->start_month . '</td>
                            <td>' . $data->end_month . '</td>
                            <td>' . number_format($data->gross_pay, 2) . '</td>
                            <td>' . number_format($data->consolidated_relief_allowance, 2) . '</td>
                            <td>' . number_format($data->pension_contribution_declared, 2) . '</td>
                            <td>' . number_format($data->nhf_contribution_declared, 2) . '</td>
                            <td>' . number_format($data->nhis_contribution_declared, 2) . '</td>
                            <td>' . number_format($data->tax_free_pay, 2) . '</td>
                            <td>' . number_format($data->chargeable_income, 2) . '</td>
                            <td>' . number_format($data->tax_payable, 2) . '</td>
                            <td>' . number_format($data->annual_tax, 2) . '</td>
                        </tr>';

            $total_gross_pay += $data->gross_pay;
            $total_tax_payable += $data->tax_payable;
            $total_annual_tax += $data->annual_tax;

        }
        $output .= '<tr>
                        <td colspan="5"><b>TOTAL</b></td>
                        <td><strong>' . number_format($total_gross_pay, 2) . '</strong></td>
                        <td colspan="6"></td>		
                        <td><strong>' . number_format($total_tax_payable, 2) . '</strong></td>		
                        <td><strong>' . number_format($total_annual_tax, 2) . '</strong></td>
                    </tr>';

        $output .= '</tbody></table>';
        return $output;
    }

    // TODO:
    // 1. Create the tax payer table - done
    // 2. Fill it up with appropriate columns from the tax payer's sheet - done
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
        $pdf->setOptions(array('orientation' => 'landscape'));
        $pdf->addPage($this->convertDataToHTML());

        if (!$pdf->send()) {
            $error = $pdf->getError();
            // ... handle error here
        }
    }

}
