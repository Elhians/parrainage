<?php
include '../config.php';
include '../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_option = $_POST['user_option'];
    $role = $_POST['role'];
    $photo = uploadPhoto($_FILES['photo']);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_option, role, photo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $email, $password, $user_option, $role, $photo);

    if ($stmt->execute()) {
        if ($role == 'filleul') {
            // Trouver un parrain sans filleul et de la même option
            $stmt = $conn->prepare("SELECT * FROM users WHERE role = 'parrain' AND user_option = ? AND id NOT IN (SELECT parrain_id FROM parrainages) LIMIT 1");
            $stmt->bind_param("s", $user_option);
            $stmt->execute();
            $parrain = $stmt->get_result()->fetch_assoc();

            if ($parrain) {
                // Associer le filleul au parrain
                $filleul_id = $conn->insert_id;
                $stmt = $conn->prepare("INSERT INTO parrainages (parrain_id, filleul_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $parrain['id'], $filleul_id);
                $stmt->execute();

                // Mettre à jour l'utilisateur filleul avec l'id du parrain
                $stmt = $conn->prepare("UPDATE users SET sponsor_id = ? WHERE id = ?");
                $stmt->bind_param("ii", $parrain['id'], $filleul_id);
                $stmt->execute();
            }
        }
        header('Location: login.php');
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Inscription</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br>
            <select name="user_option" required>
                <option value="INF">Informatique</option>
                <option value="TR">Télécommunication et Réseau</option>
            </select><br>
            <select name="role" required>
                <option value="parrain">Parrain</option>
                <option value="filleul">Filleul</option>
            </select><br>
            <input type="file" name="photo" accept="image/*" required><br>
            <button type="submit">S'inscrire</button>
        </form>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
