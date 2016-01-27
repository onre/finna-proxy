<?php

class Api
{
  public function searchRetrieveRequest($version, $query)
  {
    if ($version != '1.2')
      return false;

    $finna = new Finna;

    $finnaResults = $finna->search($query);

    $dom = new DOMDocument('1.0', 'UTF-8');

    $xmlRoot = $dom->createElement('xml');
    $xmlRoot = $dom->appendchild($xmlRoot);

    $version = $dom->createElement('version', '1.2');
    $xmlRoot->appendChild($version);

    $numberOfRecords = $dom->createElement('numberOfRecords', count($finnaResults['records']));
    $xmlRoot->appendChild($numberOfRecords);

    $records = $dom->createElement('records');

    foreach ($finnaResults['records'] as $record) {
      $sxml = simplexml_load_string($record['fullRecord']);
      
      $domSxml = dom_import_simplexml($sxml->children()[0]); // first child is what we want

      $importedRecord = $dom->importNode($domSxml);

      $records->appendChild($importedRecord);
    }

    $dom->appendChild($records);

    return $dom->saveXML();
  }
}