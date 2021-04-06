<x-app-layout>
<div class="container">
	Clicca su una Label per ottenerla.
	<div class="row ml-3" id="label-container"></div>
</div>
</x-app-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
	$.ajax({
        url: "/labels/get-all",
        type: "get",
        success: response => {
        	let labels = response.labels;

        	$.each(labels, function(id){
        		$('#label-container').append(
        			'<a href="/labels/user/get/' + id + '" class="btn shadow bg-white ml-3 mt-2">'+
        				'<p>' + labels[id].label_name + '</p>' +
        				labels[id].label_description +
        			'</a>'
        			);
        	});
        }
    });
});
	
</script>