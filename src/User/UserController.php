<?php

namespace Alfs18\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Alfs18\User\HTMLForm\UserLoginForm;
use Alfs18\User\HTMLForm\CreateUserForm;
use Alfs18\User\HTMLForm\CreateQuestionForm;
use Alfs18\User\HTMLForm\CreateCommentsForm;
// use Alfs18\User\HTMLForm\CreateAnswerForm;
use Alfs18\User\HTMLForm\CreateAnswerCommentsForm;
use Alfs18\User\HTMLForm\FormModelCheckboxMultiple;
use Alfs18\User\HTMLForm\FormElementFile;
use Alfs18\User\HTMLForm\SearchForm;
use Alfs18\User\Functions;
use Anax\TextFilter;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return object or void
     */
    public function initialize()
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        // var_dump($page);
        $route = $request->getRoute();
        // var_dump($route);
        $acronym = $_SESSION["acronym"] ?? null;
        // var_dump($_SESSION);

        if ($route == "user/login" || $route == "user/create") {
            return;
        } elseif (!$acronym) {
            $page = $this->di->get("page");

            $page->add("anax/v2/article/default", [
                "content" => "Vänligen logga in för att ta del av innehållet.",
            ]);

            return $page->render([
                "title" => "Failed",
            ]);
        }

        // if ($route !="user/viewQuestion") {
        //     $baseURL = $request->getBaseUrl();
        //     $pic = [
        //         // "content" => "<img src='../../htdocs/image/snail2.jpg' width='1100px'></img>",
        //         "content" => "<img src='{$baseURL}/image/snail2.jpg' width='1100px'></img>",
        //     ];
        //
        //     $page->add("anax/v2/article/default", $pic, "flash");
        // }

        $baseURL = $request->getBaseUrl();
        $content = [
            "pic" => "<img src='{$baseURL}/image/snail3.jpg' width='1100px'></img>",
            "text" => "<h1>Allt om trädgård</h1>",
        ];

        $page->add("test", $content, "flash");

        // $pic = [
        //         // "content" => "<img src='../../htdocs/image/snail2.jpg' width='1100px'></img>",
        //         "content" => "<img src='{$baseURL}/image/snail2.jpg' width='1100px'></img>",
        //     ];
        //
        //     $page->add("anax/v2/article/default", $pic, "flash");
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/article/default", [
            "content" => "An index page",
        ]);

        return $page->render([
            "title" => "A index page",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        // var_dump($_SESSION);

        if ($_SESSION["acronym"] ?? null) {
            $response = $this->di->get("response");
            return $response->redirect("user/questions");
        }

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        // $data = [
        //     "content" => "Inget konto?<br>Skapa ett <a href='create'>här</a>",
        // ];

        $pic = [
            "content" => "<img src='../../htdocs/image/garden2.jpg' width='1000px'></img>",
        ];

        $page->add("login-side", [], "sidebar-right");
        $page->add("anax/v2/article/default", $pic, "flash");

        return $page->render([
            "title" => "A login page",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function profileAction() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $res = new Functions();
        $acronym = $_SESSION["acronym"];
        $rows = "id, question, tags";
        $questions = $res->getProfileInfo($acronym, $this->di, "Question", $rows);
        $rows2 = "id, questionId, answer";
        $answers = $res->getProfileInfo($acronym, $this->di, "Answers", $rows2);
        $rows3 = "id, questionId, answerId, comment";
        $comments = $res->getProfileInfo($acronym, $this->di, "Comments", "*");
        $rows4 = "points, info, picture, created";
        $user = $res->getProfileInfo($acronym, $this->di, "User", $rows4);
        // var_dump($comments);

        $form = new FormElementFile("img", ["image/*"]);
        $baseURL = $request->getBaseUrl();
        // var_dump($baseURL);

        $filter = new \Anax\TextFilter\TextFilter();

        $page->add("profile", [
            "content" => $questions,
            "acronym" => $acronym,
            "answers" => $answers,
            "comments" => $comments,
            "user" => $user,
            "form" => $form->getHTML(),
            "baseURL" => $baseURL,
            "filter" => $filter,
        ]);

        // $pic = [
        //     "content" => "<img src='../../htdocs/image/car.png' width='1000px'></img>",
        // ];
        //
        // $page->add("login-side", [], "sidebar-right");
        // $page->add("anax/v2/article/default", $pic, "flash");

        return $page->render([
            "title" => "Profile",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function profileEditAction(string $acronym, string $toUpdate) : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $response = $this->di->get("response");

        $res = new Functions();
        $rows = "points, info, picture, created";
        $user = $res->getProfileInfo($acronym, $this->di, "User", $rows);
        $pictures = $res->getAllProfilePictures($this->di, $acronym);

        $info = $_POST["info"] ?? null;
        $picture = $_POST["picture"] ?? null;
        if ($info) {
            var_dump($info);
            $res->setProfileInfo($this->di, $acronym, $info);

            $response->redirect("user/profile");
        } elseif ($picture) {
            var_dump($picture);
            $res->setProfilePicture($this->di, $acronym, $picture);

            $response->redirect("user/profile");
        }

        // update table User, with toUpdate

        $baseURL = $request->getBaseUrl();

        $page->add("profile-edit", [
            "acronym" => $acronym,
            "user" => $user,
            "baseURL" => $baseURL,
            "pictures" => $pictures,
            "toUpdate" => $toUpdate,
        ]);

        return $page->render([
            "title" => "Profile",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function uploadAction() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $res = new Functions();

        $post = $request->getPost("submit");
        var_dump($post);
        // var_dump($_POST["submit"]);
        // var_dump($_POST);
        var_dump($_FILES);

        if ($post) {
            // $res->setProfilePicture($this->di, $acronym, $post);
            $target_dir = "C:/cygwin64/home/Lichn/dbwebb-kurser/ramverk1/me/kmom10/module/htdocs/img/profile/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                var_dump("smask");
             $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
              if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
              } else {
                echo "File is not an image.";
                $uploadOk = 0;
              }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
              echo "Sorry, file already exists.";
              $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
              echo "Sorry, your file is too large.";
              $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
              echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
              echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                $res->setProfilePicture($this->di, $acronym, $_FILES["fileToUpload"]);
                $res->addProfilePicture($this->di, $acronym, $_FILES["fileToUpload"]);
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
            }
        }

        $page->add("anax/v2/article/default", [
            "content" => "Hello",
        ]);

        // $pic = [
        //     "content" => "<img src='../../htdocs/image/car.png' width='1000px'></img>",
        // ];
        //
        // $page->add("login-side", [], "sidebar-right");
        // $page->add("anax/v2/article/default", $pic, "flash");

        return $page->render([
            "title" => "Profile",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function viewProfileAction(string $acronym) : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $res = new Functions();
        $rows = "id, question, tags";
        $questions = $res->getProfileInfo($acronym, $this->di, "Question", $rows);
        foreach ($questions as $question) {
            $answered = $res->checkIfAnswered($this->di, $question->id);
            $question->answered = $answered;
        }
        $answers = $res->getProfileInfo($acronym, $this->di, "Answers", "*");
        $comments = $res->getProfileInfo($acronym, $this->di, "Comments", "*");
        $user = $res->getProfileInfo($acronym, $this->di, "User", "*");
        $baseURL = $request->getBaseUrl();
        $filter = new \Anax\TextFilter\TextFilter();

        $page->add("view-profile", [
            "content" => $questions,
            "answers" => $answers,
            "comments" => $comments,
            "acronym" => $acronym,
            "user" => $user,
            "baseURL" => $baseURL,
            "filter" => $filter,
        ]);

        return $page->render([
            "title" => "Profile",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function askAction() : object
    {
        $page = $this->di->get("page");
        // $acronym = $_SESSION["acronym"];
        $acronym = $_SESSION["acronym"];
        // var_dump($_SESSION);
        $form = new CreateQuestionForm($this->di, $acronym);
        $form->check();

        $page->add("ask-question", [
            "content" => $form->getHTML(),
        ]);

        // $page->add("ask-question", [
        //     "content" => "Hello",
        // ]);

        // $pic = [
        //     "content" => "<img src='../../htdocs/image/car.png' width='1000px'></img>",
        // ];

        $page->add("ask-tip", [], "sidebar-right");
        $page->add("ask-tag", [], "sidebar-right");
        // $page->add("anax/v2/article/default", $pic, "flash");

        return $page->render([
            "title" => "Ställ en fråga",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();


        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function logoutAction() : object
    {
        $page = $this->di->get("page");
        $response = $this->di->get("response");
        $user = new Functions();
        $user->sessionDestroy($this->di);

        // $page->add("anax/v2/article/default", [
        //     "content" => "Du har loggats ut",
        // ]);
        //
        // return $page->render([
        //     "title" => "A create user page",
        // ]);
        $response->redirect("index");
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function questionsAction() : object
    {
        $page = $this->di->get("page");

        $res = new Functions();
        $questions = $res->getAllQuestions($this->di);

        rsort($questions);
        $questions2 = array_slice($questions, 0, 3);

        // Get list of all users.
        $users = $res->getAllUsers($this->di);
        $sums = [];
        foreach ($users as $user) {
            $acronym = $user->acronym;
            // get all questions made by user
            $quests = $res->getProfileInfo($acronym, $this->di, "Question", "question");
            // get all comments made by user
            $com = $res->getProfileInfo($acronym, $this->di, "Comments", "comment");
            // get all answers made by user
            $ans = $res->getProfileInfo($acronym, $this->di, "Answers", "answer");
            // sum up everything
            $sums[$acronym] = sizeof($quests) + sizeof($com) + sizeof($ans);
        }

        arsort($sums);

        // get all tags and count how many times they occur
        $tags = $res->getAllTags($this->di);
        $tags2 = $res->countTagsFrequency($tags);
        arsort($tags2);

        $data = [
            "questions" => $questions2,
            "size" => sizeof($questions),
            "userStatus" => array_slice($sums, 0, 3),
            "tags" => array_slice($tags2, 0, 3),
        ];

        $page->add("questions", $data);

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function tagsAction() : object
    {
        $page = $this->di->get("page");

        // Get all from comments where id = $commentId.
        $res = new Functions();
        $tags = $res->getAllTags($this->di);
        $tags2 = $res->getTagsOnce($tags);
        sort($tags2);
        // var_dump($tags2);

        $page->add("tags", [
            "tags" => $tags2,
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function usersAction() : object
    {
        $page = $this->di->get("page");

        // Get all from comments where id = $commentId.
        $res = new Functions();
        $users = $res->getAllUsers($this->di);

        sort($users);

        $page->add("users", [
            "users" => $users,
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function acceptAnswerAction(int $questionId, int $commentId) : object
    {
        $response = $this->di->get("response");
        $page = $this->di->get("page");

        // Get all from comments where id = $commentId.
        $res = new Functions();
        $comment = $res->getOneQuestionComment($this->di, $commentId);

        $acronym = $comment[0]->acronym;
        $answer = $comment[0]->comment;
        $created = $comment[0]->created;

        // Save as answer.
        $res->saveAnswer($this->di, $questionId, $acronym, $answer, $created);

        // Delete comment.
        $res->deleteComment($this->di, $commentId);

        var_dump($comment[0]->comment);

        // $page->add("anax/v2/article/default", [
        //     "content" => "Hello",
        // ]);
        //
        // return $page->render([
        //     "title" => "A create user page",
        // ]);


        $response->redirect("user/viewQuestion/{$questionId}");
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function showQuestionsAction() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        // get search form
        $formSearch = new SearchForm($this->di);
        $formSearch->check();

        // get all questions to show in the view.
        $res = new Functions();
        $questions = $res->getAllQuestions($this->di);

        // get all tags, and only once
        $tags = $res->getAllTags($this->di);
        $tags2 = $res->getTagsOnce($tags);

        $baseURL = $request->getBaseUrl();
        $size = "?width=50&height=50&crop-to-fit&area=0,0,0,0";

        foreach ($questions as $question) {
            $acronym = $question->acronym;
            $questionId = $question->id;

            // get profile picture of the user who made a question
            $picture = $res->getProfileInfo($acronym, $this->di, "User", "picture");

            $question->picture = "<img src='{$baseURL}/image/profile/{$picture[0]->picture}{$size}'></img>";
            // get all answers
            $question->answers = $res->getQuestionAnswers($this->di, $questionId);
        }



        // show all tags as a checkbox form
        $form = new FormModelCheckboxMultiple($this->di, $tags2);
        $form->check();

        // get variables from posted checkbox form
        $items = $request->getPost();
        if ($items["items"] ?? null) {
            // visa endast info gällande de ikryssade taggarna
            foreach ($items["items"] as $val) {
                // var_dump($val);
                $questions = $res->getSomeQuestionsTags($this->di, $val);
                // var_dump($questions);
            }
        }


        $page->add("show-all-questions", [
            "content" => $formSearch->getHTML(),
            "res" => $questions,
            "tags" => $tags2,
        ]);

        // $page->add("anax/v2/article/default", [
        //     "content" => $form->getHTML(),
        // ], "sidebar-right");

        asort($tags2);
        $page->add("tags", [
            "tags" => $tags2,
        ], "sidebar-right");

        return $page->render([
            "title" => "A create user page",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function viewQuestionAction(int $id) : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        // get all questions to show in the view.
        $res = new Functions();
        $question = $res->getOneQuestion($this->di, $id);
        $submit = $request->getPost("submit-sort") ?? null;
        $answers = $res->getAnswersOrdered($this->di, $id, "created");
        if ($submit) {
            $sort = $request->getPost("sort") ?? null;
            // var_dump($sort);
            $answers = $res->getAnswersOrdered($this->di, $id, $sort);
        }
        $comments = $res->getQuestionComments($this->di, $id);

        // get answerId and make an array of all
        // comments connected to all answers...?
        // Lägg till alla aComments som tillhör $answers[0]
        // till $answers.
        $aComments = $res->getAnswerComments($this->di, 1);
        // $smask = $answers;

        foreach ($answers as $answer) {
            // var_dump($answer->id);
            $aComments2 = $res->getAnswerComments($this->di, $answer->id);
            $answer->comments = $aComments2;
            // $smask->comments = $aComments2;
        }
        // var_dump($answers);

        // var_dump($comments);
        $qId = $question[0]->id;
        // var_dump($qId);
        $acronym = $_SESSION["acronym"];
        // var_dump($acronym);

        $form = new CreateCommentsForm($this->di, $acronym, $qId);
        $form->check();

        // $aForm = new CreateAnswerCommentsForm($this->di, $acronym, $aId ?? 1);
        // $aForm->check();

        // $textfilter = new TextFilter();
        $filter = new \Anax\TextFilter\TextFilter();
        // var_dump($form);
        $up = "<img src='../../../htdocs/image/up.png' width='30px'></img>";
        $down = "<img src='../../../htdocs/image/down.png' width='30px'></img>";

        $user = $_SESSION["acronym"];

        $page->add("view-question", [
            "res" => $question,
            "answers" => $answers,
            "qComments" => $comments,
            "aComments" => $aComments,
            "qComForm" => $form->getHTML(),
            // "aComForm" => $aForm->getHTML(),
            "acronym" => $acronym,
            "filter" => $filter,
            "up" => $up,
            "down" => $down,
            "user" => $user,
            "qId" => $id,
        ]);

        $tags = $question[0]->tags ?? "Grönsaker, Plantor";
        $tagsArray = explode("; ", $tags);

        $page->add("show-tags", [
            "res" => $tagsArray,
        ], "sidebar-right");

        $pic = [
            // "content" => "<img src='../../../htdocs/image/snail2.jpg' width='1100px'></img>",
            "content" => "<h1>Allt om trädgård</h1>",
        ];

        $page->add("anax/v2/article/default", $pic, "flash");

        $content = "<h2>Info</h2><p>Betygsätt en fråga, svar eller kommentar genom att klicka pil upp, om du tyckte den var bra, eller pil ner, om den var dålig.</p>";
        $page->add("anax/v2/article/default", [
            "content" => $content,
        ], "sidebar-right");

        $page->add("ask-tip", [], "sidebar-right");

        return $page->render([
            "title" => "View question",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function editPostAction(int $id, string $table) : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $response = $this->di->get("response");

        if ($table == "Question") {
            $rows = "question, tags";
        } elseif ($table == "Answers") {
            $rows = "answer";
        } else {
            $rows = "comment";
        }

        // get the post to update.
        $res = new Functions();
        $post = $res->getOnePost($this->di, $id, $table, $rows);

        $submit = $request->getPost("submit") ?? null;
        $delete = $request->getPost("delete") ?? null;
        if ($submit) {
            $altered = $request->getPost("info");
            if ($table == "Question") {
                $tags = $request->getPost("tags");
                $res->updatePost($this->di, $id, $table, "tags", $tags);
                $rows = "question";
            }
            $res->updatePost($this->di, $id, $table, $rows, $altered);
            $response->redirect("user/editPost/{$id}/{$table}");
        } elseif ($delete) {
            $res->deletePost($this->di, $id, $table);

            $page->add("anax/v2/article/default", [
                "content" => "<h2>Inlägg borttaget!</h2>",
            ]);

            return $page->render([
                "title" => "Edit",
            ]);
        }

        $page->add("edit-post", [
            "post" => $post,
            "table" => $table,
            "rows" => $rows,
            // "qId" => $id,
        ]);

        return $page->render([
            "title" => "View question",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function viewTagQuestionsAction(string $tag) : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        // get all questions to show in the view.
        $res = new Functions();
        $questions = $res->getSomeQuestions($this->di, $tag);

        $baseURL = $request->getBaseUrl();
        $size = "?width=50&height=50&crop-to-fit&area=0,0,0,0";

        foreach ($questions as $question) {
            $acronym = $question->acronym;
            $questionId = $question->id;

            // get profile picture of the user who made a question
            $picture = $res->getProfileInfo($acronym, $this->di, "User", "picture");

            $question->picture = "<img src='{$baseURL}/image/profile/{$picture[0]->picture}{$size}'></img>";
            // get all answers
            $question->answers = $res->getQuestionAnswers($this->di, $questionId);
        }

        $filter = new \Anax\TextFilter\TextFilter();

        $user = $_SESSION["acronym"];

        $page->add("view-tag-questions", [
            "questions" => $questions,
            "filter" => $filter,
            "user" => $user,
            "tag" => $tag,
        ]);

        return $page->render([
            "title" => "View question",
        ]);
    }


    /**
     * Description.
     *
     * @param string $table  Informs if points should be changed
     *                      for question/answer/comment.
     * @param int $qId       The id of the question previously shown.
     * @param int $id       The id of the question/answer/comment.
     *
     * @throws Exception
     *
     * @return
     */
    public function pointsAction(string $table, int $qId, int $id, int $points)
    {
        $page = $this->di->get("page");
        $response = $this->di->get("response");

        $res = new Functions();

        // Get the current points from database.
        $currentPoints = $res->getPoints($this->di, $table, $id);

        // Add new points.
        $result = intval($currentPoints->points) + $points;
        $smask = $res->setPoints($this->di, $table, $id, $result);

        return $response->redirect("user/viewQuestion/{$qId}");

        // $ans = $res->getQuestionAnswers($this->di, 1);
        // var_dump($ans);

        // $page->add("anax/v2/article/default", [
        //     "content" => "Hello",
        // ]);
        //
        // return $page->render([
        //     "title" => "Points",
        // ]);
    }
}
