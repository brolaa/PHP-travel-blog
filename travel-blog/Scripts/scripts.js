//funkcja javascript do liczenia znaków w textarea
function countChars(obj, maxLength, id) { 
    //znaki filtrowane przez php
    const punct = "&\'\"<>";
    let strCount = 0;
    
    for(let i = 0; i < obj.value.length; i++){
        if(punct.includes(obj.value[i])){ //znaki filtrowane przez php
            strCount+=5;
        } else if (obj.value[i]==='\n') { //znak nowej linii
            strCount+=10;
        } else {
            strCount++;
        }
    };
    
    if(strCount > maxLength){
        document.getElementById(id).innerHTML = '<span style="color: red;">' + strCount + '/' + maxLength + '</span>';
    }else{
        document.getElementById(id).innerHTML = strCount + '/' + maxLength;
    }
}

