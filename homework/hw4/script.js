const validateResult = users => {
    const successContainer = document.getElementById('success');
    const errorContainer = document.getElementById('error');

    if(validInput()){
        const username = document.getElementById('username').value;
        let usernameTaken = false;
        
        for(let i = 0; i < users.length; i++){
            if(users[i]['username'] == username){
                usernameTaken = true;
            }
        }
        
        if(usernameTaken){
            successContainer.innerHTML = '';
            errorContainer.innerHTML = 'Username already taken.';
        }else{
            successContainer.innerHTML = 'Successful registration.';
            errorContainer.innerHTML = '';
        }
    }else{
        successContainer.innerHTML = '';
        errorContainer.innerHTML = 'Incorrect input.';
    }
}

const fetchData = () => {
    fetch('https://jsonplaceholder.typicode.com/users')
        .then(response => response.json())
        .then(validateResult);
}

function containsNumbers(str){
    return /[0-9]/.test(str);
}

function containsCapitalLetters(str){
    return /[A-Z]/.test(str);
}

function containsSmallLetters(str){
    return /[a-z]/.test(str);
}

function validEmailFormat(str){
    return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(str);
}

function validPostalCodeFormat(str){
    return /(^$)|(^\d{4}$)|(^\d{5}-\d{4}$)/.test(str);
}

function validInput() {
    const username = document.getElementById('username').value;
    const name = document.getElementById('name').value;
    const fname = document.getElementById('family-name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const pcode = document.getElementById('postal-code').value;

    return (username.length >= 3 && username.length <= 10) && 
            name.length <= 50 && 
            fname.length <= 50 && 
            validEmailFormat(email) &&
            (password.length >= 6 && password.length <= 10 && 
                containsNumbers(password) && 
                containsCapitalLetters(password) && 
                containsSmallLetters(password)) &&
            validPostalCodeFormat(pcode);
}

document.getElementById('register-btn').addEventListener('click', fetchData);