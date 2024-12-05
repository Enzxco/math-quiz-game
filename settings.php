<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['level'] = $_POST['level'] ?? 1;
    $_SESSION['operator'] = $_POST['operator'] ?? 'add';
    $_SESSION['max_difference'] = $_POST['max_difference'] ?? 3;
    $_SESSION['num_questions'] = $_POST['num_questions'] ?? 10;
    $_SESSION['custom_start'] = $_POST['custom_start'] ?? 1;
    $_SESSION['custom_end'] = $_POST['custom_end'] ?? 10;
    $_SESSION['start'] = $_POST['custom_start'] ?? 1; // Add this line
    $_SESSION['end'] = $_POST['custom_end'] ?? 10; // Add this line
    header('Location: quiz.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Quiz - Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 30px;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 10px;
            display: block;
            text-align: left;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1em;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        input[type="range"] {
            width: 100%;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1.1em;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        form {
            margin: 10px 0;
        }

        .custom-level {
            display: flex;
            justify-content: space-between;
        }

        .custom-level span {
            font-size: 1em;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Math Quiz Settings</h1>
        <form method="POST" action="settings.php">
            <label for="level">Choose Difficulty Level:</label>
            <select name="level" id="level">
                <option value="1" <?= isset($_SESSION['level']) && $_SESSION['level'] == 1 ? 'selected' : '' ?>>Level 1 (1-10)</option>
                <option value="2" <?= isset($_SESSION['level']) && $_SESSION['level'] == 2 ? 'selected' : '' ?>>Level 2 (11-100)</option>
                <option value="custom" <?= isset($_SESSION['level']) && $_SESSION['level'] == 'custom' ? 'selected' : '' ?>>Custom</option>
            </select><br>

            <div id="custom-level-settings" style="display: <?= isset($_SESSION['level']) && $_SESSION['level'] == 'custom' ? 'block' : 'none' ?>;">
                <label for="custom_start">Custom Level Range (Start):</label>
                <input type="number" name="custom_start" id="custom_start" value="<?= isset($_SESSION['custom_start']) ? $_SESSION['custom_start'] : 1 ?>" min="1" oninput="syncCustomRange()"><br>

                <label for="custom_end">Custom Level Range (End):</label>
                <input type="number" name="custom_end" id="custom_end" value="<?= isset($_SESSION['custom_end']) ? $_SESSION['custom_end'] : 10 ?>" min="1" oninput="syncCustomRange()"><br>

                <label for="custom_range">Custom Level Range (Slide):</label>
                <input type="range" name="custom_range" id="custom_range" min="1" max="100" value="<?= isset($_SESSION['custom_end']) ? $_SESSION['custom_end'] : 10 ?>" oninput="syncCustomRange()"><br>
                <div class="custom-level">
                    <span>Start: <span id="start-display">1</span></span>
                    <span>End: <span id="end-display">10</span></span>
                </div>
            </div><br>

            <label for="operator">Choose Operator:</label>
            <select name="operator" id="operator">
                <option value="add" <?= isset($_SESSION['operator']) && $_SESSION['operator'] == 'add' ? 'selected' : '' ?>>Addition</option>
                <option value="subtract" <?= isset($_SESSION['operator']) && $_SESSION['operator'] == 'subtract' ? 'selected' : '' ?>>Subtraction</option>
                <option value="multiply" <?= isset($_SESSION['operator']) && $_SESSION['operator'] == 'multiply' ? 'selected' : '' ?>>Multiplication</option>
                <option value="divide" <?= isset($_SESSION['operator']) && $_SESSION['operator'] == 'divide' ? 'selected' : '' ?>>Division</option>
            </select><br>

            <label for="max_difference">Max Difference from Correct Answer:</label>
            <input type="number" name="max_difference" id="max_difference" value="<?= isset($_SESSION['max_difference']) ? $_SESSION['max_difference'] : 3 ?>"><br>

            <label for="num_questions">Number of Questions:</label>
            <input type="number" name="num_questions" id="num_questions" value="<?= isset($_SESSION['num_questions']) ? $_SESSION['num_questions'] : 10 ?>" min="1"><br>

            <button type="submit">Start Game</button>
        </form>
    </div>

    <script>
        document.getElementById('level').addEventListener('change', function() {
            if (this.value === 'custom') {
                document.getElementById('custom-level-settings').style.display = 'block';
            } else {
                document.getElementById('custom-level-settings').style.display = 'none';
            }
        });

        function syncCustomRange() {
            var start = document.getElementById('custom_start').value;
            var end = document.getElementById('custom_end').value;
            var slider = document.getElementById('custom_range');
            
            if (start != "") {
                slider.value = start;
                document.getElementById('start-display').textContent = start;
            }

            if (end != "") {
                slider.value = end;
                document.getElementById('end-display').textContent = end;
            }
        }
    </script>
</body>
</html>
