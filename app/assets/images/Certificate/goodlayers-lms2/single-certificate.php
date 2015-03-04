<?php get_header(); ?>
<div class="gdlr-lms-content">
	<div class="gdlr-lms-container gdlr-lms-container">
	<?php 
		while( have_posts() ){ the_post();
			the_content();
		}
	?>
	</div><!-- gdlr-lms-container -->
</div><!-- gdlr-lms-content -->
<?php get_footer(); ?>