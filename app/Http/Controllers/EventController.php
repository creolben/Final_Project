<?php

namespace App\Http\Controllers;
use App;
use input;
use App\Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\recipeSearch;
class EventController extends Controller
{
  
  public function index()
    {
          $c = new \App\myCalendar;
          $calendar =  $c->create();
        return view('main_page', compact('calendar'));
      }
    
  Public function search(Request $request){
   $c = new \App\myCalendar;
   $calendar = $c->create();
   if ($request->has('recipe'))
    {
//
    $searchValues = $request->input('recipe');
    }
  else
  {
    $searchValues = 'chicken';
  }
  $search = "http://food2fork.com/api/search?key=f1a5ea67b861428fa53fd5ee48e46386&q=";
  $search .= $searchValues;
  $jsonSearchContent = file_get_contents($search);
  $jfo = json_decode($jsonSearchContent);
  $listOfRecipes = $jfo->recipes;

  $listOfRecipesId = array();
  $listOfRecipesTitle = array();
  $listOfRecipesImage = array();
  $listOfsource_url = array();
  $max = sizeof($listOfRecipes);
  
    for($i=0; $i<$max ;$i++)
    {
      
      array_push($listOfRecipesId, $listOfRecipes[$i]->recipe_id);
      array_push($listOfRecipesTitle, $listOfRecipes[$i]->title);
      array_push($listOfRecipesImage, $listOfRecipes[$i]->image_url);
      array_push($listOfsource_url , $listOfRecipes[$i]->source_url);
    }

    return response()->json(['listOfId' => $listOfRecipesId,'listOfTitle' => $listOfRecipesTitle, 'listOfImages' => $listOfRecipesImage,'listOfUrls' =>$listOfsource_url]);
     
    
    //return view('main_page', compact('calendar'));
  }
  public function create(Request $request)
    {
     
       $e =  new \App\EventModel;
       $e->title = $request->title;
       $e->full_day = true;
       $e->start_time = $request->start_time;
       $e->end_time = $request->end_time;
       $e->save();
       $events = \App\EventModel::all();
       return response()->json(['events' => $events]);
    }
  
  public function edit($id)
    {
     return view('event/edit', ['event' => Event::findOrFail($id)]);
    }
  public function update(Request $request)
    {
      if ($request->has('start_time')){
        $title = $request->title;
      $id = $request->id;
      $start_time = $request->start_time;
      $end_time = $request->end_time;
      $e = \App\EventModel::find($request->id);
      $e->start_time = $start_time;
      $e->end_time = $end_time;
      $e->save();
      }
      
    }
  public function destroy(Request $request)
    {
        if ($request){
       $event = \App\EventModel::findOrFail($request->id);
       $event->delete();
       return response()->json(['event' => $event]);
      }
    }
  Public function test(){
    $events = \App\EventModel::all();
    //return $events;
    return view('test',compact('events'));
  }
  Public function feed(){
    $events = \App\EventModel::all();
    return $events;
    
  }
}
