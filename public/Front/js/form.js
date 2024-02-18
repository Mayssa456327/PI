// JavaScript
const userTypeSelect = document.getElementById("userType");
const patientFields = document.querySelector(".patient-fields");
const medecinFields = document.querySelector(".medecin-fields");

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
