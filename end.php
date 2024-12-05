<?php
session_start();
$final_score = $_SESSION['score'] ?? ['correct' => 0, 'wrong' => 0];
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Quiz - Final Score</title>
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
            max-width: 450px;
        }

        .score {
            font-size: 1.5em;
            margin-top: 20px;
            color: #333;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Game Over</h1>
        <p>Your Final Score:</p>
        <p class="score">
            Correct: <?php echo $final_score['correct']; ?><br>
            Wrong: <?php echo $final_score['wrong']; ?>
        </p>

        <form action="quiz.php" method="POST" style="display: inline;">
            <button type="submit">Play Again</button>
        </form>

        <form action="main.php" method="GET" style="display: inline;">
            <button type="submit">Back to Menu</button>
        </form>
    </div>
</body>
</html>
