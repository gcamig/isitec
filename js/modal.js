document.addEventListener("DOMContentLoaded", function() {
    let modal = document.querySelector("#passModal");
    let btn = document.querySelector("#openModal");
    let span = document.querySelector(".closeModal");
    console.log(modal, btn, span)
    
    btn.addEventListener("click", function(){
        console.log("clicked");
        console.log(modal);
        // modal.style.display = "block!important";
        // console.log(modal.style.display);
        modal.classList.toggle("show");
        modal.classList.toggle("hide");
        console.log(modal.style.display);
    }) 
    
    span.addEventListener("click", function(){
        modal.classList.toggle("show");
        modal.classList.toggle("hide");
        // modal.style.display = "none!important";
        console.log(modal.style.display);
    })

    window.addEventListener("click", function(event){
        if(event.target == modal){
            modal.classList.toggle("show");
            modal.classList.toggle("hide");
            // modal.style.display = "none";
        }
    })
})
