<?php require APPROOT . '/views/inc/header.php'; ?>
    <!-- TOP NAVIGATION -->
    <?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

    <?php flash('post_msg'); ?>

    <a href="<?php echo URLROOT?>/Posts/create"><button class="post-create-btn">SHOW POST</button></a>

    <br><br>
    <a href="<?php echo URLROOT?>/Posts/index"><button class="post-create-btn">Back</button></a>


    <div class="post-index-container show">
        <div class="post-header">
            <div class="post-user-profileimage">
                <img src="<?php echo URLROOT;?>/img/profileImgs/<?php echo $data['post']->profile_image;?>" alt="">    
            </div>
            <div class="post-user-name"><?php echo $data['post']->user_name; ?></div>
            <div class="post-created-at"><?php echo convertTimeToReadableFormat($data['post']->post_created_at); ?></div>
            <?php if($data['post']->user_id == $_SESSION['user_id']): ?>
            <div class="post-control-btns">
                <a href="<?php echo URLROOT?>/Posts/edit/<?php echo $data['post']->post_id ?>"><button class="post-control-btn1">EDIT</button></a>
                <a href="<?php echo URLROOT?>/Posts/delete/<?php echo $data['post']->post_id ?>"><button class="post-control-btn2">DELETE</button></a>
            </div>
            <?php endif; ?>
        </div>
        <div class="post-body">
            <div class="post-image show">
                <?php if($data['post']->image != null): ?>
                    <img src="<?php echo URLROOT;?>/img/postsImgs/<?php echo $data['post']->image;?>" alt="">
                <?php endif; ?>
            </div>
            <div class="post-title"><?php echo $data['post']->title; ?></div>
            <div class="post-content"><?php echo $data['post']->body; ?></div>
        </div>
        <form method="post">
        <div class="post-footer">
            <?php if($data['post']->interaction == 'liked'): ?>
            <div class="post-likes active" id="post-likes-<?php echo $data['post']->post_id; ?>" onclick="addLike(<?php echo $data['post']->post_id; ?>)">
            <?php else: ?>
            <div class="post-likes" id="post-likes-<?php echo $data['post']->post_id; ?>" onclick="addLike(<?php echo $data['post']->post_id; ?>)">
            <?php endif; ?>
                <img src="<?php echo URLROOT;?>/img/components/posts/like-btn.png" alt="">
                <div class="posts-likes-count" id="posts-likes-count-<?php echo $data['post']->post_id; ?>"><?php echo $data['post']->likes; ?></div>
            </div>
            <?php if($data['post']->interaction == 'disliked'): ?>
            <div class="post-dislikes active" id="post-dislikes-<?php echo $data['post']->post_id; ?>" onclick="addDislike(<?php echo $data['post']->post_id; ?>)">
            <?php else: ?>
            <div class="post-dislikes" id="post-dislikes-<?php echo $data['post']->post_id; ?>" onclick="addDislike(<?php echo $data['post']->post_id; ?>)">
            <?php endif; ?>
                <img src="<?php echo URLROOT;?>/img/components/posts/dislike-btn.png" alt="">
                <div class="posts-dislikes-count" id="posts-dislikes-count-<?php echo $data['post']->post_id; ?>"><?php echo $data['post']->dislikes; ?></div>
            </div>
            <!-- comment input field -->
            <input type="text" name="post-comment" id="post-comment" placeholder="Add a comment...">
            <div class="post-footer-commentbtn" id="post-footer-commentbtn"><img src="<?php echo URLROOT;?>/img/components/posts/comment-btn.png" alt="">    </div>
        </div>
        </form>
    </div>

    <!-- comment section -->
    <div class="comment-section-container">
        <div class="comment-section-header">
            <h1>Comments</h1>
        </div>
        <?php flash('comment_msg'); ?>
        <!-- testing purposes only -->
        <!-- <div id="msg"></div> -->

        <!-- comment thread -->
        <div id="results"></div>        
    </div>

<!-- jQuery -->
<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/jQuery/jQuery.js"></script> 

<script type="text/JavaScript">
    var URLROOT = '<?php echo URLROOT; ?>'
    var CURRENT_POST = '<?php echo $data['post']->post_id; ?>';
</script> 

<!-- Post interactions -->
<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/components/posts/postsInteractions.js"></script>   

<!-- Comments -->
<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/components/comments/comments.js"></script>   
<!-- Cpmments interactions -->
<script type="text/JavaScript" src="<?php echo URLROOT; ?>/js/components/comments/commentsInteractions.js"></script>   


<?php require APPROOT . '/views/inc/footer.php'; ?>