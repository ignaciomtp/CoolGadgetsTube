	<script>

		var mylikes = [];

		var reloaded = 0;
		var reloadNumber = 1;

		var playPromise = null;

		function stickyNavbar() {
			let height = $(window).scrollTop();
			let width =  $(window).width();

			if(height >= 140) {
				$('.navbar').addClass('fixedbar');
				if(width >= 992){
					$('.navbar').addClass('fixedbarheight');
					$('#logosmall').css('display', 'inline-block');
					$('.nav-item').css('line-height', '42px');
				} 
			} else {
				$('.navbar').removeClass('fixedbar');
				$('.navbar').removeClass('fixedbarheight');
				$('#logosmall').css('display', 'none');
				$('.nav-item').css('line-height', '30px');
			}
		}

		function stickyBox() {
			let height = $(window).scrollTop();
			let width =  $(window).width();

			if(height >= 140 && width >= 768) {
				$('#blogsidebar').addClass('fixed-postbox');
				 
			} else {
				$('#blogsidebar').removeClass('fixed-postbox');
			}			
		}

		function loading(boo) {
			if(boo) {
				$('#loading').css('display', 'block');
			} else {
				$('#loading').css('display', 'none');
			}
		}

		function showVideoPost(id) {
			$('#vid-' + id).addClass('vid-container-v');
			$('#vid-' + id).css('display', 'block'); 
			$('#video' + id).css('display', 'block');
			
			/*playPromise = $('#video' + id).trigger('play'); */
			playPromise = document.getElementById('video' + id).play();
			$('#imgprod' + id).css('display', 'none');
			$('#playbtn' + id).css('display', 'none');
		}

		function showVideo(id) {
		/*	$('.vid-container').css('display', 'block');*/

			if(!playPromise) playPromise = $('#video' + id).get(0);

			loadVideoClass(id);
			$('#vid-' + id).css('display', 'block'); 
			$('#video' + id).css('display', 'block');
			


			if (playPromise.paused) {
			    playPromise.play();
			}

			$('#video' + id).get(0).play();

			//playPromise = document.getElementById('video' + id).play();
			$('#imgprod' + id).css('display', 'none');
			$('#playbtn' + id).css('display', 'none');
		}

		function hideVideo(id) {
			$('#vid-container' + id).css('display', 'none');
			$('#video' + id).css('display', 'none');

			if(playPromise) {
				if (Promise.resolve(playPromise) === playPromise) {
				  console.log("The object is a Promise");
				  playPromise.then(_ => {
				    if (!playPromise.paused) {
					    playPromise.pause();
					    playPromise = null;
					}
			      })
			      .catch(error => {
			      // Auto-play was prevented
			      // Show paused UI.
			    	console.log(error);
			      });

				/**********************/
				} else {
				  console.log("The object is not a Promise");
				}
			}

			$('#imgprod' + id).css('display', 'inline');
			$('#playbtn' + id).css('display', 'inline');			
		}

		function pauseVideo(id) {
			if (playPromise !== undefined) {
			    playPromise.then(_ => {
			      // Automatic playback started!
			      // Show playing UI.
			      // We can now safely pause video...
			     //$('#video' + id).trigger('pause');
				    if (!playPromise.paused) {
					    playPromise.pause();
					}
			    })
			    .catch(error => {
			      // Auto-play was prevented
			      // Show paused UI.
			    	console.log(error);
			    });
			} 
		}

		function pauseVideo2(id) {
			var video = $('#video' + id).get(0);
			
			if (!video.paused) {
			    video.pause();
			}
		}

		function loadVideoClass(id) {
			let video = $('#video' + id).get(0);
			console.log('Loadvideo');
			if(video) {
				console.log({video});
				video.addEventListener( "loadedmetadata", function (e) {
				    let width = this.videoWidth,
				        height = this.videoHeight;

				        if(width > height) {
				        	$('#vid-' + id).addClass('vid-container-h');
				        } else {
				        	$('#vid-' + id).addClass('vid-container-v');
				        }
				}, false );
			}
		}

		function loadVideoBig(id) {
			console.log('load Video Big');

			hideVideo(id);

			//if(!playPromise) playPromise = $('#big-video').get(0);

			$('#clip').css('display', 'flex');

			let bigVid = $('#big-video').get(0);

			bigVid.src = $('#video' + id).get(0).src;

			bigVid.load();

			bigVid.play();

			//showVideo(id);
		}


		function closeVideoBig() {
			$('#clip').css('display', 'none');
		}

		function likeProduct(event, id) {
			event.stopPropagation();

			if(!mylikes.includes(id)) {
				
				let url = window.location.origin + '/likeproduct/' + id;

				$.ajax({
		            url: url,
		            type : 'GET',
		            success: function(result){
		            	$('#likes-' + id).html(result);
		            	mylikes.push(id);
		            	localStorage.setItem('myLikes', JSON.stringify(mylikes));
		            	setMyCookie();
		            },
		        });				
			}

			
			deactivateLike(id);

		}

		function activateTooltips() {
			const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
			const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
		}

		
		function deactivateLike(id) {
			$('#likes-' + id).removeClass('fav-btn');
			$('#likes-' + id).addClass('fav-btn-liked');
			$('#likes-' + id).tooltip('disable');
		}


		function setMyCookie() {
		  	const d = new Date();
		  	d.setTime(d.getTime() + (3600 * 1000 * 24 * 365));
		  	let expires = "expires="+ d.toUTCString();
		  	document.cookie = 'mylikes' + "=" + JSON.stringify(mylikes) + ";" + expires + ";path=/";
		}

		function getMyCookie() {
			let name = "mylikes=";
			let decodedCookie = decodeURIComponent(document.cookie);
			let ca = decodedCookie.split(';');
			for(let i = 0; i <ca.length; i++) {
			  let c = ca[i];
			  while (c.charAt(0) == ' ') {
			    c = c.substring(1);
			  }
			  if (c.indexOf(name) == 0) {
			    return c.substring(name.length, c.length);
			  }
			}
			return "";
		}

		function resetReloaded() {
			reloaded = 0;
		}

		function loadMore() {
			loading(true);
			reloaded = 1;
			reloadNumber++;
			console.log('Load more');
			let url = window.location.origin + '/loadmore/' + reloadNumber;

			$.ajax({
	            url: url,
	            type : 'GET',
	            success: function(result){
	            	$('#prodsdiv').append(result);
	            	mylikes.forEach(elem => deactivateLike(elem));
	            	loading(false);
	            	setTimeout(resetReloaded, 500);
	            	$('#backTop').css('display', 'block');
	            	activateTooltips();
	            },
	        });		

		}

		function loadMoreCategory(initial = false) {
			
			let numItems = initial ? 0 : $('.card').length;

			let slug = $('#category').val();

			console.log('Load more category ', slug);
			let url = window.location.origin + '/categoryloadmore/' + slug + '/' + numItems;

			if(numItems >= 10 || slug == 'popular') {
				loading(true);
				$.ajax({
		            url: url,
		            type : 'GET',
		            success: function(result){
		            	if(result.length) {
		            		$('#prodsdiv').append(result);
		            		mylikes.forEach(elem => deactivateLike(elem));
		            		loading(false);
		            		if(!initial) setTimeout(resetReloaded, 500);
		            		$('#backTop').css('display', 'block');
		            		activateTooltips();
		            	} else {
		            		$('#divref').css('display', 'none');
		            		$('#noMore').css('display', 'block');
		            		loading(false);
		            	}	            	
		            	
		            },
		        });		
			} else {
				$('#divref').css('display', 'none');
		        $('#noMore').css('display', 'block');
			}

		}

		function loadMorePost(initial = false) {
			let numItems = initial ? 0 : $('.post-prod-title').length;
			let slug = $('#posttagsslugs').val();

			let url = window.location.origin + '/postloadmore/' + slug + '/' + numItems;

			loading(true);
			$.ajax({
	            url: url,
	            type : 'GET',
	            success: function(result){
	            	if(result.length) {
	            		$('#items-div').append(result);
	            		
	            		loading(false);
	            		if(!initial) setTimeout(resetReloaded, 500);
	            		$('#backTop').css('display', 'block');
	            		activateTooltips();
	            	} else {
	            		
	            		$('#noMore').css('display', 'block');
	            		loading(false);
	            	}	            	
	            	
	            },
	        });		

		}



		function loadMoreTag() {
			
			let numItems = $('.card').length;

			let slug = $('#tag').val();

			console.log('Load more tag');
			let url = window.location.origin + '/tagloadmore/' + slug + '/' + numItems;

			if(numItems >= 10) {
				loading(true);
				$.ajax({
		            url: url,
		            type : 'GET',
		            success: function(result){
		            	if(result.length) {
		            		$('#prodsdiv').append(result);
		            		loading(false); 
		            		mylikes.forEach(elem => deactivateLike(elem));
		            		setTimeout(resetReloaded, 500);
		            		$('#backTop').css('display', 'block');
		            		activateTooltips();
		            	} else {
		            		$('#divref').css('display', 'none');
		            		$('#noMore').css('display', 'block');
		            		loading(false); 
		            	}	   
		            	
		            },
		        });		
			} else {
				$('#divref').css('display', 'none');
		        $('#noMore').css('display', 'block');
			}

		}


		function loadMoreSearch() {
			
			let numItems = $('.card').length;

			let term = $('#searchTerm').val();
			
			let url = window.location.origin + '/searching/' + term + '/' + numItems;

			loading(true);
			$.ajax({
	            url: url,
	            type : 'GET',
	            success: function(result){
	            	let res = JSON.parse(result);
            		if(res.html.length) {
            			$('#prodsdiv').append(res.html);
            			$('#numberresults').html(res.total);
	            		mylikes.forEach(elem => deactivateLike(elem));
	            		loading(false);
	            		setTimeout(resetReloaded, 500);
	            		$('#backTop').css('display', 'block');
	            		activateTooltips();
	            	} else {
	            		$('#divref').css('display', 'none');
	            		$('#noMore').css('display', 'block');
	            		loading(false);
	            	}	            	
	            	
	            },
	        });		

	        

		}


		function pagesize() {
			let res = 0;

			let box = document.getElementById('divref');
			
			if (typeof box === 'object' && box !== null && 'getBoundingClientRect' in box) {
			  const result = box.getBoundingClientRect();

			  res = result.top;
			}

			return res;
			
		}


		$( document ).ready(function() {

			activateTooltips();
			
		    savedLikes = localStorage.getItem('myLikes');

		    if(savedLikes && savedLikes.length) {
		    	mylikes = JSON.parse(savedLikes);
		    	
		    } else {
		    	let cookieLikes = getMyCookie();
		    	if(cookieLikes && cookieLikes.length) {		    		
		    		mylikes = JSON.parse(cookieLikes);
		    		localStorage.setItem('myLikes', cookieLikes);
		    	}
		    }

		    mylikes.forEach(elem => deactivateLike(elem));
		    
		});



	</script>