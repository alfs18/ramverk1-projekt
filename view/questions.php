<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Frågor</h1>
<p><a href="ask">Ställ fråga</a></p>

<p><a href="showQuestions">Se ställda frågor</a></p>

<h3>Senast ställda</h3>
<?php foreach ($questions as $question): ?>
    <a href="<?= url("user/viewQuestion/{$question->id}"); ?>"><?php echo $question->question ?></a><br>
    - <a href="<?= url("user/viewProfile/{$question->acronym}"); ?>"><?php echo $question->acronym ?></a>,
    <?php echo $question->created ?? null ?><br><br>
<?php endforeach ?>

<h3>Mest aktiva användarna</h3>
<b><a href="<?= url("user/users") ?>">Se alla användare</a></b>
<?php foreach ($userStatus as $user => $status): ?>
    <p><a href="<?= url("user/viewProfile/{$user}"); ?>"><?php echo $user ?></a> -
    <?php echo $status ?></p>
<?php endforeach ?>

<h3>Populäraste taggarna</h3>
<b><a href="<?= url("user/tags") ?>">Se alla taggar</a></b>
<?php foreach ($tags as $tag => $sum): ?>
    <p><a href="<?= url("user/viewTagQuestions/{$tag}"); ?>"><?= $tag ?></a> -
    <?php echo $sum ?></p>
<?php endforeach ?>
