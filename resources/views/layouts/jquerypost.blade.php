<script>
		$(window).on('scroll', function(){

			stickyNavbar();

			stickyBox();

			let scrollPosition = $(window).scrollTop() + $(window).height();

			let pageSize = $('#blogtext').height();

			let postTags = $('#posttagsslugs').val();

			if(postTags && !reloaded && scrollPosition > pageSize) {
				reloaded = 1;

				loadMorePost();
			} 


		});
</script>