<?php require APPROOT . '/views/inc/header.php'; ?>
    <!-- TOP NAVIGATION -->
    <?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

    <h1>Posts edit</h1>

    <div class="post-container">
        <center><h2>Edit the post </h2></center>
        <form action="<?php echo URLROOT;?>/Posts/edit/<?php echo $data['post_id']; ?>" method="post" enctype="multipart/form-data">
            <div class="post-image">
                <?php if($data['image_name'] != null): ?>
                    <img src="<?php echo URLROOT;?>/img/postsImgs/<?php echo $data['image_name']; ?>" alt="" id="image_placeholder">
                <?php else:?>
                    <img src="" alt="" id="image_placeholder" style="display: none;">
                <?php endif; ?>
            </div>
            <br>
            <div class="upper">
                <div class="left">
                    <input type="text" name="title" id="title" placeholder="Title" value="<?php echo $data['title']; ?>">
                    <span class="form-invalid"><?php echo $data['title_err']; ?></span>              
                    <span class="form-invalid"><?php echo $data['image_err']; ?></span>
                </div>
                <div class="right">
                    <img src="<?php echo URLROOT; ?>/img/components/posts/browse-image.png" alt="" id="addImagebtn" onclick="toggleBrowse()">
                    <img src="<?php echo URLROOT; ?>/img/components/posts/remove-image.png" alt="" id="removeImagebtn" style="display: none;" onclick="removeImage()">
                    <input type="text" name="intentially_removed" id="intentially_removed" style="display: none;" readonly>
                    <input type="file" name="image" id="image" style="display: none;">
                </div>
            </div>
            <textarea name="body" id="body" placeholder="Content" rows="10" cols="10"><?php echo $data['body']; ?></textarea>
            <span class="form-invalid"><?php echo $data['body_err']; ?></span>
            <br>
            <input type="submit" value="Update" class="post-btn">
        </form>
    </div>

<!-- javascript for posts -->
<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/components/posts/posts.js"></script>   

<?php require APPROOT . '/views/inc/footer.php'; ?>