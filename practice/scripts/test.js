class Owner {
    constructor(dataObject){
        this.id = dataObject.id;
        this.username = dataObject.username;
        this.password = dataObject.password;
        this.registeredOn = dataObject.registeredOn;
        this.lastLoginOn = dataObject.lastLoginOn;
        this.introText = dataObject.introText;
    }

    getHtmlElementForItemInList() {
        const usernameText = document.createTextNode(this.username);
        
        const usernameContainer = document.createElement('span');
        usernameContainer.setAttribute('class', 'username');
        usernameContainer.appendChild(usernameText);
        
        const introText = document.createTextNode(this.introText);
        const introContainer = document.createElement('span');
        introContainer.setAttribute('class', 'intro=text');
        introContainer.appendChild(introText);
   
        const lineElement = document.createElement('div');
        lineElement.setAttribute('class', 'owner');
        lineElement.setAttribute('id', this.id);

        lineElement.appendChild(usernameContainer);
        lineElement.appendChild(introContainer);
        
        // <div class="owner" id="{id}"><span class="username">{username}</span><span class="intro-text">{intro text}</span></div>

        return lineElement;
    }

    getHtmlElementForItemInList2() {
        const ownerData = `<span class="username">${this.username}</span><span class="intro-text">${this.introText}</span>`;
    
        const lineElement = document.createElement('div');
        lineElement.setAttribute('class', 'owner');
        lineElement.setAttribute('id', this.id);
        
        lineElement.innerHTML = ownerData;

        return lineElement;
    }

    getHtmlAsTextForItemInList() {
        // 
    }
}

const displayOwners2 = owners => {
    const ownersListContainer = document.getElementById('owners-container');
    ownersListContainer.innerHTML = ''; // -> remove previous children

    owners.map(owner => new Owner(owner))
        .map(owner => owner.getHtmlElementForItemInList2()) // getHtmlElementForItemInList
        .forEach(ownerElement => {
            ownersListContainer.appendChild(ownerElement);   
        });
}


const displayOwners3 = owners => {
    document.getElementById('owners-container').innerHTML = owners.map(owner => new Owner(owner))
        .map(owner => owner.getHtmlAsTextForItemInList())
        .reduce((a, b) => a + b, '');
}

//console.log(123);

const displayOwners = (owners) => {
    console.log(owners);
}

const loadOwners = () => {    
    fetch('./owner.php')
        .then(response => response.json())
        .then(displayOwners2); // displayOwners | displayOwners3
}

const sendLoginRequest = event => {
    return fetch('./session.php', {
        method: 'POST',
        body: new FormData(event.target)
    })
    .then(r => r.json())
    .then(r => {
        if (r.logged){
            document.location.reload();
        }else{
            alert('Unsuccessful login');
        }
    });
}

const showLoginForm = () => {
    const formContainer = document.createElement('div');
    formContainer.innerHTML = `
        <form id="login-form">
        <div><input type="text" name="username" placeholder="username"></input></div>
        <div><input type="password" name="password"></input></div>
        <input type="submit" value="enter"></input>
        </form>`;
    
    document.getElementById('content').appendChild(formContainer);
    document.getElementById('login-form').addEventListener('submit', sendLoginRequest);
}

const logout = () => {
    fetch('./session.php', {
        'method': 'DELETE',
    })
    .then(() => {
        const messageContainer = document.createElement('span');
        messageContainer.innerText = 'Successful logout from the system.';

        document.getElementById('content').appendChild(messageContainer);
        
        window.setTimeout(() => {
            document.location.reload();
        }, 2000);
    });
}

const checkLoginStatus = () => {
    fetch('./session.php')
        .then(r => r.json())
        .then(response => {
            if(response.logged){
                document.getElementById('sidebar').innerHTML = `<div>Hello, <span id="username">${response.username}</span></div>
                <div><button id="logout">Logout</button></div>`;
                document.querySelector('#sidebar').addEventListener('click', logout);
            }else{
                document.getElementById('sidebar').innerHTML = `<button id="login">Влез в системата</button>`; 
                document.querySelector('#sidebar #login').addEventListener('click', showLoginForm);   
            }
        });
}

document.getElementById('see-owners').addEventListener('click', loadOwners);

checkLoginStatus();



/*
let button = document.getElementById('see-owners');
button.addEventListener('click', (event) => {
    console.log("from button", event);
    event.stopPropagation();
});

window.setTimeout(1000);
document.body.addEventListener('click', event => console.log("from body", event));
*/

// example 1
let data = new FormData();
data.append('x', 5);
data.append('y', "asdf");

fetch('./owner.php', {
    method: 'POST',
    body: data
})    
.then(response => response.json())
.then(displayOwners);

// example 2
let data2 = {
    'x': 5,
    'y': "asdf"
};

fetch('./owner.php', {
    method: 'POST',
    body: JSON.stringify(data2),
    headers: {
        'Content-Type': 'application/json'
    }
})
.then(response => response.json())
.then(displayOwners);

// example 3 -> returns promise
const sendPostRequest = (data) => {
    return fetch('./owner.php', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json());
}

// example input:
//      sendPostRequest({'x':5, 'y':6})
//          .then(displayOwners);

// example 4 -> returns promise
const sendPostRequestAsFormData = (data) => {
    let formData = new FormData();
    for(key in data){
        formData.append(key, data[key]);
    }

    return fetch('./owner.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json());
}

// example input:
//      sendPostRequestAsFormData({z: 7})
//          .then(displayOwners);