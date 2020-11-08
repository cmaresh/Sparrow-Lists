<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "sparrow";


$curruser = 1;
setcookie('id', 1);
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$listId = $_GET['id'];

//Retrieve list name
$sql = "SELECT name FROM lists WHERE id = ".$listId;
$result = $conn->query($sql);
$name = [];
while($row = $result->fetch_assoc()) {
    $name[] = $row;
}

//Retrieve list items
$sql = "SELECT id, content FROM items WHERE parent = ".$listId;
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
        <h2><?php echo $name[0]['name']; ?></h2>
        <div class="list-items">
        <?php foreach($lists as $l) { echo '<div class="list-item"><h5 class="list-name">'.$l['content'].'</h5></div>'; } ?>
        </div>
        <div class="add-new"><h6>+</h6></div>
    </div></div></div>
</section>

</body>
<script>
    creatingNew = false;
    $(document).ready(function() {
        addNew = $('.add-new');
        addNew.click(function() {
            if (!creatingNew) {
                creatingNew = true;
                $('.add-new').html(`
                    <input id="new-list-name" type='text' placeholder="Enter a list item">
                `);
            }
        });

        $(document).keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            var content = $('#new-list-name').val();
            if(keycode == '13' && creatingNew){
                $.post('/sparrow/api/newlistitem.php', { content: content, parent: <?php echo $listId ?> }, function(data) {
                    console.log(data);
                    data = JSON.parse(data);
                    var newItemHtml = '<div class="list-item"><h5 class="list-name">' + data.content + '</h5></div>'
                    $('.list-items').append(newItemHtml);
                    $('.add-new').html(`
                    <h6>+</h6>
                    `);
                });
                creatingNew = false;
            }
        });
    });
</script>
</html>