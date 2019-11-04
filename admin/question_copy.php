<?php

require_once('../config/dbconnect.php');	

/*$sql = "SELECT * FROM ".$db_suffix."exercise where exercise_id!='9'";
$news_query = mysqli_query($db,$sql);
while($row = mysqli_fetch_object($news_query)){
	
	$damn_var_coop=1;

	$sql1 = "SELECT * FROM ".$db_suffix."question WHERE exercise_id='$row->exercise_id'";
	$news_query1 = mysqli_query($db,$sql1);
	
	while($row1 = mysqli_fetch_object($news_query1)){
		
		mysqli_query($db, "UPDATE ".$db_suffix."question SET question_pick='".$damn_var_coop."' WHERE question_id='$row1->question_id'");
		
		$damn_var_coop++;	
	}
}
*/


$questions = array (	

"sein" => array(
		"1ps"  => "ich bin",
		"2ps"  => "du bist",
		"3ps"  => "er ist = sie ist = es ist",
		"1pp"  => "wir sind",		
		"2pp"  => "ihr seid",		
		"3pp"  => "Sie/sie sind",
	),
	"haben" => array(
		"1ps"  => "ich habe",
		"2ps"  => "du hast",
		"3ps"  => "er hat = sie hat = es hat",
		"1pp"  => "wir haben",		
		"2pp"  => "ihr habt",		
		"3pp"  => " Sie/sie haben",
	),
"werden" => array(
		"1ps"  => "ich werde",
		"2ps"  => "du wirst",
		"3ps"  => "er wird = sie wird = es wird",
		"1pp"  => "wir werden",		
		"2pp"  => "ihr werdet",		
		"3pp"  => " Sie/sie werden",
	),
"gehen" => array(
		"1ps"  => "ich gehe",
		"2ps"  => "du gehst",
		"3ps"  => "er geht = sie geht = es geht",
		"1pp"  => "wir gehen",		
		"2pp"  => "ihr geht",		
		"3pp"  => "Sie/sie gehen",
	),
"lachen" => array(
		"1ps"  => "ich lache",
		"2ps"  => "du lachst",
		"3ps"  => "er lacht = sie lacht = es lacht",
		"1pp"  => "wir lachen",		
		"2pp"  => "ihr lacht",		
		"3pp"  => "Sie/sie lachen",
	),
"lieben" => array(
		"1ps"  => "ich liebe",
		"2ps"  => "du liebst",
		"3ps"  => "er liebt = sie liebt = es liebt",
		"1pp"  => "wir lieben",		
		"2pp"  => "ihr liebt",		
		"3pp"  => "Sie/sie lieben",
	),
"weinen" => array(
		"1ps"  => "ich weine",
		"2ps"  => "du weinst",
		"3ps"  => "er weint = sie weint = es weint",
		"1pp"  => "wir weinen",		
		"2pp"  => "ihr weint",		
		"3pp"  => "Sie/sie weinen",
	),
"kaufen" => array(
		"1ps"  => "ich kaufe",
		"2ps"  => "du kaufst",
		"3ps"  => "er kauft = sie kauft = es kauft",
		"1pp"  => "wir kaufen",		
		"2pp"  => "ihr kauft",		
		"3pp"  => "Sie/sie kaufen",
	),
"spielen" => array(
		"1ps"  => "ich spiele",
		"2ps"  => "du spielst",
		"3ps"  => "er spielt = sie spielt = es spielt",
		"1pp"  => "wir spielen",		
		"2pp"  => "ihr spielt",		
		"3pp"  => "Sie/sie spielen",
	),
"danken" => array(
		"1ps"  => "ich danke",
		"2ps"  => "du dankst",
		"3ps"  => "er dankt = sie dankt = es dankt",
		"1pp"  => "wir danken",		
		"2pp"  => "ihr dankt",		
		"3pp"  => "Sie/sie danken",
	),
"diskutieren" => array(
		"1ps"  => "ich diskutiere",
		"2ps"  => "du diskutierst",
		"3ps"  => "er diskutiert = sie diskutiert = es diskutiert",
		"1pp"  => "wir diskutieren",		
		"2pp"  => "ihr diskutiert",		
		"3pp"  => "Sie/sie diskutieren",
	),
"fehlen" => array(
		"1ps"  => "ich fehle",
		"2ps"  => "du fehlst",
		"3ps"  => "er fehlt = sie fehlt = es fehlt",
		"1pp"  => "wir fehlen",		
		"2pp"  => "ihr fehlt",		
		"3pp"  => "Sie/sie fehlen",
	),
"fegen" => array(
		"1ps"  => "ich fege",
		"2ps"  => "du fegst",
		"3ps"  => "er fegt = sie fegt = es fegt",
		"1pp"  => "wir fegen",		
		"2pp"  => "ihr fegt",		
		"3pp"  => "Sie/sie fegen",
	),
"folgen" => array(
		"1ps"  => "ich folge",
		"2ps"  => "du folgst",
		"3ps"  => "er folgt = sie folgt = es folgt",
		"1pp"  => "wir folgen",		
		"2pp"  => "ihr folgt",		
		"3pp"  => "Sie/sie folgen",
	),
"fragen" => array(
		"1ps"  => "ich frage",
		"2ps"  => "du fragst",
		"3ps"  => "er fragt = sie fragt = es fragt",
		"1pp"  => "wir fragen",		
		"2pp"  => "ihr fragt",		
		"3pp"  => "Sie/sie fragen",
	),
"fotografieren" => array(
		"1ps"  => "ich fotografiere",
		"2ps"  => "du fotografierst",
		"3ps"  => "er fotografiert = sie fotografiert = es fotografiert",
		"1pp"  => "wir fotografieren",		
		"2pp"  => "ihr fotografiert",		
		"3pp"  => "Sie/sie fotografieren",
	),
"frühstücken" => array(
		"1ps"  => "ich frühstücke",
		"2ps"  => "du frühstückst",
		"3ps"  => "er frühstückt = sie frühstückt = es frühstückt",
		"1pp"  => "wir frühstücken",		
		"2pp"  => "ihr frühstückt",		
		"3pp"  => "Sie/sie frühstücken",
	),
"fühlen" => array(
		"1ps"  => "ich fühle",
		"2ps"  => "du fühlst",
		"3ps"  => "er fühlt = sie fühlt = es fühlt",
		"1pp"  => "wir fühlen",		
		"2pp"  => "ihr fühlt",		
		"3pp"  => "Sie/sie fühlen",
	),
"frieren" => array(
		"1ps"  => "ich friere",
		"2ps"  => "du frierst",
		"3ps"  => "er friert = sie friert = es friert",
		"1pp"  => "wir frieren",		
		"2pp"  => "ihr friert",		
		"3pp"  => "Sie/sie frieren",
	),
"gähnen" => array(
		"1ps"  => "ich gähne",
		"2ps"  => "du gähnst",
		"3ps"  => "er gähnt = sie gähnt = es gähnt",
		"1pp"  => "wir gähnen",		
		"2pp"  => "ihr gähnt",		
		"3pp"  => "Sie/sie gähnen",
	),
"hängen" => array(
		"1ps"  => "ich hänge",
		"2ps"  => "du hängst",
		"3ps"  => "er hängt = sie hängt = es hängt",
		"1pp"  => "wir hängen",		
		"2pp"  => "ihr hängt",		
		"3pp"  => "Sie/sie hängen",
	),
"heulen" => array(
		"1ps"  => "ich heule",
		"2ps"  => "du heulst",
		"3ps"  => "er heult = sie heult = es heult",
		"1pp"  => "wir heulen",		
		"2pp"  => "ihr heult",		
		"3pp"  => "Sie/sie heulen",
	),
"hören" => array(
		"1ps"  => "ich höre",
		"2ps"  => "du hörst",
		"3ps"  => "er hört = sie hört = es hört",
		"1pp"  => "wir hören",		
		"2pp"  => "ihr hört",		
		"3pp"  => "Sie/sie hören",
	),
"hüpfen" => array(
		"1ps"  => "ich hüpfe",
		"2ps"  => "du hüpfst",
		"3ps"  => "er hüpft = sie hüpft = es hüpft",
		"1pp"  => "wir hüpfen",		
		"2pp"  => "ihr hüpft",		
		"3pp"  => "Sie/sie hüpfen",
	),
"husten" => array(
		"1ps"  => "ich huste",
		"2ps"  => "du hustst",
		"3ps"  => "er hustt = sie hustt = es hustt",
		"1pp"  => "wir husten",		
		"2pp"  => "ihr hustt",		
		"3pp"  => "Sie/sie husten",
	),
"irren" => array(
		"1ps"  => "ich irre",
		"2ps"  => "du irrst",
		"3ps"  => "er irrt = sie irrt = es irrt",
		"1pp"  => "wir irren",		
		"2pp"  => "ihr irrt",		
		"3pp"  => "Sie/sie irren",
	),
"kauen" => array(
		"1ps"  => "ich kaue",
		"2ps"  => "du kaust",
		"3ps"  => "er kaut = sie kaut = es kaut",
		"1pp"  => "wir kauen",		
		"2pp"  => "ihr kaut",		
		"3pp"  => "Sie/sie kauen",
	),
"klopfen" => array(
		"1ps"  => "ich klopfe",
		"2ps"  => "du klopfst",
		"3ps"  => "er klopft = sie klopft = es klopft",
		"1pp"  => "wir klopfen",		
		"2pp"  => "ihr klopft",		
		"3pp"  => "Sie/sie klopfen",
	),
"leben" => array(
		"1ps"  => "ich lebe",
		"2ps"  => "du lebst",
		"3ps"  => "er lebt = sie lebt = es lebt",
		"1pp"  => "wir leben",		
		"2pp"  => "ihr lebt",		
		"3pp"  => "Sie/sie leben",
	),
"malen" => array(
		"1ps"  => "ich male",
		"2ps"  => "du malst",
		"3ps"  => "er malt = sie malt = es malt",
		"1pp"  => "wir malen",		
		"2pp"  => "ihr malt",		
		"3pp"  => "Sie/sie malen",
	),
"parken" => array(
		"1ps"  => "ich parke",
		"2ps"  => "du parkst",
		"3ps"  => "er parkt = sie parkt = es parkt",
		"1pp"  => "wir parken",		
		"2pp"  => "ihr parkt",		
		"3pp"  => "Sie/sie parken",
	),
"planen" => array(
		"1ps"  => "ich plane",
		"2ps"  => "du planst",
		"3ps"  => "er plant = sie plant = es plant",
		"1pp"  => "wir planen",		
		"2pp"  => "ihr plant",		
		"3pp"  => "Sie/sie planen",
	),
"prüfen" => array(
		"1ps"  => "ich prüfe",
		"2ps"  => "du prüfst",
		"3ps"  => "er prüft = sie prüft = es prüft",
		"1pp"  => "wir prüfen",		
		"2pp"  => "ihr prüft",		
		"3pp"  => "Sie/sie prüfen",
	),
"pusten" => array(
		"1ps"  => "ich puste",
		"2ps"  => "du pustst",
		"3ps"  => "er pustt = sie pustt = es pustt",
		"1pp"  => "wir pusten",		
		"2pp"  => "ihr pustt",		
		"3pp"  => "Sie/sie pusten",
	),
"rasen" => array(
		"1ps"  => "ich rase",
		"2ps"  => "du rasst",
		"3ps"  => "er rast = sie rast = es rast",
		"1pp"  => "wir rasen",		
		"2pp"  => "ihr rast",		
		"3pp"  => "Sie/sie rasen",
	),
"rauchen" => array(
		"1ps"  => "ich rauche",
		"2ps"  => "du rauchst",
		"3ps"  => "er raucht = sie raucht = es raucht",
		"1pp"  => "wir rauchen",		
		"2pp"  => "ihr raucht",		
		"3pp"  => "Sie/sie rauchen",
	),
"reisen" => array(
		"1ps"  => "ich reise",
		"2ps"  => "du reist",
		"3ps"  => "er reist = sie reist = es reist",
		"1pp"  => "wir reisen",		
		"2pp"  => "ihr reist",		
		"3pp"  => "Sie/sie reisen",
	),
"rollen" => array(
		"1ps"  => "ich rolle",
		"2ps"  => "du rollst",
		"3ps"  => "er rollt = sie rollt = es rollt",
		"1pp"  => "wir rollen",		
		"2pp"  => "ihr rollt",		
		"3pp"  => "Sie/sie rollen",
	),

"sagen" => array(
		"1ps"  => "ich sage",
		"2ps"  => "du sagst",
		"3ps"  => "er sagt = sie sagt = es sagt",
		"1pp"  => "wir sagen",		
		"2pp"  => "ihr sagt",		
		"3pp"  => "Sie/sie sagen",
	),
"schauen" => array(
		"1ps"  => "ich schaue",
		"2ps"  => "du schaust",
		"3ps"  => "er schaut = sie schaut = es schaut",
		"1pp"  => "wir schauen",		
		"2pp"  => "ihr schaut",		
		"3pp"  => "Sie/sie schauen",
	),
"schicken" => array(
		"1ps"  => "ich schicke",
		"2ps"  => "du schickst",
		"3ps"  => "er schickt = sie schickt = es schickt",
		"1pp"  => "wir schicken",		
		"2pp"  => "ihr schickt",		
		"3pp"  => "Sie/sie schicken",
	),
"spucken" => array(
		"1ps"  => "ich spucke",
		"2ps"  => "du spuckst",
		"3ps"  => "er spuckt = sie spuckt = es spuckt",
		"1pp"  => "wir spucken",		
		"2pp"  => "ihr spuckt",		
		"3pp"  => "Sie/sie spucken",
	),
"stellen" => array(
		"1ps"  => "ich stelle",
		"2ps"  => "du stellst",
		"3ps"  => "er stellt = sie stellt = es stellt",
		"1pp"  => "wir stellen",		
		"2pp"  => "ihr stellt",		
		"3pp"  => "Sie/sie stellen",
	),
"stören" => array(
		"1ps"  => "ich störe",
		"2ps"  => "du störst",
		"3ps"  => "er stört = sie stört = es stört",
		"1pp"  => "wir stören",		
		"2pp"  => "ihr stört",		
		"3pp"  => "Sie/sie stören",
	),
"suchen" => array(
		"1ps"  => "ich suche",
		"2ps"  => "du suchst",
		"3ps"  => "er sucht = sie sucht = es sucht",
		"1pp"  => "wir suchen",		
		"2pp"  => "ihr sucht",		
		"3pp"  => "Sie/sie suchen",
	),
"surfen" => array(
		"1ps"  => "ich surfe",
		"2ps"  => "du surfst",
		"3ps"  => "er surft = sie surft = es surft",
		"1pp"  => "wir surfen",		
		"2pp"  => "ihr surft",		
		"3pp"  => "Sie/sie surfen",
	),
"tanzen" => array(
		"1ps"  => "ich tanze",
		"2ps"  => "du tanzt",
		"3ps"  => "er tanzt = sie tanzt = es tanzt",
		"1pp"  => "wir tanzen",		
		"2pp"  => "ihr tanzt",		
		"3pp"  => "Sie/sie tanzen",
	),
"teilen" => array(
		"1ps"  => "ich teile",
		"2ps"  => "du teilst",
		"3ps"  => "er teilt = sie teilt = es teilt",
		"1pp"  => "wir teilen",		
		"2pp"  => "ihr teilt",		
		"3pp"  => "Sie/sie teilen",
	),
"trennen" => array(
		"1ps"  => "ich trenne",
		"2ps"  => "du trennst",
		"3ps"  => "er trennt = sie trennt = es trennt",
		"1pp"  => "wir trennen",		
		"2pp"  => "ihr trennt",		
		"3pp"  => "Sie/sie trennen",
	),
"üben" => array(
		"1ps"  => "ich übe",
		"2ps"  => "du übst",
		"3ps"  => "er übt = sie übt = es übt",
		"1pp"  => "wir üben",		
		"2pp"  => "ihr übt",		
		"3pp"  => "Sie/sie üben",
	),
"zahlen" => array(
		"1ps"  => "ich zahle",
		"2ps"  => "du zahlst",
		"3ps"  => "er zahlt = sie zahlt = es zahlt",
		"1pp"  => "wir zahlen",		
		"2pp"  => "ihr zahlt",		
		"3pp"  => "Sie/sie zahlen",
	),
"zeigen" => array(
		"1ps"  => "ich zeige",
		"2ps"  => "du zeigst",
		"3ps"  => "er zeigt = sie zeigt = es zeigt",
		"1pp"  => "wir zeigen",		
		"2pp"  => "ihr zeigt",		
		"3pp"  => "Sie/sie zeigen",
	),
"arbeiten" => array(
		"1ps"  => "ich arbeite",
		"2ps"  => "du arbeitest",
		"3ps"  => "er arbeitet = sie arbeitet = es arbeitet",
		"1pp"  => "wir arbeiten",		
		"2pp"  => "ihr arbeitet",		
		"3pp"  => "Sie/sie arbeiten",
	),
"töten" => array(
		"1ps"  => "ich töte",
		"2ps"  => "du tötest",
		"3ps"  => "er tötet = sie tötet = es tötet",
		"1pp"  => "wir töten",		
		"2pp"  => "ihr tötet",		
		"3pp"  => "Sie/sie töten",
	),
"tötesten" => array(
		"1ps"  => "ich töte",
		"2ps"  => "du tötest",
		"3ps"  => "er tötet = sie tötet = es tötet",
		"1pp"  => "wir töten",		
		"2pp"  => "ihr tötet",		
		"3pp"  => "Sie/sie töten",
	),
"leugnen" => array(
		"1ps"  => "ich leugne",
		"2ps"  => "du leugnest",
		"3ps"  => "er leugnet = sie leugnet = es leugnet",
		"1pp"  => "wir leugnen",		
		"2pp"  => "ihr leugnet",		
		"3pp"  => "Sie/sie leugnen",
	),
"mieten" => array(
		"1ps"  => "ich miete",
		"2ps"  => "du mietest",
		"3ps"  => "er mietet = sie mietet = es mietet",
		"1pp"  => "wir mieten",		
		"2pp"  => "ihr mietet",		
		"3pp"  => "Sie/sie mieten",
	),
"pusten" => array(
		"1ps"  => "ich puste",
		"2ps"  => "du pustest",
		"3ps"  => "er pustet = sie pustet = es pustet",
		"1pp"  => "wir pusten",		
		"2pp"  => "ihr pustet",		
		"3pp"  => "Sie/sie pusten",
	),
"husten" => array(
		"1ps"  => "ich huste",
		"2ps"  => "du hustest",
		"3ps"  => "er hustet = sie hustet = es hustet",
		"1pp"  => "wir husten",		
		"2pp"  => "ihr hustet",		
		"3pp"  => "Sie/sie husten",
	),
"leiten" => array(
		"1ps"  => "ich leite",
		"2ps"  => "du leitest",
		"3ps"  => "er leitet = sie leitet = es leitet",
		"1pp"  => "wir leiten",		
		"2pp"  => "ihr leitet",		
		"3pp"  => "Sie/sie leiten",
	),
"beten" => array(
		"1ps"  => "ich bete",
		"2ps"  => "du betest",
		"3ps"  => "er betet = sie betet = es betet",
		"1pp"  => "wir beten",		
		"2pp"  => "ihr betet",		
		"3pp"  => "Sie/sie beten",
	),
"zeichnen" => array(
		"1ps"  => "ich zeichne",
		"2ps"  => "du zeichnest",
		"3ps"  => "er zeichnet = sie zeichnet = es zeichnet",
		"1pp"  => "wir zeichnen",		
		"2pp"  => "ihr zeichnet",		
		"3pp"  => "Sie/sie zeichnen",
	),
"landen" => array(
		"1ps"  => "ich lande",
		"2ps"  => "du landest",
		"3ps"  => "er landet = sie landet = es landet",
		"1pp"  => "wir landen",		
		"2pp"  => "ihr landet",		
		"3pp"  => "Sie/sie landen",
	),
"ordnen" => array(
		"1ps"  => "ich ordne",
		"2ps"  => "du ordnest",
		"3ps"  => "er ordnet = sie ordnet = es ordnet",
		"1pp"  => "wir ordnen",		
		"2pp"  => "ihr ordnet",		
		"3pp"  => "Sie/sie ordnen",
	),
"reiten" => array(
		"1ps"  => "ich reite",
		"2ps"  => "du reitest",
		"3ps"  => "er reitet = sie reitet = es reitet",
		"1pp"  => "wir reiten",		
		"2pp"  => "ihr reitet",		
		"3pp"  => "Sie/sie reiten",
	),
"reiten" => array(
		"1ps"  => "ich reite",
		"2ps"  => "du reitest",
		"3ps"  => "er reitet = sie reitet = es reitet",
		"1pp"  => "wir reiten",		
		"2pp"  => "ihr reitet",		
		"3pp"  => "Sie/sie reiten",
	),
"retten" => array(
		"1ps"  => "ich rette",
		"2ps"  => "du rettest",
		"3ps"  => "er rettet = sie rettet = es rettet",
		"1pp"  => "wir retten",		
		"2pp"  => "ihr rettet",		
		"3pp"  => "Sie/sie retten",
	),
"starten" => array(
		"1ps"  => "ich starte",
		"2ps"  => "du startest",
		"3ps"  => "er startet = sie startet = es startet",
		"1pp"  => "wir starten",		
		"2pp"  => "ihr startet",		
		"3pp"  => "Sie/sie starten",
	),
"testen" => array(
		"1ps"  => "ich teste",
		"2ps"  => "du testest",
		"3ps"  => "er testet = sie testet = es testet",
		"1pp"  => "wir testen",		
		"2pp"  => "ihr testet",		
		"3pp"  => "Sie/sie testen",
	),
"warten" => array(
		"1ps"  => "ich warte",
		"2ps"  => "du wartest",
		"3ps"  => "er wartet = sie wartet = es wartet",
		"1pp"  => "wir warten",		
		"2pp"  => "ihr wartet",		
		"3pp"  => "Sie/sie warten",
	),
"baden" => array(
		"1ps"  => "ich bade",
		"2ps"  => "du badest",
		"3ps"  => "er badet = sie badet = es badet",
		"1pp"  => "wir baden",		
		"2pp"  => "ihr badet",		
		"3pp"  => "Sie/sie baden",
	),
"reden" => array(
		"1ps"  => "ich rede",
		"2ps"  => "du redest",
		"3ps"  => "er redet = sie redet = es redet",
		"1pp"  => "wir reden",		
		"2pp"  => "ihr redet",		
		"3pp"  => "Sie/sie reden",
	),
"spenden" => array(
		"1ps"  => "ich spende",
		"2ps"  => "du spendest",
		"3ps"  => "er spendet = sie spendet = es spendet",
		"1pp"  => "wir spenden",		
		"2pp"  => "ihr spendet",		
		"3pp"  => "Sie/sie spenden",
	),
"melden" => array(
		"1ps"  => "ich melde",
		"2ps"  => "du meldest",
		"3ps"  => "er meldet = sie meldet = es meldet",
		"1pp"  => "wir melden",		
		"2pp"  => "ihr meldet",		
		"3pp"  => "Sie/sie melden",
	),

);


