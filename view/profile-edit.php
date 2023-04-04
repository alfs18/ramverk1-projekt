<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$imageSize = "?width=80&height=80&crop-to-fit&area=0,0,0,0";
$imageSize2 = "?width=100&height=100&crop-to-fit&area=0,0,0,0";
?>
<h1>Profil (<?= $acronym ?>)
<img src="<?= $baseURL ?>/image/profile/<?= $user[0]->picture ?><?= $imageSize ?>"></img>
</h1>

<!-- om baseURL-en innehåller picture, visa detta -->
<?php if ($toUpdate == "picture") : ?>
<h4>Redigera profilbild</h4>
<!-- markera nuvarande profilbild -->
<div class="pictures">
    <form method="post">
        <?php foreach ($pictures as $row) : ?>
            <!-- om $user[0]->picture == $row->name, ge den en viss style -->
            <!-- <a href=""><img src="<?= $baseURL ?>/image/profile/<?= $row->name ?>" height="80px"></img></a> -->
            <input type="radio" id="<?= $row->name ?>" name="picture" class="picture-radio" value="<?= $row->name ?>">
            <label for="<?= $row->name ?>">
                <img class="radio-img" src="<?= $baseURL ?>/image/profile/<?= $row->name ?><?= $imageSize2 ?>"></img>
            </label>
        <?php endforeach ?>
        <input type="submit" name="submit" value="Välj">
    </form>
</div>

<h4>Ladda upp egen bild</h4>
<form action="upload" method="post" enctype="multipart/form-data">
<input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
<input type="submit" name="submit" value="Ladda upp">
</form>
<br>

<?php else : ?>
<h3>Presentation</h3>
<form method="post">
    <textarea class="info-text" name="info" rows="4"><?= $user[0]->info ?></textarea>
    <input type="submit" name="submit" value="Ändra">
</form>
<?php endif ?>
