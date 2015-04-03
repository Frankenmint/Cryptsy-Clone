<?php
/**
 * PHP Security Auditor
 * ====================
 *
 * Security settings are defined in php.xml - change them to meet your needs
 * or requirements then use the scanner to ensure you are continuing to comply
 * with them.
 *
 * http://www.idontplaydarts.com
 *
 * @date 20/02/2010
 * @author phil taylor
 *
 */

class Audit {

	static private $rules;
	static private $constants;
	static private $phpVer;

	static public $report;

	/**
	 * Converts settings such as 1M 1G 1K to their byte equivilent values
	 *
	 * @param string $n
	 * @return string
	 */
	static private function convertToBytes($n) {

			// If n is -1 then there is no limit
    		if ($n == -1)
    			return PHP_INT_MAX;

    		switch (substr($n, -1)) {
                    case "B": return substr($n,0,-1);
 		    		case "K": return substr($n,0,-1) * 1024;
                    case "M": return substr($n,0,-1) * 1024 * 1024;
                    case "G": return substr($n,0,-1) * 1024 * 1024 * 1024;
            }
            return $n;
    	}

	static private function MakeReport($type, $title) {

			ksort(self::$report[$type]);

    		$html = '<h1>' . $title . '</h1><table><tr class="h"><th>Setting</th><th>Current</th><th>Recomended</th><th>Description</th></tr>';
	    	foreach(self::$report[$type] as $key => $values)
	    	{
	    		if ($values['p'] == 1) $class="r";
	    		else $class="v";

				$html .= '<tr><td class="e">' . htmlentities($key) . '</td>' .
					 '<td class="'. $class .'">' . htmlentities($values['c']) . '</td>' .
					 '<td class="'. $class .'">' . htmlentities($values['r']) . '</td>' .
					 '<td class="'. $class .'">' . htmlentities($values['d']) . '</td></tr>';
	    	}
	    	$html .= '</table>';

			return $html;
	}


    static public function HTMLReport()
    	{
    		$class = "";

    		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">' .
					'<html><head>' .
    				'<link rel="stylesheet" type="text/css" media="all" href="style.css"/>' .
    				'</head><body>';

    		$html .= self::MakeReport("ini", "PHP INI");
    		$html .= self::MakeReport("disabled", "PHP Disabled Functions");
    		$html .= self::MakeReport("const", "PHP CONST");

	    	$html .= '</html>';

	    	echo($html . "\n");
	}

   	/**
   	* Adds an item to the reporting array.
   	*
   	* @param string $type - the type (ini or const)
   	* @param string $key - the name of the variable
   	* @param string $currentValue - the current ini or const value
   	* @param string $recomended - the recomended value
   	* @param string $desc - a description of the issue
   	* @param boolean $problem - true if not complaint, false if compliant
   	*/
	static private function Report($type, $key, $currentValue, $recomended, $desc, $problem)
	{
		if (isset(self::$report[$type][$key]))
			if ((self::$report[$type][$key]['r'] < $recomended)
				&& (self::$report[$type][$key['p']] == 1))
					return;

		self::$report[$type][$key] = array(
									"c" => $currentValue,
									"r" => $recomended,
									"d" => $desc,
									"p" => $problem
								);
	}

	/**
	 * Loads the rules from an XML file
	 *
	 * @param string $file
	 */
	static public function LoadRules($file = "php.xml")
	{

				if (!defined('PHP_VERSION_ID'))
				{
					$version = explode(".", PHP_VERSION);
					self::$phpVer =  ($version[0] * 10000 + $version[1] * 100 + $version[2]);
				} else
					self::$phpVer = PHP_VERSION_ID;

				self::$constants = get_defined_constants();
				self::$rules = simplexml_load_file($file);
	}

	/**
	 * Processes the XML ruleset against const and ini values found in PHP
	 *
	 */
	static public function ProcessXML() {

				foreach(self::$rules as $null => $entry) {
					$ruleID = $entry->attributes()->id;

					// Check the version of PHP the rule applies to

					$version = (string)$entry->version;

					if ($version != "") {

						$op = (string)$entry->version->attributes()->op;

						switch ($op) {
							case 'before':
								if ($version < self::$phpVer)
									continue 2;
							break;
						}
					}

					// Evaluate the rule as we are sure it applys to the version of PHP running

					switch((string)$entry->type)
					{
						// Look at CONST values in PHP
						case "const":

							$key 	= (string)$entry->key;	// e.g LIBXML_NOENT
							$cValue = self::$constants[$key];	// The current value
							$rValue = (string)$entry->value;	// The recomended value
							$desc	= (string)$entry->description;	// Description

							switch((string)$entry->value->attributes()->op)
							{
								case "eq":
										self::Report("const", $key, $cValue, $rValue, $desc, ($cValue == $rValue) ? 0 : 1);
								break;
							}

						break;

						// Check the list of functions that should be restricted

						case "disable_functions":

							$disabled = ini_get("disable_functions");
							$list = explode(",", $disabled);

							$xmlList = (array)($entry->list);
							$xmlList = $xmlList['function'];

							foreach($xmlList as $null => $function) {
								$de = array_search($function, $list);
								self::Report("disabled", $function, (($de == 0) ? "enabled" : "disabled"), "disabled", "", (($de == 0) ? 1 : 0));
							}

						break;

						// Look at values defined within the INI files

						case "ini":

							$key 	= (string)$entry->key; // e.g. display_errors
							$cValue = trim(self::convertToBytes(ini_get($key))); // Current value
							$rValue = (string)$entry->value;	// Recomended value
							$desc	= (string)$entry->description; // Description

							if (is_numeric($rValue) && $cValue == "") $cValue = "0";

							// Deals with where one value should be compared to another

							if ((string)$entry->value->attributes()->type == "key")
								$rValue = self::convertToBytes(ini_get((string)$entry->value));

							switch((string)$entry->value->attributes()->op)
							{
								// Equal to
								case "eq":
									self::Report("ini", $key, $cValue, $rValue, $desc, ($cValue == $rValue) ? 0 : 1);
								break;

								// Less than or equal to
								case "lt":
									self::Report("ini", $key, $cValue, "< $rValue", $desc, ($cValue <= $rValue) ? 0 : 1);
								break;

								// Greater than or equal to
								case "gt":
									self::Report("ini", $key, $cValue, "> $rValue", $desc, ($cValue >= $rValue) ? 0 : 1);
								break;

								// Not equal to
								case "ne":
									$neValue  = (string)$entry->value->attributes()->net;
									$notBlank = (string)$entry->value->attributes()->notblank;


									if ($notBlank == "true") {
										self::Report("ini", $key, $cValue, $rValue, $desc, ($cValue != "") ? 0 : 1);
										break;
									}

									self::Report("ini", $key, $cValue, $rValue, $desc, ($cValue != $neValue) ? 0 : 1);
								break;

							}

						break;
					}

				}

	}


}

Audit::LoadRules();
Audit::ProcessXML();
Audit::HTMLReport();
