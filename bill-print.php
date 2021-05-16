<?php
$bill_id = $_GET['bill_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Bill</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<style type="text/css">
    table {
        border-collapse: collapse;
        width: 92.5%;
        border-spacing: 0;
        border: 1px solid #ddd;
        background-color: #fff;
        margin-top: 50px;
        margin-left: 50px;
        margin-right: 50px;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .tds {
        text-align: left;
        padding: 5px;
        font-size: 18px;
    }

    @media (max-width: 1131px) {
        .doc {
            margin-left: 50px;
            margin-right: 50px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            margin-right: 0px;
            margin-left: 0px;
        }
    }
</style>

<body>
<div class="float-right mr-4">
    <button class="btn btn-primary btn-md" onclick="window.print()">Print Bill</button>
    </div>
    <div class="container mt-5">
    <div>
        <div class="float-right">
            <img src="./ceb.png" width="150px" alt="">
        </div>

        <div style="position: absolute;z-index: 999;margin-top: 30px;margin-left: 50px;">
            <h1>Ceylon Electrcity Board</h1>
            <h3>Electrcity Bill</h3>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th nowrap="true"
                    style="text-align: left; padding: 5px; background-color: #000; color: #fff; font-size: 18px;">
                    Discription</th>
                <th nowrap="true"
                    style="text-align: right; padding: 5px; background-color: #000; color: #fff; font-size: 18px;">Price
                </th>
            </tr>
        </thead>
        <tbody id="billData">

        </tbody>
    </table>

    <h4 id="notice" class="text-center mt-4" style="color: red;"></h1>
    </div>
   


    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/8.5.0/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.5.0/firebase-database.js"></script>

    <script>
        const queryString = window.location.search;
        console.log(queryString);

        const urlParams = new URLSearchParams(queryString);
        const bill_id = urlParams.get('bill_id');
        console.log(bill_id);

        var firebaseConfig = {
            apiKey: "AIzaSyBOfNZHQ9c_-KS6WDdGMjKSRvvGNzAFNg4",
            authDomain: "smart-power-meter-44e02.firebaseapp.com",
            databaseURL: "https://smart-power-meter-44e02-default-rtdb.firebaseio.com",
            projectId: "smart-power-meter-44e02",
            storageBucket: "smart-power-meter-44e02.appspot.com",
            messagingSenderId: "644579599926",
            appId: "1:644579599926:web:4a93acae4245a03fcc9a97",
            measurementId: "G-K930REWS3E"
        };
        firebase.initializeApp(firebaseConfig);

        firebase.database().ref('Bills').child(bill_id).on('value', (data) => {
            let bill = data.val();
            console.log(bill);

            document.getElementById('billData').innerHTML = '';
            var i = 0;

            document.getElementById('billData').innerHTML += `
                <tr>
                <td nowrap="true" style="text-align: left; padding: 5px; font-size: 18px;">Billing Date</td>
                <td nowrap="true" style="text-align: right; padding: 5px; font-size: 18px;">${bill.billingDate}</td>
                </tr>

                <tr>
                <td nowrap="true" style="text-align: left; padding: 5px; font-size: 18px;">Service Charge</td>
                <td nowrap="true" style="text-align: right; padding: 5px; font-size: 18px;">${bill.serviceCharge}</td>
                </tr>

                <tr>
                <td nowrap="true" style="text-align: left; padding: 5px; font-size: 18px;">Amperes (A)</td>
                <td nowrap="true" style="text-align: right; padding: 5px; font-size: 18px;">${bill.ampval}</td>
                </tr>

                <tr>
                <td nowrap="true" style="text-align: left; padding: 5px; font-size: 18px;">Power Usage (Kw)</td>
                <td nowrap="true" style="text-align: right; padding: 5px; font-size: 18px;">${bill.powerUsage}</td>
                </tr>

                <tr>
                    <td nowrap="true" style="text-align: left; padding: 5px; font-size: 18px;">Daily Usage</td>
                    <td nowrap="true" style="text-align: right; padding: 5px; font-size: 18px;">${bill.dailyUsage}</td>
                </tr>

                <tr>
                    <td nowrap="true" style="text-align: left; padding: 5px; font-size: 18px;">Due Amount</td>
                    <td nowrap="true" style="text-align: right; padding: 5px; font-size: 18px;">${bill.dueAmount}</td>
                </tr>

                <tr>
                    <td nowrap="true" style="text-align: right; padding: 5px; font-size: 20px;"><b>Total Amount Of Bill</b></td>
                    <td nowrap="true" style="text-align: right; padding: 5px; font-size: 20px;"><b>${bill.totalAmount}</b></td>
                </tr>
                `;

                let total = bill.totalAmount;
                if(total>4000){
                    var message = "<strong>NOTICE!</strong> Pay off arrears and avoid power outages";
                    document.getElementById("notice").innerHTML = message;
                }
                
        });

        function printBill(){
            window.print();
        } 
        // });
    </script>
</body>

</html>