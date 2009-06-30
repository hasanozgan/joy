<?php
class ocharacters {

	const sImgPath = 'img/avatars/';

	public $aTestMulti = array ('bla' => array (1,2,3));
	
	public $aChars = array (
		'strength' => 0,
		'dexterity' => 0,
		'intelligence' => 0,
		'endurance' => 0,
		'swiftness' => 0
		);

	public $aAttacks = array (
		'sword' => 0,
		'axe' => 0,
		'lance' => 0,
		'club' => 0,
		'hand' => 0
		);
	public $aDefenseWith = array (
		'sword' => 0,
		'axe' => 0,
		'lance' => 0,
		'club' => 0,
		'hand' => 0,
		'shield' => 0
		);
	public $aDefenseAgainst = array (
		'sword' => 0,
		'axe' => 0,
		'lance' => 0,
		'club' => 0,
		'hand' => 0
		);
	public $aSpecialAtt = array (
		'poison' => 0,
		'fire' => 0,
		'ice' => 0,
		'earth' => 0,
		'water' => 0
		);
	public $aSpecialDef = array (
		'poison' => 0,
		'fire' => 0,
		'ice' => 0,
		'earth' => 0,
		'water' => 0
		);
	public $aSpecialMisc = array (
		'autoHeal' => 0
		);
	public $oArmour = null;
	public $oWeapon = null;
	public $oEquipment = null;
	public $aWeapons = array ();
	public $aArmours = array ();
	public $aEquipments = array ();

	public $PV = 0;
	public $XP = 0;
	public $sImg = '';


	public function __construct ($sImg = 'default.png') {
		$this -> sImg = self::sImgPath.$sImg;
	}

	public function __set ($name, $value) {
		if (isset ($this -> $name)) {
			$this -> $name = $value;
		}
	}

	public function __get ($name) {
		if (isset ($this -> $name)) {
			return $this -> $name;
		}
	}

	public function getMe ($sProp, $sDetail = '') {
		if (isset ($this -> $sProp)) {
			if (!empty ($sDetail)) {
				if (is_array ($this -> $sProp) && array_key_exists ($sDetail, $this -> sProp)) {
					return $this -> $sProp[$sDetail];
				} else {
					return false;
				}
			} else {
				return $this -> $sProp;
			}
		} else {
			return false;
		}
	}

	public function setMe ($sProp, array $aProps = array (), $sDetail = '') {
		if ((empty ($aProps) && empty ($sDetail)) || !isset ($this -> $sProp)) {
			return false;
		} else {
			if (isset ($aProps)) {
				foreach ($aProps as $clef => $val) {
					if (array_key_exists ($clef, $this -> $sProp) && is_numeric ($val)) {
						$this -> {$sProp}[$clef] = $val;
					}
				}
			} else {
				if (isset ($this -> $sProp[$sDetail]) && is_numeric ($sDetail)) {
					$this -> {$sProp}[$sDetail] = $sDetail;
				}
			}
		}
	}

	public function equipMe ($sProp, $oObj) {
		if (!isset ($sProp) || !is_object ($oObj)) {
			return false;
		} else {
			$this -> {$sProp} = $oObj;
		}
	}

	public function addEquip ($sProp, $sName) {
		if (!isset ($sProp)) {
			return false;
		} else {
			$this -> {$sProp}[] = $sName;
		}
	}

	public function isHit ($iAtt, $sWeaponType, array $aSpecials = array ()) {
	}

}
?>