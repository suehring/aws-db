<?php

//Note that this code does not work as-is.  Needs Elastic Beanstalk

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
//Do this first - may result in error
/*
$client->deleteTable(array(
  'TableName' => 'Songs'
));
*/

//Do this next
/*
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
*/

//Once table has been created and propagated, do this:
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


$result = $client->getItem(array(
  'ConsistenRead' => false,
  'TableName' => 'Songs',
  'Key' => array(
    'SongID' => array('N' => '1'),
    'Title' => array('S' => 'Microphone Singer')
  )
));

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
foreach ($iterator as $item) {
  print $item['Album']['S'] . ": " . $item['Title']['S'] . "\n";
}
//print $result['Item']['Artist']['S'] . "\n";

?>
