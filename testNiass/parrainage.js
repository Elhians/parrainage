const filleuls = [
    { name: "Filleul 1", photo: "image/1.jpg" },
    { name: "Filleul 2", photo: "image/2.webp" },
    { name: "Filleul 3", photo: "image/3.jpg" },
    { name: "Filleul 4", photo: "image/4 (1).jpg" },
    { name: "Filleul 5", photo: "image/4 (2).jpg" },
    { name: "Filleul 6", photo: "image/4 (3).jpg" }
];
const parrains = [
    { name: "Parrain 1", photo: "image/4 (1).jpg" },
    { name: "Parrain 2", photo: "image/4 (2).jpg" },
    { name: "Parrain 3", photo: "image/4 (3).jpg" },
    { name: "Parrain 4", photo: "image/4 (1).jpg" },
    { name: "Parrain 5", photo: "image/4 (2).jpg" },
    { name: "Parrain 6", photo: "image/4 (3).jpg" }
];

let assignedFilleuls = new Set();

function getRandomIndex(arr) {
    return Math.floor(Math.random() * arr.length);
}

function assignParrain() {
    if (assignedFilleuls.size === filleuls.length) {
        alert("Tous les filleuls ont déjà été parrainés.");
        return;
    }

    let filleulIndex, parrainIndex;
    do {
        filleulIndex = getRandomIndex(filleuls);
    } while (assignedFilleuls.has(filleulIndex));
    
    parrainIndex = getRandomIndex(parrains);

    const filleul = filleuls[filleulIndex];
    const parrain = parrains[parrainIndex];

    const filleulContainer = document.getElementById('filleul-container');
    const parrainContainer = document.getElementById('parrain-container');

    // Start the spin animation
    const filleulPhoto = document.getElementById('filleul-photo');
    const parrainPhoto = document.getElementById('parrain-photo');
    filleulPhoto.classList.add('spin');
    parrainPhoto.classList.add('spin');

    setTimeout(() => {
        // Stop the spin animation
        filleulPhoto.classList.remove('spin');
        parrainPhoto.classList.remove('spin');

        // Hide the containers before updating content
        filleulContainer.classList.remove('reveal');
        parrainContainer.classList.remove('reveal');

        // Set a timeout to allow the hiding animation to complete
        setTimeout(() => {
            // Update the selected filleul and parrain
            document.getElementById('filleul-name').innerText = `Filleul: ${filleul.name}`;
            document.getElementById('filleul-photo').src = filleul.photo;

            document.getElementById('parrain-name').innerText = `Parrain: ${parrain.name}`;
            document.getElementById('parrain-photo').src = parrain.photo;

            // Reveal the containers with updated content
            filleulContainer.classList.add('reveal');
            parrainContainer.classList.add('reveal');

            // Mark the filleul as assigned
            assignedFilleuls.add(filleulIndex);
        }, 3000); // Delay to allow for the fade-out effect
    }, 2000); // Duration of the spin animation
}
