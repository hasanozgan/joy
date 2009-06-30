<?php
/**
* include stuff
*/
require_once 'class/ocharacters.cls.php';
require_once 'class/oweapons.cls.php';
require_once 'class/xmlserialize.cls.php';

/**
* main class instanciation
*/
$ohero = new ocharacters;

/**
* defining some characteristics =! from the one by default
*/
$ohero -> setMe ('aChars', array ('strength' => 9,'dexterity' => 6,'intelligence' => 3,'endurance' => 8,'swiftness' => 7));
$ohero -> setMe ('aAttacks', array ('sword' => 5,
		'axe' => 0,
		'lance' => 0,
		'club' => 0,
		'hand' => 0));
$ohero -> setMe ('aDefenseWith', array ('sword' => 1,
		'axe' => 0,
		'lance' => 0,
		'club' => 0,
		'hand' => 0,
		'shield' => 0));
$ohero -> setMe ('aDefenseAgainst', array ('sword' => 2,
		'axe' => 1,
		'lance' => 0,
		'club' => 5,
		'hand' => 10));

/**
* adding an oweapon object to the hero
*/
$osword = new oweapons ('Basic Sword', 'sword');
$ohero -> addEquip ('aWeapons', $osword -> getMe ('sName'));
$ohero -> equipMe ('oWeapon', $osword);

$ohero -> aTestMulti = array ('bla' => array (1 => array ('test2', 30),2,5));
$ohero -> PV = 20;
$ohero -> aChars['strength'] = 23;

/**
* xmlserializer instanciation with the created object
*/
$oxml = new xmlserialize ($ohero);
$oxml -> getProps ();

/**
* echo the object's properties
*/
echo $oxml;
$sXml = $oxml -> varsToXml ();

/**
* echo the xml serialization 
*/
#echo htmlentities ($sXml);
echo $oxml;

/**
* create a new empty hero object, to be sure it works fine :-) Charcateristics will be the default ones
*/
$oNewHero = new ocharacters;
/**
* now we will get the object again
*/
$oNewXml = new xmlserialize ($oNewHero, array ($osword));

/**
* get the object
*/
$oNewXml -> xmlToVars ($sXml);

/**
* we assign the obtained object to our new instance of a hero
*/
$oNewHero2 = $oNewXml -> getObj ();

/**
* echo the obtained hero : yep, everything is here :-)
*/

echo '<br /><br />';
echo '<pre>', print_r ($oNewHero2), '</pre>';

?>
