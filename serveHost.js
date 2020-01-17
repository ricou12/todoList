const $main = document.querySelector('conteneur');
//  récupèrer la liste des enregistrement.
const $titleUpdate = document.querySelector('.updateNote input[name="nom"]');
const $memoUpdate = document.querySelector('.updateNote textarea[name="note"]');
const $buttonUpload = document.querySelector('.buttonUpload');
const $txtResult = document.querySelector('.txtResult');
// Nouvel enregistrement
const $btnSend = document.querySelector('.createNote button');
const $title = document.querySelector('.createNote input[name="nom"]');
const $memo = document.querySelector('.createNote textarea[name="note"]');
const $message = document.querySelector('.createNote h4');

$btnSend.addEventListener('click', (evt) => {
    // Récupérer les valeurs du formulaire et les charges dans un tableau.
    const data = {
        "title": $title.value,
        "memo": $memo.value
    };
    sendRequest(data);
});

const sendRequest = (data) => {
    // ENVOI LES DONNEES DU FORMULAIRE AU SERVEUR VIA UNE REQUETE DATA OBJ --> CONVERTI EN JSON
    fetch('./updateNotes.php', {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(returnData => {
        // Lecture de la réponse
        if (returnData && returnData.success) {
            $message.innerHTML = "Enregistrement réussi !";
        } else {
            $message.innerHTML = "Impossible d'enregistrer !";
        }
    })
    .catch((error) => {
        $message.innerHTML = 'Il y a eu un problème avec l\'opération fetch: ' + error.message;
    });
}

/* ------------------------------------------------------------- */

$buttonUpload.addEventListener('click', evt => {
    updateDataBase();
});

// Envoi de la requete de connexion au serveur pour récupérer la liste stocké dans la base de donnée.
const updateDataBase = () => {
    fetch('./getList.php',{method: "POST"})
        .then(res => res.json())
        .then(returnData => {
            if (returnData){
                // $message.innerHTML = returnData[0].titre;
                $txtResult.value = returnData.map(element => element.titre ).join('');
               
                console.log(returnData);
            } else {
                $txtResult.value = "Erreur du serveur !"; 
            }
        })
        .catch((error) => {
            $txtResult.value = 'Il y a eu un problème avec l\'opération fetch: ' + error.message;
        });
}