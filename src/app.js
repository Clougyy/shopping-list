const listeE = document.querySelector(".liste");
const archiveE = document.querySelector(".archive");
const items = document.querySelectorAll(".item");
const add = document.querySelectorAll(".add");
const addbutton = document.querySelector("button");
const addInput = document.querySelector(".add input");
const reset = document.querySelector(".reset_b");

reset.addEventListener('click',function(){
    archive = []
    $.get( "list.php?del=1");
    update_list();
});

$.get( "list.php?get_lists=1", function( data ) {
    js = JSON.parse(data);
    liste = js[0].reverse();
    archive = js[1].reverse();
    update_list();


    addbutton.addEventListener('click',function(){
        liste.unshift(addInput.value);
        $.get( "list.php?add="+addInput.value);
        addInput.value='';
        update_list();
    });
    
    addInput.addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            liste.unshift(addInput.value);
            $.get( "list.php?add="+addInput.value);
            addInput.value='';
            update_list();
        }
    });

  });


function update_list(){
    if (liste.length == 0){
        listeE.style.display = "none";
    }else{
        listeE.style.display = "block";
    }

    if (archive.length == 0){
        archiveE.style.display = "none";
        reset.style.display = "none";
    }else{
        archiveE.style.display = "block";
        reset.style.display = "block";
    }

    listeE.innerHTML="";
    archiveE.innerHTML="";
    liste.forEach(element =>{
        var cb = document.createElement("div");
        cb.className = "item";
        var inP = document.createElement("input");
        inP.type = "checkbox";

        inP.addEventListener('change', function(){
            $.get( "list.php?switch=toarchive&item="+element);
            liste = liste.filter(function(item) {
                return item !== element;
            });
            archive.unshift(element);
            update_list();
        });
        
        var naM = document.createElement("div");
        naM.className='name';
        naM.innerHTML=element;
        cb.appendChild(inP);
        cb.appendChild(naM);
        listeE.appendChild(cb);
    });


    archive.forEach(element =>{
        var cb = document.createElement("div");
        cb.className = "item";
        var inP = document.createElement("input");
        inP.type = "checkbox";
        inP.checked  = true;
        
        inP.addEventListener('change', function(){
            $.get( "list.php?switch=reset&item="+element);
            archive = archive.filter(function(item) {
                return item !== element;
            });
            liste.unshift(element);
            update_list();
        });
        
        var naM = document.createElement("div");
        naM.className='name';
        naM.style.textDecoration = 'line-through';
        naM.innerHTML=element;
        cb.appendChild(inP);
        cb.appendChild(naM);
        archiveE.appendChild(cb);
    });
    
}


