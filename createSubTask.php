<?php

$fnSelector = json_decode(file_get_contents('php://input'));
call_user_func($fnSelector->fn);

function subTaskCreate(){

    require_once 'variables.php'; 
    $postCall = json_decode(file_get_contents('php://input'));

    $fields = '{
        "fields": {
            "project": {
                "key": "OPS"
            },
            "parent": {
                "key": "'.$postCall->parent.'"
            },
            "summary": "'.$postCall->summary.'",
            "description": "",
            "issuetype": {
                "id": "5"
            },
            "assignee":{"accountId": "'.$myJiraUserID.'"},
            "reporter":{"accountId": "'.$postCall->reporter.'"},
            "customfield_16801": {
                "id": "'.$postCall->c16801.'"
            },
            "customfield_16800": {
                "id": "'.$postCall->c16800.'"
            },
            "customfield_29800": {
                "id": "'.$postCall->c29800.'"
            },
            "customfield_22001": {
                "id": "'.$postCall->c22001.'"
            },
            "customfield_29200": {
                "id": "'.$postCall->c29200.'"
            },
            "customfield_29500": "'.$postCall->c29500.'",
            "customfield_29501": "'.$postCall->c29501.'",
            "customfield_29502": "'.$postCall->c29502.'",
            "customfield_29503": "'.$postCall->c29503.'",
            "customfield_11410": "'.$postCall->c11410.'",
            "customfield_21002": "'.$postCall->c21002.'",
            "customfield_10412": "'.$postCall->c10412.'",
            "customfield_19002": "'.$postCall->c19002.'",
            "customfield_20000": "'.$postCall->c20000.'",
            "customfield_18200": "'.$postCall->c18200.'", 
            "description": "'.preg_replace("/\\n/","\\n",urldecode($postCall->description)).'"
        }
    }';

    // echo(urldecode($postCall->description));
    // echo($fields);


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $jiraDomain.'rest/api/2/issue/');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_USERPWD, $apiUserName.":".$apiToken);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result=curl_exec($ch);
    curl_close($ch);
    echo $result;

    // return $result;

};
