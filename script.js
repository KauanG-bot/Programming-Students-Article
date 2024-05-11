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


// Lógica para abrir o pop-up de cadastro quando clicar no link "Cadastre-se" no pop-up de login
const linkCadastreSe = document.getElementById("link-cadastre-se");

linkCadastreSe.addEventListener("click", () => {
    // Remove a classe 'active' do pop-up de login
    containerLogin.classList.remove("active");
    
    // Adiciona a classe 'active' ao pop-up de cadastro
    containerCadastro.classList.add("active");
});

// Lógica para fechar o pop-up de cadastro
inativeCadastro.addEventListener("click", () => {
    // Fecha o pop-up de cadastro
    containerCadastro.classList.remove("active");
});

// Lógica para fechar o pop-up de login
inativeLogin.addEventListener("click", () => {
    // Fecha o pop-up de login
    containerLogin.classList.remove("active");
});

const linkLogin = document.getElementById("link-login");

linkLogin.addEventListener("click", () => {
    // Remove a classe 'active' do pop-up de cadastro
    containerCadastro.classList.remove("active");
    
    // Adiciona a classe 'active' ao pop-up de login
    containerLogin.classList.add("active");
});

// Lógica para fechar o pop-up de cadastro
inativeCadastro.addEventListener("click", () => {
    // Fecha o pop-up de cadastro
    containerCadastro.classList.remove("active");
});

// Lógica para fechar o pop-up de login
inativeLogin.addEventListener("click", () => {
    // Fecha o pop-up de login
    containerLogin.classList.remove("active");
});

// Lógica para abrir o pop-up de login quando clicar no link de postagem
const postLink = document.querySelector("Post");

postLink.addEventListener("click", () => {
    // Remove a classe 'active' do pop-up de cadastro (se estiver aberto)
    containerCadastro.classList.remove("active");

    // Adiciona a classe 'active' ao pop-up de login
    containerLogin.classList.add("active");
});

// Lógica para fechar o pop-up de login
inativeLogin.addEventListener("click", () => {
    // Fecha o pop-up de login
    containerLogin.classList.remove("active");
});
