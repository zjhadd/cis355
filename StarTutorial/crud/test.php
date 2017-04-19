<?php
	# Here is some play with html text using php
	echo "<strong>Here is some play with html text using php</strong><br>";
	
	echo "hello world<br>\"wat it do?\" <br><br> \\ backslash backslash! \\";
	# comment
	echo '<br>hello world<br>\"wat it do?\"<br>';

	# Here are some datatypes in PHP
	$variable = 1;
	$var2 = 1.5;
	$varString = "hello, its me.";
	$varBool = false;
	$varObj = array(1,2,3); # or simply -->  = [1,2,3];
	$varNull = NULL; # not case-sensitive, can also be --> null;
	
	# Here are some expresions in PHP
	echo "<br><strong>Here are some expresions in PHP</strong><br>";
	
	echo "<br>variable + var2 equals " . ($variable + $var2);
	echo "<br>This is the array -> ";
	for ($i=0;$i<3;$i++){
		echo $varObj[$i] . ", ";
	}
	
	
	
?>