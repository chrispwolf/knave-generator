<!--
	Hi Alistair! Below is the code for the Knave generator. This file just lives on its own in a directory on my personal website, chrispwolf.com/knave.

	It's definitely kind of a rush job I did for fun, so it's probably not ideal, but I am adding a few comments to show you what stuff is.

	It's mostly executable php code, which runs on the server so by the time it hits your web browser it's just an html file. 

	Hope this is helpful!
-->

<!-- This just links to Boostrap, which is a free library of front-end code. I'm using it mostly because it has built-in css for columns and formatting, and it makes all the text a nice sans-serif. -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- This is just a simple css rule that turns the whole body white on black. -->
<style type="text/css">
	body{
	/*	background-color: #111;
		color:white;
	}*/
</style>

<!-- PHP starts here. Everything above is standard html. -->
<?php
	//Array of abilities
	$abilities = array(
		"str"=>6,
		"dex"=>6,
		"con"=>6,
		"int"=>6,
		"wis"=>6,
		"cha"=>6,
	);

	//Roll for abilities, 1-6 three times each, any roll lower than the current score becomes the score.
	foreach ($abilities as $attr => $current) {
		for($r=0; $r<3; $r++){
			$roll = rand(1, 6);
			if($roll<$current){
				$abilities[$attr] = $roll;
				$current = $roll;
			}
		}
	}

	//Armor stat, inventory slots. Array for putting randomized equipment in so we can print it to the page later.
	$armor = 11;
	$hasShield = false;
	$maxEquipment = $abilities["con"] + 10;
	$equipment = array();
	$shield = false; //use this to determine if we will try and get 2-handed melee weapons.

	//FOOD
	// start with three days of rations
	array_push($equipment, "1 Day's Rations");
	array_push($equipment, "1 Day's Rations");

	//ARMOR
	$armorRoll = rand(1,20);
	if($armorRoll >= 4 && $armorRoll <= 14){
		array_push($equipment, "Gambeson: A12 Q3");
	}elseif($armorRoll >= 15 && $armorRoll <= 19){
		array_push($equipment, "Brigandine: A13 Q3, 2 Slots");
	}elseif($armorRoll == 20){
		array_push($equipment, "Chain Armor: A14 Q3, 3 Slots");
	}

	//HElMETS & SHIELDS
	$shieldRoll = rand(1,20);
	if($shieldRoll >= 13 && $shieldRoll <= 15){
		array_push($equipment, "Helmet: Armor+1 Q1");
	}elseif($shieldRoll >= 16 && $shieldRoll <= 18){
		array_push($equipment, "Shield: Armor+1 Q1");
		$hasShield = true;
	}elseif($shieldRoll == 20){
		array_push($equipment, "Helmet: Armor+1 Q1");
		array_push($equipment, "Shield: Armor+1 Q1");
		$hasShield = true;
	}

	//Weapons
	//We start with 1 weapon. First we'll roll to see if it's a melee weapon or a ranged weapon. It's a 50/50 chance, modified by the difference between WIS and STR. So a character with higher STR is more likely to get a melee weapon. If the difference is large enough, it can become  guarantee.

	$weaponMod = $abilities["str"] - $abilities["wis"];

	$weaponRoll = rand(1,6) + $weaponMod;
	
	if($weaponRoll >= 4){
		//Melee Weapons
		// Because players normally choose weapons but I wanted the generator to assign them, I decided that if you had a shield, there is no reason you would take a two-handed weapon, so there are two sets of potential melee weapons depending on whether you 	have a helmet.
		$meleeRoll = rand(1,10);
		if($hasShield){
			if($meleeRoll <= 2){
				array_push($equipment, "Light Melee Weapon: 1d6, Q3");
			}else{
				array_push($equipment, "Medium Melee Weapon: 1d8, Q3, 2 Slots");
			}
		}else{
			if($meleeRoll <= 2){
				array_push($equipment, "Light Melee Weapon: 1d6, Q3");
			}elseif($meleeRoll<=7){
				array_push($equipment, "Medium Melee Weapon: 1d8, Q3, 2 Slots");
			}else{
				array_push($equipment, "Heavy Melee Weapon: 1d10, Q3, 2H 3 Slots");
			}
		}
	}else{
		//Ranged Weapons
		//Just randomizes weapons.
		$rangedRoll = rand(1,10);
		if($rangedRoll <=2){
			array_push($equipment, "Sling: 1d4, Q3");
		}elseif($rangedRoll <= 7){
			array_push($equipment, "Bow: 1d6, Q3, 2H, 2 Slots");
			array_push($equipment, "Quiver with 20 arrows");
		}else{
			array_push($equipment, "Crossbow: 1d8, Q3, 2H, 3 Slots");
			array_push($equipment, "Quiver with 20 quarrels");
		}
	}
	//OTHER EQUIPMENT
	//These are just recreations of the tables, followed by a random roll or two on each that pushes an item into the array we are using for starting equipment
	$dungeoneeringGear = array(
		"Rope, 50ft",
		"Pulleys",
		"Candles, 5",
		"Chain, 10ft",
		"Chalk, 10 pcs.",
		"Crowbar",
		"Tinderbox",
		"Grappling Hook",
		"Hammer",
		"Waterskin",
		"Lantern",
		"Lamp Oil",
		"Padlock",
		"Manacles",
		"Mirror",
		"Pole, 10ft",
		"Sack",
		"Tent",
		"Spikes, 5",
		"Torches, 5"
	);

	array_push($equipment, $dungeoneeringGear[array_rand($dungeoneeringGear)]);
	array_push($equipment, $dungeoneeringGear[array_rand($dungeoneeringGear)]);

	$generalGear = array(
		"Air Bladder",
		"Bear Trap",
		"Shovel",
		"Bellows",
		"Grease",
		"Saw",
		"Bucket",
		"Caltrops",
		"Chisel",
		"Drill",
		"Fishing Rod",
		"Marbles",
		"Glue",
		"Pick",
		"Hourglass",
		"Net",
		"Tongs",
		"Lockpicks",
		"Metal File",
		"Nails"
	);

	array_push($equipment, $generalGear[array_rand($generalGear)]);

	$miscGear = array(
		"Incense",
		"Sponge",
		"Lens",
		"Perfume",
		"Horn",
		"Bottle",
		"Soap",
		"Spyglass",
		"Tar Pot",
		"Twine",
		"Fake Jewels",
		"Blank Book",
		"Card Deck",
		"Dice Set",
		"Cook Pots",
		"Face Paint",
		"Whistle",
		"Instrument",
		"Quill & Ink",
		"Small Bell"
	);

	array_push($equipment, $miscGear[array_rand($miscGear)]);


	//All the traits.
	$physiques = array(
		"Athletic",
		"Brawny",
		"Corpulent",
		"Delicate",
		"Gaunt",
		"Hulking",
		"Lanky",
		"Ripped",
		"Rugged",
		"Scrawny",
		"Short",
		"Sinewy",
		"Slender",
		"Flabby",
		"Statuesque",
		"Stout",
		"Tiny",
		"Towering",
		"Willowy",
		"Wiry"
	);

	$faces = array(
		"Bloated",
		"Blunt",
		"Bony",
		"Chiseled",
		"Delicate",
		"Elongated",
		"Patrician",
		"Pinched",
		"Hawkish",
		"Broken",
		"Impish",
		"Narrow",
		"Ratlike",
		"Round",
		"Sunken",
		"Sharp",
		"Soft",
		"Square",
		"Wide",
		"Wolfish"
	);

	$skins = array(
		"Battle Scar",
		"Birthmark",
		"Burn Scar",
		"Dark",
		"Makeup",
		"Oily",
		"Pale",
		"Perfect",
		"Pierced",
		"Pockmarked",
		"Reeking",
		"Tattooed",
		"Rosy",
		"Rough",
		"Sallow",
		"Sunburned",
		"Tanned",
		"War Paint",
		"Weathered",
		"Whip Scar"
	);

	$hairs = array(
		"Bald",
		"Braided",
		"Bristly",
		"Cropped",
		"Curly",
		"Disheveled",
		"Dreadlocks",
		"Filthy",
		"Frizzy",
		"Greased",
		"Limp",
		"Long",
		"Luxurious",
		"Mohawk",
		"Oily",
		"Ponytail",
		"Silky",
		"Topknot",
		"Wavy",
		"Wispy"
	);

	$clothings = array(
		"Antique",
		"Bloody",
		"Ceremonial",
		"Decorated",
		"Eccentric",
		"Elegant",
		"Fashionable",
		"Filthy",
		"Flamboyant",
		"Stained",
		"Foreign",
		"Frayed",
		"Frumpy",
		"Livery",
		"Oversized",
		"Patched",
		"Perfumed",
		"Rancid",
		"Torn",
		"Undersized"
	);

	$virtues = array(
		"Ambitious",
		"Cautious",
		"Courageous",
		"Courteous",
		"Curious",
		"Disciplined",
		"Focused",
		"Generous",
		"Gregarious",
		"Honest",
		"Honorable",
		"Humble",
		"Idealistic",
		"Just",
		"Loyal",
		"Merciful",
		"Righteous",
		"Serene",
		"Stoic",
		"Tolerant"
	);

	$vices = array(
		"Aggressive",
		"Arrogant",
		"Bitter",
		"Cowardly",
		"Cruel",
		"Deceitful",
		"Flippant",
		"Gluttonous",
		"Greedy",
		"Irascible",
		"Lazy",
		"Nervous",
		"Prejudiced",
		"Reckless",
		"Rude",
		"Suspicious",
		"Vain",
		"Vengeful",
		"Wasteful",
		"Whiny"
	);

	$backgrounds = array(
		"an alchemist",
		"a beggar",
		"a butcher",
		"a burglar",
		"a charlatan",
		"a cleric",
		"a cook",
		"a cultist",
		"a gambler",
		"an herbalist",
		"a magician",
		"a mariner",
		"a mercenary",
		"a merchant",
		"an outlaw",
		"a performer",
		"a pickpocket",
		"a smuggler",
		"a student",
		"a tracker"
	);

	//I turned each of the misfortunes into a phrase to do the history section.
	$misfortunes = array(
		"then you were abandoned",
		"then you became addicted to something",
		"then you were blackmailed",
		"then you were condemned",
		"then you were cursed",
		"then you were defrauded",
		"then you were demoted",
		"then you were discredited",
		"then you were disowned",
		"then you were exiled",
		"then you were framed",
		"now you are haunted",
		"then you were kidnapped",
		"then you were mutilated",
		"then you became poor",
		"now you are pursued",
		"then you were rejected",
		"then you were replaced",
		"then you were robbed",
		"then you were suspected of something"
	);
	// I made up these next two just to get the fun little sentence at the end of history. "Now you're [adjective] [noun]"
	$adjectives = array(
		"a good-for-nothing",
		"a down on your luck",
		"a penniless",
		"an opportunistic",
		"a doomed",
		"a shiftless",
		"a wandering",
		"a honorless",
		"a deplorable",
		"an unemployable",
		"an ignoble",
		"an inglorious",
		"a pitiable",
		"a repugnant",
		"a damnable",
		"a picaresque",
		"an irideemable",
		"an honorless",
		"a disreputable",
		"an underequipped"
	);

	$nouns = array(
		"rogue",
		"cutpurse",
		"adventurer",
		"vagabond",
		"grave robber",
		"jack of all trades",
		"scalawag",
		"vagrant",
		"dungeoneer",
		"thug",
		"scoundrel",
		"rapscallion",
		"miscreant",
		"treasure hunter",
		"\"archaeologist\"",
		"screw up",
		"outlaw",
		"ne'er-do-well",
		"rascal",
		"ruffian",
		"thrill seeker"
	);
//Alignment
	$alignRoll = rand(1,20);
	$alignment = "Neutrality";
	if($alignRoll <= 5){
		$alignment = "Law";
	}elseif($alignRoll >= 16){
		$alignment = "Chaos";
	}
?>
<!-- The remainder of the file is just html with php "echo" statements, which just take the variables above and print them into the html-->
<div class="container" style="max-width:800px; margin-top: 80px;"> 
	<h1>A Knave</h1>
	<hr style="height:0; border-bottom:1px solid black;">
	<div class="row">
		<div class="col-md-2 col-sm-4">
			STR: <?php echo $abilities["str"] . " : " . intval($abilities["str"] + 10); ?>
		</div>
		<div class="col-md-2 col-sm-4">
			DEX: <?php echo $abilities["dex"] . " : " . intval($abilities["dex"] + 10); ?>
		</div>
		<div class="col-md-2 col-sm-4">
			CON: <?php echo $abilities["con"] . " : " . intval($abilities["con"] + 10); ?>
		</div>
		<div class="col-md-2 col-sm-4">
			INT: <?php echo $abilities["int"] . " : " . intval($abilities["int"] + 10); ?>
		</div>
		<div class="col-md-2 col-sm-4">
			WIS: <?php echo $abilities["wis"] . " : " . intval($abilities["wis"] + 10); ?>
		</div>
		<div class="col-md-2 col-sm-4">
			CHA: <?php echo $abilities["cha"] . " : " . intval($abilities["cha"] + 10); ?>
		</div>
	</div>
	<div class="row" style="margin-top: 40px;">
		<div class="col-sm-6">
			<h2>
				Getting Hurt
			</h2>
			<p>
				You have <?php echo rand(1,8); ?> hit points.
				When unarmored, your Armor is 1:11.
			</p>
			<h2 style="margin-top: 30px;">
				Equipment
			</h2>
			<p>
				You have <?php echo $abilities['con'] + 10; ?> inventory slots. You can choose from the following items to fill them. Unless otherwise noted, each item takes up one slot. 
			</p>
			<p>
				<?php 
					foreach ($equipment as $item => $name) {
						echo $name . "<br>";
					}
				?>
			</p>
		</div>
		<div class="col-sm-6">
			<h2>Traits</h2>
			Physique: <?php echo $physiques[array_rand($physiques)]; ?><br>
			Face: <?php echo $faces[array_rand($faces)]; ?><br>
			Skin: <?php echo $skins[array_rand($skins)]; ?><br>
			Hair: <?php echo $hairs[array_rand($hairs)]; ?><br>
			Clothing: <?php echo $clothings[array_rand($clothings)]; ?><br>
			Virtue: <?php echo $virtues[array_rand($virtues)]; ?><br>
			Vice: <?php echo $vices[array_rand($vices)]; ?><br>
			Alignment: <?php echo $alignment; ?>
			<h2 style="margin-top: 30px;">History</h2>
			<p>
				You used to be <?php echo $backgrounds[array_rand($backgrounds)]; ?> but <?php echo $misfortunes[array_rand($misfortunes)]; ?>.
			</p>
			<p>
				Now you're <?php echo $adjectives[array_rand($adjectives)] . " " . $nouns[array_rand($nouns)]; ?>.
			</p>
		</div>
	</div>
</div>
<footer class="container" style="text-align:center; font-size: 11px; padding:15px;">
	<a style="text-decoration: underline; color:black!important;" target="_blank" href="https://www.drivethrurpg.com/product/250888/Knave?affiliate_id=392207">Knave</a> and its awesome random tables are by Ben Milton AKA Questing Beast and you should check out his <a style="text-decoration: underline; color:black!important;" href="https://www.patreon.com/questingbeast/" target="_blank">Patreon.</a>
</footer>