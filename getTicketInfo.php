<?php

$fnSelector = json_decode(file_get_contents('php://input'));
call_user_func($fnSelector->fn);

function getJiraFields(){
    require_once 'variables.php'; 

    $postCall = json_decode(file_get_contents('php://input'));
	$jiraFields = "";
	//$jiraFields = 'key,summary,description,customfield_25304,customfield_29503,customfield_15003,customfield_21002,reporter,assignee,customfield_11410,customfield_19002,customfield_10412,customfield_20000,customfield_22001';
	$jiraQuery = urlencode($postCall->query);
    $jiraMax = 100;
	$jiraStart =  0;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $jiraDomain.'rest/api/2/search?jql='.$jiraQuery.'&expand=renderedFields&fields='.$jiraFields.'&maxResults='.$jiraMax.'&startAt='.$jiraStart);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERPWD, $apiUserName.":".$apiToken);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result=curl_exec($ch);

	curl_close($ch);

	echo $result;

	return $result;

};


?>