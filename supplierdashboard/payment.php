<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container input[type="text"] {
            padding: 10px;
        }

        .form-container input[type="submit"] {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form action="">
            <div class="mb-3">
                <label for="nbr" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="nbr" name="nbr" placeholder="Shyiramo nimero">
            </div>
            <button type="submit" class="btn btn-success w-100">Make Payment</button> <!-- Green button -->
        </form>
    </div>

    <!-- Bootstrap JS (optional, for responsiveness features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
