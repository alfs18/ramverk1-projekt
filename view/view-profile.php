<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// var_dump($content[0]->question);
?>
<h1><?= $acronym ?>
    <img src="<?= $baseURL ?>/image/profile/<?= $user[0]->picture ?>?width=80&height=80&crop-to-fit&area=0,0,0,0"></img>
</h1>

<h3>Presentation</h3>
<div class="profile-presentation">
    <?= $filter->parse($user[0]->info, ["markdown"])->text ?>
</div>

<h3>Aktivitet</h3>
<div class="profile-activity">
    <p>Antal kommentarer: <?= sizeof($comments ?? []) ?></p>
    <p>Antal skrivna svar: <?= sizeof($answers ?? []) ?></p>
    <p>Antal ställda frågor: <?= sizeof($content ?? []) ?></p>

    <?php if ($content) : ?>
        <table class="profile-questions-table">
            <tr class="first">
                <th>Rad</th>
                <th>Fråga</th>
                <th>Är besvarad?</th>
            </tr>
        <?php $id = 0; foreach ($content as $row) :
            $id++;?>
            <tr>
                <td><?= $id ?></td>
                <td class="question-row">
                    <a href="<?= url("user/viewQuestion/{$row->id}"); ?>">
                        <?= $row->question ?>
                    </a>
                </td>
                <td><?= $row->answered ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif ?>
    </table>


    <!-- <?php $id = 0; foreach ($content as $row) :
        $id++; ?>
        <p><a href="<?= url("user/viewQuestion/{$row->id}"); ?>"><?= $row->question ?></a></p>
        <p>Är besvarad? <?php echo $row->answered ?></p>
    <?php endforeach; ?> -->

</div>
