<?php session_start(); ?>
<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "sparrow";


$curruser = 1;

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

if (isset($_SESSION['user'])) {
    $sql = "SELECT id, name FROM lists WHERE owner = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user']);

    $lists = [];
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $lists[] = $row;
        }
    }
} 

$conn->close();
?>
<!DOCTYPE html>
<html>
<?php include './head.php'; ?>

<body>
<?php include './header.php'; ?>

<div class="backdrop birds"></div>
<section id="lists">
    
    <div class="container padded"><div class="row"><div class="col-12">
        <?php if (isset($_SESSION['user'])): ?>
        <h2>Your Lists</h2>
        <div class="list-items">
        <?php foreach($lists as $l) { echo '<div class="list-item"><h5 class="list-name"><a href="list.php?id='.$l['id'].'">'.$l['name'].'</a></h5></div>'; } ?>
        </div>
        <div class="list-option add"><h6>+</h6></div>
        <div class="list-option remove"><h6>-</h6></div>
        <?php else: ?>
        <div id="no-access">
            <div>you are not logged in</div>
            <a href="login.php">LOGIN ></a>
        </div>
        <?php endif; ?>
    </div></div></div>
</section>

</body>
<script>
    creatingNew = false;
    $(document).ready(function() {
        addNew = $('.add');
        addNew.click(function() {
            if (!creatingNew) {
                creatingNew = true;
                $('.add').html(`
                    <input id="new-list-name" type='text' placeholder="Enter a list name">
                `);
            }
        });

        $(document).keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            var listname = $('#new-list-name').val();
            if(keycode == '13' && creatingNew){
                $.post('/sparrow/api/newlist.php', { user: "<?php echo $_SESSION['user']; ?>", name: listname }, function(data) {
                    data = JSON.parse(data);
                    var newItemHtml = '<div class="list-item"><h5 class="list-name"><a href="list.php?id=' + data.id + '">' + data.name + '</a></h5></div>'
                    $('.list-items').append(newItemHtml);
                    $('.add').html(`
                    <h6>+</h6>
                    `);
                });
                creatingNew = false;
            }
        });
    });
</script>


</html>