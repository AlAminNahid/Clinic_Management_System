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
            const patientRow = e.target.closest("tr");

            if(!patientRow){
                return;
            }

            if (e.target.classList.contains("delete-btn")) {
                const patientName = patientRow.children[0].textContent.trim();

                if(confirm(`Are you sure you want to delete ${patientName}`)){
                    fetch(`../../../Controller/dashboard/admin/edit_delete_updateController.php?action=deletePatient`, {
                        method: "POST",
                        headers: {"Content-Type": "application/json"},
                        body: JSON.stringify({
                            patientID: patientRow.dataset.id
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            patientRow.remove();
                            alert(`${patientName} deleted successfully.`);
                        }
                        else{
                            alert(`Failed to delete patient: ` + data.message);
                        }
                    })
                    .catch(err => console.error("Error:", err));
                }
            }
            if (e.target.classList.contains("edit-btn")) {
                const editBtn = e.target;
                if(editBtn.textContent.trim() === "Save"){
                    const updatedFullName = patientRow.children[0].querySelector("input").value.trim();
                    const updatedPhone = patientRow.children[1].querySelector("input").value.trim();
                    const updatedAge = patientRow.children[2].querySelector("input").value.trim();
                    const updatedGender = patientRow.children[3].querySelector("input").value.trim();
                    const updatedAddress = patientRow.children[4].querySelector("input").value.trim();

                    fetch(`../../../Controller/dashboard/admin/edit_delete_updateController.php?action=editPatient`, {
                        method: "POST",
                        headers: {"Content-Type": "application/json"},
                        body: JSON.stringify({
                            patientID: patientRow.dataset.id,
                            newFullName: updatedFullName,
                            newPhone: updatedPhone,
                            newAge: updatedAge,
                            newGender: updatedGender,
                            newAddress: updatedAddress
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            patientRow.children[0].textContent = updatedFullName;
                            patientRow.children[1].textContent = updatedPhone;
                            patientRow.children[2].textContent = updatedAge;
                            patientRow.children[3].textContent = updatedGender;
                            patientRow.children[4].textContent = updatedAddress;

                            editBtn.textContent = "Edit";
                            alert("patient info updated successfully.");
                        }
                        else{
                            alert("Failed to update patient: " + data.message);
                        }
                    })
                    .catch(err => console.error("Error:", err));
                }
                else{
                    const currentFullName = patientRow.children[0].textContent.trim();
                    const currentPhone = patientRow.children[1].textContent.trim();
                    const currentAge = patientRow.children[2].textContent.trim();
                    const currentGender = patientRow.children[3].textContent.trim();
                    const currentAddress = patientRow.children[4].textContent.trim();

                    patientRow.children[0].innerHTML = `<input type="text" value="${currentFullName}">`;
                    patientRow.children[1].innerHTML = `<input type="text" value="${currentPhone}">`;
                    patientRow.children[2].innerHTML = `<input type="text" value="${currentAge}">`;
                    patientRow.children[3].innerHTML = `<input type="text" value="${currentGender}">`;
                    patientRow.children[4].innerHTML = `<input type="text" value="${currentAddress}">`;

                    editBtn.textContent = "Save";
                }
            }
        });
    }

    const appointmentList = document.getElementById("appointment-list");
    if (appointmentList) {
        appointmentList.addEventListener("click", e => {
            const appRow = e.target.closest("tr");

            if(!appRow){
                return;
            }

            const appointmentID = appRow.children[0].textContent.trim();

            if (e.target.classList.contains("approve-btn")) {
                if(confirm("Are you sure you want to approve this appointments?")){
                    updateAppointmentStatus(appointmentID, "Approved", appRow);
                }
            }
            if (e.target.classList.contains("cancel-btn")) {
                if(confirm("Are you sure you want to cancel this appointment?")){
                    updateAppointmentStatus(appointmentID, "Cancelled", appRow);
                }
            }
            if (e.target.classList.contains("delete-btn")) {
                if(confirm("Are you sure you want to delete this appointment?")){
                    deleteAppointment(appointmentID, appRow);
                }
            }
        });
    }

    const medicineList = document.getElementById("medicine-list");
    if (medicineList) {
        medicineList.addEventListener("click", e => {
            const medRow = e.target.closest("tr");

            if (e.target.classList.contains("delete-btn")) {
                if(!medRow){
                    return;
                }

                const medicineName = medRow.children[0].textContent.trim();

                if(confirm(`Are you sure you want to delete ${medicineName}`)){
                    fetch(`../../../Controller/dashboard/admin/edit_delete_updateController.php?action=deleteMedicine`, {
                        method: "POST",
                        headers: {"Content-Type": "application/json"},
                        body: JSON.stringify({
                            medicineName: medicineName
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            medRow.remove();
                            alert(`${medicineName} deleted successfully`);
                        }
                        else{
                            alert("Failed to delete medicine: " + data.message);
                        }
                    })
                    .catch(err => console.error("Error:", err));
                }
            }
            if (e.target.classList.contains("toggle-btn")) {
                const medicineName = medRow.children[0].textContent.trim();
                const currentStatus = medRow.children[4].textContent.trim();
                const newStatus = currentStatus === "Active" ? "Inactive" : "Active";

                if(confirm(`Are you sure you want to ${newStatus === "Active" ? "activate" : "deactivate"} ${medicineName}`)){
                    fetch(`../../../Controller/dashboard/admin/edit_delete_updateController.php?action=toggleMedicineStatus`, {
                        method: "POST",
                        headers: {"Content-Type": "application/json"},
                        body: JSON.stringify({
                            medicineName: medicineName,
                            newStatus: newStatus
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            medRow.children[4].textContent = newStatus;
                            e.target.textContent = newStatus === "Active" ? "Deactivate" : "Activate";
                            e.target.classList.toggle("activate-btn", newStatus !== "Active");
                            e.target.classList.toggle("deactivate-btn", newStatus === "Active");
                            
                            alert(`${medicineName} is now ${newStatus}.`);
                        }
                        else{
                            alert("Failed to update status: " + data.message);
                        }
                    })
                    .catch(err => console.error("Error:", err));
                }
            }
        });
    }
});

function updateAppointmentStatus(appointmentID, newStatus, row){
    fetch(`../../../Controller/dashboard/admin/edit_delete_updateController.php?action=updateAppointmentStatus`, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            appointmentID,
            newStatus
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            row.children[5].textContent = newStatus;
            alert(`Appointment status updated to ${newStatus}`);
        }
        else{
            alert("Failed to update appointment: " + data.message);
        }
    })
    .catch(err => console.error("Error:", err));
}

function deleteAppointment(appointmentID, row){
    fetch(`../../../Controller/dashboard/admin/edit_delete_updateController.php?action=deleteAppointment`, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            appointmentID
        })
    })
    .then(res => res.json)
    .then(data => {
        if(data.success){
            row.remove();
            alert("Appointment deleted successfully.");
        }
        else{
            alert("Failed to delete appointment: " + data.message);
        }
    })
    .catch(err => console.error("Error:", err));
}