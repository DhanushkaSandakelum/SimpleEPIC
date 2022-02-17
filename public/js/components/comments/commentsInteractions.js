// COMMENT INTERACTIONS
// Likes 
function addCommentLike(commentId) {
    if($('#comment-likes-'+commentId).hasClass('active')) {
        $('#comment-likes-'+commentId).removeClass('active');

        decCommentsLikes(commentId);
    }
    else {
        if($('#comment-dislikes-'+commentId).hasClass('active')) {
            $('#comment-dislikes-'+commentId).removeClass('active');

            decCommentsDislikes(commentId);
        }

        $('#comment-likes-'+commentId).addClass('active');

        incCommentsLikes(commentId);
    }
}

function addCommentDislike(commentId) {
    if($('#comment-dislikes-'+commentId).hasClass('active')) {
        $('#comment-dislikes-'+commentId).removeClass('active');

        decCommentsDislikes(commentId);
    }
    else {
        if($('#comment-likes-'+commentId).hasClass('active')) {
            $('#comment-likes-'+commentId).removeClass('active');

            decCommentsLikes(commentId);
        }

        $('#comment-dislikes-'+commentId).addClass('active');

        incCommentsDislikes(commentId);
    }
}

function incCommentsLikes(commentId) {
    $.ajax({
        url: URLROOT+'/Comments/incCommentsLikes/'+commentId,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(likes) {
            $("#comment-likes-count-"+commentId).text(likes);
        }
    })
}

function decCommentsLikes(commentId) {
    $.ajax({
        url: URLROOT+'/Comments/decCommentsLikes/'+commentId,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(likes) {
            $("#comment-likes-count-"+commentId).text(likes);
        }
    })
}

function incCommentsDislikes(commentId) {
    $.ajax({
        url: URLROOT+'/Comments/incCommentsDislikes/'+commentId,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(likes) {
            $("#comment-dislikes-count-"+commentId).text(likes);
        }
    })
}

function decCommentsDislikes(commentId) {
    $.ajax({
        url: URLROOT+'/Comments/decCommentsDislikes/'+commentId,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(likes) {
            $("#comment-dislikes-count-"+commentId).text(likes);
        }
    })
}