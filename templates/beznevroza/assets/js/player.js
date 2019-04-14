var audio= document.getElementById('audio'); 
var btnPlayPause= document.getElementById('playPause');

var currentStateAudio=false; //если 1 то играет  если 0 нет
var currentAudioIconInPlaylist;
var currentAudioForPlay=null;

//audioContext
var audContext = new AudioContext();
var gainNode = audContext.createGain();
var source = audContext.createMediaElementSource(audio);
var javascriptNode = audContext.createScriptProcessor(2048, 1, 1);
javascriptNode.connect(audContext.destination);
var analyser = audContext.createAnalyser();
analyser.smoothingTimeConstant = 0.3;
analyser.fftSize = 64;
analyser.connect(javascriptNode);   

// canvas
var ctx = $("#canvas").get()[0].getContext("2d");
var gradient = ctx.createLinearGradient(0,0,0,30);
gradient.addColorStop(1,'#0e8212');
gradient.addColorStop(0.75,'#a3a51a');
gradient.addColorStop(0.25,'#f43406');
gradient.addColorStop(0,'#ffffff');


javascriptNode.onaudioprocess = function() {
    // get the average for the first channel
    var array =  new Uint8Array(analyser.frequencyBinCount);
    analyser.getByteFrequencyData(array);
    // clear the current state
    ctx.clearRect(0, 0, 1000, 325);
    // set the fill style
    ctx.fillStyle=gradient;
    drawSpectrum(array);
}


function drawSpectrum(array) {
    for ( var i = 0; i < (array.length); i++ ){
        var value = array[i];
        ctx.fillRect(i*6,(350-value)/10,4,35);
    }
};

//элементы controll panel
var controllPanelTime=document.getElementById('playerPanelTime');
var controllPanelImg=document.getElementById('playerPanelImg');
var controllPanelTitle=document.getElementById('playerPanelTitle');

var durationAudio=0;

function setParametrPlayer(id){

    // console.log('function setParametrPlayer');

    //берем данные из плейлиста и установливаем плеер
    audio.src="media/audiosessions/"+document.getElementById('href_'+id).textContent.replace('mp3','encrypted');
    //audio.src="media/audiosessions/"+document.getElementById('href_'+id).textContent.replace('ogg','encrypted');
    console.log();
    controllPanelImg.src='media/'+document.getElementById('href_img_'+id).textContent;
    controllPanelTitle.textContent=document.getElementById('caption_'+id).textContent;

}

var getDuration = function (url, next) {
    var _player = new Audio(url);
    _player.addEventListener("durationchange", function (e) {
        if (this.duration!=Infinity) {
           var duration = this.duration
           _player.remove();
            durationAudio = this.duration;
            // console.log(" getDuration  "+duration);
        };
    }, false);      
    _player.load();
    _player.currentTime = 24*60*60; //fake big time
    _player.volume = 0;
    _player.play();
    //waiting...
    // return  duration;
};

window.onload = function() {

    // загрузка колекции времени из плейлисти
    var timesInPlaylist=document.getElementsByClassName('playlist-time'); 

    // console.log('finction onload');

    var audiosForPlay = document.getElementsByClassName('next');
    if(audiosForPlay.length!=0){
        currentAudioForPlay = audiosForPlay[0];
        currentAudioForPlay.className +='playlist-list activ';
        currentAudioIconInPlaylist= document.getElementById('icon_'+currentAudioForPlay.id);
        setParametrPlayer(currentAudioForPlay.id);
        getDuration (audio.src)
    }
    else{
        console.log('нет аудио записи для воспроизведения');
    }
};

btnPlayPause.onclick=toggleState;


function play(){
    //параметры для audioContext
    source.connect(analyser);
    source.connect(gainNode);
    gainNode.connect(audContext.destination);

    audio.play();
    playPause.src="../templates/beznevroza/assets/img/player/player-icon-pause.png";
    currentAudioIconInPlaylist.src="../templates/beznevroza/assets/img/player/playlist-icon-pause.png";
    currentStateAudio=true;
}
function pause(){
    audio.pause();
    playPause.src="../templates/beznevroza/assets/img/player/player-icon-play.png";
    currentAudioIconInPlaylist.src="../templates/beznevroza/assets/img/player/playlist-icon-play.png";
    currentStateAudio=false;
}
function toggleState(){
    // console.log('finction toggleState');
    if(currentAudioForPlay!=null){
        if(!currentStateAudio){
            play();
        }
        else{
            pause();
        }
    }
}
function stop(){
    audio.pause();
    audio.currentTime = 0;
    playPause.src="../templates/beznevroza/assets/img/player/player-icon-play.png";
    currentAudioIconInPlaylist.src="../templates/beznevroza/assets/img/player/playlist-icon-play.png";
    currentStateAudio=false;
    if (sourceNode){          
        sourceNode.disconnect();
        sourceNode.stop(0);
        sourceNode = null;
    }
}
audio.addEventListener("ended", stop, true);
audio.addEventListener("canplay", function (){
    document.getElementById('load').innerHTML="";
}, true);
audio.addEventListener("timeupdate", function (){
    progress=audio.currentTime;
    controllPanelTime.textContent=gTimeFormat(progress);
    if(flag==false){
        auditioned.style.width=progress/(durationAudio/widthRels)+"px";
    }
}, true);

