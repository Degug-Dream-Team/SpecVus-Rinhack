<?php <?php class libVirtXML{public function dom2xml($h0){foreach($h0->$q1 as $g2){if($g2->hasChildNodes()){$this->dom2xml($g2);}else{if($h0->hasAttributes()&&strlen($h0->$z3)){$h0->setAttribute("nodeValue",$g2->$t4);$g2->$z3="";}}}}public function xml2json($o5,$e6=false,$e7=false){$f8=new DOMDocument();$f8->loadXML($o5);$this->dom2xml($f8);$n9=simplexml_load_string($f8->saveXML());if($e7===true){$t10=str_replace(['@','"\n"'],['','""'],json_encode($n9,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));}else{$t10=str_replace(['@','"\n"'],['','""'],json_encode($n9,JSON_NUMERIC_CHECK|JSON_UNESCAPED_SLASHES));}$b11=json_decode($t10,true);return($e6===true?$b11:$t10);}}?>