<?php
function escape($string){
	//always return;
	return htmlentities($string,ENT_QUOTES,'UTF-8');
}
