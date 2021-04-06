$(document).ready(function(){
    $.ajax({
        url: '/dashboard/get',
        type: 'GET',
        success: response => {
            for (var i = response.length - 1; i >= 0; i--) {
                if(!response[i].personal_team){
                    $('#team_container').append(
                        '<a class="mt-4 mb-4" href="/teams/profile/' + response[i].id + '"><div class="col-5 mt-4 mr-2 btn bg-white overflow-hidden shadow-xl sm:rounded-lg drop_labels_here_' + response[i].id + '" id="team_' + response[i].id + '"}}">' +
                            response[i].name +
                        '</div></a>'
                    );
                }
            }
        }
    });
});

