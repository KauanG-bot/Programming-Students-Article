// Logica pop-up de cadastro
const activeCadastro = document.getElementById("active-cadastro");
const containerCadastro = document.getElementById("container-cadastro");
const inativeCadastro = containerCadastro.querySelector("#inative");

activeCadastro.addEventListener("click", () =>{
    containerCadastro.classList.add("active");
});

inativeCadastro.addEventListener("click" , () =>{
    containerCadastro.classList.remove("active");
});

// Logica pop-up de login
const activeLogin = document.getElementById("active-login");
const containerLogin = document.getElementById("container-login");
const inativeLogin = containerLogin.querySelector("#inative");

activeLogin.addEventListener("click", () =>{
    containerLogin.classList.add("active");
});

inativeLogin.addEventListener("click" , () =>{
    containerLogin.classList.remove("active");
});
