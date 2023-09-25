if (localStorage.getItem("logged") != "true") {
    window.location.href = "login.html";
}

const editIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --> <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" /> </svg>';
const deleteIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --> <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" /> </svg>';

// Function to create a nurse element
function createNurseElement(nurseName) {
    const nurseElement = document.createElement('div');
    nurseElement.classList.add('area__group');
    nurseElement.innerHTML = `
        <div class="areas__nurses-name">${nurseName}</div>
        <div class="areas__edit">${editIcon}</div>
        <div class="areas__delete">${deleteIcon}</div>
    `;
    return nurseElement;
}

// Function to create an area element
function createAreaElement(areaData) {
    const areaElement = document.createElement('div');
    areaElement.classList.add('areas__area');

    const nursesContainer = document.createElement('div');
    nursesContainer.classList.add('areas__nurses');

    areaData.nurses.forEach(nurse => {
        const nurseElement = createNurseElement(nurse.name);
        nursesContainer.appendChild(nurseElement);
    });


    areaElement.innerHTML = `
        <div class="area__group">
            <h3 class="areas__name">${areaData.areaName}</h3>
            <div class="areas__edit">${editIcon}</div>
        </div>
        <div class="areas__nurses">
            <div class="areas__nurses--add">+</div>
        </div>
        <div class="areas__delete">${deleteIcon}</div>
    `;

    areaElement.querySelector('.areas__nurses').appendChild(nursesContainer);

    return areaElement;
}

// Function to populate areas and nurses
function populateAreasAndNurses(areasData) {
    const areasContainer = document.querySelector('.areas__container');

    console.log(areasData)
    areasData.forEach((areaData) => {
        const areaElement = createAreaElement(areaData);
        areasContainer.appendChild(areaElement);
    });
}

async function fetchAreasAndNurses() {
    try {
        const response = await fetch('http://localhost/olimpiadasServer/api/areas/-v');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const areasData = await response.json();
        populateAreasAndNurses(areasData);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

areaAddEvent = () =>{
    document.querySelector(".areas__area--add").addEventListener("click", async () => {
        try {
            const response = await fetch('http://localhost/olimpiadasServer/api/areas/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ Name: "Name" }),
            });
    
            const data = await response.json();
    
            if (response.status === 200) {
                await updateAreas();
            } else {
                // Authentication failed
                loginMessage.textContent = 'Authentication failed. Please try again.';
            }
        } catch (error) {
            console.error('Error:', error);
            loginMessage.textContent = 'An error occurred. Please try again later.';
        }
    })

    document.querySelector(".areas__delete").addEventListener("click",()=>{

    })
} 

async function updateAreas() {
    document.querySelector(".areas__container").innerHTML = '<div class="areas__area--add"> <img src="assets/new-img.png" alt="new img" class="area--add"> </div>  ';
    await fetchAreasAndNurses();
    await areaAddEvent();
}

//patients section

function createPatientElement(patient) {
    const patientElement = document.createElement('div');
    patientElement.classList.add('patients__patient');
    patientElement.textContent = patient.FirstName + " " + patient.LastName;

    return patientElement;
}

function populatePatients(patients) {
    const patientsContainer = document.querySelector('.patients__container');

    patients.forEach((patient) => {
        const patientElement = createPatientElement(patient);
        patientsContainer.appendChild(patientElement);
    });
}

async function fetchPatients() {
    try {
        const response = await fetch('http://localhost/olimpiadasServer/api/patients/');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const patients = await response.json();
        await populatePatients(patients);
        areaAddEvent();
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

//users section

function createUserElement(user) {
    const userElement = document.createElement('div');
    userElement.classList.add('users__user');
    userElement.textContent = user.UserName;

    return userElement;
}

function populateUsers(users) {
    const usersContainer = document.querySelector('.users__container');

    users.forEach((user) => {
        const userElement = createUserElement(user);
        usersContainer.appendChild(userElement);
    });
}

async function fetchUsers() {
    try {
        const response = await fetch('http://localhost/olimpiadasServer/api/users/');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const users = await response.json();
        populateUsers(users);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

//calls section

function createCallElement(call) {
    const callElement = document.createElement('div');
    callElement.classList.add('calls__call');
    callElement.innerHTML = `
        <div class="call__id">ID: ${call.ID}</div>
        <div class="call__type">Type: <span class="call__type-span" ${call.Type == "Emergency" ? "style='color:red;'" : ""}>${call.Type}</span> </div>
        <div class="call__response">Response Time: ${call.ResponseTime}s</div>
        <div class="call__attended">Attended: ${call.Attended == 0 ? "No" : "Yes"}</div>
    `;
    return callElement;
}

function populateCalls(calls) {
    const callsContainer = document.querySelector('.calls__container');

    calls.forEach((call) => {
        const callElement = createCallElement(call);
        callsContainer.appendChild(callElement);
    });
}

async function fetchCalls() {
    try {
        const response = await fetch('http://localhost/olimpiadasServer/api/calls/');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const calls = await response.json();
        populateCalls(calls);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

// Call the function to fetch areas and nurses data and populate the UI when the page loads
window.addEventListener('load', () => {
    Promise.all([fetchAreasAndNurses(), fetchPatients(), fetchUsers(), fetchCalls()]);
});
