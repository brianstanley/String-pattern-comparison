<?php
/*
Script that compare strings with a pattern and return
the similarity results
For the comparisson You can put an array or a single string for the compare word
The pattern its a simple string but with some modifications you can put an array.
--------------------
IMPORTANT READ
100%: The words are same(best).
>100%: The words are little similar but not same.

*/
class Analysis{
	public $patron = "comunidad";
	public $busqueda;
	public $busquedaLen;
	public $patronLen;
/* start methods */	
	public function __construct($busqueda,$pattern){
		$this->patron=$pattern;
		if(is_array($busqueda)):
			array_walk($busqueda, array($this,'trimPalabras'));
		endif;
		$this->busqueda=$busqueda;
		$this->starter();	
	}
	function trimPalabras(&$value){ 
	    $value = trim($value); 
	    $value = str_replace(' ','',$value);
	    return true;	
	}

	function starter(){
		if(is_array($this->busqueda)):
			foreach($this->busqueda as $palabra){
				$this->busqueda = $palabra;
				if(strlen($palabra) > strlen($this->patron)):
					$resto = strlen($palabra)-strlen($this->patron); 	
					$palabra=substr_replace($palabra, "", -$resto);
				endif;
				$this->busquedaLen = strlen($palabra);
				$this->patronLen = strlen($this->patron);		
				$diferencia = $this->patronLen-$this->busquedaLen;
				if($diferencia > 0){
					for($i=1;$i<=$diferencia;$i++){
						$palabra = $palabra." ";	
					}
				}
				$this->coincidences($palabra,$this->patron);			
				
			}
		else:
			$busqueda = $this->busqueda;
			$this->busquedaLen = strlen($this->busqueda);
			$this->patronLen = strlen($this->patron);
			$diferencia = $this->patronLen-$this->busquedaLen;
			if($diferencia > 0){
				for($i=1;$i<=$diferencia;$i++){
					$busqueda = $this->busqueda." ";	
				}
			}
			$this->coincidences($busqueda,$this->patron);	
		endif;
	}
	/* Here I get the individually percentage of each pattern letter */
	function getLetterValue(){
		return 100/$this->patronLen;
	}
	/*Here I obtain the value of the comparison word with the pattern */
	function comparison(){
		$valeCletra = 100/$this->patronLen;
		$res = $valeCletra*$this->busquedaLen;
		return $res;
	}
	function coincidences($palabra){
		$coincidences = 0;
		$palabra = " ".$palabra; 
		for($in = 1;$in<=strlen($this->patron);$in++){
			for($a=1; $a<=strlen($this->patron);$a++){
				if($palabra[$a]==$this->patron[$in-1] ):
					$palabra[$a]="|";	
					$coincidences++;
				endif;	
			}	
		}
		$valorLetra = $this->getLetterValue($this->patronLen); 
		echo "Word: <b>".$this->busqueda."</b> | Pattern: <b>".$this->patron."</b><br>";
		echo "<br>";

		echo "Final result: ";
		$rfinal = $coincidences*$valorLetra+$this->comparison($this->busquedaLen,$this->patronLen);
		$rfinal = $rfinal/2;
		echo $rfinal."% possibilities";
		echo "<br>";
		echo "<br>";
	}
/* End Methods */

}
/* End class analysis */
$compare=array("drink ? s","eat","food","cars");
//$busqueda = "comunity";
$pattern = "cars";
$analisis = new Analysis($compare,$pattern);
?>