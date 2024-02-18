const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
const userTypeSelect = document.getElementById("userType");
const patientFields = document.querySelector(".patient-fields");
const medecinFields = document.querySelector(".medecin-fields");

// sign in
sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

// Contrôler l'affichage des champs de formulaire en fonction du type d'utilisateur sélectionné
userTypeSelect.addEventListener("change", () => {
    const userType = userTypeSelect.value;

    // Masquer tous les champs spécifiques
    patientFields.classList.add("hidden");
    medecinFields.classList.add("hidden");

    // Afficher les champs spécifiques en fonction du type d'utilisateur sélectionné
    if (userType === "patient") {
        patientFields.classList.remove("hidden");
    } else if (userType === "medecin") {
        medecinFields.classList.remove("hidden");
    }
});

// Sign in End
let menu = document.querySelector("#menu-bars");
let navbar = document.querySelector(".navbar");
const scrollButton = document.querySelector(".scroll-top");

menu.onclick = () => {
  navbar.classList.toggle("active");
  menu.classList.toggle("fa-times");
};

window.onscroll = () => {
  navbar.classList.remove("active");
  menu.classList.remove("fa-times");
};

scrollButton.addEventListener("click", () => {
  window.scrollTo(0, 0);
});
