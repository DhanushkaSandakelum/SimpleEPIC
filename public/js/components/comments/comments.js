$(document).ready(function() {
    // adding a comment
    $('#post-footer-commentbtn').click(function(event) {
        event.preventDefault();

        // check whether comment input field is empty or not
        if(!($('#post-comment').val() == 0)) {
            $.ajax({
                url: URLROOT+"/Comments/comment/"+CURRENT_POST,
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(comment) {
                    // for testing purposes
                    $('#msg').text(comment);
                }
            })

            // Refresh the entire comment thread
            $.ajax({
                url: URLROOT+"/Comments/showComments/"+CURRENT_POST,
                dataType: "html",
                success: function(results) {
                    // for testing purposes
                    $('#results').html(results);
                }
            })

            $('#post-comment').val('');
        }
    })

    // onload show existing comments
    $.ajax({
        url: URLROOT+"/Comments/showComments/"+CURRENT_POST,
        dataType: "html",
        success: function(results) {
            // for testing purposes
            $('#results').html(results);
        }
    })
})

// delete function 
function deleteComment(commentid) {
    $.ajax({
        url: URLROOT+"/Comments/deleteComment/"+commentid,
        method: "post",
        data: $('form').serialize(),
        dataType: "text",
        success: function(respose) {
            location.reload();
        }
    })
}
