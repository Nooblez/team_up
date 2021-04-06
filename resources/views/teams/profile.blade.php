<x-app-layout>
	<input type="hidden" name="{{ $team->id }}" value="{{ $team->id }}" id="team_id">
	<div class="container card m-5">
		<div class="row mt-3 ml-3">
			<div class="col-4">
			    Team Leader
			</div>
			<div id="team_leader_container" class="col-6"></div>
		</div>
		<div class="row mt-3 ml-3">
			<div class="col-4">
		    	Team Members
			</div>
			<div id="team_member_container" class="col-6"></div>
		</div>
		<div class="row mt-3 ml-3 mb-3">
			<div class="col-4">
				<br>
			    Team Labels
			</div>
			<div id="team_labels_container" class="col-6">
			</div>
		</div>
		<div class="row">
			<button class="btn btn-dark ml-3 mb-3 col-1" onclick="submit()">Iscriviti</button>
		</div>
	</div>
</x-app-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="/js/team_profile.js"></script>