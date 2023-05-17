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

      if(dateType === "intervention"){
         // Charger le contenu du json via AJAX
         const xhr = new XMLHttpRequest();
         xhr.onload = function () {
             if (xhr.status == 200) {
                 const data = JSON.parse(xhr.responseText);

                 newFields = document.createElement("div");
                 newFields.classList.add("date-fields");
                 newFields.setAttribute("data", dateType);

                 // Label du select
                 let interventionLabel = document.createElement("label");
                 interventionLabel.htmlFor = "intervention";
                 interventionLabel.textContent = "Formation : ";
                 newFields.appendChild(interventionLabel);

                 //élément Select avec formateurs
                 let selectIntervention = document.createElement("select");
                 selectIntervention.name = "intervention[]";
                 interventionLabel.appendChild(selectIntervention);

                 //Option de départ
                 let defaultOption = document.createElement("option");
                 defaultOption.disabled = true;
                 defaultOption.setAttribute("selected", "");
                 defaultOption.textContent = "Choisir une formation";
                 selectIntervention.appendChild(defaultOption);

                 data.forEach(formation => {
                     let option = document.createElement("option");
                     option.value = formation.id_formation;
                     option.textContent = formation.nom_formation;
                     selectIntervention.appendChild(option)
                 });

                 // Concaténation de la chaine de caractères avec le reste des create elements
                 newFields.innerHTML += `
                 <label for="date-debut-${dateType}"> Date de début d'${dateType} :
                 <input name="date-debut-${dateType}[]" type="date">
                 </label>
                 <label for="date-fin-${dateType}"> Date de fin d'${dateType} :
                 <input name="date-fin-${dateType}[]" type="date">
                 </label>
                 <button class="delete-date-fields" type="button" data="${dateType}">Supprimer période ${dateType}</button>
                  `;
                 newDateBtn.before(newFields);

             }

             let deleteButtons = document.querySelectorAll(".delete-date-fields");
             Array.from(deleteButtons).forEach(function (deleteBtn) {
                 deleteBtn.addEventListener("click", () => {
                     let fields = deleteBtn.parentNode;

                     if (fields) {
                         fields.remove();
                     }
                 });
             });

         };
         xhr.open('GET', '/planning/public/admin/modifierFormateur?id=0');
         xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
         xhr.send();

      }
      else{
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
      };
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


