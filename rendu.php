<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE
$pdo = new PDO('mysql:host=127.0.0.1;dbname=php_rendu', "root", "");


### ETAPE 1

####CREE UNE BASE DE DONNEE AVEC UNE TABLE PERSONNAGE, UNE TABLE TYPE
/*
 * personnages
 * id : primary_key int (11)
 * name : varchar (255)
 * atk : int (11)
 * pv: int (11)
 * type_id : int (11)
 * stars : int (11)
 */
$cp = $pdo->prepare("CREATE TABLE personnages(
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255),
        atk INT(11),
        pv INT(11) DEFAULT 100,
        type_id INT(11) NULL,
        stars INT(11))");
$cp->execute();
/*
 * types
 * id : primary_key int (11)
 * name : varchar (255)
 */
$ct = $pdo->prepare("CREATE TABLE types(
        ID INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100)
)");
$ct->execute();

#######################
## ETAPE 2

#### CREE DEUX LIGNE DANS LA TABLE types
# une ligne avec comme name = feu
# une ligne avec comme name = eau
$add_type=$pdo->prepare('INSERT INTO types(name)VALUE("Feu"),("Eau")'
);
$add_type->execute();
#######################
## ETAPE 3

# AFFICHER DANS LE SELECTEUR (<select name="" id="">) tout les types qui sont disponible (cad tout les type contenu dans la table types)
$show_types = $pdo->prepare('SELECT * FROM types');
$show_types->execute();
$types = $show_types->fetchAll(PDO::FETCH_OBJ);

#######################
## ETAPE 4

# ENREGISTRER EN BASE DE DONNEE LE PERSONNAGE, AVEC LE BON TYPE ASSOCIER

#######################
## ETAPE 5
# AFFICHER LE MSG "PERSONNAGE ($name) CREER"

#######################
## ETAPE 6

# ENREGISTRER 5 / 6 PERSONNAGE DIFFERENT

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
<h1>Acceuil</h1>
<div class="w-100 mt-5">
    <form action="" method="POST" class="form-group">
        <div class="form-group col-md-4">
            <label for="name">Nom du personnage</label>
            <input name="name" type="text" class="form-control" placeholder="Nom">
        </div>
        <div class="form-group col-md-4">
            <label for="atk">Attaque du personnage</label>
            <input name="atk" type="text" class="form-control" placeholder="Atk">
        </div>
        <div class="form-group col-md-4">
            <label for="pv">Pv du personnage</label>
            <input name="pv" type="text" class="form-control" placeholder="Pv">
        </div>
        <div class="form-group col-md-4">
            <label for="type">Type</label>
            <select name="type" id="type"><br>
                <option value="" selected disabled>Choisissez un type</option >
                <?php
                foreach($types as $key => $value):
                    ;?>
                    <option value="<?php echo $value->id?>"><?php echo $value->names?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-primary">Enregistrer</button>
    </form>

</div>

</body>
</html>
<?php
if (!empty($_POST)){
    $name = $_POST["name"];
    $atk = $_POST["atk"];
    $pv = $_POST["pv"];
    $type = $_POST["type"];
    $add_form = $pdo->prepare('INSERT INTO personnages (name,atk,pv,type_id) VALUES ("'.$name.'",'.$atk.','.$pv.','.$type.')');
    $add_form->execute();

    echo "le personnage " . $_POST["name"] . " a été créé";
}?>