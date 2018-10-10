<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Team;
use App\Match;
use App\Lib\Sportradar;
use App\TeamVersusTeam;
use App\LeagueTeamStandings;
use App\Lib\Translator;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    public function __construct(){
        $response = [];
    }
    
    function response($data){
        $data = $this->arrayHandleFun($data);
        //echo "<pre>"; print_r($data);
        // die;
        //echo json_encode($data,JSON_UNESCAPED_UNICODE); 
        echo json_encode($data,JSON_UNESCAPED_UNICODE); 
    }
    
    function validationHandle($validation,$len=null){
        foreach ($validation->getMessages() as $field_name => $messages){
            if(!isset($firstError)){
                if($len=='ar'){
                    $messages[0] = Translator::process('en', 'ar', $messages[0]);
                }
                $firstError        =$messages[0];
                $error[$field_name]=$messages[0];
            }
        }
        return $firstError;
    }
    
    function random($length = 30){
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length).time();
    }
    
    
    function arrayHandleFun($array, $isRepeat = false){
        //echo "asdf"; die('hello');
        foreach ($array as $key => $value) {
          //  echo "<pre>"; print_r($value); die;
            if ($value === null) { 
                $array[$key] =  "";
            }else if (is_array($value)) {
                if (empty($value)){
                    //$value[$key] = "";
                }else{
                    $array[$key] = SELF::arrayHandleFun($value);
                } 
            }
        }
        if (!$isRepeat) {
            $array = SELF::arrayHandleFun($array,true);
        }
        return $array;        
    }


    function teamDetailsUpdate($id){
        
        $match = Match::find($id);
        // This code use for head to head match data get start here.
        $endPoint =  "teams/".$match['home_team_id']."/versus/".$match['away_team_id']."/"."matches.json?";
        $response = Sportradar::process_data($endPoint);                    
        $matchData = json_decode($response['response']);
        //dd($matchData);
        if (count(@$matchData->last_meetings->results)>0){
            foreach ($matchData->last_meetings->results as $key => $matchData) {
                if($key<5){
                    $data = [
                        "match_id" => $id,
                        "home" => $matchData->sport_event->competitors[0]->name,
                        "away" => $matchData->sport_event->competitors[1]->name,
                        "home_score" => $matchData->sport_event_status->home_score,
                        "away_score" => $matchData->sport_event_status->away_score,
                    ];
                    $result = TeamVersusTeam::create($data);
                }
            }
        }                 
        // This code use for head to head match data get end here.

        // This code use for league table get start here.
        $endPoint =  "tournaments/".$match['competition_id']."/standings.json?";
        $response = Sportradar::process_data($endPoint);                    
        $leagueData = json_decode($response['response']);
        
        if($leagueData!=""){
            if (count(@$leagueData->standings)>0){
                LeagueTeamStandings::where([['competition_id','=',$match['competition_id']]])->delete();
                foreach ($leagueData->standings as $key => $team) {
                    foreach($team->groups as $team_standings){
                        foreach($team_standings->team_standings as $details){
                            $data = [
                                "competition_id"=> $match['competition_id'],
                                "standing_type" => $team->type,
                                "team_id"       => $details->team->id,
                                "team_name"     => $details->team->name,
                                "rank"          => $details->rank,
                                "points"        => $details->points,
                                "played"        => $details->played,
                                "won"           => $details->win,
                                "lost"          => $details->loss,
                                "draw"          => $details->draw,
                                "created_at"    => date("Y-m-d H:i:s"),
                            ];
                            $result = LeagueTeamStandings::create($data);
                        }
                    }
                }
            }
            // This code use for league table get end here.          
            
        }
        
        
    }
    
    
    
}
