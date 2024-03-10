//Logica pop-up//
const active = document.getElementById("active");
const inative = document.getElementById("inative");
const container = document.getElementById("container");

active.addEventListener("click", () =>{
    container.classList.add("active");
})

inative.addEventListener("click" , () =>{
    container.classList.remove("active");
});


