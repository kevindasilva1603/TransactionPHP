<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une nouvelle transaction</title>
    <!-- Inclure ici le CSS de base, si nécessaire -->
</head>
<body>

<div class="container">
    <h1>Créer une nouvelle transaction</h1>
    
    <!-- Le formulaire pour créer une nouvelle transaction -->
    <form action="/transactions/store" method="POST">
        <!-- Champ pour le libellé de la transaction -->
        <div class="form-group">
            <label for="label">Libellé :</label>
            <input type="text" id="label" name="label" required>
        </div>
        
        <!-- Champ pour le montant de la transaction -->
        <div class="form-group">
            <label for="amount">Montant (en centimes) :</label>
            <input type="number" id="amount" name="amount" required>
        </div>
        
        <!-- Bouton pour soumettre le formulaire -->
        <div class="form-group">
            <button type="submit">Enregistrer la transaction</button>
        </div>
    </form>
</div>

</body>
</html>
