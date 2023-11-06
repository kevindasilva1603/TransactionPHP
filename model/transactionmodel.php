<?php
// TransactionModel.php

// Ici, vous allez connecter votre script PHP à une base de données, par exemple, MySQL.

// Supposons que vous avez une fonction de connexion à la base de données
function connectDB() {
    // Remplacer par les détails de votre base de données
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "myDatabase";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function getAllTransactionsByUserId($userId) {
    $conn = connectDB();

    $sql = "SELECT * FROM transactions WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $transactions = [];
    while($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $transactions;
}

function createTransaction($userId, $label, $amount) {
    $conn = connectDB();

    $sql = "INSERT INTO transactions (user_id, label, amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $userId, $label, $amount);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

function getTransactionById($transactionId) {
    $conn = connectDB();

    $sql = "SELECT * FROM transactions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    $stmt->execute();
    $result = $stmt->get_result();

    $transaction = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $transaction;
}

function updateTransaction($transactionId, $label, $amount) {
    $conn = connectDB();

    $sql = "UPDATE transactions SET label = ?, amount = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $label, $amount, $transactionId);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

function deleteTransaction($transactionId) {
    $conn = connectDB();

    $sql = "DELETE FROM transactions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}
