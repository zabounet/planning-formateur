addEventListener('DOMContentLoaded', () => {

    let newFields;
    let addButton = document.querySelectorAll(".add-date-fields");

    Array.from(addButton).forEach(function (newDateBtn) {
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

                        let counter = 0;
                        data.forEach(formateur => {
                            if (counter == 0 || counter == 1) {
                                counter++;
                                return;
                            }
                            let option = document.createElement("option");
                            option.value = formateur.id_formateur;
                            option.textContent = formateur.nom_formateur + ' ' + formateur.prenom_formateur;
                            selectFormateur.appendChild(option)
                            counter++;
                        });

                        // Concaténation de la chaine de caractères avec le reste des create elements
                        newFields.innerHTML += `
                        <div class="separate">
                        <label for="date-debut-${dateType}"> Date de début :</label>
                        <input id="date-debut-${dateType}" name="date-debut-${dateType}[]" type="date" class="date-periode">
                        </div>
                        <div class="separate">
                        <label for="date-fin-${dateType}"> Date de fin :</label>
                        <input id="date-debut-${dateType}" name="date-fin-${dateType}[]" type="date" class="date-periode">
                        </div>
                        <button class="delete-date-fields" type="button" data="${dateType}">X</button>
                        <hr>
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
                xhr.open('GET', '/planning/public/admin/ajouterFormation');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send();

            }

            else {

                newFields = document.createElement("div");
                newFields.classList.add("date-fields");
                newFields.setAttribute("data", dateType);
                newFields.innerHTML = `
                    <div class="separate">
                    <label for="date-debut-${dateType}"> Date de début :</label>
                    <input id="date-debut-${dateType}" name="date-debut-${dateType}[]" type="date" class="date-periode">
                    </div>
                    <div class="separate">
                    <label for="date-fin-${dateType}"> Date de fin :</label>
                    <input id="date-fin-${dateType}" name="date-fin-${dateType}[]" type="date" class="date-periode">
                    </div>
                    <button class="delete-date-fields" type="button" data="${dateType}">X</button>
                    <hr>
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

    // Get the fieldsets and the next button
    const part1 = document.getElementById('part1');
    const part2 = document.getElementById('part2');
    const part3 = document.getElementById('part3');
    const part4 = document.getElementById('part4');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const step4 = document.getElementById('step4');
    const interruptions = document.getElementsByName('interruption');
    const interruptionsDates = document.querySelector('.interruption-dates');
    const nextButton = document.getElementById('nextButton');
    const submitButton = document.getElementById('submitButton');

    // Show the first fieldset
    part1.style.display = 'flex';

    // Add a click event listener to the next button
    nextButton.addEventListener('click', function () {

        if (part1.style.display === "flex") {
            if (document.getElementById('type').value
                && document.getElementById('grn').value
                && document.getElementById('ville').value
                && document.getElementById('grn').value
                && document.getElementById('acronyme').value
                && document.getElementById('description').value
                && document.getElementById('offre').value
                && document.getElementById('date-debut').value
                && document.getElementById('date-fin').value) {
                part1.animate(
                    [
                        {
                            transform: "translate(0, 0)",
                            display: "flex",
                        },
                        {
                            transform: "translate(-1200px, 0)",
                            display: "none"
                        }
                    ],
                    {
                        duration: 700,
                        iterations: 1,
                        direction: 'normal',
                    }
                );

                part2.animate(
                    [
                        {
                            position: "absolute",
                            left: "1300px",
                            top: "73.3px",
                            display: "none",
                        },
                        {
                            position: "absolute",
                            left: "0",
                            top: "73.3px",
                            display: "flex"
                        }
                    ],
                    {
                        duration: 700,
                        iterations: 1,
                        direction: 'normal',
                    }
                );
                part2.style.display = 'flex';
                setTimeout(function () {
                    part1.style.display = 'none';
                }, 700);

                step2.style.backgroundColor = "#58d665";
            }
            else {
                alert("merci de remplir tous les champs.")
            }

            return;
        }
        if (part2.style.display === "flex") {
            if (document.getElementById('date-debut-centre').value && document.getElementById('date-fin-centre').value) {
                part2.animate(
                    [
                        {
                            transform: "translate(0, 0)",
                            display: "flex",
                        },
                        {
                            transform: "translate(-1200px, 0)",
                            display: "none"
                        }
                    ],
                    {
                        duration: 700,
                        iterations: 1,
                        direction: 'normal',
                    }
                );

                part3.animate(
                    [
                        {
                            position: "absolute",
                            left: "1300px",
                            top: "73.3px",
                            display: "none",
                        },
                        {
                            position: "absolute",
                            left: "0",
                            top: "73.3px",
                            display: "flex"
                        }
                    ],
                    {
                        duration: 700,
                        iterations: 1,
                        direction: 'normal',
                    }
                );
                part3.style.display = 'flex';
                setTimeout(function () {
                    part2.style.display = 'none';
                }, 700);

                step3.style.backgroundColor = "#58d665";
            }
            else {
                alert("merci de remplir tous les champs.")
            }
            
            return;
        }
        if (part3.style.display === "flex") {
            if(nextButton.style.opacity == .1){
                alert("Veuillez cocher l'une des deux cases avant de continuer.");
            }
            else{
                if(interruptionsDates.style.display === "none"){
                    part3.animate(
                        [
                            {
                                transform: "translate(0, 0)",
                                display: "flex",
                            },
                            {
                                transform: "translate(-1200px, 0)",
                                display: "none"
                            }
                        ],
                        {
                            duration: 700,
                            iterations: 1,
                            direction: 'normal',
                        }
                    );

                    part4.animate(
                        [
                            {
                                position: "absolute",
                                left: "1300px",
                                top: "73.3px",
                                display: "none",
                            },
                            {
                                position: "absolute",
                                left: "0",
                                top: "73.3px",
                                display: "flex"
                            }
                        ],
                        {
                            duration: 700,
                            iterations: 1,
                            direction: 'normal',
                        }
                    );
                    part4.style.display = 'flex';
                    setTimeout(function () {
                        part3.style.display = 'none';
                    }, 700);

                    nextButton.style.display = "none";
                    submitButton.style.display = "inline-block"

                    step4.style.backgroundColor = "#58d665";
                    return;
                }
                else if(interruptionsDates.style.display === "block"){
                    if(document.getElementById('date-debut-interruption') && document.getElementById('date-fin-interruption')){
                        part3.animate(
                            [
                                {
                                    transform: "translate(0, 0)",
                                    display: "flex",
                                },
                                {
                                    transform: "translate(-1200px, 0)",
                                    display: "none"
                                }
                            ],
                            {
                                duration: 700,
                                iterations: 1,
                                direction: 'normal',
                            }
                        );
        
                        part4.animate(
                            [
                                {
                                    position: "absolute",
                                    left: "1300px",
                                    top: "73.3px",
                                    display: "none",
                                },
                                {
                                    position: "absolute",
                                    left: "0",
                                    top: "73.3px",
                                    display: "flex"
                                }
                            ],
                            {
                                duration: 700,
                                iterations: 1,
                                direction: 'normal',
                            }
                        );
                        part4.style.display = 'flex';
                        setTimeout(function () {
                            part3.style.display = 'none';
                        }, 700);
        
                        nextButton.style.display = "none";
                        submitButton.style.display = "inline-block"
        
                        step4.style.backgroundColor = "#58d665";
                        return;
                    }
                    else {
                        alert("Veuillez renseigner au moins une période ou cocher \"Aucune interruption\" si vous ne souhaitez pas en ajouter.")
                    }
                }
            }
        }
    });
    nextButton.addEventListener('click', function () {
        if (part3.style.display === "flex") {
            Array.from(interruptions).forEach(function (interruption){
                // nextButton.setAttribute('disabled', '');
                nextButton.style.opacity = .1;

                interruption.addEventListener('change', () =>{
                    if(interruption.value === "addInterruptions"){
                        interruptionsDates.style.display = "block";
                        // nextButton.removeAttribute('disabled');
                        nextButton.style.opacity = 1;
                    }
                    else if(interruption.value === "noInterruptions"){
                        interruptionsDates.style.display = "none";
                        // nextButton.removeAttribute('disabled');
                        nextButton.style.opacity = 1;
                    }
                })
            });
        };
    })
})