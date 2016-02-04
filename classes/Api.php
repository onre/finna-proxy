<?php

class Api
{
  public function searchRetrieveRequest($params)
  {
    $finna = new Finna;

    if (!isset($params['maximumRecords']))
      $limit = 0;
    else
      $limit = $params['maximumRecords'];

    if(!empty($params['x-pquery']))
      $params['query'] = $params['x-pquery'];

    $apiParams = array('limit' => $limit);
    if (!empty($params['startRecord']))
      $apiParams['page'] = $params['startRecord'];

    $finnaResults = $finna->search($params['query'], $apiParams);

    $dom = new DOMDocument('1.0', 'UTF-8');

    $xmlRoot = $dom->createElementNS('http://docs.oasis-open.org/ns/search-ws/sruResponse', 'zs:searchRetrieveResponse');
    $xmlRoot = $dom->appendchild($xmlRoot);

    $numberOfRecords = $dom->createElement('zs:numberOfRecords', $finnaResults['resultCount']);
    $xmlRoot->appendChild($numberOfRecords);

    if(!empty($finnaResults['records'])) {
      $records = $dom->createElement('zs:records');
      $positionIndex = 1;

      foreach ($finnaResults['records'] as $record) {
        $domRecord = new DOMDocument;
        $domRecord->loadXML($record['fullRecord']);

        if (!$domRecord) {
          Log::write('corrupted XML');
          Log::write(print_r($record,1));
          break;
        }

        $recordList = $domRecord->getElementsByTagName('record');

        if (!$recordList->length) {
          Log::write('unexpected result, no records found');
          Log::write(print_r($record,1));
          break;
        }

        $importedRecord = $dom->importNode($recordList->item(0), true); 

        $ourRecord = $dom->createElement('zs:record');

        $recordXMLEscaping = $dom->createElement('zs:recordXMLEscaping', 'xml');
        $ourRecord->appendChild($recordXMLEscaping);
      
        $recordSchema = $dom->createElement('zs:recordSchema');
        $ourRecord->appendChild($recordSchema);

        $recordData = $dom->createElement('zs:recordData');
        $recordData->appendChild($importedRecord);
        $ourRecord->appendChild($recordData);

        $recordPosition = $dom->createElement('zs:recordPosition', $positionIndex);
        $ourRecord->appendChild($recordPosition);

        $records->appendChild($ourRecord);

        $positionIndex++;
      }

      $xmlRoot->appendChild($records);
    }

    $echoedRequest = $dom->createElement('zs:echoedSearchRetrieveRequest');

    foreach ($params as $key => $value) {
      $element = $dom->createElement('zs:'.$key, $value);
      $echoedRequest->appendchild($element);
    }

    $xmlRoot->appendChild($echoedRequest);

    return $dom->saveXML();
  }
}