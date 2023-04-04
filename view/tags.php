<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
// var_dump($tags);
?>
<h1>Taggar</h1>
<!-- länk till alla frågor som innehåller taggen -->
<?php $id = 0; foreach ($tags as $row) :
    $id++;?>
    <p><a href="<?= url("user/viewTagQuestions/{$row}"); ?>"><?= $row ?></a></p>
<?php endforeach; ?>
