<x-app-layout>
    <input type="hidden" id="team_id" name="team_id" value="{{ $team->id }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        @if($team->user_id == Auth::user()->id)
        <!-- Solo il Leader può aggiungere o rimuovere Labels -->
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        Current Labels <br>
                        Click on a Label to remove it
                        <a href="{{ route('team.label.get', $team) }}"><button class="ml-4 mt-4 btn btn-primary">Get a Label for your Team here</button></a>
                    </div>
                    <div class="card col-8 mt-1 shadow rounded-lg">
                        <div class="card-body">
                            <div id="labels-container">Here appear the labels of your team. Click on one to remove it.</div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            
            <x-jet-section-border />
        @endif
            @livewire('teams.update-team-name-form', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])

            @if (Gate::check('delete', $team) && !$team->personal_team)
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="/js/teams.js"></script>