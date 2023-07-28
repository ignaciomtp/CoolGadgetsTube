<script>
		$(window).on('scroll', function(){

			stickyNavbar();

			stickyBox();

			let scrollPosition = $(window).scrollTop() + $(window).height();

			let pageSize = $('#prodsdiv').height();

			if(!reloaded && scrollPosition > pageSize) {
				reloaded = 1;
				//loadMore();
				loadMoreCategory(true);
			} 


		});
</script>