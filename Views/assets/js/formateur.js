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
  let addBtn = document.querySelectorAll(".add-date-fields");

  Array.from(addBtn).forEach(function (newDateBtn) {
    newDateBtn.addEventListener("click", () => {
      let dateType = newDateBtn.getAttribute("data");

      if (dateType === "intervention") {
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
        xhr.open('GET', '/planning/public/index.php?p=admin/modifierFormateur&?id=0');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send();

      }
      else if(dateType === "autre"){
        newFields = document.createElement("div");
        newFields.classList.add("date-fields");
        newFields.setAttribute("data", dateType);
        newFields.innerHTML = `
                        <label for="intitule-${dateType}"> Intitulé :
                        <input name="intitule-${dateType}[]" type="text">
                        </label>
                        <label for="date-debut-${dateType}"> Date de début de la période de ${dateType} :
                        <input name="date-debut-${dateType}[]" type="date">
                        </label>
                        <label for="date-fin-${dateType}"> Date de fin de la période de ${dateType} :
                        <input name="date-fin-${dateType}[]" type="date">
                        </label>
                        <button class="delete-date-fields" type="button" data="${dateType}">Supprimer la période de ${dateType}</button>
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
      }
      else {
        newFields = document.createElement("div");
        newFields.classList.add("date-fields");
        newFields.setAttribute("data", dateType);
        newFields.innerHTML = `
                        <label for="date-debut-${dateType}"> Date de début de la période de ${dateType} :
                        <input name="date-debut-${dateType}[]" type="date">
                        </label>
                        <label for="date-fin-${dateType}"> Date de fin de la période de ${dateType} :
                        <input name="date-fin-${dateType}[]" type="date">
                        </label>
                        <button class="delete-date-fields" type="button" data="${dateType}">Supprimer la période de ${dateType}</button>
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
});

