// edit.php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la transaction</title>
</head>
<body>

<div class="container">
    <h1>Modifier la transaction</h1>
    
    <!-- Formulaire pour modifier une transaction existante -->
    <form action="/transactions/update?id=<?php echo $transactionId; ?>" method="POST">
        <!-- Ajouter les champs pré-remplis avec les données de la transaction -->
    </form>
</div>

</body>
</html>
