
var pollServer = function() {
    console.log('pollServer in');
    $.get('chat.php', function(result){
        console.log('chat.php get over');

        if(!result.success){
            console.log("Error polling server for new messages!");
            return;
        }
        
        console.log(result);
        $.each(result.messages, function(idx){
            var chatBubble;
            if(this.sent_by == 'self'){
                chatBubble = $('<div class="row bubble-sent pull-right">' 
                            + this.message + '</div><div class="clearfix"></div>');
            }else{
                chatBubble = $('<div class="row bubble-recv">' + this.message + '</div><div class="clearfix"></div>');
            }
            $('#chatPanel').append(chatBubble);
        });

        setTimeout(pollServer, 5000);
    });
};

$(document).ready(function(){
    pollServer();

    $('button').click(function(){
        $(this).toggleClass('active');
    });
});

$('#sendMsgBtn').on('click', function(event){
    event.preventDefault();
    
    var msg = $('#chatMsg').val();

    $.post('chat.php', {
        'message' : msg
    }, function(result){
        $('#sendMsgBtn').toggleClass('active');

        if(!result.success){
            alert('There was an error sending your message!');
        }else{
            console.log('Message sent!');
            $('#chatMsg').val('');
        }
    });
})


