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

## POUVOIR SELECTIONER UN PERSONNE DANS LE PREMIER SELECTEUR
$show_stat = $pdo->prepare('SELECT * FROM personnages WHERE pv>10');
$show_stat->execute();
$status = $show_stat->fetchAll(PDO::FETCH_OBJ);
## ETAPE 2

## POUVOIR SELECTIONER UN PERSONNE DANS LE DEUXIEME SELECTEUR

## ETAPE 3

## LORSQUE LON APPPUIE SUR LE BOUTON FIGHT, RETIRER LES PV DE CHAQUE PERSONNAGE PAR RAPPORT A LATK DU PERSONNAGE QUIL COMBAT

## ETAPE 4

## UNE FOIS LE COMBAT LANCER (QUAND ON APPPUIE SUR LE BTN FIGHT) AFFICHER en dessous du formulaire
# pour le premier perso PERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)
# pour le second persoPERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)

## ETAPE 5

## N'AFFICHER DANS LES SELECTEUR QUE LES PERSONNAGES QUI ONT PLUS DE 10 PV


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
<h1>Combats</h1>
<div class="w-100 mt-5">

    <form action="" method="post">
        <div class="form-group">
            <select name="pers1" id="pers1"><br>
                <?php
                foreach($status as $key => $value):
                    ;?>
                    <option value="<?php echo $value->id?>"><?php echo $value->name?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <select name="pers2" id="pers2"><br>
                <?php
                foreach($status as $key => $value):
                    ;?>
                    <option value="<?php echo $value->id?>"><?php echo $value->name?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn">Fight</button>
    </form>
    <?php
    if (!empty($_POST)) {
        if($_POST["pers1"] != $_POST["pers2"]) {
                $perso2 = $_POST["pers2"];
                $perso1 = $_POST["pers1"];
                $show_stat1 = $pdo->prepare('SELECT * FROM `personnages` WHERE ID IN("' . $perso1 . '","' . $perso2 . '")');
                $show_stat1->execute();
                $status1 = $show_stat1->fetchAll(PDO::FETCH_OBJ);
                if ($perso1 != $perso2) {
                    $atkp1 = $status1[0]->atk;
                    $atkp2 = $status1[1]->atk;
                    $lifep1 = $status1[0]->pv;
                    $lifep2 = $status1[1]->pv;
                    $name1 = $status1[0]->name;
                    $name2 = $status1[1]->name;
                } else {
                    $atkp1 = $status1[0]->atk;
                    $atkp2 = $status1[0]->atk;
                    $lifep1 = $status1[0]->pv;
                    $lifep2 = $status1[0]->pv;
                    $name1 = $status1[0]->name;
                    $name2 = $status1[0]->name;
                }
                echo "le premier personnage " . $name1 . " A PERDU " . $atkp2."<br>";
                echo "le premier personnage " . $name2 . " A PERDU " . $atkp1."<br>";
                $lostpv1=$lifep1-$atkp2;
                $lostpv2=$lifep2-$atkp1;
                $lose_life1 = $pdo->prepare('UPDATE personnages SET pv='.$lostpv1.' WHERE name LIKE "'.$name1.'"');
                $lose_life1->execute();
                $lose_life2 = $pdo->prepare('UPDATE personnages SET pv='.$lostpv2.' WHERE name LIKE "'.$name2.'"');
                $lose_life2->execute();
        }
        else{
            echo  "veuillez rentrerz deux personnages différents";
        }
    }
    ?>
</div>

</body>
</html>
