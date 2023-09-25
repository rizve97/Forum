@extends('layouts.app')
@section('content')

<div class="alert alert-success">
	<button onclick="postData()">Click Me</button>
</div>
@endsection
@section('script')
<script>
   

    function postData(){
   
        //var name = $("input[name=name]").val();
        //var password = $("input[name=password]").val();
        //var email = $("input[name=email]").val();
   		csrfTok();
        	$.ajax({
	           type:'POST',
	           url:'/ajaxRequest',
	           data:{
	           	name : 'name'
	           },
	           success:function(data){
	              notifications(data.code);
	           },
	           error: function(xhr, status) {
	           	 notifications(xhr.status);
			    },
	        });
	};
</script>
@endsection