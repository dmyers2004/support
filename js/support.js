$(function(){

	$('.alert').prepend('<a href="#" class="close">x</a>');

	// Close the notifications when the close link is clicked
	$('a.close').live('click', function(e){
		e.preventDefault();
		$(this).fadeTo(200, 0); // This is a hack so that the close link fades out in IE
		$(this).parent().fadeTo(200, 0);
		$(this).parent().slideUp(400, function(){
			$(window).trigger('notification-closed');
			$(this).remove();
		});
	});

	$('.ticket-list').on('click', 'a[data-id]', function(e){
		e.preventDefault();
		$.post(SITE_URL+'/support/details', { id : $(this).attr('data-id') }, function(result){
			var result = $.parseJSON(result);
			if (result.status) {
				$('.name span').html(result.data.name);
				$('.title span').html(result.data.title);
				$('.created span').html(result.data.created);
				$('.status span').html(result.data.status);
				$('.description span').html(result.data.description);
				$('.details-buttons a').attr('data-id', result.data.id);

				var width = $('.ticket-list').width();
				var parent = $('.ticket-list').offset();
				$('.details-display').css( { 'position': 'fixed', 
											 'z-index': 1000, 
											 'top': 100, 
											 'left': parent.left,
											 'width': width,
											 'height': 'auto' } )
									.fadeIn('fast');
			} else {
				$('.message').html(result.data.message);
			}
		});
	});

	$('a.btn').click(function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		var status = $(this).attr('data-status');

		$.post(SITE_URL+'/support/status', { id : id, status : status }, function(result){
			var result = $.parseJSON(result);
			if (result.status) {
				$('html').trigger('click');
				$('td.'+id).html(status);
				$('td.'+id).removeClass().addClass(id+' '+status.replace(' ', '-'));
			}
		});
	});

	$('html').click(function(e){
		if ($('.details-display').find(e.target).length == 0) {
			$('.details-display span').empty();
			$('.details-display').hide();
		}
	});

	get_last = function() {
		var id = $('.ticket-list tr').find('a:first').attr('data-id');

		$.post(SITE_URL+'/support/get_last', { id : id }, function(data){
			var result = $.parseJSON(data);

			if (result.status) {
				$.each(result.data.tickets, function(index, value){
					if (result.data.admin){
						var title = '<td><a data-id="'+value.id+'" class="details" href="'+SITE_URL+'/support/#">'+value.title+'</a></td>';
					} else {
						var title = '<td>'+value.title+'</td>';
					}

					$('.ticket-list table tr:eq(0)').after('<tr>'+
																'<td>'+value.number+'</td>'+
																'<td>'+value.name+'</td>'+
																title+
																'<td class="'+value.id+' '+value.status+'">'+value.status+'</td>'+
															'</tr>');
				});
			}
		});
	}

	if ($('td.in-progress').length > 0){
		$('td.in-progress').html($('td.in-progress').html().replace('-', ' '));
	}

	window.setInterval(function(){
		get_last();
	// set the poll rate for new tickets -- 2 minutes
	}, 120000);
});