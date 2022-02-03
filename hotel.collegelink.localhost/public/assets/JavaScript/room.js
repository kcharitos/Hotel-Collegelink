$(document).ready(function(){
  
	$('#rating i').on('click', function(){
	var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
	document.getElementById("rate").value = onStar;

		// Now highlight all the stars that's not after the current hovered star
		$('#rating i').parent().children('i.fa-star').each(function(e){
		  if (e < onStar) {
			$(this).removeClass('far');
			$(this).addClass('fas');
		  }
		  else {
			$(this).removeClass('fas');
			$(this).addClass('far');
		  }
		});
	});

	
	$("#submit-button button").click(function(event){
	  if(document.getElementById("rate").value == ""){
		  event.preventDefault();
		  alert("Number of stars are required! Please complete this field to submit your review.");
	  }
	});
	
});