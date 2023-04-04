<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
// var_dump($tags);
?>
<h1>Användare</h1>
<!-- länk till alla frågor som innehåller taggen -->
<?php $id = 0; foreach ($users as $row) :
    $id++;?>
    <p><a href="<?= url("user/viewProfile/{$row->acronym}"); ?>"><?= $row->acronym ?></a></p>
<?php endforeach; ?>
