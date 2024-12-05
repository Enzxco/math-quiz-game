<?php
session_start();

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = ['correct' => 0, 'wrong' => 0];
}
if (!isset($_SESSION['question_number'])) {
    $_SESSION['question_number'] = 1;
}
if (!isset($_SESSION['num_questions'])) {
    $_SESSION['num_questions'] = 10;
}

$remark = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer']) && isset($_POST['correct_answer'])) {
    $user_answer = $_POST['answer'];
    $correct_answer = $_POST['correct_answer'];

    if ((float)$user_answer === (float)$correct_answer) {
        $_SESSION['score']['correct']++;
        $remark = "Correct!";
    } else {
        $_SESSION['score']['wrong']++;
        $remark = "Wrong! The correct answer was $correct_answer.";
    }

    $_SESSION['question_number']++;

    if ($_SESSION['question_number'] > $_SESSION['num_questions']) {
        header('Location: end.php');
        exit();
    }
}

$level = $_SESSION['level'] ?? 1;
$operator = $_SESSION['operator'] ?? 'add';
$max_difference = $_SESSION['max_difference'] ?? 3;

if ($level == 'custom' && isset($_SESSION['start']) && isset($_SESSION['end'])) {
    $range = [$_SESSION['start'], $_SESSION['end']];
} else {
    switch ($level) {
        case '1': $range = [1, 10]; break;
        case '2': $range = [11, 100]; break;
        default: $range = [1, 10]; break;
    }
}

$num1 = rand($range[0], $range[1]);
$num2 = rand($range[0], $range[1]);

switch ($operator) {
    case 'add':
        $question = "$num1 + $num2";
        $correct_answer = $num1 + $num2;
        break;
    case 'subtract':
        $question = "$num1 - $num2";
        $correct_answer = $num1 - $num2;
        break;
    case 'multiply':
        $question = "$num1 × $num2";
        $correct_answer = $num1 * $num2;
        break;
    case 'divide':
        while ($num2 === 0) $num2 = rand($range[0], $range[1]);
        $question = "$num1 ÷ $num2";
        $correct_answer = $num1 / $num2;
        $correct_answer = round($correct_answer, 2);
        break;
    default:
        die("Invalid operator selected!");
}

$choices = [$correct_answer];
while (count($choices) < 4) {
    $random_choice = $correct_answer + rand(-$max_difference, $max_difference);
    if (!in_array($random_choice, $choices)) {
        $choices[] = $random_choice;
    }
}
shuffle($choices);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        h2 {
            color: #4CAF50;
        }
        .question {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .choices input {
            margin: 10px;
            cursor: pointer;
        }
        .choices label {
            font-size: 18px;
            margin-left: 10px;
            cursor: pointer;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .score {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
        .remark {
            margin-top: 15px;
            font-size: 18px;
            color: green;
        }
        .end-quiz {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Math Quiz</h1>
        <p>Question <?php echo $_SESSION['question_number']; ?> of <?php echo $_SESSION['num_questions']; ?>:</p>
        <h2 class="question"><?php echo $question; ?></h2>
        <form action="quiz.php" method="POST">
            <div class="choices">
                <?php foreach ($choices as $choice): ?>
                    <input type="radio" name="answer" value="<?php echo $choice; ?>" required>
                    <label><?php echo $choice; ?></label><br>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="correct_answer" value="<?php echo $correct_answer; ?>">
            <button type="submit" class="button">Submit Answer</button>
        </form>

        <?php if (!empty($remark)): ?>
            <p class="remark"><strong><?php echo $remark; ?></strong></p>
        <?php endif; ?>

        <p class="score">Score: <?php echo $_SESSION['score']['correct']; ?> Correct, <?php echo $_SESSION['score']['wrong']; ?> Wrong</p>

        <form action="end.php" method="POST" class="end-quiz">
            <button type="submit" class="button">End Quiz</button>
        </form>
    </div>
</body>
</html>
