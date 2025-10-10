document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".menu-btn");
    const sections = document.querySelectorAll(".content-section");

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            buttons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");

            sections.forEach(section => section.classList.remove("active"));
            const targetId = button.getAttribute("data-target");
            const targetSection = document.getElementById(targetId);
            if (targetSection) targetSection.classList.add("active");
        });
    });

    window.confirmLogout = function() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "../../../Controller/logout.php";
        }
    };

    fetchDashboardStats();
    fetchDoctors();
    fetchPatients();
    fetchAppointments();
    fetchMedicines();
    fetchBackups();
});

function fetchBackups(){
    fetch('../../../Controller/dashboard/admin/backupController.php?action=getBackupInfo')
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById("backup-list");

        if(!tbody){
            return;
        }

        tbody.innerHTML = "";
        if(data.length === 0){
            tbody.innerHTML = `<tr><td colspan="5">No Backup found</td></tr>`;
            return;
        }

        data.forEach(backup => {
            tbody.innerHTML += `
                <tr data-id="${backup.BackupID}" data-file="${backup.FileName}">
                    <td>${backup.BackupID}</td>
                    <td>${backup.FileName}</td>
                    <td>${backup.CreatedAt}</td>
                    <td>${backup.CreatedBy}</td>
                    <td>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
            `
        });
        document.querySelectorAll('.backup-delete-btn').forEach(btn => {
            btn.addEventListener('click', function(){
                const row = this.closest('tr');
                const backupID = row.dataset.id;
                const fileName = row.dataset.file;

                if(confirm(`Are you sure you want to delete backup "${fileName}"?`)){
                    deleteBackup(backupID, fileName);
                }
            });
        });
    })
    .catch(err => console.error("Error fetching backups:", err));
}

function deleteBackup(backupID, fileName){
    fetch(`../../../Controller/dashboard/admin/backupController.php?action=deleteBackup&backupID=${backupID}&fileName=${fileName}`)
        .then(res => res.json())
        .then(data => {
            if(data.success){
                alert("Backup deleted successfully!");
                fetchBackups();
            } else {
                alert("Failed to delete backup: " + data.message);
            }
        })
        .catch(err => console.error("Error deleting backup:", err));
}

function createBackup(){
    if(!confirm("Are you sure you want to create a new backup?")){
        return;
    }

    window.location.href = "../../../Controller/dashboard/admin/backupController.php?action=createBackup";

    setTimeout(fetchBackups, 3000);
}

function fetchDashboardStats() {
    fetch('../../../Controller/dashboard/admin/dataFetchController.php?action=getDashboardStats')
        .then(res => res.json())
        .then(data => {
            document.getElementById('total-doctors').textContent = data.doctors || 0;
            document.getElementById('total-patients').textContent = data.patients || 0;
            document.getElementById('total-appointments').textContent = data.appointments || 0;
            document.getElementById('total-medicines').textContent = data.medicines || 0;
            
            const adminTbody = document.getElementById('admin-info');
            if(adminTbody && data.adminInfo) {
                const admin = data.adminInfo;
                adminTbody.innerHTML = `
                    <tr>
                        <td>${admin.FullName || ""}</td>
                        <td>${admin.Email || ""}</td>
                        <td>${admin.PhoneNumber || ""}</td>
                    </tr>
                `
            }
        });
}

function fetchDoctors() {
    fetch('../../../Controller/dashboard/admin/dataFetchController.php?action=getDoctors')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("doctor-list");
            if (!tbody) {
                return;
            } 
            tbody.innerHTML = "";
            data.forEach(doctor => {
                tbody.innerHTML += `
                    <tr data-id="${doctor.DoctorID}">
                        <td>${doctor.FullName || ""}</td>
                        <td>${doctor.PhoneNumber || ""}</td>
                        <td>${doctor.Specialization || ""}</td>
                        <td>${doctor.VisitFee || ""}</td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function fetchPatients() {
    fetch('../../../Controller/dashboard/admin/dataFetchController.php?action=getPatients')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("patient-list");
            if (!tbody) {
                return;
            } 
            tbody.innerHTML = "";
            data.forEach(patient => {
                tbody.innerHTML += `
                    <tr data-id="${patient.PatientID}">
                        <td>${patient.FullName || ""}</td>
                        <td>${patient.PhoneNumber || ""}</td>
                        <td>${patient.Age || ""}</td>
                        <td>${patient.Gender || ""}</td>
                        <td>${patient.Address || ""}</td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function fetchAppointments() {
    fetch('../../../Controller/dashboard/admin/dataFetchController.php?action=getAppointments')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("appointment-list");
            if (!tbody) {
                return;
            } 
            tbody.innerHTML = "";
            data.forEach(app => {
                tbody.innerHTML += `
                    <tr>
                        <td>${app.AppointmentID || ""}</td>
                        <td>${app.PatientName || ""}</td>
                        <td>${app.DoctorName || ""}</td>
                        <td>${app.Date || ""} ${app.Time || ""}</td>
                        <td>${app.Status || ""}</td>
                        <td>
                            <button class="approve-btn">Approve</button>
                            <button class="reschedule-btn">Reschedule</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function fetchMedicines() {
    fetch('../../../Controller/dashboard/admin/dataFetchController.php?action=getMedicines')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("medicine-list");
            if (!tbody) {
                return;
            } 
            tbody.innerHTML = "";
            data.forEach(med => {
                tbody.innerHTML += `
                    <tr>
                        <td>${med.Name || ""}</td>
                        <td>${med.Type || ""}</td>
                        <td>${med.Strength || ""}</td>
                        <td>${med.ManufacturerName || ""}</td>
                        <td>${med.Status || ""}</td>
                        <td>
                            <button class="toggle-btn ${med.Status === 'Active' ? 'deactivate-btn' : 'activate-btn'}">
                                ${med.Status === 'Active' ? 'Deactivate' : 'Activate'}
                            </button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                `;
            });
        });
}
