@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-20 ">
            <div class="panel panel-default">
                <div class="panel-heading">All Match</div>
                <div class="panel-body">
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Tournament ID</th>
                                    <th>match name</th>
                                    <th>ground name</th>
                                    <th>match type</th>
                                    <th>overs</th>
                                    <th>innings</th>
                                    <th>status</th>
                                    <th>toss</th>
                                    <th>team1 id</th>
                                    <th>team2 id</th>
                                    <th>location</th>
                                    <th>match date</th>
                                    <th>ttl overs</th>
                                    <th>ttl player</th>
                                    <th>win toss</th>
                                    <th>toss winner</th>
                                    <th>inning 1</th>
                                    <th>inning 2</th>
                                    <th>view</th>
                                    <th>delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($match_masters as $match)
                                    <tr>
                                        <td>{{ $match->tournament_id}}</td>
                                        <td>{{ $match->match_name }}</td>
                                        <td>{{ $match->ground_name }}</td>
                                        <td>{{ $match->match_type }}</td>
                                        <td>{{ $match->overs }}</td>
                                        <td>{{ $match->innings }}</td>
                                        <td>{{ $match->status }}</td>
                                        <td>{{ $match->toss }}</td>
                                        <td>{{ $match->team1_id }}</td>
                                        <td>{{ $match->team2_id }}</td>
                                        <td>{{ $match->location }}</td>
                                        <td>{{ $match->match_date }}</td>
                                        <td>{{ $match->ttl_overs }}</td>
                                        <td>{{ $match->ttl_player_each_cnt }}</td>
                                        <td>{{ $match->win_toss_id }}</td>
                                        <td>{{ $match->selected_to_by_toss_winner }}</td>
                                        <td>{{ $match->inning_1 }}</td>
                                        <td>{{ $match->inning_2 }}</td>
                                        <td><a href="{{route('matchmaster.show',$match->match_id)}}">link</a></td>
                                        <td>
                                            <form id="delete" method="post" action="/matchmaster/{{$match->match_id}}">
                                               {{ csrf_field() }}
                                               {{ method_field('Delete') }}
                                               <button>delete</button>
                                           </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
