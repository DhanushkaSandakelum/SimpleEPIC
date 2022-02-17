<?php
    class Users extends Controller {
        public function __construct() {
            $this->userModel = $this->model('M_Users');
        }

        public function register() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Form is submitting
                // Validate the data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Input data
                $data = [
                    'profile_image' => $_FILES['profile_image'],
                    'profile_image_name' => time().'_'.$_FILES['profile_image']['name'],
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),

                    'profile_image_err' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validate each inputs
                // validate profile image and upload
                if(uploadImage($data['profile_image']['tmp_name'], $data['profile_image_name'], '/img/profileImgs/')) {
                    // done
                }
                else {
                    $data['profile_image_err'] = 'Profile picture uploading unsuccessful';
                }

                // Validate name
                if(empty($data['name'])) {
                    $data['name_err'] = 'Please enter a name';
                }

                // Validate email
                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter a email';
                }
                else {
                    // Check email is already registered or not
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_err'] = 'Email is already registered';
                    }
                }

                // Validate password
                if(empty($data['password'])) {
                    $data['password_err'] = 'Please enter a password';
                }
                else if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm the password';
                }
                else {
                    if($data['password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Passwords are not matching';
                    }
                }

                // Validation is completed and no error then register the user
                if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['profile_image_err'])) {
                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register user
                    if($this->userModel->register($data)) {
                        // create a flash message
                        flash('reg_flash', 'You are succusefully registered!');

                        redirect('Users/login');
                    }
                    else {
                        die('Something went wrong');
                    }
                }
                else {
                    // Load view
                    $this->view('users/v_register', $data);
                }

            }
            else {
                // Initial form
                $data = [
                    'profile_image' => '',
                    'profile_image_name' => '',
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',

                    'profile_image_err' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Load view
                $this->view('users/v_register', $data);
            }
        }

        public function login() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Form is dubmitting
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),

                    'email_err' => '',
                    'password_err' => ''
                ];

                // validate the email
                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter the email';
                }
                else {
                    if($this->userModel->findUserByEmail($data['email'])) {
                        // User is found
                    }
                    else {
                        // User is not found
                        $data['email_err'] = 'User not found';
                    }
                }

                // Validate the password
                if(empty($data['password'])) {
                    $data['password_err'] = 'Please enter the password';
                }

                // If no error found the login the user
                if(empty($data['email_err']) && empty($data['password_err'])) {
                    // log the user
                    $loggedUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedUser) {
                        // User the authenticated
                        // Create user sessions

                        $this->createUserSession($loggedUser);

                        redirect('Posts/index');
                    }
                    else {
                        $data['password_err'] = 'Password incorrect';

                        // Load view with errors
                        $this->view('users/v_login', $data);
                    }
                }
                else {
                    // Load view with errors
                    $this->view('users/v_login', $data);
                }
            }
            else {
                // Initial form

                $data = [
                    'email' => '',
                    'password' => '',

                    'email_err' => '',
                    'password_err' => ''
                ];

                // Load view
                $this->view('users/v_login', $data);
            }
        }

        public function createUserSession($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_profile_image'] = $user->profile_image;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;

            redirect('Pages/index/'.$_SESSION['user_id']);
        }

        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_profile_image']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();

            redirect('Users/login');
        }

        public function isLoggedIn() {
            if(isset($_SESSION['user_id'])) {
                return true;
            }
            else {
                return false;
            }
        }
    }
?>