<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">TK Pertiwi Bojongwetan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- QUERY MENU -->
    <?php
	$role      = $this->session->userdata('role');
	$queryMenu = "SELECT * FROM `menu` WHERE `menu`.`role` = '$role'";
	$menu      = $this->db->query($queryMenu)->result_array();
	?>

    <!-- LOOPING MENU -->
    <?php foreach ($menu as $m): ?>
    <?php if ($title == $m['menu']): ?>
    <li class="nav-item active">
        <?php else: ?>
    <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link" href="<?php echo base_url($m['url']); ?>">
            <i class="<?php echo $m['icon']; ?>"></i>
            <span><?php echo $m['menu']; ?></span>
        </a>
    </li>
    <?php endforeach; ?>

    <!-- Divider -->

    <hr class="sidebar-divider">

    <?php if ($role == 'admin') : ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKelas" aria-expanded="true"
            aria-controls="collapseKelas">
            <i class="fas fa-fw fa-chalkboard"></i>
            <span>Data Kelas</span>
        </a>
        <div id="collapseKelas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Daftar Kelas:</h6>
                <?php if (!empty($all_kelas)) : ?>
                <?php foreach ($all_kelas as $kelas_item) : ?>
                <a class="collapse-item"
                    href="<?= base_url('admin/kelas/' . strtolower(str_replace(' ', '-', $kelas_item['nama_kelas']))) ?>">
                    <?= $kelas_item['nama_kelas']; ?>
                </a>
                <?php endforeach; ?>
                <?php else : ?>
                <a class="collapse-item" href="#">Tidak ada data kelas</a>
                <?php endif; ?>
            </div>
        </div>
    </li>
    <?php endif; ?>

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('auth2/logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>