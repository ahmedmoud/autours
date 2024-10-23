<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Autours Car Rental Invoice</title>
    <style>

        /* Add your CSS styling here */
        body {
            font-family: sans-serif;
            margin: 0; /* Remove default body margin */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;

        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .two-column-table {
            width: 100%;
            display: table;
        }
        .two-column-table > div {
            display: table-cell;
            width: 48%;
            padding: 0 1%;
            vertical-align: top;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        img {
            max-width: 100%; /* Ensure image doesn't overflow */
            height: auto;
        }
        .section {
            margin-bottom: 20px;
        }
        .border-color {
            border-color: rgba(255,255,255,0);
        }
    </style>
</head>
<body>
<div class="container">
    <table class="border-color" >
        <tr class="border-color">
            <td class="border-color" style=" width: 50%; text-align: left;">
                <img width="300" height="100" src="http://staging.autours.net/img/4k-logo.png"/>
            </td>
            <td class="border-color" style=" width: 50%; text-align: right; ">
                <p><strong>Booking number:</strong> {{isset($rental) ? $rental->order_number : ''}}</p>
            </td>
        </tr>
    </table>
    <table class="border-color" style="background-color: #e6e6e6; ">
        <tr class="border-color">
            <td class="border-color" style=" width: 50%; text-align: left;">
                <h3>Customer Name</h3>
                <p>{{isset($rental) ? $rental->customer->name : ''}}</p>
            </td>
            <td class="border-color" style=" width: 50%;">
                <h3>Supplier</h3>
                <p>{{isset($rental) ?  $rental->supplier->name : ''}}</p>
            </td>
        </tr>
    </table>


    <table class="border-color" style="background-color: #e6e6e6; ">
        <tr class="border-color">
            <td class="border-color" style=" width: 50%; text-align: left;">
                <div style="width: 48%; margin-bottom: 20px;">
                    <h3 style="font-size: 1.2em; margin-bottom: 0.5em;">Pick-up</h3>
                    <p style="margin-bottom: 0.5em;">{{isset($rental) ? \Carbon\Carbon::parse($rental->start_date)->format("d M Y") .' '. \Carbon\Carbon::parse($rental->start_date)->dayName
                        . ', ' . \Carbon\Carbon::parse($rental->start_time)->format("h i A") : ''}}</p>
                    <p style="margin-bottom: 0.5em;">{{isset($rental) ? $rental->vehicle->branch->location . ' ' . count($rental->vehicle->locationType) ? $rental->vehicle->locationType[0]->name  : '': ''}}</p>
                    <p style="margin-bottom: 0.5em;">Address: {{isset($rental) ? $rental->vehicle->branch->adresse : ''}}</p>
                    <p style="margin-bottom: 0.5em;">Business hours: 08:00-23:00 (Sunday)</p>
                    <p style="margin-bottom: 0.5em;">Phone: {{isset($rental)? $rental->supplier->phone_num : ' '}}</p>
                </div>
            </td>
            <td class="border-color" style=" width: 50%;">
                <div style="width: 48%; margin-bottom: 20px;">
                    <h3 style="font-size: 1.2em; margin-bottom: 0.5em;">Drop-off</h3>
                    <p style="margin-bottom: 0.5em;">{{isset($rental) ? \Carbon\Carbon::parse($rental->end_date)->format("d M Y") .' '. \Carbon\Carbon::parse($rental->start_date)->dayName
                        . ', ' . \Carbon\Carbon::parse($rental->end_time)->format("h i A") : ''}}</p>
                    <p style="margin-bottom: 0.5em;">{{isset($rental) ? $rental->vehicle->branch->location . ' ' . count($rental->vehicle->locationType) ? $rental->vehicle->locationType[0]->name  : '': ''}}</p>
                    <p style="margin-bottom: 0.5em;">Address: {{isset($rental) ? $rental->vehicle->branch->adresse : ''}}</p>
                    <p style="margin-bottom: 0.5em;">Business hours: 08:00-23:00 (Sunday)</p>
                    <p style="margin-bottom: 0.5em;">Phone: {{isset($rental)? $rental->supplier->phone_num : ' '}}</p>
                </div>
            </td>
        </tr>
    </table>

    <table class="border-color" style="background-color: #e6e6e6; ">
        <tr class="border-color">
            <td class="border-color" style=" width: 50%; text-align: left;">
        <div style="width:48%; margin-bottom: 20px;">
            <h3 style="font-size: 1.2em; margin-bottom: 10px;">Car details</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Car</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Full-size Toyota Camry or
                        similar, FDAV/SDAR
                    </td>
                </tr>
                <tr style="background-color: white;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Seats/Doors</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">5 seats, 4 doors</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Features</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Air Conditioning, Automatic,
                        Gasoline
                    </td>
                </tr>
                <tr style="background-color: white;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Fuel Policy</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Same to same</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Mileage</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Unlimited</td>
                </tr>
            </table>
        </div>
            </td>
            <td class="border-color" style=" width: 50%; text-align: left;">
        <div style="width:48%; margin-bottom: 20px;">
            <h3 style="font-size: 1.2em; margin-bottom: 10px;">Protection</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Included Insurance</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Included</th>
                </tr>
                <tr style="background-color: white;">
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Collision Damage Waiver
                        (deductible: ~130.00 KWD)
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">✓</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Roadside Assistance</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">✓</td>
                </tr>
                <tr style="background-color: white;">
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Theft Protection</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">✓</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Third Party Liability (TPL)</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">✓</td>
                </tr>
            </table>
        </div>
            </td>
        </tr>


    </table>

    <div class="section">
        <h3>Payment</h3>
        <p>Pay at pick-up</p>
        <p>500.60 AED (~42.13 KWD)</p>
        <p>Refundable Security Deposit: 1500.00 AED (~130.00 KWD)</p>
    </div>

    <div class="section">
        <h3>What you need to bring</h3>
        <ul>
            <li>Voucher</li>
            <li>Driver's license</li>
            <li>Passport/Identity card</li>
            <li>Credit or debit card</li>
        </ul>
        <p>Accepted Credit/Debit Cards: American Express, MasterCard, VISA</p>
    </div>

    <!-- Add remaining sections similarly -->
</div>
</body>
</html>
