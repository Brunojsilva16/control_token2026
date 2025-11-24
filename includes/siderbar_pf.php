<div class="sidebar">
    <div class="profile">
        <!-- <img src="https://1.bp.blogspot.com/-vhmWFWO2r8U/YLjr2A57toI/AAAAAAAACO4/0GBonlEZPmAiQW4uvkCTm5LvlJVd_-l_wCNcBGAsYHQ/s16000/team-1-2.jpg" alt="profile_picture"> -->
        <img src="assets/img/semfoto.png" alt="profile_picture">

        <div>
            <?php include 'includes/login_navuser.php'; ?>
        </div>

        <h3><?php echo $usuario; ?></h3>
        <!-- <p>Recepcionista</p> -->
    </div>

    <ul>
        <li>
            <a href="home" <?php echo $title == 'Home' ? 'class="active"' : ''; ?>>
                <span class="icon"><i class="fas fa-home"></i></span>
                <span class="item">Inicio</span>
            </a>
        </li>
        <li>
            <a href="consulta" <?php echo $title == 'Consulta' ? 'class="active"' : ''; ?>>
                <span class="icon"><i class="fa fa-database"></i></span>
                <span class="item">Consulta</span>
            </a>
        </li>
        <li>
            <a href="pesquisa" <?php echo $title == 'Token' ? 'class="active"' : ''; ?>>
                <span class="icon"><i class="fas fa-chart-line"></i></span>
                <span class="item">Relatórios</span>
            </a>
        </li>

        <!-- <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-cog"></i></span>
                        <span class="item">Settings</span>
                    </a>
        </li> -->
        

    </ul>
</div>