<!DOCTYPE html>
<html>
<head>
    <title>Billing Form</title>
</head>
<body>

    <h1>Billing Form</h1>

    <form method="post" action="process_billing.php">
        <label for="prev_reading">CLIENT_ID:</label>
        <input type="number" name="client_id" id="client_id" value="<?= $_GET['client_id'] ?>"><br>

        <label for="prev_reading">Previous Reading:</label>
        <input type="number" name="previous_reading" id="previous_reading" required><br>

        <label for="present_reading">Present Reading:</label>
        <input type="number" name="present_reading" id="present_reading" required><br>

        <label for="price_per_meter">Price per Cubic Meter:</label>
        <input type="number" name="price_per_meter" id="price_per_meter" required><br>

        <label for="bill_date">Bill Date:</label>
        <input type="date" name="bill_date" id="bill_date" required><br>

        <button type="submit">Calculate Bill</button>
    </form>

</body>
</html>
