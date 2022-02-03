(function ($) {
	$(document).on('submit', 'form.SearchForm', function(e){
		// Stop default form behaviour
		e.preventDefault();
		
		// Get form data
		const formData = $(this).serialize();
		
		// AJAX request
		$.ajax(
			'http://hotel.collegelink.localhost/public/ajax/search_results.php',
			{
				type: "GET",
				typeData: "html",
				data: formData
			}).done(function(result){
				// Clear results container
				$('#ListOfRooms').html('');
				
				// Append results to container
				$('#ListOfRooms').append(result);
				
				// Push url state
				history.pushState({}, '', 'http://hotel.collegelink.localhost/public/list.php?' + formData);
			});
	});
})(jQuery);