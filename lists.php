<?php
$servername = "127.0.0.1:3309";
$username = "root";
$password = "";
$database = "sparrow";


$curruser = 1;
setcookie('id', 1);
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$sql = "SELECT id, name FROM lists WHERE owner = 1";

$result = $conn->query($sql);

$lists = [];
while($row = $result->fetch_assoc()) {
    $lists[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<?php readfile('./head.php'); ?>

<body>
<?php readfile('./header.php'); ?>

<section id="lists">
    <div class="container"><div class="row"><div class="col-12">
        <h2>Your Lists</h2>
        <?php foreach($lists as $l) { echo '<div class="list-item"><h5 class="list-name"><a href="list/?id='.$l['id'].'">'.$l['name'].'</a></h5></div>'; } ?>
        <div class="list-item next"><div class="add-new"><h6>+ Add New</h6></div></div>
    </div></div></div>
</section>

</body>
<script>
    creatingNew = false;
    $(document).ready(function() {
        addNewText = $('.add-new h6');
        addNewText.click(function() {
            creatingNew = true;
            $('.add-new').html(`
                <input id="new-list-name" type='text' placeholder="Enter a list name">
            `);
        });

        $(document).keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13' && creatingNew){
                $('.list-item .next').html(`
                    <h5 class="list-name">
                        <a href="list/?id=''></a>
                    </h5>
                `)
                listname = $('#new-list-name').val();
                $.post('/sparrow/api/newlist.php', { name: listname }, function(data) {
                    console.log(data);
                })
            }
        });
    });
</script>


</html>