<?php session_start(); ?>
<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "sparrow";

setcookie('id', 1);
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$searchtext;

if (isset($_POST['searchtext'])) {
    $searchtext = $_POST['searchtext'];
} else {
    $searchtext = "%";
}

$sql = "SELECT DISTINCT lists.id, lists.name 
        FROM lists JOIN items 
        WHERE (name LIKE ? OR content LIKE ?) 
        AND locked = false 
        LIMIT 20";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $searchtext, $searchtext);

$search_results = [];

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<?php include './head.php'; ?>

<body>
<?php include './header.php'; ?>

<div class="backdrop trees"></div>
<section id="home">
    <div class="container padded"><div class="row"><div class="col-12">
    <form name="search" class="search-form" method="post">
        <input type="text" name="searchtext" placeholder="search" class="search-input" /><input type="submit" value=">">
    </form>
    <div class="search-info">
        <?php
        if (strcmp($searchtext, "%") !== 0) {
            echo "public lists containing the term \"".$searchtext."\"";
        } else {
            echo "popular public lists";
        }
        ?>
    </div>
    <div class="results">
        <?php if (count($search_results) <= 0): ?>
            <div class="no-results">No results found</div>
        <?php endif; ?>
        
        <?php foreach($search_results as $result): ?>
        <a href="list.php?id=<?php echo $result['id']; ?>" class="list">
            <div class="bullet">></div>
            <div class="item-name"><?php echo $result['name']; ?></div>
        </a>
        <?php endforeach; ?>
    </div>
    </div></div></div>
</section>

</body>

</html>