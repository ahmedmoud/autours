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
            border-color: rgba(255, 255, 255, 0);
        }
    </style>
</head>
<body>
<div class="container">
    <table class="border-color">
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
                <div style="width: 48%; margin-bottom: 20px;">
                    <h3 style="font-size: 1.2em; margin-bottom: 0.5em;">Pick-up</h3>
                    <p style="margin-bottom: 0.5em;">{{isset($rental) ? \Carbon\Carbon::parse($rental->start_date)->format("d M Y") .' '. \Carbon\Carbon::parse($rental->start_date)->dayName
                        . ', ' . \Carbon\Carbon::parse($rental->start_time)->format("h i A") : ''}}</p>
                    <p style="margin-bottom: 0.5em;">{{isset($rental) ? $rental->vehicle->branch->location . ' ' . count($rental->vehicle->locationType) ? $rental->vehicle->locationType[0]->name  : '': ''}}</p>
                    <p style="margin-bottom: 0.5em;">
                        Address: {{isset($rental) ? $rental->vehicle->branch->adresse : ''}}</p>
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
                    <p style="margin-bottom: 0.5em;">
                        Address: {{isset($rental) ? $rental->vehicle->branch->adresse : ''}}</p>
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
                    <table class="border-color" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                        <tr class="border-color" style="background-color: #f2f2f2;">
                            <th class="border-color" style="border: 1px solid #ddd; padding: 8px; text-align: left;">
                                Car
                            </th>
                            <td class="border-color"
                                style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->vehicle_category->name . ' ' . $rental->vehicle->name}}
                            </td>
                        </tr>
                        @for($i = 0; $i< count($rental->vehicle->vehicle_specifications); $i+=2)
                            <tr class="border-color" style="background-color: white;">
                                <th class="border-color"
                                    style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->vehicle_specifications[$i]->name}}</th>
                                <td class="border-color"
                                    style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->vehicle_specifications[$i]->value}}</td>
                            </tr>
                            @if($i+1 < count($rental->vehicle->vehicle_specifications))
                                <tr class="border-color" style="background-color: #f2f2f2;">
                                    <th class="border-color"
                                        style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->vehicle_specifications[$i+1]->name}}</th>
                                    <td class="border-color"
                                        style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->vehicle_specifications[$i+1]->name}}</td>
                                </tr>
                            @endif
                        @endfor
                    </table>
                </div>
            </td>
            <td class="border-color" style=" width: 50%; text-align: left;">
                <div style="width:48%; margin-bottom: 20px;">
                    <h3 style="font-size: 1.2em; margin-bottom: 10px;">Protection</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">

                        @for($i = 0; $i< count($rental->vehicle->included); $i+=2)
                            <tr class="border-color" style="background-color: white;">

                                <th class="border-color"
                                    style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->included[$i]->what_is_included}}</th>
                                @if($rental->vehicle->included[$i]->description)
                                    <td class="border-color"
                                        style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->included[$i]->description}}</td>
                                @endif
                            </tr>

                            @if($i+1 < count($rental->vehicle->included))
                                <tr class="border-color" style="background-color: #f2f2f2;">
                                    <th class="border-color"
                                        style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->included[$i+1]->what_is_included}}</th>
                                    @if($rental->vehicle->included[$i+1]->description)

                                        <td class="border-color"
                                            style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{$rental->vehicle->included[$i+1]->description}}</td>
                                    @endif
                                </tr>
                            @endif
                        @endfor
                    </table>
                </div>
            </td>
        </tr>


    </table>

    <table class="border-color" style="background-color: #e6e6e6; ">
        <tr class="border-color">
            <td class="border-color" style=" width: 50%; text-align: left;">
                <div class="section">
                    <h3 style="margin-top: 1%; margin-bottom: 1%;">Payment</h3>
                    <p>Paid</p>
                    <p>{{$rental->price }}  {{$rental->currency }}</p>
                    <p>No Any other fees or hidden payments</p>
                </div>
            </td>
            <td class="border-color" style=" width: 50%; text-align: left;">
                <div class="section">
                    <h3 style="margin-top: 1%; margin-bottom: 1%;">What you need to bring</h3>
                    <ul>
                        <li>Voucher</li>
                        <li>Driver's license</li>
                        <li>Passport/Identity card</li>
                        <li>Credit or debit card</li>
                    </ul>
                    <p>Accepted Credit/Debit Cards: Knet, MasterCard, VISA</p>
                </div>
            </td>
        </tr>
    </table>

    <!-- Add remaining sections similarly -->
</div>
</body>
</html>
