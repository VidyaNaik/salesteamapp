<div class="list-group" id="side-menu">
    <a href="../home.php" class="list-group-item">Home</a>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="addbdm.php" class="list-group-item">Add BDM</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="addbde.php" class="list-group-item">Add BDE</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN" || $_SESSION['role'] == "BDE") : ?>
        <a href="addclient.php" class="list-group-item">Add Client</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="bdmlist.php" class="list-group-item">BDM List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="bdelist.php" class="list-group-item">BDE List</a>
    <?php endif; ?>
    <a href="../clientlist.php" class="list-group-item">Client List</a>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="addlocation.php" class="list-group-item">Add Location</a>
    <?php endif; ?>
</div>