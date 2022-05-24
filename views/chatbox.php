
    <div id="alert-container"  style="z-index:999999999">
    </div>
<div class="container w-100 position-relative">
    <div class="row chatbox-container">
        <div id="buttonMenu" onclick="openUserList()" class=" d-md-none d-sm-block ">
            <button class="menu-button my-3">
            </button>
        </div>
        <div id="userContainer" class=" col-sm-12 col-md-3 border-l">
            <aside>
                <div class="header flex">
                    <h1 class="border-b text-center text-warning py-2">PHP-JS<br>ChatBox</h1>
                    <div class="user-info text-light text-center border-b pb-2 mb-2">
                        <span class="text-info"><script>document.write(sessionStorage.getItem('username'))</script></span><span class="text-warning">  / <a href="#" class="text-danger text-decoration-none" onclick="logout()">Se deconnecter</a></span>
                    </div>
                </div>
                <div  class="liste">
                    <?php require('usersConnected.php') ?>
                </div>
            </aside>
        </div>
        <div class="col-sm-12 col-md-8 border-l">
            <div id="messagesContainer" class="message-container d-flex flex-column text-light" style="overflow-y:auto">
                <script> getMessages() </script>
            </div>
            <nav class="input-container text-light d-flex items-center navbar">
                <div class="d-flex" style="width:100%;">
                    <div class="lead emoji-picker-container border-primary mt-2 radius-lg bg-light">
                        <input type="text"  name="newMessage" class="border-0" style="width:80%" data-emojiable="true">
                    </div>
                    <button class="btn btn-primary" style="height:fit-content" onclick="sendMessage()">
                        >
                    </button>
                </div>
            </nav>
        </div>
    </div>
</div>
<script>
    $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '../lib/img/',
            popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
    });

    checkToken();
    displayNewError(sessionStorage.alert);

    window.onload=function(){
        $messages = setInterval(function(){
            getMessages();
            getConnectedUsers();
        },2000)


    }

</script>

