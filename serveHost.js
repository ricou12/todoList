const $updateNote = document.querySelector('.updateNote');

//  récupèrer la liste des enregistrement.
const $buttonUpload = document.querySelector('.buttonUpload');

// Nouvel enregistrement
const $btnSend = document.querySelector('.createNote .btnRegister');
const $title = document.querySelector('.createNote .title');
const $memo = document.querySelector('.createNote .notes');

// CONSOLE
const $txtResult = document.querySelector('.txtResult');
$txtResult.addEventListener('input',(evt) => {
    console.log('ok');
});

// RECUPERE LA LISTE DES TODO PAR UTILISATEUR
$buttonUpload.addEventListener('click', () => {
    updateDataBase();
});
// Envoi de la requete de connexion au serveur pour récupérer la liste stocké dans la base de donnée.
const updateDataBase = () => {
    fetch('./getList.php',{method: "POST"})
        .then(res => res.json())
        .then(returnData => {
            if (returnData){
                $txtResult.value = "Mémos mise à jour !"; 
                $updateNote.innerHTML = returnData.map(element => generateList(element.id,element.titre,element.note) ).join('');
            } else {
                $txtResult.value = "Vous n'avez enregistré aucun mémo !"; 
            }
        })
        .catch((error) => {
            $txtResult.value = 'Il y a eu un problème avec l\'opération fetch: ' + error.message;
        });
}

const generateList = (id,title,note) => {
    return `
    <div class="container">
        <div class="row border">
            <div class="col-12 col-lg-4 d-flex flex-nowrap justify-content-between p-2">
                    <div class="d-flex flex-nowrap align-items-start">
                        <input type="checkbox" id="titleUploaded">
                        <label class="mx-2" for="titleUploaded">${title}</label>
                    </div>
                    <div>
                        <a href="#"><img src="./img/trash.png" alt="trash" data-id="${id}" width="50"></a>
                    </div>
            </div>
            <div class="col-12 col-lg-8">
                <p>${note}</p>
            </div>
        </div>
    </div>
    `;
}

// ENREGISTRE LES DONNEES DU FORMULAIRE AU SERVEUR VIA UNE REQUETE DATA OBJ --> CONVERTI EN JSON
$btnSend.addEventListener('click', () => {
    if ($title.value != '' || $memo.value != '' ){
        // Récupérer les valeurs du formulaire et les charges dans un tableau.
        const data = {
            "title": $title.value,
            "memo": $memo.value
        };
        requestToServer('./updateNotes.php',data,true);
    }
});

// DELETE TODO
$updateNote.addEventListener('click', event => {
    const element = event.target;
    if(element.hasAttribute('data-id')){
        const destroyTodo = element.getAttribute('data-id');
        // send request for delete entry by id
        const data = {
            "table": "blocnote",
            "id": destroyTodo
        };
        requestToServer('./deleteSql.php',data,true);
    }
    console.log(evt);
});

// ENVOIE UNE REQUETE VERS UN SERVEUR DISTANT JS
const requestToServer = (adressServe,data,state) => {
    fetch(adressServe, {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(returnData => {
        // Lecture de la réponse
        if (returnData && returnData.success) {
            $txtResult.value = returnData.success;
            // Si suppression d'entrée, rafraichi la page en relançant une requete pour récupérer la liste
            if (state){
               updateDataBase(); 
            }
        } else {
            $txtResult.value = "Erreur du serveur !";
        }
    })
    .catch((error) => {
        $txtResult.value = 'Il y a eu un problème avec l\'opération fetch: ' + error.message;
    });  
}

// ACTUALISE L'APPLICATION
updateDataBase(); 