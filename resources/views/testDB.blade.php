<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
</head>
<body>
    <form id="paymentForm">
        <label for="cardholderName">Cardholder's Name</label>
        <input type="text" id="cardholderName" name="cardholderName" required><br>

        <label for="cardNumber">Card Number</label>
        <input type="text" id="cardNumber" name="cardNumber" required><br>

        <label for="expMonth">Expiration Month</label>
        <input type="text" id="expMonth" name="expMonth" required><br>

        <label for="expYear">Expiration Year</label>
        <input type="text" id="expYear" name="expYear" required><br>

        <label for="cvc">CVC</label>
        <input type="text" id="cvc" name="cvc" required><br>

        <button type="button" onclick="encryptAndSubmit()">Submit Payment</button>
    </form>

    <script>
        function encryptAndSubmit() {
            // Get form data
            const cardholderName = document.getElementById('cardholderName').value;
            const cardNumber = document.getElementById('cardNumber').value;
            const expMonth = document.getElementById('expMonth').value;
            const expYear = document.getElementById('expYear').value;
            const cvc = document.getElementById('cvc').value;

            // Encryption key (in a real-world scenario, do not hardcode; dynamically generate or fetch from secure source)
            const secretKey = "my-secret-key";

            // Encrypt each field
            const encryptedCardholderName = CryptoJS.AES.encrypt(cardholderName, secretKey).toString();
            const encryptedCardNumber = CryptoJS.AES.encrypt(cardNumber, secretKey).toString();
            const encryptedExpMonth = CryptoJS.AES.encrypt(expMonth, secretKey).toString();
            const encryptedExpYear = CryptoJS.AES.encrypt(expYear, secretKey).toString();
            const encryptedCVC = CryptoJS.AES.encrypt(cvc, secretKey).toString();

            // Create JSON object
            const encryptedData = {
                cardholderName: encryptedCardholderName,
                cardNumber: encryptedCardNumber,
                expMonth: encryptedExpMonth,
                expYear: encryptedExpYear,
                cvc: encryptedCVC
            };

            // Display encrypted data in console
            console.log("Encrypted Data: ", encryptedData);

            // Optionally save to a file (for demonstration, creating a downloadable JSON file)
            const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(encryptedData));
            const downloadAnchorNode = document.createElement('a');
            downloadAnchorNode.setAttribute("href", dataStr);
            downloadAnchorNode.setAttribute("download", "encrypted_data.json");
            document.body.appendChild(downloadAnchorNode); // required for firefox
            downloadAnchorNode.click();
            downloadAnchorNode.remove();
        }
    </script>
</body>
</html>
