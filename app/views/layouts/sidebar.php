<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="logo-badge"><svg>
                <use href="#i-sprout" />
            </svg></div>
        <span>Sitter Control</span>
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
        <div class="theme-card" id="theme-toggle-card">
            <div class="theme-card-left">
                <div class="theme-card-icon" id="theme-icon-wrap">
                    <svg class="icon-moon"><use href="#i-moon" /></svg>
                    <svg class="icon-sun hidden"><use href="#i-sun" /></svg>
                </div>
                <div class="theme-card-text">
                    <span class="theme-title" id="theme-status-text">Tema Escuro</span>
                    <span class="theme-sub">Modo noturno</span>
                </div>
            </div>
            <label class="theme-switch" for="theme-toggle-input" title="Alternar tema">
                <input type="checkbox" id="theme-toggle-input" aria-label="Ativar tema escuro">
                <span class="theme-slider"></span>
            </label>
        </div>
    </div>
</aside>
