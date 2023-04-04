<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Ändra</h1>
<br>
<?php if ($table == "Deleted") : ?>
    <?= $table ?>
<?php elseif ($table == "Question") : ?>
<form method="post">
    <textarea class="info-text" name="info" rows="4"><?= $post[0]->question ?></textarea>
    <input type="text" class="tags-text" name="tags" value ="<?= $post[0]->tags ?>">
    <br><br><input type="submit" name="submit" value="Ändra">
    <input type="submit" name="delete" value="Ta bort">
</form>
<?php else : ?>
    <form method="post">
        <textarea class="info-text" name="info" rows="4"><?= $post[0]->$rows ?></textarea>
        <br><br><input type="submit" name="submit" value="Ändra">
        <input type="submit" name="delete" value="Ta bort">
    </form>
<?php endif ?>
