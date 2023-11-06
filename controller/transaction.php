<?php
// TransactionController.php

namespace App\Controllers;

// Ici, nous avons notre TransactionController qui contient des méthodes pour gérer les transactions.
class TransactionController {
    // Cette méthode montre toutes les transactions d'un utilisateur.
    public function index() {
        session_start(); // On commence une session.
        if (!isset($_SESSION['user_id'])) { // Si l'utilisateur n'est pas connecté,
            header('Location: /login'); // On le redirige vers la page de connexion.
            exit(); // On arrête l'exécution du script.
        }
        
        // On récupère toutes les transactions de l'utilisateur.
        $transactions = TransactionModel::getAllByUserId($_SESSION['user_id']);
        
        // On inclut la vue qui va afficher les transactions.
        require __DIR__ . '/../views/transactions/index.php';
    }

    // Cette méthode affiche le formulaire pour créer une nouvelle transaction.
    public function create() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        // On inclut la vue avec le formulaire de création de transaction.
        require __DIR__ . '/../views/transactions/create.php';
    }

    // Cette méthode traite les données envoyées par le formulaire de création.
    public function store() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        // On vérifie que la méthode utilisée pour accéder à la page est POST.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On récupère les données envoyées par l'utilisateur.
            $label = $_POST['label'];
            $amount = $_POST['amount'];
            
            // Ici, vous feriez normalement de la validation...
            
            // On enregistre la nouvelle transaction.
            TransactionModel::create($_SESSION['user_id'], $label, $amount);
            
            // On redirige l'utilisateur vers la liste des transactions.
            header('Location: /transactions');
            exit();
        } else {
            header('Location: /transactions/create');
            exit();
        }
    }

    // Cette méthode affiche le formulaire de modification d'une transaction.
    public function edit() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        // On récupère l'ID de la transaction à modifier.
        $transactionId = $_GET['id'];
        $transaction = TransactionModel::getById($transactionId);
        
        // On vérifie que la transaction appartient à l'utilisateur.
        if (!$transaction || $transaction['user_id'] != $_SESSION['user_id']) {
            header('HTTP/1.0 403 Forbidden');
            echo "Vous n'avez pas le droit de modifier cette transaction.";
            exit();
        }
        
        // On inclut la vue de modification.
        require __DIR__ . '/../views/transactions/edit.php';
    }

    // Cette méthode traite les données du formulaire de modification.
    public function update() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On récupère et on valide les données envoyées.
            $transactionId = $_GET['id'];
            $label = $_POST['label'];
            $amount = $_POST['amount'];
            
            // Encore une fois, vérification de la propriété de la transaction...
            $transaction = TransactionModel::getById($transactionId);
            if (!$transaction || $transaction['user_id'] != $_SESSION['user_id']) {
                header('HTTP/1.0 403 Forbidden');
                echo "Vous n'avez pas le droit de modifier cette transaction.";
                exit();
            }
            
            // On met à jour la transaction.
            TransactionModel::update($transactionId, $label, $amount);
            
            // Redirection vers la liste des transactions.
            header('Location: /transactions');
            exit();
        } else {
            header('Location: /transactions/edit?id=' . $_GET['id']);
            exit();
        }
    }

    // Cette méthode gère la suppression d'une transaction.
    public function destroy() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On traite la demande de suppression.
            $transactionId = $_POST['id'];
            
            // Vérification de la propriété de la transaction...
            $transaction = TransactionModel::getById($transactionId);
            if (!$transaction || $transaction['user_id'] != $_SESSION['user_id']) {
                header('HTTP/1.0 403 Forbidden');
                echo "Vous n'avez pas le droit de supprimer cette transaction.";
                exit();
            }
            
            // Suppression de la transaction.
            TransactionModel::destroy($transactionId);
            
            // Redirection vers la liste des transactions.
            header('Location: /transactions');
            exit();
        } else {
            header('HTTP/1.0 405 Method Not Allowed');
            echo "Méthode non autorisée";
            exit();
        }
    }
}
?>
