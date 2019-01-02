jQuery(document).ready(function(){
	jQuery("button.menu-image-upload").live("click", function(e){
		e.preventDefault();

		var Uploader = wp.media({
			'title' : 'Upload submenu image',
			'button' : {
				'text' : 'set the image'
			},
			'multiple' : false
		});

		Uploader.open();

		var button = jQuery(this);

		Uploader.on("select", function(){
			var image = Uploader.state().get("selection").first().toJSON();

			var link = image.url;

			button.next("input").val(link);
		})
	});
})