<?php
    class M_Comments {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function addComment($data) {
            $this->db->query('INSERT INTO Comments(post_id, user_id, content, likes, dislikes) VALUES(:post_id, :user_id, :content, :likes, :dislikes)');
            $this->db->bind(':post_id', $data['post_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':content', $data['content']);
            $this->db->bind(':likes', $data['likes']);
            $this->db->bind(':dislikes', $data['dislikes']);

            // Execute 
            if($this->db->execute()) {
                return true;
            }
            else {
                return false;
            }
        }

        public function getComments($id) {
            $this->db->query('SELECT * FROM v_comments WHERE post_id = :post_id');
            $this->db->bind(':post_id', $id);

            return $this->db->resultSet();
        }

        public function deleteComment($commentId) {
            $this->db->query('DELETE FROM Comments WHERE comment_id = :id');
            $this->db->bind(':id', $commentId);

            // Execute 
            if($this->db->execute()) {
                return true;
            }
            else {
                return false;
            }
        }

        // COMMENTS INTERACTIONS
        public function incLikes($commentId) {
            $this->db->query('UPDATE Comments SET likes = likes + 1 WHERE comment_id = :comment_id');
            $this->db->bind(':comment_id', $commentId);

            // Execute 
            if($this->db->execute()) {
                return $this->getLikes($commentId);
            }
            else {
                return false;
            }
        }

        public function decLikes($commentId) {
            $this->db->query('UPDATE Comments SET likes = likes - 1 WHERE comment_id = :comment_id');
            $this->db->bind(':comment_id', $commentId);

            // Execute 
            if($this->db->execute()) {
                return $this->getLikes($commentId);
            }
            else {
                return false;
            }
        }

        public function getLikes($commentId) {
            $this->db->query('SELECT likes FROM v_comments WHERE comment_id = :comment_id');
            $this->db->bind(':comment_id', $commentId);

            $row = $this->db->single();

            return $row;
        }


        public function incDislikes($commentId) {
            $this->db->query('UPDATE Comments SET dislikes = dislikes + 1 WHERE comment_id = :comment_id');
            $this->db->bind(':comment_id', $commentId);

            // Execute 
            if($this->db->execute()) {
                return $this->getDislikes($commentId);
            }
            else {
                return false;
            }
        }

        public function decDislikes($commentId) {
            $this->db->query('UPDATE Comments SET dislikes = dislikes - 1 WHERE comment_id = :comment_id');
            $this->db->bind(':comment_id', $commentId);

            // Execute 
            if($this->db->execute()) {
                return $this->getDislikes($commentId);
            }
            else {
                return false;
            }
        }

        public function getDislikes($commentId) {
            $this->db->query('SELECT dislikes FROM v_comments WHERE comment_id = :comment_id');
            $this->db->bind(':comment_id', $commentId);

            $row = $this->db->single();

            return $row;
        }

        // comments likes dislikes interacitons
        public function addCommentInteraction($commentId, $userId, $interaction) {
            $this->db->query('INSERT INTO CommentsInteractions(comment_id, user_id, interaction) VALUES(:comment_id, :user_id, :interaction)');
            $this->db->bind(":comment_id", $commentId);
            $this->db->bind(":user_id", $userId);
            $this->db->bind(":interaction", $interaction);

            if($this->db->execute()) {
                return true;
            }
            else {
                return false;
            }
        }

        public function setCommentInteraction($commentId, $userId, $interaction) {
            $this->db->query('UPDATE CommentsInteractions SET interaction = :interaction WHERE comment_id = :comment_id AND user_id = :user_id');
            $this->db->bind(":comment_id", $commentId);
            $this->db->bind(":user_id", $userId);
            $this->db->bind(":interaction", $interaction);

            if($this->db->execute()) {
                return true;
            }
            else {
                return false;
            }
        }

        public function getCommentInteraction($commentId, $userId) {
            $this->db->query('SELECT * FROM CommentsInteractions WHERE comment_id = :comment_id AND user_id = :user_id');
            $this->db->bind(":comment_id", $commentId);
            $this->db->bind(":user_id", $userId);

            $row = $this->db->single();

            return $row;
        }

        public function isCommentInteractionExist($commentId, $userId) {
            $this->db->query('SELECT * FROM CommentsInteractions WHERE comment_id = :comment_id AND user_id = :user_id');
            $this->db->bind(":comment_id", $commentId);
            $this->db->bind(":user_id", $userId);

            $results = $this->db->single();

            $results = $this->db->rowCount();

            if($results > 0) {
                return true;
            }
            else {
                return false;
            }
        }
    }
?>