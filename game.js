var score;            //uncovered cells
var available=false;  //boolean value to check if it's possible to uncover a cell or not 
var time;             //seconds since game is started
var firstSet=true;    // enable observe methods just once
var timer = null;      

function Shuffle() {
    time=0;
    available=true;
    clearInterval (timer);
    timer = setInterval(function(){ time++; if (available){  $("timer").innerHTML = "You started " + time + " seconds ago"; }
                                        else { $("timer").innerHTML= ""; }
                                    if (!available) clearInterval(timer);}, 1000);
    score = 0;
    var scorePar = $("score");
    scorePar.innerHTML = "Your score is 0/85";
    var fields = document.getElementsByTagName("td"); //all the cells
    var bombs = [];                                //boolean values, rapresents is the cells are empty or with the bomb
    for (var i = 0; i < 100; i++) {
        bombs.push(false);                 //initially all the cells are empty
        fields[i].innerHTML = "";            //initially all the cells are unknown
        fields[i].className = "cell";
    }

    for (var i = 0; i < 15; i++) {             //choosing random cells with the bomb
        var randrows = parseInt(Math.random() * 10);
        var randcol = parseInt(Math.random() * 10);
        if (bombs[randrows * 10 + randcol]) {
            i--;           //if a cell already has a bomb, take another one
        } else {
            bombs[randrows * 10 + randcol] = true;   //tenths rapresents the rows, units the columns
        }
    }
    if (firstSet) {
         firstSet=false;
         secondPart(bombs);        
    }
}

function secondPart(bombs) {             //every cell is available to be clicked
    var fields = document.getElementsByTagName("td");
    for (var i = 0; i < fields.length; i++) { 
         fields[i].observe('dblclick', function() {uncover(bombs, this.id);});
         fields[i].className= "cell";
         fields[i].observe('click', function(){
                                           if (this.innerHTML.localeCompare("B")== 0 && available){
                                                     this.innerHTML = "";
                                                     this.className= "cell";
                                           }else if (this.innerHTML.localeCompare("")== 0 && available){
                                                         this.innerHTML = "B"; 
                                                         this.className = "bomb";
                                            }
                                    });
    }
}

function uncover(bombs, ident) {
    var thisField = $(ident);
    if ((thisField.innerHTML.localeCompare("") == 0 || thisField.innerHTML.localeCompare("B") == 0) && (available)){ //you can't uncover a non-empty cell  
                                                                                                                                                                                                      
        var idNumber = parseInt(ident.substring(5));    //taking away "field" from id to get the number  
        var scorePar = $("score");
        if (!bombs[idNumber]) {                         //if you  clicked over a free cell
            thisField.className="checked";
            neighbours = countMines(bombs, ident);
            thisField.innerHTML = neighbours;
            if (neighbours == 0){                       //uncover the cells around a 0 neighbours bombs cell
              //  thisField.className = "noNeighbours";   
                freeAround (bombs, ident);
            }
            score++;
            if (score != 85 ) {
                var stringScore = "Your score is " + score.toString() + "/85";
                scorePar.innerHTML = stringScore;
            } else {
                available=false;
                scorePar.innerHTML = "You won in " + time + " seconds!";
                var winAudio = new Audio ('audio/win.mp3');
                winAudio.play();
            } 
      
         } else {      //if you clicked over a bomb
               if (score == 0) {     //you can't die at the first try
                   Shuffle();                       
               }else {
                    available=false;               
                    thisField.innerHTML = ":(";    
                    var audio = new Audio('audio/ab.mp3');
                    audio.play();
                    scorePar.innerHTML = "You lost noob!";
               }
         }
    }
}


function countMines(bombs, ident) {
    total = 0;
    cell = $(ident);
    var idNumber = parseInt(ident.substring(5));
    if (idNumber - 11 >= 0 && idNumber % 10 != 0)   //checking if the neighbour exist
        if (bombs[idNumber - 11]) {
            total++;
        }
    if (idNumber - 10 >= 0)
        if (bombs[idNumber - 10]) {
            total++;
        }
    if (idNumber - 9 >= 0 && idNumber % 10 != 9)
        if (bombs[idNumber - 9]) {
            total++;
        }

    if (idNumber - 1 >= 0 && idNumber % 10 != 0)
        if (bombs[idNumber - 1]) {
            total++;
        }

    if (idNumber + 1 <= 99 && idNumber % 10 != 9)
        if (bombs[idNumber + 1]) {
            total++;
        }

    if (idNumber + 9 <= 99 && idNumber % 10 != 0)
        if (bombs[idNumber + 9]) {
            total++;
        }

    if (idNumber + 10 <= 99)
        if (bombs[idNumber + 10]) {
            total++;
        }

    if (idNumber + 11 <= 99 && idNumber % 10 != 9)
        if (bombs[idNumber + 11]) {
            total++;
        }

    return total;
}
function freeAround(bombs, ident){
    var idNumber = parseInt(ident.substring(5));
    var newIdent;
    var neighCell;

    if (idNumber - 11 >= 0 && idNumber % 10 != 0){  //if top-right neighbour exists
        if (idNumber -11 < 10) newIdent = "frame0" + (idNumber -11);
        else newIdent = "frame"+ (idNumber -11);
        neighCell= $(newIdent);
        if (neighCell.innerHTML.localeCompare("")== 0)
            uncover(bombs, newIdent);
    }

    if (idNumber - 10 >= 0){
        if (idNumber -10 < 10) newIdent = "frame0" + (idNumber -10);
        else newIdent = "frame" +(idNumber - 10);
        neighCell= $(newIdent);
        if (neighCell.innerHTML.localeCompare("")== 0)
            uncover(bombs, newIdent);
    }
 
    if (idNumber - 9 >= 0 && idNumber % 10 != 9){
        if (idNumber -9 < 10) newIdent = "frame0" + (idNumber -9);
        else newIdent = "frame" +(idNumber - 9);
        neighCell= $(newIdent);
        if (neighCell.innerHTML.localeCompare("")== 0)
            uncover(bombs, newIdent);
    }

    if (idNumber - 1 >= 0 && idNumber % 10 != 0){
        if (idNumber -1 < 10) newIdent = "frame0" + (idNumber -1);
        else newIdent = "frame" + (idNumber - 1);
        neighCell= $(newIdent);
        if (neighCell.innerHTML.localeCompare("")== 0)
            uncover(bombs, newIdent);
    }

    if (idNumber + 1 <= 99 && idNumber % 10 != 9){
        if (idNumber +1 < 10) newIdent = "frame0" + (idNumber + 1);
        else newIdent = "frame" + (idNumber + 1);
        neighCell= $(newIdent);
        if (neighCell.innerHTML.localeCompare("")== 0)
            uncover(bombs, newIdent);
    }

    if (idNumber + 9 <= 99 && idNumber % 10 != 0){
        if (idNumber +9 < 10) newIdent = "frame0" + (idNumber + 10);
        else newIdent = "frame" + (idNumber + 9);
        neighCell= $(newIdent);
        if (neighCell.innerHTML.localeCompare("")== 0)
            uncover(bombs, newIdent);
    }

    if (idNumber + 10 <= 99){
        newIdent = "frame" + (idNumber + 10);
        neighCell= $(newIdent);
        if (neighCell.innerHTML.localeCompare("")== 0)
            uncover(bombs, newIdent);
    }
 
    if (idNumber + 11 <= 99 && idNumber % 10 != 9){
        newIdent= "frame" + (idNumber + 11);
        neighCell= $(newIdent);
        if (neighCell.innerHTML.localeCompare("")== 0)
            uncover(bombs, newIdent);
    } 
}
