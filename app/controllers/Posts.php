<?php
    class Posts extends Controller {
        public function __construct() {
            $this->postsModel = $this->model('M_Posts');
        }

        // MAIN POSTS FUNCTIONS
        // VIEW
        public function index() {
            $posts = $this->postsModel->getPosts();

            $data = [
                'posts' => $posts
            ];

            $this->view('posts/v_index', $data);
        }

        public function show($id) {
            $post = $this->postsModel->getPostById($id);

            $data = [
                'post' => $post
            ];

            $this->view('posts/v_show', $data);
        }

        // CREATE
        public function create() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'image' => $_FILES['image'],
                    'image_name' => time().'_'.$_FILES['image']['name'],
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),

                    'image_err' => '',
                    'title_err' => '',
                    'body_err' => ''
                ];

                // validation
                if($data['image']['size'] > 0) {
                    if(uploadImage($data['image']['tmp_name'], $data['image_name'], '/img/postsImgs/')) {
                        // done
                    }
                    else {
                        $data['image_err'] = 'Unsuccessful image uploading';
                    }
                }
                else {
                    $data['image_name'] = null;
                }

                if(empty($data['title'])) {
                    $data['title_err'] = 'Please enter a title';
                }

                if(empty($data['body'])) {
                    $data['body_err'] = 'Please enter a content';
                }

                if(empty($data['image_err']) && empty($data['title_err']) && empty($data['body_err'])) {
                    if($this->postsModel->create($data)) {
                        // get the post id 
                        $postId = $this->postsModel->getPostIdByContent($data);
                        $userId = $_SESSION['user_id'];

                        $this->postsModel->addPostInteraction($postId, $userId, 'new');

                        flash('post_msg', 'Post is published');
                        redirect('Posts/index');
                    }
                    else {
                        die('Something went wrong');
                    }
                }
                else {
                    // Loading the view with errors
                    $this->view('posts/v_create', $data);
                }
            }
            else {
                $data = [
                    'image' => '',
                    'image_name' => '',
                    'title' => '',
                    'body' => '',

                    'image_err' => '',
                    'title_err' => '',
                    'body_err' => ''
                ];

                $this->view('posts/v_create', $data);
            }
        }

        // UPDATE
        public function edit($postId) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'image' => $_FILES['image'],
                    'image_name' => time().'_'.$_FILES['image']['name'],
                    'post_id' => $postId,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),

                    'image_err' => '',
                    'title_err' => '',
                    'body_err' => ''
                ];

                // validation
                $post = $this->postsModel->getPostById($postId);
                $oldImage = PUBROOT.'/img/postsImgs/'.$post->image;

                // photo updated
                // user havent changed the existing image
                if($_POST['intentially_removed'] == 'removed') {
                    deleteImage($oldImage);
                    
                    $data['image_name'] = '';
                }
                else {
                    if($_FILES['image']['name'] == '') {
                        $data['image_name'] = $post->image;
                    }
                    else {
                        updateImage($oldImage, $data['image']['tmp_name'], $data['image_name'],'/img/postsImgs/');
                    }
                }

                if(empty($data['title'])) {
                    $data['title_err'] = 'Please enter a title';
                }

                if(empty($data['body'])) {
                    $data['body_err'] = 'Please enter a content';
                }

                if(empty($data['title_err']) && empty($data['body_err'])) {
                    if($this->postsModel->edit($data)) {
                        flash('post_msg', 'Post is updated');
                        redirect('Posts/v_edit');
                    }
                    else {
                        die('Something went wrong');
                    }
                }
                else {
                    // Loading the view with errors
                    $this->view('posts/v_edit', $data);
                }
            }
            else {
                $post = $this->postsModel->getPostById($postId);

                // Check the owner
                if($post->user_id != $_SESSION['user_id']) {
                    redirect('Posts/v_index');
                }

                $data = [
                    'image' => '',
                    'image_name' => $post->image,
                    'post_id' => $postId,
                    'title' => $post->title,
                    'body' => $post->body,

                    'image_err' => '',
                    'title_err' => '',
                    'body_err' => ''
                ];

                $this->view('posts/v_edit', $data);
            }
        }

        // DELETE
        public function delete($postId) {
            $post = $this->postsModel->getPostById($postId);

            // Check owner
            if($post->user_id != $_SESSION['user_id']) {
                redirect('Posts/v_index');
            }
            else {
                $post = $this->postsModel->getPostById($postId);
                $oldImage = PUBROOT.'/img/postsImgs/'.$post->image;
                deleteImage($oldImage);

                if($this->postsModel->delete($postId)) {
                    flash('post_msg', 'Post is deleted');
                    redirect('Posts/v_index');
                }
                else {
                    die('Something went wrong');
                }
            }
        }

        // POST INTERACTIONS
        // Likes
        public function incPostsLikes($postId) {
            $likes =  $this->postsModel->incLikes($postId);

            $userId = $_SESSION['user_id'];

            if($this->postsModel->isPostInteractionExist($postId, $userId)) {
                $res = $this->postsModel->setPostInteraction($postId, $userId, 'liked');
            }
            else {
                $res = $this->postsModel->addPostInteraction($postId, $userId, 'liked');
            }

            if($likes != false && $res != false) {
                echo $likes->likes;
            }
        }

        public function decPostsLikes($postId) {
            $likes =  $this->postsModel->decLikes($postId);

            $userId = $_SESSION['user_id'];

            $res = $this->postsModel->setPostInteraction($postId, $userId, 'like removed');

            if($likes != false && $res != false) {
                echo $likes->likes;
            }
        }

        // dislikes
        public function incPostsDislikes($postId) {
            $dislikes =  $this->postsModel->incDislikes($postId);

            $userId = $_SESSION['user_id'];

            if($this->postsModel->isPostInteractionExist($postId, $userId)) {
                $res = $this->postsModel->setPostInteraction($postId, $userId, 'disliked');
            }
            else {
                $res = $this->postsModel->addPostInteraction($postId, $userId, 'disliked');
            }

            if($dislikes != false && $res != false) {
                echo $dislikes->dislikes;
            }
        }

        public function decPostsDislikes($postId) {
            $dislikes =  $this->postsModel->decDislikes($postId);

            $userId = $_SESSION['user_id'];

            $res = $this->postsModel->setPostInteraction($postId, $userId, 'dislike removed');

            if($dislikes != false && $res != false) {
                echo $dislikes->dislikes;
            }
        }
    }
?>