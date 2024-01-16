<?php
//TODO #1: Modifica la cadena de connexió amb les teves dades d'accés
function getConnection()
{
    $connString = 'mysql:host=localhost;port=3306;dbname=lovingcats;charset=utf8';
    $user = 'root';
    $pass = '';
    $db = null;
    try {
        $db = new PDO($connString, $user, $pass, [PDO::ATTR_PERSISTENT => True]);
    } catch (PDOException $e) {
        echo "<p style=\"color:red;\">Error " . $e->getMessage() . "</p>";
    } finally {
        return $db;
    }
}

// TODO #2: Implementa la funció insertCats($cats) que reb un array de gats i els inserta a la base de dades
// TODO   : Si un gat ja existeix a la base de dades no s'ha de tornar a inserir (cal comprovar-ho abans d'inserir)
function insertCats($cats)
{
    $inserit = false;
    $conn = getConnection();
    $sql = "INSERT INTO cat (idCat, tags) VALUES (:id, :tags)";
    try {
        foreach ($cats as $cat) {
            $id = $cat["_id"];
            $tagsArray = $cat['tags'];
            $tags = '';
            for ($i = 0; $i < count($tagsArray); $i++) {
                if ($i < count($tagsArray) - 1) {
                    $tags .= $tagsArray[$i] . ',';
                } else {
                    $tags .= $tagsArray[$i];
                }
            }
            $resultat = $conn->prepare($sql);
            $resultat->execute([':id' => $id, ':tags' => $tags]);
        }
        if ($resultat) {
            $inserit = true;
        }
    } catch (PDOException $e) {
        echo "<p style=\"color:red;\">Error " . $e->getMessage() . "</p>";
    } finally {
        return $inserit;
    }
}
