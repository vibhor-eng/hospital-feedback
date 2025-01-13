@extends('layouts.master') 

@section('seo_title', 'Login')



@section('body_content')

<!-- partial -->
        <div class="main-panel">
        	@include('layouts.blocks.error')
	          <div class="content-wrapper">

	          	<h1>Generated QR Code</h1>
   			{!! $qrCode !!}
	            
	          </div>
	          
	          @include('layouts.blocks.footer')
          
        </div>
        

@endsection