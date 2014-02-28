<?php 
/**
Template Page for the gallery overview

Follow variables are useable :

	$gallery     : Contain all about the gallery
	$images      : Contain all images, path, title
	$pagination  : Contain the pagination content

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>

<style type="text/css">
/**** center and put at bottom ****/
.ngg-navigation{position: absolute;bottom: 3px;left: 20%;right: 20%;}
#isotopegallery{padding-bottom: 40px;}
/**** Isotope Filtering ****/
.isotope-item {z-index: 2;}
.isotope-hidden.isotope-item {pointer-events: none;z-index: 1;}
/**** Isotope CSS3 transitions ****/
.isotope,
.isotope .isotope-item {
  -webkit-transition-duration: 0.8s;
     -moz-transition-duration: 0.8s;
      -ms-transition-duration: 0.8s;
       -o-transition-duration: 0.8s;
          transition-duration: 0.8s;
}
.isotope {
  -webkit-transition-property: height, width;
     -moz-transition-property: height, width;
      -ms-transition-property: height, width;
       -o-transition-property: height, width;
          transition-property: height, width;
}
.isotope .isotope-item {
  -webkit-transition-property: -webkit-transform, opacity;
     -moz-transition-property:    -moz-transform, opacity;
      -ms-transition-property:     -ms-transform, opacity;
       -o-transition-property:         top, left, opacity;
          transition-property:         transform, opacity;
}
/**** disabling Isotope CSS3 transitions ****/
.isotope.no-transition,
.isotope.no-transition .isotope-item,
.isotope .isotope-item.no-transition {
  -webkit-transition-duration: 0s;
     -moz-transition-duration: 0s;
      -ms-transition-duration: 0s;
       -o-transition-duration: 0s;
          transition-duration: 0s;
}
.photo {float:left;margin:10px;}
.filters {margin: 0 0 20px 0}
.filters li{ float:left;list-style-type: none;margin:5px;}
.filters li a {font-size: 14px;background: #414141;padding: 3px 12px;color: #999;display: inline-block;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;}
.filters li a.active {color: #7aaeae;background: #000;}
</style>

<script type="text/javascript">
	jQuery(document).ready(function($){
		
		//sets the cookie. remove if not using jquery cookie
		var artistSelector = $.cookie("selector");
		
		//checks to see if our cookie matches the gallery picked
		//adds an active class. this is used when seeking a gallery
		//from another page. remove if not using jquery cookie
		$('.filters a').each(function(i){
        	var filter = $(this).attr('data-filter');
        	if (filter == artistSelector) {
                $(this).addClass('active');
            }
    	});	
    	
    	//sets the isotope container...you need this	
		var $container = $('#isotopegallery');
      	
      	//sets the div of the photos...you need this
		$container.isotope({
			itemSelector: '.photo'
		});
		
		//starts the filtering isotope base on the cookie. remove if not using jquery cookie
  		$container.isotope({ 
  			filter: artistSelector
  		});
  		
  		//change the filtering and add an active class. this happens on page...you need this
  		//also sets an active class on the filter tag
		$('.filters a').click(function(){
			var artistSelector = '';
  			var artistSelector = $(this).attr('data-filter');
  			$('.filters a.active').removeClass('active');
  			$(this).addClass('active');
  			$container.isotope({ 
  				filter: artistSelector 
  			});
  			return false;
		});
	//thats all folks
    });
</script>

<h3 class="filterTitle span1">Filter:</h3>
<ul class="filters span10" class="clearfix">
  	<li><a href="#" data-filter="*">show all</a></li>
  	<?php  
  	//lets get all the nextgen gallery image tags. we only want the ones that have images
  	//this will create a nice button style list of each tag that we can filter by
  	$filtertags = get_terms('ngg_tag');
    foreach ( $filtertags as $filtertag ) : ?> 
  	<li><a href="#" data-filter=".<?php echo $filtertag->slug; ?>"><?php echo $filtertag->name; ?></a></li>
  	<?php endforeach; ?>
</ul>

<div class="clearfix"></div>

<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($gallery)) : ?>
 
<div id="isotopegallery" class="photos clearfix" id="<?php echo $gallery->anchor ?>">
 
        <?php
                //Used to break down and extract the width and height of each image
                function get_string_between($string, $start, $end){
                        $string = " ".$string;
                        $ini = strpos($string,$start);
                        if ($ini == 0) return "";
                        $ini += strlen($start);
                        $len = strpos($string,$end,$ini) - $ini;
                        return substr($string,$ini,$len);
                }
        ?>
 
        <!-- Thumbnails -->
        <?php foreach ( $images as $image ) : ?>
               
               
                <?php if ( !$image->hidden ) {
                        //GET the Size parameters for each image. this i used to size the div box that the images goes inside of.
                        $the_size_string = $image->size;
                        $thewidth = get_string_between($the_size_string, "width=\"", "\"");
                        $theheight = get_string_between($the_size_string, "height=\"", "\"");
                        $divstyle = 'width:'.$thewidth.'px; height:'.$theheight.'px;'; 
                }?>
               
 
                        <?php
                                //Get the TAGS for this image  
                                $tags = wp_get_object_terms($image->pid,'ngg_tag');
                                $tag_string = ''; //store the list of strings to be put into the class menu for isotpe filtering       
                                ?>
                                <?php foreach ( $tags as $tag ) : ?>     
                                  <?php $tag_string = $tag_string.$tag->slug.' ';  //alternativley can use $tag->name;, slug with put hyphen between words ?>      
                                <?php endforeach; ?>   
                                               
                <div class="photo <?php echo $tag_string ?>" style="<?php echo $divstyle; ?>">
                        <a href="<?php echo $image->imageURL ?>" title="<?php echo $image->description ?>" <?php echo $image->thumbcode ?> >
                                <?php if ( !$image->hidden ) { ?>
                                <img title="<?php echo $image->alttext ?>" alt="<?php echo $image->alttext ?>" src="<?php echo $image->thumbnailURL ?>" />
                                <?php } ?>
                        </a>
                </div> 
       
       
                <?php if ( $image->hidden ) continue; ?>
                <?php if ( $gallery->columns > 0 && ++$i % $gallery->columns == 0 ) { ?>
                        <br style="clear: both" />
                        
                <?php } ?>
 
        <?php endforeach; ?>
       
        <!-- Pagination -->
        <?php echo $pagination ?>
       
</div>
 
<?php endif; ?>
