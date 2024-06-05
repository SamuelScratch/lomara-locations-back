<?php
global $imageBox;
?>

<!DOCTYPE html>
<html>

<?php

include "./template/header.php";

?>
<h2 style="text-align: center;font-size: 24px;font-weight: bold; margin:10px"><?php echo $imageBox->maison->nom; ?></h2>

<main style="display: flex;gap: 20px;margin: 20px auto;width: 1000px;" id="liste-images">
    <a href="<?php echo "/admin/" . $imageBox->getParameterValue("maison_id"); ?>" style="padding: 10px;border: 1px solid black; border-radius: 5px;font-weight: bold;text-align: center">
        <- Retour </a>
            <a href="<?php echo "/admin/" . $this->getParameterValue("maison_id") . "/image/-1"; ?>" style="padding: 10px;border: 1px solid black; border-radius: 5px;font-weight: bold;text-align: center">
                +
            </a>
            <div style="display: flex;flex-wrap: wrap;gap: 20px;margin:auto 20px">
                <?php foreach ($imageBox->imageList as $image) : ?>
                    <div style="padding: 10px;border: 1px solid black; border-radius: 5px;display: flex;flex-direction: column;gap: 10px;justify-content: space-between">
                        <img id="img" width="200px" src="<?php echo $image->data_image; ?>">
                        <div style="display: flex;flex-direction: column">
                            <a href="<?php echo "/admin/" . $image->maison_id . "/image/" . $image->id; ?>" style="border: 1px solid grey; border-radius: 3px;padding: 2px;text-align: center;background-color: whitesmoke" class="material-icons">edit</a>
                            <button onclick="deleteSomething(<?php echo $image->id; ?>)" class="material-icons">delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

</main>

<script>
    function deleteSomething(id) {
        fetch("<?php echo "/admin/" . $image->maison_id . "/image/" ?>" + id, {
            method: 'DELETE'
        }).finally(() => window.location.reload())
    }
</script>

</html>