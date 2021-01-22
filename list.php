<?php session_start(); ?>
<?php
include './templates/config.tpl.php';

$listId = $_GET['id'];

//Retrieve list name
$sql = "SELECT name, owner, locked FROM lists WHERE id = ?";
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
    <div class="container padded"><div class="row">
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
                <div class="unlocked-content"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-lock-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 9a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2V9z"/><path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/></svg>&nbsp;
                Locked</div>
                <div class="locked-content"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock-fill" viewBox="0 0 16 16"><path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2z"/></svg>
                Unlocked</div>
                </h3>
                <h3 class="delete" data-toggle="modal" data-target="#deletemodal">Delete?</h3>
            </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6 sp-flex-column fixed-height">
            <div class="list-content">
                <div class="description">This is a description</div>
                <ol id="list-items">
                <?php foreach($lists as $l) { echo '<li class="list-name '.($owner ? 'editable' : '').'" data-id="'.$l['id'].'">'.$l['content'].'</li>'; } ?>
                </ol>
            </div>
            <?php if ($owner): ?>
            <div class="list-options">
                <div class="list-option add"><h6>+</h6></div>
                <div class="list-option remove"><h6>-</h6></div>
            </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6" style="background-color: black;">
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
            $('.selected').length > 0 ? $('.remove').show() : $('.remove').hide();
        });

        $('#lock').click(function() {
            $.post('/sparrow/api/togglelock.php', { id: <?php echo $listId; ?> });
            $(this).toggleClass('locked');
        })
    });
</script>
<?php endif; ?>
</html>