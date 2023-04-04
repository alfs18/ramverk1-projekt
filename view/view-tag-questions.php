<?php

namespace Anax\View;

use Alfs18\User\HTMLForm\CreateAnswerCommentsForm;
/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Frågor med taggen <?= $tag ?></h1>
<!-- Show the question -->
<!-- <div class="questions">
    <?php foreach ($questions as $row) : ?>
        <a href="<?= url("user/viewQuestion/{$row->id}"); ?>"><?= $row->question ?></a>
        - <a href="<?= url("user/viewProfile/{$row->acronym}"); ?>"><?= $row->acronym ?></a>
        <br>
        <?= $row->created ?><br>
        Poäng: <?= $row->points ?><br><br>
    <?php endforeach ?>
</div> -->

<table class="all-questions-table">
    <tr class="first">
        <th>Rad</th>
        <!-- <th>Id</th> -->
        <th>Fråga</th>
        <th>Poäng</th>
        <th>Användare</th>
        <th>Antal svar</th>
    </tr>
<?php $id = 0; foreach ($questions as $row) :
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


<br><p><a href="../showQuestions">Tillbaka</a></p>
