<?php

namespace Alfs18\User;

// use Psr\Container\ContainerInterface;

/**
 * Functions.
 */
class Functions
{
    /**
     * Get user information.
     *
     * @param string $acronym current user that's logged in.
     * @param object $di.
     *
     * @return array
     */
    public function getProfileInfo($acronym, $di, $table, $rows)
    {
        $db = $di->get("dbqb");
        $db->connect();
        // $user = $db->select("id, question, tags")
        //            ->from("Question")
        $user = $db->select($rows)
                   ->from($table)
                   ->where("acronym = ?")
                   ->execute([$acronym])
                   ->fetchAll();

        // var_dump($user);
        return $user;
    }


    /**
     * Get one post.
     *
     * @param object $di.
     * @param int $id       the id of the post.
     * @param string $table the table that contains the post.
     * @param string $rows  the rows to be fetch.
     *
     * @return array
     */
    public function getOnePost($di, $id, $table, $rows)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $post = $db->select($rows)
                   ->from($table)
                   ->where("id = ?")
                   ->execute([$id])
                   ->fetchAll();

        // var_dump($post);
        return $post;
    }


    /**
     * Get one post.
     *
     * @param object $di.
     * @param int $id       the id of the post.
     * @param string $table the table that contains the post.
     * @param string $rows  the rows to be updated.
     * @param string $res   the updated text.
     *
     * @return array
     */
    public function updatePost($di, $id, $table, $rows, $res)
    {
        $db = $di->get("dbqb");
        $db->connect()
            ->update($table, [$rows])
            ->where("id = ?")
            ->execute([$res, $id]);

        return "Saved";
    }


    /**
     * Get one post.
     *
     * @param object $di.
     * @param int $id       the id of the post.
     * @param string $table the table that contains the post.
     *
     * @return array
     */
    public function deletePost($di, $id, $table)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $sql = "DELETE FROM $table WHERE id = ?;";
        $db->execute($sql, [$id]);
        return "Deleted";
    }


    /**
     * Get one post.
     *
     * @param object $di.
     * @param int $id       the id of the post.
     * @param string $table the table that contains the post.
     *
     * @return array
     */
    public function deleteCommentOrAnswer($di, $id, $table)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $sql = "DELETE FROM $table WHERE questionId = ?;";
        $db->execute($sql, [$id]);

        return "Deleted";
    }


    /**
     * Get one post.
     *
     * @param object $di.
     * @param int $id       the id of the post.
     * @param string $table the table that contains the post.
     *
     * @return array
     */
    public function deleteAnswerComments($di, $id)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $sql = "DELETE FROM AnswerComments WHERE answerId = ?;";
        $db->execute($sql, [$id]);

        return "Deleted";
    }



    /**
     * Get all users.
     *
     * @param object $di.
     *
     * @return array
     */
    public function getAllUsers($di)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $users = $db->select("acronym")
                   ->from("User")
                   ->execute()
                   ->fetchAll();

        return $users;
    }



    /**
     * Get information about which users are the most active.
     *
     * @param object $di.
     * @param array $users. List of all users.
     *
     * @return array
     */
    public function getUserStatus($di, $users)
    {
        // get all answers made by $acronym
        $answers = [];
        foreach ($users as $acronym) {
            $db = $di->get("dbqb");
            $db->connect();
            $answers = $db->select("answer")
                        ->from("Answers")
                        ->where("acronym = ?")
                        ->execute([$acronym])
                        ->fetchAll();
        }

        return $answers;
    }



    /**
     * Get all questions.
     *
     * @param object $di.
     *
     * @return array
     */
    public function getAllQuestions($di)
    {
        $db = $di->get("dbqb");
        $db->connect();

        $questions = $db->select("*")
                        ->from("Question")
                        ->execute()
                        ->fetchAll();

        return $questions;
    }


    /**
     * Get some questions.
     *
     * @param object $di.
     *
     * @return array
     */
    public function getSomeQuestions($di, $tag)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $questions = $db->select("*")
                        ->from("Question")
                        ->where("tags LIKE ?")
                        ->execute(["%$tag%"])
                        ->fetchAll();

        return $questions;
    }


    /**
     * Get all tags.
     *
     * @param object $di.
     *
     * @return array
     */
    public function getAllTags($di)
    {
        $db = $di->get("dbqb");
        $db->connect();

        $res = $db->select("tags")
                        ->from("Question")
                        ->execute()
                        ->fetchAll();

        // Add all tags to one string.
        $tagString = "";
        foreach ($res as $question) {
            $tagString .= "; " . $question->tags;
            // var_dump($tagString);
        }

        // Remove '; ' from the beginning of string.
        $tagString = trim($tagString, "; ");

        // Create an array.
        $tagsArray = explode("; ", $tagString);
        // var_dump($tagsArray);

        // // Make sure a tag only occur once in the array.
        // $tags = [];
        // foreach ($tagsArray as $val) {
        //     if (!in_array($val, $tags)) {
        //         array_push($tags, $val);
        //     }
        // }

        return $tagsArray;
    }


    /**
     * Get tags once. Makes sure a tag
     * in the array only occurs once.
     *
     * @param array $tagsArray     Array with tags.
     *
     * @return array
     */
    public function getTagsOnce($tagsArray)
    {
        $tags = [];
        foreach ($tagsArray as $val) {
            if (!in_array($val, $tags)) {
                array_push($tags, $val);
            }
        }

        return $tags;
    }


    /**
     * Count the amount of time a tag occur in the array.
     *
     * @param array $tagsArray     Array with tags.
     *
     * @return array
     */
    public function countTagsFrequency($tagsArray)
    {
        // var_dump($tagsArray);
        $tags = [];
        foreach ($tagsArray as $val) {
            if (!array_key_exists($val, $tags)) {
                $tags[$val] = 0;
            }
            $tags[$val] += 1;
        }

        return $tags;
    }


    /**
     * Change character to ÅÄÖ if needed.
     *
     * @param string $text     The string/text to be checked.
     *
     * @return array
     */
    public function changeCharacter($text)
    {
        $characters = [
            "/&Aring;/" => "Å",
            "/&aring;/" => "å",
            "/&Auml;/" => "Ä",
            "/&auml;/" => "ä",
            "/&Ouml;/" => "Ö",
            "/&ouml;/" => "ö"
        ];

        foreach ($characters as $key => $val) {
            $text = preg_replace($key, $val, $text);
        }
        return $text;
    }


    /**
     * Get some tags.
     *
     * @param object $di.
     *
     * @return array
     */
    public function getSomeQuestionsTags($di, $res)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $questions = $db->select("id, acronym, question, tags")
                   ->from("Question")
                   ->where("tags LIKE ?")
                   ->execute(["%$res%"])
                   ->fetchAll();

        // var_dump($questions);
        return $questions;
    }


    /**
     * Get one question.
     *
     * @param object $di.
     *
     * @return array
     */
    public function getOneQuestion($di, $res)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $questions = $db->select("*")
                   ->from("Question")
                   ->where("id = ?")
                   ->execute([$res])
                   ->fetchAll();

        // var_dump($questions);
        return $questions;
    }


    /**
     * Get question information.
     *
     * @param string $acronym current user that's logged in.
     * @param object $di.
     *
     * @return array
     */
    public function getQuestionComments($di, $questionId)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $res = $db->select("*")
                   ->from("Comments")
                   ->where("questionId = ?")
                   ->execute([$questionId])
                   ->fetchAll();

        // var_dump($res);
        return $res;
    }


    /**
     * Get one question comment.
     *
     * @param object $di.
     * @param int $id Id of the comment.
     *
     * @return array
     */
    public function getOneQuestionComment($di, $id)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $res = $db->select("*")
                   ->from("Comments")
                   ->where("id = ?")
                   ->execute([$id])
                   ->fetchAll();

        return $res;
    }


    /**
     * Get all comments connected to answer.
     *
     * @param int $answerId the answer the comment is connected to.
     * @param object $di.
     *
     * @return array
     */
    public function getAnswerComments($di, $answerId)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $res = $db->select("*")
                   ->from("AnswerComments")
                   ->where("answerId = ?")
                   ->execute([$answerId])
                   ->fetchAll();

        // var_dump($res);
        return $res;
    }


    /**
     * Get all comments connected to answer.
     *
     * @param object $di.
     * @param int $questionId the question the answer is connected to.
     * @param string $column the column to order by.
     *
     * @return array
     */
    public function getAnswersOrdered($di, $questionId, $column)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $sql = "SELECT * FROM Answers WHERE questionId = ? ORDER BY $column;";
        $res = $db->executeFetchAll($sql, [$questionId]);

        return $res;
    }


    /**
     * Check if a question has been answered.
     *
     * @param int $questionId the question the answer is connected to.
     * @param object $di.
     *
     * @return string   either Ja or Nej.
     */
    public function checkIfAnswered($di, $questionId)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $res = $db->select("answer")
                   ->from("Answers")
                   ->where("questionId = ?")
                   ->execute([$questionId])
                   ->fetch();

        $answered = "Nej";
        if ($res ?? null) {
            $answered = "Ja";
        }
        return $answered;
    }


    /**
     * Get question information.
     *
     * @param object $di.
     * @param int $questionId Id of the question.
     *
     * @return array
     */
    public function getQuestionAnswers($di, $questionId)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $res = $db->select("*")
                   ->from("Answers")
                   ->where("questionId = ?")
                   ->execute([$questionId])
                   ->fetchAll();

        // var_dump($res);
        return $res;
    }


    /**
     * Check if logged in user is the same as acronym.
     *
     * @param string $acronym the username to check.
     *
     * @return array
     */
    public function userCheck($acronym)
    {
        $user = $_SESSION["acronym"];
        if ($user == $acronym) {
            return true;
        }
        return false;
    }


    /**
     * Get question information.
     *
     * @param object $di.
     * @param int $questionId Id of the question.
     *
     * @return array
     */
    public function getPoints($di, $table, $id)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $res = $db->select("points")
                   ->from($table)
                   ->where("id = ?")
                   ->execute([$id])
                   ->fetch();

        return $res;
    }


    /**
     * Check if logged in user is the same as acronym.
     *
     * @param object $di
     * @param string $table the table to update.
     * @param int $id       the id being updated.
     * @param int $points   the points to be added.
     *
     * @return array
     */
    public function setPoints($di, $table, $id, $points)
    {
        // var_dump($points);
        $db = $di->get("dbqb");
        $db->connect()
            ->update($table, ["points"])
            ->where("id = ?")
            ->execute([$points, $id]);

        return "Saved";
    }


    /**
     * Change profile picture.
     *
     * @param object $di
     * @param string $acronym the user's picture to update.
     * @param string $picture the picture to change to.
     *
     * @return array
     */
    public function setProfilePicture($di, $acronym, $picture)
    {
        // var_dump($points);
        $db = $di->get("dbqb");
        $db->connect()
            ->update("User", ["picture"])
            ->where("acronym = ?")
            ->execute([$picture, $acronym]);

        return "Saved";
    }


    /**
     * Change profile info.
     *
     * @param object $di
     * @param string $acronym   the user's picture to update.
     * @param string $info      the info text to change to.
     *
     * @return array
     */
    public function setProfileInfo($di, $acronym, $info)
    {
        $db = $di->get("dbqb");
        $db->connect()
            ->update("User", ["info"])
            ->where("acronym = ?")
            ->execute([$info, $acronym]);

        return "Saved";
    }


    /**
     * Add uploaded profile picture to table Pictures.
     *
     * @param object $di
     * @param string $acronym the user that uploads the picture.
     * @param string $name    the name of the picture.
     *
     * @return array
     */
    public function addProfilePicture($di, $acronym, $name)
    {
        // var_dump($points);
        $db = $di->get("dbqb");
        $db->connect()
            ->insert("Pictures", ["acronym", "name"])
            ->execute([$acronym, $name]);

        return "Saved";
    }


    /**
     * Get all profile pictures from table Pictures.
     *
     * @param object $di
     * @param string $acronym the user that uploaded the picture.
     * @param string $name    the name of the picture.
     *
     * @return array
     */
    public function getAllProfilePictures($di, $acronym)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $res = $db->select("name")
                   ->from("Pictures")
                   ->where("acronym = ? OR acronym = ?")
                   ->execute(["default", $acronym])
                   ->fetchAll();

        return $res;
    }


    /**
     * Save answer.
     *
     * @param object $di.
     * @param int $questionId Id of the question.
     * @param string $acronym The user who made the comment/answer.
     * @param string $answer The comment/answer.
     *
     * @return array
     */
    public function saveAnswer($di, $questionId, $acronym, $answer, $created)
    {
        $points = 0;

        $db = $di->get("dbqb");
        $db->connect()
            ->insert("Answers", ["questionId", "acronym", "answer", "points", "created"])
            ->execute([$questionId, $acronym, $answer, $points, $created]);

        return "Saved";
    }


    /**
     * Delete comment.
     *
     * @param object $di.
     * @param int $id Id of the comment to be removed.
     *
     * @return array
     */
    public function deleteComment($di, $id)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $sql = "DELETE FROM Comments WHERE id = ?;";
        $db->execute($sql, [$id]);
    }



    /**
     * Destroy a session, the session must be started.
     *
     * @return void
     */
    function sessionDestroy()
    {
        $style = $_SESSION['AnaxStyleChooser'] ?? "css/mine.css";
        // Unset all of the session variables.
        $_SESSION = [];

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        $_SESSION['AnaxStyleChooser'] = $style;

        // $_SESSION["status"] = null;
        // $_SESSION["acronym"] = null;
        // $_SESSION["message"] = null;
        // var_dump($_SESSION);
    }
}
