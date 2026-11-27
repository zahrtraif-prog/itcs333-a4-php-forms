<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

$name = '';
$email = '';
$message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!validate_required($name)) {
        $errors['name'] = 'Name is required.';
    } elseif (!validate_length($name, 2, 60)) {
        $errors['name'] = 'Name must be between 2 and 60 characters.';
    }

    if (!validate_required($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!validate_email($email)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (!validate_required($message)) {
        $errors['message'] = 'Message is required.';
    } elseif (!validate_length($message, 10, 1000)) {
        $errors['message'] = 'Message must be between 10 and 1000 characters.';
    }

    if (empty($errors)) {
        header('Location: success.php', true, 303);
        exit;
    }
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us</title>
  <style>
    .error { color: red; font-size: 0.9em; }
  </style>
</head>
<body>
  <h1>Contact Us</h1>

  <form method="post" action="index.php">
    <label>Name 
      <input type="text" name="name" value="<?= e($name) ?>">
    </label>
    <?php if (isset($errors['name'])): ?>
      <span class="error"><?= e($errors['name']) ?></span>
    <?php endif; ?>
    <br>

    <label>Email 
      <input type="email" name="email" value="<?= e($email) ?>">
    </label>
    <?php if (isset($errors['email'])): ?>
      <span class="error"><?= e($errors['email']) ?></span>
    <?php endif; ?>
    <br>

    <label>Message 
      <textarea name="message"><?= e($message) ?></textarea>
    </label>
    <?php if (isset($errors['message'])): ?>
      <span class="error"><?= e($errors['message']) ?></span>
    <?php endif; ?>
    <br>

    <button type="submit">Send</button>
  </form>
</body>
</html>