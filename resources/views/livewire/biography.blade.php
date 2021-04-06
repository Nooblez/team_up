<x-jet-action-section>
	<x-slot name="title">
		Biography
	</x-slot>
	<x-slot name="description">
		Informations about you.
	</x-slot>
	<x-slot name="content">
		<form action="" name="bio-update" class="col-12">
			@csrf
			<textarea id="bio" name="bio" form="bio-update" placeholder="Enter text here..."></textarea>
		</form>
		<button class="btn btn-primary" id="submit">Save</button>
	</x-slot>

</x-jet-action-section>

<script>
$(document).ready(function(){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
	$.ajax({
		url: '/user/bio/get',
		type: 'GET',
		success: response => {
			console.log(response);
			$('#bio').html(response);
		}
	});
});

$('#submit').on('click', function(){

	$.ajax({
		url:'/user/update/' + $('#bio').val(),
		type:'POST',
		success: response =>{
			console.log(response);
			$('#bio').html(response);
		}
	});
});
</script>