<?php
include_once "./controller/imageBox.php";
// Main
$imageBox = new imageBox("GET", $_SERVER["REQUEST_URI"], $this->parameter);
$imageBox->isApi = false;
$imageBox->execute();
?>

<!DOCTYPE html>
<html>

<?php

include "./template/header.php";

?>

<main style="display: flex;gap: 20px;margin: 20px auto">
    <a href="<?php echo "/admin/" . $imageBox->maison->id . "/image"?>" style="border: 1px solid black; border-radius: 5px;padding: 10px;font-weight: bold"><- Retour</a>

            <form action="<?php echo "/admin/" . $imageBox->maison->id . "/image/" . $imageBox->image->id; ?>" method="post" style="width:500px;display:flex;flex-direction:column;padding: 10px;border: 1px solid black; border-radius: 5px">

                <input type="hidden" name="id" value="<?php echo $imageBox->image->id; ?>" readonly>
                <input type="hidden" name="maison_id" value="<?php echo $imageBox->image->maison_id; ?>">
                <div>
                    <input id="inp" type="file">
                    <br>
                    <input name="data_image" type="text" id="b64" style="display: none;" value="<?php echo $imageBox->image->data_image; ?>">
                    <br>
                    <img id="img" width="300px" src="<?php echo $imageBox->image->data_image; ?>">
                </div>
                <br>
                <input type="submit" value="Sauvegarder">
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