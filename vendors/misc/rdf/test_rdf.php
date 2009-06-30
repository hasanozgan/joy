<?php
include 'HV_ArrayToRDFCollection.php';

$data = array();

$level1[1]['year'] = array('field_id' => 1, 'field_name' => '1st Year');
$level1[2]['year'] = array('field_id' => 2, 'field_name' => '2nd Year');



$level2 = array();
$level2[11]['quarter'] = array('field_id' => 11, 'field_name' => 'Y1 First Quarter');
$level2[12]['quarter'] = array('field_id' => 12, 'field_name' => 'Y1 Second Quarter');
$level2[13]['quarter'] = array('field_id' => 13, 'field_name' => 'Y1 Third Quarter');
$level2[14]['quarter'] = array('field_id' => 14, 'field_name' => 'Y1 Fourth Quarter');

$level3 = array();
$level3[21]['quarter'] = array('field_id' => 21, 'field_name' => 'Y2 First Quarter');
$level3[22]['quarter'] = array('field_id' => 22, 'field_name' => 'Y2 Second Quarter');
$level3[23]['quarter'] = array('field_id' => 23, 'field_name' => 'Y2 Third Quarter');
$level3[24]['quarter'] = array('field_id' => 24, 'field_name' => 'Y2 Fourth Quarter');


$level1[1]['year']['_seq'] = $level2;
$level1[2]['year']['_seq'] = $level3;



$data2 = array();
$data2[101]['amount']  = array('field_name' => 'Initial', 'field_amount' => '200');
$data2[102]['amount']  = array('field_name' => 'Final',   'field_amount' => '210');

$data3 = array();
$data3[201]['amount']  = array('field_name' => 'Initial', 'field_amount' => '300');
$data3[202]['amount']  = array('field_name' => 'Final',   'field_amount' => '410');


$level2[11]['quarter']['_seq'] = $data2;
$level3[22]['quarter']['_seq'] = $data3;

$level1[1]['year']['_seq'] = $level2;
$level1[2]['year']['_seq'] = $level3;


$data['_seq'] = $level1;

HV_ArrayToRDFCollection::output($data); 
?>