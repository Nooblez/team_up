$(document).ready(function(){
    let team_id = $('#team_id').val();
    console.log(team_id);
    $.ajax({
        url: "/labels/team/" + team_id + "/get",
        type: "get",
        success: response => {
            let labels = response.labels;
            if (labels.length > 0) {
                $('#labels-container').html('');
            }
            let i = 0;
            $.each(labels, function(id){
                console.log(response.labels[i].id);
                $('#labels-container').append(
                    '<a class="btn shadow btn-secondary ml-3 mt-2 label_team_' + team_id + '" onClick="label_team_button(' + team_id + ', ' + response.labels[i].id + ')">'+
                        '<p>' + response.labels[id].label_name + '</p></a>'
                    );
                i += 1;
            });
        }
    });
});

function label_team_button(team_id, id){
    $.ajax({
        url: '/labels/team/' + team_id + '/detach/' + id,
        type: 'GET',
        success: response => {
            $('.label_team_' + team_id).hide();
        }
    });
}