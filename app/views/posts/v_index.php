<?php require APPROOT . '/views/inc/header.php'; ?>
    <!-- TOP NAVIGATION -->
    <?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

    <?php flash('post_msg'); ?>

    <a href="<?php echo URLROOT?>/Posts/create"><button class="post-create-btn">CREATE POST</button></a>


    <?php foreach($data['posts'] as $post): ?>
    <div class="post-index-container">
        <div class="post-header">
            <div class="post-user-profileimage">
                <img src="<?php echo URLROOT;?>/img/profileImgs/<?php echo $post->profile_image;?>" alt="">    
            </div>
            <div class="post-user-name"><?php echo $post->user_name; ?></div>
            <div class="post-created-at"><?php echo convertTimeToReadableFormat($post->post_created_at); ?></div>
            <?php if($post->user_id == $_SESSION['user_id']): ?>
            <div class="post-control-btns">
                <a href="<?php echo URLROOT?>/Posts/edit/<?php echo $post->post_id ?>"><button class="post-control-btn1">EDIT</button></a>
                <a href="<?php echo URLROOT?>/Posts/delete/<?php echo $post->post_id ?>"><button class="post-control-btn2">DELETE</button></a>
            </div>
            <?php endif; ?>
        </div>
        <a href="<?php echo URLROOT;?>/Posts/show/<?php echo $post->post_id; ?>" class="post-body-link">
        <div class="post-body">
            <div class="post-image">
                <?php if($post->image != null): ?>
                    <img src="<?php echo URLROOT;?>/img/postsImgs/<?php echo $post->image;?>" alt="">
                <?php endif; ?>
            </div>
            <div class="post-title"><?php echo $post->title; ?></div>
            <div class="post-content"><?php echo $post->body; ?></div>
        </div>        
        </a>
        <div class="post-footer">
            <?php if($post->interaction == 'liked'): ?>
            <div class="post-likes active" id="post-likes-<?php echo $post->post_id; ?>" onclick="addLike(<?php echo $post->post_id; ?>)">
            <?php else: ?>
            <div class="post-likes" id="post-likes-<?php echo $post->post_id; ?>" onclick="addLike(<?php echo $post->post_id; ?>)">
            <?php endif; ?>
                <img src="<?php echo URLROOT;?>/img/components/posts/like-btn.png" alt="">
                <div class="posts-likes-count" id="posts-likes-count-<?php echo $post->post_id; ?>"><?php echo $post->likes; ?></div>
            </div>
            <?php if($post->interaction == 'disliked'): ?>
            <div class="post-dislikes active" id="post-dislikes-<?php echo $post->post_id; ?>" onclick="addDislike(<?php echo $post->post_id; ?>)">
            <?php else: ?>
            <div class="post-dislikes" id="post-dislikes-<?php echo $post->post_id; ?>" onclick="addDislike(<?php echo $post->post_id; ?>)">
            <?php endif; ?>
                <img src="<?php echo URLROOT;?>/img/components/posts/dislike-btn.png" alt="">
                <div class="posts-dislikes-count" id="posts-dislikes-count-<?php echo $post->post_id; ?>"><?php echo $post->dislikes; ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

<!-- jQuery -->
<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/jQuery/jQuery.js"></script> 

<script type="text/JavaScript">
    var URLROOT = '<?php echo URLROOT; ?>'
</script> 

<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/components/posts/postsInteractions.js"></script>   


<?php require APPROOT . '/views/inc/footer.php'; ?>