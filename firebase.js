let firebaseConfig = {
    apiKey: "AIzaSyBOfNZHQ9c_-KS6WDdGMjKSRvvGNzAFNg4",
    authDomain: "smart-power-meter-44e02.firebaseapp.com",
    databaseURL: "https://smart-power-meter-44e02-default-rtdb.firebaseio.com",
    projectId: "smart-power-meter-44e02",
    storageBucket: "smart-power-meter-44e02.appspot.com",
    messagingSenderId: "644579599926",
    appId: "1:644579599926:web:4a93acae4245a03fcc9a97",
    measurementId: "G-K930REWS3E"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Add New Customer
document.getElementById('formReg').addEventListener('submit', function (e) {
    e.preventDefault();

    var name = document.getElementById('name');
    var mobile = document.getElementById('mobile');
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    var password2 = document.getElementById('password2');

    firebase.auth().createUserWithEmailAndPassword(email.value, password.value)
        .then(function (response) {
            console.log('success');
            console.log(response);
            firebase.database().ref('Users').push({
                name: name.value,
                mobile: mobile.value,
                userId: firebase.auth().currentUser.uid,
                email: firebase.auth().currentUser.email
            })
            firebase.auth().signOut();
            email.value = '';
            password.value = '';
        })
        .catch(function (error) {
            var errorCode = error.code;
            var errorMessage = error.message;
            console.log(errorCode);
            console.log(errorMessage);
        });
});

firebase.database().ref('Users').on('value',(data)=>{
    let users= data.val();
    document.getElementById('tableUsers').innerHTML='';
    var i=0;
    for (const user in users){
        i++
        document.getElementById('tableUsers').innerHTML+=`
        <tr>
            <td>${i}</td>
            <td>${users[user].name}</td>
            <td>${users[user].email}</td>
            <td>${users[user].mobile}</td>
        </tr>
        `;
    }
});


  