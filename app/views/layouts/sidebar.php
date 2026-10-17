<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="logo-badge"><svg>
                <use href="#i-sprout" />
            </svg></div>
        <span>SitCare</span>
    </div>
    <nav class="nav-group">
        <a href="index.php?pagina=dashboard" class="nav-item <?= ($pagina == 'dashboard') ? 'active' : '' ?>">
            <svg>
                <use href="#i-grid" />
            </svg> Painel
        </a>
        <a href="index.php?pagina=criancas" class="nav-item <?= ($pagina == 'criancas') ? 'active' : '' ?>">
            <svg>
                <use href="#i-smile" />
            </svg> Crianças
        </a>
        <a href="index.php?pagina=responsaveis" class="nav-item <?= ($pagina == 'responsaveis') ? 'active' : '' ?>">
            <svg>
                <use href="#i-users" />
            </svg> Responsáveis
        </a>
        <a href="index.php?pagina=tarefas" class="nav-item <?= ($pagina == 'tarefas') ? 'active' : '' ?>">
            <svg>
                <use href="#i-check-square" />
            </svg> Tarefas
        </a>
        <a href="index.php?pagina=pagamentos" class="nav-item <?= ($pagina == 'pagamentos') ? 'active' : '' ?>">
            <svg>
                <use href="#i-wallet" />
            </svg> Pagamentos
        </a>
        <a href="index.php?pagina=perfil" class="nav-item <?= ($pagina == 'perfil') ? 'active' : '' ?>">
            <svg>
                <use href="#i-user-circle" />
            </svg> Perfil
        </a>
    </nav>
    <div class="sidebar-foot">
        <a href="index.php?acao=logout" class="nav-item" id="btn-logout"><svg>
                <use href="#i-logout" />
            </svg> Sair</a>
    </div>
</aside>