<?php

require './aws/aws-autoloader.php';
require 'creds.inc';

date_default_timezone_set('UTC');

use Aws\DynamoDb\DynamoDbClient;

$client = DynamoDbClient::factory(array(
    'key' => DYNKEY,
	'secret' => DYNSECRET,
    'region'  => 'us-west-2',
	'version' => '2012-08-10'
));
print "The time is now " . date("Y-m-d h:i:s");

/*
$client->deleteTable(array(
  'TableName' => 'Songs'
));
*/
// Assumes table creation was NOT done manually on the web console.
$client->createTable(array(
  'TableName' => 'Songs',
  'AttributeDefinitions' => array(
    array(
      'AttributeName' => 'SongID',
      'AttributeType' => 'N'
    ),
    array(
      'AttributeName' => 'Title',
      'AttributeType' => 'S'
    )
  ),
  'KeySchema' => array(
    array(
      'AttributeName' => 'SongID',
      'KeyType' => 'HASH'
    ),
    array(
      'AttributeName' => 'Title',
      'KeyType' => 'RANGE'
    )
  ),
  'ProvisionedThroughput' => array(
    'ReadCapacityUnits' => 5,
    'WriteCapacityUnits' => 5
  )
));
print "Adding items 1 and 2";
$result = $client->putItem(array(
  'TableName' => 'Songs',
  'Item' => array(
    'SongID' => array('N' => '1'),
    'Title' => array('S' => 'Microphone Singer'),
    'Artist' => array('S' => 'Jakob'),
    'Album' => array('S' => 'My Best')
  )
));

$result = $client->putItem(array(
  'TableName' => 'Songs',
  'Item' => array(
    'SongID' => array('N' => '2'),
    'Title' => array('S' => 'Favorite Song'),
    'Artist' => array('S' => 'Jakob'),
    'Album' => array('S' => 'My Best')
  )
));
/*
//Query is a way to retrieve one item
$result = $client->getItem(array(
  'ConsistenRead' => false,
  'TableName' => 'Songs',
  'Key' => array(
    'SongID' => array('N' => '1')
  )
));
*/

//Scan is a way to get all items with a particular partition key
$iterator = $client->getIterator('Scan', array(
  'TableName' => 'Songs',
  'KeyConditions' => array(
    'SongID' => array(
      'AttributeValueList' => array(
        array('N' => '0'),
      ),
      'ComparisonOperator' => 'GT'
    )
  )
));
//Assumes "Album" has been set in each Item
foreach ($iterator as $item) {
  if (isset($item['Album']['S'])) {
    print $item['Album']['S'] . ": ";
  } else {
    print "No_Album_Data: ";
  }
  print $item['Title']['S'] . "\n";
}

print "<br>Execution complete.";
?>
