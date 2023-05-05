addEventListener('DOMContentLoaded', () => {
  const dateFinContratInput = document.getElementById('fin');
  typeContratSelect = document.getElementById('type_contrat');

  typeContratSelect.addEventListener('change', (event) => {
    if (event.target.value === 'CDI') {
      dateFinContratInput.disabled = true;
    } else {
      dateFinContratInput.disabled = false;
    }
  });


  let newFields;
  let newDateBtn = document.querySelector(".add-date-fields");

    newDateBtn.addEventListener("click", () => {

      let dateType = newDateBtn.getAttribute("data");

      newFields = document.createElement("div");
      newFields.classList.add("date-fields");
      newFields.setAttribute("data", dateType);
      newFields.innerHTML = `
                      <label for="date-debut-${dateType}"> Date de début de la période d'${dateType} :
                      <input name="date-debut-${dateType}[]" type="date">
                      </label>
                      <label for="date-fin-${dateType}"> Date de fin de la période d'${dateType} :
                      <input name="date-fin-${dateType}[]" type="date">
                      </label>
                      <button class="delete-date-fields" type="button" data="${dateType}">Supprimer la période d'${dateType}</button>
                  `;
      newDateBtn.before(newFields);

      let deleteButtons = document.querySelectorAll(".delete-date-fields");
      Array.from(deleteButtons).forEach(function (deleteBtn) {
        deleteBtn.addEventListener("click", () => {
          let fields = deleteBtn.parentNode;

          if (fields) {
            fields.remove();
          }
        });
      });
    });
  });



// function submitForm(event) {
//     const nomValid = checkNomValidity();
//     const prenomValid = checkPrenomValidity();
//     const emailValid = checkMailValidity();
//     const Error = document.getElementById("error");
//     if (!nomValid || !prenomValid || !emailValid) {
//       event.preventDefault(); // Empêche la soumission du formulaire
//       Error.textContent = "Veuillez entrer des chose valide.";
//     }
// }
//     function checkNomValidity() {
//       const nomInput = document.getElementById("nom-input");
//       const nomError = document.getElementById("error");
//       const name = nomInput.value;
//       const regex = /^[a-zA-Zàáâäãåçèéêëìíîïðòóôöõøùúûüýÿ\-\'\s]+$/;
//       if (regex.test(name)) {
//         nomInput.style.border = "2px solid green";
//         nomError.textContent = "";
//       } else {
//         nomInput.style.border = "2px solid red";
//         nomError.textContent = "Veuillez entrer un nom valide.";
//       }
//     }

//     function checkPrenomValidity() {
//       const prenomInput = document.getElementById("prenom-input");
//       const prenomError = document.getElementById("error");
//       const prenom = prenomInput.value;
//       const regex = /^[a-zA-Zàáâäãåçèéêëìíîïðòóôöõøùúûüýÿ\-\'\s]+$/;
//       if (regex.test(prenom)) {
//         prenomInput.style.border = "2px solid green";
//         prenomError.textContent = "";
//       } else {
//         prenomInput.style.border = "2px solid red";
//         prenomError.textContent = "Veuillez entrer un prenom valide.";
//       }
//     }

//     function checkMailValidity() {
//       const mailInput = document.getElementById("mail-input");
//       const mailError = document.getElementById("error");
//       const mail = mailInput.value;
//       const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//       if (regex.test(mail)) {
//         mailInput.style.border = "2px solid green";
//         mailError.textContent = "";
//       } else {
//         mailInput.style.border = "2px solid red";
//         mailError.textContent = "Veuillez entrer une adresse email valide.";
//       }
//     }


