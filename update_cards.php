<pre>
<?php
/**
 * Created by PhpStorm.
 * User: hesslau
 * Date: 5/23/17
 * Time: 6:11 PM
 */

require __DIR__ . '/incl/autoload.php';
require __DIR__ . '/incl/TrelloCard.php';
require __DIR__ . '/settings.php';

$currentUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http')."://".$_SERVER['HTTP_HOST'].preg_replace('/\?.*$/', '', $_SERVER["REQUEST_URI"]);

$client = new \Stevenmaguire\Services\Trello\Client(array(
    'key' => TRELLO_APP_KEY,
    'token' => TRELLO_TOKEN
));

$cards = $client->getBoardCards(TRELLO_BOARD_ID);
$resolvedCards = array_map(function($trelloCard) use ($client) {
    return new TrelloCard($client,$trelloCard);
},$cards);

foreach($resolvedCards as $card) {
    printf("%s<br>\n",$card->getName());
}

file_put_contents("data/cards.json",json_encode($resolvedCards));