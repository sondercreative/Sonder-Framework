<?php
/********************************************************\
|********************************************************|

	The script below will generate a spread of 18 colour
	choices of varying lightness and darkness based on 
	originally defined colour. Each number represents a 
	5% jump in brightness
	
	The colours range from 1 to 19, where 1 will be the
	lightest colour, and 19 being the darkest. 10 will 
	be the originally entered colour.
	
	IE $pc = #ff0000;
	
	$p1 = #ff7373 - Light red, 50% to white
	$p19 = #8c0000 - Dark Red, 50% to black
	
	The numeric variables can be used directly on any
	file this file is included on. For ease of use, I've
	added in generic dark and light variables for all 
	colours ($pl - Primary Light, $sd - secondary dark).
	

|********************************************************|
\********************************************************/
	include ("../../../../wp-load.php");//needed to get access to the wp functions file
	$mods = css_to_var(array('primary_color','secondary_color','tertiary_color')); // pulls the three colour choices from the wordpress theme customize menu.
		$pc =$mods[0];
		$sc = $mods[1];
		$tc = $mods[2];
		$colorArr = array(array('p',$mods[0]),array('s',$mods[1]),array('t',$mods[2])); // pulling the colours and a designator into an array
	if($colorArr!=''){
		foreach($colorArr as $colors){
			$state = $colors[0];
			$color = $colors[1];//making a clean variable out of the array data
			if($color!=''){
				$d=20;
				$l=0;		//counting designators for the variables
				for($x=-0.5;$x>=-1;$x=$x-0.05){//
					$v = round($x,2);	
					$k = (-$v)*100;	// MATH! :D 
					${$state.$d} = colourBrightness($color,$v); // creating the actual variable using the state [p,s,t] and the counting designator. 
					$d--;
				}
				for($x=0.5;$x<=1;$x=$x+0.05){
					$v = round($x,2);
					$k =(($v*100));	// YAAAAY MATH :D
					${$state.$l} = colourBrightness($color,$v); // creating the actual variable using the state [p,s,t] and the counting designator. 
					$l++;
				}
				${$state.'10'}= $color; //not necessary but a just in case kind of thing
			}
		}
	}
	// setting the numberic varibles to something less unique.
	$pl = $p8; 
	$pd = $p12;
	$sl = $s8;
	$sd = $s12;
	$tl = $t6;
	$td = $t12;
/********************************************************\
|********************************************************|
	END COLOUR GENERATION SCRIPT
|********************************************************|
\********************************************************/

$lineHeight = '1.5em';
$fontSize = '15px';
$textColor = '#777';

$font1 = "'Raleway', sans-serif";
$font2 = "'Raleway', sans-serif";
	
?>