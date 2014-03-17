This original script from cevenson (https://github.com/cevenson/isotope-nextgen-gallery-template/) has been modified:

See demo at: http://dnnsldr.com/dev/diamondtats/gallery

Additional jQuery has been set so that an active class on the filter links can be set. Modified so that the list of 
filtered image tags is not hard-coded, but instead showing all the image tags while removing those that have no 
images attached to them so new tags can be added to the list automatically.

Also using jquery cookie to set a cookie so that you can set a cookie for the data-filter that can be used on other 
pages go to that filtered category. jQuery cookie is not necessary. If you are not going to use it, comment out 
necessary jQuery on the gallery-isotope.php file.

Create a folder called nggallery in your Wordpress theme's root folder
Place the file gallery-isotope.php in the nggallery folder

Create a folder called js in your theme's root folder (if it doesn't already exist)
Place jquery.isotope.min.js inside the js folder. Reference this file

Call the template in your post or page with the shortcode [nggallery id=XX template=isotope] where XX is the 
gallery ID Number

##To Use the jQuery Cookie plugin (https://github.com/carhartl/jquery-cookie)

To have a cookie set of a link clicked elsewhere that will be used on the gallery-isotope.php file that will open the 
gallery and fiter by the set tag, download and reference jquery cookie and then add this script to your page
(header, homepage, or any other page that you will be setting the link):

<script type="text/javascript">
		//set the variables to blank
		var selector = '';
		var artistSelector = '';
		jQuery(document).ready(function($){
				//click on an anchor link that is going to the gallery that 
				//you want to filter by
				jQuery('.artistGalleryFilter').click(function(){
				     //set the cookie with the data filter
				     $.cookie.raw = true;
			 	     $.cookie('selector', $(this).attr('data-filter') );
		    });
		//thats all folks
		});
</script>

And then create a link like this:
<a class="artistGalleryFilter" href="<?php echo get_bloginfo('url');?>/gallery" data-filter=".<?=$post->post_name?>">
View Gallery</a>

Replace <?=$post->post_name?> with whatever filter tag you want to go to. Don't forget to include the period at 
the beginning.

