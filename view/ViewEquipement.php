<?php
?>

<!DOCTYPE html>
<html>

<?php

include "./template/header.php";

?>

<main style="display: flex;gap: 20px;margin: 20px auto">
    <a href="<?php echo "/admin/" . $this->getParameterValue("maison_id") ?>" style="border: 1px solid black; border-radius: 5px;padding: 10px;font-weight: bold"><- Retour</a>
            <form action="<?php echo "/admin/" . $this->getParameterValue("maison_id") . "/equipement" ?>" method="post" style="width:500px;padding: 10px;border: 1px solid black; border-radius: 5px">
                <?php foreach ($this->equipementList as $equipement) : ?>
                    <input type="checkbox" id="<?php echo $equipement["id"] ?>" name="<?php echo $equipement["id"] ?>" <?php if ($this->EquipementExists($equipement["id"])) echo "checked"; ?>/>
                    <label for="<?php echo $equipement["id"] ?>"><?php echo $equipement["nom"] ?></label>
                    <br>
                <?php endforeach; ?>
                <input type="submit" value="Sauvegarder">
            </form>
</main>

<?php

include "./template/footer.php";

?>

</html>