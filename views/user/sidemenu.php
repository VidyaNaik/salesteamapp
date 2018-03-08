<div class="list-group" id="side-menu">
    <a href="home.php" class="list-group-item">Home</a>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/addbdm.php" class="list-group-item">Add BDM</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/addbde.php" class="list-group-item">Add BDE</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN" || $_SESSION['role'] == "BDE") : ?>
        <a href="admin/addclient.php" class="list-group-item">Add Client</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/bdmlist.php" class="list-group-item">BDM List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/bdelist.php" class="list-group-item">BDE List</a>
    <?php endif; ?>
    <a href="clientlist.php" class="list-group-item">Client List</a>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/addlocation.php" class="list-group-item">Add Location</a>
    <?php endif; ?>
</div>