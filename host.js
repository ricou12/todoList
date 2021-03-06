const $txtResult = document.querySelector('.txtResult');

// FORMULAIRE D'INSCRIPTION
const $stateLogin = document.querySelector('.connect');
const $btnLog = document.querySelector('.connect .register');
const $titleLog = document.querySelector('.connect a h6');
const $link = document.querySelector('.connect .link');

// div qui contiendra tout les memos
const $updateNote = document.querySelector('.updateNote');
//  Bouton pour envoyer une requete (récupère la liste des enregistrements.)
const $buttonUpload = document.querySelector('.buttonUpload');

// Nouvel enregistrement
const $btnSend = document.querySelector('.createNote .btnRegister');
const $title = document.querySelector('.createNote .title');
const $memo = document.querySelector('.createNote .notes');


// CHANGER LOGIN OU LOGOUT
$titleLog.addEventListener('click', () =>{
    if ($stateLogin.hasAttribute('data-connect')) {
        const $state = $stateLogin.getAttribute('data-connect');
        switch ($state) {
            case 'login':
                $titleLog.textContent = "Se connecter";
                $btnLog.textContent = "S'inscrire";
                $stateLogin.setAttribute('data-connect', 'logout');
                break;
            case 'logout':
                $titleLog.textContent = "S'inscrire";
                $btnLog.textContent = "Connexion";
                $stateLogin.setAttribute('data-connect', 'login');
                break;
            default:
        }
    }
});

// CONNEXION AU COMPTE USER
$btnLog.addEventListener('click', () =>
{
    const $password = document.getElementById('password');
    const $email = document.getElementById('email');
    if ($stateLogin.hasAttribute('data-connect'))
    {
        const $state = $stateLogin.getAttribute('data-connect');
        if ($state == 'logger')
        {
            requestToServer('StopSession', './sessionStop.php',{});
            $link.style.visibility = "visible";
            $titleLog.textContent = "S'inscrire";
            $btnLog.textContent = "Connexion";
            $txtResult.value = "Vous êtes déconnectés !"
            $stateLogin.setAttribute('data-connect', 'login');
            $updateNote.innerHTML="";
        }
        if ($password.value && $email.value)
        {
            const data =
            {
                "email": $email.value,
                "password": $password.value
            };
            switch ($state)
            {
                case 'login':
                    requestToServer('getUser', './getUser.php', data);
                    break;
                case 'logout':
                    requestToServer('addUser', './register.php', data);
                    break;
                default:
            }
        }
    }
});

// RECUPERE LA LISTE DES TODO PAR UTILISATEUR
$buttonUpload.addEventListener('click', () => updateDataBase());
const updateDataBase = () => {
    requestToServer('upload', './getList.php', {});
}

// CREE UN NOUVEL ENREGISTREMENT DANS LA DATABASE
$btnSend.addEventListener('click', () => addNewRegister());
const addNewRegister = () => {
    if ($title.value != '' || $memo.value != '') {
        // Récupérer les valeurs du formulaire et les charges dans un tableau.
        const data = {
            "title": $title.value,
            "memo": $memo.value
        };
        requestToServer('added', './updateNotes.php', data);
    }
}

// DELETE UN ENREGISTREMENT DANS LA DATABASE
$updateNote.addEventListener('click', () => deleteRegister());
const deleteRegister = () => {
    const element = event.target;
    if (element.hasAttribute('data-id')) {
        const destroyTodo = element.getAttribute('data-id');
        // send request for delete entry by id
        const data = {
            "table": "blocnote",
            "id": destroyTodo
        };
        requestToServer('deleted', './deleteSql.php', data);
    }
}

// ENVOIE LA REQUETE VERS LE SERVEUR DISTANT
const requestToServer = (command, adressServe, data) => {
    fetch(adressServe, {
            method: "POST",
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(returnData => {
            if (returnData) {
                // traitement de la réponse
                executeWork(command, returnData);
            } else {
                $txtResult.value = "Erreur du serveur !";
            }
        })
        .catch((error) => {
            $txtResult.value = 'Il y a eu un problème avec l\'opération fetch: ' + error.message;
        });
}

function executeWork(command, data) {
    switch (command) {
        case 'upload':
            if (data) {
                $updateNote.innerHTML = data.map(element => generateList(element.id, element.titre, element.note)).join('');
                // $txtResult.value = "Mémos mise à jour !";
            } else {
                // $txtResult.value = "Vous n'avez enregistré aucun mémo !";
            }
            break;
        case 'added':
            if (data.success) {
                $txtResult.value = "Enregistrement réussi !";
                $title.value = "";
                $memo.value = "";
            } else {
                $txtResult.value = "Erreur lors de l'enregistrement, veuillez contacter l'administrateur !";
            }
            updateDataBase();
            break;
        case 'deleted':
            if (data.success) {
                $txtResult.value = "Suppression réussie !";
            } else {
                $txtResult.value = "Erreur lors de la suppression, veuillez contacter l'administrateur !";
            }
            updateDataBase();
            break;
        case 'getUser':
            if (data.success) {
                $link.style.visibility = "hidden"; 
                $stateLogin.setAttribute('data-connect', 'logger');
                $btnLog.textContent = "Déconnexion";
                $txtResult.value = "Vous êtes connecté !" + " identifiant: " +  data.session + " User :" + data.name;
                updateDataBase();
            } else {
                $txtResult.value = data.msg;
            }
            break;
        case 'addUser':
            if (data.success) {
                $link.style.visibility = "hidden";
                $stateLogin.setAttribute('data-connect', 'logger');
                $btnLog.textContent = "Déconnexion";
                $txtResult.value = "Merci d'avoir créer votre compte ! " + "Session: " + data.session + " User :" + data.name;
            } else {
                $txtResult.value = "Vous possédez deja un compte, merci de vous identifier !";
            }
            break;
            case 'stopSession':
                if(data.success){
                    // $link.style.visibility = "visible";
                    // $titleLog.textContent = "S'inscrire";
                    // $btnLog.textContent = "Connexion";
                    // $txtResult.value = "Vous êtes déconnectés !"
                    // $stateLogin.setAttribute('data-connect', 'login');
                    // $updateNote.innerHTML="";
                }
                // updateDataBase();
        default:
            console.log('erreur de commande : ' + command);
    }
}

const generateList = (id, title, note) => {
    return `
    <div class="container">
        <div class="row border">
            <div class="col-12 col-lg-4 d-flex flex-nowrap justify-content-between p-2">
                    <div class="d-flex flex-nowrap align-items-start">
                        <input type="checkbox" id="titleUploaded">
                        <label class="mx-2" for="titleUploaded">${title}</label>
                    </div>
                    <div>
                        <a href="#"><img class="border border-danger rounded" src="./img/trash.png" alt="trash" data-id="${id}" width="50"></a>
                    </div>
            </div>
            <div class="col-12 col-lg-8">
                <p>${note}</p>
            </div>
        </div>
    </div>
    `;
}

// ACTUALISE L'APPLICATION
updateDataBase();