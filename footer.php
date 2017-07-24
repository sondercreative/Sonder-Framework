


			
		  <footer class="page-footer">
		    <div class="container">

		    	<div class="row">

		    		<div class="col s12 m12 l9 footerMenus">
		    			<div class="row">
				    		<div class="col s12 m5 l4 footerAddress">
				        		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-1')) ?>
				        	</div>

					        <div class="col s12 m3 l3 footerMenu">
					          <?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-2')) ?>
					        </div>
					        <div class="col s12 m3 l3 footerMenu">
				        		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-3')) ?>
				        	</div>
				        	<div class="col s12 m12 l2 footerSocial hide-on-med-and-down">
				        		<?php echo do_shortcode('[social]'); ?>
				        	</div>
				        </div>
				    </div>

		        	<div class="col s12 m6 l3 footerCopy">
		        		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-4')) ?>
		        	</div>

		        	<div class="col s12 m6 l2 footerSocial right-align hide-on-large-only">
				        <?php echo do_shortcode('[social]'); ?>
				    </div>
		        </div>


		    </div>
		  </footer>






		<?php wp_footer(); ?>

		<script>
		    jQuery.each(window.deferAfterjQueryLoaded, function(index, fn) {
		        fn();
		    });
		</script>

	</body>
</html>
