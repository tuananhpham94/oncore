<?php
require_once 'google-api-php-client-2.2.2/vendor/autoload.php';
require '../../vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=client_secret.json');
set_time_limit(0);
$client = new Google_Client;
$client->useApplicationDefaultCredentials();

$client->setApplicationName("Something to do with my representatives");

$client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds']);

if ($client->isAccessTokenExpired()) {
    $client->refreshTokenWithAssertion();
}
$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
\Google\Spreadsheet\ServiceRequestFactory::setInstance(
    new \Google\Spreadsheet\DefaultServiceRequest($accessToken)
);


// Get our spreadsheet
$spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
    ->getSpreadsheetFeed()
    ->getByTitle('Oncore International - Consumer Lead Tracker - DO NOT EDIT');

// Get the first worksheet (tab)
$worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
$worksheet = $worksheets[0];

$listFeed = $worksheet->getListFeed();
if($privacy == "on" || $privacy == "1" || $privacy == 1 || $privacy == "True") {
    $privacy = "TRUE";
} else {
    $privacy = "FALSE";
}