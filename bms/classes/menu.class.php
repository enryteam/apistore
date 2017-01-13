<?php
class menu{
	
	function getRole(){
		return array (
				0=>array(
						"c"=>"category",
						"flag"=>0,
				),
				1=>array(
						"c"=>"adminManager",
						"flag"=>0
				),
				2=>array(
						"c"=>"index",
						"flag"=>0
				),
				3=>array(
						"c"=>"level",
						"flag"=>0
				),
				4=>array(
						"c"=>"tag",
						"flag"=>0
				),
				5=>array(
					    "c"=>"snsitive",
						"flag"=>0
				),
				6=>array(
					    "c"=>"user",
						"flag"=>0
				),
				7=>array(
					    'c'=>'suggest',
						'flag'=>0,
				),
				8=>array(
					    'c'=>'course',
						'flag'=>0
				),
		);
	}
}