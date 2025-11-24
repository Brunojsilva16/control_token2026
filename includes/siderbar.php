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
            <a href="gerar_codigo" <?php echo $title == 'Controle' ? 'class="active"' : ''; ?>>
                <span class="icon"><i class="far fa-play-circle"></i></span>
                <span class="item">Gerar token</span>
            </a>
        </li>
        <li>
            <a href="consulta" <?php echo $title == 'Consulta' ? 'class="active"' : ''; ?>>
                <span class="icon"><i class="fa fa-database"></i></span>
                <span class="item">Consulta</span>
            </a>
        </li>
        <li>
            <a href="profissionais" <?php echo $title == 'Profissionais' ? 'class="active"' : ''; ?>>
                <span class="icon"><i class="fas fa-user-friends"></i></span>
                <span class="item">Profissionais</span>
            </a>
        </li>
        <li>
            <a href="adm" <?php echo $title == 'Administradores' ? 'class="active"' : ''; ?>>
                <span class="icon"><i class="fas fa-user-shield"></i></span>
                <span class="item">Administradores</span>
            </a>
        </li>

        <li>
            <a href="pesquisa" <?php echo $title == 'Pesquisa' ? 'class="active"' : ''; ?>>
                <span class="icon"><i class="fas fa-chart-line"></i></span>
                <span class="item">Relatórios</span>
            </a>
        </li>

    </ul>
</div>