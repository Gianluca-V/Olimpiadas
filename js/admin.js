
const editIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --> <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" /> </svg>';
const deleteIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --> <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" /> </svg>'

// Simulate data from the server (replace this with actual API calls)
const areasData = [
    {
        areaName: 'Area 1',
        nurses: ['Nurse 1', 'Nurse 2', 'Nurse 3']
    },
    {
        areaName: 'Area 2',
        nurses: ['Nurse 4', 'Nurse 5']
    }
];

// Function to create a nurse element
function createNurseElement(nurseName) {
    const nurseElement = document.createElement('div');
    nurseElement.classList.add('area__group');
    nurseElement.innerHTML = `
        <div class="areas__nurses-name">${nurseName}</div>
        <div class="areas__edit">${editIcon}</div>
        <div class="areas__delete">${deleteIcon}</div>
    `;
    console.log(nurseElement)
    return nurseElement;
}

// Function to create an area element
function createAreaElement(areaData) {
    const areaElement = document.createElement('div');
    areaElement.classList.add('areas__area');

    const nursesContainer = document.createElement('div');
    nursesContainer.classList.add('areas__nurses');

    areaData.nurses.forEach(nurse => {
        const nurseElement = createNurseElement(nurse);
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

    // Append the nurses container to the areas container
    areaElement.querySelector('.areas__nurses').appendChild(nursesContainer);

    return areaElement;
}

// Function to populate areas and nurses
function populateAreasAndNurses() {
    const areasContainer = document.querySelector('.areas__container');
    
    areasData.forEach((areaData) => {
        const areaElement = createAreaElement(areaData);
        areasContainer.appendChild(areaElement);
    });
}

// Call the function to populate areas and nurses when the page loads
window.addEventListener('load', populateAreasAndNurses);
