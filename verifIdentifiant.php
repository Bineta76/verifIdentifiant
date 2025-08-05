<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "labo"); // Modifie les infos si besoin

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erreur de connexion à la BDD."]);
    exit();
}

// Lire les données JSON reçues
$data = json_decode(file_get_contents("php://input"), true);

$nom = isset($data['nom']) ? $conn->real_escape_string($data['nom']) : '';
$prenom = isset($data['prenom']) ? $conn->real_escape_string($data['prenom']) : '';

// Vérification dans la base de données
$sql = "SELECT * FROM users WHERE nom='$nom' AND prenom='$prenom'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}

$conn->close();
?>
