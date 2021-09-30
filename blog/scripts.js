//automatic comment refresh


$(document).ready(function(){
	// When user clicks on submit comment to add comment under post
	$(document).on('click', '#submit_comment', function(e) {
		e.preventDefault();
		var comment_text = $('#comment_text').val();
		var url = $('#comment_form').attr('action');
		// Stop executing if not value is entered
		if (comment_text === "" ) return;
		$.ajax({
			url: url,
			type: "POST",
			data: {
				comment_text: comment_text,
				comment_posted: 1
			},
			success: function(data){
				console.log(data);
				var response = JSON.parse(data);
				if (data === "error") {
					alert('There was an error adding comment. Please try again');
				} else {
					$('#comments-wrapper').prepend(response.comment)
					$('#comments_count').text(response.comments_count); 
					$('#comment_text').val('');
				}
			}
		});
	});

//rating system

resetStarColors();
function setStars(max){
	for (var i=0; i <= max; i++)
	$('.fa-star:eq('+i+')').css('color','green');
}
if (localStorage.getItem('ratedIndex' + window.location.href) != null){
	setStars(parseInt(localStorage.getItem('ratedIndex' + window.location.href)));
}	

$('.fa-star').on('click',function(){
	if(localStorage.getItem('alreadyVoted' + window.location.href) != '1'){
	ratedIndex = parseInt($(this).attr('data-index'));
	localStorage.setItem('ratedIndex' + window.location.href , ratedIndex);
	SavetoDB();
	}
});


$('.fa-star').mouseover(function(){

	resetStarColors();
	var currentIndex = parseInt($(this).attr('data-index'));
		setStars(currentIndex);
});

$('.fa-star').mouseleave(function (){

	resetStarColors();
	if(localStorage.getItem('ratedIndex' + window.location.href) != -1){
		console.log('ratedindex' + window.location.href);
		setStars(localStorage.getItem('ratedIndex' + window.location.href));
	}	
});


});


var ratedIndex = -1;


function resetStarColors(){
	$('.fa-star').css('color','black');
}	
function SavetoDB(){

	
		$.ajax
		({
			url: "single_post.php",
			method: "POST",
			dataType: "json",
			data: 
			{
				save: 1,
				ratedIndex: ratedIndex
			}, success: function(r){
		
			}
		});
			localStorage.setItem('alreadyVoted' + window.location.href, '1');
	
}	
	