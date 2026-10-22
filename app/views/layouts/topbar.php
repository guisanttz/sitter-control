<header class="topbar">
    <div style="display:flex;align-items:center;gap:14px;">
        <button class="icon-btn menu-toggle" id="menu-toggle" aria-label="Abrir menu"><svg>
                <use href="#i-menu" />
            </svg></button>
        <div class="titles">
            <h1 id="topbar-title">
                <?php
                $titulos = [
                    'dashboard' => 'Painel',
                    'criancas' => 'Crianças',
                    'responsaveis' => 'Responsáveis',
                    'tarefas' => 'Tarefas',
                    'pagamentos' => 'Pagamentos',
                    'perfil' => 'Perfil'
                ];
                echo $titulos[$pagina] ?? 'Painel';
                ?>
            </h1>
            <p id="topbar-sub">
                <?php
                $subs = [
                    'dashboard' => 'Aqui está um resumo do seu dia.',
                    'criancas' => 'Cadastre e acompanhe as crianças sob seus cuidados.',
                    'responsaveis' => 'Contatos e vínculos com as crianças.',
                    'tarefas' => 'Organize o que precisa ser feito, hoje e depois.',
                    'pagamentos' => 'Controle o que já entrou e o que ainda falta receber.',
                    'perfil' => 'Suas informações pessoais e de acesso.'
                ];
                echo $subs[$pagina] ?? 'Aqui está um resumo do seu dia.';
                ?>
            </p>
        </div>
    </div>
    <div class="topbar-right">
        <div class="searchbox"><svg>
                <use href="#i-search" />
            </svg><input placeholder="Buscar..."></div>
        <button class="icon-btn" aria-label="Notificações"><svg>
                <use href="#i-bell" />
            </svg><span class="dot"></span></button>
        <?php
        $iniciaisTopbar = 'CU';
        if (!empty($perfilDados['nome'])) {
            $partesTopbar = preg_split('/\s+/', trim($perfilDados['nome']));
            $iniciaisTopbar = mb_strtoupper(mb_substr($partesTopbar[0], 0, 1));
            if (count($partesTopbar) > 1) {
                $iniciaisTopbar .= mb_strtoupper(mb_substr(end($partesTopbar), 0, 1));
            }
        }
        ?>
        <a href="index.php?pagina=perfil" class="who" style="text-decoration:none;color:inherit;" title="Ver Perfil">
            <div class="avatar"><?= htmlspecialchars($iniciaisTopbar) ?></div>
            <div>
                <div class="name"><?= htmlspecialchars($perfilDados['nome'] ?? 'Cuidadora') ?></div>
                <div class="role">Cuidadora</div>
            </div>
        </a>
    </div>
</header>

</header>