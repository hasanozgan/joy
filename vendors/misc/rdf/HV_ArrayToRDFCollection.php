<?php
/**
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
* Copy of GNU Lesser General Public License at: http://www.gnu.org/copyleft/lesser.txt
* Contact author at: hveluwenkamp@myrealbox.com
*
*/

/**
* Generate RDF of array as a collection serialised in XML. 
* Called as a static class.
* Can be used for template generation in Mozilla platform.

* Example of use:
* <pre>
* include 'HV_ArrayToRDFCollection.php';
* 
* $data = array();
* 
* $level1[1]['year'] = array('field_id' => 1, 'field_name' => '1st Year');
* $level1[2]['year'] = array('field_id' => 2, 'field_name' => '2nd Year');
* 
* $level2 = array();
* $level2[11]['quarter'] = array('field_id' => 11, 'field_name' => 'Y1 First Quarter');
* $level2[12]['quarter'] = array('field_id' => 12, 'field_name' => 'Y1 Second Quarter');
* $level2[13]['quarter'] = array('field_id' => 13, 'field_name' => 'Y1 Third Quarter');
* $level2[14]['quarter'] = array('field_id' => 14, 'field_name' => 'Y1 Fourth Quarter');
* 
* $level3 = array();
* $level3[21]['quarter'] = array('field_id' => 21, 'field_name' => 'Y2 First Quarter');
* $level3[22]['quarter'] = array('field_id' => 22, 'field_name' => 'Y2 Second Quarter');
* $level3[23]['quarter'] = array('field_id' => 23, 'field_name' => 'Y2 Third Quarter');
* $level3[24]['quarter'] = array('field_id' => 24, 'field_name' => 'Y2 Fourth Quarter');
* 
* $level1[1]['year']['_seq'] = $level2;
* $level1[2]['year']['_seq'] = $level3;
* 
* $data2 = array();
* $data2[101]['amount']  = array('field_name' => 'Initial', 'field_amount' => '200');
* $data2[102]['amount']  = array('field_name' => 'Final',   'field_amount' => '210');
* 
* $data3 = array();
* $data3[201]['amount']  = array('field_name' => 'Initial', 'field_amount' => '300');
* $data3[202]['amount']  = array('field_name' => 'Final',   'field_amount' => '410');
* 
* $level2[11]['quarter']['_seq'] = $data2;
* $level3[22]['quarter']['_seq'] = $data3;
* 
* $level1[1]['year']['_seq'] = $level2;
* $level1[2]['year']['_seq'] = $level3;
* 
* $data['_seq'] = $level1;
* 
* HV_ArrayToRDFCollection::output($data); 
* </pre>
*
* @author Herman Veluwenkamp
* @version 1.0
*/
class HV_ArrayToRDFCollection {

  /**
  * URI of RDF model.
  * @var string
  * @public
  */  
  public static $uri_model = 'urn:record:';
  
  /**
  * URI to use for data in RDF output.
  * @var string
  * @public
  */  
  public static $uri_base = 'urn:record#';

  /**
  * URI for extra RDF content attached to data with parseType of 'Resource'.
  * @var string
  * @public
  */  
  public static $uri_resource = 'urn:resource:';
  
  /**
  * Tag to use in RDF as collection element.
  * @var string
  * @public
  */  
  public static $tag_collection = 'list';

  /**
  * Attribute name for indicating RDF parseType.
  * Should be in RDF namespace but Mozilla implementation of RDF is outdated.
  * @var string
  * @public
  */  
  public static $attributename_parseType = 'nc:parseType';
  
  /**
  * Key used to indicate a collection in the input array.
  * @var string
  * @public
  */  
  public static $key_container = '_seq';

  /**
  * Extra RDF to append to RDF model.
  * @var string
  * @public
  */  
  public static $rdf_resource = '';
    
  /**
  * Array of metadata associated with incoming data array.
  * @var array
  * @public
  */  
  public static $metadata = array();
    
  /**
  * Generates the collection in RDF
  *
  * @param string $data Array to be processed.
  * @param string $spacer Private
  * @param string $expanded Private
  * @param string $last_key Private
  * @param string $last_index Private
  * @returns string RDF serialised as XML
  */ 
  private static function generateCollection($data, $spacer='', $expanded='', $last_key='', $last_index='') {
    if (is_array($data) or is_object($data)) {
      while (list($key, $val) = each($data)) {
        if (is_array($val)) {
          if ($key==self::$key_container) {
            $expanded .=  $spacer.'<'.self::$tag_collection.' rdf:parseType="Collection">'."\n";
            $expanded  = self::generateCollection($val, $spacer.'  ', $expanded, $key);
            $expanded .=  $spacer.'</'.self::$tag_collection.'>'."\n";
          } else {
            if ($last_key==self::$key_container) {
              $expanded  = self::generateCollection($val, $spacer, $expanded, $key, $key);
            } else {
              $urn = "urn:$key:$last_key";
              $expanded .=  $spacer.'<rdf:Description about="'.$urn.'">'."\n";
              $expanded  = self::generateCollection($val, $spacer.'  ', $expanded, $key, $last_index);
              $expanded .=  $spacer.'</rdf:Description>'."\n";
            }
          }
        } else {
          $attribute = '';
          
          if (isset(self::$metadata[$key]['parseType'])) {
            
            switch (self::$metadata[$key]['parseType']) {
              case 'Resource':
                $attribute .= ' rdf:resource="'.self::$uri_resource.$key.'#'.$val.'"';
                $val = '';
                break;
              case 'Literal':
              case 'Date':
              default:
                $attribute .= ' '.self::$attributename_parseType.'="'.self::$metadata[$key]['parseType'].'"';
                break;
            }
          }
          $expanded .= $spacer.'<'.$key.$attribute.'>'.$val.'</'.$key.'>'."\n";          
        }
      }
    } else $expanded .= $spacer.'<'.$data.'>'."\n";
    return $expanded;
  }  
  

  /**
  * Generates the wrapper around the RDF collection and inserts the generated RDF collection.
  *
  * @param string $data Array to be processed.
  * @returns string RDF serialised as XML
  */   
  public static function generateRDF($data) {
            
    $rdf  = '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"';
    $rdf .= ' xmlns:nc="http://home.netscape.com/NC-rdf#"';
    
    if (self::$uri_resource) $rdf .= ' xmlns:resource="'.self::$uri_resource.'"';

    
    $rdf .= ' xmlns="'.self::$uri_base.'">'."\n";
    $rdf .= '  <rdf:Description rdf:about="'.self::$uri_model.'all">'."\n";
    $rdf .= self::generateCollection($data, '    ');
    $rdf .= '  </rdf:Description>'."\n";
    
    if (self::$rdf_resource) $rdf .= "\n".self::$rdf_resource;
    
    $rdf .= '</rdf:RDF>';
    
    return $rdf;
  }

  /**
  * Generates and outputs the RDF including the HTTP content type header.
  *
  * @param string $data Array to be processed.
  * @returns void
  */     
  public static function output($data) {
    header('content-type: text/xml');
    $rdf = self::generateRdf($data);
    echo $rdf;
  }
}



?>
