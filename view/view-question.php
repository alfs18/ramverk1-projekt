<?php

namespace Anax\View;

use Alfs18\User\HTMLForm\CreateAnswerCommentsForm;
/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<form class="sorting" action="" method="post">
    <label for="sort">Sortera svaren efter:</label>
    <select name="sort" id="sort-answers">
        <option value="created">Datum</option>
        <option value="points DESC">Rank</option>
    </select>
    <input type="submit" name="submit-sort" value="Submit">
</form>
<br>

<!-- Show the question -->
<div class="main-question">
    <?php echo $filter->parse($res[0]->question, ["markdown"])->text ?>
    - <a href="<?= url("user/viewProfile/{$res[0]->acronym}"); ?>"><?php echo $res[0]->acronym ?></a>
    <br>
    <?php echo $res[0]->created ?>
    <?php if ($user == $res[0]->acronym) :?>
        <br><a href="../../user/editPost/<?= $res[0]->id ?>/Question"> Ändra </a>
    <?php endif; ?>
    <br><br><a class="img-button" href="<?= url("user/points/Question/{$qId}/{$qId}/1"); ?>"> <?= $up ?> </a>
    <a class="img-button" href="<?= url("user/points/Question/{$qId}/{$qId}/-1"); ?>"> <?= $down ?> </a>
    Poäng: <?= $res[0]->points ?>
</div>

<!-- Show comments connected to question -->
<?php $id = 0; foreach ($qComments as $com) :
    $id++; ?>
    <div class="comments-div">
        <div class="button-div">
            Poäng: <?= $com->points ?>
            <a class="img-button" href="<?= url("user/points/Comments/{$qId}/{$com->id}/1"); ?>"> <?= $up ?> </a>
            <a class="img-button" href="<?= url("user/points/Comments/{$qId}/{$com->id}/-1"); ?>"> <?= $down ?> </a>
        </div>
        <div class="q-comments">
            <?php echo $filter->parse($com->comment, ["markdown"])->text ?>
            - <a href="<?= url("user/viewProfile/{$com->acronym}"); ?>"><?php echo $com->acronym ?></a>
            <?php echo $com->created ?>
            <?php if ($user == $com->acronym) :?>
                <br><br><a href="../../user/editPost/<?= $com->id ?>/Comments"> Ändra </a>
            <?php endif; ?>
            <?php if ($user == $res[0]->acronym) :?>
                <p><a class="answer-button" href="<?= url("user/acceptAnswer/{$qId}/{$com->id}"); ?>"> Godkänn som svar </a></p>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<!-- Comment question -->
<?php print_r($qComForm) ?>

<!-- Show answers connected to question -->
<?php $id = 0; foreach ($answers as $row) :
    $id++; ?>
    <div class="answer">
        <h4 class="answer-h4">Svar</h4>
        <!-- <?= $row->id ?><br> -->
        <?php echo $filter->parse($row->answer, ["markdown"])->text ?><br>
        - <a href="<?= url("user/viewProfile/{$row->acronym}"); ?>"><?php echo $row->acronym ?></a><br>
        <?= $row->created ?>
        <?php if ($user == $row->acronym) :?>
            <br><a href="../../user/editPost/<?= $row->id ?>/Answers"> Ändra </a>
        <?php endif; ?>
        <br><br><a class="img-button" href="<?= url("user/points/Answers/{$qId}/{$row->id}/1"); ?>"> <?= $up ?> </a>
        <a class="img-button" href="<?= url("user/points/Answers/{$qId}/{$row->id}/-1"); ?>"> <?= $down ?> </a>
        Poäng: <?= $row->points ?>
    </div>

    <!-- Show comments connected to answer -->
    <?php foreach ($row->comments as $comment): ?>
    <div class="comments-div">
        <div class="button-div">
            Poäng: <?= $comment->points ?>
            <a class="img-button" href="<?= url("user/points/AnswerComments/{$qId}/{$comment->id}/1"); ?>"> <?= $up ?> </a>
            <a class="img-button" href="<?= url("user/points/AnswerComments/{$qId}/{$comment->id}/-1"); ?>"> <?= $down ?> </a>
        </div>
        <div class="a-comments">
        <?php echo $filter->parse($comment->comment, ["markdown"])->text ?>
        - <a href="<?= url("user/viewProfile/{$comment->acronym}"); ?>"><?php echo $comment->acronym ?></a>
        <?= $comment->created ?><br>
        <?php if ($user == $comment->acronym) :?>
            <a href="../../user/editPost/<?= $comment->id ?>/AnswerComments"> Ändra </a>
        <?php endif; ?>
        <!-- <?php if ($user == $res[0]->acronym) :?>
            <p><a class="answer-button" href="<?= url("user/acceptAnswer/{$qId}/{$comment->id}"); ?>"> Godkänn som svar </a></p>
        <?php endif; ?> -->
    </div>
    </div>
    <?php endforeach; ?>

    <!-- Form to comment answer -->
    <?php
    $aForm = new CreateAnswerCommentsForm($this->di, $acronym, $row->id);
    $aForm->check();
    print_r($aForm->getHTML());
    ?>
<?php endforeach; ?>
