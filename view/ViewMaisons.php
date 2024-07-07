<?php
include_once "./controller/MaisonBox.php";
// Main
$maisonBox = new MaisonBox("GET", null, null);
$maisonBox->isApi = false;
$maisonBox->execute();
?>

<!DOCTYPE html>
<html>

<?php

include "./template/header.php";

?>

<main style="display: flex;gap: 20px;margin: 20px auto">
    <?php foreach ($maisonBox->maisonList as $maison) : ?>
        <a href="<?php echo "/admin/" . $maison->id; ?>" style="padding: 10px;border: 1px solid black; border-radius: 5px">
            <?php echo $maison->nom; ?>
        </a>
    <?php endforeach; ?>
        <a href="/admin/-1" style="padding: 10px;border: 1px solid black; border-radius: 5px;font-weight: bold;text-align: center">
            +
        </a>
</main>

<?php

include "./template/footer.php";

?>

</html>