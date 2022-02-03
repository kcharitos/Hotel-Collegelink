(function ($) {
	$(document).on('submit', 'form.favoriteForm', function(e){
		// Stop default form behaviour
		e.preventDefault();
		
		// Get form data
		const formData = $(this).serialize();
		
		// AJAX request
		$.ajax(
			'http://hotel.collegelink.localhost/public/ajax/room_favorite.php',
			{
				type: "POST",
				typeData: "json",
				data: formData
			}).done(function(result){
				console.log(result);
				if(result.user == ''){
					window.location.href='http://hotel.collegelink.localhost/public/index.php';
				}else{
					if(result.status){
						$('input[name=is_favorite]').val(result.is_favorite ? 1 : 0);
						$('i.fa-heart').addClass(result.is_favorite ? 'fas' : 'far');
						$('i.fa-heart').removeClass(result.is_favorite ? 'far' : 'fas');
					}else{
						$('input[name=is_favorite]').val(result.is_favorite ? 1 : 0);
						$('i.fa-heart').addClass(result.is_favorite ? 'far' : 'fas');
						$('i.fa-heart').removeClass(result.is_favorite ? 'fas' : 'far');
					}
				}
			});
	});
	
	$(document).on('submit', 'form.review-form', function(e){
		// Stop default form behaviour
		e.preventDefault();
		
		// Get form data
		const formData = $(this).serialize();
		
		// AJAX request
		$.ajax(
			'http://hotel.collegelink.localhost/public/ajax/room_review.php',
			{
				type: "POST",
				typeData: "html",
				data: formData
			}).done(function(result){
				if($('input[name=user_id]').val() == ''){
					window.location.href='http://hotel.collegelink.localhost/public/index.php';
				}

				$('div.no-reviews').html('');
				// Append review to list
				$('#room-review-container').append(result);
				
				// Reset review form
				$('form.review-form').trigger('reset');
				$('#rating i').parent().children('i.fa-star').each(function(e){
					$(this).removeClass('fas');
					$(this).addClass('far');
				  });
			});
	});
})(jQuery);