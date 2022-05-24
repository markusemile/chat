
<div id ="userListWrapper" class=" d-flex flex-column align-content-center text-light ">
        <h6 class='border-b py-2 text-center select-none text-light '>Liste de personnes connectées</h6>

    <div id="userListContainer" class="scrollbar">
        <div  id="userItem0" class='userlist-item mb-1 cursor-pointer active' onclick="changeCurrentRoom('userItem0')");>
            <span class="userlist-name select-none my-3">Public Room</span>
        </div>
        <div id="usersListe" class="d-flex flex-column align-items-start" >
            <!--        ajax puts here the users list-->
            <script>getConnectedUsers(<?= $_POST['id'] ?>)</script>
        </div>
    </div>

</div>

<style>
    @media screen and (max-width:480px){
        #userListWrapper{
            position:fixed;
            align-items: center;
            width:100vw !important;
            height:100vh !important;
            overflow-y:auto ;
            top:0px;
            left:0;
            padding-top:10px;
            background-color:var(--third-color);
            z-index:999999999;
            transform:translateX(-100%);
            transition:all 0.5s ease;
        }
        #userListWrapper.show{
            transform:translateX(0);
        }
        #userListContainer {
            height:100vh ;
            width:100vw;

        }
        .userlist-item{
            margin:auto;
            width:80% !important;
        }
    }
</style>