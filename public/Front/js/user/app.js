const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

// sign in
sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
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
