<?php
include_once "./controller/MaisonBox.php";
// Main
$maisonBox = new MaisonBox("GET", $_SERVER["REQUEST_URI"], $this->parameter);
$maisonBox->isApi = false;
$maisonBox->execute();
?>

<!DOCTYPE html>
<html>

<?php

include "./template/header.php";

?>

<main style="display: flex;gap: 20px;margin: 20px auto">
    <a href="/admin" style="border: 1px solid black; border-radius: 5px;padding: 10px;font-weight: bold"><- Retour</a>
    <a href="<?php echo "/admin/" . $maisonBox->maison->id . "/image"; ?>" style="border: 1px solid black; border-radius: 5px;padding: 10px;font-weight: bold">Gérer les images -></a>
    <a href="<?php echo "/admin/" . $maisonBox->maison->id . "/equipement"; ?>" style="border: 1px solid black; border-radius: 5px;padding: 10px;font-weight: bold">Gérer les équipements -></a>

            <form action="<?php echo "/admin/" . $maisonBox->maison->id; ?>" method="post" style="width:500px;display:flex;flex-direction:column;padding: 10px;border: 1px solid black; border-radius: 5px">
                <label for="id">Id :</label>
                <input type="text" name="id" value="<?php echo $maisonBox->maison->id; ?>" readonly>
                <br>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" value="<?php echo $maisonBox->maison->nom; ?>">
                <br>
                <label for="adresse">Adresse :</label>
                <input type="text" name="adresse" value="<?php echo $maisonBox->maison->adresse; ?>">
                <br>
                <label for="code_postal">Code postal :</label>
                <input type="text" name="code_postal" value="<?php echo $maisonBox->maison->code_postal; ?>">
                <br>
                <label for="ville">Ville :</label>
                <input type="text" name="ville" value="<?php echo $maisonBox->maison->ville; ?>">
                <br>
                <label for="nb_personne">Nombre de personne :</label>
                <input type="text" name="nb_personne" value="<?php echo $maisonBox->maison->nb_personne; ?>">
                <br>
                <label for="description">Description :</label>
                <textarea name="description" style="height: 150px;resize:vertical"><?php echo $maisonBox->maison->description; ?></textarea>
                <br>
                <label for="texte_tarif">Texte Tarif :</label>
                <textarea name="texte_tarif" style="height: 150px;resize:vertical"><?php echo $maisonBox->maison->texte_tarif; ?></textarea>
                <br>
                <label>Vignette :</label>
                <br>
                <div>
                    <input id="inp" type="file">
                    <br>
                    <input name="vignette" type="text" id="b64" style="display: none;" value="<?php echo $maisonBox->maison->vignette; ?>">
                    <img id="img" width="300px" src="<?php echo $maisonBox->maison->vignette; ?>">
                </div>
                <br>
                <input type="submit" value="Enregistrer">
            </form>
</main>

<script>
    function readFile() {

        if (!this.files || !this.files[0]) return;

        const FR = new FileReader();

        FR.addEventListener("load", function(evt) {
            document.querySelector("#img").src = evt.target.result;
            document.querySelector("#b64").value = evt.target.result;
        });

        FR.readAsDataURL(this.files[0]);

    }

    document.querySelector("#inp").addEventListener("change", readFile);
</script>

<?php

include "./template/footer.php";

?>

</html>