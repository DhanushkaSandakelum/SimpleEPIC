<?php require APPROOT . '/views/inc/header.php'; ?>
    <!-- TOP NAVIGATION -->
    <?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

    

    <div class="form-contaier">
        <div class="form-header">
            <center><h1>User sign up</h1></center>
            <p><b>Please fill the form to register.</b></p>
        </div>
        <form action="<?php echo URLROOT?>/Users/register" method="POST" enctype="multipart/form-data">
            <!-- profile image -->
            <div class="form-drag-area">
                <div class="icon">
                    <img src="<?php echo URLROOT; ?>/img/components/imageUpload/placeholder-icon.png" alt="placeholder" width="90px" height="90px" id="profile_image_placeholder">
                </div>
                <div class="right-content">
                    <div class="description">Drag & Drop to Upload File</div>
                    <div class="form-upload">
                        <input type="file" name="profile_image" id="profile_image" style="display: none;">
                        Browse File
                    </div>
                </div>
            </div>
            <div class="form-validation">
                <div class="profile-image-validation">
                    <img src="<?php echo URLROOT; ?>/img/components/imageUpload/green-tick-icon.png" alt="green-tick" width="15px" height="15px">
                    Select a Profile picture
                </div>
            </div>
            <span class="form-invalid"><?php echo $data['profile_image_err']; ?></span>

            <!-- name -->
            <div class="form-input-title">Name</div>
            <input type="text" name="name" id="name" class="name" value="<?php echo $data['name']; ?>">
            <span class="form-invalid"><?php echo $data['name_err']; ?></span>

            <!-- email -->
            <div class="form-input-title">Email</div>
            <input type="text" name="email" id="email" class="email" value="<?php echo $data['email']; ?>">
            <span class="form-invalid"><?php echo $data['email_err']; ?></span>

            <!-- password -->
            <div class="form-input-title">Password</div>
            <input type="password" name="password" id="password" class="password" value="<?php echo $data['password']; ?>">
            <span class="form-invalid"><?php echo $data['password_err']; ?></span>

            <!-- confirm password -->
            <div class="form-input-title">Confirm password</div>
            <input type="password" name="confirm_password" id="confirm_password" class="confirm_password" value="<?php echo $data['confirm_password']; ?>">
            <span class="form-invalid"><?php echo $data['confirm_password_err']; ?></span>

            <br>
            <input type="submit" value="Register" class="form-btn">            
        </form>
    </div>

<!-- javascript for profile image -->
<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/components/imageUpload/imageUpload.js"></script>

<?php require APPROOT . '/views/inc/footer.php'; ?>