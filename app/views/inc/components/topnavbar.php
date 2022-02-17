<div class="topnav">
  <div>
    <a class="active" href="#home">Home</a>
    <?php if(!isset($_SESSION['user_id'])): ?>
    <a href="<?php echo URLROOT?>/Users/login">Login</a>
    <a href="<?php echo URLROOT?>/Users/register">Register</a>
    <?php else: ?>
    <a href="<?php echo URLROOT?>/Users/logout">Log out</a>
    <?php endif; ?>
  </div>
  <!-- profile image -->
  <?php if(isset($_SESSION['user_id'])): ?>
  <div class="profile">
    <div class="pic">
      <img src="<?php echo URLROOT; ?>/img/profileImgs/<?php echo $_SESSION['user_profile_image']; ?>" alt="">
    </div>
    <div class="user-name">
        <?php echo $_SESSION['user_name']; ?>
    </div>
  </div>
  <?php endif; ?>
</div>