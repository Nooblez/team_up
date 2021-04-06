$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/labels/team/' + $('#team_id').val() + '/get/',
        type: 'GET',
        success: response => {
            for (var i = response.labels.length - 1; i >= 0; i--) {
                $('#team_labels_container').append(
                    '<a class="mt-4 mb-4"><div class="col-5 mt-4 mr-2 btn btn-primary overflow-hidden shadow-xl sm:rounded-lg' + response.labels[i].id + '" id="team_' + response.labels[i].id + '"}}">' +
                        response.labels[i].label_name +
                    '</div></a>'
                );
            }
        }
    });

    $.ajax({
        url: '/team/' + $('#team_id').val() + '/members/get/',
        type: 'GET',
        success: response => {
            let members = response.labels;
            if (members.length == 0) {
                $('#team_member_container').html('Non c\'è alcun membro in questo team.');
            }

            for (var i = members.length - 1; i >= 0; i--) {
                $('#team_member_container').append(
                    members[i].name + ' - ' + members[i].email + '<br>'
                );
            }
        }
    });

    $.ajax({
        url: '/team/' + $('#team_id').val() + '/leader/get/',
        type: 'GET',
        success: response => {
            $('#team_leader_container').html(
                response.name + ' - ' + response.email + '<br>'
            );
        }
    });

    $.ajax({
        url: '/roles/get/all',
        type: 'GET',
        success: response => {
            $('#select_role').html('<option id="none"> - Select a Role - </option>');
            for (var i = response.length - 1; i >= 0; i--) {
                $('#select_role').append(
                    '<option id="' + i+1 + '" value="' + i+1 + '"><p class="h2">' + response[i].name + '</p>&nbsp; <p class="h3">' + response[i].description + '</p></option>'
                );
            }
        }
    });
});

function add_team_member(){
    
    $.ajax({
        url: '/team/' + $('#team_container').val() + '/add/user/' + $('#email').val() + '/role/' + $('#select_role :selected').val(),
        type: 'POST',
        success: response => {
        }
    });

    location.reload();
}

function submit(){
    $.ajax({
        //manda email a tutti gli admin
        url: '/team/' + $('#team_id').val() + '/submit',
        type: 'GET',
        success: response => {
            window.location('/submitted');
        }
    });
}