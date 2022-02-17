function addLike(postid) {
    if($('#post-likes-'+postid).hasClass('active')) {
        $('#post-likes-'+postid).removeClass('active');

        decPostsLikes(postid);
    }
    else {
        if($('#post-dislikes-'+postid).hasClass('active')) {
            $('#post-dislikes-'+postid).removeClass('active');

            decPostsDislikes(postid);
        }

        $('#post-likes-'+postid).addClass('active');

        incPostsLikes(postid);
    }
}

function addDislike(postid) {
    if($('#post-dislikes-'+postid).hasClass('active')) {
        $('#post-dislikes-'+postid).removeClass('active');

       decPostsDislikes(postid);
    }
    else {
        if($('#post-likes-'+postid).hasClass('active')) {
            $('#post-likes-'+postid).removeClass('active');

            decPostsLikes(postid);
        }

        $('#post-dislikes-'+postid).addClass('active');

        incPostsDislikes(postid);
    }
}

function incPostsLikes(postid) {
    $.ajax({
        url: URLROOT+'/Posts/incPostsLikes/'+postid,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(likes) {
            $("#posts-likes-count-"+postid).text(likes);
        }
    })
}

function decPostsLikes(postid) {
    $.ajax({
        url: URLROOT+'/Posts/decPostsLikes/'+postid,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(likes) {
            $("#posts-likes-count-"+postid).text(likes);
        }
    })
}

function incPostsDislikes(postid) {
    $.ajax({
        url: URLROOT+'/Posts/incPostsDislikes/'+postid,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(likes) {
            $("#posts-dislikes-count-"+postid).text(likes);
        }
    })
}

function decPostsDislikes(postid) {
    $.ajax({
        url: URLROOT+'/Posts/decPostsDislikes/'+postid,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(likes) {
            $("#posts-dislikes-count-"+postid).text(likes);
        }
    })
}