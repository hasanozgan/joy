<?php
class oweapons {

	const sPathImg = 'img/weapons/';

	public $sImg = '';

	private $sIsA = '';
	private $aSpecialAtt = array (
		'poison' => 0,
		'fire' => 0,
		'ice' => 0,
		'earth' => 0,
		'water' => 0
		);
	private $aSpecialDef = array (
		'poison' => 0,
		'fire' => 0,
		'ice' => 0,
		'earth' => 0,
		'water' => 0
		);
	private $aDefense = array (
		'sword' => 0,
		'axe' => 0,
		'lance' => 0,
		'club' => 0,
		'hand' => 0
		);

	private $sName = '';
	private $sType = '';

	public function __construct ($sName, $sType, $sImg = 'default.png') {
		$this -> sImg = self::sPathImg.$sImg;
		$this -> sName = $sName;
		$this -> sType = $sType;
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
}
?>