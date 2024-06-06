<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fake Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Lățimea containerului */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            width: 100%; /* Lățimea butonului */
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Stripe.</h1>
        <form method="post" action="fake_payment.php">
            <div>
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount" placeholder="200.00" required>
            </div>
            <div>
                <label for="card_number">Card Number</label>
                <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
            </div>
            <div>
                <label for="expiration_date">Expiration Date (MM/YY)</label>
                <input type="text" id="expiration_date" name="expiration_date" placeholder="01/23" required>
            </div>
            <div>
                <label for="cvv">CVV</label>
                <input type="password" id="cvv" name="cvv" placeholder="123" required>
            </div>
            <button type="submit" name="process_payment">Process Payment</button>
        </form>
    </div>
</body>
</html>
