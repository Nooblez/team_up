$(document).ready(function(){
    $.ajax({
        url: '/labels/user/get',
        type: 'GET',
        success: response => {
            for (var i = response.length - 1; i >= 0; i--) {
                $('#label_buttons_container').append(
                    '<button class="btn btn-secondary mt-1 label_' + response[i].id + '" onclick="detach_label(' + response[i].id + ')">' + response[i].name + '</button> &nbsp;'
                );
            }
        }
    });
});

function detach_label(id) {
    console.log('click');
    $.ajax({
        url: '/labels/user/detach/' + id,
        type: 'GET',
        success: response => {
            $('.label_' + id).hide();
        }
    });
}