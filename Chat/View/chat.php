<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>
<body>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-8"><h3>Discussion</h3></div>
                <div class="col-md-4">

                </div>
            </div>
            <table class="table" id="table_messages">
                <thead>
                <tr style="background: #eee">
                    <th>Pseudo</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php $messages = $_SESSION["messages"];
                foreach ($messages as $message) { ?>
                    <tr>
                        <td><?php echo $message->getSender()->getPseudo(); ?></td>
                        <td><?php echo $message->getMessage(); ?></td>
                        <td><?php echo $message->getSendAt(); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <hr>
        </div>
        <div class="col-md-4">
            <?php $users = $_SESSION["users"]; ?>
            <h3>Liste Connectés (<?php echo count($users) ?>)</h3>
            <ul class="list-group" id="table_users">
                <?php foreach ($users as $user) {
                    $active = ""; ?>
                    <?php if ($user->getPseudo() == $_SESSION['pseudo']) {
                        $active = "list-group-item-info";
                    } ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center <?php echo $active; ?>">
                        <?php echo $user->getPseudo() ?>
                        <span class="badge badge-pill badge-success"><font color="#28a745">1</font></span>
                    </li>
                <?php } ?>
            </ul>
            <p></p>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a class="btn btn-danger" href="logout">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>

    <form class="form-inline" action="add" method="POST">
        <div class="form-group col-md-6">
            <label for="message" class="sr-only">Message</label>
            <input type="text" class="form-control" name="message" placeholder="Message..." required style="width:100%">
        </div>
        <button type="submit" class="btn btn-primary col-md-1">Envoyer</button>
    </form>
    <br><br>

</div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
    setInterval(
        function () {
            refresh();
        }, 1000
    );

    function refresh() {
        $.ajax(
            {
                type: "GET",
                dataType: "json",
                url: "/chat/refresh",
                success: function (data) {
                    messages = data['messages'];
                    users = data['users'];

                    contenu_table_messages = '<tr><th>Pseudo</th><th ' +
                        '>Message</th><th>Date</th></tr>';
                    var sendername = "";
                    for (var i = 0; i < messages.length; i++) {
                        for (var j = 0; j < users.length; j++) {
                            if(users[j]['0'] == messages[i]['1']){
                                sendername = users[j]['1']
                            }
                        }

                        contenu_table_messages += '<tr><td>'+ sendername +'</td>';
                        contenu_table_messages += '<td>' + messages[i]['2'] + '</td>';
                        contenu_table_messages += '<td>' + messages[i]['3'] + '</td>'
                    }
                    contenu_table_messages += '</tr>';

                    $('#table_messages').html(contenu_table_messages);

                    contenu_table_users = '';
                    var currentuser = '<?php echo $_SESSION['pseudo']; ?>';

                    for (var i = 0; i < users.length; i++) {
                        var styleactive = '';
                        if (currentuser == users[i]['1']) {
                            styleactive = ' list-group-item-info';
                        }
                        contenu_table_users += '<li class="list-group-item d-flex justify-content-between align-items-center ' + styleactive + '">' + users[i]['1'] + '<span class="badge badge-pill badge-success"><font color="#28a745">1</font></span></li>';
                    }

                    $('#table_users').html(contenu_table_users);
                }
            }
        );
    }




</script>