<?php
    class Comments extends Controller {
        public function __construct() {
            $this->commentsModel = $this->model('M_Comments');
        }

        // CREATE
        public function comment($id) {
            $userId = $_SESSION['user_id'];
            $postId = $id;
            $commentContent = $_POST['post-comment'];

            echo 'user: '.$userId.' post'.$postId.' comment'.$commentContent;

            $data = [
                'post_id' => $postId,
                'user_id' => $userId,
                'content' => $commentContent,
                'likes' => '',
                'dislikes' => '',
            ];

            if($this->commentsModel->addComment($data)) {
                flash('comment_msg', 'Your comment added.');
            }
            else {
                die('Something went wrong');
            }
        }

        public function showComments($id) {
            $comments = $this->commentsModel->getComments($id);

            $userId = $_SESSION['user_id'];

            // Render  HTML elements using PHP
            foreach($comments as $comment) {
                if($this->commentsModel->isCommentInteractionExist($comment->comment_id, $userId)) {
                    $selfInteraction = $this->commentsModel->getCommentInteraction($comment->comment_id, $userId);
                    $selfInteraction = $selfInteraction->interaction;
                }
                else {
                    $selfInteraction = '';
                }

                echo '<div class="comment-container">';
                echo    '<div class="comment-left">';
                echo        '<img src="'.URLROOT.'/img/profileImgs/'.$comment->profile_image.'" alt="">'; 
                echo    '</div>';
                echo    '<div class="comment-right">';
                echo       '<div class="comment-right-header">';
                echo            '<div class="comment-right-subheader">';
                echo                '<div class="comment-user-name">'.$comment->user_name.'</div>';
                echo                '<span class="comment-delete-btn"><img src="'.URLROOT.'/img/components/comments/comment-delete-btn.png" alt="" onclick="deleteComment('.$comment->comment_id.')"></span>';
                echo            '</div>';
                echo            '<div class="comment-posted-at">'.convertTimeToReadableFormat($comment->comment_created_at).'</div>';
                echo        '</div>';
                echo        '<div class="comment-right-body">';
                echo            $comment->content;
                echo        '</div>';
                echo        '<div class="comment-right-footer">';
                if($selfInteraction == "liked") {
                echo            '<div class="comment-likes active" id="comment-likes-'.$comment->comment_id.'" onclick="addCommentLike('.$comment->comment_id.')">';
                }
                else {
                echo            '<div class="comment-likes" id="comment-likes-'.$comment->comment_id.'" onclick="addCommentLike('.$comment->comment_id.')">';
                }
                echo                '<img src="'.URLROOT.'/img/components/comments/like-btn.png" alt="">';
                echo                '<div class="comment-likes-count" id="comment-likes-count-'.$comment->comment_id.'">'.$comment->likes.'</div>';
                echo            '</div>';
                if($selfInteraction == "disliked") {
                echo            '<div class="comment-dislikes active" id="comment-dislikes-'.$comment->comment_id.'" onclick="addCommentDislike('.$comment->comment_id.')">';
                }
                else {
                echo            '<div class="comment-dislikes" id="comment-dislikes-'.$comment->comment_id.'" onclick="addCommentDislike('.$comment->comment_id.')">';
                }
                echo                '<img src="'.URLROOT.'/img/components/comments/dislike-btn.png" alt="">';
                echo                '<div class="comment-likes-count" id="comment-dislikes-count-'.$comment->comment_id.'">'.$comment->dislikes.'</div>';
                echo            '</div>';
                echo        '</div>';
                echo    '</div>';
                echo '</div>';
            }
        }

        public function deleteComment($commentid) {
            if($this->commentsModel->deleteComment($commentid)) {
                flash('comment_msg', 'Your comment removed.');
            }
            else {
                die('Something went wrong');
            }
        }

        // COMMENTS INTERACTIONS
        // Likes
        public function incCommentsLikes($commentid) {
            $likes =  $this->commentsModel->incLikes($commentid);

            $userId = $_SESSION['user_id'];

            if($this->commentsModel->isCommentInteractionExist($commentid, $userId)) {
                $res = $this->commentsModel->setCommentInteraction($commentid, $userId, 'liked');
            }
            else {
                $res = $this->commentsModel->addCommentInteraction($commentid, $userId, 'liked');
            }

            if($likes != false && $res != false) {
                echo $likes->likes;
            }
        }

        public function decCommentsLikes($commentid) {
            $likes =  $this->commentsModel->decLikes($commentid);

            $userId = $_SESSION['user_id'];

            $res = $this->commentsModel->setCommentInteraction($commentid, $userId, 'like removed');

            if($likes != false && $res != false) {
                echo $likes->likes;
            }
        }

        // dislikes
        public function incCommentsDislikes($commentid) {
            $dislikes =  $this->commentsModel->incDislikes($commentid);

            $userId = $_SESSION['user_id'];

            if($this->commentsModel->isCommentInteractionExist($commentid, $userId)) {
                $res = $this->commentsModel->setCommentInteraction($commentid, $userId, 'disliked');
            }
            else {
                $res = $this->commentsModel->addCommentInteraction($commentid, $userId, 'disliked');
            }

            if($dislikes != false && $res != false) {
                echo $dislikes->dislikes;
            }
        }

        public function decCommentsDislikes($commentid) {
            $dislikes =  $this->commentsModel->decDislikes($commentid);

            $userId = $_SESSION['user_id'];

            $res = $this->commentsModel->setCommentInteraction($commentid, $userId, 'dislike removed');

            if($dislikes != false && $res != false) {
                echo $dislikes->dislikes;
            }
        }
    }
?>