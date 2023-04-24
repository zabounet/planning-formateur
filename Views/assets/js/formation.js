addEventListener('DOMContentLoaded', () => {

    let newFields;
    let addButton = document.querySelectorAll(".add-date-fields");

    Array.from(addButton).forEach(function (newDateBtn) {
        newDateBtn.addEventListener("click", () => {

            let dateType = newDateBtn.getAttribute("data");
            let date = new Date();
            let dateMin = new Date(date.getTime() - (date.getTimezoneOffset() * 60000))
                .toISOString()
                .split("T")[0];

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
                        let formateurLabel = document.createElement("label");
                        formateurLabel.htmlFor = "formateur";
                        formateurLabel.textContent = "Formateur : ";
                        newFields.appendChild(formateurLabel);

                        //élément Select avec formateurs
                        let selectFormateur = document.createElement("select");
                        selectFormateur.name = "formateur[]";
                        formateurLabel.appendChild(selectFormateur);

                        //Option de départ
                        let defaultOption = document.createElement("option");
                        defaultOption.disabled = true;
                        defaultOption.setAttribute("selected", "");
                        defaultOption.textContent = "Choisir un formateur";
                        selectFormateur.appendChild(defaultOption);

                        data.forEach(formateur => {
                            let option = document.createElement("option");
                            option.value = formateur.id_formateur;
                            option.textContent = formateur.nom_formateur + ' ' + formateur.prenom_formateur;
                            selectFormateur.appendChild(option)
                        });

                        // Concaténation de la chaine de caractères avec le reste des create elements
                        newFields.innerHTML += `
                        <label for="date-debut-${dateType}"> Date de début d'${dateType} :
                        <input name="date-debut-${dateType}[]" type="date" min="${dateMin}">
                        </label>
                        <label for="date-fin-${dateType}"> Date de fin d'${dateType} :
                        <input name="date-fin-${dateType}[]" type="date" min="${dateMin}">
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
                xhr.open('GET', '/planning/public/formation/ajouterFormation');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send();

            }

            else {

                newFields = document.createElement("div");
                newFields.classList.add("date-fields");
                newFields.setAttribute("data", dateType);
                newFields.innerHTML = `
                    <label for="date-debut-${dateType}"> Date de début période ${dateType} :
                    <input name="date-debut-${dateType}[]" type="date" min="${dateMin}">
                    </label>
                    <label for="date-fin-${dateType}"> Date de fin période ${dateType} :
                    <input name="date-fin-${dateType}[]" type="date" min="${dateMin}">
                    </label>
                    <button class="delete-date-fields" type="button" data="${dateType}">Supprimer période ${dateType}</button>
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
        });
    })
})