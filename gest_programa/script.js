document.addEventListener("DOMContentLoaded", () => {
    const programForm = document.getElementById("programForm");
    const programList = document.getElementById("programList");

   
    const normalizeText = (text) => {
        return text
            .toLowerCase()
            .normalize("NFD") 
            .replace(/[\u0300-\u036f]/g, ""); 
    };

    programForm.addEventListener("submit", (e) => {
        e.preventDefault(); 

       
        const programName = normalizeText(document.getElementById("programName").value);
        const programCode = normalizeText(document.getElementById("programCode").value);
        const programDuration = document.getElementById("programDuration").value; 

    
        const programItem = document.createElement("li");
        programItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");

        programItem.innerHTML = `
            <span>
                <strong>${programName}</strong> (codigo: ${programCode}, duracion: ${programDuration} años)
            </span>
            <div>
                <button class="btn btn-sm btn-warning edit-btn">editar</button>
                <button class="btn btn-sm btn-danger delete-btn">eliminar</button>
            </div>
        `;
        programList.appendChild(programItem);

        programForm.reset();
        programItem.querySelector(".delete-btn").addEventListener("click", () => {
            programList.removeChild(programItem);
        });
        programItem.querySelector(".edit-btn").addEventListener("click", () => {
            document.getElementById("programName").value = programName;
            document.getElementById("programCode").value = programCode;
            document.getElementById("programDuration").value = programDuration;
            programList.removeChild(programItem);
        });
    });
});
