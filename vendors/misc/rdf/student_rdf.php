<?php
include 'HV_ArrayToRDFCollection.php';

$data = array();

$level1[1]['student'] = array('student_id' => 11, 
                              'student_givenname' => 'John', 
                              'student_familyname' => 'Smith',
                              'student_registration' => 'Tuesday, 5 July 2005 12:34',
                              'student_gender' => 'M',
                              );

$level1[2]['student'] = array('student_id' => 12, 
                              'student_givenname' => 'Sarah', 
                              'student_familyname' => 'Brown',
                              'student_registration' => 'Wednesday, 9 February 2005 14:25',
                              'student_gender' => 'F',
                              );
$level1[3]['student'] = array('student_id' => 3, 
                              'student_givenname' => 'Charles', 
                              'student_familyname' => 'Craft',
                              'student_registration' => 'Thursday, 7 April 2005 09:13',
                              'student_gender' => 'M',
                              );                              

$level1[4]['student'] = array('student_id' => 25, 
                              'student_givenname' => 'Kelly', 
                              'student_familyname' => 'James',
                              'student_registration' => 'Friday, 8 April 2005 08:45',
                              'student_gender' => 'F',
                              );    
                              
$data['_seq'] = $level1;


// assign parseType metadata
$metadata['student_id']['parseType'] = 'Integer';
$metadata['student_registration']['parseType'] = 'Date';
$metadata['student_gender']['parseType'] = 'Resource';

HV_ArrayToRDFCollection::$metadata = $metadata;

// extra RDF used as lookup for gender
$extra = <<<EXTRA
<rdf:Description about="urn:resource:student_gender#M">
  <resource:label>Male</resource:label>
</rdf:Description>

<rdf:Description about="urn:resource:student_gender#F">
  <resource:label>Female</resource:label>
</rdf:Description>
EXTRA;

HV_ArrayToRDFCollection::$rdf_resource = $extra;

HV_ArrayToRDFCollection::output($data); 

?>
