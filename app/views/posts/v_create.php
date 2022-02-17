<?php require APPROOT . '/views/inc/header.php'; ?>
    <!-- TOP NAVIGATION -->
    <?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>


    <div class="post-container">
        <center><h2>Create a post </h2></center>
        <form action="<?php echo URLROOT;?>/Posts/create" method="post" enctype="multipart/form-data">
            <div class="post-image">
                <img src="" alt="" id="image_placeholder" style="display: none;">
            </div>
            <br>
            <div class="upper">
                <div class="left">
                    <input type="text" name="title" id="title" placeholder="Title" value="<?php $data['title']; ?>">
                    <span class="form-invalid"><?php echo $data['title_err']; ?></span>                    
                    <span class="form-invalid"><?php echo $data['image_err']; ?></span>
                </div>
                <div class="right">
                    <img src="<?php echo URLROOT; ?>/img/components/posts/browse-image.png" alt="" id="addImagebtn" onclick="toggleBrowse()">
                    <img src="<?php echo URLROOT; ?>/img/components/posts/remove-image.png" alt="" id="removeImagebtn" style="display: none;" onclick="removeImage()">
                    <input type="file" name="image" id="image" style="display: none;">
                </div>
            </div>
            <textarea name="body" id="body" placeholder="Content" rows="10" cols="10" value="<?php $data['body']; ?>"></textarea>
            <span class="form-invalid"><?php echo $data['body_err']; ?></span>
            <br>
            <input type="submit" value="Post" class="post-btn">
        </form>
    </div>
  
<!-- javascript for posts -->
<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/components/posts/posts.js"></script>


<?php require APPROOT . '/views/inc/footer.php'; ?>