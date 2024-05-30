<?php
include '../config.php';
include '../functions.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$parrains = getUsersByRole($conn, 'parrain');
$filleuls = getUsersByRole($conn, 'filleul');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $parrain_id = $_POST['parrain_id'];
    $filleul_id = $_POST['filleul_id'];
    
    // Associer le filleul au parrain
    $stmt = $conn->prepare("INSERT INTO parrainages (parrain_id, filleul_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $parrain_id, $filleul_id);
    $stmt->execute();
    
    // Mettre à jour l'utilisateur filleul avec l'id du parrain
    $stmt = $conn->prepare("UPDATE users SET sponsor_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $parrain_id, $filleul_id);
    $stmt->execute();
}

function getUsersByRole($conn, $role) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE role = ?");
    $stmt->bind_param("s", $role);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Parrainage</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Administration - Parrainage</h1>
        <div class="parrainage-container">
            <form method="POST">
                <label for="parrain_id">Parrain:</label>
                <select name="parrain_id" id="parrain_id" required>
                    <?php foreach ($parrains as $parrain): ?>
                        <option value="<?php echo $parrain['id']; ?>"><?php echo htmlspecialchars($parrain['username']); ?> - <?php echo htmlspecialchars($parrain['user_option']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="filleul_id">Filleul:</label>
                <select name="filleul_id" id="filleul_id" required>
                    <?php foreach ($filleuls as $filleul): ?>
                        <option value="<?php echo $filleul['id']; ?>"><?php echo htmlspecialchars($filleul['username']); ?> - <?php echo htmlspecialchars($filleul['user_option']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Assigner</button>
            </form>
            <div class="parrainage-list">
                <?php
                $stmt = $conn->prepare("SELECT p.username AS parrain_name, f.username AS filleul_name FROM parrainages pr
                                        JOIN users p ON pr.parrain_id = p.id
                                        JOIN users f ON pr.filleul_id = f.id");
                $stmt->execute();
                $parrainages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                ?>
                <h2>Liste des parrainages</h2>
                <ul>
                    <?php foreach ($parrainages as $parrainage): ?>
                        <li><?php echo htmlspecialchars($parrainage['parrain_name']); ?> est le parrain de <?php echo htmlspecialchars($parrainage['filleul_name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