$exercise_id=117;

$sql="INSERT INTO ".$db_suffix."question (question_pick, question_desc, question_type, question_marks, question_answer, exercise_id, user_id, question_case, question_group, question_status) VALUES ";

foreach($questions as $rest => $value)
{	
		$question_pick=trim($rest);
		
		$question_marks=6;
		
		if(empty($question_pick)){
			
			while(1){
				
				$question_pick="";
				
				$question_pick=mt_rand(1, 1000);
				$dd = mysqli_query($db, "select question_id from ".$db_suffix."question where exercise_id='$exercise_id' AND question_pick='$question_pick'");

				if(mysqli_num_rows($dd)<=0)
				
					break;					
			}
		}	
		
		
		
		$infinitiv = trim($rest);
		
		$ps1 = trim($value["1ps"]);
		
		$ps2 = trim($value["2ps"]);
		
		$ps3 = "er, sie, es ".str_replace("er ", "", trim(explode('=', $value["3ps"])[0]));
		
		$pp1 = trim($value["1pp"]);
		
		$pp2 = trim($value["2pp"]);
		
		$pp3 = trim($value["3pp"]);
		
		
		$question_answer_infinitiv = $ps1. ' + '.$pp1.' + '.$ps2.' + '.$pp2.' + '.$ps3.' + '.$pp3 ;
		
		$question_answer_ps1 = $infinitiv.' + '.$pp1.' + '.$ps2.' + '.$pp2.' + '.$ps3.' + '.$pp3 ;

		$question_answer_ps2 = $infinitiv.' + '.$ps1. ' + '.$pp1.' + '.$pp2.' + '.$ps3.' + '.$pp3 ;
		
		$question_answer_ps3 = $infinitiv.' + '.$ps1. ' + '.$pp1.' + '.$ps2.' + '.$pp2.' + '.$pp3 ;
		
		$question_answer_pp1 = $infinitiv.' + '.$ps1. ' + '.$ps2.' + '.$pp2.' + '.$ps3.' + '.$pp3 ;
		
		$question_answer_pp2 = $infinitiv.' + '.$ps1. ' + '.$pp1.' + '.$ps2.' + '.$ps3.' + '.$pp3 ;
		
		$question_answer_pp3 = $infinitiv.' + '.$ps1. ' + '.$pp1.' + '.$ps2.' + '.$pp2.' + '.$ps3 ;
		
		
		
		
		$question_desc_infinitiv='
		
		<table class="table">
	<thead>
		<tr>
			<td class="text-center" colspan="3"><sub><strong>Infinitv</strong></sub>&nbsp;&nbsp;'.$infinitiv.'</td>
		</tr>
		<tr>
			<td width="18%">&nbsp;</td>
			<td width="41%"><sub><strong>Singular</strong></sub></td>
			<td width="41%"><sub><strong>Plural</strong></sub></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="18%"><sub><strong>1. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>2. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>3. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
	</tbody>
</table>
';

		$question_desc_ps1='
		
		<table class="table">
	<thead>
		<tr>
			<td class="text-center" colspan="3"><sub><strong>Infinitv</strong></sub>&nbsp;&nbsp;<input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%">&nbsp;</td>
			<td width="41%"><sub><strong>Singular</strong></sub></td>
			<td width="41%"><sub><strong>Plural</strong></sub></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="18%"><sub><strong>1. Person</strong></sub></td>
			<td width="41%">&nbsp;&nbsp;&nbsp;'.$ps1.'</td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>2. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>3. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
	</tbody>
</table>
';

		$question_desc_ps2='
		
		<table class="table">
	<thead>
		<tr>
			<td class="text-center" colspan="3"><sub><strong>Infinitv</strong></sub>&nbsp;&nbsp;<input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%">&nbsp;</td>
			<td width="41%"><sub><strong>Singular</strong></sub></td>
			<td width="41%"><sub><strong>Plural</strong></sub></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="18%"><sub><strong>1. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>2. Person</strong></sub></td>
			<td width="41%">&nbsp;&nbsp;&nbsp;'.$ps2.'</td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>3. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
	</tbody>
</table>
';

		$question_desc_ps3='
		
		<table class="table">
	<thead>
		<tr>
			<td class="text-center" colspan="3"><sub><strong>Infinitv</strong></sub>&nbsp;&nbsp;<input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%">&nbsp;</td>
			<td width="41%"><sub><strong>Singular</strong></sub></td>
			<td width="41%"><sub><strong>Plural</strong></sub></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="18%"><sub><strong>1. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>2. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>3. Person</strong></sub></td>
			<td width="41%">&nbsp;&nbsp;&nbsp;'.$ps3.'</td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
	</tbody>
</table>
';
		
		$question_desc_pp1='
		
		<table class="table">
	<thead>
		<tr>
			<td class="text-center" colspan="3"><sub><strong>Infinitv</strong></sub>&nbsp;&nbsp;<input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%">&nbsp;</td>
			<td width="41%"><sub><strong>Singular</strong></sub></td>
			<td width="41%"><sub><strong>Plural</strong></sub></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="18%"><sub><strong>1. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%">&nbsp;&nbsp;&nbsp;'.$pp1.'</td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>2. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>3. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
	</tbody>
</table>
';
		
		$question_desc_pp2='
		
		<table class="table">
	<thead>
		<tr>
			<td class="text-center" colspan="3"><sub><strong>Infinitv</strong></sub>&nbsp;&nbsp;<input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%">&nbsp;</td>
			<td width="41%"><sub><strong>Singular</strong></sub></td>
			<td width="41%"><sub><strong>Plural</strong></sub></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="18%"><sub><strong>1. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>2. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%">&nbsp;&nbsp;&nbsp;'.$pp2.'</td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>3. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
	</tbody>
</table>
';


		$question_desc_pp3='
		
		<table class="table">
	<thead>
		<tr>
			<td class="text-center" colspan="3"><sub><strong>Infinitv</strong></sub>&nbsp;&nbsp;<input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%">&nbsp;</td>
			<td width="41%"><sub><strong>Singular</strong></sub></td>
			<td width="41%"><sub><strong>Plural</strong></sub></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="18%"><sub><strong>1. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>2. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
		</tr>
		<tr>
			<td width="18%"><sub><strong>3. Person</strong></sub></td>
			<td width="41%"><input autocomplete="off" class="form-control input-sm" name="question" size="20" type="text" /></td>
			<td width="41%">&nbsp;&nbsp;&nbsp;'.$pp3.'</td>
		</tr>
	</tbody>
</table>
';
		
		
		
		$sql.= "('$question_pick', '".$question_desc_infinitiv."', 'Fill in the gap', '$question_marks', '$question_answer_infinitiv', '$exercise_id', '1', '1', 'einfach', '1'), ";
		
		$sql.= "('$question_pick', '".$question_desc_ps1."', 'Fill in the gap', '$question_marks', '$question_answer_ps1', '$exercise_id', '1', '1', 'einfach', '1'), ";
		
		$sql.= "('$question_pick', '".$question_desc_ps2."', 'Fill in the gap', '$question_marks', '$question_answer_ps2', '$exercise_id', '1', '1', 'einfach', '1'), ";
		
		$sql.= "('$question_pick', '".$question_desc_ps3."', 'Fill in the gap', '$question_marks', '$question_answer_ps3', '$exercise_id', '1', '1', 'einfach', '1'), ";
		
		$sql.= "('$question_pick', '".$question_desc_pp1."', 'Fill in the gap', '$question_marks', '$question_answer_pp1', '$exercise_id', '1', '1', 'einfach', '1'), ";
		
		$sql.= "('$question_pick', '".$question_desc_pp2."', 'Fill in the gap', '$question_marks', '$question_answer_pp2', '$exercise_id', '1', '1', 'einfach', '1'), ";
		
		$sql.= "('$question_pick', '".$question_desc_pp3."', 'Fill in the gap', '$question_marks', '$question_answer_pp3', '$exercise_id', '1', '1', 'einfach', '1'), ";		
	
}

$sql=substr($sql, 0, -2);

mysqli_query($db, $sql);



?>