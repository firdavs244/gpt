<?php
// Oldindan belgilangan javoblar
$correct_answers = [
    'test1' => 'strong',
    'test2' => 'attack',
    'test3' => 'firewall',
    'test4' => 'spoofing',
    // Qo'shimcha testlar
];

// Foydalanuvchi javoblarini olish
$user_answers = [
    'test1' => $_POST['test1'] ?? null,
    'test2' => $_POST['test2'] ?? null,
    'test3' => $_POST['test3'] ?? null,
    'test4' => $_POST['test4'] ?? null,
    // Qo'shimcha testlar
];

// Natijalarni aniqlash
$results = [];
foreach ($correct_answers as $test => $correct_answer) {
    $results[$test] = [
        'correct' => ($user_answers[$test] === $correct_answer),
        'user_answer' => $user_answers[$test]
    ];
}

// Natijalarni JSON faylga yozish
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Natijalarni saqlash
    $results_file = 'results.json';
    if (file_exists($results_file)) {
        $existing_data = json_decode(file_get_contents($results_file), true);
    } else {
        $existing_data = [];
    }

    $new_result = [
        'date' => date('Y-m-d H:i:s'),
        'results' => $results
    ];

    // Natijalarni yangi ro'yxatga qo'shish
    $existing_data[] = $new_result;
    file_put_contents($results_file, json_encode($existing_data, JSON_PRETTY_PRINT));
}

if (isset($_POST['ajax'])) {
    echo json_encode($results);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Axborot Xavfsizligi Testi</title>
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
        .btn-submit {
            background-color: #007bff;
            color: white;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .question-text {
            font-size: 1.2rem;
        }
        .form-check-label {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4">Axborot Xavfsizligi Testi</h1>
    <a href="scores.php" class="mb-5">Natijalar</a>
    <form id="testForm">
        <!-- Test 1 -->
        <div class="card">
            <div class="card-body">
                <h5 class="question-text">Test 1: Xavfsiz parolning shakli qanday bo'lishi kerak?</h5>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test1" value="strong" id="test1-strong">
                    <label class="form-check-label" for="test1-strong">Kuchli parol</label><br>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test1" value="weak" id="test1-weak">
                    <label class="form-check-label" for="test1-weak">Yomon parol</label><br>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test1" value="medium" id="test1-medium">
                    <label class="form-check-label" for="test1-medium">O'rtacha parol</label><br>
                </div>
                <div id="result-test1"></div>
            </div>
        </div>

        <!-- Test 2 -->
        <div class="card">
            <div class="card-body">
                <h5 class="question-text">Test 2: SQL Inyeksiya nima?</h5>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test2" value="attack" id="test2-attack">
                    <label class="form-check-label" for="test2-attack">Xavfli hujum turi</label><br>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test2" value="safe" id="test2-safe">
                    <label class="form-check-label" for="test2-safe">Xavfsiz kod yozish</label><br>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test2" value="null" id="test2-null">
                    <label class="form-check-label" for="test2-null">Hech narsa</label><br>
                </div>
                <div id="result-test2"></div>
            </div>
        </div>

        <!-- Test 3 (Yangi test) -->
        <div class="card">
            <div class="card-body">
                <h5 class="question-text">Test 3: Xavfsiz tarmoqni himoya qilish uchun qanday qurilma kerak?</h5>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test3" value="firewall" id="test3-firewall">
                    <label class="form-check-label" for="test3-firewall">Firewall</label><br>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test3" value="router" id="test3-router">
                    <label class="form-check-label" for="test3-router">Router</label><br>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test3" value="switch" id="test3-switch">
                    <label class="form-check-label" for="test3-switch">Switch</label><br>
                </div>
                <div id="result-test3"></div>
            </div>
        </div>

        <!-- Test 4 (Yangi test) -->
        <div class="card">
            <div class="card-body">
                <h5 class="question-text">Test 4: Spoofing nima?</h5>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test4" value="spoofing" id="test4-spoofing">
                    <label class="form-check-label" for="test4-spoofing">Internetni aldash</label><br>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test4" value="phishing" id="test4-phishing">
                    <label class="form-check-label" for="test4-phishing">Foydalanuvchini aldatish</label><br>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="test4" value="none" id="test4-none">
                    <label class="form-check-label" for="test4-none">Hech narsa</label><br>
                </div>
                <div id="result-test4"></div>
            </div>
        </div>

        <!-- Boshqa testlarni qo'shishingiz mumkin -->
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Formadagi barcha radio tugmalariga event listener qo'shamiz
        document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', function(event) {
                const testName = event.target.name;
                const selectedAnswer = event.target.value;

                // Fetch API orqali javobni tekshiramiz
                fetch('index.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        [testName]: selectedAnswer,
                        ajax: true
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        // Javobni tekshirish va xabar ko'rsatish
                        const result = data[testName];
                        const resultDiv = document.getElementById(`result-${testName}`);

                        if (result.correct) {
                            resultDiv.innerHTML = `<div class="result-message correct">To'g'ri javob!</div>`;
                        } else {
                            resultDiv.innerHTML = `<div class="result-message incorrect">Noto'g'ri javob!</div>`;
                        }

                        // Foydalanuvchi javobni o'zgartira olmasligi uchun radio tugmalarini o'chirib qo'yamiz
                        document.querySelectorAll(`input[name="${testName}"]`).forEach(function(input) {
                            input.disabled = true;
                        });
                    });
            });
        });
    });
</script>
</body>
</html>
