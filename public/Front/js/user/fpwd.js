function checkEmail() {
  var myInput = document.getElementById("myInput");
  //   myInput.disabled = true;
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
      if (!response.exists) {
        emailError.textContent = "Email does not exist";
      } else {
        myInput.disabled = false;

        emailError.textContent = "";
      }
    }
  };
  xhr.send(`email=${emailInput.value}`);
}
function checkPassword() {
  var password = document.getElementById("password").value;
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
  var myInput = document.getElementById("myInput");
  myInput.disabled = true;

  var password = document.getElementById("password").value;
  var passwordd = document.getElementById("cpassword").value;
  const cpasswordError = document.getElementById("cpassword-error");

  var strength = 0;
  if (passwordd.length >= 8) {
    strength++;
  }
  if (passwordd.match(/[a-z]/)) {
    strength++;
  }
  if (passwordd.match(/[A-Z]/)) {
    strength++;
  }
  if (passwordd.match(/[0-9]/)) {
    strength++;
  }
  if (passwordd.match(/[$@#&!]/)) {
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
    if (password.length != passwordd.length) {
      cpasswordError.textContent = "Strong password but it still doesnt match";
    } else if (password.length < passwordd.length) {
      cpasswordError.textContent = "Password doesnt match";
    } else if (password == passwordd) {
      cpasswordError.textContent = "Correct password";
      myInput.disabled = false;
    }
  }
}
