<?php


class BibleBrainBibleController extends Bible implements BibleBrainConection {
    private $dbConnection;
    private $languageCodeIso;


    public function __construct(){
        $this->dbConnection = new DatabaseConnection();
        
    }
    /*This endpoint would be used to find all content available for each Bible for a specific language.
https://4.dbt.io/api/bibles?language_code=HAE&page=1&limit=25
*/
    public function getBiblesForLanguageIso($languageCodeIso, $limit){

	$output = '';
    $url = 'https://4.dbt.io/api/bibles?language_code=';
    $url .=  strtoupper($languageCodeIso) ;
    $url .= '&page=1&limit='. $limit;
   
    $response =  new BibleBrainConnection($url);
	print_r($response);
	/*$dbp_prod = 'dbp-prod';
	$dbp_vid ='dbp-vid';
	foreach ($resources as $resource){
		$output .= $resource->abbr . ': '. $resource->vname . '(' . $resource->name. ')<br>';
		if (isset($resource->filesets->$dbp_prod)){
			$items = $resource->filesets->$dbp_prod;
			foreach ( $items as $item){
				$output .= '----------' .$item->id . '(' . $item->type. ')'. $item->size . '<br>';
			}
		}
		if (isset($resource->filesets->$dbp_vid)){
			$items = $resource->filesets->$dbp_vid;
			foreach ( $items as $item){
				$output .= '----------' .$item->id . '(' . $item->type. ')'. $item->size . '<br>';
			}
		}
	}
	return $output;
    */