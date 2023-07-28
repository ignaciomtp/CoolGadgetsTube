<div id="barraaceptacion" style="display: block;">
    <div class="inner">
        This website uses cookies to improve your experience. We'll assume you're ok with this, but you can opt-out <a href="#" >if you wish </a> 
        <a href="javascript:void(0);" class="btn btn-danger ml-2" onclick="PonerCookie();"><b>OK</b></a> 
		

    </div>
</div>

<div id="backTop" onclick="window.scrollTo(0, 0)"></div>

<footer class="footer mt-0 py-3 ">
	<div class="container row centrado">
		<div class="col-md-6 pb-3">
			<span class="legal">
				<a href="{{ route('terms') }}">Terms and Conditions</a> 
			</span>
			<br>
			<span class="legal">
				<a href="{{ route('contact') }}">Contact</a>
			</span>
			<br>

		</div>
		<div class="col-md-6 ml-auto ">
			<P class="text-muted">CoolGadgetsTube is a participant in the Amazon Services LLC Associates Program, an affiliate advertising program designed to provide a means for sites to earn advertising fees by advertising and linking to Amazon.com.

			</P>
			
			
			
		</div>
		
	</div>

	<div class="container row centrado">
		<div class="col-md-6 pb-3">
			<div >
				<i class="fab fa-amazon fa-2x"></i>
				<i class="fab fa-cc-visa fa-2x"></i>
				<i class="fab fa-cc-mastercard fa-2x"></i>
				<i class="fab fa-cc-discover fa-2x"></i>
				<i class="fab fa-cc-amex fa-2x"></i>
				<i class="fab fa-cc-paypal fa-2x"></i>
			</div>
		</div>

		<div class="col-md-6 ml-auto pt-2">
			<span class="text-muted">© 2022 - 2023 Cool Gadgets Tube</span>
		</div>

	</div>
</footer>


<script>
	$(document).ready(function(){
		if(getCookie('tiendaaviso') != 1 || getCookie('tiendaaviso') != '1'){
            document.getElementById("barraaceptacion").style.display="block";
        } else {
            document.getElementById("barraaceptacion").style.display="none";
        }
	});


	$(window).on('scroll', function(){
		var win = $(this); 
		if($(window).scrollTop() > 100){
			$('nav').addClass('black');
			if(win.width() > 990){
				$('#logosmall').css('display', 'block');
			}
		} else {
			$('nav').removeClass('black');
			$('#logosmall').css('display', 'none');
		}
	});



/*
	window.onresize = function(event) {
	    console.log($(window).width());
	}; */

	function getCookie(c_name){
        var c_value = document.cookie;
        var c_start = c_value.indexOf(" " + c_name + "=");
        if (c_start == -1){
            c_start = c_value.indexOf(c_name + "=");
        }
        if (c_start == -1){
            c_value = null;
        }else{
            c_start = c_value.indexOf("=", c_start) + 1;
            var c_end = c_value.indexOf(";", c_start);
            if (c_end == -1){
                c_end = c_value.length;
            }
            c_value = c_value.substring(c_start,c_end);
        }
        return c_value;
    }

    function setCookie(c_name,value,exdays){
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = value + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie=c_name + "=" + c_value;
    }

    
    function PonerCookie(){
        setCookie('tiendaaviso','1',365);
        document.getElementById("barraaceptacion").style.display="none";
    }
</script>