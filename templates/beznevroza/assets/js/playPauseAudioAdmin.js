function togglleState(event){
    event = event || window.event
    var target = event.target || event.srcElement
    var audioTg=document.getElementById('audio'+target.id);
    if(target.className==="admin-pause-button"){
        target.className="admin-play-button";
        audioTg.pause();
    }
    else{
        target.className="admin-pause-button";
        audioTg.play();
    }
}