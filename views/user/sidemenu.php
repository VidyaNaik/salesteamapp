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
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/clientcompanylist.php" class="list-group-item">Client Company List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/clientcontactlist.php" class="list-group-item">Client Contact List</a>
    <?php endif; ?>
    <?php if ($_SESSION['role'] == "ADMIN") : ?>
        <a href="admin/configurations.php" class="list-group-item">Configurations</a>
    <?php endif; ?>
</div>