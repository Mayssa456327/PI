function checkPassword() {
  var password = document.getElementById("pass").value;
  const passwordError = document.getElementById("password-error");
  var strength = 0;
  if (password.length >= 8) {
    strength++;
  }
  if (password.match(/[a-z]/)) {
    strength++;
  }
  if (password.match(/[A-Z]/)) {
    strength++;
  }
  if (password.match(/[0-9]/)) {
    strength++;
  }
  if (password.match(/[$@#&!]/)) {
    strength++;
  }
  if (strength == 0) {
    passwordError.textContent =
      "Most contain 8 caracters : at least one Uppercase , one lowercase ,one number and one symbole ";
  } else if (strength <= 1) {
    passwordError.textContent =
      "Most contain 8 caracters : at least one Uppercase , one lowercase ,one number and one symbole ";
    document.getElementById("pw").className = "weak";
    document.getElementById("pass").className = "weak";
  } else if (strength <= 3) {
    passwordError.textContent =
      "Most contain 8 caracters : at least one Uppercase , one lowercase ,one number and one symbole ";
    document.getElementById("pw").className = "medium";
    document.getElementById("pass").className = "medium";
  } else if (strength <= 5) {
    passwordError.textContent = "Strong password ";

    document.getElementById("pw").className = "strong";
    document.getElementById("pass").className = "strong";
  }
}

function checkConPassword() {
  var password = document.getElementById("confirmpass").value;
  var passwordd = document.getElementById("pass").value;
  const cpasswordError = document.getElementById("cpassword-error");

  // if (password != passwordd) {

  //     document.getElementById("pww").className = "weak";
  //     document.getElementById("confirmpass").className = "weak";
  //     // alert("THE pwd doesnt match.");
  // }

  var strength = 0;
  if (password.length >= 8) {
    strength++;
  }
  if (password.match(/[a-z]/)) {
    strength++;
  }
  if (password.match(/[A-Z]/)) {
    strength++;
  }
  if (password.match(/[0-9]/)) {
    strength++;
  }
  if (password.match(/[$@#&!]/)) {
    strength++;
  }
  if (strength == 0) {
    cpasswordError.textContent =
      "Most contain 8 caracters : at least one Uppercase , one lowercase ,one number and one symbole ";
    document.getElementById("pww").className = "";
    document.getElementById("confirmpass").className = "";
  } else if (strength <= 1) {
    document.getElementById("pww").className = "weak";
    document.getElementById("confirmpass").className = "weak";
    document.getElementById("icone").className = "stable";
  } else if (strength <= 3) {
    document.getElementById("pww").className = "medium";
    document.getElementById("confirmpass").className = "medium";
  } else if (strength <= 5 && password == passwordd) {
    cpasswordError.textContent = "Correct password";

    document.getElementById("pww").className = "strong";
    document.getElementById("confirmpass").className = "strong";
  } else if (password.length > passwordd.length) {
    cpasswordError.textContent = "Password doesnt match";

    document.getElementById("pww").className = "weak";
    document.getElementById("confirmpass").className = "weak";
  } else if (password.length < passwordd.length) {
    cpasswordError.textContent = "Strong password but it still doesnt match";

    document.getElementById("pww").className = "weak";
    document.getElementById("confirmpass").className = "weak";
  }
}

function checkUsername() {
  const usernameInput = document.getElementById("username");
  const usernameError = document.getElementById("username-error");

  // Check if the username is empty
  if (usernameInput.value.trim().length === 0) {
    usernameError.textContent = "Username cannot be empty";
    return;
  } else {
    usernameError.textContent = "";
  }
  const hasLetter = /[a-zA-Z]/.test(usernameInput.value);
  if (!hasLetter) {
    usernameError.textContent = "Username must contain at least one letter";
    return;
  } else {
    usernameError.textContent = "";
  }
  // Make an AJAX request to check if the username already exists
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "check-username.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.exists) {
        usernameError.textContent = "Username already taken";
      } else {
        usernameError.textContent = "";
      }
    }
  };
  xhr.send(`username=${usernameInput.value}`);
}

function checkEmail() {
  const emailInput = document.getElementById("email");
  const emailError = document.getElementById("email-error");

  if (!emailInput.checkValidity()) {
    // if (emailInput.length() > 7) {
    emailError.textContent = "Please enter a valid email address";
    return;
    // }
  }

  // Make an AJAX request to check if the username already exists
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "check-email.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.exists) {
        emailError.textContent = "Email already taken";
      } else {
        emailError.textContent = "";
      }
    }
  };
  xhr.send(`email=${emailInput.value}`);
}

function checkPhone() {
  const phoneInput = document.getElementById("mob");
  const phoneError = document.getElementById("phone-error");

  if (
    phoneInput.value.length < 8 ||
    phoneInput.value.length > 11 ||
    !/^\d+$/.test(phoneInput.value)
  ) {
    // if the length is greater than 11 or if it contains any letters

    phoneError.textContent = "Invalid phone number";
    return;
  }
  // Make an AJAX request to check if the username already exists
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "check-phone.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.exists) {
        phoneError.textContent = "Phone number already taken";
      } else {
        phoneError.textContent = "";
      }
    }
  };
  xhr.send(`mob=${phoneInput.value}`);
}
const passwordInput = document.getElementById("pass");
const cpasswordInput = document.getElementById("confirmpass");
const showCPasswordToggle = document.getElementById("show-cpassword-togglel");
const showPasswordToggle = document.getElementById("show-password-togglel");

showPasswordToggle.addEventListener("click", function () {
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    showPasswordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
  } else {
    passwordInput.type = "password";
    showPasswordToggle.innerHTML = '<i class="fas fa-eye"></i>';
  }
});

showCPasswordToggle.addEventListener("click", function () {
  if (cpasswordInput.type === "password") {
    cpasswordInput.type = "text";
    showCPasswordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
  } else {
    cpasswordInput.type = "password";
    showCPasswordToggle.innerHTML = '<i class="fas fa-eye"></i>';
  }
});
