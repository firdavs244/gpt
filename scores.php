<?php
// Natijalarni JSON faylidan o'qish
$results_file = 'results.json';
if (file_exists($results_file)) {
    $results_data = json_decode(file_get_contents($results_file), true);
} else {
    $results_data = [];
}

ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natijalar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .result-message {
            font-size: 1rem;
            font-weight: bold;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }
        .correct {
            background-color: #28a745;
            color: white;
        }
        .incorrect {
            background-color: #dc3545;
            color: white;
        }
        .btn-back {
            background-color: #007bff;
            color: white;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4">Foydalanuvchi Natijalari</h1>

    <?php if (!empty($results_data)): ?>
        <?php foreach ($results_data as $result): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Natija: <?= $result['date'] ?></h5>
                    <p class="card-text">
                        <?php foreach ($result['results'] as $test => $test_result): ?>
                            <strong><?= ucfirst($test) ?>:</strong>
                            <?php if ($test_result['correct']): ?>
                                <span class="badge badge-success">To'g'ri</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Noto'g'ri</span>
                            <?php endif; ?>
                            <br>
                        <?php endforeach; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning">Hozirda hech qanday natijalar mavjud emas.</div>
    <?php endif; ?>

    <div class="text-center">
        <a href="index.php" class="btn btn-back">Testga qaytish</a>
    </div>
</div>
</body>
</html>
