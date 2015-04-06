(function() {

	function extractVideoID(url){
	    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
	    var match = url.match(regExp);
	    if ( match && match[7].length == 11 ){
	        return match[7];
	    }else{
	        return null;
	    }
	}

	function appendVideo(el,id){
		$el.find('.placeholders .glyphicon').hide();
		$el.append('<iframe src="https://www.youtube.com/embed/' + 
			id + '" frameborder="0" allowfullscreen></iframe>');
	}

	$(window).load(function(){
		$('.youtube-wrapper input').each(function() {
			var elem = $(this);

			elem.data('oldVal', elem.val());
			if (elem.val() != '') {
				var id = extractVideoID(elem.val());
				if (id != null) {
					$el = $(this).parents('.youtube-wrapper').find('.preview-box');
					appendVideo($el,id);
				}
			};

			// Look for changes in the value
			elem.bind("propertychange change click keyup input paste", function(event){
				
				// If value has changed...
				if (elem.data('oldVal') != elem.val()) {
					$el = $(this).parents('.youtube-wrapper').find('.preview-box');

					$(this).parents('.youtube-wrapper').find('iframe').remove();
					$el.find('.placeholders .glyphicon').show();
					$el.find('.placeholders .error').hide();
					$(elem).removeClass('has-error');

					// Updated stored value
					elem.data('oldVal', elem.val());

					var id = extractVideoID(elem.val());

					if (id != null) {
						appendVideo($el,id);
					}
					else{
						if (elem.val() != '') {
							$el.find('.placeholders .idle').hide();
							$el.find('.placeholders .error').show();
							$(elem).addClass('has-error');
						};
					}

				}
			});
		});
	});

})();