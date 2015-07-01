/*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
/* 
    Created on : Jun 29, 2015, 1:52:03 PM
    Author     : Yury Martynov <linxon>
*/

$(document).ready(function() {

    $('.com-tree-control-btl').click(function() {
        $('.toggle').toggle(0);
    });

    $('#com-reply-post').click(function(name) {
        name.preventDefault();
        $('#com-enter-reply-form').slideDown(250);
    });

    $('#btn-enter-post').click(function(none) {
        
        none.preventDefault();
        
        var $postMsg = $('#com-enetr-reply-message').val();
        
        $.ajax({
            type: 'POST',
            url: 'xajax.php',
            cache: false,
            data: {
                'request': 'add_comment',
                'send_post_msg': $postMsg
            },
            success: function(data, textStatus, jqXHR) {
                $('.comment-options').append(data);
                $('#com-enter-reply-form').hide(0);
                $('#com-enetr-reply-message').val('');
            },
            error: function() {
                console.log('Error');
            }
        });
    });

});