<?php
namespace App;
use Illuminate\Http\Request;
class recipeSearch{
  public $listOfRecipesId;
  public $listOfRecipesTitle;
  public $listOfRecipesImage;
  Public Function find (Request $request){
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
    $max = sizeof($listOfRecipes);
    for($i=0; $i<$max ;$i++)
    {
      
      array_push($listOfRecipesId, $listOfRecipes[$i]->recipe_id);
      array_push($listOfRecipesTitle, $listOfRecipes[$i]->title);
      array_push($listOfRecipesImage, $listOfRecipes[$i]->image_url);
    }

  }
  
}
