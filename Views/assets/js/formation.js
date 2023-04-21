addEventListener('DOMContentLoaded', () =>{
  
    let addButton = document.querySelectorAll(".add-date-fields");
    let fieldCount = 1;

    Array.from(addButton).forEach(function (newDateBtn) {
        newDateBtn.addEventListener("click", () => {

            let dateType = newDateBtn.getAttribute("data");
            let newFields = document.createElement("div");
            newFields.classList.add("date-fields");
            newFields.innerHTML = `
                <label for="date-debut-${dateType}${fieldCount}"> Date de début ${dateType} :
                <input name="date-debut-${dateType}${fieldCount}" type="date">
                </label>
                <label for="date-fin-${dateType}${fieldCount}"> Date de fin ${dateType}:
                <input name="date-fin-${dateType}${fieldCount}" type="date">
                </label>
            `;
            newDateBtn.before(newFields);
            fieldCount++;
        });
    })  
})