<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
// var_dump($res);
?>
<h1>Frågor</h1>

            <!-- Sökruta -->
<!-- <?php print_r($content) ?> -->

<table class="all-questions-table">
    <tr class="first">
        <th>Rad</th>
        <th>Fråga</th>
        <th>Poäng</th>
        <th>Användare</th>
        <th>Antal svar</th>
    </tr>
<?php $id = 0; foreach ($res as $row) :
    $id++;?>
    <tr>
        <td><?= $id ?></td>
        <!-- länk till frågan -->
        <td class="question-row">
            <a href="<?= url("user/viewQuestion/{$row->id}"); ?>">
                <?= $row->question ?>
            </a>
        </td>
        <td><?= $row->points ?? 0 ?></td>
        <!-- länk till profilen som skrivit inlägget -->
        <td class="img-row">
            <a href="<?= url("user/viewProfile/{$row->acronym}"); ?>">
                <?= $row->acronym ?><br><?= $row->picture ?>
            </a>
        </td>
        <td><?= count($row->answers) ?></td>
    </tr>
<?php endforeach; ?>
</table>
