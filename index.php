<?php session_start(); ?>
<?php
include './templates/config.tpl.php';

$searchtext;
$searchtext_SQL;

if (isset($_POST['searchtext'])) {
    $searchtext = strtoupper($_POST['searchtext']);
    $searchtext_SQL = "%".$searchtext."%";
} else {
    $searchtext = "%";
    $searchtext_SQL = "%";
}

$sql = "SELECT DISTINCT lists.id, lists.name 
        FROM lists 
        INNER JOIN items ON lists.id = items.parent
        WHERE ( UPPER(name) LIKE ? OR UPPER(content) LIKE ?) 
        AND locked = false 
        LIMIT 20";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $searchtext_SQL, $searchtext_SQL);

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
<?php include './templates/head.tpl.php'; ?>

<body>
<?php include './templates/header.tpl.php'; ?>

<div class="backdrop trees"></div>
<section id="home">
    <div class="container padded"><div class="row"><div class="col-12">
    <form name="search" class="search-form" method="post">
        <input type="text" name="searchtext" placeholder="search" class="search-input" /><input type="submit" value=">">
    </form>
    <div class="search-info">
        <?php
        if (isset($_POST['searchtext'])) {
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
    <div plume></div>
    <div plume-menu></div>
</section>

<script src="./scripts/plume.js"></script>
<script>plume()</script>
</body>

</html>