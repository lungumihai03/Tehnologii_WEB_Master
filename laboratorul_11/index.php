<?php
// daca s-a trimis formularul, citim matricea din input
$A = [];
$m = 0;
$n = 0;
$diagonala = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = isset($_POST['matrix']) ? trim($_POST['matrix']) : '';

    if ($raw !== '') {
        $rows = preg_split('/\r\n|\r|\n/', $raw);

        foreach ($rows as $row) {
            if (trim($row) === '') continue;
            // separare prin spatiu
            $cols = preg_split('/\s+/', trim($row));
            $A[] = array_map('floatval', $cols);
        }

        // determinam dimensiunile
        $m = count($A);
        $n = $m > 0 ? count($A[0]) : 0;

        // optional: normalizam numarul de coloane (taiem sau completam)
        foreach ($A as &$row) {
            if (count($row) > $n) {
                $row = array_slice($row, 0, $n);
            } elseif (count($row) < $n) {
                $row = array_pad($row, $n, 0);
            }
        }
        unset($row);

        // diagonala
        $dim = min($m, $n);
        for ($i = 0; $i < $dim; $i++) {
            $diagonala[] = $A[$i][$i];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Diagonala principală a matricei</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 { text-align: center; }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        table {
            border-collapse: collapse;
            margin: 20px auto;
        }
        td, th {
            border: 1px solid #999;
            padding: 8px 12px;
            text-align: center;
        }
        .diag {
            color: #fff;
            background: #007acc;
            font-weight: bold;
        }
        .result {
            text-align: center;
            margin-top: 20px;
        }
        .chip {
            display: inline-block;
            margin: 3px;
            padding: 6px 10px;
            border-radius: 12px;
            background: #007acc;
            color: #fff;
            font-weight: bold;
            min-width: 24px;
        }
        textarea {
            width: 100%;
            height: 120px;
            font-family: monospace;
        }
        .note {
            font-size: 0.9em;
            color: #555;
        }
        .btn {
            margin-top: 10px;
            padding: 6px 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Elementele diagonalei principale</h1>

    <form method="post">
        <label for="matrix">Introduceți matricea (fiecare linie pe un rând, elementele separate prin spațiu):</label><br>
        <textarea id="matrix" name="matrix"><?php
            // afisam ce a introdus utilizatorul la POST
            if (isset($_POST['matrix'])) {
                echo htmlspecialchars($_POST['matrix']);
            } else {
                // exemplu initial
                echo "1 2 3 4\n5 6 7 8\n9 10 11 12\n13 14 15 16";
            }
        ?></textarea>
        <div class="note">
            Exemplu:<br>
            1 2 3 4<br>
            5 6 7 8<br>
            9 10 11 12<br>
            13 14 15 16
        </div>
        <button type="submit" class="btn">Calculează diagonala</button>
    </form>

    <?php if ($m > 0 && $n > 0): ?>
        <h3>Matricea A (<?php echo $m . " × " . $n; ?>)</h3>
        <table>
            <tbody>
            <?php for ($i = 0; $i < $m; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < $n; $j++): ?>
                        <td class="<?php echo ($i === $j) ? 'diag' : ''; ?>">
                            <?php echo htmlspecialchars($A[$i][$j]); ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>

        <div class="result">
            <h3>Diagonala principală:</h3>
            <?php if (count($diagonala) === 0): ?>
                <p>Matricea este goală.</p>
            <?php else: ?>
                <?php foreach ($diagonala as $elem): ?>
                    <span class="chip"><?php echo htmlspecialchars($elem); ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>