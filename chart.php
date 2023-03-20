<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        #chart {
            width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <canvas id="chart"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chart').getContext('2d');
    <?php
        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "root", "water_billing_system");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Query the bills table and retrieve the data
        $sql = "SELECT bill_amount, bill_date FROM bills";
        $result = mysqli_query($conn, $sql);

        // Prepare the labels and data arrays for Chart.js
        $labels = array();
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $labels[] = $row['bill_date'];
            $data[] = $row['bill_amount'];
        }
        mysqli_close($conn);
    ?>
    const data = {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Water Bill Payments',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            data: <?php echo json_encode($data); ?>,
        }]
    };
    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Water Bill Payments'
                    },
                    legend: {
                        display: false
                    },
                },
            },
        };
        const myChart = new Chart(ctx, config);
    </script>
</body>
</html>