<?php

$numbers = [];
$maxValue = null;
$positions = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = isset($_POST['numbers']) ? trim($_POST['numbers']) : '';

    if ($raw === '') {
        $error = 'Introduceți valori întregi separate prin spațiu sau virgulă.';
    } else {
        // Separare după spațiu sau virgulă
        $parts = preg_split('/[,\s]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($parts as $p) {
            if (!preg_match('/^-?\d+$/', $p)) {
                $error = 'Toate valorile trebuie să fie numere întregi.';
                break;
            }
            $numbers[] = (int)$p;
        }

        $n = count($numbers);
        if ($error === '') {
            if ($n === 0) {
                $error = 'Vectorul nu poate fi gol.';
            } elseif ($n > 100) {
                $error = 'Numărul de componente nu poate depăși 100.';
            } else {

                $maxValue = $numbers[0];
                foreach ($numbers as $i => $val) {
                    if ($val > $maxValue) {
                        $maxValue = $val;
                    }
                }
                foreach ($numbers as $i => $val) {
                    if ($val === $maxValue) {
                        $positions[] = $i + 1; 
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Vector - maxim și poziții</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            padding: 24px 28px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        h1 {
            margin-top: 0;
            font-size: 22px;
            color: #222;
        }
        p.description {
            color: #555;
            font-size: 14px;
            margin-bottom: 18px;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
            color: #333;
        }
        textarea {
            width: 100%;
            min-height: 80px;
            resize: vertical;
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .btn {
            margin-top: 14px;
            padding: 8px 18px;
            font-size: 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            background: #0069d9;
            color: #fff;
        }
        .btn:hover {
            background: #0053ad;
        }
        .error {
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 6px;
            background: #ffe5e5;
            color: #b30000;
            font-size: 13px;
        }
        .result {
            margin-top: 20px;
            padding: 10px 12px;
            border-radius: 6px;
            background: #e6f3ff;
            color: #064e96;
            font-size: 14px;
        }
        .result strong {
            color: #02315a;
        }
        .code {
            font-family: "Consolas", "Courier New", monospace;
            background: #f0f0f0;
            padding: 4px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Determinarea componentei maximale și a pozițiilor ei</h1>
    <p class="description">
        Introduceți un vector cu <span class="code">n</span> componente întregi (1 ≤ n ≤ 100), separate prin spațiu sau virgulă.
        Se va determina valoarea maximă și toate pozițiile (indexare de la 1) la care apare.
    </p>

    <form method="post">
        <label for="numbers">Vector (ex: 2 7 -3 7 4):</label>
        <textarea id="numbers" name="numbers"><?php
            echo isset($_POST['numbers']) ? htmlspecialchars($_POST['numbers']) : '';
        ?></textarea>
        <button type="submit" class="btn">Calculează</button>
    </form>

    <?php if ($error !== ''): ?>
        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $maxValue !== null): ?>
        <div class="result">
            <p><strong>Vectorul introdus:</strong>
                <?php echo implode(', ', $numbers); ?>
            </p>
            <p><strong>Componenta maximală:</strong> <?php echo $maxValue; ?></p>
            <p><strong>Pozițiile componentei maximale (indexare de la 1):</strong>
                <?php echo implode(', ', $positions); ?>
            </p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>