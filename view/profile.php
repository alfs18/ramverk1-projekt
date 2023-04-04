<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Profil (<?= $acronym ?>)
<img src="<?= $baseURL ?>/image/profile/<?= $user[0]->picture ?>?width=80&height=80&crop-to-fit&area=0,0,0,0"></img>
</h1>

<a href="profile-edit/<?= $acronym ?>/picture">Ändra profilbild</a>

<h3>Presentation</h3>
<div class="user-presentation">
    <?= $filter->parse($user[0]->info, ["markdown"])->text ?>
    <a href="profile-edit/<?= $acronym ?>/info">Ändra</a>
</div>

<h3>Aktivitet</h3>
<div class="user-activity">
    <p><b>Antal ställda frågor:</b> <?= sizeof($content ?? []) ?></p>

    <?php $id = 0; foreach ($content as $row) :
        $id++; ?>
        <p><a href="<?= url("user/viewQuestion/{$row->id}"); ?>"><?= $row->question ?></a></p>
    <?php endforeach; ?>

    <p><b>Antal skrivna svar:</b> <?= sizeof($answers ?? []) ?></p>
    <!-- <?php $id = 0; foreach ($answers as $row) :
        $id++; ?>
        <p><?= $row->answer ?></p>
    <?php endforeach; ?> -->

    <p><b>Kommentarer:</b> <?= sizeof($comments ?? []) ?></p>

    <?php $id = 0; foreach ($comments as $comment) :
        $id++; ?>
        <!-- <?php var_dump($comment) ?> -->
        <!-- <p><?= $comment->comment ?></p> -->
    <?php endforeach; ?>
</div>
