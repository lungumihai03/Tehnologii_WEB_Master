<?php

$result = null;
$m = null;
$n = null;
$product = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $m = isset($_POST['m']) ? (int)$_POST['m'] : null;
    $n = isset($_POST['n']) ? (int)$_POST['n'] : null;

    if ($m === null || $n === null) {
        $error = 'Introdu ambele valori m și n.';
    } elseif ($m <= 0 || $n <= 0) {
        $error = 'm și n trebuie să fie numere naturale (pozitive).';
    } elseif ($m >= n) {
        $error = 'Condiția trebuie să fie m < n.';
    } else {
        $product = 1;
        $found = false;
        for ($i = $m; $i < $n; $i++) {
            if ($i % $m === 0) {
                $product *= $i;
                $found = true;
            }
        }
        if (!$found) {
            $result = 'Nu există numere mai mici decât n divizibile cu m.';
        } else {
            $result = "Produsul numerelor mai mici decât $n, divizibile cu $m, este: $product";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Produs numere divizibile cu m</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background: #f5f7fb;
        }
        .container {
            margin-top: 40px;
            background: #ffffff;
            border-radius: 8px;
            padding: 24px 28px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            margin-top: 0;
            font-size: 22px;
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        .field {
            margin-bottom: 16px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #444;
        }
        input[type="number"] {
            width: 100%;
            padding: 8px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            background: #007bff;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }
        button:hover {
            background: #005fd1;
        }
        .error {
            margin-top: 10px;
            color: #b00020;
            font-size: 14px;
        }
        .result {
            margin-top: 16px;
            padding: 10px 12px;
            border-radius: 4px;
            background: #e8f4ff;
            color: #004a99;
            font-size: 14px;
        }
        .info {
            margin-top: 8px;
            font-size: 12px;
            color: #666;
        }
        .value {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Produsul numerelor divizibile cu m</h1>
    <form method="post" action="">
        <div class="field">
            <label for="m">m (număr natural, m &lt; n):</label>
            <input type="number" id="m" name="m" min="1" required value="<?php echo htmlspecialchars($m ?? ''); ?>">
        </div>
        <div class="field">
            <label for="n">n (număr natural, n &gt; m):</label>
            <input type="number" id="n" name="n" min="1" required value="<?php echo htmlspecialchars($n ?? ''); ?>">
        </div>
        <button type="submit">Calculează</button>
    </form>

    <div class="info">
        Se calculează produsul tuturor numerelor naturale mai mici decât <span class="value">n</span>,
        care sunt divizibile cu <span class="value">m</span>.
    </div>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($result !== null): ?>
        <div class="result"><?php echo htmlspecialchars($result); ?></div>
    <?php endif; ?>
</div>
</body>
</html>