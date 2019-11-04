function animateValue(id, start, end, duration) {

    // check for commas
    var isComma = /[0-9]+,[0-9]+/.test(end); 
    //end = end.replace(/,/g, '');

    // assumes integer values for start and end

    var obj = document.getElementById(id);
    var range = end - start;
    // no timer shorter than 50ms (not really visible any way)
    var minTimer = 50;
    // calc step time to show all interediate values
    var stepTime = Math.abs(Math.floor(duration / range));

    // never go below minTimer
    stepTime = Math.max(stepTime, minTimer);

    // get current time and calculate desired end time
    var startTime = new Date().getTime();
    var endTime = startTime + duration;
    var timer;

    function run() {
        var now = new Date().getTime();
        var remaining = Math.max((endTime - now) / duration, 0);
        var value = Math.round(end - (remaining * range));
        obj.innerHTML = value;
        if (value == end) {
            clearInterval(timer);
        }
        // Preserve commas if input had commas
        if (isComma) {
            while (/(\d+)(\d{3})/.test(value.toString())) {
                value = value.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
        }
    }

    var timer = setInterval(run, stepTime);
    run();
}

function getRandomizer(bottom, top) {

	return Math.floor( Math.random() * ( 1 + top - bottom ) ) + bottom;
    
}


var lsgwoerter_used=[];
var  points=0;
var used_words=0;

var random = getRandomizer( 0, lsgwoerter.length-1 ); 
var lsgwort = lsgwoerter[random]; // the word to guess will be chosen from the array above
var lsgwort_w_space = lsgwort;
lsgwort=lsgwort.replace(" ", "");

var myarr = lsgwort.split(":");
lsgwort=myarr[0];
var hint=myarr[1];
$(".hints").empty();
$(".hints").html(hint);

var ratewort = new Array(lsgwort.length);
var fehler = 0;

// every letter in the word is symbolized by an underscore in the guessfield
for (var i = 0; i < ratewort.length; i++){
	ratewort[i] = "_ ";
}

// prints the guessfield
function printRatewort(){
	
	var ratefeld = document.getElementById("ratefeld");
	ratefeld.innerHTML = "";
	
	for (var i = 0; i < ratewort.length; i++){
	var ratefeld = document.getElementById("ratefeld");
	var buchstabe = document.createTextNode(ratewort[i]);	
	ratefeld.appendChild(buchstabe);
	}
	if(lsgwort_w_space.indexOf(" ")!=-1){
		var a=ratefeld.innerHTML;
		var b="&nbsp;&nbsp;";
		var position=lsgwort_w_space.indexOf(" ")*2;	
		var output = a.substr(0, position) + b + a.substr(position);
		ratefeld.innerHTML=output;
	}
}

//checks if the the letter provided by the user matches one or more of the letters in the word
var pruefeZeichen = function(){
	var f = document.rateformular; 
	var b = f.elements["ratezeichen"]; 
	var zeichen = b.value; // the letter provided by the user
	//zeichen = zeichen.toLowerCase();
	var to_match="";
	//console.log(zeichen);
	for (var i = 0; i < lsgwort.length; i++){
		
		to_match=lsgwort[i];
		to_match=to_match.toLowerCase();	
		
		if(to_match === zeichen.toLowerCase()){
			ratewort[i] = lsgwort[i] + " ";
			var treffer = true;
		}
	b.value = "";
	}
	
	//deletes the guessfield and replaces it with the new one
	var ratefeld = document.getElementById("ratefeld");
	ratefeld.innerHTML=""; 
	printRatewort();
	
	//checks if all letters have been found
	var fertig = true;
	for (var i = 0; i < ratewort.length; i++){
		if(ratewort[i] === "_ "){
			fertig = false;
		}
	}
	
	// if a guessed letter is not in the word, the letter will be put on the "wrong letters"-list and hangman grows
	if(!treffer && fehler<=6 && fertig==false){
		var gerateneBuchstaben = document.getElementById("gerateneBuchstaben");
		var buchstabe = document.createTextNode(" " + zeichen);
		gerateneBuchstaben.appendChild(buchstabe); 
		fehler++;
		var hangman = document.getElementById("hangman");
		
		if(fehler<=6)
			
			hangman.src = $('.SITE_URL').val()+"hangman_source/hangman" + fehler + ".png";
	}
	
	if(fertig){
		
		$('#success').modal('show');
		
		setTimeout(function(){

		$('#success').modal('hide');
		
		animateValue("value", 1, points+1, 1000);
			
		points++;
		
		}, 2000);
		
		used_words++;
		
		if(used_words<lsgwoerter.length){
			lsgwoerter_used.push(lsgwort+":"+hint);
			lsgwoerter.splice(random,1);
			random = getRandomizer( 0, lsgwoerter.length-1 ); 
			lsgwort = lsgwoerter[random];
			lsgwort_w_space = lsgwort;
			lsgwort=lsgwort.replace(" ", "");			
		}
		else{		
			random = getRandomizer( 0, lsgwoerter_used.length-1 ); 
			lsgwort = lsgwoerter_used[random];
			lsgwort_w_space = lsgwort;
			lsgwort=lsgwort.replace(" ", "");
		}
		//alert(lsgwoerter_used[random]);
		myarr = lsgwort.split(":");
		lsgwort=myarr[0];
		hint=myarr[1];
		$(".hints").empty();
		$(".hints").html(hint);
		$(".points").empty();
		$(".points").html(points);
		
		ratewort = new Array(lsgwort.length);
		fehler = 0;
		
		var hangman = document.getElementById("hangman");
		hangman.src = $('.SITE_URL').val()+"hangman_source/hangman0.png";
		
		var gerateneBuchstaben = document.getElementById("gerateneBuchstaben");
		gerateneBuchstaben.innerHTML="Falsche Antworten:";
		
		for (var i = 0; i < ratewort.length; i++){
			ratewort[i] = "_ ";
		}
		
		setTimeout(function(){

			printRatewort();
				
		}, 3000);		
	}
	
	//once you got six wrong letters, you lose
	if(fehler >= 6){
		$('#dead').modal('show');
		
		setTimeout(function(){

		$('#dead').modal('hide');
		
		}, 3000);
		
		setTimeout(function(){
			var ratefeld = document.getElementById("ratefeld");
			ratefeld.innerHTML = lsgwort.substr(0, 3) + "&nbsp;&nbsp;" + lsgwort.substr(3);		
		}, 3000);	
		$.ajax({
			   type: "POST",
			   url:  $('.SITE_URL').val()+"hangman_source/save_data.php",
			   dataType: "text",
			   data: {score: points},
			   success: function(data){		
					//window.location.reload(true);
			   }								   		   		
		  });
	}
}

function init(){
	printRatewort();
}

window.onload = init;