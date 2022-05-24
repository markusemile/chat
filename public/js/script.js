
let currentRoom = "userItem0";
let currId=sessionStorage.id;
let lastMessageId=0;
let maxMessage=50;

function changeCurrentRoom(newRoom){
    currentRoom=newRoom;
    activeRoom(currentRoom);
    openUserList();
    getMessages();
}

function activeRoom(room){
    const activeRoom = document.querySelector('.active')
    const newRoom = document.getElementById(room);
    activeRoom.classList.remove('active');
    newRoom.classList.add('active');
}


function openUserList(){
    document.getElementById("userListWrapper").classList.toggle('show');
}

function sendMessage(){
    const message = document.querySelector("[name='newMessage']").value;
    const from = currentRoom.replace(/[^\d.*]+/,'');
    document.querySelector("[name='newMessage']").value='';
    if(message.length>0){
        const {token,username,id} = sessionStorage;
        const data = `?from=${id}&room=${from}&message=${message}`;
        console.log(data);
        const url =`http://myiptest.be/api/message/new${data}`

        queryNewMessage = new XMLHttpRequest();
        queryNewMessage.open('post',url,true);
        queryNewMessage.onreadystatechange=function(){
            if(this.readyState==4 && this.status==200){
                if(queryNewMessage.response){
                    getMessages();
                    getConnectedUsers(id);
                }
            }
        }
        queryNewMessage.send();
    }
}

function checkToken(){

    const {token,username} = sessionStorage;
    const data = `?username=${username}&token=${token}`;
    const url = "http://myiptest.be/api/checkToken"+data;

    const tokenReq = new XMLHttpRequest();
    tokenReq.open('POST',url,true);
    tokenReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    tokenReq.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            const response = JSON.parse(tokenReq.response);
            if(response.token!==token){
                let error=[];
                error[0]=['error','Erreur session, veuillez-vous reconnecter !'];
                displayNewError(error,'http://myiptest.be/');
            }

        }
    }
    tokenReq.send();

}

/**
 * function to get the connected user
 *
 * @param currId - id of the current connected user
 */
function getConnectedUsers(){
    const url = `http://myiptest.be/api/user?id=${currId}`;
    const userReq = new XMLHttpRequest();

    userReq.open('get',url,true);
    userReq.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            response = JSON.parse(userReq.response);
            document.getElementById("usersListe").innerText='';
            //document.getElementById("responsiveList").innerText='';
            // console.log('-----')
            // console.log(response)
            // console.log('-----')
            Object.entries(response).map(function(user){
                const display = currId===user[0] ? 'd-none' : 'd-block';
                const userItem = document.createElement('div');
                userItem.id=`userItem${user[1].id}`;
                const actived = currentRoom == userItem.id && 'active' ;
                const nbMessage = user[1].nb_messages!=undefined ? user[1].nb_messages : '';
                userItem.classList.add('userlist-item',display,'mb-1','w-100',actived);
                userItem.setAttribute('onclick',`changeCurrentRoom('userItem${user[1].id}')`);
                const userItemLabel = document.createElement('span');
                userItemLabel.classList.add('userlist-name','select-none','cursor-pointer','py-3','w-full');
                userItemLabel.innerHTML="<span>"+user[1].username+"</span><span class='badge rounded-pill bg-warning text-dark badge-message'>"+nbMessage+"</span>";
                userItem.appendChild(userItemLabel);
                document.getElementById("usersListe").appendChild(userItem);
                //document.getElementById("responsiveList").appendChild(userItem);
            })
        }
    }
    userReq.send();
}


/**
 * SIGN IN function with ajax request to the api
 *
 * @param event
 */
function signin(event) {

    const form = event;
    const username = form.elements.username.value;
    const password = form.elements.password.value;
    const url = "http://myiptest.be/api/user/signin";
    const datas = "?username="+username+"&password="+password;
    const req = url+datas;
    const xhttp = new XMLHttpRequest();
    // we ask to the api if it's a registered user
    xhttp.open("POST",req,true)
    xhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function(){
        if(this.readyState==4 & this.status === 200){
            const responses = JSON.parse(xhttp.response)
            if(!responses.id){
                // if not we call an alert
                displayNewError(JSON.stringify(responses.alert));

            }else{
                // if it a registered user we send the form
                const form = document.getElementById('signinForm');
                form.elements.token.value=responses.token;
                window.sessionStorage.setItem('token',responses.token);
                form.elements.password.value=null;
                form.elements.id.value=responses.id;
                window.sessionStorage.setItem('id',responses.id);
                window.sessionStorage.setItem('username',responses.username);
                let alert = [];
                alert[0]=["success","Your are now connected ! Good Chat !"]
                window.sessionStorage.setItem('alert',JSON.stringify(alert));
                form.submit();

            }
        }
    }
    xhttp.send();
}

