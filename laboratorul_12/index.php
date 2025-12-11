<?php

$result = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = isset($_POST['text']) ? $_POST['text'] : "";
    if ($text !== "") {
        $len = mb_strlen($text, 'UTF-8');
        if ($len > 1) {
            $lastChar  = mb_substr($text, $len - 1, 1, 'UTF-8');
            $rest      = mb_substr($text, 0, $len - 1, 'UTF-8');
            $result    = $lastChar . $rest;
        } else {
            $result = $text;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Deplasare litere la dreapta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            margin-top: 0;
            font-size: 22px;
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .result {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
            background: #eef5ff;
            border: 1px solid #c9ddff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Deplasare text la dreapta cu o poziție</h1>

    <form method="post">
        <label for="text">Introduceți textul:</label>
        <input type="text" id="text" name="text"
               value="<?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <input type="submit" value="Procesează">
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="result">
            <strong>Text inițial:</strong>
            <?php echo htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8'); ?><br>
            <strong>Text deplasat:</strong>
            <?php echo htmlspecialchars($result, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>