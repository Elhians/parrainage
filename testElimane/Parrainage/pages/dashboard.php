<?php
include '../config.php';
include '../functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user = getUserById($conn, $user_id);

// Recherche du parrain ou du filleul
if ($user['role'] == 'parrain') {
    $stmt = $conn->prepare("SELECT * FROM users WHERE sponsor_id = ?");
    $stmt->bind_param("i", $user_id);
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user['sponsor_id']);
}

$stmt->execute();
$relation = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Bienvenue, <?php echo htmlspecialchars($user['username']); ?></h1>
        <h2>Votre <?php echo $user['role'] == 'parrain' ? 'filleul' : 'parrain'; ?> :</h2>
        <?php if ($relation): ?>
            <img src="<?php echo htmlspecialchars($relation['photo']); ?>" alt="Photo de <?php echo htmlspecialchars($relation['username']); ?>" style="max-width: 150px;"><br>
            <p>Nom: <?php echo htmlspecialchars($relation['username']); ?></p>
            <p>Email: <?php echo htmlspecialchars($relation['email']); ?></p>
            <p>Option: <?php echo htmlspecialchars($relation['user_option']); ?></p>
        <?php else: ?>
            <p>Aucun parrain/filleul trouvé.</p>
        <?php endif; ?>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
