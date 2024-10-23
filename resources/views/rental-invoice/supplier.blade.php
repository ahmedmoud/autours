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
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .section {
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div >
        <div >
            <img width="300" height="100" src="http://staging.autours.net/img/4k-logo.png"/>
        </div>
        <div  style="margin-top: 3%; margin-left: 1%;">
            <p><strong>Booking number:</strong> DC-6528272</p>
        </div>
    </div>

    <div style="display: flex; width: 100%; background: #efeded; border-radius: 15px; padding: 1%;">
        <div style="display: inline-block; width: 48%; padding-right: 2%; vertical-align: top; ">
            <h3>Customer Name</h3>
            <p>Mr. Ahmed El Said Mohamed Fadl</p>
        </div>
        <div style="display: inline-block; width: 48%; vertical-align: top;">
            <h3>Supplier</h3>
            <p>BLITZ - Blitz Car Rentals</p>
        </div>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; width: 100%;">
        <div style="width: 48%; margin-bottom: 20px;">
            <h3 style="font-size: 1.2em; margin-bottom: 0.5em;">Pick-up</h3>
            <p style="margin-bottom: 0.5em;">29 October 2023, Sunday, 20:00</p>
            <p style="margin-bottom: 0.5em;">Dubai Int. Airport (DXB) - Meet & Greet</p>
            <p style="margin-bottom: 0.5em;">Address: Dubai International Airport, 67 Airport Rd, Garhoud, Dubai</p>
            <p style="margin-bottom: 0.5em;">Business hours: 08:00-23:00 (Sunday)</p>
            <p style="margin-bottom: 0.5em;">Phone: 00971523804237</p>
        </div>
        <div style="width: 48%; margin-bottom: 20px;">
            <h3 style="font-size: 1.2em; margin-bottom: 0.5em;">Drop-off</h3>
            <p style="margin-bottom: 0.5em;">3 November 2023, Friday, 20:00</p>
            <p style="margin-bottom: 0.5em;">Dubai Int. Airport (DXB) - Meet & Greet</p>
            <p style="margin-bottom: 0.5em;">Address: Dubai International Airport, 67 Airport Rd, Garhoud, Dubai</p>
            <p style="margin-bottom: 0.5em;">Business hours: 08:00 - 23:00 (Friday)</p>
            <p style="margin-bottom: 0.5em;">Phone: 00971523804237</p>
        </div>
    </div>

    <div class="section">
        <h3>Car details</h3>
        <table>
            <tr>
                <th>Car</th>
                <td>Full-size Toyota Camry or similar, FDAV/SDAR</td>
            </tr>
            <tr>
                <th>Seats/Doors</th>
                <td>5 seats, 4 doors</td>
            </tr>
            <tr>
                <th>Features</th>
                <td>Air Conditioning, Automatic, Gasoline</td>
            </tr>
            <tr>
                <th>Fuel Policy</th>
                <td>Same to same</td>
            </tr>
            <tr>
                <th>Mileage</th>
                <td>Unlimited</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Protection</h3>
        <table>
            <tr>
                <th>Included Insurance</th>
                <th>Included</th>
            </tr>
            <tr>
                <td>Collision Damage Waiver (deductible: ~130.00 KWD)</td>
                <td>✓</td>
            </tr>
            <tr>
                <td>Roadside Assistance</td>
                <td>✓</td>
            </tr>
            <tr>
                <td>Theft Protection</td>
                <td>✓</td>
            </tr>
            <tr>
                <td>Third Party Liability (TPL)</td>
                <td>✓</td>
            </tr>
            <!-- Add other protection items here -->
        </table>
    </div>

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