var gTimeFormat=function(seconds){
    var m=Math.floor(seconds/60)<10?"0"+Math.floor(seconds/60):Math.floor(seconds/60);
    var s=Math.floor(seconds-(m*60))<10?"0"+Math.floor(seconds-(m*60)):Math.floor(seconds-(m*60));
    return m+":"+s;
};

var rels=document.getElementById('rels');
var auditioned= document.getElementById('auditioned');
var begunok = document.getElementById('begunok');
var widthRels=rels.offsetWidth;
var progress;
var flag=false;
rels.onclick=function(e){
    if(flag==false){
        auditioned.style.width=e.layerX+"px" 
        progress=(durationAudio/widthRels)*e.layerX;
        if(currentStateAudio){
            pause();
            audio.currentTime=progress;
            play();
        }
        else{
            audio.currentTime=progress;
        }
    }
    else{
        flag=false;
    }
}
rels.onmouseup=function(){
    if(flag)
        flag=false;
}
rels.onmousemove=function(e){
    if(flag){
        auditioned.style.width=e.layerX+"px";
    }
}
begunok.onmousedown=function(){
    flag=true;
}
begunok.onmouseup=function(){
    if(flag){
        flag=false;
        progress=(durationAudio/widthRels)*e.layerX+"px";
        if(currentStateAudio){
            pause();
            audio.currentTime=progress;
            play();
        }
        else{
            audio.currentTime=progress;
        }
    }
}


//Звук
     var points = document.getElementById('points');
     points.onclick = function(event){
        if(event.target.id!="points"){
            var currentPoint=event.target;
            pointPosition=currentPoint.id.charAt(currentPoint.id.length-1);
            if(pointPosition<=9 && pointPosition>=0){
                var volumeValue;
                // audio.volume=0.0;
                if(currentPoint.className==="point-activ"){
                    volumeValue=10
                    for(var i=9; pointPosition<=i; i--){
                        volumeValue=Math.round(volumeValue);
                        volumeValue=volumeValue-1;
                        document.getElementById('point'+i).className="point-inactiv";
                        // gainNode.gain.setValueAtTime(volumeValue/10, audio.duration+1);
                    }
                    audio.volume=volumeValue/10;
                }
                else if(currentPoint.className==="point-inactiv"){
                    volumeValue=0
                    for(var i=0; pointPosition>=i; i++){
                        volumeValue+=1
                        document.getElementById('point'+i).className="point-activ";
                    }
                    audio.volume=volumeValue/10;
                    
                }
            }
        }
    }

// hide or show playlist
var showingPlaylistFlag=true;
function diplay_hide (blockId){ 

    if ($(blockId).css('display') == 'none') { 
        
        $(blockId).animate({height: 'show'}, 500); 
    } 
    else{     
        $(blockId).animate({height: 'hide'}, 500); 
    }
} 

// hide or show blockwindow
var showingBlockWindowsAbonimentFlag=false
function showingBlockWindowsAboniment(event){
    if(showingBlockWindowsAbonimentFlag){
        document.getElementById('black-layout-block-playlist-window').style.display="none";
        document.getElementById('block-playlist-window').style.display="none";
        showingBlockWindowsAbonimentFlag=false;
    }
    else{
        document.getElementById('black-layout-block-playlist-window').style.display="block";
        document.getElementById('block-playlist-window').style.display="block";
        var tmp=event.target.id.charAt(event.target.id.length-1)
        document.getElementById('timeInBlockWin').textContent=document.getElementById("time_interval_"+tmp).textContent;
        showingBlockWindowsAbonimentFlag=true;

    }
}

// обратный отчет в playlist
var timesInPlaylist=document.getElementsByClassName('playlist-time');

    //функция делает обратный отчет
    function timer(time){
        var tmp=time.charAt(time.length-1);
        if(tmp!=0){
            tmp=tmp-1;
            time = time.substring(0,time.length-1)+tmp
            return time;
        }
        else{
            tmp=time.charAt(time.length-2);
            if(tmp!=0){
                tmp=tmp-1;
                time = time.substring(0,time.length-2)+tmp+"9"
                return time;
            }
            else{
                tmp=time.charAt(time.length-4);
                if(tmp!=0){
                    tmp=tmp-1;
                    time = time.substring(0,time.length-4)+tmp+":59"
                    return time;
                }
                else{
                    tmp=time.charAt(time.length-5);
                    if(tmp!=0){
                        tmp=tmp-1;
                        time = time.substring(0,time.length-5)+tmp+"9:59"
                        return time;
                    }
                    else{
                        tmp=time.charAt(time.length-7);
                        if(tmp!=0){
                            tmp=tmp-1;
                            time = time.substring(0,time.length-7)+tmp+":23:59"
                            return time;
                        }
                        else{
                            tmp=time.charAt(time.length-8);
                            
                            if(tmp!=0){
                                tmp=tmp-1;
                                time = time.substring(0,time.length-8)+tmp+"9:23:59"
                                return time;
                            }
                            else{
                                location.reload()
                            }
                        }
                    }
                }
            }
        }

    }

    // начать повторы с интервалом 1 мин
    setInterval(function() {
        for(var i = 0; i < timesInPlaylist.length; i++){
            timesInPlaylist[i].textContent=timer(timesInPlaylist[i].textContent);
            // if(timesInPlaylist[i].textContent)
        }
    }, 2000);
