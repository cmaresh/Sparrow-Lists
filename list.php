<?php session_start(); ?>
<?php
include './templates/config.tpl.php';

$listId = $_GET['id'];

//Retrieve list name
$sql = "SELECT * FROM lists WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $listId);

$list = [];

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $list[] = $row;
    }
}

$exists     = false;
$owner      = false;
$access     = false;

if (count($list) > 0) {
    $exists = true;
}

if ($exists && isset($_SESSION['user']) && ($list[0]['owner'] === $_SESSION['user'])) {
    $owner = true;
}

if ($exists && ( $owner || !$list[0]['locked'] )) {
    $access = true;
}

//Retrieve list items
if ($access) {
    $sql = "SELECT id, content FROM items WHERE parent = ? ORDER BY id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $listId);
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
<?php include './templates/head.tpl.php'; ?>

<body>
<?php include './templates/header.tpl.php'; ?>

<div class="modal" id="deletemodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">deleting list</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>this action cannot be undone.<br><br>proceed?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="delete-final">Yes</button>
      </div>
    </div>
  </div>
</div>

<div class="backdrop birds"></div>
<section id="lists">
    <div class="container padded">
        <?php if ($owner): ?>
            <div class="list-options-pos">
                <div class="list-options">
                    <div class="list-option add">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
                    </div>
                    <div class="list-option cancel" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/></svg>
                    </div>
                    <div class="list-option shiftup" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>
                    </div>
                    <div class="list-option shiftdown" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg>
                    </div>
                    <div class="list-option changepos" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M7 11.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/></svg>
                    </div>
                    <div class="list-option remove" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row no-gutters">
        <?php if (!$exists): ?>
        <div class="col-12">
            <div id="no-access">
                <div>a list with this ID does not exist</div>
                <a href="/sparrow/">HOME ></a>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($exists && !$access): ?>
        <div class="col-12">
            <div id="no-access">
                <div>this list has not yet been unlocked by the owner</div>
                <a href="/">back to home</a>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($exists && $access): ?>
        <div class="col-12">
            <h2><?php echo $list[0]['name']; ?></h2>
            <?php if ($owner): ?>
            <div class="list-settings">
                <h3 id="lock" class="<?php echo $list[0]['locked'] ? 'unlocked' : 'locked'; ?>">
                <div class="unlocked-content"><img src="media/unlock-fill.svg" alt="locked" />&nbsp;
                Locked</div>
                <div class="locked-content"><img src="media/lock-fill.svg" alt="locked" />&nbsp;
                Unlocked</div>
                </h3>
                <h3 class="delete" data-toggle="modal" data-target="#deletemodal">Delete?</h3>
            </div>
            <?php endif; ?>
        </div>
        <div class="col=12">
        
        <div class="description">
            <?php if($owner): ?>
                    <div class="grow-wrap">
                        <textarea id="description-content" placeholder="Enter a description for your list here."><?php echo $list[0]['description']; ?></textarea>
                    </div>
                </div>
            <?php
                else: 
                    if($list[0]['description']) echo $list[0]['description'];
                    else echo 'This is a list';
                endif; 
             ?>
        </div>
        <div class="col-md-6 sp-flex-column">
            <div class="list-content">
                <ol id="list-items">
                <?php foreach($lists as $l) { echo '<li class="list-name '.($owner ? 'editable' : '').'" data-id="'.$l['id'].'"><div class="list-name-content">'.$l['content'].'</div></li><br>'; } ?>
                <!--<li class="list-name editable" data-id="100">List item content
                    <div class="poster-section">
                        <img class="poster-blurfix" src="./media/shapeofwater.jpg" alt="poster" />
                        <img class="poster-background" src="./media/shapeofwater.jpg" alt="poster" />
                        <img class="poster-image" src="./media/shapeofwater.jpg" alt="poster" />
                    </div>
                    <div class="movie-info">
                        <h7 class="movie-title">The Shape of Water</h7><br>
                        <span class="movie-subtext">R | 2h 3m | 22 December 2017</span><br>
                        <b>Director: </b>Guillermo del Toro<br>
                        <b>Writers: </b>Guillermo del Toro, Venessa Taylor<br>
                        <b>Stars: </b>Sally Hawkins, Octavia Spencer, Michael Shannon<br>
                    </div>
                    <div class="close-item">
                        ^
                    </div>
                </li>-->
                </ol>
            </div>
        </div>
        <div class="col-md-6">
            <div class="center-col">
                <div class="desktop-movie-wrap">
                    <div class="poster-section">
                        <img class="poster-blurfix" src="./media/shapeofwater.jpg" alt="poster" />
                        <img class="poster-background" src="./media/shapeofwater.jpg" alt="poster" />
                        <img class="poster-image" src="./media/shapeofwater.jpg" alt="poster" />
                    </div>
                    <div class="movie-info">
                        <h7 class="movie-title">The Shape of Water</h7><br>
                        <span class="movie-subtext">R | 2h 3m | 22 December 2017</span><br>
                        <b>Director: </b>Guillermo del Toro<br>
                        <b>Writers: </b>Guillermo del Toro, Venessa Taylor<br>
                        <b>Stars: </b>Sally Hawkins, Octavia Spencer, Michael Shannon<br>
                    </div>
                    <div class="close-item">
                        ^
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div></div></div>
</section>

</body>
<?php if ($owner): ?>
<script>
    creatingNew = false;
    $(document).ready(function() {
        addNew = $('.add');
        remove = $('.remove');
    
        addNew.click(function() {
            if (!creatingNew) {
                creatingNew = true;
                $('.add').html(`
                    <input id="new-list-name" type='text' placeholder="Enter a list item">
                `);
            }
        });

        remove.click(function() {
            selected = $('.selected');
            removeIds = [];
            selected.each(function() {
                removeIds.push($(this).attr('data-id'));
            });
            $.post('/sparrow/api/removeitems.php', { listId: <?php echo $listId; ?>, ids: removeIds }, function(data) {
                data = JSON.parse(data);
                $('.selected').remove();
                remove.hide();
            });
        });

        $('#delete-final').click(function() {
            $.post('/sparrow/api/deletelist.php', { user: "<?php echo $_SESSION['user']; ?>", id: <?php echo $listId; ?> }, function(data) {
                window.location.href = '/sparrow/lists.php';
            });
        });

        $(document).keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            var content = $('#new-list-name').val();
            if(keycode == '13' && creatingNew){
                $.post('/sparrow/api/newlistitem.php', { user: "<?php echo $_SESSION['user']?>", content: content, parent: <?php echo $listId ?> }, function(data) {
                    data = JSON.parse(data);
                    const ol = document.querySelector("#list-items");
                    const li = document.createElement('li');
                    li.classList.add("list-name");
                    li.setAttribute("data-id", data.id);
                    const text = document.createTextNode(data.content);
                    li.appendChild(text);
                    ol.appendChild(li);

                    // var newItemHtml = '<li class="list-name" data-id="' + data.id +'">' + data.content + '</li>'
                    // $(newItemHtml).appendTo('.list-items').click(function() {
                    //     $(this).toggleClass('selected');
                    //     $('.selected').length > 0 ? $('.remove').show() : $('.remove').hide();
                    // });
                    $('.add').html(`
                    <h6>+</h6>
                    `);
                });
                creatingNew = false;
            }
        });
        

        $('.list-name').click(function() {
            $(this).toggleClass('selected');
            $('.selected').length > 0 ? $('.remove').css("display", "flex") : $('.remove').hide();
        });

        $('#lock').click(function() {
            $.post('/sparrow/api/togglelock.php', { id: <?php echo $listId; ?> });
            $(this).toggleClass('locked');
        });
    });
</script>
<?php endif; ?>
</html>