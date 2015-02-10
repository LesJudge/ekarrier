/**
 * Ékezetek eltávolítására kliens oldalon
 * Az op tömb lehet objektum, amiben a beállítások vannak felsorolva, string, ami a célelem nevét tartalmazza, 
 * illetve jquery elem, ami a célelemet jelenti. Ha üres, a cél az az elem lesz, amire ráhúzták, 
 * lásd egyéb beállítások (set)
 */
$.fn.removeAccents=function(op){
var set={
   toLower:true,                 //ha igaz, kisbetűssé alakítja a célt
   toUpper:false,                //ha igaz, nagybetűssé alakaítja a célt
   accents:"áéíóöőúüűÁÉÍÓÖŐÚÜŰ", //azok a karakterek, amiket le kell cserélni a cleared-ben megadottra
   cleared:"aeiooouuuAEIOOOUUU", //ezekre cseréli le az ékezetek. Bővíthető, hogy az itt szereplő reguláris elemeket ne cserélje (pl. \\/,\\?,\\|,& stb)
   target:null,                  //az az elem, amibe a lecserélt szöveg kerül. Stringként vagy jquery objektumként is megadható
   bind:'keypress',                //milyen műveletre reagáljon: change:ha elhagyja a forráselemet; keypress:a forráselemben gombnyomásra cserél;keyup,keydown, stb)
   onEmpty:false,                 //ha igaz, csak akkor cseréli le a célelemben található értéket, ha az üres
   delimitter:"-" 
};
if(op){if((op instanceof $)||(typeof(op)=='string')){set.target=op;}else{for(o in op){set[o]=op[o];}}}
$(this).each(function(){$(this).bind(set.bind,function(){var ta=set.target;ta=ta?(ta instanceof $?ta:$(ta)):$(this);var f=set.accents,t=set.cleared,r=$(this).val(),i=0;for(;i<f.length;++i){r=r.replace(new RegExp(f.charAt(i),'g'),t.charAt(i));}r=r.replace(new RegExp('[^'+t+'\\w\._]','g'),set.delimitter);r=set.toLower?r.toLowerCase():r;r=set.toUpper?r.toUpperCase():r;if((set.onEmpty&&!$(ta).val())||!set.onEmpty){$(ta).val(r);}});});}