function logout(){
    const verif = confirm('Voulez-vous vraiment quitter le chat ?');
    if(verif){
        const id = currId;
        const data = `?id=${id}`;
        const url= `http://myiptest.be/api/user/logout${data}`;
        const reqLogout = new XMLHttpRequest();

        reqLogout.open('get',url,true);
        reqLogout.onreadystatechange=function(){
            if(this.readyState===4 && this.status===200){
                if(reqLogout.response){
                    window.sessionStorage.clear();
                    window.location.replace('http://myiptest.be/');
                }
            }
        }
        reqLogout.send();
    }
}

/**
 * SIGN UP function with ajax request to the api
 *
 * @param event
 */
function signup(event) {
    const form = event;
    const username = form.elements.username.value;
    const password = form.elements.password.value;
    const confirmPassword = form.elements.confirmPassword.value;

    const url = "http://myiptest.be/api/user/signup";
    const datas = `?username=${username}&password=${password}&confirmPassword=${confirmPassword}`;
    const req = url+datas;

    const xhttp = new XMLHttpRequest();
    // we ask to the api if it's a registered user
    xhttp.open("POST",req,true)
    xhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhttp.onreadystatechange = function(){
        if(this.readyState==4 & this.status === 200){
            const responses = JSON.parse(xhttp.response)
            if(!responses.id){
                // if not we call an alert
                displayNewError(JSON.stringify(responses.alert));

            }else{
                // if it a registered user we send the form
                const form = document.getElementById('signupForm');
                form.elements.token.value=responses.token;
                window.sessionStorage.setItem('token',responses.token);
                form.elements.id.value=responses.id;
                window.sessionStorage.setItem('id',responses.id);
                window.sessionStorage.setItem('username',responses.username);
                window.sessionStorage.setItem('alert',JSON.stringify(responses.alert));
                form.submit();

            }
        }
    }
    xhttp.send();
}

/**
 * function that display a alert with a cross button to remove it
 *
 * @param errors
 */
function displayNewError(errors,href=null){
    let color='';
    errors = JSON.parse(errors);
    errors.map(function(error){
        // console.log(error)
        // checking for type of  message and attribute a class
        if(error[0]==='error'){
            color="alert-danger";
        }else if(error[0]==='success'){
            color="alert-success";
        }
        let errTxt = error[1];
        errTxt = errTxt.includes('Duplicate') ? "This user Exist, please change your username." : errTxt
        const newErr = document.createElement('div');
        newErr.classList.add("alert","alert-dismissible","fade","show",color);
        newErr.setAttribute("role","alert");
        newErr.innerText=errTxt;
        newErr.id=Date.now();
        newErr.setAttribute("onClick",`closeMe(${newErr.id},'${href}')`);
        const newErrButton = document.createElement('button');
        newErrButton.type="button";
        newErrButton.classList.add("btn-close");
        newErr.appendChild(newErrButton);
        document.getElementById('alert-container').appendChild(newErr);
    })
}

/**
 * function to close the alert element
 *
 * @param elem
 */
function closeMe(elem,href='null'){
    element = document.getElementById(elem);
    element.parentElement.removeChild(element);
    if(href!=='null'){
        document.location.replace(href);
    }
}

function getMessages(){
    const room = currentRoom.replace(/[^\d.*]+/,'');
    const id = sessionStorage.id;
    const data = `?from=${id}&room=${room}&start=${lastMessageId}&limit=${maxMessage}`;

    const url="http://myiptest.be/api/message"+data;
    // console.log(url);
    const messageReq = new XMLHttpRequest();
    messageReq.open('get',url);
    messageReq.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            // console.log(messageReq.response)
            const messages = JSON.parse(messageReq.response);
            document.getElementById('messagesContainer').innerText='';
            // console.log(typeof messages);
            if(typeof messages=='object') {
                messages.map(function (message) {
                    const time = message.created_at.split(' ');
                    const messageContainer = document.createElement('div');
                    const messageInner = document.createElement('span');
                    const align = sessionStorage.id == message.id_user ? 'align-self-end' : 'align-self-start';
                    const owner = sessionStorage.id == message.id_user ? 'owner-message' : 'guest-message';
                    messageInner.innerHTML = "<div><p><span class='message-user-name'>" + message.username + "</span><small class='message-time'>" + time[1].substr(0, 5) + "</small></p><p>" + decodeURI((message.content) + "</p></div>");
                    messageContainer.id = 'mess' + message.id;
                    messageContainer.classList.add(align, owner, 'message-item','col-md-6','col-sm-12');
                    messageContainer.appendChild(messageInner);
                    document.getElementById('messagesContainer').appendChild(messageContainer);
                    //lastMessageId=message.id;
                })
            }
        }
    }
    messageReq.send();
}

function checkAlert(){
    if(sessionStorage.alert!==undefined){
        console.log(sessionStorage.alert);
    }
}

