document.addEventListener("DOMContentLoaded", () => {
  const $form = document.querySelector("form");
  const $name = document.querySelector("#name");
  const $email = document.querySelector("#email");
  const $email_repeat = document.querySelector("#email_repeat");
  const $password = document.querySelector("#password");
  const $nameError = document.querySelector(".name-error");
  const $emailError = document.querySelector(".email-error");
  const $email_repeatError = document.querySelector(".email-repeat-error");
  const $passwordError = document.querySelector(".password-error");

  const getValidations = ({ name, email, email_repeat, password }) => {
    let nameIsValid = false;
	let emailIsValid = false;
	let email_repeatIsValid = false;
    let passwordIsValid = false;
	
	if (name !== "") {
      nameIsValid = true;
    }

    if (email !== "" &&
      /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)
    ) {
      emailIsValid = true;
    }
	
	if (email == email_repeat) {
      email_repeatIsValid = true;
    }

    if (password !== "" && password.length > 6) {
      passwordIsValid = true;
    }

    return {
	  nameIsValid,
      emailIsValid,
	  email_repeatIsValid,
      passwordIsValid,
    };
  };

  $form.addEventListener("submit", (e) => {
    e.preventDefault();
    const { name, email, email_repeat, password } = e.target.elements;
    const values = {
	  name: name.value,
      email: email.value,
	  email_repeat: email_repeat.value,
      password: password.value,
    };
    const validations = getValidations(values);
	
	if (!validations.nameIsValid) {
      $name.classList.add("is-invalid");
      $nameError.classList.remove("d-none");
    } else {
      $name.classList.remove("is-invalid");
      $nameError.classList.add("d-none");
    }
	
    if (!validations.emailIsValid) {
      $email.classList.add("is-invalid");
      $emailError.classList.remove("d-none");
    } else {
      $email.classList.remove("is-invalid");
      $emailError.classList.add("d-none");
    }
	
	if (!validations.email_repeatIsValid) {
      $email_repeat.classList.add("is-invalid");
      $email_repeatError.classList.remove("d-none");
    } else {
      $email_repeat.classList.remove("is-invalid");
      $email_repeatError.classList.add("d-none");
    }

    if (!validations.passwordIsValid) {
      $password.classList.add("is-invalid");
      $passwordError.classList.remove("d-none");
    } else {
      $password.classList.remove("is-invalid");
      $passwordError.classList.add("d-none");
    }

    if (validations.nameIsValid && validations.emailIsValid && validations.email_repeatIsValid && validations.passwordIsValid) {
      $form.submit();
    }
  });

  $nameError.classList.add("d-none");
  $emailError.classList.add("d-none");
  $email_repeatError.classList.add("d-none");
  $passwordError.classList.add("d-none");
});