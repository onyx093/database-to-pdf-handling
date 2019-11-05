<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <title>Username list from the database</title>
</head>
<body>
    <h1>Names list from the database</h1>

<a href="{{ route('generate-pdf') }}">Generate PDF</a>

    <table>
        <thead>
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
        </thead>
        <?php 
            
            $i = 0;
            $total_gross_pay = 0;
            $total_tax_payable = 0;
            $total_annual_tax = 0;
            
        
            ?>
        <tbody>
            @foreach($payer_data as $data)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $data->payer_rin }}</td>		
                <td>{{ $data->payer_name }}</td>
                <td>{{ $data->start_month }}</td>
                <td>{{ $data->end_month }}</td>
                <td>{{ number_format($data->gross_pay ,2) }}</td>
                <td>{{ number_format($data->consolidated_relief_allowance ,2) }}</td>
                <td>{{ number_format($data->pension_contribution_declared ,2) }}</td>
                <td>{{ number_format($data->nhf_contribution_declared ,2) }}</td>
                <td>{{ number_format($data->nhis_contribution_declared ,2) }}</td>
                <td>{{ number_format($data->tax_free_pay ,2) }}</td>
                <td>{{ number_format($data->chargeable_income ,2) }}</td>
                <td>{{ number_format($data->tax_payable ,2) }}</td>
                <td>{{ number_format($data->annual_tax ,2) }}</td>
            </tr>
         <?php
																					
			$total_gross_pay += $data->gross_pay;
			$total_tax_payable += $data->tax_payable;
			$total_annual_tax += $data->annual_tax;
		   ?>																
            
            @endforeach
            <tr>
                <td colspan="5"><b>TOTAL</b></td>
                <td><strong>{{ number_format($total_gross_pay,2) }}</strong></td>
                <td colspan="6"></td>		
				<td><strong>{{ number_format($total_tax_payable,2) }}</strong></td>		
				
				<td><strong>{{ number_format($total_annual_tax,2) }}</strong></td>			

            </tr>
        </tbody>
    </table>

    <p>{{ $payer_data->links() }}</p>
</body>
</html>