document.addEventListener("DOMContentLoaded", () =>{
    const doctorList = document.getElementById("doctor-list");
    if (doctorList) {
        doctorList.addEventListener("click", e => {
            const doctorRow = e.target.closest("tr");

            if(!doctorRow){
                return;
            }

            if (e.target.classList.contains("delete-btn")) {
                const doctorName = doctorRow.children[0].textContent.trim();

                if(confirm(`Are you sure you want to delete ${doctorName}?`)){
                    fetch(`../../../Controller/dashboard/admin/edit_delete_updateController.php?action=deleteDoctor`, {
                        method: "POST",
                        headers: {"Content-Type": "application/json"},
                        body: JSON.stringify({
                            doctorID: doctorRow.dataset.id
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            doctorRow.remove();
                            alert(`${doctorName} deleted successfully.`);
                        }
                        else{
                            alert("Failed to delete doctor: " + data.message);
                        }
                    })
                    .catch(err => console.error("Error:", err));
                }
            } 
            if (e.target.classList.contains("edit-btn")) {
                const editBtn = e.target;
                if(editBtn.textContent.trim() === "Save"){
                    const updatedFullName = doctorRow.children[0].querySelector("input").value.trim();
                    const updatedPhone = doctorRow.children[1].querySelector("input").value.trim();
                    const updatedSpecialization = doctorRow.children[2].querySelector("input").value.trim();
                    const updatedFee = doctorRow.children[3].querySelector("input").value.trim();

                    fetch(`../../../Controller/dashboard/admin/edit_delete_updateController.php?action=editDoctor`, {
                        method: "POST",
                        headers: {"Content-Type": "application/json"},
                        body: JSON.stringify({
                            doctorID: doctorRow.dataset.id,
                            newFullName: updatedFullName,
                            newPhone: updatedPhone,
                            newSpecialization: updatedSpecialization,
                            newFee: updatedFee
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            doctorRow.children[0].textContent = updatedFullName;
                            doctorRow.children[1].textContent = updatedPhone;
                            doctorRow.children[2].textContent = updatedSpecialization;
                            doctorRow.children[3].textContent = updatedFee;

                            editBtn.textContent = "Edit";
                            alert("Doctor info updated successfully.");
                        }
                        else{
                            alert("Failed to update doctor: " + data.message);
                        }
                    })
                    .catch(err => console.error("Error:", err));
                }
                else {
                    const currentFullName = doctorRow.children[0].textContent.trim();
                    const currentPhone = doctorRow.children[1].textContent.trim();
                    const currentSpecialization = doctorRow.children[2].textContent.trim();
                    const currentFee = doctorRow.children[3].textContent.trim();

                    doctorRow.children[0].innerHTML = `<input type="text" value="${currentFullName}">`;
                    doctorRow.children[1].innerHTML = `<input type="text" value="${currentPhone}">`;
                    doctorRow.children[2].innerHTML = `<input type="text" value="${currentSpecialization}">`;
                    doctorRow.children[3].innerHTML = `<input type="text" value="${currentFee}">`;

                    editBtn.textContent = "Save";
                }
            }
        });
    }

    const patientList = document.getElementById("patient-list");
    if (patientList) {
        patientList.addEventListener("click", e => {
            if (e.target.classList.contains("delete-btn")) {
                console.log("Delete patient clicked");
            }
            if (e.target.classList.contains("edit-btn")) {
                console.log("Edit patient clicked");
            }
        });
    }

    const appointmentList = document.getElementById("appointment-list");
    if (appointmentList) {
        appointmentList.addEventListener("click", e => {
            if (e.target.classList.contains("approve-btn")) {
                console.log("Approve appointment clicked");
            }
            if (e.target.classList.contains("reschedule-btn")) {
                console.log("Reschedule appointment clicked");
            }
            if (e.target.classList.contains("delete-btn")) {
                console.log("Delete appointment clicked");
            }
        });
    }

    const medicineList = document.getElementById("medicine-list");
    if (medicineList) {
        medicineList.addEventListener("click", e => {
            if (e.target.classList.contains("toggle-btn")) {
                console.log("Toggle medicine status clicked");
            }
            if (e.target.classList.contains("delete-btn")) {
                console.log("Delete medicine clicked");
            }
        });
    }
});