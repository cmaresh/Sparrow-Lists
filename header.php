<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12 header-col">
                <div class="left"><a href="/sparrow/"><h4>SPARROW</h4></a></div>
                <div class="right">
                <?php if (!empty($_SESSION['user'])): ?>
                    <a href="/sparrow/lists.php"><h6>Lists</h6></a>
                    <a href="/sparrow/logout.php"><h6>Logout</h6></a>
                <?php else: ?>
                    <a href="/sparrow/login.php"><h6>Login</h6></a>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>