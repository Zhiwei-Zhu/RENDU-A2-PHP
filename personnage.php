<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE
try{
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=php_rendu', "root", "");
} catch (Exception $e){
    echo "erreur de connection à la base de donnée";
}
## ETAPE 1

## RECUPERER TOUT LES PERSONNAGES CONTENU DANS LA TABLE personnages
$show_stat = $pdo->prepare('SELECT * FROM personnages');
$show_stat->execute();
$status = $show_stat->fetchAll(PDO::FETCH_OBJ);
## ETAPE 2

## LES AFFICHERS DANS LE HTML
## AFFICHER SON NOM, SON ATK, SES PV, SES STARS

## ETAPE 3

## DANS CHAQUE PERSONNAGE JE VEUX POUVOIR APPUYER SUR UN BUTTON OU IL EST ECRIT "STARS"

## LORSQUE L'ON APPUIE SUR LE BOUTTON "STARS"

## ON SOUMET UN FORMULAIRE QUI METS A JOURS LE PERSONNAGE CORRESPONDANT (CELUI SUR LEQUEL ON A CLIQUER) EN INCREMENTANT LA COLUMN STARS DU PERSONNAGE DANS LA BASE DE DONNEE

#######################
## ETAPE 4
# AFFICHER LE MSG "PERSONNAGE ($name) A GAGNER UNE ETOILES"

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendu Php</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="nav mb-3">
    <a href="./rendu.php" class="nav-link">Acceuil</a>
    <a href="./personnage.php" class="nav-link">Mes Personnages</a>
    <a href="./combat.php" class="nav-link">Combats</a>
</nav>
<h1>Mes personnages</h1>

    <div class="w-100 mt-5">
        <?php foreach ($status as $key=>$value):?>
        <form method="post">
            <p>Nom: <?php echo $value->name?></p>
            <p>atk: <?php echo $value->atk?></p>
            <p>pv: <?php echo $value->pv?></p>
            <input name="<?php echo $value->id?>" type="submit" class="btn" value="Stars:<?php echo $value->stars?>"><br>

            <?php
                if(!empty($_POST["$value->id"]) ){
                    $star=$value->stars;
                    $name=$value->name;
                    $star++;
                    $add_stars = $pdo->prepare('UPDATE personnages SET stars='.$star.' WHERE name ="'.$name.'"');
                    $add_stars->execute();
                    echo "le personnage ".$name."a gagné une étoile";
                }
            endforeach; ?>
        </form>
    </div>

</body>
</html>
