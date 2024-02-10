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
    passwordError.textContent = "Weak password";
  } else if (strength <= 3) {
    passwordError.textContent = "Medium password ";
  } else if (strength <= 5) {
    passwordError.textContent = "Strong password ";
  }
}

function checkConPassword() {
  var password = document.getElementById("confirmpass").value;
  var passwordd = document.getElementById("pass").value;
  const cpasswordError = document.getElementById("cpassword-error");

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
  } else if (strength <= 1) {
    cpasswordError.textContent = "Weak password";
  } else if (strength <= 3) {
    cpasswordError.textContent = "Medium password ";
  } else if (strength <= 5) {
    cpasswordError.textContent = "Strong password ";
    if (password.length != passwordd.length) {
      cpasswordError.textContent = "Strong password but it still doesnt match";
    } else if (password.length > passwordd.length) {
      cpasswordError.textContent = "Password doesnt match";
    } else if (password == passwordd) {
      cpasswordError.textContent = "Correct password";
    }
  }
}

function checkEmail() {
  const emailInput = document.getElementById("email");
  const emailError = document.getElementById("email-error");

  if (!emailInput.checkValidity()) {
    emailError.textContent = "Please enter a valid email address";
    return;
  } else {
    emailError.textContent = "";
  }
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "check-email2.php");
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
  } else {
    phoneError.textContent = "";
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
  xhr.open("POST", "check-username2.php");
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
function confirmSubmit() {
  var result = confirm("Are you sure you want to submit this form?");
  return result;
}

function confirmSubmitD() {
  var result = confirm("Are you sure you want to delete your account?");
  return result;
}
const passwordInput = document.getElementById("pass");
const cpasswordInput = document.getElementById("confirmpass");
const showCPasswordToggle = document.getElementById("show-cpassword-toggle");
const showPasswordToggle = document.getElementById("show-password-toggle");

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
