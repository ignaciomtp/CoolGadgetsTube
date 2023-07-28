    @extends('layouts.basecat')

    @section('title', 'Contact')

    @section('content')

    <main class="album bg-light pb-5">
		<div class="container pt-3 text-center mb-4">
			
			@if(isset($successMsg))
              <div class="alert alert-success"> {{ $successMsg }}</div>
            @endif

			<div class="white-back sombra p-5 mt-5 mb-5">
				<h1>Contact Us</h1>
				<p class="text-left">Thank you for accessing the contact form. We will be happy to answer any comments, suggestions or even criticism you may have. Don't miss the opportunity to tell us what you like about this website and what you would improve.
				</p>
				<form class="py-2" method="post" action="{{ route('sendMessage') }}">
                @csrf
                <div class="row">
                    <div class="col-md-8 text-left form-line">
                        <div class="form-group row">
                        	<div class="col-3">
								<label for="inputName">Name</label>
                        	</div>
                        	<div class="col-9">
                        		<input type="text" class="form-control" name="inputName" id="inputName" required  >
                        	</div>
                            
                            
                        </div>
                        <div class="form-group row">
                        	<div class="col-3">
								<label for="inputEmail">Email</label>
                        	</div>
                        	<div class="col-9">
                        		<input type="email" class="form-control" id="inputEmail" name="inputEmail" required >
                        	</div>
                            
                            
                        </div>	
						<div class="form-group row">
							<div class="col-3">
								<label for="inputSubject">Subject</label>
                        	</div>
                        	<div class="col-9">
                        		<input type="text" class="form-control" id="inputSubject" name="inputSubject" required >
                        	</div>
                            
                            
                        </div>	
                    </div>
                        
                    <div class="col-md-4">
                        <div class="form-check" id="contactcheck">
                          <input class="form-check-input" type="checkbox" name="flexCheckDefault" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckDefault">
                            Default checkbox
                          </label>
                        </div>
                    </div>

                    <div class="col-md-12 text-left">
						<div class="form-group">
                            <label for ="description"> Message</label>
                            <textarea  class="form-control" id="description" name="description" rows="5" required ></textarea>
                        </div>
                        <div>
                            <button type="submit" id="send" class="btn btn-dark submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Send</button>
                        </div>

                    </div>
                </div>
            </form>

			</div>

		</div>



	</main>


@endsection